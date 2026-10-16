<?php

namespace App\Providers;

use App\Models\SiteSetting;
use App\Models\VillageProfile;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /*
    |--------------------------------------------------------------------------
    | REGISTER
    |--------------------------------------------------------------------------
    */

    public function register(): void
    {
        //
    }


    /*
    |--------------------------------------------------------------------------
    | BOOT
    |--------------------------------------------------------------------------
    */

    public function boot(): void
    {
        /*
        |--------------------------------------------------------------------------
        | BOOTSTRAP PAGINATION
        |--------------------------------------------------------------------------
        */

        Paginator::useBootstrapFive();


        /*
        |--------------------------------------------------------------------------
        | PUBLIC WEBSITE GLOBAL DATA
        |--------------------------------------------------------------------------
        |
        | $siteProfile dan $siteSettings dibutuhkan oleh:
        |
        | - layouts.app
        | - home
        | - profile
        | - destinations
        | - blog
        | - gallery
        | - halaman error
        |
        | Static cache digunakan supaya dalam satu request Laravel tidak
        | menjalankan query VillageProfile dan SiteSetting berulang kali
        | saat child view + layout sama-sama dirender.
        |
        */

        View::composer(
            [
                'layouts.app',

                'home',

                'profile.*',

                'destinations.*',

                'blog.*',

                'gallery.*',

                'errors.*',
            ],
            function ($view) {

                static $siteProfile = null;
                static $siteSettings = null;
                static $loaded = false;


                /*
                |--------------------------------------------------------------------------
                | LOAD SEKALI PER REQUEST
                |--------------------------------------------------------------------------
                */

                if (!$loaded) {

                    $siteProfile =
                        VillageProfile::query()
                            ->first();

                    $siteSettings =
                        SiteSetting::query()
                            ->first();

                    $loaded = true;
                }


                /*
                |--------------------------------------------------------------------------
                | SHARE KE VIEW
                |--------------------------------------------------------------------------
                */

                $view->with([
                    'siteProfile' =>
                        $siteProfile,

                    'siteSettings' =>
                        $siteSettings,
                ]);
            }
        );
    }
}