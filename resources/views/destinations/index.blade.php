@extends('layouts.app')

@section(
    'title',
    'Destinasi Wisata - Umbul Kroman'
)

@section(
    'meta_description',
    'Jelajahi berbagai destinasi wisata di Umbul Kroman dan sekitarnya.'
)

@section(
    'canonical',
    route('destinations.public')
)

@section('content')

    <div class="container">

        <x-breadcrumbs
            :items="[
                [
                    'name' => 'Beranda',
                    'url' => route('home'),
                ],
                [
                    'name' => 'Destinasi',
                    'url' => route('destinations.public'),
                ],
            ]"
        />

    </div>


    <section class="section-space pt-4">

        <div class="container">

            <div
                class="
                    section-heading
                    text-center
                    mx-auto
                    mb-5
                    reveal
                "
            >

                <span class="section-kicker">
                    Jelajahi
                </span>

                <h1 class="section-title">
                    Destinasi Wisata
                </h1>

                <p class="section-description">

                    Temukan berbagai tempat menarik
                    dan pengalaman wisata
                    di Umbul Kroman.

                </p>

            </div>


            <div class="row g-4">

                @forelse(
                    $destinations
                    as $destination
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
                                    $destination->slug
                                ) }}"
                                class="
                                    destination-card-image-wrapper
                                    d-block
                                "
                            >

                                @if($destination->image)

                                    <x-responsive-image
                                        :src="$destination->image"
                                        :thumbnail="$destination->thumbnail"
                                        :alt="$destination->name"
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

                                <h2 class="h5 fw-bold mb-3">

                                    <a
                                        href="{{ route(
                                            'destinations.show.public',
                                            $destination->slug
                                        ) }}"
                                        class="
                                            text-decoration-none
                                            text-dark
                                        "
                                    >

                                        {{ $destination->name }}

                                    </a>

                                </h2>


                                @if($destination->description)

                                    <p class="text-muted mb-4">

                                        {{ \Illuminate\Support\Str::limit(
                                            strip_tags(
                                                $destination->description
                                            ),
                                            115
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
                                            $destination->ticket_price
                                            === null
                                        )

                                            Info Tiket

                                        @elseif(
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

                                    </span>


                                    <a
                                        href="{{ route(
                                            'destinations.show.public',
                                            $destination->slug
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

                @empty

                    <div class="col-12">

                        <div
                            class="
                                text-center
                                py-5
                                text-muted
                            "
                        >
                            Belum ada destinasi wisata.
                        </div>

                    </div>

                @endforelse

            </div>


            {{-- =================================================
                PAGINATION
            ================================================== --}}

            @if($destinations->hasPages())

                <div
                    class="
                        public-pagination
                        mt-5
                        d-flex
                        justify-content-center
                    "
                >

                    {{ $destinations->links() }}

                </div>

            @endif

        </div>

    </section>

@endsection