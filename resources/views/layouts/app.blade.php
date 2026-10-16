@php
    $defaultTitle =
        $siteSettings?->site_title
        ?? $siteProfile?->name
        ?? 'Umbul Kroman';

    $pageTitle =
        trim(
            $__env->yieldContent('title')
        );

    if (!$pageTitle) {
        $pageTitle = $defaultTitle;
    }

    $defaultDescription =
        $siteSettings?->meta_description
        ?: (
            $siteProfile?->description
                ? \Illuminate\Support\Str::limit(
                    strip_tags(
                        $siteProfile->description
                    ),
                    160
                )
                : 'Website resmi Umbul Kroman. Informasi wisata, destinasi, berita, galeri, dan profil desa.'
        );

    $pageDescription =
        trim(
            $__env->yieldContent(
                'meta_description'
            )
        );

    if (!$pageDescription) {
        $pageDescription =
            $defaultDescription;
    }

    $pageCanonical =
        trim(
            $__env->yieldContent(
                'canonical'
            )
        );

    if (!$pageCanonical) {
        $pageCanonical =
            url()->current();
    }

    $pageType =
        trim(
            $__env->yieldContent(
                'meta_type'
            )
        );

    if (!$pageType) {
        $pageType = 'website';
    }

    $pageRobots =
        trim(
            $__env->yieldContent(
                'robots'
            )
        );

    if (!$pageRobots) {
        $pageRobots =
            'index, follow, max-image-preview:large';
    }

    $pageImage =
        trim(
            $__env->yieldContent(
                'meta_image'
            )
        );

    if (
        !$pageImage &&
        $siteProfile?->hero_image
    ) {
        $pageImage =
            asset(
                'storage/' .
                $siteProfile->hero_image
            );
    }

    $faviconUrl =
        $siteSettings?->favicon
            ? asset(
                'storage/' .
                $siteSettings->favicon
            )
            : null;

    $isHome =
        request()->routeIs(
            'home'
        );

    $heroPreloadUrl =
        $isHome &&
        $siteProfile?->hero_image
            ? asset(
                'storage/' .
                $siteProfile->hero_image
            )
            : null;
@endphp

<!DOCTYPE html>

<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        http-equiv="X-UA-Compatible"
        content="IE=edge"
    >


    {{-- =========================================================
        BASIC SEO
    ========================================================== --}}

    <title>{{ $pageTitle }}</title>

    <meta
        name="description"
        content="{{ $pageDescription }}"
    >

    @if($siteSettings?->meta_keywords)

        <meta
            name="keywords"
            content="{{ $siteSettings->meta_keywords }}"
        >

    @endif

    <meta
        name="robots"
        content="{{ $pageRobots }}"
    >

    <meta
        name="author"
        content="{{ $defaultTitle }}"
    >


    {{-- =========================================================
        CANONICAL
    ========================================================== --}}

    <link
        rel="canonical"
        href="{{ $pageCanonical }}"
    >


    {{-- =========================================================
        FAVICON
    ========================================================== --}}

    @if($faviconUrl)

        <link
            rel="icon"
            type="image/webp"
            href="{{ $faviconUrl }}"
        >

        <link
            rel="apple-touch-icon"
            href="{{ $faviconUrl }}"
        >

    @endif


    {{-- =========================================================
        PRELOAD HERO HOME
    ========================================================== --}}

    @if($heroPreloadUrl)

        <link
            rel="preload"
            as="image"
            href="{{ $heroPreloadUrl }}"
            fetchpriority="high"
        >

    @endif


    {{-- =========================================================
        OPEN GRAPH
    ========================================================== --}}

    <meta
        property="og:locale"
        content="id_ID"
    >

    <meta
        property="og:type"
        content="{{ $pageType }}"
    >

    <meta
        property="og:title"
        content="{{ $pageTitle }}"
    >

    <meta
        property="og:description"
        content="{{ $pageDescription }}"
    >

    <meta
        property="og:url"
        content="{{ $pageCanonical }}"
    >

    <meta
        property="og:site_name"
        content="{{ $defaultTitle }}"
    >

    @if($pageImage)

        <meta
            property="og:image"
            content="{{ $pageImage }}"
        >

        <meta
            property="og:image:alt"
            content="{{ $pageTitle }}"
        >

    @endif


    {{-- =========================================================
        TWITTER / X
    ========================================================== --}}

    <meta
        name="twitter:card"
        content="{{ $pageImage ? 'summary_large_image' : 'summary' }}"
    >

    <meta
        name="twitter:title"
        content="{{ $pageTitle }}"
    >

    <meta
        name="twitter:description"
        content="{{ $pageDescription }}"
    >

    @if($pageImage)

        <meta
            name="twitter:image"
            content="{{ $pageImage }}"
        >

    @endif


    {{-- =========================================================
        VITE
    ========================================================== --}}

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])


    {{-- =========================================================
        EXTRA HEAD / STRUCTURED DATA
    ========================================================== --}}

    @stack('head')

