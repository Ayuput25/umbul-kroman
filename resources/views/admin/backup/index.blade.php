@extends('layouts.admin')

@section('title', 'Backup & Restore')

@section('page_title', 'Backup & Restore')

@section('content')

<div class="mb-4">

    <h2 class="fw-bold mb-1">
        Backup & Restore
    </h2>

    <p class="text-muted mb-0">
        Amankan database dan seluruh file media website.
    </p>

</div>


{{-- STATUS --}}
<div class="row g-4 mb-4">

    <div class="col-md-6 col-xl-3">

        <div class="admin-stat-card">

            <div class="admin-stat-label">
                Destinasi
            </div>

            <div class="admin-stat-value">
                {{ $statistics['destinations'] }}
            </div>

            <div class="admin-stat-meta">
                Data destinasi
            </div>

        </div>

    </div>


    <div class="col-md-6 col-xl-3">

        <div class="admin-stat-card">

            <div class="admin-stat-label">
                Artikel
            </div>

            <div class="admin-stat-value">
                {{ $statistics['posts'] }}
            </div>

            <div class="admin-stat-meta">
                Blog & berita
            </div>

        </div>

    </div>


    <div class="col-md-6 col-xl-3">

        <div class="admin-stat-card">

            <div class="admin-stat-label">
                Galeri
            </div>

            <div class="admin-stat-value">
                {{ $statistics['galleries'] }}
            </div>

            <div class="admin-stat-meta">
                Foto galeri
            </div>

        </div>

    </div>


    <div class="col-md-6 col-xl-3">

        <div class="admin-stat-card">

            <div class="admin-stat-label">
                File Media
            </div>

            <div class="admin-stat-value">
                {{ $mediaStatistics['files'] }}
            </div>

            <div class="admin-stat-meta">

                {{ $mediaStatistics['formatted_size'] }}

            </div>

        </div>

    </div>

</div>


{{-- ZIP STATUS --}}
@if(!$zipAvailable)

    <div
        class="
            alert
            alert-danger
            border-0
            shadow-sm
            mb-4
        ">

        <strong>
            PHP ZIP extension belum aktif.
        </strong>

        Aktifkan extension ZIP agar Full Backup dapat digunakan.

    </div>

@endif


{{-- FULL BACKUP --}}
<div
    class="
        admin-card
        mb-4
        overflow-hidden
    ">

    <div
        class="p-4 p-lg-5"
        style="
            background:
                linear-gradient(
                    135deg,
                    #0f6a42,
                    #174f38
                );
            color: white;
        ">

        <div class="row align-items-center g-4">

            <div class="col-lg-8">

                <div
                    class="
                        small
                        text-uppercase
                        fw-bold
                        opacity-75
                        mb-2
                    ">

                    Recommended

                </div>

                <h2 class="fw-bold mb-3">
                    Full Backup ZIP
                </h2>

                <p
                    class="mb-0 opacity-75"
                    style="
                        max-width: 700px;
                        line-height: 1.8;
                    ">

                    Backup lengkap database beserta foto
                    destinasi, gambar blog, galeri, logo,
                    hero image, favicon, dan seluruh media
                    yang dikelola website.

                </p>

            </div>


            <div
                class="
                    col-lg-4
                    text-lg-end
                ">

                @if($zipAvailable)

                    <a
                        href="{{ route(
                            'admin.backup.full.export'
                        ) }}"
                        class="
                            btn
                            btn-light
                            btn-lg
                            fw-bold
                        ">

                        Download Full Backup

                    </a>

                @else

                    <button
                        type="button"
                        class="
                            btn
                            btn-light
                            btn-lg
                        "
                        disabled>

                        ZIP Tidak Tersedia

                    </button>

                @endif

            </div>

        </div>

    </div>

</div>


