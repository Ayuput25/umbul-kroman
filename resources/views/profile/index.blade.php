@extends('layouts.app')

@section(
    'title',
    'Profil ' .
    ($profile?->name ?? 'Umbul Kroman')
)

@section(
    'meta_description',
    $profile?->description
        ? \Illuminate\Support\Str::limit(
            strip_tags($profile->description),
            160
        )
        : 'Profil dan informasi Umbul Kroman.'
)

@section(
    'canonical',
    route('profile')
)

@if($profile?->hero_image)

    @section(
        'meta_image',
        asset(
            'storage/' .
            $profile->hero_image
        )
    )

@endif


@section('content')

@if($profile)


{{-- HERO --}}
<section
    class="home-hero"
    style="
        min-height: 560px;
        background-image:
            url(
                '{{ $profile->hero_image
                    ? asset(
                        'storage/' .
                        $profile->hero_image
                    )
                    : 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1800&q=85'
                }}'
            );
    ">

    <div class="container">

        <div class="hero-content">

            <div class="hero-badge reveal">
                ✦ Profil Desa
            </div>

            <h1 class="hero-title reveal">

                {{ $profile->name }}

            </h1>


            @if($profile->tagline)

                <p class="hero-description reveal">

                    {{ $profile->tagline }}

                </p>

            @endif

        </div>

    </div>

</section>


{{-- TENTANG --}}
@if($profile->description)

<section class="section-space">

    <div class="container">

        <div
            class="
                section-heading
                mx-auto
                text-center
                reveal
            ">

            <span class="section-kicker">
                Tentang
            </span>

            <h2 class="section-title mb-4">

                Mengenal {{ $profile->name }}

            </h2>

            <p
                class="section-description"
                style="white-space: pre-line;">

                {{ $profile->description }}

            </p>

        </div>

    </div>

</section>

@endif


{{-- SEJARAH --}}
@if($profile->history)

<section class="section-space bg-soft">

    <div class="container">

        <div
            class="
                card
                border-0
                shadow-sm
                reveal
            "
            style="border-radius: 28px;">

            <div class="card-body p-4 p-md-5">

                <span class="section-kicker">
                    Perjalanan
                </span>

                <h2 class="section-title mb-4">
                    Sejarah
                </h2>

                <div
                    class="text-muted"
                    style="
                        white-space: pre-line;
                        line-height: 1.95;
                        font-size: 1.06rem;
                    ">

                    {{ $profile->history }}

                </div>

            </div>

        </div>

    </div>

</section>

@endif


{{-- VISI MISI --}}
@if(
    $profile->vision ||
    $profile->mission
)

<section class="section-space">

    <div class="container">

        <div
            class="
                section-heading
                text-center
                mx-auto
                mb-5
                reveal
            ">

            <span class="section-kicker">
                Arah Pengembangan
            </span>

            <h2 class="section-title">
                Visi & Misi
            </h2>

        </div>


        <div class="row g-4">

            @if($profile->vision)

                <div class="col-lg-5">

                    <div
                        class="
                            intro-card
                            h-100
                            reveal
                        ">

                        <div
                            class="
                                info-feature-icon
                                mb-4
                            ">
                            V
                        </div>

                        <h3 class="fw-bold mb-3">
                            Visi
                        </h3>

                        <div
                            class="text-muted"
                            style="
                                white-space: pre-line;
                                line-height: 1.9;
                            ">

                            {{ $profile->vision }}

                        </div>

                    </div>

                </div>

            @endif


            @if($profile->mission)

                <div class="col-lg-7">

                    <div
                        class="
                            intro-card
                            h-100
                            reveal
                        ">

                        <div
                            class="
                                info-feature-icon
                                mb-4
                            ">
                            M
                        </div>

                        <h3 class="fw-bold mb-3">
                            Misi
                        </h3>

                        <div
                            class="text-muted"
                            style="
                                white-space: pre-line;
                                line-height: 1.9;
                            ">

                            {{ $profile->mission }}

                        </div>

                    </div>

                </div>

            @endif

        </div>

    </div>

</section>

@endif


{{-- KONTAK --}}
@if(
    $profile->address ||
    $profile->phone ||
    $profile->email ||
    $profile->google_maps_src
)

<section class="section-space bg-soft">

    <div class="container">

        <div
            class="
                section-heading
                text-center
                mx-auto
                mb-5
                reveal
            ">

            <span class="section-kicker">
                Temukan Kami
            </span>

            <h2 class="section-title">
                Kontak & Lokasi
            </h2>

        </div>


        <div class="row g-4">

            <div class="col-lg-4">

                <div
                    class="
                        intro-card
                        h-100
                        reveal
                    ">

                    <h4 class="fw-bold mb-4">
                        Informasi
                    </h4>


                    @if($profile->address)

                        <div class="mb-4">

                            <div
                                class="
                                    text-muted
                                    small
                                    fw-bold
                                    text-uppercase
                                    mb-1
                                ">

                                Alamat

                            </div>

                            {{ $profile->address }}

                        </div>

                    @endif


                    @if($profile->phone)

                        <div class="mb-4">

                            <div
                                class="
                                    text-muted
                                    small
                                    fw-bold
                                    text-uppercase
                                    mb-1
                                ">

                                Telepon

                            </div>

                            <a
                                href="tel:{{ $profile->phone }}"
                                class="
                                    text-primary-custom
                                    text-decoration-none
                                    fw-semibold
                                ">

                                {{ $profile->phone }}

                            </a>

                        </div>

                    @endif


                    @if($profile->email)

                        <div>

                            <div
                                class="
                                    text-muted
                                    small
                                    fw-bold
                                    text-uppercase
                                    mb-1
                                ">

                                Email

                            </div>

                            <a
                                href="mailto:{{ $profile->email }}"
                                class="
                                    text-primary-custom
                                    text-decoration-none
                                    fw-semibold
                                ">

                                {{ $profile->email }}

                            </a>

                        </div>

                    @endif

                </div>

            </div>


            <div class="col-lg-8">

                @if($profile->google_maps_src)

                    <div
                        class="
                            overflow-hidden
                            shadow-sm
                            reveal
                        "
                        style="
                            border-radius: 24px;
                        ">

                        <iframe
                            src="{{ $profile->google_maps_src }}"
                            width="100%"
                            height="450"
                            style="border: 0;"
                            allowfullscreen
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Lokasi {{ $profile->name }}">
                        </iframe>

                    </div>

                @else

                    <div
                        class="
                            intro-card
                            d-flex
                            align-items-center
                            justify-content-center
                            text-muted
                            h-100
                            reveal
                        "
                        style="min-height: 450px;">

                        Google Maps belum tersedia.

                    </div>

                @endif

            </div>

        </div>

    </div>

</section>

@endif


@else

<section class="section-space">

    <div class="container">

        <div
            class="
                alert
                alert-info
                text-center
            ">

            Profil desa belum tersedia.

        </div>

    </div>

</section>

@endif

@endsection