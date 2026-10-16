@extends('layouts.admin')

@section('title', 'Pengaturan Website')

@section('page_title', 'Pengaturan Website')

@section('content')

<div class="mb-4">

    <h2 class="fw-bold mb-1">
        Pengaturan Website
    </h2>

    <p class="text-muted mb-0">
        Kelola identitas website, SEO, WhatsApp,
        media sosial, favicon, dan footer.
    </p>

</div>


<form
    action="{{ route('admin.settings.update') }}"
    method="POST"
    enctype="multipart/form-data">

    @csrf
    @method('PUT')


    {{-- WEBSITE --}}
    <div class="admin-card mb-4">

        <div class="admin-card-header">

            <div>

                <h5 class="fw-bold mb-1">
                    Identitas Website
                </h5>

                <small class="text-muted">
                    Judul dan favicon website.
                </small>

            </div>

        </div>


        <div class="admin-card-body">

            <div class="mb-4">

                <label class="form-label fw-semibold">
                    Judul Website
                </label>

                <input
                    type="text"
                    name="site_title"
                    class="form-control"
                    value="{{ old(
                        'site_title',
                        $settings->site_title
                    ) }}"
                    placeholder="Umbul Kroman">

            </div>


            <div>

                <label class="form-label fw-semibold d-block">
                    Favicon
                </label>


                <div class="mb-3">

                    @if($settings->favicon)

                        <img
                            id="faviconPreview"
                            src="{{ asset(
                                'storage/' .
                                $settings->favicon
                            ) }}"
                            alt="Favicon"
                            class="admin-logo-preview">

                    @else

                        <div
                            id="faviconPreviewEmpty"
                            class="admin-preview-empty"
                            style="
                                max-width: 150px;
                                height: 150px;
                            ">

                            Belum ada favicon.

                        </div>


                        <img
                            id="faviconPreview"
                            src=""
                            alt="Preview Favicon"
                            class="
                                admin-logo-preview
                                d-none
                            "
                            data-empty-target="#faviconPreviewEmpty">

                    @endif

                </div>


                <input
                    type="file"
                    name="favicon"
                    class="form-control"
                    accept=".png,.jpg,.jpeg,.webp"
                    data-image-preview="#faviconPreview">

                <small class="text-muted">
                    Disarankan ukuran persegi, misalnya 512×512.
                    Maksimal 1 MB.
                </small>

            </div>

        </div>

    </div>


    {{-- SEO --}}
    <div class="admin-card mb-4">

        <div class="admin-card-header">

            <div>

                <h5 class="fw-bold mb-1">
                    SEO
                </h5>

                <small class="text-muted">
                    Informasi website untuk mesin pencari.
                </small>

            </div>

        </div>


        <div class="admin-card-body">

            <div class="mb-4">

                <label class="form-label fw-semibold">
                    Meta Description
                </label>

                <textarea
                    name="meta_description"
                    class="form-control"
                    rows="4"
                    placeholder="Deskripsi website untuk Google...">{{ old(
                        'meta_description',
                        $settings->meta_description
                    ) }}</textarea>

                <small class="text-muted">
                    Disarankan sekitar 150–160 karakter.
                </small>

            </div>


            <div>

                <label class="form-label fw-semibold">
                    Meta Keywords
                </label>

                <textarea
                    name="meta_keywords"
                    class="form-control"
                    rows="3"
                    placeholder="umbul kroman, wisata klaten, wisata air, ...">{{ old(
                        'meta_keywords',
                        $settings->meta_keywords
                    ) }}</textarea>

            </div>

        </div>

    </div>


    {{-- WHATSAPP --}}
    <div class="admin-card mb-4">

        <div class="admin-card-header">

            <div>

                <h5 class="fw-bold mb-1">
                    WhatsApp
                </h5>

                <small class="text-muted">
                    Pengaturan tombol WhatsApp mengambang.
                </small>

            </div>

        </div>


        <div class="admin-card-body">

            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Nomor WhatsApp
                </label>

                <input
                    type="text"
                    name="whatsapp_number"
                    class="form-control"
                    value="{{ old(
                        'whatsapp_number',
                        $settings->whatsapp_number
                    ) }}"
                    placeholder="081234567890">

                <small class="text-muted">
                    Bisa menggunakan format 08... atau 628...
                </small>

            </div>


            <div class="mb-4">

                <label class="form-label fw-semibold">
                    Pesan Otomatis
                </label>

                <textarea
                    name="whatsapp_message"
                    class="form-control"
                    rows="4"
                    placeholder="Halo, saya ingin bertanya mengenai Umbul Kroman.">{{ old(
                        'whatsapp_message',
                        $settings->whatsapp_message
                    ) }}</textarea>

            </div>


            <div class="form-check form-switch">

                <input
                    class="form-check-input"
                    type="checkbox"
                    name="show_whatsapp"
                    value="1"
                    id="showWhatsapp"
                    {{ old(
                        'show_whatsapp',
                        $settings->show_whatsapp
                    ) ? 'checked' : '' }}>

                <label
                    class="form-check-label"
                    for="showWhatsapp">

                    Tampilkan tombol WhatsApp di website

                </label>

            </div>

        </div>

    </div>


    {{-- MEDIA SOSIAL --}}
    <div class="admin-card mb-4">

        <div class="admin-card-header">

            <div>

                <h5 class="fw-bold mb-1">
                    Media Sosial
                </h5>

                <small class="text-muted">
                    Tautan akun media sosial resmi.
                </small>

            </div>

        </div>


        <div class="admin-card-body">

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label class="form-label fw-semibold">
                        Instagram
                    </label>

                    <input
                        type="url"
                        name="instagram_url"
                        class="form-control"
                        value="{{ old(
                            'instagram_url',
                            $settings->instagram_url
                        ) }}"
                        placeholder="https://instagram.com/...">

                </div>


                <div class="col-md-6 mb-3">

                    <label class="form-label fw-semibold">
                        Facebook
                    </label>

                    <input
                        type="url"
                        name="facebook_url"
                        class="form-control"
                        value="{{ old(
                            'facebook_url',
                            $settings->facebook_url
                        ) }}"
                        placeholder="https://facebook.com/...">

                </div>


                <div class="col-md-6 mb-3">

                    <label class="form-label fw-semibold">
                        TikTok
                    </label>

                    <input
                        type="url"
                        name="tiktok_url"
                        class="form-control"
                        value="{{ old(
                            'tiktok_url',
                            $settings->tiktok_url
                        ) }}"
                        placeholder="https://tiktok.com/@...">

                </div>


                <div class="col-md-6 mb-3">

                    <label class="form-label fw-semibold">
                        YouTube
                    </label>

                    <input
                        type="url"
                        name="youtube_url"
                        class="form-control"
                        value="{{ old(
                            'youtube_url',
                            $settings->youtube_url
                        ) }}"
                        placeholder="https://youtube.com/@...">

                </div>

            </div>

        </div>

    </div>


    {{-- FOOTER --}}
    <div class="admin-card mb-4">

        <div class="admin-card-header">

            <div>

                <h5 class="fw-bold mb-1">
                    Footer
                </h5>

                <small class="text-muted">
                    Teks tambahan di bagian bawah website.
                </small>

            </div>

        </div>


        <div class="admin-card-body">

            <label class="form-label fw-semibold">
                Teks Footer
            </label>

            <input
                type="text"
                name="footer_text"
                class="form-control"
                value="{{ old(
                    'footer_text',
                    $settings->footer_text
                ) }}"
                placeholder="Website Informasi Wisata Umbul Kroman">

        </div>

    </div>


    <div class="d-flex flex-wrap gap-2">

        <button
            type="submit"
            class="btn btn-admin-primary">

            Simpan Pengaturan

        </button>


        <a
            href="{{ route('home') }}"
            target="_blank"
            class="btn btn-light">

            Lihat Website ↗

        </a>

    </div>

</form>

@endsection