<div class="row g-4 mb-4">

    {{-- ISI FULL BACKUP --}}
    <div class="col-lg-5">

        <div class="admin-card h-100">

            <div class="admin-card-header">

                <div>

                    <h5 class="fw-bold mb-1">
                        Isi Full Backup
                    </h5>

                    <small class="text-muted">
                        Semua komponen penting website.
                    </small>

                </div>

            </div>


            <div class="admin-card-body">

                <div
                    class="
                        d-flex
                        align-items-center
                        justify-content-between
                        py-3
                        border-bottom
                    ">

                    <span>
                        Database Website
                    </span>

                    <span
                        class="
                            badge
                            bg-success-subtle
                            text-success
                        ">

                        Included

                    </span>

                </div>


                <div
                    class="
                        d-flex
                        align-items-center
                        justify-content-between
                        py-3
                        border-bottom
                    ">

                    <span>
                        Foto Destinasi
                    </span>

                    <span
                        class="
                            badge
                            bg-success-subtle
                            text-success
                        ">

                        Included

                    </span>

                </div>


                <div
                    class="
                        d-flex
                        align-items-center
                        justify-content-between
                        py-3
                        border-bottom
                    ">

                    <span>
                        Gambar Blog
                    </span>

                    <span
                        class="
                            badge
                            bg-success-subtle
                            text-success
                        ">

                        Included

                    </span>

                </div>


                <div
                    class="
                        d-flex
                        align-items-center
                        justify-content-between
                        py-3
                        border-bottom
                    ">

                    <span>
                        Galeri
                    </span>

                    <span
                        class="
                            badge
                            bg-success-subtle
                            text-success
                        ">

                        Included

                    </span>

                </div>


                <div
                    class="
                        d-flex
                        align-items-center
                        justify-content-between
                        py-3
                        border-bottom
                    ">

                    <span>
                        Logo & Hero
                    </span>

                    <span
                        class="
                            badge
                            bg-success-subtle
                            text-success
                        ">

                        Included

                    </span>

                </div>


                <div
                    class="
                        d-flex
                        align-items-center
                        justify-content-between
                        py-3
                    ">

                    <span>
                        Favicon
                    </span>

                    <span
                        class="
                            badge
                            bg-success-subtle
                            text-success
                        ">

                        Included

                    </span>

                </div>


                <div
                    class="
                        alert
                        alert-light
                        border
                        mt-4
                        mb-0
                    ">

                    Password admin tidak disimpan
                    di dalam backup.

                </div>

            </div>

        </div>

    </div>


    {{-- RESTORE ZIP --}}
    <div class="col-lg-7">

        <div class="admin-card h-100">

            <div class="admin-card-header">

                <div>

                    <h5 class="fw-bold mb-1">
                        Restore Full Backup
                    </h5>

                    <small class="text-muted">
                        Pulihkan database dan seluruh media.
                    </small>

                </div>

            </div>


            <div class="admin-card-body">

                <div
                    class="
                        alert
                        alert-warning
                        border-0
                    ">

                    <strong>
                        Perhatian:
                    </strong>

                    Data dan media saat ini akan diganti
                    dengan data yang terdapat di backup ZIP.

                </div>


                <form
                    action="{{ route(
                        'admin.backup.full.import'
                    ) }}"
                    method="POST"
                    enctype="multipart/form-data"
                    id="fullRestoreForm">

                    @csrf


                    <div class="mb-4">

                        <label class="form-label fw-semibold">
                            File Full Backup ZIP
                        </label>

                        <input
                            type="file"
                            name="backup_zip"
                            class="form-control"
                            accept=".zip,application/zip"
                            required>

                        <small class="text-muted">
                            Maksimal 100 MB.
                        </small>

                    </div>


                    <div class="mb-4">

                        <label class="form-label fw-semibold">
                            Password Admin Saat Ini
                        </label>

                        <input
                            type="password"
                            name="current_password"
                            class="form-control"
                            autocomplete="current-password"
                            required>

                    </div>


                    <div
                        class="
                            form-check
                            border
                            rounded-3
                            p-3
                            mb-4
                        ">

                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="confirmation"
                            value="1"
                            id="fullConfirmation"
                            required>

                        <label
                            class="form-check-label"
                            for="fullConfirmation">

                            Saya memahami bahwa proses restore
                            akan mengganti database dan media
                            website saat ini.

                        </label>

                    </div>


                    <button
                        type="button"
                        class="btn btn-danger"
                        data-bs-toggle="modal"
                        data-bs-target="#fullRestoreModal"
                        {{ !$zipAvailable
                            ? 'disabled'
                            : ''
                        }}>

                        Restore Full Backup

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>


