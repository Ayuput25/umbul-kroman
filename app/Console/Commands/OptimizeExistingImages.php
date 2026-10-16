<?php

namespace App\Console\Commands;

use App\Models\Destination;
use App\Models\Gallery;
use App\Models\Post;
use App\Models\SiteSetting;
use App\Models\VillageProfile;
use App\Services\ImageService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Throwable;

class OptimizeExistingImages extends Command
{
    /*
    |--------------------------------------------------------------------------
    | COMMAND SIGNATURE
    |--------------------------------------------------------------------------
    */

    protected $signature = 'images:optimize
                            {--force : Optimasi ulang file WebP yang sudah ada}
                            {--only= : Hanya proses destinations,posts,galleries,profile,settings}
                            {--keep-old : Jangan hapus file gambar lama}';


    /*
    |--------------------------------------------------------------------------
    | COMMAND DESCRIPTION
    |--------------------------------------------------------------------------
    */

    protected $description =
        'Optimasi gambar lama menjadi WebP dan membuat thumbnail Umbul Kroman';


    /*
    |--------------------------------------------------------------------------
    | COUNTERS
    |--------------------------------------------------------------------------
    */

    private int $optimized = 0;

    private int $skipped = 0;

    private int $missing = 0;

    private int $failed = 0;


    /*
    |--------------------------------------------------------------------------
    | CONSTRUCTOR
    |--------------------------------------------------------------------------
    */

    public function __construct(
        private ImageService $imageService
    ) {
        parent::__construct();
    }


    /*
    |--------------------------------------------------------------------------
    | HANDLE
    |--------------------------------------------------------------------------
    */

    public function handle(): int
    {
        $this->newLine();

        $this->info(
            '=============================================='
        );

        $this->info(
            ' UMBUL KROMAN - IMAGE OPTIMIZER'
        );

        $this->info(
            '=============================================='
        );

        $this->newLine();


        /*
        |--------------------------------------------------------------------------
        | CHECK GD
        |--------------------------------------------------------------------------
        */

        if (
            !extension_loaded('gd') ||
            !function_exists('imagewebp')
        ) {
            $this->error(
                'PHP GD / WebP support belum aktif.'
            );

            $this->line(
                'Cek dengan: php -m | findstr /I gd'
            );

            return self::FAILURE;
        }


        /*
        |--------------------------------------------------------------------------
        | VALIDASI OPTION --ONLY
        |--------------------------------------------------------------------------
        */

        $only =
            $this->option('only');

        $allowed = [
            'destinations',
            'posts',
            'galleries',
            'profile',
            'settings',
        ];


        if (
            $only &&
            !in_array(
                $only,
                $allowed,
                true
            )
        ) {
            $this->error(
                'Nilai --only tidak valid.'
            );

            $this->line(
                'Gunakan salah satu: '
                . implode(
                    ', ',
                    $allowed
                )
            );

            return self::FAILURE;
        }


        /*
        |--------------------------------------------------------------------------
        | INFORMASI MODE
        |--------------------------------------------------------------------------
        */

        if (
            $this->option('force')
        ) {
            $this->warn(
                'Mode FORCE aktif.'
            );

            $this->line(
                'File WebP yang sudah ada akan diproses ulang.'
            );

            $this->newLine();
        }


        if (
            $this->option('keep-old')
        ) {
            $this->warn(
                'Mode KEEP OLD aktif.'
            );

            $this->line(
                'File gambar lama tidak akan dihapus.'
            );

            $this->newLine();
        }


        if ($only) {
            $this->info(
                'Hanya memproses: '
                . $only
            );

            $this->newLine();
        }


        /*
        |--------------------------------------------------------------------------
        | DESTINATIONS
        |--------------------------------------------------------------------------
        */

        if (
            !$only ||
            $only === 'destinations'
        ) {
            $this->processDestinations();
        }


        /*
        |--------------------------------------------------------------------------
        | POSTS
        |--------------------------------------------------------------------------
        */

        if (
            !$only ||
            $only === 'posts'
        ) {
            $this->processPosts();
        }


        /*
        |--------------------------------------------------------------------------
        | GALLERIES
        |--------------------------------------------------------------------------
        */

        if (
            !$only ||
            $only === 'galleries'
        ) {
            $this->processGalleries();
        }


        /*
        |--------------------------------------------------------------------------
        | PROFILE
        |--------------------------------------------------------------------------
        */

        if (
            !$only ||
            $only === 'profile'
        ) {
            $this->processProfile();
        }


        /*
        |--------------------------------------------------------------------------
        | SETTINGS
        |--------------------------------------------------------------------------
        */

        if (
            !$only ||
            $only === 'settings'
        ) {
            $this->processSettings();
        }


        /*
        |--------------------------------------------------------------------------
        | RESULT
        |--------------------------------------------------------------------------
        */

        $this->newLine(2);

        $this->info(
            '=============================================='
        );

        $this->info(
            ' HASIL IMAGE OPTIMIZER'
        );

        $this->info(
            '=============================================='
        );


        $this->table(
            [
                'Status',
                'Jumlah',
            ],
            [
                [
                    'Berhasil dioptimasi',
                    $this->optimized,
                ],
                [
                    'Dilewati',
                    $this->skipped,
                ],
                [
                    'File tidak ditemukan',
                    $this->missing,
                ],
                [
                    'Gagal',
                    $this->failed,
                ],
            ]
        );


        if (
            $this->failed > 0
        ) {
            $this->warn(
                'Ada gambar yang gagal diproses.'
            );

            $this->line(
                'Periksa pesan error di atas.'
            );
        } else {
            $this->info(
                'Semua proses selesai.'
            );
        }


        $this->newLine();


        return $this->failed > 0
            ? self::FAILURE
            : self::SUCCESS;
    }


