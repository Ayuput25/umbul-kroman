@props([
    'items' => [],
])

@php
    $breadcrumbItems = collect($items)
        ->filter(function ($item) {
            return !empty($item['name']);
        })
        ->values();

    $breadcrumbSchemaItems = [];

    foreach ($breadcrumbItems as $index => $item) {
        $schemaItem = [
            '@type' => 'ListItem',
            'position' => $index + 1,
            'name' => $item['name'],
        ];

        if (!empty($item['url'])) {
            $schemaItem['item'] = $item['url'];
        }

        $breadcrumbSchemaItems[] = $schemaItem;
    }

    $breadcrumbSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => $breadcrumbSchemaItems,
    ];
@endphp


{{-- =========================================================
    BREADCRUMB SCHEMA
========================================================== --}}

@push('head')

    <script type="application/ld+json">
        {!! json_encode(
            $breadcrumbSchema,
            JSON_UNESCAPED_SLASHES |
            JSON_UNESCAPED_UNICODE |
            JSON_HEX_TAG |
            JSON_HEX_AMP |
            JSON_HEX_APOS |
            JSON_HEX_QUOT
        ) !!}
    </script>

@endpush


{{-- =========================================================
    VISUAL BREADCRUMB
========================================================== --}}

<nav
    aria-label="breadcrumb"
    {{ $attributes->merge([
        'class' => 'public-breadcrumb-wrapper'
    ]) }}
>

    <ol class="breadcrumb public-breadcrumb mb-0">

        @foreach($breadcrumbItems as $index => $item)

            @php
                $isLast =
                    $index ===
                    $breadcrumbItems->count() - 1;
            @endphp


            <li
                class="
                    breadcrumb-item

                    @if($isLast)
                        active
                    @endif
                "
                @if($isLast)
                    aria-current="page"
                @endif
            >

                @if(
                    !$isLast &&
                    !empty($item['url'])
                )

                    <a href="{{ $item['url'] }}">

                        {{ $item['name'] }}

                    </a>

                @else

                    {{ $item['name'] }}

                @endif

            </li>

        @endforeach

    </ol>

</nav>