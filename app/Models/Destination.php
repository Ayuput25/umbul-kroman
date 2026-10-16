<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = [
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
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'ticket_price' => 'decimal:2',
    ];


    /*
    |--------------------------------------------------------------------------
    | THUMBNAIL
    |--------------------------------------------------------------------------
    |
    | Kalau thumbnail ada:
    | destinations/thumbs/xxxx.webp
    |
    | maka thumbnail itu yang dipakai.
    |
    | Kalau thumbnail belum ada, misalnya gambar lama sebelum fitur optimasi
    | dibuat, otomatis fallback ke gambar utama.
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