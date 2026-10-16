<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Post;
use App\Models\Gallery;
use App\Models\VillageProfile;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $destinationCount = Destination::count();

        $activeDestinationCount = Destination::where(
            'is_active',
            true
        )->count();

        $postCount = Post::count();

        $publishedPostCount = Post::where(
            'is_published',
            true
        )->count();

        $galleryCount = Gallery::count();

        $activeGalleryCount = Gallery::where(
            'is_active',
            true
        )->count();

        $profile = VillageProfile::first();

        $latestDestinations = Destination::latest()
            ->take(5)
            ->get();

        $latestPosts = Post::latest()
            ->take(5)
            ->get();

        return view(
            'admin.dashboard.index',
            compact(
                'destinationCount',
                'activeDestinationCount',
                'postCount',
                'publishedPostCount',
                'galleryCount',
                'activeGalleryCount',
                'profile',
                'latestDestinations',
                'latestPosts'
            )
        );
    }
}