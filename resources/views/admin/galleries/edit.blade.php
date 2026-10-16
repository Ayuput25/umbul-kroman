@extends('layouts.admin')

@section('title', 'Edit Galeri')

@section('page_title', 'Edit Galeri')

@section('content')

<div class="mb-4">

    <h2 class="fw-bold mb-1">
        Edit Galeri
    </h2>

    <p class="text-muted mb-0">
        Perbarui foto {{ $gallery->title }}.
    </p>

</div>


<div class="admin-card">

    <div class="admin-card-body">

        <form
            action="{{ route(
                'galleries.update',
                $gallery
            ) }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf
            @method('PUT')


            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Judul Foto
                </label>

                <input
                    type="text"
                    name="title"
                    class="form-control"
                    value="{{ old(
                        'title',
                        $gallery->title
                    ) }}"
                    required>

            </div>


            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Deskripsi
                </label>

                <textarea
                    name="description"
                    class="form-control"
                    rows="4">{{ old(
                        'description',
                        $gallery->description
                    ) }}</textarea>

            </div>


            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Ganti Foto
                </label>

                <input
                    type="file"
                    name="image"
                    class="form-control"
                    accept=".jpg,.jpeg,.png,.webp"
                    data-image-preview="#galleryPreview">

                <small class="text-muted">
                    Kosongkan jika foto tidak ingin diganti.
                </small>

            </div>


            <div class="mb-4">

                <label class="form-label fw-semibold d-block">
                    Preview Foto
                </label>

                <img
                    id="galleryPreview"
                    src="{{ asset(
                        'storage/' .
                        $gallery->image
                    ) }}"
                    alt="{{ $gallery->title }}"
                    class="admin-image-preview">

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
                    value="{{ old(
                        'sort_order',
                        $gallery->sort_order
                    ) }}">

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
                    {{ old(
                        'is_active',
                        $gallery->is_active
                    ) ? 'checked' : '' }}>

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

                    Simpan Perubahan

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