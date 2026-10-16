@extends('layouts.admin')

@section('title', 'Blog & Berita')

@section('page_title', 'Blog & Berita')

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
            Blog & Berita
        </h2>

        <p class="text-muted mb-0">
            Kelola banyak artikel sekaligus.
        </p>

    </div>


    <a
        href="{{ route('posts.create') }}"
        class="btn btn-admin-primary">

        + Tambah Artikel

    </a>

</div>


<div class="admin-card mb-4">

    <div class="admin-card-body">

        <form
            method="GET"
            action="{{ route('posts.index') }}">

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
                        placeholder="Cari judul, slug, ringkasan, atau isi...">

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
                            value="published"
                            {{ $status === 'published'
                                ? 'selected'
                                : ''
                            }}>

                            Published

                        </option>

                        <option
                            value="draft"
                            {{ $status === 'draft'
                                ? 'selected'
                                : ''
                            }}>

                            Draft

                        </option>

                        <option
                            value="scheduled"
                            {{ $status === 'scheduled'
                                ? 'selected'
                                : ''
                            }}>

                            Terjadwal

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
                            href="{{ route('posts.index') }}"
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
    action="{{ route('posts.bulk') }}"
    method="POST">

    @csrf


    <div class="admin-card">

        <div class="admin-card-header">

            <div>

                <h5 class="fw-bold mb-1">
                    Daftar Artikel
                </h5>

                <small class="text-muted">

                    Total {{ $posts->total() }} artikel.

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
                    style="max-width: 230px;">

                    <option value="">
                        Pilih Aksi
                    </option>

                    <option value="publish">
                        Publish
                    </option>

                    <option value="draft">
                        Jadikan Draft
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

                            <th>Gambar</th>
                            <th>Judul</th>
                            <th>Status</th>
                            <th>Publish</th>
                            <th width="190">Aksi</th>

                        </tr>

                    </thead>


                    <tbody>

                    @forelse($posts as $post)

                        <tr>

                            <td>

                                <input
                                    type="checkbox"
                                    name="ids[]"
                                    value="{{ $post->id }}"
                                    class="
                                        form-check-input
                                        row-checkbox
                                    ">

                            </td>


                            <td>

                                @if($post->image)

                                    <img
                                        src="{{ asset(
                                            'storage/' .
                                            $post->image
                                        ) }}"
                                        alt="{{ $post->title }}"
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
                                            justify-content-center
                                            align-items-center
                                            text-muted
                                        "
                                        style="
                                            width:100px;
                                            height:70px;
                                            border-radius:12px;
                                        ">

                                        No Image

                                    </div>

                                @endif

                            </td>


                            <td>

                                <div class="fw-bold">

                                    {{ \Illuminate\Support\Str::limit(
                                        $post->title,
                                        55
                                    ) }}

                                </div>

                                <small class="text-muted">
                                    {{ $post->slug }}
                                </small>

                            </td>


                            <td>

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

                            </td>


                            <td>

                                {{ $post->published_at
                                    ? $post->published_at
                                        ->format('d/m/Y H:i')
                                    : '-'
                                }}

                            </td>


                            <td>

                                <div class="d-flex gap-2">

                                    <a
                                        href="{{ route(
                                            'posts.edit',
                                            $post
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
                                            'posts.destroy',
                                            $post
                                        ) }}"
                                        data-name="{{ $post->title }}">

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

                                Artikel tidak ditemukan.

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        @if($posts->hasPages())

            <div class="p-3 border-top">
                {{ $posts->links() }}
            </div>

        @endif

    </div>

</form>


@include('admin.partials.bulk-script', [
    'itemLabel' => 'artikel'
])


{{-- SINGLE DELETE MODAL --}}
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
                    Hapus Artikel
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