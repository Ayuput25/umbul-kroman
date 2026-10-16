@extends('layouts.app')

@section(
    'title',
    $query
        ? 'Hasil Pencarian: ' .
            $query .
            ' - Umbul Kroman'
        : 'Pencarian - Umbul Kroman'
)

@section(
    'meta_description',
    $query
        ? 'Hasil pencarian untuk ' .
            $query .
            ' di website Umbul Kroman.'
        : 'Cari destinasi wisata dan artikel di Umbul Kroman.'
)

@section(
    'canonical',
    route('search')
)

@section(
    'robots',
    'noindex, follow'
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
                    'name' => 'Pencarian',
                    'url' => route('search'),
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
                "
            >

                <span class="section-kicker">
                    Pencarian
                </span>

                <h1 class="section-title">
                    Cari Informasi
                </h1>

                <p class="section-description">

                    Cari destinasi wisata
                    atau artikel di Umbul Kroman.

                </p>

            </div>


            {{-- SEARCH FORM --}}
            <div
                class="
                    row
                    justify-content-center
                    mb-5
                "
            >

                <div class="col-lg-8">

                    <form
                        action="{{ route('search') }}"
                        method="GET"
                        class="public-search-form"
                    >

                        <div class="public-search-box">

                            <input
                                type="search"
                                name="q"
                                value="{{ $query }}"
                                class="public-search-input"
                                placeholder="Cari destinasi atau artikel..."
                                autocomplete="off"
                                maxlength="100"
                                required
                            >

                            <button
                                type="submit"
                                class="public-search-button"
                            >
                                Cari
                            </button>

                        </div>

                    </form>

                </div>

            </div>


            @if($query === '')

                <div
                    class="
                        text-center
                        py-5
                        text-muted
                    "
                >

                    Masukkan kata kunci
                    untuk mulai mencari.

                </div>


            @elseif($totalResults === 0)

                <div
                    class="
                        public-search-empty
                        text-center
                    "
                >

                    <div
                        class="
                            public-search-empty-icon
                        "
                    >
                        ?
                    </div>


                    <h2
                        class="
                            h4
                            fw-bold
                            mb-3
                        "
                    >
                        Tidak Ada Hasil
                    </h2>


                    <p class="text-muted mb-0">

                        Tidak ditemukan destinasi
                        atau artikel untuk

                        <strong>
                            “{{ $query }}”
                        </strong>.

                    </p>

                </div>


            @else

                {{-- TOTAL --}}
                <div
                    class="
                        d-flex
                        flex-column
                        flex-md-row
                        justify-content-between
                        align-items-md-center
                        gap-2
                        mb-5
                    "
                >

                    <div>

                        <span class="text-muted">
                            Hasil pencarian untuk
                        </span>

                        <strong>
                            “{{ $query }}”
                        </strong>

                    </div>


                    <div class="public-search-count">

                        {{ $totalResults }}
                        hasil ditemukan

                    </div>

                </div>


                {{-- DESTINATIONS --}}
                @if(
                    $destinations &&
                    $destinationTotal > 0
                )

                    <section class="mb-5">

                        <div
                            class="
                                d-flex
                                justify-content-between
                                align-items-end
                                gap-3
                                mb-4
                            "
                        >

                            <div>

                                <span class="section-kicker">
                                    Destinasi
                                </span>

                                <h2
                                    class="
                                        h3
                                        fw-bold
                                        mb-0
                                    "
                                >
                                    Destinasi Ditemukan
                                </h2>

                            </div>


                            <span class="text-muted">

                                {{ $destinationTotal }}
                                hasil

                            </span>

                        </div>


                        <div class="row g-4">

                            @foreach(
                                $destinations
                                as $destination
                            )

                                <div
                                    class="
                                        col-md-6
                                        col-lg-4
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

                                            @endif

                                        </a>


                                        <div
                                            class="
                                                destination-card-body
                                            "
                                        >

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
                                                        $destination->slug
                                                    ) }}"
                                                    class="
                                                        text-decoration-none
                                                        text-dark
                                                    "
                                                >

                                                    {{ $destination->name }}

                                                </a>

                                            </h3>


                                            @if(
                                                $destination->description
                                            )

                                                <p
                                                    class="
                                                        text-muted
                                                        mb-4
                                                    "
                                                >

                                                    {{ \Illuminate\Support\Str::limit(
                                                        strip_tags(
                                                            $destination->description
                                                        ),
                                                        110
                                                    ) }}

                                                </p>

                                            @endif


                                            <a
                                                href="{{ route(
                                                    'destinations.show.public',
                                                    $destination->slug
                                                ) }}"
                                                class="
                                                    text-decoration-none
                                                    fw-semibold
                                                    text-success
                                                    mt-auto
                                                "
                                            >
                                                Lihat Detail →
                                            </a>

                                        </div>

                                    </article>

                                </div>

                            @endforeach

                        </div>


                        @if(
                            $destinations->hasPages()
                        )

                            <div
                                class="
                                    public-pagination
                                    mt-4
                                    d-flex
                                    justify-content-center
                                "
                            >

                                {{ $destinations->links() }}

                            </div>

                        @endif

                    </section>

                @endif


                {{-- BLOG --}}
                @if(
                    $posts &&
                    $postTotal > 0
                )

                    <section>

                        <div
                            class="
                                d-flex
                                justify-content-between
                                align-items-end
                                gap-3
                                mb-4
                            "
                        >

                            <div>

                                <span class="section-kicker">
                                    Blog
                                </span>

                                <h2
                                    class="
                                        h3
                                        fw-bold
                                        mb-0
                                    "
                                >
                                    Artikel Ditemukan
                                </h2>

                            </div>


                            <span class="text-muted">

                                {{ $postTotal }}
                                hasil

                            </span>

                        </div>


                        <div class="row g-4">

                            @foreach(
                                $posts
                                as $post
                            )

                                <div
                                    class="
                                        col-md-6
                                        col-lg-4
                                    "
                                >

                                    <article
                                        class="
                                            blog-card
                                            h-100
                                        "
                                    >

                                        <a
                                            href="{{ route(
                                                'blog.show.public',
                                                $post->slug
                                            ) }}"
                                            class="d-flex"
                                        >

                                            @if($post->image)

                                                <img
                                                    src="{{ asset(
                                                        'storage/' .
                                                        $post->image
                                                    ) }}"
                                                    alt="{{ $post->title }}"
                                                    class="blog-card-image"
                                                    loading="lazy"
                                                    decoding="async"
                                                >

                                            @endif

                                        </a>


                                        <div
                                            class="
                                                blog-card-body
                                            "
                                        >

                                            @if(
                                                $post->published_at
                                            )

                                                <div
                                                    class="
                                                        small
                                                        text-muted
                                                        mb-2
                                                    "
                                                >

                                                    {{ $post
                                                        ->published_at
                                                        ->format(
                                                            'd M Y'
                                                        )
                                                    }}

                                                </div>

                                            @endif


                                            <h3
                                                class="
                                                    h5
                                                    fw-bold
                                                    mb-3
                                                "
                                            >

                                                <a
                                                    href="{{ route(
                                                        'blog.show.public',
                                                        $post->slug
                                                    ) }}"
                                                    class="
                                                        text-decoration-none
                                                        text-dark
                                                    "
                                                >

                                                    {{ $post->title }}

                                                </a>

                                            </h3>


                                            <p
                                                class="
                                                    text-muted
                                                    mb-4
                                                "
                                            >

                                                {{ \Illuminate\Support\Str::limit(
                                                    $post->excerpt
                                                        ?: strip_tags(
                                                            $post->content
                                                        ),
                                                    110
                                                ) }}

                                            </p>


                                            <a
                                                href="{{ route(
                                                    'blog.show.public',
                                                    $post->slug
                                                ) }}"
                                                class="
                                                    text-decoration-none
                                                    fw-semibold
                                                    text-success
                                                    mt-auto
                                                "
                                            >
                                                Baca Artikel →
                                            </a>

                                        </div>

                                    </article>

                                </div>

                            @endforeach

                        </div>


                        @if($posts->hasPages())

                            <div
                                class="
                                    public-pagination
                                    mt-4
                                    d-flex
                                    justify-content-center
                                "
                            >

                                {{ $posts->links() }}

                            </div>

                        @endif

                    </section>

                @endif

            @endif

        </div>

    </section>

@endsection