@extends('layouts.admin')

@section('title', 'Tambah Galeri')

@section('page_title', 'Tambah Galeri')

@section('content')

<div class="mb-4">

    <h2 class="fw-bold mb-1">
        Tambah Foto Galeri
    </h2>

    <p class="text-muted mb-0">
        Tambahkan foto baru ke galeri website.
    </p>

</div>


<div class="admin-card">

    <div class="admin-card-body">

        <form
            action="{{ route('galleries.store') }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf


            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Judul Foto
                </label>

                <input
                    type="text"
                    name="title"
                    class="form-control"
                    value="{{ old('title') }}"
                    placeholder="Contoh: Suasana Umbul Kroman"
                    required>

            </div>


            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Deskripsi
                </label>

                <textarea
                    name="description"
                    class="form-control"
                    rows="4"
                    placeholder="Deskripsi singkat foto...">{{ old('description') }}</textarea>

            </div>


            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Foto
                </label>

                <input
                    type="file"
                    name="image"
                    class="form-control"
                    accept=".jpg,.jpeg,.png,.webp"
                    required
                    data-image-preview="#galleryPreview">

                <small class="text-muted">
                    Format JPG, JPEG, PNG, atau WebP.
                    Maksimal 4 MB.
                </small>

            </div>


            <div class="mb-4">

                <label class="form-label fw-semibold d-block">
                    Preview Foto
                </label>

                <div
                    id="galleryPreviewEmpty"
                    class="admin-preview-empty">

                    Belum ada foto dipilih.

                </div>


                <img
                    id="galleryPreview"
                    src=""
                    alt="Preview Galeri"
                    class="
                        admin-image-preview
                        d-none
                    "
                    data-empty-target="#galleryPreviewEmpty">

            </div>


            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Urutan
                </label>

                <input
                    type="number"
                    name="sort_order"
                    class="form-control"
                    min="0"
                    value="{{ old('sort_order', 0) }}">

                <small class="text-muted">
                    Angka lebih kecil akan tampil lebih dahulu.
                </small>

            </div>


            <div class="form-check form-switch mb-4">

                <input
                    class="form-check-input"
                    type="checkbox"
                    name="is_active"
                    value="1"
                    id="isActive"
                    {{ old('is_active', true)
                        ? 'checked'
                        : ''
                    }}>

                <label
                    class="form-check-label"
                    for="isActive">

                    Tampilkan foto di website

                </label>

            </div>


            <div class="d-flex flex-wrap gap-2">

                <button
                    type="submit"
                    class="btn btn-admin-primary">

                    Simpan Foto

                </button>


                <a
                    href="{{ route('galleries.index') }}"
                    class="btn btn-light">

                    Batal

                </a>

            </div>

        </form>

    </div>

</div>

@endsection