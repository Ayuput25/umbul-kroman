<?php

namespace App\Http\Controllers;

use App\Models\VillageProfile;
use App\Services\ImageService;
use Illuminate\Http\Request;

class VillageProfileController extends Controller
{
    public function __construct(
        private ImageService $imageService
    ) {
        //
    }


    public function show()
    {
        $profile =
            VillageProfile::first();

        return view(
            'profile.index',
            compact('profile')
        );
    }


    public function edit()
    {
        $profile =
            VillageProfile::firstOrCreate(
                [],
                [
                    'name' =>
                        'Umbul Kroman',
                ]
            );

        return view(
            'admin.profile.edit',
            compact('profile')
        );
    }


    public function update(
        Request $request
    ) {
        $profile =
            VillageProfile::firstOrCreate(
                [],
                [
                    'name' =>
                        'Umbul Kroman',
                ]
            );


        $validated =
            $request->validate([
                'name' =>
                    'required|string|max:255',

                'tagline' =>
                    'nullable|string|max:255',

                'description' =>
                    'nullable|string',

                'history' =>
                    'nullable|string',

                'vision' =>
                    'nullable|string',

                'mission' =>
                    'nullable|string',

                'address' =>
                    'nullable|string|max:500',

                'phone' =>
                    'nullable|string|max:50',

                'email' =>
                    'nullable|email|max:255',

                'google_maps_embed' =>
                    'nullable|string',

                'logo' =>
                    'nullable|image|mimes:jpg,jpeg,png,webp|max:8192',

                'hero_image' =>
                    'nullable|image|mimes:jpg,jpeg,png,webp|max:15360',
            ]);


        /*
        |--------------------------------------------------------------------------
        | LOGO
        |--------------------------------------------------------------------------
        */

        if (
            $request->hasFile('logo')
        ) {
            $newLogo =
                $this->imageService->store(
                    $request->file('logo'),
                    'profile',
                    800,
                    800,
                    88,
                    false
                );


            $this->imageService->delete(
                $profile->logo
            );


            $validated['logo'] =
                $newLogo;
        }


        /*
        |--------------------------------------------------------------------------
        | HERO
        |--------------------------------------------------------------------------
        */

        if (
            $request->hasFile(
                'hero_image'
            )
        ) {
            $newHero =
                $this->imageService->store(
                    $request->file(
                        'hero_image'
                    ),
                    'profile',
                    1920,
                    1200,
                    84,
                    false
                );


            $this->imageService->delete(
                $profile->hero_image
            );


            $validated['hero_image'] =
                $newHero;
        }


        $profile->update(
            $validated
        );


        return redirect()
            ->route(
                'admin.profile.edit'
            )
            ->with(
                'success',
                'Profil desa berhasil diperbarui dan media telah dioptimasi.'
            );
    }
}