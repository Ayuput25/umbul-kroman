<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Gallery;
use App\Models\Post;
use App\Models\VillageProfile;

class HomeController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | PROFILE
        |--------------------------------------------------------------------------
        */

        $profile =
            VillageProfile::first();


        /*
        |--------------------------------------------------------------------------
        | DESTINATIONS
        |--------------------------------------------------------------------------
        */

        $destinations =
            Destination::query()
                ->where(
                    'is_active',
                    true
                )
                ->latest()
                ->take(6)
                ->get();


        $totalDestinations =
            Destination::query()
                ->where(
                    'is_active',
                    true
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | POSTS
        |--------------------------------------------------------------------------
        */

        $posts =
            Post::query()
                ->where(
                    'is_published',
                    true
                )
                ->whereNotNull(
                    'published_at'
                )
                ->where(
                    'published_at',
                    '<=',
                    now()
                )
                ->latest(
                    'published_at'
                )
                ->take(3)
                ->get();


        $totalPosts =
            Post::query()
                ->where(
                    'is_published',
                    true
                )
                ->whereNotNull(
                    'published_at'
                )
                ->where(
                    'published_at',
                    '<=',
                    now()
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | GALLERIES
        |--------------------------------------------------------------------------
        */

        $galleries =
            Gallery::query()
                ->where(
                    'is_active',
                    true
                )
                ->orderBy(
                    'sort_order'
                )
                ->latest()
                ->take(8)
                ->get();


        $totalGalleries =
            Gallery::query()
                ->where(
                    'is_active',
                    true
                )
                ->count();


        return view(
            'home',
            compact(
                'profile',
                'destinations',
                'posts',
                'galleries',
                'totalDestinations',
                'totalPosts',
                'totalGalleries'
            )
        );
    }
}