<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="robots"
        content="noindex, nofollow"
    >

    <title>
        @yield('title', 'Admin - Umbul Kroman')
    </title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    @stack('styles')


    <style>

        :root {
            --admin-primary: #168653;
            --admin-primary-dark: #0f6a42;

            --admin-bg: #f4f7f5;
            --admin-card: #ffffff;

            --admin-text: #26382f;
            --admin-muted: #708078;

            --admin-border: #e3ebe6;

            --admin-sidebar: #10261b;
            --admin-sidebar-secondary: #143626;

            --admin-sidebar-width: 260px;
        }


        /*
        |--------------------------------------------------------------------------
        | BASE
        |--------------------------------------------------------------------------
        */

        html,
        body {
            min-height: 100%;
        }

        body {
            margin: 0;

            color:
                var(--admin-text);

            background:
                var(--admin-bg);
        }

        .admin-shell {
            min-height: 100vh;
        }


        /*
        |--------------------------------------------------------------------------
        | SIDEBAR
        |--------------------------------------------------------------------------
        */

        .admin-sidebar {
            position: fixed;

            top: 0;
            bottom: 0;
            left: 0;

            z-index: 1080;

            width:
                var(--admin-sidebar-width);

            overflow-x: hidden;
            overflow-y: auto;

            color: #ffffff;

            background:
                linear-gradient(
                    180deg,
                    var(--admin-sidebar),
                    var(--admin-sidebar-secondary)
                );

            transition:
                transform .25s ease;
        }


        .admin-sidebar::-webkit-scrollbar {
            width: 5px;
        }


        .admin-sidebar::-webkit-scrollbar-thumb {
            background:
                rgba(
                    255,
                    255,
                    255,
                    .15
                );

            border-radius: 999px;
        }


        /*
        |--------------------------------------------------------------------------
        | BRAND
        |--------------------------------------------------------------------------
        */

        .admin-sidebar-brand {
            min-height: 78px;

            display: flex;
            align-items: center;

            gap: 12px;

            padding:
                18px
                20px;

            border-bottom:
                1px solid
                rgba(
                    255,
                    255,
                    255,
                    .08
                );
        }


        .admin-sidebar-logo {
            width: 44px;
            height: 44px;

            flex: 0 0 44px;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #ffffff;

            background:
                var(--admin-primary);

            border-radius: 13px;

            font-size: 15px;
            font-weight: 800;
        }


        .admin-sidebar-brand-text {
            min-width: 0;

            flex: 1;
        }


        .admin-sidebar-title {
            color: #ffffff;

            font-size: 15px;
            font-weight: 800;

            line-height: 1.2;
        }


        .admin-sidebar-subtitle {
            display: block;

            margin-top: 4px;

            color:
                rgba(
                    255,
                    255,
                    255,
                    .55
                );

            font-size: 11px;
        }


        /*
        |--------------------------------------------------------------------------
        | SIDEBAR CLOSE
        |--------------------------------------------------------------------------
        */

        .admin-sidebar-close {
            display: none;

            width: 38px;
            height: 38px;

            flex: 0 0 38px;

            align-items: center;
            justify-content: center;

            padding: 0;

            color:
                rgba(
                    255,
                    255,
                    255,
                    .75
                );

            background:
                transparent;

            border: 0;

            border-radius: 10px;

            font-size: 29px;

            line-height: 1;

            cursor: pointer;
        }


        .admin-sidebar-close:hover {
            color: #ffffff;

            background:
                rgba(
                    255,
                    255,
                    255,
                    .08
                );
        }


        /*
        |--------------------------------------------------------------------------
        | MENU
        |--------------------------------------------------------------------------
        */

        .admin-menu {
            padding:
                18px
                14px;
        }


        .admin-menu-label {
            padding:
                10px
                12px
                8px;

            color:
                rgba(
                    255,
                    255,
                    255,
                    .42
                );

            font-size: 10px;
            font-weight: 700;

            letter-spacing: .1em;

            text-transform: uppercase;
        }


        .admin-menu-link {
            min-height: 46px;

            display: flex;
            align-items: center;

            gap: 12px;

            margin-bottom: 4px;

            padding:
                10px
                12px;

            color:
                rgba(
                    255,
                    255,
                    255,
                    .74
                );

            border-radius: 12px;

            text-decoration: none;

            transition:
                color .2s ease,
                background .2s ease;
        }


        .admin-menu-link:hover {
            color: #ffffff;

            background:
                rgba(
                    255,
                    255,
                    255,
                    .07
                );
        }


        .admin-menu-link.active {
            color: #ffffff;

            background:
                var(--admin-primary);

            box-shadow:
                0 8px 20px
                rgba(
                    0,
                    0,
                    0,
                    .15
                );
        }


        .admin-menu-icon {
            width: 30px;
            height: 30px;

            flex: 0 0 30px;

            display: flex;
            align-items: center;
            justify-content: center;

            color: inherit;

            background:
                rgba(
                    255,
                    255,
                    255,
                    .07
                );

            border-radius: 9px;

            font-size: 13px;
            font-weight: 800;
        }


        .admin-menu-link.active
        .admin-menu-icon {
            background:
                rgba(
                    255,
                    255,
                    255,
                    .16
                );
        }


        /*
        |--------------------------------------------------------------------------
        | MAIN
        |--------------------------------------------------------------------------
        */

        .admin-main {
            min-height: 100vh;

            margin-left:
                var(--admin-sidebar-width);

            transition:
                margin-left .25s ease;
        }


        /*
        |--------------------------------------------------------------------------
        | TOPBAR
        |--------------------------------------------------------------------------
        */

        .admin-topbar {
            position: sticky;

            top: 0;

            z-index: 1070;

            min-height: 78px;

            display: flex;
            align-items: center;

            background:
                rgba(
                    255,
                    255,
                    255,
                    .94
                );

            backdrop-filter:
                blur(12px);

            border-bottom:
                1px solid
                var(--admin-border);
        }


        .admin-topbar-inner {
            width: 100%;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 15px;

            padding:
                0
                28px;
        }


        /*
        |--------------------------------------------------------------------------
        | HAMBURGER
        |--------------------------------------------------------------------------
        */

        .admin-sidebar-toggle {
            display: none;

            width: 46px;
            height: 46px;

            flex: 0 0 46px;

            align-items: center;
            justify-content: center;

            padding: 0;

            color:
                var(--admin-text);

            background: #ffffff;

            border:
                1px solid
                var(--admin-border);

            border-radius: 12px;

            font-size: 24px;

            line-height: 1;

            cursor: pointer;

            position: relative;

            z-index: 1100;
        }


        .admin-sidebar-toggle:hover {
            background:
                #f4f7f5;
        }


        .admin-page-title {
            margin: 0;

            color:
                var(--admin-text);

            font-size: 18px;
            font-weight: 800;
        }


        .admin-page-subtitle {
            margin-top: 2px;

            color:
                var(--admin-muted);

            font-size: 12px;
        }


        /*
        |--------------------------------------------------------------------------
        | USER
        |--------------------------------------------------------------------------
        */

        .admin-user-button {
            display: flex;
            align-items: center;

            gap: 10px;

            padding:
                6px
                10px
                6px
                7px;

            color:
                var(--admin-text);

            background: #ffffff;

            border:
                1px solid
                var(--admin-border);

            border-radius: 13px;
        }


        .admin-user-avatar {
            width: 36px;
            height: 36px;

            flex: 0 0 36px;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #ffffff;

            background:
                var(--admin-primary);

            border-radius: 10px;

            font-weight: 800;
        }


        .admin-user-info {
            text-align: left;

            line-height: 1.15;
        }


        .admin-user-name {
            display: block;

            max-width: 170px;

            overflow: hidden;

            font-size: 13px;
            font-weight: 700;

            text-overflow: ellipsis;

            white-space: nowrap;
        }


        .admin-user-email {
            display: block;

            max-width: 190px;

            margin-top: 3px;

            overflow: hidden;

            color:
                var(--admin-muted);

            font-size: 10px;

            text-overflow: ellipsis;

            white-space: nowrap;
        }


        /*
        |--------------------------------------------------------------------------
        | CONTENT
        |--------------------------------------------------------------------------
        */

        .admin-content {
            padding: 28px;
        }


        /*
        |--------------------------------------------------------------------------
        | CARD
        |--------------------------------------------------------------------------
        */

        .admin-card {
            background:
                var(--admin-card);

            border:
                1px solid
                var(--admin-border);

            border-radius: 18px;

            box-shadow:
                0 10px 30px
                rgba(
                    30,
                    70,
                    48,
                    .05
                );
        }


        .admin-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 15px;

            padding:
                20px
                22px;

            border-bottom:
                1px solid
                var(--admin-border);
        }


        .admin-card-body {
            padding: 22px;
        }


        /*
        |--------------------------------------------------------------------------
        | STAT CARD
        |--------------------------------------------------------------------------
        */

        .admin-stat-card {
            position: relative;

            height: 100%;

            overflow: hidden;

            padding: 24px;

            background: #ffffff;

            border:
                1px solid
                var(--admin-border);

            border-radius: 18px;

            box-shadow:
                0 10px 30px
                rgba(
                    30,
                    70,
                    48,
                    .05
                );
        }


        .admin-stat-card::after {
            content: "";

            position: absolute;

            top: -40px;
            right: -35px;

            width: 100px;
            height: 100px;

            background:
                rgba(
                    22,
                    134,
                    83,
                    .08
                );

            border-radius: 50%;
        }


        .admin-stat-label {
            color:
                var(--admin-muted);

            font-size: 13px;
            font-weight: 600;
        }


        .admin-stat-value {
            margin-top: 10px;

            font-size: 34px;
            font-weight: 900;
        }


        .admin-stat-meta {
            margin-top: 8px;

            color:
                var(--admin-primary);

            font-size: 12px;
            font-weight: 700;
        }


        /*
        |--------------------------------------------------------------------------
        | TABLE
        |--------------------------------------------------------------------------
        */

        .table {
            margin-bottom: 0;
        }


        .table thead th {
            color:
                var(--admin-muted);

            background:
                #f8faf9;

            font-size: 11px;
            font-weight: 700;

            text-transform: uppercase;

            letter-spacing: .05em;

            border-bottom:
                1px solid
                var(--admin-border);
        }


        .table tbody td {
            vertical-align: middle;

            border-color:
                var(--admin-border);
        }


        /*
        |--------------------------------------------------------------------------
        | BUTTON
        |--------------------------------------------------------------------------
        */

        .btn-admin-primary {
            color: #ffffff;

            background:
                var(--admin-primary);

            border-color:
                var(--admin-primary);

            border-radius: 11px;

            font-weight: 700;
        }


        .btn-admin-primary:hover {
            color: #ffffff;

            background:
                var(--admin-primary-dark);

            border-color:
                var(--admin-primary-dark);
        }


        /*
        |--------------------------------------------------------------------------
        | FORMS
        |--------------------------------------------------------------------------
        */

        .admin-content .form-control,
        .admin-content .form-select {
            min-height: 46px;

            border-color:
                var(--admin-border);

            border-radius: 11px;
        }


        .admin-content
        textarea.form-control {
            min-height: auto;
        }


        .admin-content .form-control:focus,
        .admin-content .form-select:focus {
            border-color:
                rgba(
                    22,
                    134,
                    83,
                    .55
                );

            box-shadow:
                0 0 0 .2rem
                rgba(
                    22,
                    134,
                    83,
                    .10
                );
        }


        /*
        |--------------------------------------------------------------------------
        | IMAGE PREVIEW
        |--------------------------------------------------------------------------
        */

        .admin-image-preview {
            width: 100%;
            max-width: 360px;
            height: 230px;

            object-fit: cover;

            background:
                #f8faf9;

            border:
                1px solid
                var(--admin-border);

            border-radius: 16px;
        }


        .admin-logo-preview {
            width: 150px;
            height: 150px;

            padding: 8px;

            object-fit: contain;

            background:
                #f8faf9;

            border:
                1px solid
                var(--admin-border);

            border-radius: 16px;
        }


        .admin-preview-empty {
            width: 100%;
            max-width: 360px;
            height: 230px;

            display: flex;
            align-items: center;
            justify-content: center;

            color:
                var(--admin-muted);

            background:
                #fafcfb;

            border:
                2px dashed
                var(--admin-border);

            border-radius: 16px;
        }


        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        .admin-validation-box {
            border: 0;

            border-left:
                4px solid
                #dc3545;

            border-radius: 12px;

            box-shadow:
                0 8px 25px
                rgba(
                    220,
                    53,
                    69,
                    .08
                );
        }


        /*
        |--------------------------------------------------------------------------
        | TOAST
        |--------------------------------------------------------------------------
        */

        .admin-toast-container {
            position: fixed;

            top: 94px;
            right: 24px;

            z-index: 1200;

            width:
                min(
                    390px,
                    calc(100vw - 30px)
                );
        }


        .admin-toast {
            overflow: hidden;

            border: 0;

            border-radius: 14px;

            box-shadow:
                0 15px 40px
                rgba(
                    0,
                    0,
                    0,
                    .15
                );
        }


        /*
        |--------------------------------------------------------------------------
        | RESPONSIVE
        |--------------------------------------------------------------------------
        */

        @media (max-width: 991.98px) {

            /*
            | Sidebar tersembunyi sebagai default.
            */

            .admin-sidebar {
                width:
                    min(
                        320px,
                        82vw
                    );

                transform:
                    translateX(-100%) !important;
            }


            /*
            | Ketika class show aktif.
            */

            .admin-sidebar.show {
                transform:
                    translateX(0) !important;
            }


            .admin-sidebar-close {
                display: inline-flex;
            }


            .admin-main {
                margin-left: 0 !important;
            }


            .admin-sidebar-toggle {
                display: inline-flex !important;
            }


            .admin-content {
                padding: 20px;
            }


            .admin-topbar-inner {
                padding:
                    0
                    18px;
            }


            .admin-user-email {
                display: none;
            }

        }


        @media (max-width: 575.98px) {

            .admin-content {
                padding: 15px;
            }


            .admin-topbar {
                min-height: 70px;
            }


            .admin-topbar-inner {
                padding:
                    0
                    14px;
            }


            .admin-user-info {
                display: none;
            }


            .admin-user-button {
                padding: 5px;
            }


            .admin-user-button.dropdown-toggle::after {
                display: none;
            }


            .admin-page-subtitle {
                display: none;
            }


            .admin-toast-container {
                top: 82px;
                right: 15px;
            }

        }

    </style>

