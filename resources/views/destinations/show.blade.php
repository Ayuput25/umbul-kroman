@extends('layouts.app')

@section(
    'title',
    $destination->name . ' - Destinasi Umbul Kroman'
)

@section(
    'meta_description',
    \Illuminate\Support\Str::limit(
        strip_tags(
            $destination->description
                ?: 'Informasi destinasi wisata '
                    . $destination->name
                    . ' di Umbul Kroman.'
        ),
        160
    )
)

@section(
    'canonical',
    route(
        'destinations.show.public',
        $destination->slug
    )
)

@if($destination->image)

    @section(
        'meta_image',
        asset(
            'storage/' .
            $destination->image
        )
    )

@endif


{{-- =========================================================
    TOURIST ATTRACTION SCHEMA
========================================================== --}}

@push('head')

    @php
        $destinationUrl =
            route(
                'destinations.show.public',
                $destination->slug
            );

        $destinationSchema = [
            '@context' =>
                'https://schema.org',

            '@type' =>
                'TouristAttraction',

            '@id' =>
                $destinationUrl .
                '#tourist-attraction',

            'name' =>
                $destination->name,

            'url' =>
                $destinationUrl,

            'description' =>
                \Illuminate\Support\Str::limit(
                    strip_tags(
                        $destination->description
                            ?: 'Destinasi wisata '
                                . $destination->name
                    ),
                    300
                ),

            'inLanguage' =>
                'id-ID',
        ];


        if ($destination->image) {

            $destinationSchema['image'] = [
                asset(
                    'storage/' .
                    $destination->image
                ),
            ];
        }


        if ($destination->address) {

            $destinationSchema['address'] = [
                '@type' =>
                    'PostalAddress',

                'streetAddress' =>
                    $destination->address,

                'addressCountry' =>
                    'ID',
            ];
        }


        if ($destination->google_maps_url) {

            $destinationSchema['hasMap'] =
                $destination->google_maps_url;
        }


        if (
            $destination->ticket_price
            !== null
        ) {
            $destinationSchema['offers'] = [
                '@type' =>
                    'Offer',

                'price' =>
                    number_format(
                        (float)
                        $destination->ticket_price,
                        0,
                        '.',
                        ''
                    ),

                'priceCurrency' =>
                    'IDR',

                'availability' =>
                    'https://schema.org/InStock',

                'url' =>
                    $destinationUrl,
            ];

            $destinationSchema[
                'isAccessibleForFree'
            ] =
                (float)
                $destination->ticket_price
                === 0.0;
        }
    @endphp


    <script type="application/ld+json">
        {!! json_encode(
            $destinationSchema,
            JSON_UNESCAPED_SLASHES |
            JSON_UNESCAPED_UNICODE |
            JSON_HEX_TAG |
            JSON_HEX_AMP |
            JSON_HEX_APOS |
            JSON_HEX_QUOT
        ) !!}
    </script>

@endpush


