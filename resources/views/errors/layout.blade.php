@php
    $errorTitle =
        trim(
            $__env->yieldContent('error_title')
        );

    if (!$errorTitle) {
        $errorTitle = 'Terjadi Kesalahan';
    }

    $errorCode =
        trim(
            $__env->yieldContent('error_code')
        );

    $errorMessage =
        trim(
            $__env->yieldContent('error_message')
        );

    $siteName =
        $siteProfile?->name
        ?? $siteSettings?->site_title
        ?? 'Umbul Kroman';

    $faviconUrl =
        $siteSettings?->favicon
            ? asset(
                'storage/' .
                $siteSettings->favicon
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
        name="robots"
        content="noindex, nofollow"
    >

    <title>
        {{ $errorCode }}
        -
        {{ $errorTitle }}
        |
        {{ $siteName }}
    </title>


    @if($faviconUrl)

        <link
            rel="icon"
            type="image/webp"
            href="{{ $faviconUrl }}"
        >

    @endif


    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])


    <style>
        body {
            min-height: 100vh;
            margin: 0;

            display: flex;
            flex-direction: column;

            background:
                radial-gradient(
                    circle at top right,
                    rgba(22, 134, 83, 0.10),
                    transparent 35%
                ),
                linear-gradient(
                    180deg,
                    #f7fbf8 0%,
                    #ffffff 100%
                );
        }

        .error-page {
            flex: 1;

            display: flex;
            align-items: center;

            padding-top: 70px;
            padding-bottom: 70px;
        }

        .error-card {
            position: relative;

            overflow: hidden;

            max-width: 850px;

            margin-left: auto;
            margin-right: auto;

            padding: 60px 50px;

            text-align: center;

            background: #ffffff;

            border: 1px solid
                var(--uk-border);

            border-radius: 30px;

            box-shadow:
                0 30px 80px
                rgba(15, 67, 42, 0.10);
        }

        .error-card::before {
            content: "";

            position: absolute;

            width: 250px;
            height: 250px;

            top: -130px;
            right: -100px;

            background:
                rgba(22, 134, 83, 0.08);

            border-radius: 50%;
        }

        .error-card::after {
            content: "";

            position: absolute;

            width: 180px;
            height: 180px;

            bottom: -100px;
            left: -80px;

            background:
                rgba(22, 134, 83, 0.06);

            border-radius: 50%;
        }

        .error-card-content {
            position: relative;
            z-index: 2;
        }

        .error-logo {
            width: 72px;
            height: 72px;

            margin-bottom: 24px;

            object-fit: contain;

            background: #ffffff;

            border-radius: 20px;

            box-shadow:
                0 10px 30px
                rgba(15, 67, 42, 0.12);
        }

        .error-code {
            margin-bottom: 12px;

            color:
                var(--uk-primary);

            font-size:
                clamp(
                    4rem,
                    12vw,
                    8rem
                );

            font-weight: 900;

            letter-spacing: -0.07em;

            line-height: 0.9;
        }

        .error-title {
            margin-bottom: 16px;

            color:
                var(--uk-dark);

            font-size:
                clamp(
                    1.8rem,
                    4vw,
                    2.8rem
                );

            font-weight: 800;

            letter-spacing: -0.03em;
        }

        .error-message {
            max-width: 620px;

            margin-left: auto;
            margin-right: auto;
            margin-bottom: 32px;

            color:
                var(--uk-muted);

            font-size: 1.05rem;

            line-height: 1.8;
        }

        .error-actions {
            display: flex;
            flex-wrap: wrap;

            justify-content: center;

            gap: 12px;
        }

        .error-btn-primary {
            min-height: 50px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            padding: 12px 24px;

            color: #ffffff;

            background:
                var(--uk-primary);

            border: 1px solid
                var(--uk-primary);

            border-radius: 14px;

            text-decoration: none;

            font-weight: 700;
        }

        .error-btn-primary:hover {
            color: #ffffff;

            background:
                var(--uk-primary-dark);

            border-color:
                var(--uk-primary-dark);

            transform:
                translateY(-2px);
        }

        .error-btn-secondary {
            min-height: 50px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            padding: 12px 24px;

            color:
                var(--uk-primary);

            background:
                transparent;

            border: 1px solid
                rgba(22, 134, 83, 0.25);

            border-radius: 14px;

            text-decoration: none;

            font-weight: 700;
        }

        .error-btn-secondary:hover {
            color: #ffffff;

            background:
                var(--uk-primary);

            border-color:
                var(--uk-primary);
        }

        .error-footer {
            padding-top: 20px;
            padding-bottom: 30px;

            color:
                var(--uk-muted);

            text-align: center;

            font-size: 0.9rem;
        }

        @media (
            max-width: 767.98px
        ) {

            .error-page {
                padding-top: 40px;
                padding-bottom: 40px;
            }

            .error-card {
                padding:
                    45px 24px;

                border-radius: 24px;
            }

            .error-message {
                font-size: 1rem;
            }

            .error-actions {
                flex-direction: column;
            }

            .error-btn-primary,
            .error-btn-secondary {
                width: 100%;
            }

        }
    </style>

</head>


<body>

    <main class="error-page">

        <div class="container">

            <div class="error-card">

                <div
                    class="error-card-content"
                >

                    @if($siteProfile?->logo)

                        <img
                            src="{{ asset(
                                'storage/' .
                                $siteProfile->logo
                            ) }}"
                            alt="{{ $siteName }}"
                            class="error-logo"
                            width="72"
                            height="72"
                        >

                    @endif


                    <div class="error-code">

                        {{ $errorCode }}

                    </div>


                    <h1 class="error-title">

                        {{ $errorTitle }}

                    </h1>


                    @if($errorMessage)

                        <p class="error-message">

                            {{ $errorMessage }}

                        </p>

                    @endif


                    <div class="error-actions">

                        <a
                            href="{{ route('home') }}"
                            class="error-btn-primary"
                        >
                            Kembali ke Beranda
                        </a>


                        <button
                            type="button"
                            class="error-btn-secondary"
                            onclick="history.back()"
                        >
                            Kembali
                        </button>

                    </div>

                </div>

            </div>

        </div>

    </main>


    <footer class="error-footer">

        <div class="container">

            © {{ date('Y') }}

            {{ $siteName }}

        </div>

    </footer>

</body>

</html>