</head>


<body>

<div class="admin-shell">


    {{-- =========================================================
        SINGLE SIDEBAR
    ========================================================== --}}

    <aside
        class="admin-sidebar"
        id="adminSidebar"
        aria-label="Navigasi Admin"
    >

        <div class="admin-sidebar-brand">

            <div class="admin-sidebar-logo">
                UK
            </div>


            <div class="admin-sidebar-brand-text">

                <div class="admin-sidebar-title">
                    Umbul Kroman
                </div>

                <span class="admin-sidebar-subtitle">
                    Administration Panel
                </span>

            </div>


            <button
                type="button"
                class="admin-sidebar-close"
                id="adminSidebarClose"
                aria-label="Tutup sidebar"
            >
                ×
            </button>

        </div>


        <nav class="admin-menu">


            {{-- UTAMA --}}

            <div class="admin-menu-label">
                Utama
            </div>


            <a
                href="{{ route('admin.dashboard') }}"
                class="
                    admin-menu-link
                    {{ request()->routeIs(
                        'admin.dashboard',
                        'admin.home'
                    ) ? 'active' : '' }}
                "
            >

                <span class="admin-menu-icon">
                    D
                </span>

                <span>
                    Dashboard
                </span>

            </a>


            {{-- KONTEN --}}

            <div class="admin-menu-label">
                Konten
            </div>


            <a
                href="{{ route('admin.profile.edit') }}"
                class="
                    admin-menu-link
                    {{ request()->routeIs(
                        'admin.profile.*'
                    ) ? 'active' : '' }}
                "
            >

                <span class="admin-menu-icon">
                    P
                </span>

                <span>
                    Profil Desa
                </span>

            </a>


            <a
                href="{{ route('destinations.index') }}"
                class="
                    admin-menu-link
                    {{ request()->routeIs(
                        'destinations.*'
                    ) ? 'active' : '' }}
                "
            >

                <span class="admin-menu-icon">
                    W
                </span>

                <span>
                    Destinasi
                </span>

            </a>


            <a
                href="{{ route('posts.index') }}"
                class="
                    admin-menu-link
                    {{ request()->routeIs(
                        'posts.*'
                    ) ? 'active' : '' }}
                "
            >

                <span class="admin-menu-icon">
                    B
                </span>

                <span>
                    Blog / Berita
                </span>

            </a>


            <a
                href="{{ route('galleries.index') }}"
                class="
                    admin-menu-link
                    {{ request()->routeIs(
                        'galleries.*'
                    ) ? 'active' : '' }}
                "
            >

                <span class="admin-menu-icon">
                    G
                </span>

                <span>
                    Galeri
                </span>

            </a>


            {{-- SISTEM --}}

            <div class="admin-menu-label">
                Sistem
            </div>


            <a
                href="{{ route('admin.settings.edit') }}"
                class="
                    admin-menu-link
                    {{ request()->routeIs(
                        'admin.settings.*'
                    ) ? 'active' : '' }}
                "
            >

                <span class="admin-menu-icon">
                    S
                </span>

                <span>
                    Pengaturan
                </span>

            </a>


            <a
                href="{{ route('admin.backup.index') }}"
                class="
                    admin-menu-link
                    {{ request()->routeIs(
                        'admin.backup.*'
                    ) ? 'active' : '' }}
                "
            >

                <span class="admin-menu-icon">
                    BK
                </span>

                <span>
                    Backup & Restore
                </span>

            </a>


            <a
                href="{{ route('admin.account.edit') }}"
                class="
                    admin-menu-link
                    {{ request()->routeIs(
                        'admin.account.*'
                    ) ? 'active' : '' }}
                "
            >

                <span class="admin-menu-icon">
                    A
                </span>

                <span>
                    Akun Admin
                </span>

            </a>


            <a
                href="{{ route('home') }}"
                target="_blank"
                rel="noopener noreferrer"
                class="admin-menu-link"
            >

                <span class="admin-menu-icon">
                    ↗
                </span>

                <span>
                    Lihat Website
                </span>

            </a>

        </nav>

    </aside>


    {{-- =========================================================
        MAIN
    ========================================================== --}}

    <div class="admin-main">


        {{-- TOPBAR --}}

        <header class="admin-topbar">

            <div class="admin-topbar-inner">


                <div
                    class="
                        d-flex
                        align-items-center
                        gap-3
                    "
                >

                    <button
                        type="button"
                        class="admin-sidebar-toggle"
                        id="adminSidebarToggle"
                        aria-label="Buka atau tutup sidebar"
                        aria-controls="adminSidebar"
                        aria-expanded="false"
                    >
                        ☰
                    </button>


                    <div>

                        <h1 class="admin-page-title">

                            @yield(
                                'page_title',
                                'Admin Panel'
                            )

                        </h1>


                        <div class="admin-page-subtitle">
                            Kelola website Umbul Kroman
                        </div>

                    </div>

                </div>


                {{-- USER --}}

                <div class="dropdown">

                    <button
                        class="
                            admin-user-button
                            dropdown-toggle
                        "
                        type="button"
                        id="adminUserDropdown"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                    >

                        <div class="admin-user-avatar">

                            {{ strtoupper(
                                substr(
                                    auth()->user()->name
                                        ?? 'A',
                                    0,
                                    1
                                )
                            ) }}

                        </div>


                        <div class="admin-user-info">

                            <span class="admin-user-name">

                                {{ auth()->user()->name
                                    ?? 'Administrator'
                                }}

                            </span>


                            <span class="admin-user-email">

                                {{ auth()->user()->email
                                    ?? ''
                                }}

                            </span>

                        </div>

                    </button>


                    <ul
                        class="
                            dropdown-menu
                            dropdown-menu-end
                            shadow-sm
                            border-0
                        "
                        aria-labelledby="adminUserDropdown"
                    >

                        <li>

                            <a
                                class="dropdown-item"
                                href="{{ route(
                                    'admin.account.edit'
                                ) }}"
                            >
                                Akun Admin
                            </a>

                        </li>


                        <li>

                            <a
                                class="dropdown-item"
                                href="{{ route(
                                    'admin.settings.edit'
                                ) }}"
                            >
                                Pengaturan
                            </a>

                        </li>


                        <li>

                            <a
                                class="dropdown-item"
                                href="{{ route(
                                    'admin.backup.index'
                                ) }}"
                            >
                                Backup & Restore
                            </a>

                        </li>


                        <li>
                            <hr class="dropdown-divider">
                        </li>


                        <li>

                            <form
                                action="{{ route(
                                    'admin.logout'
                                ) }}"
                                method="POST"
                            >

                                @csrf

                                <button
                                    type="submit"
                                    class="
                                        dropdown-item
                                        text-danger
                                    "
                                >
                                    Logout
                                </button>

                            </form>

                        </li>

                    </ul>

                </div>

            </div>

        </header>


        {{-- CONTENT --}}

        <main class="admin-content">

            @if($errors->any())

                <div
                    class="
                        alert
                        alert-danger
                        admin-validation-box
                        mb-4
                    "
                    role="alert"
                >

                    <div class="fw-bold mb-2">
                        Periksa kembali data berikut:
                    </div>


                    <ul class="mb-0">

                        @foreach(
                            $errors->all()
                            as $error
                        )

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            @yield('content')

        </main>

    </div>

