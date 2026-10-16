@extends('layouts.admin')

@section('title', 'Profil Desa')

@section('page_title', 'Profil Desa')

@section('content')

<div class="mb-4">

    <h2 class="fw-bold mb-1">
        Profil Desa
    </h2>

    <p class="text-muted mb-0">
        Kelola informasi profil yang ditampilkan di website.
    </p>

</div>


<form
    action="{{ route('admin.profile.update') }}"
    method="POST"
    enctype="multipart/form-data">

    @csrf
    @method('PUT')


    {{-- INFORMASI UTAMA --}}
    <div class="admin-card mb-4">

        <div class="admin-card-header">

            <div>

                <h5 class="fw-bold mb-1">
                    Informasi Utama
                </h5>

                <small class="text-muted">
                    Identitas utama Umbul Kroman.
                </small>

            </div>

        </div>


        <div class="admin-card-body">

            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Nama
                </label>

                <input
                    type="text"
                    name="name"
                    class="form-control"
                    value="{{ old(
                        'name',
                        $profile->name
                    ) }}"
                    required>

            </div>


            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Tagline
                </label>

                <input
                    type="text"
                    name="tagline"
                    class="form-control"
                    value="{{ old(
                        'tagline',
                        $profile->tagline
                    ) }}"
                    placeholder="Pesona Alam di Kabupaten Klaten">

            </div>


            <div>

                <label class="form-label fw-semibold">
                    Deskripsi
                </label>

                <textarea
                    name="description"
                    class="form-control"
                    rows="6"
                    placeholder="Deskripsi singkat mengenai Umbul Kroman...">{{ old(
                        'description',
                        $profile->description
                    ) }}</textarea>

            </div>

        </div>

    </div>


    {{-- SEJARAH VISI MISI --}}
    <div class="admin-card mb-4">

        <div class="admin-card-header">

            <div>

                <h5 class="fw-bold mb-1">
                    Sejarah, Visi & Misi
                </h5>

                <small class="text-muted">
                    Informasi lengkap mengenai desa dan wisata.
                </small>

            </div>

        </div>


        <div class="admin-card-body">

            <div class="mb-4">

                <label class="form-label fw-semibold">
                    Sejarah
                </label>

                <textarea
                    name="history"
                    class="form-control"
                    rows="8"
                    placeholder="Tuliskan sejarah Umbul Kroman...">{{ old(
                        'history',
                        $profile->history
                    ) }}</textarea>

            </div>


            <div class="mb-4">

                <label class="form-label fw-semibold">
                    Visi
                </label>

                <textarea
                    name="vision"
                    class="form-control"
                    rows="4">{{ old(
                        'vision',
                        $profile->vision
                    ) }}</textarea>

            </div>


            <div>

                <label class="form-label fw-semibold">
                    Misi
                </label>

                <textarea
                    name="mission"
                    class="form-control"
                    rows="7">{{ old(
                        'mission',
                        $profile->mission
                    ) }}</textarea>

            </div>

        </div>

    </div>


    {{-- KONTAK --}}
    <div class="admin-card mb-4">

        <div class="admin-card-header">

            <div>

                <h5 class="fw-bold mb-1">
                    Kontak & Lokasi
                </h5>

                <small class="text-muted">
                    Informasi kontak dan lokasi yang ditampilkan kepada pengunjung.
                </small>

            </div>

        </div>


        <div class="admin-card-body">

            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Alamat
                </label>

                <textarea
                    name="address"
                    class="form-control"
                    rows="3">{{ old(
                        'address',
                        $profile->address
                    ) }}</textarea>

            </div>


            <div class="row">

                <div class="col-md-6 mb-3">

                    <label class="form-label fw-semibold">
                        Telepon
                    </label>

                    <input
                        type="text"
                        name="phone"
                        class="form-control"
                        value="{{ old(
                            'phone',
                            $profile->phone
                        ) }}"
                        placeholder="081234567890">

                </div>


                <div class="col-md-6 mb-3">

                    <label class="form-label fw-semibold">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="{{ old(
                            'email',
                            $profile->email
                        ) }}"
                        placeholder="info@umbulkroman.com">

                </div>

            </div>


            <div>

                <label class="form-label fw-semibold">
                    Google Maps Embed
                </label>

                <textarea
                    name="google_maps_embed"
                    class="form-control"
                    rows="6"
                    placeholder='<iframe src="https://www.google.com/maps/embed?..."></iframe>'>{{ old(
                        'google_maps_embed',
                        $profile->google_maps_embed
                    ) }}</textarea>

                <small class="text-muted">
                    Buka Google Maps → Bagikan → Sematkan peta →
                    salin kode iframe.
                </small>

            </div>

        </div>

    </div>


    {{-- MEDIA --}}
    <div class="admin-card mb-4">

        <div class="admin-card-header">

            <div>

                <h5 class="fw-bold mb-1">
                    Media Website
                </h5>

                <small class="text-muted">
                    Kelola logo dan gambar utama website.
                </small>

            </div>

        </div>


        <div class="admin-card-body">

            <div class="row g-4">

                {{-- LOGO --}}
                <div class="col-lg-5">

                    <label class="form-label fw-semibold d-block">
                        Logo
                    </label>


                    <div class="mb-3">

                        @if($profile->logo)

                            <img
                                id="logoPreview"
                                src="{{ asset(
                                    'storage/' .
                                    $profile->logo
                                ) }}"
                                alt="Logo"
                                class="
                                    admin-logo-preview
                                    mb-2
                                ">

                        @else

                            <div
                                id="logoPreviewEmpty"
                                class="admin-preview-empty"
                                style="
                                    max-width: 150px;
                                    height: 150px;
                                ">

                                Belum ada logo.

                            </div>


                            <img
                                id="logoPreview"
                                src=""
                                alt="Preview Logo"
                                class="
                                    admin-logo-preview
                                    d-none
                                "
                                data-empty-target="#logoPreviewEmpty">

                        @endif

                    </div>


                    <input
                        type="file"
                        name="logo"
                        class="form-control"
                        accept=".jpg,.jpeg,.png,.webp"
                        data-image-preview="#logoPreview">

                    <small class="text-muted">
                        Disarankan PNG/WebP dengan latar transparan.
                        Maksimal 2 MB.
                    </small>

                </div>


                {{-- HERO --}}
                <div class="col-lg-7">

                    <label class="form-label fw-semibold d-block">
                        Hero / Cover Website
                    </label>


                    <div class="mb-3">

                        @if($profile->hero_image)

                            <img
                                id="heroPreview"
                                src="{{ asset(
                                    'storage/' .
                                    $profile->hero_image
                                ) }}"
                                alt="Hero"
                                class="admin-image-preview">

                        @else

                            <div
                                id="heroPreviewEmpty"
                                class="admin-preview-empty">

                                Belum ada gambar hero.

                            </div>


                            <img
                                id="heroPreview"
                                src=""
                                alt="Preview Hero"
                                class="
                                    admin-image-preview
                                    d-none
                                "
                                data-empty-target="#heroPreviewEmpty">

                        @endif

                    </div>


                    <input
                        type="file"
                        name="hero_image"
                        class="form-control"
                        accept=".jpg,.jpeg,.png,.webp"
                        data-image-preview="#heroPreview">

                    <small class="text-muted">
                        Disarankan gambar landscape beresolusi tinggi.
                        Maksimal 4 MB.
                    </small>

                </div>

            </div>

        </div>

    </div>


    <div class="d-flex flex-wrap gap-2">

        <button
            type="submit"
            class="btn btn-admin-primary">

            Simpan Profil

        </button>


        <a
            href="{{ route('profile') }}"
            target="_blank"
            class="btn btn-light">

            Lihat Halaman Publik ↗

        </a>

    </div>

</form>

@endsection