@section('content')

    {{-- =========================================================
        BREADCRUMB
    ========================================================== --}}

    <div class="container">

        <x-breadcrumbs
            :items="[
                [
                    'name' => 'Beranda',
                    'url' => route('home'),
                ],
                [
                    'name' => 'Destinasi',
                    'url' => route(
                        'destinations.public'
                    ),
                ],
                [
                    'name' => $destination->name,
                    'url' => $destinationUrl,
                ],
            ]"
        />

    </div>


    {{-- =========================================================
        HERO + INFO
    ========================================================== --}}

    <section class="pt-3 pb-5">

        <div class="container">

            <div
                class="
                    row
                    g-4
                    g-lg-5
                    align-items-start
                "
            >

                <div class="col-lg-8">

                    @if($destination->image)

                        <div
                            class="
                                overflow-hidden
                                rounded-4
                                shadow-sm
                            "
                        >

                            <x-responsive-image
                                :src="$destination->image"
                                :thumbnail="$destination->thumbnail"
                                :alt="$destination->name"
                                class="w-100 d-block"
                                sizes="
                                    (max-width: 991px) 100vw,
                                    66vw
                                "
                                loading="eager"
                                fetchpriority="high"
                                style="
                                    width: 100%;
                                    max-height: 620px;
                                    object-fit: cover;
                                "
                            />

                        </div>

                    @else

                        <div
                            class="
                                bg-light
                                rounded-4
                                d-flex
                                align-items-center
                                justify-content-center
                                text-muted
                            "
                            style="
                                min-height: 420px;
                            "
                        >

                            Belum ada gambar destinasi.

                        </div>

                    @endif

                </div>


                <div class="col-lg-4">

                    <div
                        class="
                            bg-white
                            border
                            rounded-4
                            shadow-sm
                            p-4
                        "
                    >

                        <span class="section-kicker">
                            Destinasi
                        </span>


                        <h1
                            class="
                                h2
                                fw-bold
                                mt-2
                                mb-4
                            "
                        >
                            {{ $destination->name }}
                        </h1>


                        @if(
                            $destination->ticket_price
                            !== null
                        )

                            <div class="mb-4">

                                <div
                                    class="
                                        small
                                        text-muted
                                        mb-1
                                    "
                                >
                                    Harga Tiket
                                </div>


                                <div
                                    class="
                                        fs-4
                                        fw-bold
                                        text-success
                                    "
                                >

                                    @if(
                                        (float)
                                        $destination->ticket_price
                                        === 0.0
                                    )

                                        Gratis

                                    @else

                                        Rp {{ number_format(
                                            $destination->ticket_price,
                                            0,
                                            ',',
                                            '.'
                                        ) }}

                                    @endif

                                </div>

                            </div>

                        @endif


                        @if($destination->opening_hours)

                            <div class="mb-4">

                                <div
                                    class="
                                        small
                                        text-muted
                                        mb-1
                                    "
                                >
                                    Jam Operasional
                                </div>

                                <div class="fw-semibold">

                                    {{ $destination->opening_hours }}

                                </div>

                            </div>

                        @endif


                        @if($destination->address)

                            <div class="mb-4">

                                <div
                                    class="
                                        small
                                        text-muted
                                        mb-1
                                    "
                                >
                                    Lokasi
                                </div>

                                <div>
                                    {{ $destination->address }}
                                </div>

                            </div>

                        @endif


                        @if($destination->google_maps_url)

                            <a
                                href="{{ $destination->google_maps_url }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="
                                    btn
                                    btn-success
                                    w-100
                                    rounded-pill
                                "
                            >
                                Buka Google Maps
                            </a>

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- =========================================================
        DESCRIPTION
    ========================================================== --}}

    @if($destination->description)

        <section class="section-space">

            <div class="container">

                <div class="row justify-content-center">

                    <div class="col-lg-9">

                        <div class="reveal">

                            <span class="section-kicker">
                                Tentang Destinasi
                            </span>


                            <h2
                                class="
                                    section-title
                                    mb-4
                                "
                            >
                                {{ $destination->name }}
                            </h2>


                            <div
                                class="
                                    destination-description
                                    text-muted
                                    lh-lg
                                "
                            >

                                {!! nl2br(
                                    e(
                                        $destination->description
                                    )
                                ) !!}

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>

    @endif


    {{-- =========================================================
        FACILITIES
    ========================================================== --}}

    @if($destination->facilities)

        <section
            class="
                section-space
                bg-light
            "
        >

            <div class="container">

                <div class="row justify-content-center">

                    <div class="col-lg-9">

                        <div class="reveal">

                            <span class="section-kicker">
                                Fasilitas
                            </span>


                            <h2
                                class="
                                    section-title
                                    mb-4
                                "
                            >
                                Fasilitas yang Tersedia
                            </h2>


                            <div
                                class="
                                    bg-white
                                    rounded-4
                                    border
                                    p-4
                                    p-lg-5
                                    shadow-sm
                                    lh-lg
                                "
                            >

                                {!! nl2br(
                                    e(
                                        $destination->facilities
                                    )
                                ) !!}

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>

    @endif


    {{-- =========================================================
        RELATED DESTINATIONS
    ========================================================== --}}

    @if(
        isset($relatedDestinations) &&
        $relatedDestinations->isNotEmpty()
    )

        <section class="section-space">

            <div class="container">

                <div
                    class="
                        d-flex
                        flex-column
                        flex-md-row
                        justify-content-between
                        align-items-md-end
                        gap-3
                        mb-5
                    "
                >

                    <div class="reveal">

                        <span class="section-kicker">
                            Rekomendasi
                        </span>

                        <h2
                            class="
                                section-title
                                mb-0
                            "
                        >
                            Destinasi Lainnya
                        </h2>

                    </div>


                    <a
                        href="{{ route(
                            'destinations.public'
                        ) }}"
                        class="
                            text-decoration-none
                            fw-semibold
                            text-success
                        "
                    >
                        Lihat Semua →
                    </a>

                </div>


                <div class="row g-4">

                    @foreach(
                        $relatedDestinations
                        as $relatedDestination
                    )

                        <div
                            class="
                                col-md-6
                                col-lg-4
                                reveal
                            "
                        >

                            <article
                                class="
                                    destination-card
                                    h-100
                                "
                            >

                                <a
                                    href="{{ route(
                                        'destinations.show.public',
                                        $relatedDestination->slug
                                    ) }}"
                                    class="
                                        destination-card-image-wrapper
                                        d-block
                                    "
                                >

                                    @if($relatedDestination->image)

                                        <x-responsive-image
                                            :src="$relatedDestination->image"
                                            :thumbnail="$relatedDestination->thumbnail"
                                            :alt="$relatedDestination->name"
                                            class="destination-card-image"
                                            sizes="
                                                (max-width: 767px) 100vw,
                                                (max-width: 991px) 50vw,
                                                33vw
                                            "
                                            loading="lazy"
                                        />

                                    @else

                                        <div
                                            class="
                                                destination-card-image
                                                bg-light
                                                d-flex
                                                align-items-center
                                                justify-content-center
                                                text-muted
                                            "
                                        >
                                            Belum ada gambar
                                        </div>

                                    @endif

                                </a>


                                <div class="destination-card-body">

                                    <h3
                                        class="
                                            h5
                                            fw-bold
                                            mb-3
                                        "
                                    >

                                        <a
                                            href="{{ route(
                                                'destinations.show.public',
                                                $relatedDestination->slug
                                            ) }}"
                                            class="
                                                text-decoration-none
                                                text-dark
                                            "
                                        >

                                            {{ $relatedDestination->name }}

                                        </a>

                                    </h3>


                                    @if(
                                        $relatedDestination->description
                                    )

                                        <p
                                            class="
                                                text-muted
                                                mb-4
                                            "
                                        >

                                            {{ \Illuminate\Support\Str::limit(
                                                strip_tags(
                                                    $relatedDestination->description
                                                ),
                                                110
                                            ) }}

                                        </p>

                                    @endif


                                    <div
                                        class="
                                            d-flex
                                            justify-content-between
                                            align-items-center
                                            gap-3
                                            mt-auto
                                        "
                                    >

                                        <span
                                            class="
                                                fw-bold
                                                text-success
                                            "
                                        >

                                            @if(
                                                $relatedDestination->ticket_price
                                                === null
                                            )

                                                Info Tiket

                                            @elseif(
                                                (float)
                                                $relatedDestination->ticket_price
                                                === 0.0
                                            )

                                                Gratis

                                            @else

                                                Rp {{ number_format(
                                                    $relatedDestination->ticket_price,
                                                    0,
                                                    ',',
                                                    '.'
                                                ) }}

                                            @endif

                                        </span>


                                        <a
                                            href="{{ route(
                                                'destinations.show.public',
                                                $relatedDestination->slug
                                            ) }}"
                                            class="
                                                text-decoration-none
                                                fw-semibold
                                                text-success
                                            "
                                        >
                                            Detail →
                                        </a>

                                    </div>

                                </div>

                            </article>

                        </div>

                    @endforeach

                </div>

            </div>

        </section>

    @endif


    {{-- =========================================================
        CTA
    ========================================================== --}}

    <section class="section-space bg-light">

        <div class="container">

            <div
                class="
                    text-center
                    bg-white
                    border
                    rounded-4
                    p-4
                    p-lg-5
                    shadow-sm
                    reveal
                "
            >

                <span class="section-kicker">
                    Jelajahi
                </span>


                <h2 class="fw-bold mb-3">
                    Temukan Destinasi Menarik Lainnya
                </h2>


                <p class="text-muted mb-4">

                    Lihat seluruh destinasi wisata
                    yang tersedia di Umbul Kroman.

                </p>


                <a
                    href="{{ route(
                        'destinations.public'
                    ) }}"
                    class="
                        btn
                        btn-success
                        rounded-pill
                        px-4
                    "
                >
                    Semua Destinasi
                </a>

            </div>

        </div>

    </section>

@endsection