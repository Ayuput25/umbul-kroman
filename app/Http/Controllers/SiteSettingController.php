<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use App\Services\ImageService;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    public function __construct(
        private ImageService $imageService
    ) {
        //
    }


    public function edit()
    {
        $settings =
            SiteSetting::firstOrCreate(
                [],
                [
                    'site_title' =>
                        'Umbul Kroman',

                    'show_whatsapp' =>
                        true,
                ]
            );


        return view(
            'admin.settings.edit',
            compact('settings')
        );
    }


    public function update(
        Request $request
    ) {
        $settings =
            SiteSetting::firstOrCreate(
                [],
                [
                    'site_title' =>
                        'Umbul Kroman',

                    'show_whatsapp' =>
                        true,
                ]
            );


        $validated =
            $request->validate([
                'site_title' =>
                    'nullable|string|max:255',

                'meta_description' =>
                    'nullable|string|max:1000',

                'meta_keywords' =>
                    'nullable|string|max:1000',

                'favicon' =>
                    'nullable|image|mimes:png,jpg,jpeg,webp|max:4096',

                'whatsapp_number' =>
                    'nullable|string|max:50',

                'whatsapp_message' =>
                    'nullable|string|max:500',

                'instagram_url' =>
                    'nullable|url|max:500',

                'facebook_url' =>
                    'nullable|url|max:500',

                'tiktok_url' =>
                    'nullable|url|max:500',

                'youtube_url' =>
                    'nullable|url|max:500',

                'footer_text' =>
                    'nullable|string|max:255',
            ]);


        $validated['show_whatsapp'] =
            $request->boolean(
                'show_whatsapp'
            );


        /*
        |--------------------------------------------------------------------------
        | FAVICON
        |--------------------------------------------------------------------------
        */

        if (
            $request->hasFile(
                'favicon'
            )
        ) {
            $newFavicon =
                $this->imageService->store(
                    $request->file(
                        'favicon'
                    ),
                    'settings',
                    512,
                    512,
                    90,
                    false
                );


            $this->imageService->delete(
                $settings->favicon
            );


            $validated['favicon'] =
                $newFavicon;
        }


        $settings->update(
            $validated
        );


        return redirect()
            ->route(
                'admin.settings.edit'
            )
            ->with(
                'success',
                'Pengaturan website berhasil diperbarui.'
            );
    }
}