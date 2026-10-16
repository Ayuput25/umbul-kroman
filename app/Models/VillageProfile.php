<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VillageProfile extends Model
{
    use HasFactory;

    protected $fillable = [
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
    ];

    /*
    |--------------------------------------------------------------------------
    | GOOGLE MAPS SRC
    |--------------------------------------------------------------------------
    |
    | Menerima:
    | - URL Google Maps embed langsung
    | - iframe embed dari Google Maps
    |
    | Menolak domain aneh / non-Google / non-HTTPS.
    |
    */

    public function getGoogleMapsSrcAttribute(): ?string
    {
        if (!$this->google_maps_embed) {
            return null;
        }

        $value = trim(
            $this->google_maps_embed
        );

        /*
        |--------------------------------------------------------------------------
        | JIKA INPUT LANGSUNG URL
        |--------------------------------------------------------------------------
        */

        if (
            filter_var(
                $value,
                FILTER_VALIDATE_URL
            )
        ) {
            return $this->isAllowedGoogleMapsUrl(
                $value
            )
                ? $value
                : null;
        }

        /*
        |--------------------------------------------------------------------------
        | JIKA INPUT IFRAME
        |--------------------------------------------------------------------------
        */

        if (
            preg_match(
                '/<iframe[^>]+src=["\']([^"\']+)["\']/i',
                $value,
                $matches
            )
        ) {
            $src = html_entity_decode(
                $matches[1],
                ENT_QUOTES | ENT_HTML5,
                'UTF-8'
            );

            return $this->isAllowedGoogleMapsUrl(
                $src
            )
                ? $src
                : null;
        }

        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | GOOGLE MAPS URL VALIDATION
    |--------------------------------------------------------------------------
    */

    private function isAllowedGoogleMapsUrl(
        string $url
    ): bool {
        $scheme = parse_url(
            $url,
            PHP_URL_SCHEME
        );

        $host = parse_url(
            $url,
            PHP_URL_HOST
        );

        $path = parse_url(
            $url,
            PHP_URL_PATH
        );

        if (
            !$scheme ||
            strtolower($scheme) !== 'https'
        ) {
            return false;
        }

        if (!$host) {
            return false;
        }

        $host = strtolower(
            $host
        );

        $path = $path
            ? strtolower($path)
            : '';

        /*
        |--------------------------------------------------------------------------
        | DOMAIN GOOGLE YANG DIIZINKAN
        |--------------------------------------------------------------------------
        */

        $allowedHosts = [
            'www.google.com',
            'google.com',
            'maps.google.com',
            'www.google.co.id',
            'google.co.id',
            'maps.google.co.id',
        ];

        if (
            !in_array(
                $host,
                $allowedHosts,
                true
            )
        ) {
            return false;
        }

        /*
        |--------------------------------------------------------------------------
        | KHUSUS EMBED MAPS
        |--------------------------------------------------------------------------
        |
        | Contoh:
        | https://www.google.com/maps/embed?pb=...
        |
        */

        if (
            str_starts_with(
                $path,
                '/maps/embed'
            )
        ) {
            return true;
        }

        /*
        |--------------------------------------------------------------------------
        | URL MAPS BIASA
        |--------------------------------------------------------------------------
        |
        | Tetap diizinkan untuk kompatibilitas,
        | walaupun untuk iframe sebaiknya gunakan link embed.
        |
        */

        if (
            str_starts_with(
                $path,
                '/maps'
            )
        ) {
            return true;
        }

        return false;
    }
}