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
        Login Admin - Umbul Kroman
    </title>


    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])


    <style>

        /*
        |--------------------------------------------------------------------------
        | BASE
        |--------------------------------------------------------------------------
        */

        :root {
            --login-dark: #08271a;
            --login-dark-soft: #0d3825;

            --login-green: #168653;
            --login-green-dark: #0f6b43;

            --login-cream: #f7f5ef;
            --login-white: #ffffff;

            --login-text: #17241d;
            --login-muted: #748078;

            --login-border:
                rgba(
                    18,
                    61,
                    42,
                    .12
                );

            --login-shadow:
                0 35px 90px
                rgba(
                    4,
                    31,
                    19,
                    .25
                );
        }


        * {
            box-sizing: border-box;
        }


        html,
        body {
            min-height: 100%;
        }


        body {
            min-height: 100vh;

            margin: 0;

            color:
                var(--login-text);

            background:
                var(--login-dark);

            font-family:
                Inter,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;

            -webkit-font-smoothing:
                antialiased;
        }


        /*
        |--------------------------------------------------------------------------
        | PAGE
        |--------------------------------------------------------------------------
        */

        .login-page {
            position: relative;

            min-height: 100vh;

            display: flex;
            align-items: center;
            justify-content: center;

            overflow: hidden;

            padding:
                32px;

            isolation: isolate;
        }


        /*
        |--------------------------------------------------------------------------
        | BACKGROUND
        |--------------------------------------------------------------------------
        */

        .login-page::before {
            content: "";

            position: absolute;

            inset: 0;

            z-index: -4;

            background:
                linear-gradient(
                    135deg,
                    #071f15 0%,
                    #0a3523 45%,
                    #10633f 100%
                );
        }


        .login-bg-pattern {
            position: absolute;

            inset: 0;

            z-index: -3;

            overflow: hidden;

            pointer-events: none;
        }


        .login-bg-pattern::before {
            content: "";

            position: absolute;

            width: 620px;
            height: 620px;

            top: -240px;
            right: -210px;

            background:
                rgba(
                    88,
                    202,
                    140,
                    .14
                );

            border-radius: 50%;

            filter:
                blur(2px);
        }


        .login-bg-pattern::after {
            content: "";

            position: absolute;

            width: 480px;
            height: 480px;

            bottom: -260px;
            left: -180px;

            background:
                rgba(
                    255,
                    255,
                    255,
                    .06
                );

            border-radius: 50%;
        }


        .login-grid-pattern {
            position: absolute;

            inset: 0;

            z-index: -2;

            opacity: .07;

            background-image:
                linear-gradient(
                    rgba(
                        255,
                        255,
                        255,
                        .45
                    )
                    1px,
                    transparent
                    1px
                ),
                linear-gradient(
                    90deg,
                    rgba(
                        255,
                        255,
                        255,
                        .45
                    )
                    1px,
                    transparent
                    1px
                );

            background-size:
                46px
                46px;

            mask-image:
                linear-gradient(
                    to bottom,
                    black,
                    transparent
                );
        }


        /*
        |--------------------------------------------------------------------------
        | WRAPPER
        |--------------------------------------------------------------------------
        */

        .login-wrapper {
            width: 100%;

            max-width: 1080px;

            display: grid;

            grid-template-columns:
                minmax(
                    0,
                    1.05fr
                )
                minmax(
                    420px,
                    .95fr
                );

            overflow: hidden;

            background:
                rgba(
                    255,
                    255,
                    255,
                    .98
                );

            border:
                1px solid
                rgba(
                    255,
                    255,
                    255,
                    .18
                );

            border-radius: 30px;

            box-shadow:
                var(--login-shadow);
        }


        /*
        |--------------------------------------------------------------------------
        | LEFT
        |--------------------------------------------------------------------------
        */

        .login-visual {
            position: relative;

            min-height: 650px;

            display: flex;
            flex-direction: column;
            justify-content: space-between;

            overflow: hidden;

            padding:
                46px;

            color:
                #ffffff;

            background:
                linear-gradient(
                    145deg,
                    #082b1c,
                    #105c3b
                );

            isolation: isolate;
        }


        .login-visual::before {
            content: "";

            position: absolute;

            width: 360px;
            height: 360px;

            top: -150px;
            right: -160px;

            z-index: -1;

            background:
                rgba(
                    255,
                    255,
                    255,
                    .07
                );

            border-radius: 50%;
        }


        .login-visual::after {
            content: "";

            position: absolute;

            width: 250px;
            height: 250px;

            bottom: -110px;
            left: -80px;

            z-index: -1;

            border:
                1px solid
                rgba(
                    255,
                    255,
                    255,
                    .10
                );

            border-radius: 50%;
        }


        /*
        |--------------------------------------------------------------------------
        | BRAND
        |--------------------------------------------------------------------------
        */

        .login-brand {
            display: flex;
            align-items: center;

            gap: 13px;
        }


        .login-brand-logo {
            width: 48px;
            height: 48px;

            flex: 0 0 48px;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #ffffff;

            background:
                rgba(
                    255,
                    255,
                    255,
                    .12
                );

            border:
                1px solid
                rgba(
                    255,
                    255,
                    255,
                    .14
                );

            border-radius: 14px;

            backdrop-filter:
                blur(12px);

            font-size: 15px;
            font-weight: 850;
        }


        .login-brand-name {
            color: #ffffff;

            font-size: .98rem;
            font-weight: 800;

            line-height: 1.15;
        }


        .login-brand-caption {
            display: block;

            margin-top: 4px;

            color:
                rgba(
                    255,
                    255,
                    255,
                    .52
                );

            font-size: .7rem;
        }


        /*
        |--------------------------------------------------------------------------
        | VISUAL CONTENT
        |--------------------------------------------------------------------------
        */

        .login-visual-content {
            max-width: 470px;

            padding:
                45px 0;
        }


        .login-visual-kicker {
            display: inline-flex;
            align-items: center;

            gap: 10px;

            margin-bottom: 19px;

            color:
                rgba(
                    255,
                    255,
                    255,
                    .58
                );

            font-size: .7rem;
            font-weight: 750;

            letter-spacing: .16em;

            text-transform: uppercase;
        }


        .login-visual-kicker::before {
            content: "";

            width: 34px;
            height: 1px;

            background:
                rgba(
                    255,
                    255,
                    255,
                    .55
                );
        }


        .login-visual-title {
            margin: 0;

            color: #ffffff;

            font-family:
                Georgia,
                "Times New Roman",
                serif;

            font-size:
                clamp(
                    2.7rem,
                    4.7vw,
                    4.5rem
                );

            font-weight: 400;

            letter-spacing: -.055em;

            line-height: .98;
        }


        .login-visual-description {
            max-width: 430px;

            margin:
                24px
                0
                0;

            color:
                rgba(
                    255,
                    255,
                    255,
                    .67
                );

            font-size: .94rem;

            line-height: 1.8;
        }


        .login-visual-footer {
            display: flex;
            align-items: center;

            gap: 10px;

            color:
                rgba(
                    255,
                    255,
                    255,
                    .46
                );

            font-size: .69rem;

            letter-spacing: .06em;
        }


        .login-visual-dot {
            width: 7px;
            height: 7px;

            background: #5fd497;

            border-radius: 50%;

            box-shadow:
                0 0 0 5px
                rgba(
                    95,
                    212,
                    151,
                    .10
                );
        }


        /*
        |--------------------------------------------------------------------------
        | FORM SIDE
        |--------------------------------------------------------------------------
        */

        .login-form-side {
            display: flex;
            align-items: center;
            justify-content: center;

            padding:
                54px
                52px;

            background:
                var(--login-white);
        }


        .login-form-wrapper {
            width: 100%;

            max-width: 390px;
        }


        /*
        |--------------------------------------------------------------------------
        | MOBILE LOGO
        |--------------------------------------------------------------------------
        */

        .login-mobile-brand {
            display: none;

            margin-bottom: 29px;
        }


        .login-mobile-logo {
            width: 58px;
            height: 58px;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #ffffff;

            background:
                var(--login-green);

            border-radius: 17px;

            box-shadow:
                0 13px 30px
                rgba(
                    22,
                    134,
                    83,
                    .21
                );

            font-size: 18px;
            font-weight: 850;
        }


        /*
        |--------------------------------------------------------------------------
        | HEAD
        |--------------------------------------------------------------------------
        */

        .login-heading {
            margin-bottom: 32px;
        }


        .login-small-label {
            margin-bottom: 10px;

            color:
                var(--login-green);

            font-size: .7rem;
            font-weight: 800;

            letter-spacing: .14em;

            text-transform: uppercase;
        }


        .login-title {
            margin: 0;

            color:
                var(--login-text);

            font-size:
                clamp(
                    2rem,
                    4vw,
                    2.6rem
                );

            font-weight: 850;

            letter-spacing: -.045em;
        }


        .login-subtitle {
            margin:
                10px
                0
                0;

            color:
                var(--login-muted);

            font-size: .91rem;

            line-height: 1.65;
        }


        /*
        |--------------------------------------------------------------------------
        | ALERT
        |--------------------------------------------------------------------------
        */

        .login-alert {
            position: relative;

            margin-bottom: 22px;

            padding:
                13px
                15px;

            border-radius: 12px;

            font-size: .84rem;

            line-height: 1.6;
        }


        .login-alert-success {
            color: #12643e;

            background: #edf8f1;

            border:
                1px solid
                #d7efdf;
        }


        .login-alert-danger {
            color: #a23939;

            background: #fff3f3;

            border:
                1px solid
                #f2dada;
        }


        .login-alert ul {
            margin: 0;

            padding-left: 18px;
        }


        /*
        |--------------------------------------------------------------------------
        | FIELD
        |--------------------------------------------------------------------------
        */

        .login-field {
            margin-bottom: 20px;
        }


        .login-label {
            display: block;

            margin-bottom: 8px;

            color:
                var(--login-text);

            font-size: .79rem;
            font-weight: 750;
        }


        .login-input-wrapper {
            position: relative;
        }


        .login-input {
            width: 100%;

            min-height: 52px;

            padding:
                12px
                15px;

            color:
                var(--login-text);

            background:
                #fbfcfb;

            border:
                1px solid
                var(--login-border);

            border-radius: 13px;

            outline: none;

            font-size: .91rem;

            transition:
                border-color .2s ease,
                box-shadow .2s ease,
                background .2s ease;
        }


        .login-input::placeholder {
            color: #a5afa9;
        }


        .login-input:hover {
            border-color:
                rgba(
                    22,
                    134,
                    83,
                    .24
                );
        }


        .login-input:focus {
            background: #ffffff;

            border-color:
                rgba(
                    22,
                    134,
                    83,
                    .60
                );

            box-shadow:
                0 0 0 4px
                rgba(
                    22,
                    134,
                    83,
                    .08
                );
        }


        .login-input-password {
            padding-right: 54px;
        }


        /*
        |--------------------------------------------------------------------------
        | PASSWORD TOGGLE
        |--------------------------------------------------------------------------
        */

        .password-toggle {
            position: absolute;

            top: 50%;
            right: 9px;

            width: 38px;
            height: 38px;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 0;

            color:
                var(--login-muted);

            background:
                transparent;

            border: 0;

            border-radius: 9px;

            transform:
                translateY(-50%);

            cursor: pointer;

            transition: .2s ease;
        }


        .password-toggle:hover {
            color:
                var(--login-green);

            background:
                #eef7f1;
        }


        .password-toggle svg {
            width: 18px;
            height: 18px;
        }


        /*
        |--------------------------------------------------------------------------
        | OPTIONS
        |--------------------------------------------------------------------------
        */

        .login-options {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 15px;

            margin:
                4px
                0
                25px;
        }


        .login-remember {
            display: inline-flex;
            align-items: center;

            gap: 8px;

            color:
                var(--login-muted);

            font-size: .82rem;

            cursor: pointer;
        }


        .login-checkbox {
            width: 17px;
            height: 17px;

            margin: 0;

            accent-color:
                var(--login-green);

            cursor: pointer;
        }


        /*
        |--------------------------------------------------------------------------
        | BUTTON
        |--------------------------------------------------------------------------
        */

        .login-submit {
            width: 100%;

            min-height: 52px;

            display: flex;
            align-items: center;
            justify-content: center;

            gap: 10px;

            padding:
                11px
                20px;

            color: #ffffff;

            background:
                var(--login-green);

            border:
                1px solid
                var(--login-green);

            border-radius: 13px;

            box-shadow:
                0 12px 25px
                rgba(
                    22,
                    134,
                    83,
                    .18
                );

            font-size: .9rem;
            font-weight: 800;

            cursor: pointer;

            transition:
                background .25s ease,
                transform .25s ease,
                box-shadow .25s ease;
        }


        .login-submit:hover {
            color: #ffffff;

            background:
                var(--login-green-dark);

            border-color:
                var(--login-green-dark);

            box-shadow:
                0 15px 30px
                rgba(
                    22,
                    134,
                    83,
                    .25
                );

            transform:
                translateY(-2px);
        }


        .login-submit:active {
            transform:
                translateY(0);
        }


        .login-submit-arrow {
            transition:
                transform .2s ease;
        }


        .login-submit:hover
        .login-submit-arrow {
            transform:
                translateX(3px);
        }


        /*
        |--------------------------------------------------------------------------
        | BACK LINK
        |--------------------------------------------------------------------------
        */

        .login-back {
            margin-top: 27px;

            text-align: center;
        }


        .login-back-link {
            display: inline-flex;
            align-items: center;

            gap: 7px;

            color:
                var(--login-muted);

            text-decoration: none;

            font-size: .8rem;
            font-weight: 650;

            transition: .2s ease;
        }


        .login-back-link:hover {
            color:
                var(--login-green);
        }


        /*
        |--------------------------------------------------------------------------
        | SECURITY TEXT
        |--------------------------------------------------------------------------
        */

        .login-security {
            margin-top: 22px;

            padding-top: 20px;

            color: #9aa49e;

            border-top:
                1px solid
                var(--login-border);

            text-align: center;

            font-size: .68rem;

            line-height: 1.6;
        }


        /*
        |--------------------------------------------------------------------------
        | TABLET
        |--------------------------------------------------------------------------
        */

        @media (max-width: 991.98px) {

            .login-page {
                padding:
                    24px;
            }


            .login-wrapper {
                max-width: 860px;

                grid-template-columns:
                    minmax(
                        0,
                        .85fr
                    )
                    minmax(
                        390px,
                        1fr
                    );
            }


            .login-visual {
                min-height: 600px;

                padding:
                    36px;
            }


            .login-form-side {
                padding:
                    45px
                    38px;
            }


            .login-visual-title {
                font-size:
                    3rem;
            }

        }


        /*
        |--------------------------------------------------------------------------
        | MOBILE
        |--------------------------------------------------------------------------
        */

        @media (max-width: 767.98px) {

            body {
                background:
                    var(--login-cream);
            }


            .login-page {
                align-items:
                    flex-start;

                min-height: 100svh;

                padding:
                    24px
                    16px;
            }


            .login-bg-pattern,
            .login-grid-pattern {
                display: none;
            }


            .login-wrapper {
                max-width: 480px;

                display: block;

                overflow: visible;

                background:
                    transparent;

                border: 0;

                border-radius: 0;

                box-shadow: none;
            }


            .login-visual {
                display: none;
            }


            .login-form-side {
                min-height:
                    calc(
                        100svh - 48px
                    );

                align-items:
                    center;

                padding:
                    34px
                    28px;

                background:
                    #ffffff;

                border:
                    1px solid
                    var(--login-border);

                border-radius: 24px;

                box-shadow:
                    0 20px 60px
                    rgba(
                        22,
                        61,
                        42,
                        .09
                    );
            }


            .login-mobile-brand {
                display: block;
            }


            .login-heading {
                margin-bottom: 29px;
            }


            .login-title {
                font-size: 2rem;
            }

        }


        /*
        |--------------------------------------------------------------------------
        | SMALL MOBILE
        |--------------------------------------------------------------------------
        */

        @media (max-width: 430px) {

            .login-page {
                padding:
                    12px;
            }


            .login-form-side {
                min-height:
                    calc(
                        100svh - 24px
                    );

                padding:
                    29px
                    20px;

                border-radius: 20px;
            }


            .login-mobile-logo {
                width: 54px;
                height: 54px;

                border-radius: 15px;
            }


            .login-title {
                font-size: 1.85rem;
            }


            .login-subtitle {
                font-size: .85rem;
            }


            .login-input,
            .login-submit {
                min-height: 50px;
            }


            .login-options {
                margin-bottom: 22px;
            }

        }

    </style>