</div>


{{-- =========================================================
    TOAST
========================================================== --}}

<div class="admin-toast-container">

    @if(session('success'))

        <div
            class="
                toast
                admin-toast
                text-bg-success
            "
            role="alert"
        >

            <div class="d-flex">

                <div class="toast-body">

                    <strong class="d-block mb-1">
                        Berhasil
                    </strong>

                    {{ session('success') }}

                </div>


                <button
                    type="button"
                    class="
                        btn-close
                        btn-close-white
                        me-2
                        m-auto
                    "
                    data-bs-dismiss="toast"
                    aria-label="Tutup"
                ></button>

            </div>

        </div>

    @endif


    @if(session('error'))

        <div
            class="
                toast
                admin-toast
                text-bg-danger
            "
            role="alert"
        >

            <div class="d-flex">

                <div class="toast-body">

                    <strong class="d-block mb-1">
                        Gagal
                    </strong>

                    {{ session('error') }}

                </div>


                <button
                    type="button"
                    class="
                        btn-close
                        btn-close-white
                        me-2
                        m-auto
                    "
                    data-bs-dismiss="toast"
                    aria-label="Tutup"
                ></button>

            </div>

        </div>

    @endif

</div>


{{-- =========================================================
    SIDEBAR SCRIPT
========================================================== --}}

