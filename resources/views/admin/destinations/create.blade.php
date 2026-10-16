@extends('layouts.admin')

@section('title', 'Tambah Destinasi')

@section('page_title', 'Tambah Destinasi')

@section('content')

<div class="mb-4">

    <h2 class="fw-bold mb-1">
        Tambah Destinasi
    </h2>

    <p class="text-muted mb-0">
        Tambahkan destinasi wisata baru ke website.
    </p>

</div>


<div class="admin-card">

    <div class="admin-card-body">

        <form
            action="{{ route('destinations.store') }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf


            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Nama Destinasi
                </label>

                <input
                    type="text"
                    name="name"
                    class="form-control"
                    value="{{ old('name') }}"
                    required>

            </div>


            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Deskripsi
                </label>

                <textarea
                    name="description"
                    class="form-control"
                    rows="6">{{ old('description') }}</textarea>

            </div>


            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Alamat
                </label>

                <textarea
                    name="address"
                    class="form-control"
                    rows="3">{{ old('address') }}</textarea>

            </div>


            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Google Maps URL
                </label>

                <input
                    type="url"
                    name="google_maps_url"
                    class="form-control"
                    value="{{ old('google_maps_url') }}"
                    placeholder="https://maps.google.com/...">

            </div>


            <div class="row">

                <div class="col-md-6 mb-3">

                    <label class="form-label fw-semibold">
                        Jam Buka
                    </label>

                    <input
                        type="text"
                        name="opening_hours"
                        class="form-control"
                        value="{{ old('opening_hours') }}"
                        placeholder="08.00 - 17.00">

                </div>


                <div class="col-md-6 mb-3">

                    <label class="form-label fw-semibold">
                        Harga Tiket
                    </label>

                    <input
                        type="number"
                        name="ticket_price"
                        class="form-control"
                        min="0"
                        step="1"
                        value="{{ old('ticket_price') }}"
                        placeholder="10000">

                </div>

            </div>


            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Fasilitas
                </label>

                <textarea
                    name="facilities"
                    class="form-control"
                    rows="4"
                    placeholder="Parkir, Toilet, Mushola, Warung...">{{ old('facilities') }}</textarea>

            </div>


            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Gambar Destinasi
                </label>

                <input
                    type="file"
                    name="image"
                    class="form-control"
                    accept=".jpg,.jpeg,.png,.webp"
                    data-image-preview="#destinationPreview">

                <small class="text-muted">
                    JPG, PNG atau WebP. Maksimal 4 MB.
                </small>

            </div>


            <div class="mb-4">

                <label class="form-label fw-semibold d-block">
                    Preview
                </label>

                <div
                    id="destinationPreviewEmpty"
                    class="admin-preview-empty">

                    Belum ada gambar dipilih.

                </div>

                <img
                    id="destinationPreview"
                    src=""
                    alt="Preview Destinasi"
                    class="
                        admin-image-preview
                        d-none
                    "
                    data-empty-target="#destinationPreviewEmpty">

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
                        true
                    ) ? 'checked' : '' }}>

                <label
                    class="form-check-label"
                    for="isActive">

                    Tampilkan destinasi di website

                </label>

            </div>


            <div class="d-flex flex-wrap gap-2">

                <button
                    type="submit"
                    class="btn btn-admin-primary">

                    Simpan Destinasi

                </button>

                <a
                    href="{{ route('destinations.index') }}"
                    class="btn btn-light">

                    Batal

                </a>

            </div>

        </form>

    </div>

</div>

@endsection