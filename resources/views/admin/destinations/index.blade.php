@extends('layouts.admin')

@section('title', 'Destinasi')

@section('page_title', 'Destinasi Wisata')

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
            Destinasi Wisata
        </h2>

        <p class="text-muted mb-0">
            Cari, filter, dan kelola destinasi wisata.
        </p>

    </div>

    <a
        href="{{ route('destinations.create') }}"
        class="btn btn-admin-primary">

        + Tambah Destinasi

    </a>

</div>


{{-- FILTER --}}
<div class="admin-card mb-4">

    <div class="admin-card-body">

        <form
            method="GET"
            action="{{ route('destinations.index') }}">

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
                        placeholder="Cari nama, alamat, slug, atau deskripsi...">

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
                        class="btn btn-admin-primary flex-grow-1">

                        Filter

                    </button>

                    @if($search || $status)

                        <a
                            href="{{ route('destinations.index') }}"
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
    action="{{ route('destinations.bulk') }}"
    method="POST">

    @csrf


    <div class="admin-card">

        <div class="admin-card-header">

            <div>

                <h5 class="fw-bold mb-1">
                    Daftar Destinasi
                </h5>

                <small class="text-muted">

                    Menampilkan
                    {{ $destinations->firstItem() ?? 0 }}
                    -
                    {{ $destinations->lastItem() ?? 0 }}
                    dari
                    {{ $destinations->total() }}
                    data.

                </small>

            </div>

        </div>


        {{-- BULK TOOLBAR --}}
        <div class="p-3 border-bottom">

            <div
                class="
                    d-flex
                    flex-column
                    flex-md-row
                    gap-2
                    align-items-md-center
                ">

                <div class="text-muted small me-md-2">

                    Dipilih:

                    <strong id="selectedCount">
                        0
                    </strong>

                </div>


                <select
                    name="action"
                    id="bulkAction"
                    class="form-select"
                    style="max-width: 230px;">

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

                            <th style="width: 50px;">

                                <input
                                    type="checkbox"
                                    class="form-check-input"
                                    id="selectAll">

                            </th>

                            <th>Gambar</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th width="190">Aksi</th>

                        </tr>

                    </thead>


                    <tbody>

                    @forelse(
                        $destinations
                        as $destination
                    )

                        <tr>

                            <td>

                                <input
                                    type="checkbox"
                                    name="ids[]"
                                    value="{{ $destination->id }}"
                                    class="
                                        form-check-input
                                        row-checkbox
                                    ">

                            </td>


                            <td>

                                @if($destination->image)

                                    <img
                                        src="{{ asset(
                                            'storage/' .
                                            $destination->image
                                        ) }}"
                                        alt="{{ $destination->name }}"
                                        width="100"
                                        height="70"
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
                                            text-muted
                                        "
                                        style="
                                            width: 100px;
                                            height: 70px;
                                            border-radius: 12px;
                                        ">

                                        No Image

                                    </div>

                                @endif

                            </td>


                            <td>

                                <div class="fw-bold">
                                    {{ $destination->name }}
                                </div>

                                <small class="text-muted">
                                    {{ $destination->slug }}
                                </small>

                            </td>


                            <td>

                                {{ $destination->address
                                    ? \Illuminate\Support\Str::limit(
                                        $destination->address,
                                        55
                                    )
                                    : '-'
                                }}

                            </td>


                            <td>

                                @if(
                                    $destination->ticket_price
                                    !== null
                                )

                                    @if(
                                        (float)
                                        $destination->ticket_price
                                        === 0.0
                                    )

                                        <span
                                            class="
                                                text-success
                                                fw-semibold
                                            ">

                                            Gratis

                                        </span>

                                    @else

                                        Rp {{ number_format(
                                            $destination->ticket_price,
                                            0,
                                            ',',
                                            '.'
                                        ) }}

                                    @endif

                                @else

                                    -

                                @endif

                            </td>


                            <td>

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

                            </td>


                            <td>

                                <div class="d-flex gap-2">

                                    <a
                                        href="{{ route(
                                            'destinations.edit',
                                            $destination
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
                                            'destinations.destroy',
                                            $destination
                                        ) }}"
                                        data-name="{{ $destination->name }}">

                                        Hapus

                                    </button>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="
                                    text-center
                                    py-5
                                    text-muted
                                ">

                                Tidak ada destinasi ditemukan.

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        @if($destinations->hasPages())

            <div class="p-3 border-top">

                {{ $destinations->links() }}

            </div>

        @endif

    </div>

</form>


