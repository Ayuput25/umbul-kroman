@extends('layouts.admin')

@section('title', 'Tambah Artikel')

@section('page_title', 'Tambah Artikel')

@section('content')

<div class="mb-4">

    <h2 class="fw-bold mb-1">
        Tambah Blog / Berita
    </h2>

    <p class="text-muted mb-0">
        Buat artikel atau berita baru untuk website.
    </p>

</div>


<div class="admin-card">

    <div class="admin-card-body">

        <form
            action="{{ route('posts.store') }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf


            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Judul Artikel
                </label>

                <input
                    type="text"
                    name="title"
                    class="form-control"
                    value="{{ old('title') }}"
                    required>

            </div>


            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Ringkasan
                </label>

                <textarea
                    name="excerpt"
                    class="form-control"
                    rows="3"
                    placeholder="Ringkasan singkat artikel...">{{ old('excerpt') }}</textarea>

            </div>


            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Isi Artikel
                </label>

                <textarea
                    name="content"
                    class="form-control"
                    rows="14"
                    required>{{ old('content') }}</textarea>

            </div>


            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Gambar Utama
                </label>

                <input
                    type="file"
                    name="image"
                    class="form-control"
                    accept=".jpg,.jpeg,.png,.webp"
                    data-image-preview="#postPreview">

                <small class="text-muted">
                    Maksimal 4 MB.
                </small>

            </div>


            <div class="mb-4">

                <label class="form-label fw-semibold d-block">
                    Preview
                </label>

                <div
                    id="postPreviewEmpty"
                    class="admin-preview-empty">

                    Belum ada gambar dipilih.

                </div>

                <img
                    id="postPreview"
                    src=""
                    alt="Preview Artikel"
                    class="
                        admin-image-preview
                        d-none
                    "
                    data-empty-target="#postPreviewEmpty">

            </div>


            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Tanggal Publish
                </label>

                <input
                    type="datetime-local"
                    name="published_at"
                    class="form-control"
                    value="{{ old('published_at') }}">

                <small class="text-muted">
                    Kosongkan untuk menggunakan waktu saat artikel dipublish.
                </small>

            </div>


            <div class="form-check form-switch mb-4">

                <input
                    class="form-check-input"
                    type="checkbox"
                    name="is_published"
                    value="1"
                    id="isPublished"
                    {{ old('is_published')
                        ? 'checked'
                        : ''
                    }}>

                <label
                    class="form-check-label"
                    for="isPublished">

                    Publish artikel

                </label>

            </div>


            <div class="d-flex flex-wrap gap-2">

                <button
                    type="submit"
                    class="btn btn-admin-primary">

                    Simpan Artikel

                </button>

                <a
                    href="{{ route('posts.index') }}"
                    class="btn btn-light">

                    Batal

                </a>

            </div>

        </form>

    </div>

</div>

@endsection