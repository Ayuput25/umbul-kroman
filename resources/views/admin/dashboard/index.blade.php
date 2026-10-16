@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('page_title', 'Dashboard')

@section('content')

<div
    class="
        d-flex
        flex-column
        flex-lg-row
        justify-content-between
        align-items-lg-center
        gap-3
        mb-4
    ">

    <div>

        <h2 class="fw-bold mb-1">
            Selamat datang, {{ auth()->user()->name }}
        </h2>

        <p class="text-muted mb-0">
            Berikut ringkasan kondisi website saat ini.
        </p>

    </div>


    <a
        href="{{ route('home') }}"
        target="_blank"
        class="btn btn-admin-primary">

        Lihat Website ↗

    </a>

</div>


{{-- STATISTIK --}}
<div class="row g-4 mb-4">

    <div class="col-md-6 col-xl-4">

        <div class="admin-stat-card">

            <div class="admin-stat-label">
                Total Destinasi
            </div>

            <div class="admin-stat-value">
                {{ $destinationCount }}
            </div>

            <div class="admin-stat-meta">
                {{ $activeDestinationCount }}
                destinasi aktif
            </div>

        </div>

    </div>


    <div class="col-md-6 col-xl-4">

        <div class="admin-stat-card">

            <div class="admin-stat-label">
                Blog & Berita
            </div>

            <div class="admin-stat-value">
                {{ $postCount }}
            </div>

            <div class="admin-stat-meta">
                {{ $publishedPostCount }}
                artikel dipublikasi
            </div>

        </div>

    </div>


    <div class="col-md-6 col-xl-4">

        <div class="admin-stat-card">

            <div class="admin-stat-label">
                Galeri
            </div>

            <div class="admin-stat-value">
                {{ $galleryCount }}
            </div>

            <div class="admin-stat-meta">
                {{ $activeGalleryCount }}
                foto aktif
            </div>

        </div>

    </div>

</div>


<div class="row g-4">

    {{-- DESTINASI TERBARU --}}
    <div class="col-xl-6">

        <div class="admin-card h-100">

            <div class="admin-card-header">

                <div>

                    <h5 class="fw-bold mb-1">
                        Destinasi Terbaru
                    </h5>

                    <small class="text-muted">
                        Data destinasi terbaru.
                    </small>

                </div>


                <a
                    href="{{ route(
                        'destinations.index'
                    ) }}"
                    class="
                        btn
                        btn-sm
                        btn-outline-success
                    ">

                    Lihat Semua

                </a>

            </div>


            <div class="admin-card-body">

                @forelse(
                    $latestDestinations
                    as $destination
                )

                    <div
                        class="
                            d-flex
                            align-items-center
                            justify-content-between
                            gap-3
                            py-3
                            border-bottom
                        ">

                        <div
                            class="
                                d-flex
                                align-items-center
                                gap-3
                            ">

                            @if($destination->image)

                                <img
                                    src="{{ asset(
                                        'storage/' .
                                        $destination->image
                                    ) }}"
                                    alt="{{ $destination->name }}"
                                    width="56"
                                    height="56"
                                    style="
                                        object-fit: cover;
                                        border-radius: 12px;
                                    ">

                            @else

                                <div
                                    class="
                                        bg-light
                                        d-flex
                                        align-items-center
                                        justify-content-center
                                    "
                                    style="
                                        width: 56px;
                                        height: 56px;
                                        border-radius: 12px;
                                    ">

                                    W

                                </div>

                            @endif


                            <div>

                                <div class="fw-bold">

                                    {{ $destination->name }}

                                </div>

                                <small class="text-muted">

                                    {{ \Illuminate\Support\Str::limit(
                                        $destination->address
                                            ?? 'Alamat belum diisi',
                                        45
                                    ) }}

                                </small>

                            </div>

                        </div>


                        @if($destination->is_active)

                            <span
                                class="
                                    badge
                                    rounded-pill
                                    bg-success-subtle
                                    text-success
                                ">

                                Aktif

                            </span>

                        @else

                            <span
                                class="
                                    badge
                                    rounded-pill
                                    bg-secondary-subtle
                                    text-secondary
                                ">

                                Nonaktif

                            </span>

                        @endif

                    </div>

                @empty

                    <div class="text-center py-5">

                        <p class="text-muted mb-3">
                            Belum ada destinasi.
                        </p>

                        <a
                            href="{{ route(
                                'destinations.create'
                            ) }}"
                            class="btn btn-admin-primary">

                            Tambah Destinasi

                        </a>

                    </div>

                @endforelse

            </div>

        </div>

    </div>


    {{-- BLOG TERBARU --}}
    <div class="col-xl-6">

        <div class="admin-card h-100">

            <div class="admin-card-header">

                <div>

                    <h5 class="fw-bold mb-1">
                        Artikel Terbaru
                    </h5>

                    <small class="text-muted">
                        Blog dan berita terbaru.
                    </small>

                </div>


                <a
                    href="{{ route('posts.index') }}"
                    class="
                        btn
                        btn-sm
                        btn-outline-success
                    ">

                    Lihat Semua

                </a>

            </div>


            <div class="admin-card-body">

                @forelse($latestPosts as $post)

                    <div
                        class="
                            d-flex
                            align-items-center
                            justify-content-between
                            gap-3
                            py-3
                            border-bottom
                        ">

                        <div
                            class="
                                d-flex
                                align-items-center
                                gap-3
                            ">

                            @if($post->image)

                                <img
                                    src="{{ asset(
                                        'storage/' .
                                        $post->image
                                    ) }}"
                                    alt="{{ $post->title }}"
                                    width="56"
                                    height="56"
                                    style="
                                        object-fit: cover;
                                        border-radius: 12px;
                                    ">

                            @else

                                <div
                                    class="
                                        bg-light
                                        d-flex
                                        align-items-center
                                        justify-content-center
                                    "
                                    style="
                                        width: 56px;
                                        height: 56px;
                                        border-radius: 12px;
                                    ">

                                    B

                                </div>

                            @endif


                            <div>

                                <div class="fw-bold">

                                    {{ \Illuminate\Support\Str::limit(
                                        $post->title,
                                        45
                                    ) }}

                                </div>

                                <small class="text-muted">

                                    {{ $post->created_at
                                        ->format(
                                            'd/m/Y H:i'
                                        )
                                    }}

                                </small>

                            </div>

                        </div>


                        @if(!$post->is_published)

                            <span
                                class="
                                    badge
                                    rounded-pill
                                    bg-secondary-subtle
                                    text-secondary
                                ">

                                Draft

                            </span>

                        @elseif(
                            $post->published_at &&
                            $post->published_at->isFuture()
                        )

                            <span
                                class="
                                    badge
                                    rounded-pill
                                    bg-warning-subtle
                                    text-warning-emphasis
                                ">

                                Terjadwal

                            </span>

                        @else

                            <span
                                class="
                                    badge
                                    rounded-pill
                                    bg-success-subtle
                                    text-success
                                ">

                                Published

                            </span>

                        @endif

                    </div>

                @empty

                    <div class="text-center py-5">

                        <p class="text-muted mb-3">
                            Belum ada artikel.
                        </p>

                        <a
                            href="{{ route(
                                'posts.create'
                            ) }}"
                            class="btn btn-admin-primary">

                            Tambah Artikel

                        </a>

                    </div>

                @endforelse

            </div>

        </div>

    </div>

</div>

@endsection