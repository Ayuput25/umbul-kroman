@extends('layouts.app')


@section(
    'title',
    ($profile?->name ?? 'Umbul Kroman')
    . ' - Wisata Alam Klaten'
)


@section(
    'meta_description',
    \Illuminate\Support\Str::limit(
        strip_tags(
            $profile?->description
                ?: 'Jelajahi wisata alam, destinasi, informasi, dan pesona Umbul Kroman.'
        ),
        160
    )
)


@section(
    'canonical',
    route('home')
)


@if($profile?->hero_image)

    @section(
        'meta_image',
        asset(
            'storage/' . $profile->hero_image
        )
    )

@endif


{{-- =========================================================
    STRUCTURED DATA
========================================================== --}}

@push('head')

    @php
        $organizationSameAs = array_values(
            array_filter([
                $siteSettings?->instagram_url,
                $siteSettings?->facebook_url,
                $siteSettings?->tiktok_url,
                $siteSettings?->youtube_url,
            ])
        );


        $websiteSchema = [
            '@type' => 'WebSite',

            '@id' =>
                route('home') .
                '#website',

            'url' =>
                route('home'),

            'name' =>
                $profile?->name
                ?? 'Umbul Kroman',

            'description' =>
                \Illuminate\Support\Str::limit(
                    strip_tags(
                        $profile?->description
                            ?: 'Website resmi Umbul Kroman.'
                    ),
                    200
                ),

            'inLanguage' =>
                'id-ID',
        ];


        $organizationSchema = [
            '@type' =>
                'Organization',

            '@id' =>
                route('home') .
                '#organization',

            'name' =>
                $profile?->name
                ?? 'Umbul Kroman',

            'url' =>
                route('home'),
        ];


        if ($profile?->logo) {

            $organizationSchema['logo'] = [
                '@type' =>
                    'ImageObject',

                'url' =>
                    asset(
                        'storage/' .
                        $profile->logo
                    ),
            ];
        }


        if ($profile?->description) {

            $organizationSchema['description'] =
                \Illuminate\Support\Str::limit(
                    strip_tags(
                        $profile->description
                    ),
                    300
                );
        }


        if ($profile?->address) {

            $organizationSchema['address'] = [
                '@type' =>
                    'PostalAddress',

                'streetAddress' =>
                    $profile->address,

                'addressCountry' =>
                    'ID',
            ];
        }


        if ($profile?->phone) {

            $organizationSchema['telephone'] =
                $profile->phone;
        }


        if ($profile?->email) {

            $organizationSchema['email'] =
                $profile->email;
        }


        if (!empty($organizationSameAs)) {

            $organizationSchema['sameAs'] =
                $organizationSameAs;
        }


        $homeSchema = [
            '@context' =>
                'https://schema.org',

            '@graph' => [
                $websiteSchema,
                $organizationSchema,
            ],
        ];
    @endphp


    <script type="application/ld+json">
        {!! json_encode(
            $homeSchema,
            JSON_UNESCAPED_SLASHES |
            JSON_UNESCAPED_UNICODE |
            JSON_HEX_TAG |
            JSON_HEX_AMP |
            JSON_HEX_APOS |
            JSON_HEX_QUOT
        ) !!}
    </script>


    <style>

        /*
        |--------------------------------------------------------------------------
        | HOME VARIABLES
        |--------------------------------------------------------------------------
        */

        .uk-home {
            --home-dark: #0b2b1e;
            --home-dark-soft: #123d2b;

            --home-green: #168653;
            --home-green-dark: #0e633d;

            --home-cream: #f7f4ec;
            --home-paper: #fcfbf7;
            --home-soft: #eef4ef;

            --home-text: #17241d;
            --home-muted: #748178;

            --home-border:
                rgba(
                    20,
                    61,
                    42,
                    .12
                );

            color:
                var(--home-text);

            background:
                var(--home-paper);

            overflow: hidden;
        }


        /*
        |--------------------------------------------------------------------------
        | GLOBAL HOME
        |--------------------------------------------------------------------------
        */

        .uk-home-container {
            width:
                min(
                    1240px,
                    calc(
                        100% - 48px
                    )
                );

            margin:
                0 auto;
        }


        .uk-home-section {
            padding:
                104px
                0;
        }


        .uk-home-section-sm {
            padding:
                84px
                0;
        }


        .uk-home-kicker {
            display:
                inline-flex;

            align-items:
                center;

            gap:
                11px;

            color:
                var(--home-green);

            font-size:
                .72rem;

            font-weight:
                800;

            letter-spacing:
                .17em;

            text-transform:
                uppercase;
        }


        .uk-home-kicker::before {
            content: "";

            width:
                38px;

            height:
                1px;

            background:
                currentColor;
        }


        .uk-home-heading {
            margin:
                14px
                0
                0;

            max-width:
                760px;

            color:
                var(--home-text);

            font-family:
                Georgia,
                "Times New Roman",
                serif;

            font-size:
                clamp(
                    2.7rem,
                    4.5vw,
                    4.8rem
                );

            font-weight:
                400;

            letter-spacing:
                -.05em;

            line-height:
                .98;
        }


        .uk-home-copy {
            color:
                var(--home-muted);

            font-size:
                1rem;

            line-height:
                1.9;
        }


        .uk-home-link {
            display:
                inline-flex;

            align-items:
                center;

            gap:
                8px;

            color:
                var(--home-dark);

            text-decoration:
                none;

            font-size:
                .86rem;

            font-weight:
                750;
        }


        .uk-home-link::after {
            content: "→";

            transition:
                transform
                .25s
                ease;
        }


        .uk-home-link:hover {
            color:
                var(--home-green);
        }


        .uk-home-link:hover::after {
            transform:
                translateX(4px);
        }


        /*
        |--------------------------------------------------------------------------
        | HERO
        |--------------------------------------------------------------------------
        */

        .uk-home-hero {
            position:
                relative;

            min-height:
                clamp(
                    620px,
                    78vh,
                    760px
                );

            display:
                flex;

            align-items:
                flex-end;

            overflow:
                hidden;

            isolation:
                isolate;

            background:
                var(--home-dark);
        }


        .uk-home-hero-image {
            position:
                absolute;

            inset:
                0;

            z-index:
                -4;

            width:
                100%;

            height:
                100%;

            object-fit:
                cover;

            object-position:
                center;
        }


        .uk-home-hero::before {
            content: "";

            position:
                absolute;

            inset:
                0;

            z-index:
                -3;

            background:
                linear-gradient(
                    90deg,

                    rgba(
                        3,
                        26,
                        16,
                        .94
                    )
                    0%,

                    rgba(
                        5,
                        35,
                        22,
                        .77
                    )
                    42%,

                    rgba(
                        5,
                        35,
                        22,
                        .29
                    )
                    72%,

                    rgba(
                        3,
                        25,
                        15,
                        .08
                    )
                    100%
                );
        }


        .uk-home-hero::after {
            content: "";

            position:
                absolute;

            right:
                0;

            bottom:
                0;

            left:
                0;

            z-index:
                -2;

            height:
                44%;

            background:
                linear-gradient(
                    to top,

                    rgba(
                        3,
                        24,
                        15,
                        .72
                    ),

                    transparent
                );
        }


        .uk-home-hero-inner {
            width:
                100%;

            padding:
                128px
                0
                56px;
        }


        .uk-home-hero-copy {
            max-width:
                820px;
        }


        .uk-home-hero-eyebrow {
            display:
                inline-flex;

            align-items:
                center;

            gap:
                12px;

            color:
                rgba(
                    255,
                    255,
                    255,
                    .68
                );

            font-size:
                .73rem;

            font-weight:
                750;

            letter-spacing:
                .17em;

            text-transform:
                uppercase;
        }


        .uk-home-hero-eyebrow::before {
            content: "";

            width:
                38px;

            height:
                1px;

            background:
                rgba(
                    255,
                    255,
                    255,
                    .65
                );
        }


        .uk-home-hero-title {
            max-width:
                850px;

            margin:
                23px
                0
                0;

            color:
                #ffffff;

            font-family:
                Georgia,
                "Times New Roman",
                serif;

            font-size:
                clamp(
                    4.3rem,
                    7.6vw,
                    7.3rem
                );

            font-weight:
                400;

            letter-spacing:
                -.065em;

            line-height:
                .88;
        }


        .uk-home-hero-description {
            max-width:
                620px;

            margin:
                27px
                0
                0;

            color:
                rgba(
                    255,
                    255,
                    255,
                    .77
                );

            font-size:
                1.08rem;

            line-height:
                1.8;
        }


        .uk-home-hero-bottom {
            display:
                flex;

            align-items:
                flex-end;

            justify-content:
                space-between;

            gap:
                28px;

            margin-top:
                38px;
        }


        .uk-home-hero-buttons {
            display:
                flex;

            flex-wrap:
                wrap;

            gap:
                10px;
        }


        .uk-home-btn-light,
        .uk-home-btn-glass {
            min-height:
                50px;

            display:
                inline-flex;

            align-items:
                center;

            justify-content:
                center;

            gap:
                10px;

            padding:
                11px
                22px;

            border-radius:
                999px;

            text-decoration:
                none;

            font-size:
                .86rem;

            font-weight:
                750;

            transition:
                .25s
                ease;
        }


        .uk-home-btn-light {
            color:
                var(--home-dark)
                !important;

            background:
                #ffffff;

            border:
                1px solid
                #ffffff;
        }


        .uk-home-btn-light:hover {
            background:
                #eaf3ec;

            transform:
                translateY(-2px);
        }


        .uk-home-btn-glass {
            color:
                #ffffff
                !important;

            background:
                rgba(
                    255,
                    255,
                    255,
                    .07
                );

            border:
                1px solid
                rgba(
                    255,
                    255,
                    255,
                    .24
                );

            backdrop-filter:
                blur(10px);
        }


        .uk-home-btn-glass:hover {
            background:
                rgba(
                    255,
                    255,
                    255,
                    .14
                );

            transform:
                translateY(-2px);
        }


        .uk-home-scroll {
            display:
                flex;

            align-items:
                center;

            gap:
                12px;

            color:
                rgba(
                    255,
                    255,
                    255,
                    .46
                );

            font-size:
                .67rem;

            letter-spacing:
                .13em;

            text-transform:
                uppercase;
        }


        .uk-home-scroll-line {
            width:
                1px;

            height:
                48px;

            background:
                linear-gradient(
                    to bottom,

                    rgba(
                        255,
                        255,
                        255,
                        .68
                    ),

                    transparent
                );
        }


        /*
        |--------------------------------------------------------------------------
        | ABOUT
        |--------------------------------------------------------------------------
        */

        .uk-home-about {
            background:
                var(--home-paper);
        }


        .uk-home-about-grid {
            display:
                grid;

            grid-template-columns:
                110px
                minmax(
                    0,
                    1.7fr
                )
                minmax(
                    300px,
                    .9fr
                );

            gap:
                46px;

            align-items:
                start;
        }


        .uk-home-about-number {
            color:
                rgba(
                    17,
                    64,
                    43,
                    .13
                );

            font-family:
                Georgia,
                "Times New Roman",
                serif;

            font-size:
                7.5rem;

            line-height:
                .8;
        }


        .uk-home-about-main {
            max-width:
                670px;
        }


        .uk-home-about-title {
            margin:
                20px
                0
                24px;

            color:
                var(--home-text);

            font-family:
                Georgia,
                "Times New Roman",
                serif;

            font-size:
                clamp(
                    2.3rem,
                    3.9vw,
                    4rem
                );

            font-weight:
                400;

            letter-spacing:
                -.045em;

            line-height:
                1.06;
        }


        .uk-home-about-info {
            position:
                relative;

            padding:
                30px;

            color:
                #ffffff;

            background:
                var(--home-dark);

            border-radius:
                3px
                34px
                3px
                34px;
        }


        .uk-home-about-info::after {
            content: "";

            position:
                absolute;

            top:
                20px;

            right:
                20px;

            width:
                66px;

            height:
                66px;

            border:
                1px solid
                rgba(
                    255,
                    255,
                    255,
                    .12
                );

            border-radius:
                50%;
        }


        .uk-home-info-heading {
            margin-bottom:
                28px;

            color:
                rgba(
                    255,
                    255,
                    255,
                    .46
                );

            font-size:
                .66rem;

            font-weight:
                800;

            letter-spacing:
                .16em;

            text-transform:
                uppercase;
        }


        .uk-home-info-row {
            padding:
                16px
                0;

            border-top:
                1px solid
                rgba(
                    255,
                    255,
                    255,
                    .10
                );
        }


        .uk-home-info-label {
            color:
                rgba(
                    255,
                    255,
                    255,
                    .45
                );

            font-size:
                .65rem;

            font-weight:
                750;

            letter-spacing:
                .10em;

            text-transform:
                uppercase;
        }


        .uk-home-info-value {
            margin-top:
                6px;

            color:
                #ffffff;

            font-size:
                .91rem;

            line-height:
                1.6;
        }


        /*
        |--------------------------------------------------------------------------
        | SECTION HEADER
        |--------------------------------------------------------------------------
        */

        .uk-home-section-head {
            display:
                flex;

            align-items:
                flex-end;

            justify-content:
                space-between;

            gap:
                30px;

            margin-bottom:
                46px;
        }


        /*
        |--------------------------------------------------------------------------
        | DESTINATIONS
        |--------------------------------------------------------------------------
        */

        .uk-home-destinations {
            background:
                var(--home-cream);
        }


        .uk-home-destination-grid {
            display:
                grid;

            grid-template-columns:
                repeat(
                    12,
                    minmax(
                        0,
                        1fr
                    )
                );

            gap:
                14px;
        }


        .uk-home-destination-item {
            grid-column:
                span 4;
        }


        .uk-home-destination-item:nth-child(1) {
            grid-column:
                span 7;
        }


        .uk-home-destination-item:nth-child(2) {
            grid-column:
                span 5;
        }


        .uk-home-destination-card {
            position:
                relative;

            height:
                390px;

            overflow:
                hidden;

            isolation:
                isolate;

            background:
                var(--home-dark);
        }


        .uk-home-destination-item:nth-child(1)
        .uk-home-destination-card,

        .uk-home-destination-item:nth-child(2)
        .uk-home-destination-card {
            height:
                530px;
        }


        .uk-home-destination-media {
            position:
                absolute;

            inset:
                0;

            z-index:
                -3;

            display:
                block;
        }


        .uk-home-destination-media img {
            width:
                100%
                !important;

            height:
                100%
                !important;

            object-fit:
                cover;

            transition:
                transform
                .65s
                ease;
        }


        .uk-home-destination-card::after {
            content: "";

            position:
                absolute;

            inset:
                0;

            z-index:
                -2;

            background:
                linear-gradient(
                    to top,

                    rgba(
                        3,
                        25,
                        15,
                        .92
                    )
                    0%,

                    rgba(
                        3,
                        25,
                        15,
                        .35
                    )
                    45%,

                    transparent
                    75%
                );
        }


        .uk-home-destination-card:hover
        .uk-home-destination-media img {
            transform:
                scale(1.045);
        }


        .uk-home-destination-index {
            position:
                absolute;

            top:
                22px;

            left:
                22px;

            color:
                rgba(
                    255,
                    255,
                    255,
                    .66
                );

            font-family:
                Georgia,
                "Times New Roman",
                serif;

            font-size:
                .9rem;
        }


        .uk-home-destination-ticket {
            position:
                absolute;

            top:
                18px;

            right:
                18px;

            padding:
                7px
                11px;

            color:
                var(--home-dark);

            background:
                rgba(
                    255,
                    255,
                    255,
                    .92
                );

            border-radius:
                999px;

            backdrop-filter:
                blur(8px);

            font-size:
                .68rem;

            font-weight:
                800;
        }


        .uk-home-destination-content {
            position:
                absolute;

            right:
                0;

            bottom:
                0;

            left:
                0;

            padding:
                24px;
        }


        .uk-home-destination-location {
            margin-bottom:
                8px;

            color:
                rgba(
                    255,
                    255,
                    255,
                    .58
                );

            font-size:
                .68rem;

            font-weight:
                700;

            letter-spacing:
                .07em;

            text-transform:
                uppercase;
        }


        .uk-home-destination-title {
            margin:
                0;

            max-width:
                520px;

            color:
                #ffffff;

            font-family:
                Georgia,
                "Times New Roman",
                serif;

            font-size:
                clamp(
                    1.6rem,
                    2.7vw,
                    2.8rem
                );

            font-weight:
                400;

            line-height:
                1.02;
        }


        .uk-home-destination-link {
            display:
                inline-flex;

            margin-top:
                14px;

            color:
                rgba(
                    255,
                    255,
                    255,
                    .76
                );

            text-decoration:
                none;

            font-size:
                .74rem;

            font-weight:
                700;
        }


        /*
        |--------------------------------------------------------------------------
        | JOURNAL
        |--------------------------------------------------------------------------
        */

        .uk-home-journal {
            background:
                var(--home-paper);
        }


        .uk-home-featured-article {
            display:
                grid;

            grid-template-columns:
                minmax(
                    0,
                    1.16fr
                )
                minmax(
                    360px,
                    .84fr
                );

            min-height:
                500px;

            background:
                var(--home-soft);
        }


        .uk-home-article-media {
            min-height:
                500px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            overflow:
                hidden;

            background:
                #e8eeea;
        }


        .uk-home-article-media img {
            width:
                100%;

            height:
                100%;

            object-fit:
                contain;
        }


        .uk-home-article-copy {
            display:
                flex;

            flex-direction:
                column;

            justify-content:
                center;

            padding:
                42px;
        }


        .uk-home-article-date {
            color:
                var(--home-green);

            font-size:
                .68rem;

            font-weight:
                800;

            letter-spacing:
                .12em;

            text-transform:
                uppercase;
        }


        .uk-home-article-title {
            margin:
                14px
                0
                17px;

            color:
                var(--home-text);

            font-family:
                Georgia,
                "Times New Roman",
                serif;

            font-size:
                clamp(
                    2rem,
                    3.4vw,
                    3.4rem
                );

            font-weight:
                400;

            letter-spacing:
                -.04em;

            line-height:
                1.04;
        }


        .uk-home-article-title a {
            color:
                inherit;

            text-decoration:
                none;
        }


        .uk-home-article-excerpt {
            color:
                var(--home-muted);

            line-height:
                1.8;
        }


        .uk-home-article-list {
            margin-top:
                36px;

            border-top:
                1px solid
                var(--home-border);
        }


        .uk-home-article-row {
            display:
                grid;

            grid-template-columns:
                120px
                minmax(
                    0,
                    1fr
                )
                42px;

            align-items:
                center;

            gap:
                24px;

            padding:
                22px
                0;

            border-bottom:
                1px solid
                var(--home-border);
        }


        .uk-home-article-row-date {
            color:
                var(--home-muted);

            font-size:
                .7rem;
        }


        .uk-home-article-row-title {
            margin:
                0;

            font-family:
                Georgia,
                "Times New Roman",
                serif;

            font-size:
                clamp(
                    1.2rem,
                    2vw,
                    1.75rem
                );

            font-weight:
                400;
        }


        .uk-home-article-row-title a {
            color:
                var(--home-text);

            text-decoration:
                none;
        }


        .uk-home-article-arrow {
            width:
                42px;

            height:
                42px;

            display:
                inline-flex;

            align-items:
                center;

            justify-content:
                center;

            color:
                var(--home-dark);

            border:
                1px solid
                var(--home-border);

            border-radius:
                50%;

            text-decoration:
                none;
        }


        .uk-home-article-arrow:hover {
            color:
                #ffffff;

            background:
                var(--home-dark);
        }


        /*
        |--------------------------------------------------------------------------
        | GALLERY
        |--------------------------------------------------------------------------
        */

        .uk-home-gallery {
            color:
                #ffffff;

            background:
                var(--home-dark);
        }


        .uk-home-gallery
        .uk-home-heading {
            color:
                #ffffff;
        }


        .uk-home-gallery
        .uk-home-kicker {
            color:
                #8bc7a7;
        }


        .uk-home-gallery
        .uk-home-link {
            color:
                rgba(
                    255,
                    255,
                    255,
                    .72
                );
        }


        .uk-home-gallery-grid {
            display:
                grid;

            grid-template-columns:
                1.25fr
                .8fr
                1fr
                1fr;

            grid-template-rows:
                240px
                240px;

            gap:
                10px;
        }


        .uk-home-gallery-item {
            position:
                relative;

            overflow:
                hidden;

            background:
                var(--home-dark-soft);
        }


        .uk-home-gallery-item:nth-child(1) {
            grid-row:
                span 2;
        }


        .uk-home-gallery-item:nth-child(2) {
            grid-column:
                span 2;
        }


        .uk-home-gallery-item img {
            width:
                100%
                !important;

            height:
                100%
                !important;

            object-fit:
                cover;

            transition:
                transform
                .55s
                ease;
        }


        .uk-home-gallery-item:hover img {
            transform:
                scale(1.045);
        }


        .uk-home-gallery-item::after {
            content: "";

            position:
                absolute;

            inset:
                0;

            background:
                linear-gradient(
                    to top,

                    rgba(
                        4,
                        29,
                        18,
                        .76
                    ),

                    transparent
                    58%
                );

            opacity:
                0;

            transition:
                opacity
                .25s
                ease;
        }


        .uk-home-gallery-caption {
            position:
                absolute;

            right:
                16px;

            bottom:
                14px;

            left:
                16px;

            z-index:
                2;

            color:
                #ffffff;

            font-size:
                .76rem;

            font-weight:
                700;

            opacity:
                0;

            transform:
                translateY(5px);

            transition:
                .25s
                ease;
        }


        .uk-home-gallery-item:hover::after,
        .uk-home-gallery-item:hover
        .uk-home-gallery-caption {
            opacity:
                1;
        }


        .uk-home-gallery-item:hover
        .uk-home-gallery-caption {
            transform:
                translateY(0);
        }


        /*
        |--------------------------------------------------------------------------
        | FINAL CTA
        |--------------------------------------------------------------------------
        */

        .uk-home-final {
            padding:
                112px
                0;

            background:
                var(--home-cream);
        }


        .uk-home-final-inner {
            max-width:
                900px;

            margin:
                0 auto;

            text-align:
                center;
        }


        .uk-home-final-label {
            color:
                var(--home-green);

            font-size:
                .68rem;

            font-weight:
                800;

            letter-spacing:
                .17em;

            text-transform:
                uppercase;
        }


        .uk-home-final-title {
            margin:
                20px
                auto
                22px;

            color:
                var(--home-text);

            font-family:
                Georgia,
                "Times New Roman",
                serif;

            font-size:
                clamp(
                    2.8rem,
                    5.5vw,
                    5.2rem
                );

            font-weight:
                400;

            letter-spacing:
                -.055em;

            line-height:
                .96;
        }


        .uk-home-final-copy {
            max-width:
                610px;

            margin:
                0 auto
                29px;

            color:
                var(--home-muted);

            line-height:
                1.8;
        }


        .uk-home-final-button {
            min-height:
                52px;

            display:
                inline-flex;

            align-items:
                center;

            justify-content:
                center;

            padding:
                11px
                24px;

            color:
                #ffffff
                !important;

            background:
                var(--home-dark);

            border-radius:
                999px;

            text-decoration:
                none;

            font-size:
                .84rem;

            font-weight:
                750;

            transition:
                .25s
                ease;
        }


        .uk-home-final-button:hover {
            background:
                var(--home-green);

            transform:
                translateY(-2px);
        }


        /*
        |--------------------------------------------------------------------------
        | LARGE DESKTOP
        |--------------------------------------------------------------------------
        */

        @media (min-width: 1600px) {

            .uk-home-container {
                width:
                    min(
                        1320px,
                        calc(
                            100% - 90px
                        )
                    );
            }


            .uk-home-hero {
                min-height:
                    760px;
            }


            .uk-home-hero-title {
                font-size:
                    7.5rem;
            }


            .uk-home-destination-item:nth-child(1)
            .uk-home-destination-card,

            .uk-home-destination-item:nth-child(2)
            .uk-home-destination-card {
                height:
                    560px;
            }

        }


        /*
        |--------------------------------------------------------------------------
        | LAPTOP
        |--------------------------------------------------------------------------
        */

        @media (
            min-width: 992px
        )
        and
        (
            max-width: 1280px
        ) {

            .uk-home-container {
                width:
                    min(
                        1120px,
                        calc(
                            100% - 40px
                        )
                    );
            }


            .uk-home-hero {
                min-height:
                    650px;
            }


            .uk-home-hero-inner {
                padding-bottom:
                    48px;
            }


            .uk-home-hero-title {
                font-size:
                    clamp(
                        4.2rem,
                        7vw,
                        6.3rem
                    );
            }


            .uk-home-section {
                padding:
                    88px
                    0;
            }


            .uk-home-about-grid {
                grid-template-columns:
                    85px
                    minmax(
                        0,
                        1.6fr
                    )
                    minmax(
                        280px,
                        .9fr
                    );

                gap:
                    32px;
            }


            .uk-home-about-number {
                font-size:
                    6.3rem;
            }


            .uk-home-destination-item:nth-child(1)
            .uk-home-destination-card,

            .uk-home-destination-item:nth-child(2)
            .uk-home-destination-card {
                height:
                    480px;
            }


            .uk-home-destination-card {
                height:
                    350px;
            }


            .uk-home-featured-article,
            .uk-home-article-media {
                min-height:
                    460px;
            }


            .uk-home-gallery-grid {
                grid-template-rows:
                    220px
                    220px;
            }

        }


        /*
        |--------------------------------------------------------------------------
        | TABLET
        |--------------------------------------------------------------------------
        */

        @media (max-width: 991.98px) {

            .uk-home-container {
                width:
                    min(
                        760px,
                        calc(
                            100% - 36px
                        )
                    );
            }


            .uk-home-section {
                padding:
                    80px
                    0;
            }


            .uk-home-section-sm {
                padding:
                    70px
                    0;
            }


            .uk-home-hero {
                min-height:
                    660px;
            }


            .uk-home-hero::before {
                background:
                    linear-gradient(
                        to top,

                        rgba(
                            3,
                            25,
                            15,
                            .94
                        )
                        0%,

                        rgba(
                            3,
                            30,
                            18,
                            .62
                        )
                        55%,

                        rgba(
                            3,
                            30,
                            18,
                            .24
                        )
                        100%
                    );
            }


            .uk-home-hero-inner {
                padding:
                    110px
                    0
                    46px;
            }


            .uk-home-hero-copy {
                max-width:
                    640px;
            }


            .uk-home-hero-title {
                font-size:
                    clamp(
                        4rem,
                        11vw,
                        6rem
                    );
            }


            .uk-home-about-grid {
                grid-template-columns:
                    80px
                    1fr;
            }


            .uk-home-about-info {
                grid-column:
                    2 / 3;

                max-width:
                    520px;
            }


            .uk-home-destination-grid {
                grid-template-columns:
                    repeat(
                        2,
                        minmax(
                            0,
                            1fr
                        )
                    );
            }


            .uk-home-destination-item,
            .uk-home-destination-item:nth-child(1),
            .uk-home-destination-item:nth-child(2) {
                grid-column:
                    span 1;
            }


            .uk-home-destination-item:nth-child(1)
            .uk-home-destination-card,

            .uk-home-destination-item:nth-child(2)
            .uk-home-destination-card,

            .uk-home-destination-card {
                height:
                    410px;
            }


            .uk-home-featured-article {
                grid-template-columns:
                    1fr;
            }


            .uk-home-article-media {
                min-height:
                    380px;
            }


            .uk-home-article-copy {
                padding:
                    32px;
            }


            .uk-home-gallery-grid {
                grid-template-columns:
                    repeat(
                        2,
                        minmax(
                            0,
                            1fr
                        )
                    );

                grid-template-rows:
                    repeat(
                        4,
                        210px
                    );
            }


            .uk-home-gallery-item:nth-child(1) {
                grid-row:
                    span 2;
            }


            .uk-home-gallery-item:nth-child(2) {
                grid-column:
                    auto;
            }

        }


        /*
        |--------------------------------------------------------------------------
        | MOBILE
        |--------------------------------------------------------------------------
        */

        @media (max-width: 767.98px) {

            .uk-home-container {
                width:
                    calc(
                        100% - 28px
                    );
            }


            .uk-home-section {
                padding:
                    66px
                    0;
            }


            .uk-home-section-sm {
                padding:
                    58px
                    0;
            }


            .uk-home-kicker {
                font-size:
                    .65rem;

                letter-spacing:
                    .14em;
            }


            .uk-home-heading {
                font-size:
                    clamp(
                        2.4rem,
                        11vw,
                        3.7rem
                    );

                line-height:
                    1;
            }


            /*
            | HERO MOBILE
            */

            .uk-home-hero {
                min-height:
                    620px;

                max-height:
                    none;
            }


            .uk-home-hero-image {
                object-position:
                    center;
            }


            .uk-home-hero-inner {
                padding:
                    105px
                    0
                    34px;
            }


            .uk-home-hero-eyebrow {
                font-size:
                    .64rem;

                letter-spacing:
                    .14em;
            }


            .uk-home-hero-eyebrow::before {
                width:
                    30px;
            }


            .uk-home-hero-title {
                max-width:
                    100%;

                margin-top:
                    18px;

                font-size:
                    clamp(
                        3.6rem,
                        18vw,
                        5.1rem
                    );

                line-height:
                    .9;
            }


            .uk-home-hero-description {
                max-width:
                    520px;

                margin-top:
                    22px;

                font-size:
                    .96rem;

                line-height:
                    1.72;
            }


            .uk-home-hero-bottom {
                align-items:
                    stretch;

                flex-direction:
                    column;

                margin-top:
                    29px;
            }


            .uk-home-hero-buttons {
                width:
                    100%;

                flex-direction:
                    column;
            }


            .uk-home-btn-light,
            .uk-home-btn-glass {
                width:
                    100%;

                min-height:
                    49px;
            }


            .uk-home-scroll {
                display:
                    none;
            }


            /*
            | ABOUT MOBILE
            */

            .uk-home-about-grid {
                display:
                    block;
            }


            .uk-home-about-number {
                margin-bottom:
                    20px;

                font-size:
                    5.4rem;
            }


            .uk-home-about-title {
                margin-top:
                    17px;

                font-size:
                    clamp(
                        2rem,
                        10vw,
                        3rem
                    );
            }


            .uk-home-about-main {
                max-width:
                    none;
            }


            .uk-home-about-info {
                margin-top:
                    35px;

                padding:
                    25px;

                border-radius:
                    2px
                    27px
                    2px
                    27px;
            }


            /*
            | SECTION HEADER MOBILE
            */

            .uk-home-section-head {
                align-items:
                    flex-start;

                flex-direction:
                    column;

                gap:
                    18px;

                margin-bottom:
                    29px;
            }


            /*
            | DESTINATION MOBILE
            */

            .uk-home-destination-grid {
                display:
                    block;
            }


            .uk-home-destination-item {
                margin-bottom:
                    14px;
            }


            .uk-home-destination-item:last-child {
                margin-bottom:
                    0;
            }


            .uk-home-destination-item:nth-child(1)
            .uk-home-destination-card,

            .uk-home-destination-item:nth-child(2)
            .uk-home-destination-card,

            .uk-home-destination-card {
                height:
                    360px;
            }


            .uk-home-destination-content {
                padding:
                    20px;
            }


            .uk-home-destination-index {
                top:
                    18px;

                left:
                    18px;
            }


            .uk-home-destination-ticket {
                top:
                    15px;

                right:
                    15px;
            }


            .uk-home-destination-title {
                font-size:
                    clamp(
                        1.7rem,
                        8vw,
                        2.35rem
                    );
            }


            /*
            | JOURNAL MOBILE
            */

            .uk-home-featured-article {
                display:
                    block;
            }


            .uk-home-article-media {
                min-height:
                    0;

                height:
                    280px;
            }


            .uk-home-article-copy {
                padding:
                    25px
                    21px
                    27px;
            }


            .uk-home-article-title {
                font-size:
                    clamp(
                        1.8rem,
                        9vw,
                        2.6rem
                    );
            }


            .uk-home-article-list {
                margin-top:
                    27px;
            }


            .uk-home-article-row {
                grid-template-columns:
                    1fr
                    38px;

                gap:
                    13px;

                padding:
                    19px
                    0;
            }


            .uk-home-article-row-date {
                grid-column:
                    1 / -1;

                margin-bottom:
                    -5px;
            }


            .uk-home-article-row-title {
                font-size:
                    1.25rem;
            }


            .uk-home-article-arrow {
                width:
                    38px;

                height:
                    38px;
            }


            /*
            | GALLERY MOBILE
            */

            .uk-home-gallery-grid {
                grid-template-columns:
                    repeat(
                        2,
                        minmax(
                            0,
                            1fr
                        )
                    );

                grid-template-rows:
                    220px
                    160px
                    160px
                    160px;

                gap:
                    7px;
            }


            .uk-home-gallery-item:nth-child(1) {
                grid-column:
                    span 2;

                grid-row:
                    auto;
            }


            .uk-home-gallery-item:nth-child(2) {
                grid-column:
                    auto;
            }


            /*
            | CTA MOBILE
            */

            .uk-home-final {
                padding:
                    76px
                    0;
            }


            .uk-home-final-title {
                font-size:
                    clamp(
                        2.7rem,
                        13vw,
                        4rem
                    );

                line-height:
                    .97;
            }


            .uk-home-final-copy {
                font-size:
                    .95rem;
            }


            .uk-home-final-button {
                width:
                    100%;

                max-width:
                    320px;
            }

        }


        /*
        |--------------------------------------------------------------------------
        | SMALL MOBILE 360 - 430PX
        |--------------------------------------------------------------------------
        */

        @media (max-width: 430px) {

            .uk-home-container {
                width:
                    calc(
                        100% - 24px
                    );
            }


            .uk-home-section {
                padding:
                    58px
                    0;
            }


            .uk-home-hero {
                min-height:
                    600px;
            }


            .uk-home-hero-inner {
                padding-bottom:
                    27px;
            }


            .uk-home-hero-title {
                font-size:
                    clamp(
                        3.35rem,
                        18vw,
                        4.45rem
                    );
            }


            .uk-home-hero-description {
                font-size:
                    .91rem;
            }


            .uk-home-about-number {
                font-size:
                    4.7rem;
            }


            .uk-home-about-title {
                font-size:
                    2.1rem;
            }


            .uk-home-copy {
                font-size:
                    .94rem;
            }


            .uk-home-destination-item:nth-child(1)
            .uk-home-destination-card,

            .uk-home-destination-item:nth-child(2)
            .uk-home-destination-card,

            .uk-home-destination-card {
                height:
                    325px;
            }


            .uk-home-article-media {
                height:
                    240px;
            }


            .uk-home-gallery-grid {
                grid-template-rows:
                    190px
                    140px
                    140px
                    140px;
            }


            .uk-home-final {
                padding:
                    66px
                    0;
            }

        }

    </style>

