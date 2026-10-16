@extends('layouts.app')

@section(
    'title',
    $post->title . ' - Umbul Kroman'
)

@section(
    'meta_description',
    \Illuminate\Support\Str::limit(
        strip_tags(
            $post->excerpt
                ?: $post->content
        ),
        160
    )
)

@section(
    'canonical',
    route(
        'blog.show.public',
        $post->slug
    )
)

@section(
    'meta_type',
    'article'
)

@if($post->image)

    @section(
        'meta_image',
        asset(
            'storage/' .
            $post->image
        )
    )

@endif


{{-- =========================================================
    ARTICLE STRUCTURED DATA
========================================================== --}}

@push('head')

    @php
        $articleUrl =
            route(
                'blog.show.public',
                $post->slug
            );

        $articleSchema = [
            '@context' =>
                'https://schema.org',

            '@type' =>
                'Article',

            '@id' =>
                $articleUrl . '#article',

            'mainEntityOfPage' => [
                '@type' =>
                    'WebPage',

                '@id' =>
                    $articleUrl,
            ],

            'headline' =>
                $post->title,

            'description' =>
                \Illuminate\Support\Str::limit(
                    strip_tags(
                        $post->excerpt
                            ?: $post->content
                    ),
                    300
                ),

            'url' =>
                $articleUrl,

            'inLanguage' =>
                'id-ID',

            'author' => [
                '@type' =>
                    'Organization',

                'name' =>
                    $siteProfile?->name
                    ?? 'Umbul Kroman',

                'url' =>
                    route('home'),
            ],

            'publisher' => [
                '@type' =>
                    'Organization',

                'name' =>
                    $siteProfile?->name
                    ?? 'Umbul Kroman',

                'url' =>
                    route('home'),
            ],
        ];


        if ($post->image) {

            $articleSchema['image'] = [
                asset(
                    'storage/' .
                    $post->image
                ),
            ];
        }


        if ($post->published_at) {

            $articleSchema['datePublished'] =
                $post
                    ->published_at
                    ->toIso8601String();
        }


        if ($post->updated_at) {

            $articleSchema['dateModified'] =
                $post
                    ->updated_at
                    ->toIso8601String();
        }


        if ($siteProfile?->logo) {

            $articleSchema[
                'publisher'
            ]['logo'] = [
                '@type' =>
                    'ImageObject',

                'url' =>
                    asset(
                        'storage/' .
                        $siteProfile->logo
                    ),
            ];
        }
    @endphp


    <script type="application/ld+json">
        {!! json_encode(
            $articleSchema,
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
                    'name' => 'Blog & Berita',
                    'url' => route(
                        'blog.public'
                    ),
                ],
                [
                    'name' => $post->title,
                    'url' => $articleUrl,
                ],
            ]"
        />

    </div>


    {{-- =========================================================
        ARTICLE HEADER
    ========================================================== --}}

    <section
        class="
            pt-3
            pb-4
        "
    >

        <div class="container">

            <div class="row justify-content-center">

                <div class="col-lg-9">

                    <div class="reveal">

                        <span class="section-kicker">
                            Blog & Berita
                        </span>


                        <h1
                            class="
                                display-5
                                fw-bold
                                mt-2
                                mb-3
                            "
                        >
                            {{ $post->title }}
                        </h1>


                        @if($post->published_at)

                            <div
                                class="
                                    text-muted
                                    mb-4
                                "
                            >

                                Dipublikasikan

                                {{ $post
                                    ->published_at
                                    ->format('d M Y')
                                }}

                            </div>

                        @endif


                        @if($post->excerpt)

                            <p
                                class="
                                    lead
                                    text-muted
                                    mb-0
                                "
                            >

                                {{ $post->excerpt }}

                            </p>

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- =========================================================
        FEATURED IMAGE
    ========================================================== --}}

    @if($post->image)

        <section class="pb-5">

            <div class="container">

                <div class="row justify-content-center">

                    <div class="col-lg-10">

                        <div
                            class="
                                overflow-hidden
                                rounded-4
                                shadow-sm
                            "
                        >

                            <x-responsive-image
                                :src="$post->image"
                                :thumbnail="$post->thumbnail"
                                :alt="$post->title"
                                class="w-100 d-block"
                                sizes="
                                    (max-width: 991px) 100vw,
                                    83vw
                                "
                                loading="eager"
                                fetchpriority="high"
                                style="
                                    width: 100%;
                                    max-height: 680px;
                                    object-fit: contain;
                                    background: #f3f7f4;
                                "
                            />

                        </div>

                    </div>

                </div>

            </div>

        </section>

    @endif


    {{-- =========================================================
        ARTICLE CONTENT
    ========================================================== --}}

    <section class="pb-5">

        <div class="container">

            <div class="row justify-content-center">

                <div class="col-lg-8">

                    <article
                        class="
                            blog-content
                            fs-6
                            lh-lg
                        "
                    >

                        {!! nl2br(
                            e(
                                $post->content
                            )
                        ) !!}

                    </article>

                </div>

            </div>

        </div>

    </section>


    {{-- =========================================================
        RELATED ARTICLES
    ========================================================== --}}

    @if(
        isset($relatedPosts) &&
        $relatedPosts->isNotEmpty()
    )

        <section
            class="
                section-space
                bg-light
            "
        >

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
                            Baca Juga
                        </span>

                        <h2
                            class="
                                section-title
                                mb-0
                            "
                        >
                            Artikel Lainnya
                        </h2>

                    </div>


                    <a
                        href="{{ route(
                            'blog.public'
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
                        $relatedPosts
                        as $relatedPost
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
                                    blog-card
                                    h-100
                                "
                            >

                                <a
                                    href="{{ route(
                                        'blog.show.public',
                                        $relatedPost->slug
                                    ) }}"
                                    class="d-flex"
                                    aria-label="{{ $relatedPost->title }}"
                                >

                                    @if($relatedPost->image)

                                        <img
                                            src="{{ asset(
                                                'storage/' .
                                                $relatedPost->image
                                            ) }}"
                                            alt="{{ $relatedPost->title }}"
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

                                    @if(
                                        $relatedPost->published_at
                                    )

                                        <div
                                            class="
                                                small
                                                text-muted
                                                mb-2
                                            "
                                        >

                                            {{ $relatedPost
                                                ->published_at
                                                ->format('d M Y')
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
                                                $relatedPost->slug
                                            ) }}"
                                            class="
                                                text-decoration-none
                                                text-dark
                                            "
                                        >

                                            {{ $relatedPost->title }}

                                        </a>

                                    </h3>


                                    <p
                                        class="
                                            text-muted
                                            mb-4
                                        "
                                    >

                                        {{ \Illuminate\Support\Str::limit(
                                            $relatedPost->excerpt
                                                ?: strip_tags(
                                                    $relatedPost->content
                                                ),
                                            110
                                        ) }}

                                    </p>


                                    <a
                                        href="{{ route(
                                            'blog.show.public',
                                            $relatedPost->slug
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

            </div>

        </section>

    @endif


    {{-- =========================================================
        CTA
    ========================================================== --}}

    <section class="section-space">

        <div class="container">

            <div class="row justify-content-center">

                <div class="col-lg-8">

                    <div
                        class="
                            bg-light
                            rounded-4
                            text-center
                            p-4
                            p-lg-5
                            reveal
                        "
                    >

                        <span class="section-kicker">
                            Informasi
                        </span>


                        <h2
                            class="
                                h3
                                fw-bold
                                mb-3
                            "
                        >
                            Baca Artikel Lainnya
                        </h2>


                        <p class="text-muted mb-4">

                            Temukan berita,
                            informasi,
                            dan cerita terbaru
                            dari Umbul Kroman.

                        </p>


                        <a
                            href="{{ route(
                                'blog.public'
                            ) }}"
                            class="
                                btn
                                btn-success
                                rounded-pill
                                px-4
                            "
                        >
                            Semua Artikel
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </section>

@endsection