{{-- DATABASE JSON --}}
<div class="admin-card mb-4">

    <div class="admin-card-header">

        <div>

            <h5 class="fw-bold mb-1">
                Backup Database Saja
            </h5>

            <small class="text-muted">
                Backup ringan tanpa file media.
            </small>

        </div>

    </div>


    <div class="admin-card-body">

        <div class="row g-4">

            <div class="col-lg-5">

                <h6 class="fw-bold">
                    Export JSON
                </h6>

                <p class="text-muted">
                    Gunakan jika hanya ingin menyimpan
                    data database tanpa gambar.
                </p>

                <a
                    href="{{ route(
                        'admin.backup.export'
                    ) }}"
                    class="btn btn-outline-success">

                    Download Database JSON

                </a>

            </div>


            <div class="col-lg-7">

                <h6 class="fw-bold">
                    Restore JSON
                </h6>


                <form
                    action="{{ route(
                        'admin.backup.import'
                    ) }}"
                    method="POST"
                    enctype="multipart/form-data">

                    @csrf


                    <div class="mb-3">

                        <input
                            type="file"
                            name="backup_file"
                            class="form-control"
                            accept=".json,application/json"
                            required>

                    </div>


                    <div class="mb-3">

                        <input
                            type="password"
                            name="current_password"
                            class="form-control"
                            placeholder="Password admin saat ini"
                            autocomplete="current-password"
                            required>

                    </div>


                    <div class="form-check mb-3">

                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="confirmation"
                            value="1"
                            id="jsonConfirmation"
                            required>

                        <label
                            class="form-check-label"
                            for="jsonConfirmation">

                            Saya memahami data database
                            akan diganti.

                        </label>

                    </div>


                    <button
                        type="submit"
                        class="btn btn-outline-danger">

                        Restore Database JSON

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>


{{-- FULL RESTORE MODAL --}}
<div
    class="modal fade"
    id="fullRestoreModal"
    tabindex="-1"
    aria-hidden="true">

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

                <h5
                    class="
                        modal-title
                        fw-bold
                        text-danger
                    ">

                    Konfirmasi Full Restore

                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>


            <div class="modal-body">

                <p>
                    Full restore akan mengganti
                    <strong>database dan file media</strong>
                    website.
                </p>

                <div
                    class="
                        alert
                        alert-danger
                        mb-0
                    ">

                    Sebaiknya download Full Backup kondisi
                    sekarang terlebih dahulu sebelum melanjutkan.

                </div>

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
                    class="btn btn-danger"
                    id="confirmFullRestore">

                    Ya, Restore Sekarang

                </button>

            </div>

        </div>

    </div>

</div>


<script>
document.addEventListener(
    'DOMContentLoaded',
    function () {

        const form =
            document.getElementById(
                'fullRestoreForm'
            );

        const button =
            document.getElementById(
                'confirmFullRestore'
            );


        if (!form || !button) {
            return;
        }


        button.addEventListener(
            'click',
            function () {

                if (!form.checkValidity()) {

                    const modalElement =
                        document.getElementById(
                            'fullRestoreModal'
                        );

                    const modal =
                        bootstrap.Modal.getInstance(
                            modalElement
                        );

                    modal?.hide();

                    form.reportValidity();

                    return;
                }


                this.disabled = true;

                this.textContent =
                    'Sedang Merestore...';


                form.submit();
            }
        );
    }
);
</script>

@endsection