    /*
    |--------------------------------------------------------------------------
    | PROCESS DESTINATIONS
    |--------------------------------------------------------------------------
    */

    private function processDestinations(): void
    {
        $items =
            Destination::query()
                ->whereNotNull('image')
                ->where('image', '!=', '')
                ->get();


        $this->processCollection(
            'Destinasi',
            $items,
            'destinations',
            1600,
            1200,
            82,
            true,
            640,
            420
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PROCESS POSTS
    |--------------------------------------------------------------------------
    */

    private function processPosts(): void
    {
        $items =
            Post::query()
                ->whereNotNull('image')
                ->where('image', '!=', '')
                ->get();


        $this->processCollection(
            'Blog / Artikel',
            $items,
            'posts',
            1600,
            1200,
            82,
            true,
            640,
            420
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PROCESS GALLERIES
    |--------------------------------------------------------------------------
    */

    private function processGalleries(): void
    {
        $items =
            Gallery::query()
                ->whereNotNull('image')
                ->where('image', '!=', '')
                ->get();


        $this->processCollection(
            'Galeri',
            $items,
            'galleries',
            1800,
            1400,
            84,
            true,
            640,
            420
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PROCESS PROFILE
    |--------------------------------------------------------------------------
    */

    private function processProfile(): void
    {
        $profiles =
            VillageProfile::query()
                ->get();


        $this->newLine();

        $this->info(
            '▶ Profil Desa'
        );


        if (
            $profiles->isEmpty()
        ) {
            $this->line(
                '  Tidak ada data profil.'
            );

            return;
        }


        foreach (
            $profiles
            as $profile
        ) {

            /*
            |--------------------------------------------------------------------------
            | LOGO
            |--------------------------------------------------------------------------
            */

            if ($profile->logo) {

                $this->processSingleField(
                    $profile,
                    'logo',
                    'profile',
                    800,
                    800,
                    88,
                    false,
                    0,
                    0,
                    'Logo Profil'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | HERO
            |--------------------------------------------------------------------------
            */

            if ($profile->hero_image) {

                $this->processSingleField(
                    $profile,
                    'hero_image',
                    'profile',
                    1920,
                    1200,
                    84,
                    false,
                    0,
                    0,
                    'Hero Profil'
                );
            }
        }
    }


    /*
    |--------------------------------------------------------------------------
    | PROCESS SETTINGS
    |--------------------------------------------------------------------------
    */

    private function processSettings(): void
    {
        $settings =
            SiteSetting::query()
                ->get();


        $this->newLine();

        $this->info(
            '▶ Settings'
        );


        if (
            $settings->isEmpty()
        ) {
            $this->line(
                '  Tidak ada data settings.'
            );

            return;
        }


        foreach (
            $settings
            as $setting
        ) {

            if (!$setting->favicon) {
                continue;
            }


            $this->processSingleField(
                $setting,
                'favicon',
                'settings',
                512,
                512,
                90,
                false,
                0,
                0,
                'Favicon'
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | PROCESS COLLECTION
    |--------------------------------------------------------------------------
    */

    private function processCollection(
        string $label,
        $items,
        string $directory,
        int $maxWidth,
        int $maxHeight,
        int $quality,
        bool $createThumbnail,
        int $thumbnailWidth,
        int $thumbnailHeight
    ): void {
        $this->newLine();

        $this->info(
            '▶ ' . $label
        );


        if (
            $items->isEmpty()
        ) {
            $this->line(
                '  Tidak ada gambar untuk diproses.'
            );

            return;
        }


        $this->line(
            '  Total: '
            . $items->count()
            . ' gambar'
        );


        $progress =
            $this->output
                ->createProgressBar(
                    $items->count()
                );


        $progress->setFormat(
            '  %current%/%max% [%bar%] %percent:3s%%'
        );


        $progress->start();


        foreach (
            $items
            as $item
        ) {

            try {

                $this->optimizeModelImage(
                    $item,
                    'image',
                    $directory,
                    $maxWidth,
                    $maxHeight,
                    $quality,
                    $createThumbnail,
                    $thumbnailWidth,
                    $thumbnailHeight
                );

            } catch (Throwable $error) {

                $this->failed++;


                $progress->clear();


                $this->error(
                    '  Gagal ID '
                    . $item->id
                    . ': '
                    . $error->getMessage()
                );


                $progress->display();
            }


            $progress->advance();
        }


        $progress->finish();

        $this->newLine();
    }


    /*
    |--------------------------------------------------------------------------
    | PROCESS SINGLE FIELD
    |--------------------------------------------------------------------------
    */

    private function processSingleField(
        $model,
        string $field,
        string $directory,
        int $maxWidth,
        int $maxHeight,
        int $quality,
        bool $createThumbnail,
        int $thumbnailWidth,
        int $thumbnailHeight,
        string $label
    ): void {
        try {

            $result =
                $this->optimizeModelImage(
                    $model,
                    $field,
                    $directory,
                    $maxWidth,
                    $maxHeight,
                    $quality,
                    $createThumbnail,
                    $thumbnailWidth,
                    $thumbnailHeight
                );


            if (
                $result === 'optimized'
            ) {
                $this->line(
                    '  <fg=green>✓</> '
                    . $label
                    . ' berhasil dioptimasi.'
                );
            }


            if (
                $result === 'skipped'
            ) {
                $this->line(
                    '  <fg=yellow>−</> '
                    . $label
                    . ' sudah optimal, dilewati.'
                );
            }


            if (
                $result === 'missing'
            ) {
                $this->line(
                    '  <fg=red>!</> '
                    . $label
                    . ' tidak ditemukan.'
                );
            }

        } catch (Throwable $error) {

            $this->failed++;


            $this->error(
                '  '
                . $label
                . ' gagal: '
                . $error->getMessage()
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | OPTIMIZE MODEL IMAGE
    |--------------------------------------------------------------------------
    */

    private function optimizeModelImage(
        $model,
        string $field,
        string $directory,
        int $maxWidth,
        int $maxHeight,
        int $quality,
        bool $createThumbnail,
        int $thumbnailWidth,
        int $thumbnailHeight
    ): string {
        $oldPath =
            $model->{$field};


        /*
        |--------------------------------------------------------------------------
        | EMPTY PATH
        |--------------------------------------------------------------------------
        */

        if (!$oldPath) {

            $this->skipped++;

            return 'skipped';
        }


        $disk =
            Storage::disk('public');


        /*
        |--------------------------------------------------------------------------
        | FILE NOT FOUND
        |--------------------------------------------------------------------------
        */

        if (
            !$disk->exists(
                $oldPath
            )
        ) {

            $this->missing++;

            return 'missing';
        }


        /*
        |--------------------------------------------------------------------------
        | CHECK CURRENT FILE
        |--------------------------------------------------------------------------
        */

        $alreadyWebp =
            $this->imageService
                ->isWebp(
                    $oldPath
                );


        $thumbnailReady =
            !$createThumbnail
            ||
            $this->imageService
                ->thumbnailExists(
                    $oldPath
                );


        /*
        |--------------------------------------------------------------------------
        | SKIP JIKA SUDAH OPTIMAL
        |--------------------------------------------------------------------------
        */

        if (
            !$this->option('force') &&
            $alreadyWebp &&
            $thumbnailReady
        ) {

            $this->skipped++;

            return 'skipped';
        }


        /*
        |--------------------------------------------------------------------------
        | SOURCE PATH
        |--------------------------------------------------------------------------
        */

        $absoluteSource =
            $disk->path(
                $oldPath
            );


        /*
        |--------------------------------------------------------------------------
        | CREATE NEW IMAGE
        |--------------------------------------------------------------------------
        */

        $newPath =
            $this->imageService
                ->storeFromPath(
                    $absoluteSource,
                    $directory,
                    $maxWidth,
                    $maxHeight,
                    $quality,
                    $createThumbnail,
                    $thumbnailWidth,
                    $thumbnailHeight
                );


        /*
        |--------------------------------------------------------------------------
        | DATABASE UPDATE
        |--------------------------------------------------------------------------
        */

        try {

            $model->{$field} =
                $newPath;

            $model->save();

        } catch (Throwable $error) {

            /*
            |--------------------------------------------------------------------------
            | DATABASE GAGAL → HAPUS FILE BARU
            |--------------------------------------------------------------------------
            */

            $this->imageService
                ->delete(
                    $newPath
                );


            throw $error;
        }


        /*
        |--------------------------------------------------------------------------
        | DELETE OLD IMAGE
        |--------------------------------------------------------------------------
        */

        if (
            !$this->option(
                'keep-old'
            ) &&
            $oldPath !== $newPath
        ) {

            $this->imageService
                ->delete(
                    $oldPath
                );
        }


        $this->optimized++;


        return 'optimized';
    }
}