</head>


<body>

<div class="login-page">


    {{-- =========================================================
        BACKGROUND
    ========================================================== --}}

    <div class="login-bg-pattern"></div>
    <div class="login-grid-pattern"></div>


    {{-- =========================================================
        LOGIN
    ========================================================== --}}

    <div class="login-wrapper">


        {{-- =====================================================
            LEFT VISUAL
        ====================================================== --}}

        <section class="login-visual">

            <div class="login-brand">

                <div class="login-brand-logo">
                    UK
                </div>


                <div>

                    <div class="login-brand-name">
                        Umbul Kroman
                    </div>

                    <span class="login-brand-caption">
                        Administration Panel
                    </span>

                </div>

            </div>


            <div class="login-visual-content">

                <div class="login-visual-kicker">
                    Admin Area
                </div>


                <h1 class="login-visual-title">

                    Kelola
                    Umbul Kroman
                    dengan mudah.

                </h1>


                <p class="login-visual-description">

                    Masuk ke panel administrasi
                    untuk mengelola profil,
                    destinasi,
                    artikel,
                    galeri,
                    serta informasi website
                    Umbul Kroman.

                </p>

            </div>


            <div class="login-visual-footer">

                <span class="login-visual-dot"></span>

                <span>
                    Umbul Kroman Website Management
                </span>

            </div>

        </section>


        {{-- =====================================================
            LOGIN FORM
        ====================================================== --}}

        <main class="login-form-side">

            <div class="login-form-wrapper">


                {{-- MOBILE BRAND --}}

                <div class="login-mobile-brand">

                    <div class="login-mobile-logo">
                        UK
                    </div>

                </div>


                {{-- HEADER --}}

                <div class="login-heading">

                    <div class="login-small-label">
                        Administrator
                    </div>


                    <h2 class="login-title">
                        Selamat datang.
                    </h2>


                    <p class="login-subtitle">

                        Silakan masuk menggunakan
                        akun administrator
                        untuk melanjutkan.

                    </p>

                </div>


                {{-- =================================================
                    SUCCESS
                ================================================== --}}

                @if(session('success'))

                    <div
                        class="
                            login-alert
                            login-alert-success
                        "
                        role="alert"
                    >

                        {{ session('success') }}

                    </div>

                @endif


                {{-- =================================================
                    VALIDATION ERROR
                ================================================== --}}

                @if($errors->any())

                    <div
                        class="
                            login-alert
                            login-alert-danger
                        "
                        role="alert"
                    >

                        <ul>

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


                {{-- =================================================
                    FORM
                ================================================== --}}

                <form
                    method="POST"
                    action="{{ route(
                        'admin.login.process'
                    ) }}"
                >

                    @csrf


                    {{-- EMAIL --}}

                    <div class="login-field">

                        <label
                            for="email"
                            class="login-label"
                        >
                            Email
                        </label>


                        <div class="login-input-wrapper">

                            <input
                                id="email"
                                type="email"
                                name="email"
                                class="login-input"
                                value="{{ old('email') }}"
                                placeholder="admin@example.com"
                                autocomplete="email"
                                required
                                autofocus
                            >

                        </div>

                    </div>


                    {{-- PASSWORD --}}

                    <div class="login-field">

                        <label
                            for="password"
                            class="login-label"
                        >
                            Password
                        </label>


                        <div class="login-input-wrapper">

                            <input
                                id="password"
                                type="password"
                                name="password"
                                class="
                                    login-input
                                    login-input-password
                                "
                                placeholder="Masukkan password"
                                autocomplete="current-password"
                                required
                            >


                            <button
                                type="button"
                                class="password-toggle"
                                id="passwordToggle"
                                aria-label="Tampilkan password"
                                aria-pressed="false"
                            >

                                <svg
                                    id="passwordEyeOpen"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    aria-hidden="true"
                                >

                                    <path
                                        d="
                                            M2.5 12
                                            s3.5-6
                                            9.5-6
                                            9.5 6
                                            9.5 6
                                            -3.5 6
                                            -9.5 6
                                            -9.5-6
                                            -9.5-6
                                        "
                                    />

                                    <circle
                                        cx="12"
                                        cy="12"
                                        r="2.5"
                                    />

                                </svg>


                                <svg
                                    id="passwordEyeClosed"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    aria-hidden="true"
                                    style="display: none;"
                                >

                                    <path
                                        d="M3 3l18 18"
                                    />

                                    <path
                                        d="
                                            M10.6 10.6
                                            a2 2 0 0 0
                                            2.8 2.8
                                        "
                                    />

                                    <path
                                        d="
                                            M9.9 4.2
                                            A10.7 10.7 0 0 1
                                            12 4
                                            c6 0 9.5 8 9.5 8
                                            a15.1 15.1 0 0 1
                                            -2.3 3.3
                                        "
                                    />

                                    <path
                                        d="
                                            M6.6 6.6
                                            C4 8.3
                                            2.5 12
                                            2.5 12
                                            S6 20
                                            12 20
                                            a9.7 9.7 0 0 0
                                            4.1-.9
                                        "
                                    />

                                </svg>

                            </button>

                        </div>

                    </div>


                    {{-- OPTIONS --}}

                    <div class="login-options">

                        <label
                            for="remember"
                            class="login-remember"
                        >

                            <input
                                class="login-checkbox"
                                type="checkbox"
                                name="remember"
                                value="1"
                                id="remember"
                                {{ old('remember')
                                    ? 'checked'
                                    : ''
                                }}
                            >

                            <span>
                                Ingat saya
                            </span>

                        </label>

                    </div>


                    {{-- SUBMIT --}}

                    <button
                        type="submit"
                        class="login-submit"
                    >

                        <span>
                            Masuk ke Admin
                        </span>

                        <span class="login-submit-arrow">
                            →
                        </span>

                    </button>

                </form>


                {{-- =================================================
                    BACK
                ================================================== --}}

                <div class="login-back">

                    <a
                        href="{{ route('home') }}"
                        class="login-back-link"
                    >

                        <span>
                            ←
                        </span>

                        <span>
                            Kembali ke Website
                        </span>

                    </a>

                </div>


                <div class="login-security">

                    Area ini hanya diperuntukkan
                    bagi administrator
                    yang memiliki akses.

                </div>

            </div>

        </main>

    </div>