@endpush


@section('content')

<div class="uk-home">


    {{-- =========================================================
        HERO
    ========================================================== --}}

    <section class="uk-home-hero">

        @if($profile?->hero_image)

            <img
                src="{{ asset(
                    'storage/' .
                    $profile->hero_image
                ) }}"
                alt="{{ $profile?->name ?? 'Umbul Kroman' }}"
                class="uk-home-hero-image"
                loading="eager"
                decoding="async"
                fetchpriority="high"
            >

        @endif


        <div class="uk-home-container">

            <div class="uk-home-hero-inner">

                <div class="uk-home-hero-copy">

                    <div class="uk-home-hero-eyebrow">
                        Wisata Alam · Klaten
                    </div>


                    <h1 class="uk-home-hero-title">

                        {{ $profile?->name
                            ?? 'Umbul Kroman'
                        }}

                    </h1>


                    <p class="uk-home-hero-description">

                        @if($profile?->tagline)

                            {{ $profile->tagline }}

                        @else

                            Temukan ketenangan,
                            alam,
                            kehidupan desa,
                            dan pengalaman menarik
                            di Umbul Kroman.

                        @endif

                    </p>

                </div>


                <div class="uk-home-hero-bottom">

                    <div class="uk-home-hero-buttons">

                        <a
                            href="{{ route(
                                'destinations.public'
                            ) }}"
                            class="uk-home-btn-light"
                        >
                            Jelajahi Destinasi
                            <span>→</span>
                        </a>


                        <a
                            href="{{ route(
                                'profile'
                            ) }}"
                            class="uk-home-btn-glass"
                        >
                            Tentang Umbul Kroman
                        </a>

                    </div>


                    <div class="uk-home-scroll">

                        <span class="uk-home-scroll-line"></span>

                        <span>
                            Scroll untuk menjelajah
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- =========================================================
        ABOUT
    ========================================================== --}}

    <section class="uk-home-section uk-home-about">

        <div class="uk-home-container">

            <div class="uk-home-about-grid">

                <div
                    class="
                        uk-home-about-number
                        reveal
                    "
                >
                    01
                </div>


                <div
                    class="
                        uk-home-about-main
                        reveal
                    "
                >

                    <div class="uk-home-kicker">
                        Cerita Kami
                    </div>


                    <h2 class="uk-home-about-title">

                        Tempat di mana alam,
                        kehidupan desa,
                        dan perjalanan bertemu.

                    </h2>


                    <p class="uk-home-copy">

                        @if($profile?->description)

                            {{ \Illuminate\Support\Str::limit(
                                strip_tags(
                                    $profile->description
                                ),
                                430
                            ) }}

                        @else

                            Umbul Kroman menghadirkan
                            suasana alam yang tenang,
                            kehidupan desa yang hangat,
                            serta berbagai potensi wisata
                            yang menarik untuk ditemukan.

                        @endif

                    </p>


                    <a
                        href="{{ route(
                            'profile'
                        ) }}"
                        class="
                            uk-home-link
                            mt-3
                        "
                    >
                        Mengenal Kami
                    </a>

                </div>


                <aside
                    class="
                        uk-home-about-info
                        reveal
                    "
                >

                    <div class="uk-home-info-heading">
                        Informasi
                    </div>


                    <div class="uk-home-info-row">

                        <div class="uk-home-info-label">
                            Nama
                        </div>

                        <div class="uk-home-info-value">

                            {{ $profile?->name
                                ?? 'Umbul Kroman'
                            }}

                        </div>

                    </div>


                    @if($profile?->address)

                        <div class="uk-home-info-row">

                            <div class="uk-home-info-label">
                                Lokasi
                            </div>

                            <div class="uk-home-info-value">

                                {{ $profile->address }}

                            </div>

                        </div>

                    @endif


                    @if($profile?->phone)

                        <div class="uk-home-info-row">

                            <div class="uk-home-info-label">
                                Kontak
                            </div>

                            <div class="uk-home-info-value">

                                {{ $profile->phone }}

                            </div>

                        </div>

                    @endif


                    @if($profile?->email)

                        <div class="uk-home-info-row">

                            <div class="uk-home-info-label">
                                Email
                            </div>

                            <div class="uk-home-info-value">

                                {{ $profile->email }}

                            </div>

                        </div>

                    @endif

                </aside>

            </div>

        </div>

    </section>


    {{-- =========================================================
        DESTINATIONS
    ========================================================== --}}

    @if($destinations->isNotEmpty())

        <section class="uk-home-section uk-home-destinations">

            <div class="uk-home-container">

                <div class="uk-home-section-head">

                    <div class="reveal">

                        <div class="uk-home-kicker">
                            Pilihan Perjalanan
                        </div>


                        <h2 class="uk-home-heading">
                            Tempat untuk ditemukan.
                        </h2>

                    </div>


                    <a
                        href="{{ route(
                            'destinations.public'
                        ) }}"
                        class="uk-home-link"
                    >
                        Semua Destinasi
                    </a>

                </div>


                <div class="uk-home-destination-grid">

                    @foreach(
                        $destinations
                        as $destination
                    )

                        <div
                            class="
                                uk-home-destination-item
                                reveal
                            "
                        >

                            <article class="uk-home-destination-card">

                                <a
                                    href="{{ route(
                                        'destinations.show.public',
                                        $destination->slug
                                    ) }}"
                                    class="uk-home-destination-media"
                                    aria-label="{{ $destination->name }}"
                                >

                                    @if($destination->image)

                                        <x-responsive-image
                                            :src="$destination->image"
                                            :thumbnail="$destination->thumbnail"
                                            :alt="$destination->name"
                                            loading="lazy"
                                        />

                                    @else

                                        <div
                                            class="
                                                w-100
                                                h-100
                                                d-flex
                                                align-items-center
                                                justify-content-center
                                                text-white-50
                                            "
                                        >
                                            Belum ada gambar
                                        </div>

                                    @endif

                                </a>


                                <div class="uk-home-destination-index">

                                    {{ str_pad(
                                        $loop->iteration,
                                        2,
                                        '0',
                                        STR_PAD_LEFT
                                    ) }}

                                </div>


                                <div class="uk-home-destination-ticket">

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

                                </div>


                                <div class="uk-home-destination-content">

                                    @if($destination->address)

                                        <div class="uk-home-destination-location">

                                            {{ \Illuminate\Support\Str::limit(
                                                $destination->address,
                                                58
                                            ) }}

                                        </div>

                                    @endif


                                    <h3 class="uk-home-destination-title">

                                        {{ $destination->name }}

                                    </h3>


                                    <a
                                        href="{{ route(
                                            'destinations.show.public',
                                            $destination->slug
                                        ) }}"
                                        class="uk-home-destination-link"
                                    >
                                        Lihat destinasi →
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
        JOURNAL
    ========================================================== --}}

    @if($posts->isNotEmpty())

        @php
            $featuredPost =
                $posts->first();

            $otherPosts =
                $posts->skip(1);
        @endphp


        <section class="uk-home-section uk-home-journal">

            <div class="uk-home-container">

                <div class="uk-home-section-head">

                    <div class="reveal">

                        <div class="uk-home-kicker">
                            Journal
                        </div>


                        <h2 class="uk-home-heading">
                            Cerita & informasi terbaru.
                        </h2>

                    </div>


                    <a
                        href="{{ route(
                            'blog.public'
                        ) }}"
                        class="uk-home-link"
                    >
                        Semua Artikel
                    </a>

                </div>


                <article
                    class="
                        uk-home-featured-article
                        reveal
                    "
                >

                    <a
                        href="{{ route(
                            'blog.show.public',
                            $featuredPost->slug
                        ) }}"
                        class="uk-home-article-media"
                    >

                        @if($featuredPost->image)

                            <img
                                src="{{ asset(
                                    'storage/' .
                                    $featuredPost->image
                                ) }}"
                                alt="{{ $featuredPost->title }}"
                                loading="lazy"
                                decoding="async"
                            >

                        @else

                            <span class="text-muted">
                                Belum ada gambar
                            </span>

                        @endif

                    </a>


                    <div class="uk-home-article-copy">

                        @if($featuredPost->published_at)

                            <div class="uk-home-article-date">

                                {{ $featuredPost
                                    ->published_at
                                    ->format(
                                        'd M Y'
                                    )
                                }}

                            </div>

                        @endif


                        <h3 class="uk-home-article-title">

                            <a
                                href="{{ route(
                                    'blog.show.public',
                                    $featuredPost->slug
                                ) }}"
                            >

                                {{ $featuredPost->title }}

                            </a>

                        </h3>


                        <p class="uk-home-article-excerpt">

                            {{ \Illuminate\Support\Str::limit(
                                $featuredPost->excerpt
                                    ?: strip_tags(
                                        $featuredPost->content
                                    ),
                                175
                            ) }}

                        </p>


                        <a
                            href="{{ route(
                                'blog.show.public',
                                $featuredPost->slug
                            ) }}"
                            class="
                                uk-home-link
                                mt-3
                            "
                        >
                            Baca Cerita
                        </a>

                    </div>

                </article>


                @if($otherPosts->isNotEmpty())

                    <div class="uk-home-article-list">

                        @foreach(
                            $otherPosts
                            as $post
                        )

                            <article
                                class="
                                    uk-home-article-row
                                    reveal
                                "
                            >

                                <div class="uk-home-article-row-date">

                                    @if($post->published_at)

                                        {{ $post
                                            ->published_at
                                            ->format(
                                                'd M Y'
                                            )
                                        }}

                                    @else

                                        Artikel

                                    @endif

                                </div>


                                <h3 class="uk-home-article-row-title">

                                    <a
                                        href="{{ route(
                                            'blog.show.public',
                                            $post->slug
                                        ) }}"
                                    >
                                        {{ $post->title }}
                                    </a>

                                </h3>


                                <a
                                    href="{{ route(
                                        'blog.show.public',
                                        $post->slug
                                    ) }}"
                                    class="uk-home-article-arrow"
                                    aria-label="Baca {{ $post->title }}"
                                >
                                    →
                                </a>

                            </article>

                        @endforeach

                    </div>

                @endif

            </div>

        </section>

    @endif


    {{-- =========================================================
        GALLERY
    ========================================================== --}}

    @if($galleries->isNotEmpty())

        <section class="uk-home-section uk-home-gallery">

            <div class="uk-home-container">

                <div class="uk-home-section-head">

                    <div class="reveal">

                        <div class="uk-home-kicker">
                            Moments
                        </div>


                        <h2 class="uk-home-heading">
                            Fragmen dari Umbul Kroman.
                        </h2>

                    </div>


                    <a
                        href="{{ route(
                            'gallery'
                        ) }}"
                        class="uk-home-link"
                    >
                        Seluruh Galeri
                    </a>

                </div>


                <div class="uk-home-gallery-grid">

                    @foreach(
                        $galleries
                        as $gallery
                    )

                        <a
                            href="{{ route(
                                'gallery'
                            ) }}"
                            class="
                                uk-home-gallery-item
                                reveal
                            "
                            aria-label="{{ $gallery->title }}"
                        >

                            <x-responsive-image
                                :src="$gallery->image"
                                :thumbnail="$gallery->thumbnail"
                                :alt="$gallery->title"
                                loading="lazy"
                            />


                            <div class="uk-home-gallery-caption">

                                {{ $gallery->title }}

                            </div>

                        </a>

                    @endforeach

                </div>

            </div>

        </section>

    @endif


    {{-- =========================================================
        FINAL CTA
    ========================================================== --}}

    <section class="uk-home-final">

        <div class="uk-home-container">

            <div
                class="
                    uk-home-final-inner
                    reveal
                "
            >

                <div class="uk-home-final-label">
                    Temukan Lebih Banyak
                </div>


                <h2 class="uk-home-final-title">

                    Lebih dekat
                    dengan alam,
                    cerita,
                    dan perjalanan.

                </h2>


                <p class="uk-home-final-copy">

                    Jelajahi destinasi,
                    informasi,
                    dokumentasi,
                    serta berbagai pengalaman
                    yang menjadi bagian dari
                    {{ $profile?->name
                        ?? 'Umbul Kroman'
                    }}.

                </p>


                <a
                    href="{{ route(
                        'destinations.public'
                    ) }}"
                    class="uk-home-final-button"
                >
                    Jelajahi Umbul Kroman →
                </a>

            </div>

        </div>

    </section>

</div>

@endsection