<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Post;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    public function sitemap(): Response
    {
        $destinations = Destination::query()
            ->where('is_active', true)
            ->orderByDesc('updated_at')
            ->get([
                'slug',
                'updated_at',
            ]);

        $posts = Post::query()
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderByDesc('updated_at')
            ->get([
                'slug',
                'updated_at',
            ]);


        /*
        |--------------------------------------------------------------------------
        | XML HEADER
        |--------------------------------------------------------------------------
        */

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';

        $xml .= "\n";

        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        $xml .= "\n";


        /*
        |--------------------------------------------------------------------------
        | HOME
        |--------------------------------------------------------------------------
        */

        $xml .= $this->buildUrl(
            route('home'),
            null,
            'weekly',
            '1.0'
        );


        /*
        |--------------------------------------------------------------------------
        | PROFIL
        |--------------------------------------------------------------------------
        */

        $xml .= $this->buildUrl(
            route('profile'),
            null,
            'monthly',
            '0.8'
        );


        /*
        |--------------------------------------------------------------------------
        | DESTINASI INDEX
        |--------------------------------------------------------------------------
        */

        $xml .= $this->buildUrl(
            route('destinations.public'),
            null,
            'weekly',
            '0.9'
        );


        /*
        |--------------------------------------------------------------------------
        | DESTINASI DETAIL
        |--------------------------------------------------------------------------
        */

        foreach ($destinations as $destination) {

            $xml .= $this->buildUrl(
                route(
                    'destinations.show.public',
                    $destination->slug
                ),
                $destination->updated_at,
                'monthly',
                '0.8'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | BLOG INDEX
        |--------------------------------------------------------------------------
        */

        $xml .= $this->buildUrl(
            route('blog.public'),
            null,
            'weekly',
            '0.8'
        );


        /*
        |--------------------------------------------------------------------------
        | BLOG DETAIL
        |--------------------------------------------------------------------------
        */

        foreach ($posts as $post) {

            $xml .= $this->buildUrl(
                route(
                    'blog.show.public',
                    $post->slug
                ),
                $post->updated_at,
                'monthly',
                '0.7'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | GALERI
        |--------------------------------------------------------------------------
        */

        $xml .= $this->buildUrl(
            route('gallery'),
            null,
            'weekly',
            '0.7'
        );


        /*
        |--------------------------------------------------------------------------
        | CLOSE XML
        |--------------------------------------------------------------------------
        */

        $xml .= '</urlset>';


        return response(
            $xml,
            200,
            [
                'Content-Type' =>
                    'application/xml; charset=UTF-8',

                'Cache-Control' =>
                    'public, max-age=3600',
            ]
        );
    }


    public function robots(): Response
    {
        $content = implode(
            PHP_EOL,
            [
                'User-agent: *',
                'Allow: /',
                '',
                'Disallow: /admin',
                '',
                'Sitemap: ' . route('sitemap'),
                '',
            ]
        );


        return response(
            $content,
            200,
            [
                'Content-Type' =>
                    'text/plain; charset=UTF-8',

                'Cache-Control' =>
                    'public, max-age=3600',
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | BUILD SITEMAP URL
    |--------------------------------------------------------------------------
    */

    private function buildUrl(
        string $url,
        $updatedAt = null,
        string $changefreq = 'monthly',
        string $priority = '0.5'
    ): string {
        $xml = "\n";

        $xml .= "    <url>\n";

        $xml .=
            '        <loc>'
            . $this->escapeXml($url)
            . "</loc>\n";


        if ($updatedAt) {

            $xml .=
                '        <lastmod>'
                . $updatedAt->toAtomString()
                . "</lastmod>\n";
        }


        $xml .=
            '        <changefreq>'
            . $changefreq
            . "</changefreq>\n";


        $xml .=
            '        <priority>'
            . $priority
            . "</priority>\n";


        $xml .= "    </url>\n";


        return $xml;
    }


    /*
    |--------------------------------------------------------------------------
    | ESCAPE XML
    |--------------------------------------------------------------------------
    */

    private function escapeXml(
        string $value
    ): string {
        return htmlspecialchars(
            $value,
            ENT_XML1 | ENT_QUOTES,
            'UTF-8'
        );
    }
}