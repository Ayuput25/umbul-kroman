<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'image',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];


    /*
    |--------------------------------------------------------------------------
    | THUMBNAIL
    |--------------------------------------------------------------------------
    |
    | Thumbnail baru:
    | posts/thumbs/xxxx.webp
    |
    | Kalau belum ada thumbnail, otomatis pakai gambar utama.
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