</head>


<body>

    {{-- =========================================================
        NAVBAR
    ========================================================== --}}

    <nav
        class="
            navbar
            navbar-expand-lg
            navbar-dark
            site-navbar
            sticky-top
        "
    >

        <div class="container">

            <a
                class="
                    navbar-brand
                    navbar-brand-wrapper
                "
                href="{{ route('home') }}"
            >

                @if($siteProfile?->logo)

                    <img
                        src="{{ asset(
                            'storage/' .
                            $siteProfile->logo
                        ) }}"
                        alt="{{ $siteProfile->name ?? 'Umbul Kroman' }}"
                        class="navbar-logo"
                        width="46"
                        height="46"
                        loading="eager"
                        decoding="async"
                    >

                @endif


                <span class="navbar-brand-text">

                    <span class="navbar-site-name">

                        {{ $siteProfile?->name
                            ?? 'Umbul Kroman'
                        }}

                    </span>

                    <span class="navbar-site-caption">
                        Wisata & Informasi Desa
                    </span>

                </span>

            </a>


            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarMain"
                aria-controls="navbarMain"
                aria-expanded="false"
                aria-label="Buka navigasi"
            >

                <span class="navbar-toggler-icon"></span>

            </button>


            <div
                class="
                    collapse
                    navbar-collapse
                "
                id="navbarMain"
            >

                <ul
                    class="
                        navbar-nav
                        ms-auto
                        align-items-lg-center
                    "
                >

                    <li class="nav-item">

                        <a
                            class="
                                nav-link
                                {{ request()->routeIs('home')
                                    ? 'active'
                                    : ''
                                }}
                            "
                            href="{{ route('home') }}"
                        >
                            Beranda
                        </a>

                    </li>


                    <li class="nav-item">

                        <a
                            class="
                                nav-link
                                {{ request()->routeIs('profile')
                                    ? 'active'
                                    : ''
                                }}
                            "
                            href="{{ route('profile') }}"
                        >
                            Profil
                        </a>

                    </li>


                    <li class="nav-item">

                        <a
                            class="
                                nav-link
                                {{ request()->routeIs(
                                    'destinations.public',
                                    'destinations.show.public'
                                )
                                    ? 'active'
                                    : ''
                                }}
                            "
                            href="{{ route(
                                'destinations.public'
                            ) }}"
                        >
                            Destinasi
                        </a>

                    </li>


                    <li class="nav-item">

                        <a
                            class="
                                nav-link
                                {{ request()->routeIs(
                                    'blog.public',
                                    'blog.show.public'
                                )
                                    ? 'active'
                                    : ''
                                }}
                            "
                            href="{{ route(
                                'blog.public'
                            ) }}"
                        >
                            Blog
                        </a>

                    </li>


                    <li class="nav-item">

                        <a
                            class="
                                nav-link
                                {{ request()->routeIs('gallery')
                                    ? 'active'
                                    : ''
                                }}
                            "
                            href="{{ route('gallery') }}"
                        >
                            Galeri
                        </a>

                    </li>


                    {{-- SEARCH --}}
                    <li class="nav-item ms-lg-2">

                        <a
                            href="{{ route('search') }}"
                            class="
                                nav-link
                                navbar-search-link
                                {{ request()->routeIs('search')
                                    ? 'active'
                                    : ''
                                }}
                            "
                            aria-label="Cari destinasi dan artikel"
                        >

                            <span
                                class="navbar-search-icon"
                                aria-hidden="true"
                            >
                                ⌕
                            </span>

                            <span class="d-lg-none ms-2">
                                Cari
                            </span>

                        </a>

                    </li>

                </ul>

            </div>

        </div>

    </nav>


    {{-- =========================================================
        MAIN
    ========================================================== --}}

    <main>

        @yield('content')

    </main>


    {{-- =========================================================
        FOOTER
    ========================================================== --}}

    <footer class="site-footer">

        <div class="site-footer-main">

            <div class="container">

                <div class="row g-5">

                    {{-- BRAND --}}
                    <div
                        class="
                            col-lg-5
                            col-md-6
                        "
                    >

                        <div class="footer-brand">

                            @if($siteProfile?->logo)

                                <img
                                    src="{{ asset(
                                        'storage/' .
                                        $siteProfile->logo
                                    ) }}"
                                    alt="{{ $siteProfile->name ?? 'Umbul Kroman' }}"
                                    class="footer-logo"
                                    width="58"
                                    height="58"
                                    loading="lazy"
                                    decoding="async"
                                >

                            @endif


                            <div>

                                <h5 class="mb-1">

                                    {{ $siteProfile?->name
                                        ?? 'Umbul Kroman'
                                    }}

                                </h5>


                                @if($siteProfile?->tagline)

                                    <div
                                        class="
                                            small
                                            text-white-50
                                        "
                                    >
                                        {{ $siteProfile->tagline }}
                                    </div>

                                @endif

                            </div>

                        </div>


                        @if($siteProfile?->description)

                            <p
                                class="
                                    mt-4
                                    mb-0
                                    text-white-50
                                    lh-lg
                                "
                            >

                                {{ \Illuminate\Support\Str::limit(
                                    strip_tags(
                                        $siteProfile->description
                                    ),
                                    200
                                ) }}

                            </p>

                        @endif

                    </div>


                    {{-- MENU --}}
                    <div
                        class="
                            col-lg-2
                            col-md-6
                        "
                    >

                        <h5 class="mb-4">
                            Menu
                        </h5>

                        <ul class="footer-links">

                            <li>
                                <a href="{{ route('home') }}">
                                    Beranda
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('profile') }}">
                                    Profil
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('destinations.public') }}">
                                    Destinasi
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('blog.public') }}">
                                    Blog
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('gallery') }}">
                                    Galeri
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('search') }}">
                                    Pencarian
                                </a>
                            </li>

                        </ul>

                    </div>


                    {{-- CONTACT --}}
                    <div
                        class="
                            col-lg-3
                            col-md-6
                        "
                    >

                        <h5 class="mb-4">
                            Kontak
                        </h5>


                        @if($siteProfile?->address)

                            <p class="small">
                                {{ $siteProfile->address }}
                            </p>

                        @endif


                        @if($siteProfile?->phone)

                            <p class="small">

                                <a
                                    href="tel:{{ preg_replace(
                                        '/[^0-9+]/',
                                        '',
                                        $siteProfile->phone
                                    ) }}"
                                >
                                    {{ $siteProfile->phone }}
                                </a>

                            </p>

                        @endif


                        @if($siteProfile?->email)

                            <p class="small">

                                <a
                                    href="mailto:{{ $siteProfile->email }}"
                                >
                                    {{ $siteProfile->email }}
                                </a>

                            </p>

                        @endif

                    </div>


                    {{-- SOCIAL --}}
                    <div
                        class="
                            col-lg-2
                            col-md-6
                        "
                    >

                        <h5 class="mb-4">
                            Media Sosial
                        </h5>


                        <div class="social-links">

                            @if($siteSettings?->instagram_url)

                                <a
                                    href="{{ $siteSettings->instagram_url }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="social-link"
                                >
                                    Instagram
                                </a>

                            @endif


                            @if($siteSettings?->facebook_url)

                                <a
                                    href="{{ $siteSettings->facebook_url }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="social-link"
                                >
                                    Facebook
                                </a>

                            @endif


                            @if($siteSettings?->tiktok_url)

                                <a
                                    href="{{ $siteSettings->tiktok_url }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="social-link"
                                >
                                    TikTok
                                </a>

                            @endif


                            @if($siteSettings?->youtube_url)

                                <a
                                    href="{{ $siteSettings->youtube_url }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="social-link"
                                >
                                    YouTube
                                </a>

                            @endif

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- FOOTER BOTTOM --}}
        <div class="footer-bottom">

            <div class="container">

                <div
                    class="
                        d-flex
                        flex-column
                        flex-md-row
                        justify-content-between
                        align-items-md-center
                        gap-2
                        small
                    "
                >

                    <div>

                        © {{ date('Y') }}

                        {{ $siteProfile?->name
                            ?? 'Umbul Kroman'
                        }}.

                        All rights reserved.

                    </div>


                    @if($siteSettings?->footer_text)

                        <div>
                            {{ $siteSettings->footer_text }}
                        </div>

                    @endif

                </div>

            </div>

        </div>

    </footer>


    {{-- =========================================================
        WHATSAPP
    ========================================================== --}}

    @if(
        $siteSettings?->show_whatsapp &&
        $siteSettings?->whatsappUrl()
    )

        <a
            href="{{ $siteSettings->whatsappUrl() }}"
            target="_blank"
            rel="noopener noreferrer"
            class="whatsapp-floating"
            aria-label="Hubungi melalui WhatsApp"
        >

            <svg
                viewBox="0 0 24 24"
                fill="currentColor"
                aria-hidden="true"
            >

                <path
                    d="M20.52 3.48A11.84 11.84 0 0 0 12.08 0C5.5 0 .16 5.34.16 11.92c0 2.1.55 4.15 1.6 5.96L.06 24l6.27-1.64a11.9 11.9 0 0 0 5.75 1.46h.01c6.57 0 11.91-5.34 11.91-11.92 0-3.18-1.24-6.17-3.48-8.42ZM12.09 21.8h-.01a9.88 9.88 0 0 1-5.04-1.38l-.36-.21-3.72.98.99-3.63-.24-.37a9.86 9.86 0 0 1-1.51-5.27c0-5.46 4.44-9.9 9.91-9.9a9.84 9.84 0 0 1 7 2.9 9.83 9.83 0 0 1 2.9 7c-.01 5.46-4.45 9.9-9.92 9.9Zm5.43-7.42c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.94 1.17-.17.2-.35.22-.64.07-.3-.15-1.25-.46-2.38-1.47-.88-.78-1.47-1.75-1.64-2.05-.17-.3-.02-.46.13-.61.14-.14.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.08-.15-.67-1.62-.92-2.22-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.49s1.07 2.89 1.22 3.09c.15.2 2.11 3.22 5.11 4.51.71.31 1.27.49 1.7.63.72.23 1.37.2 1.89.12.58-.09 1.76-.72 2.01-1.42.25-.7.25-1.3.17-1.42-.07-.12-.27-.2-.57-.35Z"
                />

            </svg>

        </a>

    @endif


    {{-- =========================================================
        BACK TO TOP
    ========================================================== --}}

    <button
        type="button"
        class="back-to-top"
        id="backToTop"
        aria-label="Kembali ke atas"
    >
        ↑
    </button>


    @stack('scripts')

</body>

</html>