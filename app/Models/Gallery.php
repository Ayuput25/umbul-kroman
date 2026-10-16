<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];


    /*
    |--------------------------------------------------------------------------
    | THUMBNAIL
    |--------------------------------------------------------------------------
    |
    | Thumbnail baru:
    | galleries/thumbs/xxxx.webp
    |
    | Kalau thumbnail belum tersedia, pakai gambar utama.
    |
    */

    public function getThumbnailAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }

        $directory = str_replace(
            '\\',
            '/',
            dirname($this->image)
        );

        $thumbnail =
            $directory
            . '/thumbs/'
            . basename($this->image);

        if (
            Storage::disk('public')
                ->exists($thumbnail)
        ) {
            return $thumbnail;
        }

        return $this->image;
    }
}