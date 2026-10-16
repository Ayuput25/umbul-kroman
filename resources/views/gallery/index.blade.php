@extends('layouts.app')

@section(
    'title',
    'Galeri - Umbul Kroman'
)

@section(
    'meta_description',
    'Galeri foto dan dokumentasi Umbul Kroman.'
)

@section(
    'canonical',
    route('gallery')
)

@section('content')

<section class="section-space">

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
                Dokumentasi
            </span>

            <h1 class="section-title">
                Galeri Foto
            </h1>

            <p class="section-description">
                Lihat berbagai dokumentasi
                dan suasana Umbul Kroman.
            </p>

        </div>


        <div class="row g-3 g-lg-4">

            @forelse(
                $galleries
                as $gallery
            )

                <div
                    class="
                        col-6
                        col-md-4
                        col-lg-3
                        reveal
                    "
                >

                    <button
                        type="button"
                        class="
                            gallery-item
                            border-0
                            p-0
                            w-100
                            bg-transparent
                        "
                        data-bs-toggle="modal"
                        data-bs-target="#galleryModal{{ $gallery->id }}"
                    >

                        <x-responsive-image
                            :src="$gallery->image"
                            :thumbnail="$gallery->thumbnail"
                            :alt="$gallery->title"
                            class="gallery-image"
                            sizes="
                                (max-width: 767px) 50vw,
                                (max-width: 991px) 33vw,
                                25vw
                            "
                            loading="lazy"
                        />


                        <div class="gallery-overlay">

                            <div>

                                <div class="fw-bold">
                                    {{ $gallery->title }}
                                </div>

                                <small>
                                    Lihat Foto
                                </small>

                            </div>

                        </div>

                    </button>

                </div>


                <div
                    class="modal fade"
                    id="galleryModal{{ $gallery->id }}"
                    tabindex="-1"
                    aria-hidden="true"
                >

                    <div
                        class="
                            modal-dialog
                            modal-xl
                            modal-dialog-centered
                        "
                    >

                        <div
                            class="
                                modal-content
                                bg-dark
                                border-0
                            "
                        >

                            <div
                                class="
                                    modal-header
                                    border-0
                                "
                            >

                                <h5
                                    class="
                                        modal-title
                                        text-white
                                    "
                                >
                                    {{ $gallery->title }}
                                </h5>

                                <button
                                    type="button"
                                    class="
                                        btn-close
                                        btn-close-white
                                    "
                                    data-bs-dismiss="modal"
                                    aria-label="Tutup"
                                ></button>

                            </div>


                            <div class="modal-body p-0">

                                <img
                                    src="{{ asset(
                                        'storage/' .
                                        $gallery->image
                                    ) }}"
                                    alt="{{ $gallery->title }}"
                                    class="w-100"
                                    loading="lazy"
                                    decoding="async"
                                    style="
                                        max-height: 80vh;
                                        object-fit: contain;
                                    "
                                >

                            </div>


                            @if($gallery->description)

                                <div
                                    class="
                                        modal-footer
                                        border-0
                                        justify-content-start
                                    "
                                >

                                    <p
                                        class="
                                            text-white-50
                                            mb-0
                                        "
                                    >
                                        {{ $gallery->description }}
                                    </p>

                                </div>

                            @endif

                        </div>

                    </div>

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
                        Galeri belum tersedia.
                    </div>

                </div>

            @endforelse

        </div>

    </div>

</section>

@endsection