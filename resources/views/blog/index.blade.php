@extends('layouts.app')

@section(
    'title',
    'Blog & Berita - Umbul Kroman'
)

@section(
    'meta_description',
    'Informasi, cerita, berita, dan artikel terbaru dari Umbul Kroman.'
)

@section(
    'canonical',
    route('blog.public')
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
                    'name' => 'Blog & Berita',
                    'url' => route('blog.public'),
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
                    Informasi
                </span>

                <h1 class="section-title">
                    Blog & Berita
                </h1>

                <p class="section-description">
                    Informasi dan cerita terbaru
                    seputar Umbul Kroman.
                </p>

            </div>


            <div class="row g-4">

                @forelse($posts as $post)

                    <div
                        class="
                            col-md-6
                            col-lg-4
                            reveal
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

                                @else

                                    <div
                                        class="
                                            blog-card-image
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


                            <div class="blog-card-body">

                                @if($post->published_at)

                                    <div
                                        class="
                                            small
                                            text-muted
                                            mb-2
                                        "
                                    >

                                        {{ $post
                                            ->published_at
                                            ->format('d M Y')
                                        }}

                                    </div>

                                @endif


                                <h2
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

                                </h2>


                                <p class="text-muted mb-4">

                                    {{ \Illuminate\Support\Str::limit(
                                        $post->excerpt
                                            ?: strip_tags(
                                                $post->content
                                            ),
                                        120
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

                @empty

                    <div class="col-12">

                        <div
                            class="
                                text-center
                                py-5
                                text-muted
                            "
                        >

                            Belum ada artikel.

                        </div>

                    </div>

                @endforelse

            </div>


            @if($posts->hasPages())

                <div
                    class="
                        public-pagination
                        mt-5
                        d-flex
                        justify-content-center
                    "
                >

                    {{ $posts->links() }}

                </div>

            @endif

        </div>

    </section>

@endsection