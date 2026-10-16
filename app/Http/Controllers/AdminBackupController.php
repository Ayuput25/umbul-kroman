<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Gallery;
use App\Models\Post;
use App\Models\SiteSetting;
use App\Models\VillageProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Throwable;
use ZipArchive;

class AdminBackupController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | FOLDER MEDIA YANG DIKELOLA
    |--------------------------------------------------------------------------
    */

    private array $managedMediaDirectories = [
        'destinations',
        'posts',
        'galleries',
        'profile',
        'settings',
    ];


    /*
    |--------------------------------------------------------------------------
    | HALAMAN BACKUP
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $statistics = [
            'destinations' => Destination::count(),
            'posts' => Post::count(),
            'galleries' => Gallery::count(),
            'profiles' => VillageProfile::count(),
            'settings' => SiteSetting::count(),
        ];

        $mediaStatistics = $this->getMediaStatistics();

        $zipAvailable = class_exists(ZipArchive::class);

        return view(
            'admin.backup.index',
            compact(
                'statistics',
                'mediaStatistics',
                'zipAvailable'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | EXPORT JSON
    |--------------------------------------------------------------------------
    */

    public function export()
    {
        $backup = $this->buildBackupData();

        $json = json_encode(
            $backup,
            JSON_PRETTY_PRINT |
            JSON_UNESCAPED_SLASHES |
            JSON_UNESCAPED_UNICODE
        );

        if ($json === false) {
            return back()->with(
                'error',
                'Gagal membuat file backup JSON.'
            );
        }

        $filename =
            'umbul-kroman-database-'
            . now()->format('Y-m-d-His')
            . '.json';

        return response(
            $json,
            200,
            [
                'Content-Type' =>
                    'application/json; charset=UTF-8',

                'Content-Disposition' =>
                    'attachment; filename="'
                    . $filename
                    . '"',

                'Cache-Control' =>
                    'no-store, no-cache, must-revalidate',
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | EXPORT FULL BACKUP ZIP
    |--------------------------------------------------------------------------
    */

    public function exportFull()
    {
        if (!class_exists(ZipArchive::class)) {
            return back()->with(
                'error',
                'PHP ZIP extension belum aktif.'
            );
        }

        $temporaryDirectory =
            storage_path(
                'app/backup-temp/'
                . Str::uuid()
            );

        File::ensureDirectoryExists(
            $temporaryDirectory
        );

        $filename =
            'umbul-kroman-full-backup-'
            . now()->format('Y-m-d-His')
            . '.zip';

        $zipPath =
            $temporaryDirectory
            . DIRECTORY_SEPARATOR
            . $filename;

        try {
            $backup = $this->buildBackupData();

            $json = json_encode(
                $backup,
                JSON_PRETTY_PRINT |
                JSON_UNESCAPED_SLASHES |
                JSON_UNESCAPED_UNICODE
            );

            if ($json === false) {
                throw new \RuntimeException(
                    'Gagal membuat backup JSON.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | BUAT ZIP
            |--------------------------------------------------------------------------
            */

            $zip = new ZipArchive();

            $result = $zip->open(
                $zipPath,
                ZipArchive::CREATE |
                ZipArchive::OVERWRITE
            );

            if ($result !== true) {
                throw new \RuntimeException(
                    'File ZIP tidak dapat dibuat.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | BACKUP.JSON
            |--------------------------------------------------------------------------
            */

            $zip->addFromString(
                'backup.json',
                $json
            );


            /*
            |--------------------------------------------------------------------------
            | INFO BACKUP
            |--------------------------------------------------------------------------
            */

            $readme = implode(
                PHP_EOL,
                [
                    'UMBUL KROMAN FULL BACKUP',
                    '========================',
                    '',
                    'Generated: '
                        . now()->format(
                            'Y-m-d H:i:s'
                        ),
                    '',
                    'Isi backup:',
                    '- Database website',
                    '- Destinasi',
                    '- Blog / berita',
                    '- Galeri',
                    '- Profil Desa',
                    '- Site Settings',
                    '- Media upload',
                    '',
                    'Password admin tidak disimpan.',
                ]
            );

            $zip->addFromString(
                'README.txt',
                $readme
            );


            /*
            |--------------------------------------------------------------------------
            | TAMBAHKAN MEDIA
            |--------------------------------------------------------------------------
            */

            $publicStoragePath =
                storage_path('app/public');

            foreach (
                $this->managedMediaDirectories
                as $directory
            ) {
                $sourceDirectory =
                    $publicStoragePath
                    . DIRECTORY_SEPARATOR
                    . $directory;

                if (
                    !File::isDirectory(
                        $sourceDirectory
                    )
                ) {
                    continue;
                }

                $this->addDirectoryToZip(
                    $zip,
                    $sourceDirectory,
                    'media/' . $directory
                );
            }


            $zip->close();


            if (!File::exists($zipPath)) {
                throw new \RuntimeException(
                    'File backup ZIP gagal dibuat.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | DOWNLOAD + HAPUS FILE TEMP
            |--------------------------------------------------------------------------
            */

            return response()
                ->download(
                    $zipPath,
                    $filename,
                    [
                        'Content-Type' =>
                            'application/zip',
                    ]
                )
                ->deleteFileAfterSend(true);

        } catch (Throwable $error) {

            report($error);

            if (File::exists($zipPath)) {
                File::delete($zipPath);
            }

            return back()->with(
                'error',
                'Full backup gagal dibuat: '
                . $error->getMessage()
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | IMPORT JSON
    |--------------------------------------------------------------------------
    */

    public function import(Request $request)
    {
        $request->validate([
            'backup_file' => [
                'required',
                'file',
                'max:10240',
            ],

            'current_password' => [
                'required',
                'string',
            ],

            'confirmation' => [
                'accepted',
            ],
        ]);


        $user = Auth::user();

        if (
            !Hash::check(
                $request->current_password,
                $user->password
            )
        ) {
            return back()->withErrors([
                'current_password' =>
                    'Password admin saat ini tidak sesuai.',
            ]);
        }


        try {
            $contents = file_get_contents(
                $request
                    ->file('backup_file')
                    ->getRealPath()
            );

            if ($contents === false) {
                throw new \RuntimeException(
                    'File backup tidak dapat dibaca.'
                );
            }

            $backup = json_decode(
                $contents,
                true
            );

            if (
                json_last_error()
                !== JSON_ERROR_NONE
            ) {
                throw new \RuntimeException(
                    'File bukan JSON yang valid.'
                );
            }


            $this->validateBackupData(
                $backup
            );


            DB::transaction(
                function () use (
                    $backup,
                    $user
                ) {
                    $this->restoreDatabaseData(
                        $backup,
                        $user
                    );
                }
            );

        } catch (Throwable $error) {

            report($error);

            return back()->with(
                'error',
                'Restore JSON gagal: '
                . $error->getMessage()
            );
        }


        return redirect()
            ->route('admin.backup.index')
            ->with(
                'success',
                'Backup database JSON berhasil direstore.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | IMPORT FULL BACKUP ZIP
    |--------------------------------------------------------------------------
    */

    public function importFull(
        Request $request
    ) {
        if (!class_exists(ZipArchive::class)) {
            return back()->with(
                'error',
                'PHP ZIP extension belum aktif.'
            );
        }


        $request->validate([
            'backup_zip' => [
                'required',
                'file',
                'max:102400',
            ],

            'current_password' => [
                'required',
                'string',
            ],

            'confirmation' => [
                'accepted',
            ],
        ]);


        $user = Auth::user();


        /*
        |--------------------------------------------------------------------------
        | VERIFIKASI PASSWORD
        |--------------------------------------------------------------------------
        */

        if (
            !Hash::check(
                $request->current_password,
                $user->password
            )
        ) {
            return back()->withErrors([
                'current_password' =>
                    'Password admin saat ini tidak sesuai.',
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | DIREKTORI TEMPORARY
        |--------------------------------------------------------------------------
        */

        $workDirectory =
            storage_path(
                'app/restore-temp/'
                . Str::uuid()
            );

        $extractDirectory =
            $workDirectory
            . DIRECTORY_SEPARATOR
            . 'extracted';

        $rollbackDirectory =
            $workDirectory
            . DIRECTORY_SEPARATOR
            . 'rollback-media';

        File::ensureDirectoryExists(
            $extractDirectory
        );

        File::ensureDirectoryExists(
            $rollbackDirectory
        );


        $zip = new ZipArchive();

        try {

            /*
            |--------------------------------------------------------------------------
            | BUKA ZIP
            |--------------------------------------------------------------------------
            */

            $zipPath =
                $request
                    ->file('backup_zip')
                    ->getRealPath();

            $result =
                $zip->open($zipPath);

            if ($result !== true) {
                throw new \RuntimeException(
                    'File ZIP tidak dapat dibuka.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | VALIDASI ISI ZIP
            |--------------------------------------------------------------------------
            */

            $this->validateZipEntries(
                $zip
            );


            if (
                $zip->locateName(
                    'backup.json'
                ) === false
            ) {
                throw new \RuntimeException(
                    'backup.json tidak ditemukan di dalam ZIP.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | EXTRACT KE TEMP
            |--------------------------------------------------------------------------
            */

            if (
                !$zip->extractTo(
                    $extractDirectory
                )
            ) {
                throw new \RuntimeException(
                    'Backup ZIP gagal diekstrak.'
                );
            }

            $zip->close();


            /*
            |--------------------------------------------------------------------------
            | BACA BACKUP JSON
            |--------------------------------------------------------------------------
            */

            $backupJsonPath =
                $extractDirectory
                . DIRECTORY_SEPARATOR
                . 'backup.json';

            if (
                !File::exists(
                    $backupJsonPath
                )
            ) {
                throw new \RuntimeException(
                    'File backup.json tidak ditemukan.'
                );
            }


            $backup =
                json_decode(
                    File::get(
                        $backupJsonPath
                    ),
                    true
                );


            if (
                json_last_error()
                !== JSON_ERROR_NONE
            ) {
                throw new \RuntimeException(
                    'backup.json tidak valid.'
                );
            }


            $this->validateBackupData(
                $backup
            );


            /*
            |--------------------------------------------------------------------------
            | VALIDASI MEDIA SEBELUM MENYENTUH DATA AKTIF
            |--------------------------------------------------------------------------
            */

            $extractedMedia =
                $extractDirectory
                . DIRECTORY_SEPARATOR
                . 'media';

            if (
                File::isDirectory(
                    $extractedMedia
                )
            ) {
                $this->validateExtractedMedia(
                    $extractedMedia
                );
            }


            /*
            |--------------------------------------------------------------------------
            | BUAT ROLLBACK MEDIA SAAT INI
            |--------------------------------------------------------------------------
            */

            $this->backupCurrentMedia(
                $rollbackDirectory
            );


            /*
            |--------------------------------------------------------------------------
            | RESTORE
            |--------------------------------------------------------------------------
            */

            try {

                DB::beginTransaction();


                /*
                |--------------------------------------------------------------------------
                | RESTORE DATABASE
                |--------------------------------------------------------------------------
                */

                $this->restoreDatabaseData(
                    $backup,
                    $user
                );


                /*
                |--------------------------------------------------------------------------
                | RESTORE FILE MEDIA
                |--------------------------------------------------------------------------
                */

                $this->restoreMedia(
                    $extractedMedia
                );


                DB::commit();

            } catch (Throwable $restoreError) {

                DB::rollBack();


                /*
                |--------------------------------------------------------------------------
                | ROLLBACK MEDIA
                |--------------------------------------------------------------------------
                */

                $this->restoreRollbackMedia(
                    $rollbackDirectory
                );


                throw $restoreError;
            }


        } catch (Throwable $error) {

            if ($zip->status === ZipArchive::ER_OK) {
                $zip->close();
            }

            report($error);

            File::deleteDirectory(
                $workDirectory
            );

            return back()->with(
                'error',
                'Full restore gagal: '
                . $error->getMessage()
            );
        }


        File::deleteDirectory(
            $workDirectory
        );


        return redirect()
            ->route('admin.backup.index')
            ->with(
                'success',
                'Full backup berhasil direstore. Database dan seluruh media telah dipulihkan.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | BUAT STRUKTUR BACKUP DATABASE
    |--------------------------------------------------------------------------
    */

    private function buildBackupData(): array
    {
        $user = Auth::user();

        return [
            'format' =>
                'umbul-kroman-backup',

            'version' =>
                2,

            'backup_type' =>
                'database-and-media-compatible',

            'generated_at' =>
                now()->toIso8601String(),

            'application' => [
                'name' =>
                    config('app.name'),

                'environment' =>
                    app()->environment(),

                'laravel_version' =>
                    app()->version(),
            ],

            'data' => [

                'village_profiles' =>
                    VillageProfile::query()
                        ->orderBy('id')
                        ->get()
                        ->toArray(),

                'destinations' =>
                    Destination::query()
                        ->orderBy('id')
                        ->get()
                        ->toArray(),

                'posts' =>
                    Post::query()
                        ->orderBy('id')
                        ->get()
                        ->toArray(),

                'galleries' =>
                    Gallery::query()
                        ->orderBy('id')
                        ->get()
                        ->toArray(),

                'site_settings' =>
                    SiteSetting::query()
                        ->orderBy('id')
                        ->get()
                        ->toArray(),

                /*
                |--------------------------------------------------------------------------
                | PASSWORD TIDAK PERNAH DIBACKUP
                |--------------------------------------------------------------------------
                */

                'admin_account' => [
                    'name' =>
                        $user->name,

                    'email' =>
                        $user->email,
                ],
            ],
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | VALIDASI BACKUP JSON
    |--------------------------------------------------------------------------
    */

    private function validateBackupData(
        array $backup
    ): void {
        $validator =
            Validator::make(
                $backup,
                [
                    'format' => [
                        'required',
                        'string',
                        'in:umbul-kroman-backup',
                    ],

                    'version' => [
                        'required',
                        'integer',
                        'min:1',
                        'max:2',
                    ],

                    'data' => [
                        'required',
                        'array',
                    ],

                    'data.village_profiles' => [
                        'required',
                        'array',
                    ],

                    'data.destinations' => [
                        'required',
                        'array',
                    ],

                    'data.posts' => [
                        'required',
                        'array',
                    ],

                    'data.galleries' => [
                        'required',
                        'array',
                    ],

                    'data.site_settings' => [
                        'required',
                        'array',
                    ],

                    'data.admin_account' => [
                        'nullable',
                        'array',
                    ],
                ]
            );


        if ($validator->fails()) {
            throw new \RuntimeException(
                'Format backup tidak valid atau tidak didukung.'
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | RESTORE DATABASE
    |--------------------------------------------------------------------------
    */

    private function restoreDatabaseData(
        array $backup,
        $user
    ): void {
        $data = $backup['data'];


        /*
        |--------------------------------------------------------------------------
        | PROFIL DESA
        |--------------------------------------------------------------------------
        */

        DB::table(
            'village_profiles'
        )->delete();

        foreach (
            $data['village_profiles']
            as $row
        ) {
            DB::table(
                'village_profiles'
            )->insert(
                $this->filterColumns(
                    $row,
                    [
                        'id',
                        'name',
                        'tagline',
                        'description',
                        'history',
                        'vision',
                        'mission',
                        'address',
                        'phone',
                        'email',
                        'google_maps_embed',
                        'logo',
                        'hero_image',
                        'created_at',
                        'updated_at',
                    ]
                )
            );
        }


        /*
        |--------------------------------------------------------------------------
        | DESTINASI
        |--------------------------------------------------------------------------
        */

        DB::table(
            'destinations'
        )->delete();

        foreach (
            $data['destinations']
            as $row
        ) {
            DB::table(
                'destinations'
            )->insert(
                $this->filterColumns(
                    $row,
                    [
                        'id',
                        'name',
                        'slug',
                        'description',
                        'address',
                        'google_maps_url',
                        'opening_hours',
                        'ticket_price',
                        'facilities',
                        'image',
                        'is_active',
                        'created_at',
                        'updated_at',
                    ]
                )
            );
        }


        /*
        |--------------------------------------------------------------------------
        | POSTS
        |--------------------------------------------------------------------------
        */

        DB::table(
            'posts'
        )->delete();

        foreach (
            $data['posts']
            as $row
        ) {
            DB::table(
                'posts'
            )->insert(
                $this->filterColumns(
                    $row,
                    [
                        'id',
                        'title',
                        'slug',
                        'excerpt',
                        'content',
                        'image',
                        'is_published',
                        'published_at',
                        'created_at',
                        'updated_at',
                    ]
                )
            );
        }


        /*
        |--------------------------------------------------------------------------
        | GALERI
        |--------------------------------------------------------------------------
        */

        DB::table(
            'galleries'
        )->delete();

        foreach (
            $data['galleries']
            as $row
        ) {
            DB::table(
                'galleries'
            )->insert(
                $this->filterColumns(
                    $row,
                    [
                        'id',
                        'title',
                        'description',
                        'image',
                        'is_active',
                        'sort_order',
                        'created_at',
                        'updated_at',
                    ]
                )
            );
        }


        /*
        |--------------------------------------------------------------------------
        | SITE SETTINGS
        |--------------------------------------------------------------------------
        */

        DB::table(
            'site_settings'
        )->delete();

        foreach (
            $data['site_settings']
            as $row
        ) {
            DB::table(
                'site_settings'
            )->insert(
                $this->filterColumns(
                    $row,
                    [
                        'id',
                        'site_title',
                        'meta_description',
                        'meta_keywords',
                        'favicon',
                        'whatsapp_number',
                        'whatsapp_message',
                        'show_whatsapp',
                        'instagram_url',
                        'facebook_url',
                        'tiktok_url',
                        'youtube_url',
                        'footer_text',
                        'created_at',
                        'updated_at',
                    ]
                )
            );
        }


        /*
        |--------------------------------------------------------------------------
        | ADMIN
        |--------------------------------------------------------------------------
        |
        | Password akun aktif TIDAK disentuh.
        |
        */

        $admin =
            $data['admin_account']
            ?? null;


        if ($admin) {

            $name =
                trim(
                    (string)
                    (
                        $admin['name']
                        ?? ''
                    )
                );

            $email =
                trim(
                    (string)
                    (
                        $admin['email']
                        ?? ''
                    )
                );


            if ($name !== '') {
                $user->name = $name;
            }


            if (
                $email !== '' &&
                filter_var(
                    $email,
                    FILTER_VALIDATE_EMAIL
                )
            ) {
                $exists =
                    DB::table('users')
                        ->where(
                            'email',
                            $email
                        )
                        ->where(
                            'id',
                            '!=',
                            $user->id
                        )
                        ->exists();

                if (!$exists) {
                    $user->email =
                        $email;
                }
            }


            $user->save();
        }
    }


    /*
    |--------------------------------------------------------------------------
    | TAMBAHKAN DIREKTORI KE ZIP
    |--------------------------------------------------------------------------
    */

    private function addDirectoryToZip(
        ZipArchive $zip,
        string $sourceDirectory,
        string $zipDirectory
    ): void {
        $zip->addEmptyDir(
            str_replace(
                '\\',
                '/',
                $zipDirectory
            )
        );


        $files =
            File::allFiles(
                $sourceDirectory
            );


        foreach ($files as $file) {

            $absolutePath =
                $file->getRealPath();

            if (!$absolutePath) {
                continue;
            }


            $relativePath =
                substr(
                    $absolutePath,
                    strlen(
                        realpath(
                            $sourceDirectory
                        )
                    ) + 1
                );


            $relativePath =
                str_replace(
                    '\\',
                    '/',
                    $relativePath
                );


            $zipPath =
                trim(
                    str_replace(
                        '\\',
                        '/',
                        $zipDirectory
                    ),
                    '/'
                )
                . '/'
                . $relativePath;


            $zip->addFile(
                $absolutePath,
                $zipPath
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | ANTI ZIP SLIP
    |--------------------------------------------------------------------------
    */

    private function validateZipEntries(
        ZipArchive $zip
    ): void {
        for (
            $index = 0;
            $index < $zip->numFiles;
            $index++
        ) {
            $name =
                $zip->getNameIndex(
                    $index
                );


            if ($name === false) {
                throw new \RuntimeException(
                    'ZIP mengandung entry yang tidak valid.'
                );
            }


            $normalized =
                str_replace(
                    '\\',
                    '/',
                    $name
                );


            if (
                str_contains(
                    $normalized,
                    '../'
                ) ||
                str_starts_with(
                    $normalized,
                    '/'
                ) ||
                preg_match(
                    '/^[A-Za-z]:\//',
                    $normalized
                )
            ) {
                throw new \RuntimeException(
                    'ZIP mengandung path yang tidak aman.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | HANYA IZINKAN FILE BACKUP KITA
            |--------------------------------------------------------------------------
            */

            if (
                $normalized !== 'backup.json' &&
                $normalized !== 'README.txt' &&
                !str_starts_with(
                    $normalized,
                    'media/'
                )
            ) {
                throw new \RuntimeException(
                    'ZIP mengandung file yang tidak dikenal: '
                    . $normalized
                );
            }
        }
    }


    /*
    |--------------------------------------------------------------------------
    | VALIDASI MEDIA
    |--------------------------------------------------------------------------
    */

    private function validateExtractedMedia(
        string $mediaDirectory
    ): void {
        $allowedExtensions = [
            'jpg',
            'jpeg',
            'png',
            'webp',
            'gif',
            'svg',
        ];


        foreach (
            File::allFiles(
                $mediaDirectory
            )
            as $file
        ) {
            $extension =
                strtolower(
                    $file->getExtension()
                );


            if (
                !in_array(
                    $extension,
                    $allowedExtensions,
                    true
                )
            ) {
                throw new \RuntimeException(
                    'Media backup mengandung tipe file yang tidak diizinkan: '
                    . $file->getFilename()
                );
            }


            /*
            |--------------------------------------------------------------------------
            | BATAS 20 MB PER FILE
            |--------------------------------------------------------------------------
            */

            if (
                $file->getSize()
                > 20 * 1024 * 1024
            ) {
                throw new \RuntimeException(
                    'Terdapat file media yang terlalu besar.'
                );
            }
        }
    }


    /*
    |--------------------------------------------------------------------------
    | BACKUP MEDIA SEBELUM RESTORE
    |--------------------------------------------------------------------------
    */

    private function backupCurrentMedia(
        string $rollbackDirectory
    ): void {
        $publicStorage =
            storage_path(
                'app/public'
            );


        foreach (
            $this->managedMediaDirectories
            as $directory
        ) {
            $source =
                $publicStorage
                . DIRECTORY_SEPARATOR
                . $directory;

            $destination =
                $rollbackDirectory
                . DIRECTORY_SEPARATOR
                . $directory;


            if (
                File::isDirectory(
                    $source
                )
            ) {
                File::copyDirectory(
                    $source,
                    $destination
                );
            }
        }
    }


    /*
    |--------------------------------------------------------------------------
    | RESTORE MEDIA
    |--------------------------------------------------------------------------
    */

    private function restoreMedia(
        string $extractedMediaDirectory
    ): void {
        $publicStorage =
            storage_path(
                'app/public'
            );


        File::ensureDirectoryExists(
            $publicStorage
        );


        foreach (
            $this->managedMediaDirectories
            as $directory
        ) {
            $destination =
                $publicStorage
                . DIRECTORY_SEPARATOR
                . $directory;


            if (
                File::isDirectory(
                    $destination
                )
            ) {
                File::deleteDirectory(
                    $destination
                );
            }


            $source =
                $extractedMediaDirectory
                . DIRECTORY_SEPARATOR
                . $directory;


            if (
                File::isDirectory(
                    $source
                )
            ) {
                $copied =
                    File::copyDirectory(
                        $source,
                        $destination
                    );

                if (!$copied) {
                    throw new \RuntimeException(
                        'Gagal merestore media folder '
                        . $directory
                        . '.'
                    );
                }
            }
        }
    }


    /*
    |--------------------------------------------------------------------------
    | RESTORE ROLLBACK MEDIA JIKA GAGAL
    |--------------------------------------------------------------------------
    */

    private function restoreRollbackMedia(
        string $rollbackDirectory
    ): void {
        $publicStorage =
            storage_path(
                'app/public'
            );


        foreach (
            $this->managedMediaDirectories
            as $directory
        ) {
            $destination =
                $publicStorage
                . DIRECTORY_SEPARATOR
                . $directory;


            if (
                File::isDirectory(
                    $destination
                )
            ) {
                File::deleteDirectory(
                    $destination
                );
            }


            $source =
                $rollbackDirectory
                . DIRECTORY_SEPARATOR
                . $directory;


            if (
                File::isDirectory(
                    $source
                )
            ) {
                File::copyDirectory(
                    $source,
                    $destination
                );
            }
        }
    }


    /*
    |--------------------------------------------------------------------------
    | MEDIA STATISTICS
    |--------------------------------------------------------------------------
    */

    private function getMediaStatistics(): array
    {
        $publicStorage =
            storage_path(
                'app/public'
            );

        $fileCount = 0;
        $totalBytes = 0;


        foreach (
            $this->managedMediaDirectories
            as $directory
        ) {
            $path =
                $publicStorage
                . DIRECTORY_SEPARATOR
                . $directory;


            if (
                !File::isDirectory(
                    $path
                )
            ) {
                continue;
            }


            foreach (
                File::allFiles($path)
                as $file
            ) {
                $fileCount++;

                $totalBytes +=
                    $file->getSize();
            }
        }


        return [
            'files' =>
                $fileCount,

            'bytes' =>
                $totalBytes,

            'formatted_size' =>
                $this->formatBytes(
                    $totalBytes
                ),
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | FORMAT BYTES
    |--------------------------------------------------------------------------
    */

    private function formatBytes(
        int $bytes
    ): string {
        if ($bytes <= 0) {
            return '0 B';
        }


        $units = [
            'B',
            'KB',
            'MB',
            'GB',
            'TB',
        ];


        $power =
            min(
                floor(
                    log(
                        $bytes,
                        1024
                    )
                ),
                count($units) - 1
            );


        $value =
            $bytes /
            (1024 ** $power);


        return number_format(
            $value,
            $power > 0 ? 2 : 0,
            ',',
            '.'
        )
        . ' '
        . $units[$power];
    }


    /*
    |--------------------------------------------------------------------------
    | FILTER FIELD DATABASE
    |--------------------------------------------------------------------------
    */

    private function filterColumns(
        array $row,
        array $allowedColumns
    ): array {
        return collect($row)
            ->only($allowedColumns)
            ->toArray();
    }
}