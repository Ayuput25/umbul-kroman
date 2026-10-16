<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminAccountController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminBackupController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SeoController;
use App\Http\Controllers\SiteSettingController;
use App\Http\Controllers\VillageProfileController;


/*
|--------------------------------------------------------------------------
| SEO
|--------------------------------------------------------------------------
*/

Route::get(
    '/sitemap.xml',
    [SeoController::class, 'sitemap']
)->name('sitemap');


Route::get(
    '/robots.txt',
    [SeoController::class, 'robots']
)->name('robots');


/*
|--------------------------------------------------------------------------
| WEBSITE PUBLIK
|--------------------------------------------------------------------------
*/

Route::get(
    '/',
    [HomeController::class, 'index']
)->name('home');


Route::get(
    '/profil',
    [VillageProfileController::class, 'show']
)->name('profile');


Route::get(
    '/destinasi',
    [DestinationController::class, 'publicIndex']
)->name('destinations.public');


Route::get(
    '/destinasi/{slug}',
    [DestinationController::class, 'showPublic']
)->name('destinations.show.public');


Route::get(
    '/blog',
    [PostController::class, 'publicIndex']
)->name('blog.public');


Route::get(
    '/blog/{slug}',
    [PostController::class, 'showPublic']
)->name('blog.show.public');


Route::get(
    '/galeri',
    [GalleryController::class, 'publicIndex']
)->name('gallery');


/*
|--------------------------------------------------------------------------
| SEARCH PUBLIK
|--------------------------------------------------------------------------
*/

Route::get(
    '/cari',
    [SearchController::class, 'index']
)->name('search');


/*
|--------------------------------------------------------------------------
| LOGIN ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get(
        '/admin/login',
        [AdminAuthController::class, 'showLogin']
    )->name('login');


    Route::post(
        '/admin/login',
        [AdminAuthController::class, 'login']
    )->name('admin.login.process');
});


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/admin',
        [AdminDashboardController::class, 'index']
    )->name('admin.home');


    Route::get(
        '/admin/dashboard',
        [AdminDashboardController::class, 'index']
    )->name('admin.dashboard');


    /*
    |--------------------------------------------------------------------------
    | PROFIL DESA
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/admin/profile',
        [VillageProfileController::class, 'edit']
    )->name('admin.profile.edit');


    Route::put(
        '/admin/profile',
        [VillageProfileController::class, 'update']
    )->name('admin.profile.update');


    /*
    |--------------------------------------------------------------------------
    | DESTINASI
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/admin/destinations/bulk-action',
        [DestinationController::class, 'bulkAction']
    )->name('destinations.bulk');


    Route::resource(
        '/admin/destinations',
        DestinationController::class
    )->except([
        'show',
    ]);


    /*
    |--------------------------------------------------------------------------
    | BLOG
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/admin/posts/bulk-action',
        [PostController::class, 'bulkAction']
    )->name('posts.bulk');


    Route::resource(
        '/admin/posts',
        PostController::class
    )->except([
        'show',
    ]);


    /*
    |--------------------------------------------------------------------------
    | GALERI
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/admin/galleries/bulk-action',
        [GalleryController::class, 'bulkAction']
    )->name('galleries.bulk');


    Route::resource(
        '/admin/galleries',
        GalleryController::class
    )->except([
        'show',
    ]);


    /*
    |--------------------------------------------------------------------------
    | SETTINGS
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/admin/settings',
        [SiteSettingController::class, 'edit']
    )->name('admin.settings.edit');


    Route::put(
        '/admin/settings',
        [SiteSettingController::class, 'update']
    )->name('admin.settings.update');


    /*
    |--------------------------------------------------------------------------
    | BACKUP
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/admin/backup',
        [AdminBackupController::class, 'index']
    )->name('admin.backup.index');


    Route::get(
        '/admin/backup/export',
        [AdminBackupController::class, 'export']
    )->name('admin.backup.export');


    Route::post(
        '/admin/backup/import',
        [AdminBackupController::class, 'import']
    )->name('admin.backup.import');


    Route::get(
        '/admin/backup/full/export',
        [AdminBackupController::class, 'exportFull']
    )->name('admin.backup.full.export');


    Route::post(
        '/admin/backup/full/import',
        [AdminBackupController::class, 'importFull']
    )->name('admin.backup.full.import');


    /*
    |--------------------------------------------------------------------------
    | ACCOUNT
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/admin/account',
        [AdminAccountController::class, 'edit']
    )->name('admin.account.edit');


    Route::put(
        '/admin/account/profile',
        [AdminAccountController::class, 'updateProfile']
    )->name(
        'admin.account.profile.update'
    );


    Route::put(
        '/admin/account/password',
        [AdminAccountController::class, 'updatePassword']
    )->name(
        'admin.account.password.update'
    );


    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/admin/logout',
        [AdminAuthController::class, 'logout']
    )->name('admin.logout');
});