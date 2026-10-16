@props([
    'src',
    'thumbnail' => null,
    'alt' => '',
    'class' => '',
    'sizes' => '100vw',
    'loading' => 'lazy',
    'fetchpriority' => 'auto',
    'width' => null,
    'height' => null,
])

@php
    $mainUrl = $src
        ? asset('storage/' . ltrim($src, '/'))
        : null;

    $thumbnailUrl = $thumbnail
        ? asset('storage/' . ltrim($thumbnail, '/'))
        : null;

    $hasSeparateThumbnail =
        $thumbnail &&
        $src &&
        $thumbnail !== $src;
@endphp

@if($mainUrl)

    <img
        src="{{ $thumbnailUrl ?: $mainUrl }}"

        @if($hasSeparateThumbnail)
            srcset="
                {{ $thumbnailUrl }} 640w,
                {{ $mainUrl }} 1600w
            "
            sizes="{{ $sizes }}"
        @endif

        alt="{{ $alt }}"
        class="{{ $class }}"

        loading="{{ $loading }}"
        decoding="async"
        fetchpriority="{{ $fetchpriority }}"

        @if($width)
            width="{{ $width }}"
        @endif

        @if($height)
            height="{{ $height }}"
        @endif

        {{ $attributes }}
    >

@endif