{{-- MODAL BULK --}}
<div
    class="modal fade"
    id="bulkConfirmModal"
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
            style="border-radius: 18px;">

            <div class="modal-header">

                <h5 class="modal-title fw-bold">
                    Konfirmasi Aksi
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>


            <div class="modal-body">

                <p
                    id="bulkConfirmText"
                    class="mb-0">

                    Lanjutkan aksi?

                </p>

            </div>


            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-light"
                    data-bs-dismiss="modal">

                    Batal

                </button>

                <button
                    type="button"
                    id="bulkConfirmButton"
                    class="btn btn-admin-primary">

                    Ya, Lanjutkan

                </button>

            </div>

        </div>

    </div>

</div>


{{-- MODAL DELETE SINGLE --}}
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
            style="border-radius: 18px;">

            <div class="modal-header">

                <h5 class="modal-title fw-bold">
                    Hapus Destinasi
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>


            <div class="modal-body">

                <p class="mb-0">

                    Yakin ingin menghapus

                    <strong id="deleteItemName"></strong>?

                    Data dan gambar akan dihapus permanen.

                </p>

            </div>


            <div class="modal-footer">

                <button
                    type="button"
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
document.addEventListener('DOMContentLoaded', function () {

    const selectAll =
        document.getElementById('selectAll');

    const checkboxes =
        document.querySelectorAll('.row-checkbox');

    const selectedCount =
        document.getElementById('selectedCount');

    const bulkAction =
        document.getElementById('bulkAction');

    const bulkActionButton =
        document.getElementById('bulkActionButton');

    const bulkConfirmButton =
        document.getElementById('bulkConfirmButton');

    const bulkConfirmText =
        document.getElementById('bulkConfirmText');

    const bulkForm =
        document.getElementById('bulkForm');


    function updateSelectedCount() {

        const checked =
            document.querySelectorAll(
                '.row-checkbox:checked'
            );

        selectedCount.textContent =
            checked.length;


        if (checkboxes.length > 0) {

            selectAll.checked =
                checked.length === checkboxes.length;

            selectAll.indeterminate =
                checked.length > 0 &&
                checked.length < checkboxes.length;
        }
    }


    selectAll?.addEventListener(
        'change',
        function () {

            checkboxes.forEach(
                checkbox => {
                    checkbox.checked =
                        selectAll.checked;
                }
            );

            updateSelectedCount();
        }
    );


    checkboxes.forEach(
        checkbox => {

            checkbox.addEventListener(
                'change',
                updateSelectedCount
            );
        }
    );


    bulkActionButton?.addEventListener(
        'click',
        function () {

            const checked =
                document.querySelectorAll(
                    '.row-checkbox:checked'
                );

            if (checked.length === 0) {

                alert(
                    'Pilih minimal satu destinasi.'
                );

                return;
            }


            if (!bulkAction.value) {

                alert(
                    'Pilih aksi terlebih dahulu.'
                );

                return;
            }


            let actionText = '';

            if (
                bulkAction.value ===
                'activate'
            ) {
                actionText =
                    'mengaktifkan';
            }

            if (
                bulkAction.value ===
                'deactivate'
            ) {
                actionText =
                    'menonaktifkan';
            }

            if (
                bulkAction.value ===
                'delete'
            ) {
                actionText =
                    'menghapus permanen';
            }


            bulkConfirmText.textContent =
                `Anda akan ${actionText} `
                + `${checked.length} destinasi. `
                + `Lanjutkan?`;


            const modal =
                new bootstrap.Modal(
                    document.getElementById(
                        'bulkConfirmModal'
                    )
                );

            modal.show();
        }
    );


    bulkConfirmButton?.addEventListener(
        'click',
        function () {

            bulkConfirmButton.disabled =
                true;

            bulkConfirmButton.textContent =
                'Memproses...';

            bulkForm.submit();
        }
    );


    const deleteButtons =
        document.querySelectorAll(
            '.single-delete-button'
        );

    const deleteForm =
        document.getElementById(
            'singleDeleteForm'
        );

    const deleteItemName =
        document.getElementById(
            'deleteItemName'
        );


    deleteButtons.forEach(
        button => {

            button.addEventListener(
                'click',
                function () {

                    deleteForm.action =
                        this.dataset.url;

                    deleteItemName.textContent =
                        this.dataset.name;

                    const modal =
                        new bootstrap.Modal(
                            document.getElementById(
                                'deleteModal'
                            )
                        );

                    modal.show();
                }
            );
        }
    );


    updateSelectedCount();
});
</script>

@endsection