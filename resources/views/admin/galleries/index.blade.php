@extends('layouts.admin')

@section('title', 'Galeri')

@section('page_title', 'Galeri')

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
            Galeri Foto
        </h2>

        <p class="text-muted mb-0">
            Kelola beberapa foto sekaligus.
        </p>

    </div>


    <a
        href="{{ route('galleries.create') }}"
        class="btn btn-admin-primary">

        + Tambah Foto

    </a>

</div>


<div class="admin-card mb-4">

    <div class="admin-card-body">

        <form
            method="GET"
            action="{{ route('galleries.index') }}">

            <div class="row g-3">

                <div class="col-lg-7">

                    <label class="form-label fw-semibold">
                        Pencarian
                    </label>

                    <input
                        type="text"
                        name="q"
                        class="form-control"
                        value="{{ $search }}"
                        placeholder="Cari judul atau deskripsi...">

                </div>


                <div class="col-lg-3">

                    <label class="form-label fw-semibold">
                        Status
                    </label>

                    <select
                        name="status"
                        class="form-select">

                        <option value="">
                            Semua Status
                        </option>

                        <option
                            value="active"
                            {{ $status === 'active'
                                ? 'selected'
                                : ''
                            }}>

                            Aktif

                        </option>

                        <option
                            value="inactive"
                            {{ $status === 'inactive'
                                ? 'selected'
                                : ''
                            }}>

                            Nonaktif

                        </option>

                    </select>

                </div>


                <div
                    class="
                        col-lg-2
                        d-flex
                        align-items-end
                        gap-2
                    ">

                    <button
                        type="submit"
                        class="
                            btn
                            btn-admin-primary
                            flex-grow-1
                        ">

                        Filter

                    </button>

                    @if($search || $status)

                        <a
                            href="{{ route('galleries.index') }}"
                            class="btn btn-light">

                            Reset

                        </a>

                    @endif

                </div>

            </div>

        </form>

    </div>

</div>


<form
    id="bulkForm"
    method="POST"
    action="{{ route('galleries.bulk') }}">

    @csrf


    <div class="admin-card">

        <div class="admin-card-header">

            <div>

                <h5 class="fw-bold mb-1">
                    Daftar Galeri
                </h5>

                <small class="text-muted">
                    Total {{ $galleries->total() }} foto.
                </small>

            </div>

        </div>


        <div class="p-3 border-bottom">

            <div
                class="
                    d-flex
                    flex-column
                    flex-md-row
                    align-items-md-center
                    gap-2
                ">

                <small class="text-muted me-md-2">

                    Dipilih:

                    <strong id="selectedCount">
                        0
                    </strong>

                </small>


                <select
                    name="action"
                    id="bulkAction"
                    class="form-select"
                    style="max-width:230px;">

                    <option value="">
                        Pilih Aksi
                    </option>

                    <option value="activate">
                        Aktifkan
                    </option>

                    <option value="deactivate">
                        Nonaktifkan
                    </option>

                    <option value="delete">
                        Hapus
                    </option>

                </select>


                <button
                    type="button"
                    id="bulkActionButton"
                    class="btn btn-admin-primary">

                    Terapkan

                </button>

            </div>

        </div>


        <div class="admin-card-body p-0">

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>

                            <th width="50">

                                <input
                                    type="checkbox"
                                    id="selectAll"
                                    class="form-check-input">

                            </th>

                            <th>Foto</th>
                            <th>Judul</th>
                            <th>Urutan</th>
                            <th>Status</th>
                            <th width="190">Aksi</th>

                        </tr>

                    </thead>


                    <tbody>

                    @forelse(
                        $galleries as $gallery
                    )

                        <tr>

                            <td>

                                <input
                                    type="checkbox"
                                    name="ids[]"
                                    value="{{ $gallery->id }}"
                                    class="
                                        form-check-input
                                        row-checkbox
                                    ">

                            </td>


                            <td>

                                <img
                                    src="{{ asset(
                                        'storage/' .
                                        $gallery->image
                                    ) }}"
                                    alt="{{ $gallery->title }}"
                                    width="110"
                                    height="75"
                                    style="
                                        object-fit:cover;
                                        border-radius:12px;
                                    ">

                            </td>


                            <td>

                                <div class="fw-bold">
                                    {{ $gallery->title }}
                                </div>

                                @if($gallery->description)

                                    <small class="text-muted">

                                        {{ \Illuminate\Support\Str::limit(
                                            $gallery->description,
                                            70
                                        ) }}

                                    </small>

                                @endif

                            </td>


                            <td>

                                <span
                                    class="
                                        badge
                                        rounded-pill
                                        bg-light
                                        text-dark
                                    ">

                                    {{ $gallery->sort_order }}

                                </span>

                            </td>


                            <td>

                                @if($gallery->is_active)

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

                            </td>


                            <td>

                                <div class="d-flex gap-2">

                                    <a
                                        href="{{ route(
                                            'galleries.edit',
                                            $gallery
                                        ) }}"
                                        class="
                                            btn
                                            btn-warning
                                            btn-sm
                                        ">

                                        Edit

                                    </a>


                                    <button
                                        type="button"
                                        class="
                                            btn
                                            btn-danger
                                            btn-sm
                                            single-delete-button
                                        "
                                        data-url="{{ route(
                                            'galleries.destroy',
                                            $gallery
                                        ) }}"
                                        data-name="{{ $gallery->title }}">

                                        Hapus

                                    </button>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="
                                    text-center
                                    py-5
                                    text-muted
                                ">

                                Foto tidak ditemukan.

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        @if($galleries->hasPages())

            <div class="p-3 border-top">

                {{ $galleries->links() }}

            </div>

        @endif

    </div>

</form>


@include('admin.partials.bulk-script', [
    'itemLabel' => 'foto'
])


<div
    class="modal fade"
    id="deleteModal"
    tabindex="-1">

    <div
        class="
            modal-dialog
            modal-dialog-centered
        ">

        <div
            class="
                modal-content
                border-0
                shadow
            "
            style="border-radius:18px;">

            <div class="modal-header">

                <h5 class="modal-title fw-bold">
                    Hapus Foto
                </h5>

                <button
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>


            <div class="modal-body">

                Yakin ingin menghapus

                <strong id="deleteItemName"></strong>?

            </div>


            <div class="modal-footer">

                <button
                    class="btn btn-light"
                    data-bs-dismiss="modal">

                    Batal

                </button>


                <form
                    id="singleDeleteForm"
                    method="POST">

                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="btn btn-danger">

                        Hapus

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>


<script>
document.addEventListener(
    'DOMContentLoaded',
    function () {

        const buttons =
            document.querySelectorAll(
                '.single-delete-button'
            );

        const form =
            document.getElementById(
                'singleDeleteForm'
            );

        const name =
            document.getElementById(
                'deleteItemName'
            );


        buttons.forEach(
            button => {

                button.addEventListener(
                    'click',
                    function () {

                        form.action =
                            this.dataset.url;

                        name.textContent =
                            this.dataset.name;

                        new bootstrap.Modal(
                            document.getElementById(
                                'deleteModal'
                            )
                        ).show();
                    }
                );
            }
        );
    }
);
</script>

@endsection