</div>


{{-- =========================================================
    PASSWORD TOGGLE
========================================================== --}}

<script>
    document.addEventListener(
        'DOMContentLoaded',
        function () {

            const passwordInput =
                document.getElementById(
                    'password'
                );

            const toggleButton =
                document.getElementById(
                    'passwordToggle'
                );

            const eyeOpen =
                document.getElementById(
                    'passwordEyeOpen'
                );

            const eyeClosed =
                document.getElementById(
                    'passwordEyeClosed'
                );


            if (
                !passwordInput ||
                !toggleButton
            ) {
                return;
            }


            toggleButton.addEventListener(
                'click',
                function () {

                    const isHidden =
                        passwordInput.type
                        === 'password';


                    passwordInput.type =
                        isHidden
                            ? 'text'
                            : 'password';


                    toggleButton.setAttribute(
                        'aria-pressed',
                        isHidden
                            ? 'true'
                            : 'false'
                    );


                    toggleButton.setAttribute(
                        'aria-label',
                        isHidden
                            ? 'Sembunyikan password'
                            : 'Tampilkan password'
                    );


                    if (
                        eyeOpen &&
                        eyeClosed
                    ) {

                        eyeOpen.style.display =
                            isHidden
                                ? 'none'
                                : 'block';


                        eyeClosed.style.display =
                            isHidden
                                ? 'block'
                                : 'none';

                    }


                    passwordInput.focus();

                }
            );

        }
    );
</script>

</body>

</html>