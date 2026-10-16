@extends('layouts.admin')

@section('title', 'Edit Destinasi')

@section('page_title', 'Edit Destinasi')

@section('content')

<div class="mb-4">

    <h2 class="fw-bold mb-1">
        Edit Destinasi
    </h2>

    <p class="text-muted mb-0">
        Perbarui informasi {{ $destination->name }}.
    </p>

</div>


<div class="admin-card">

    <div class="admin-card-body">

        <form
            action="{{ route(
                'destinations.update',
                $destination
            ) }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf
            @method('PUT')


            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Nama Destinasi
                </label>

                <input
                    type="text"
                    name="name"
                    class="form-control"
                    value="{{ old(
                        'name',
                        $destination->name
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
                    rows="6">{{ old(
                        'description',
                        $destination->description
                    ) }}</textarea>

            </div>


            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Alamat
                </label>

                <textarea
                    name="address"
                    class="form-control"
                    rows="3">{{ old(
                        'address',
                        $destination->address
                    ) }}</textarea>

            </div>


            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Google Maps URL
                </label>

                <input
                    type="url"
                    name="google_maps_url"
                    class="form-control"
                    value="{{ old(
                        'google_maps_url',
                        $destination->google_maps_url
                    ) }}">

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
                        value="{{ old(
                            'opening_hours',
                            $destination->opening_hours
                        ) }}">

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
                        value="{{ old(
                            'ticket_price',
                            $destination->ticket_price
                        ) }}">

                </div>

            </div>


            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Fasilitas
                </label>

                <textarea
                    name="facilities"
                    class="form-control"
                    rows="4">{{ old(
                        'facilities',
                        $destination->facilities
                    ) }}</textarea>

            </div>


            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Ganti Gambar
                </label>

                <input
                    type="file"
                    name="image"
                    class="form-control"
                    accept=".jpg,.jpeg,.png,.webp"
                    data-image-preview="#destinationPreview">

                <small class="text-muted">
                    Kosongkan jika gambar tidak ingin diganti.
                </small>

            </div>


            <div class="mb-4">

                <label class="form-label fw-semibold d-block">
                    Preview Gambar
                </label>

                @if($destination->image)

                    <img
                        id="destinationPreview"
                        src="{{ asset(
                            'storage/' .
                            $destination->image
                        ) }}"
                        alt="{{ $destination->name }}"
                        class="admin-image-preview">

                @else

                    <div
                        id="destinationPreviewEmpty"
                        class="admin-preview-empty">

                        Belum ada gambar.

                    </div>

                    <img
                        id="destinationPreview"
                        src=""
                        alt="Preview"
                        class="
                            admin-image-preview
                            d-none
                        "
                        data-empty-target="#destinationPreviewEmpty">

                @endif

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
                        $destination->is_active
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

                    Simpan Perubahan

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