<script>
(function () {

    const sidebar =
        document.getElementById(
            'adminSidebar'
        );

    const toggleButton =
        document.getElementById(
            'adminSidebarToggle'
        );

    const closeButton =
        document.getElementById(
            'adminSidebarClose'
        );


    if (
        !sidebar ||
        !toggleButton
    ) {
        return;
    }


    function isMobile() {

        return window.matchMedia(
            '(max-width: 991.98px)'
        ).matches;

    }


    function isOpen() {

        return sidebar.classList.contains(
            'show'
        );

    }


    function openSidebar() {

        if (!isMobile()) {
            return;
        }

        sidebar.classList.add(
            'show'
        );

        toggleButton.setAttribute(
            'aria-expanded',
            'true'
        );

    }


    function closeSidebar() {

        sidebar.classList.remove(
            'show'
        );

        toggleButton.setAttribute(
            'aria-expanded',
            'false'
        );

    }


    function toggleSidebar() {

        if (!isMobile()) {
            return;
        }

        if (isOpen()) {

            closeSidebar();

        } else {

            openSidebar();

        }

    }


    /*
    |--------------------------------------------------------------------------
    | HAMBURGER
    |--------------------------------------------------------------------------
    */

    toggleButton.onclick =
        function (event) {

            event.preventDefault();

            event.stopPropagation();

            toggleSidebar();

        };


    /*
    |--------------------------------------------------------------------------
    | X BUTTON
    |--------------------------------------------------------------------------
    */

    if (closeButton) {

        closeButton.onclick =
            function (event) {

                event.preventDefault();

                event.stopPropagation();

                closeSidebar();

            };

    }


    /*
    |--------------------------------------------------------------------------
    | ESC
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'keydown',
        function (event) {

            if (
                event.key === 'Escape'
            ) {

                closeSidebar();

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | RESIZE
    |--------------------------------------------------------------------------
    */

    window.addEventListener(
        'resize',
        function () {

            if (!isMobile()) {

                closeSidebar();

            }

        }
    );

})();
</script>


@stack('scripts')

</body>

</html>