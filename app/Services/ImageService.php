<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

class ImageService
{
    /*
    |--------------------------------------------------------------------------
    | STORE UPLOADED IMAGE
    |--------------------------------------------------------------------------
    */

    public function store(
        UploadedFile $file,
        string $directory,
        int $maxWidth = 1600,
        int $maxHeight = 1200,
        int $quality = 82,
        bool $createThumbnail = false,
        int $thumbnailWidth = 640,
        int $thumbnailHeight = 420
    ): string {
        $path = $file->getRealPath();

        if (!$path) {
            throw new RuntimeException(
                'File gambar upload tidak dapat dibaca.'
            );
        }

        $mimeType = $file->getMimeType();

        if (!$mimeType) {
            throw new RuntimeException(
                'Tipe file gambar tidak dapat dideteksi.'
            );
        }

        return $this->processImage(
            $path,
            $mimeType,
            $directory,
            $maxWidth,
            $maxHeight,
            $quality,
            $createThumbnail,
            $thumbnailWidth,
            $thumbnailHeight
        );
    }


    /*
    |--------------------------------------------------------------------------
    | STORE EXISTING IMAGE
    |--------------------------------------------------------------------------
    |
    | Digunakan oleh command:
    |
    | php artisan images:optimize
    |
    */

    public function storeFromPath(
        string $absolutePath,
        string $directory,
        int $maxWidth = 1600,
        int $maxHeight = 1200,
        int $quality = 82,
        bool $createThumbnail = false,
        int $thumbnailWidth = 640,
        int $thumbnailHeight = 420
    ): string {
        if (!File::exists($absolutePath)) {
            throw new RuntimeException(
                'File gambar tidak ditemukan: '
                . $absolutePath
            );
        }

        $mimeType = File::mimeType(
            $absolutePath
        );

        if (!$mimeType) {
            throw new RuntimeException(
                'Tipe gambar tidak dapat dideteksi.'
            );
        }

        return $this->processImage(
            $absolutePath,
            $mimeType,
            $directory,
            $maxWidth,
            $maxHeight,
            $quality,
            $createThumbnail,
            $thumbnailWidth,
            $thumbnailHeight
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PROCESS IMAGE
    |--------------------------------------------------------------------------
    */

    private function processImage(
        string $sourcePath,
        string $mimeType,
        string $directory,
        int $maxWidth,
        int $maxHeight,
        int $quality,
        bool $createThumbnail,
        int $thumbnailWidth,
        int $thumbnailHeight
    ): string {
        $this->ensureGdAvailable();

        $image = $this->createImageResource(
            $sourcePath,
            $mimeType
        );

        $image = $this->fixOrientation(
            $image,
            $sourcePath,
            $mimeType
        );

        $originalWidth = imagesx(
            $image
        );

        $originalHeight = imagesy(
            $image
        );

        [$newWidth, $newHeight] =
            $this->calculateResizeDimensions(
                $originalWidth,
                $originalHeight,
                $maxWidth,
                $maxHeight
            );

        $resized = $this->resizeImage(
            $image,
            $newWidth,
            $newHeight
        );

        $filename =
            Str::uuid()->toString()
            . '.webp';

        $directory = trim(
            str_replace(
                '\\',
                '/',
                $directory
            ),
            '/'
        );

        $relativePath =
            $directory
            . '/'
            . $filename;

        $absoluteOutputPath =
            Storage::disk('public')
                ->path($relativePath);

        File::ensureDirectoryExists(
            dirname(
                $absoluteOutputPath
            )
        );

        $saved = imagewebp(
            $resized,
            $absoluteOutputPath,
            $quality
        );

        if (!$saved) {
            imagedestroy($image);
            imagedestroy($resized);

            throw new RuntimeException(
                'Gagal menyimpan gambar WebP.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | THUMBNAIL
        |--------------------------------------------------------------------------
        */

        if ($createThumbnail) {
            try {
                $thumbnailRelativePath =
                    $directory
                    . '/thumbs/'
                    . $filename;

                $thumbnailAbsolutePath =
                    Storage::disk('public')
                        ->path(
                            $thumbnailRelativePath
                        );

                File::ensureDirectoryExists(
                    dirname(
                        $thumbnailAbsolutePath
                    )
                );

                $thumbnail =
                    $this->cropCenter(
                        $resized,
                        $thumbnailWidth,
                        $thumbnailHeight
                    );

                $thumbnailSaved =
                    imagewebp(
                        $thumbnail,
                        $thumbnailAbsolutePath,
                        78
                    );

                imagedestroy(
                    $thumbnail
                );

                if (!$thumbnailSaved) {
                    Storage::disk('public')
                        ->delete(
                            $relativePath
                        );

                    throw new RuntimeException(
                        'Gagal membuat thumbnail.'
                    );
                }

            } catch (\Throwable $error) {
                Storage::disk('public')
                    ->delete(
                        $relativePath
                    );

                throw $error;
            }
        }

        imagedestroy($image);
        imagedestroy($resized);

        return $relativePath;
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE IMAGE
    |--------------------------------------------------------------------------
    */

    public function delete(
        ?string $path
    ): void {
        if (!$path) {
            return;
        }

        $disk =
            Storage::disk('public');

        if (
            $disk->exists($path)
        ) {
            $disk->delete(
                $path
            );
        }

        $thumbnail =
            $this->thumbnailPath(
                $path
            );

        if (
            $thumbnail &&
            $disk->exists($thumbnail)
        ) {
            $disk->delete(
                $thumbnail
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | THUMBNAIL PATH
    |--------------------------------------------------------------------------
    */

    public function thumbnailPath(
        ?string $path
    ): ?string {
        if (!$path) {
            return null;
        }

        $normalizedPath =
            str_replace(
                '\\',
                '/',
                $path
            );

        $directory =
            dirname(
                $normalizedPath
            );

        if (
            $directory === '.' ||
            $directory === ''
        ) {
            return null;
        }

        return
            $directory
            . '/thumbs/'
            . basename(
                $normalizedPath
            );
    }


    /*
    |--------------------------------------------------------------------------
    | THUMBNAIL EXISTS
    |--------------------------------------------------------------------------
    */

    public function thumbnailExists(
        ?string $path
    ): bool {
        if (!$path) {
            return false;
        }

        $thumbnail =
            $this->thumbnailPath(
                $path
            );

        if (!$thumbnail) {
            return false;
        }

        return Storage::disk('public')
            ->exists(
                $thumbnail
            );
    }


    /*
    |--------------------------------------------------------------------------
    | CHECK WEBP
    |--------------------------------------------------------------------------
    |
    | Ini method yang sebelumnya belum ada.
    |
    */

    public function isWebp(
        ?string $path
    ): bool {
        if (!$path) {
            return false;
        }

        return strtolower(
            pathinfo(
                $path,
                PATHINFO_EXTENSION
            )
        ) === 'webp';
    }


    /*
    |--------------------------------------------------------------------------
    | GD CHECK
    |--------------------------------------------------------------------------
    */

    private function ensureGdAvailable(): void
    {
        if (
            !extension_loaded('gd')
        ) {
            throw new RuntimeException(
                'PHP GD extension belum aktif.'
            );
        }

        if (
            !function_exists(
                'imagewebp'
            )
        ) {
            throw new RuntimeException(
                'PHP GD tidak mendukung WebP.'
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE IMAGE RESOURCE
    |--------------------------------------------------------------------------
    */

    private function createImageResource(
        string $path,
        string $mimeType
    ) {
        $image = match ($mimeType) {
            'image/jpeg',
            'image/jpg' =>
                @imagecreatefromjpeg(
                    $path
                ),

            'image/png' =>
                @imagecreatefrompng(
                    $path
                ),

            'image/webp' =>
                @imagecreatefromwebp(
                    $path
                ),

            default =>
                false,
        };

        if (!$image) {
            throw new RuntimeException(
                'Format gambar tidak dapat diproses: '
                . $mimeType
            );
        }

        return $image;
    }


    /*
    |--------------------------------------------------------------------------
    | JPEG ORIENTATION
    |--------------------------------------------------------------------------
    */

    private function fixOrientation(
        $image,
        string $path,
        string $mimeType
    ) {
        if (
            !in_array(
                $mimeType,
                [
                    'image/jpeg',
                    'image/jpg',
                ],
                true
            )
        ) {
            return $image;
        }

        if (
            !function_exists(
                'exif_read_data'
            )
        ) {
            return $image;
        }

        try {
            $exif =
                @exif_read_data(
                    $path
                );
        } catch (\Throwable) {
            return $image;
        }

        $orientation =
            $exif['Orientation']
            ?? null;

        if (!$orientation) {
            return $image;
        }

        $rotated = match (
            (int) $orientation
        ) {
            3 =>
                imagerotate(
                    $image,
                    180,
                    0
                ),

            6 =>
                imagerotate(
                    $image,
                    -90,
                    0
                ),

            8 =>
                imagerotate(
                    $image,
                    90,
                    0
                ),

            default =>
                $image,
        };

        if (
            $rotated !== false &&
            $rotated !== $image
        ) {
            imagedestroy(
                $image
            );

            return $rotated;
        }

        return $image;
    }


    /*
    |--------------------------------------------------------------------------
    | CALCULATE RESIZE
    |--------------------------------------------------------------------------
    */

    private function calculateResizeDimensions(
        int $width,
        int $height,
        int $maxWidth,
        int $maxHeight
    ): array {
        if (
            $width <= $maxWidth &&
            $height <= $maxHeight
        ) {
            return [
                $width,
                $height,
            ];
        }

        $ratio = min(
            $maxWidth / $width,
            $maxHeight / $height
        );

        return [
            max(
                1,
                (int) round(
                    $width * $ratio
                )
            ),

            max(
                1,
                (int) round(
                    $height * $ratio
                )
            ),
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | RESIZE IMAGE
    |--------------------------------------------------------------------------
    */

    private function resizeImage(
        $source,
        int $width,
        int $height
    ) {
        $destination =
            imagecreatetruecolor(
                $width,
                $height
            );

        if (!$destination) {
            throw new RuntimeException(
                'Gagal membuat canvas gambar.'
            );
        }

        $this->prepareTransparency(
            $destination,
            $width,
            $height
        );

        imagecopyresampled(
            $destination,
            $source,
            0,
            0,
            0,
            0,
            $width,
            $height,
            imagesx($source),
            imagesy($source)
        );

        return $destination;
    }


    /*
    |--------------------------------------------------------------------------
    | TRANSPARENCY
    |--------------------------------------------------------------------------
    */

    private function prepareTransparency(
        $image,
        int $width,
        int $height
    ): void {
        imagealphablending(
            $image,
            false
        );

        imagesavealpha(
            $image,
            true
        );

        $transparent =
            imagecolorallocatealpha(
                $image,
                0,
                0,
                0,
                127
            );

        imagefilledrectangle(
            $image,
            0,
            0,
            $width,
            $height,
            $transparent
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CENTER CROP THUMBNAIL
    |--------------------------------------------------------------------------
    */

    private function cropCenter(
        $source,
        int $targetWidth,
        int $targetHeight
    ) {
        $sourceWidth =
            imagesx($source);

        $sourceHeight =
            imagesy($source);

        $targetRatio =
            $targetWidth
            / $targetHeight;

        $sourceRatio =
            $sourceWidth
            / $sourceHeight;


        if (
            $sourceRatio >
            $targetRatio
        ) {
            $cropHeight =
                $sourceHeight;

            $cropWidth =
                (int) round(
                    $sourceHeight
                    * $targetRatio
                );

            $sourceX =
                (int) round(
                    (
                        $sourceWidth
                        - $cropWidth
                    ) / 2
                );

            $sourceY = 0;

        } else {
            $cropWidth =
                $sourceWidth;

            $cropHeight =
                (int) round(
                    $sourceWidth
                    / $targetRatio
                );

            $sourceX = 0;

            $sourceY =
                (int) round(
                    (
                        $sourceHeight
                        - $cropHeight
                    ) / 2
                );
        }


        $thumbnail =
            imagecreatetruecolor(
                $targetWidth,
                $targetHeight
            );

        if (!$thumbnail) {
            throw new RuntimeException(
                'Gagal membuat canvas thumbnail.'
            );
        }

        $this->prepareTransparency(
            $thumbnail,
            $targetWidth,
            $targetHeight
        );

        imagecopyresampled(
            $thumbnail,
            $source,
            0,
            0,
            $sourceX,
            $sourceY,
            $targetWidth,
            $targetHeight,
            $cropWidth,
            $cropHeight
        );

        return $thumbnail;
    }
}