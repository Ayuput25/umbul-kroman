<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
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
    ];

    protected $casts = [
        'show_whatsapp' => 'boolean',
    ];

    public function whatsappUrl(): ?string
    {
        if (!$this->whatsapp_number) {
            return null;
        }

        $number = preg_replace(
            '/[^0-9]/',
            '',
            $this->whatsapp_number
        );

        if (str_starts_with($number, '0')) {
            $number = '62' . substr($number, 1);
        }

        $message = $this->whatsapp_message
            ?: 'Halo, saya ingin bertanya mengenai Umbul Kroman.';

        return 'https://wa.me/'
            . $number
            . '?text='
            . rawurlencode($message);
    }
}