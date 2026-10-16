@extends('layouts.admin')

@section('title', 'Akun Admin')

@section('page_title', 'Akun Admin')

@section('content')

<div class="mb-4">

    <h2 class="fw-bold mb-1">
        Akun Administrator
    </h2>

    <p class="text-muted mb-0">
        Kelola nama, email, dan password akun administrator.
    </p>

</div>


@if($errors->any())

    <div class="alert alert-danger">

        <ul class="mb-0">

            @foreach($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

@endif


<div class="row g-4">

    <div class="col-lg-6">

        <div class="admin-card h-100">

            <div class="admin-card-header">

                <div>

                    <h5 class="fw-bold mb-1">
                        Informasi Akun
                    </h5>

                    <small class="text-muted">
                        Ubah identitas akun administrator.
                    </small>

                </div>

            </div>


            <div class="admin-card-body">

                <form
                    action="{{ route(
                        'admin.account.profile.update'
                    ) }}"
                    method="POST">

                    @csrf
                    @method('PUT')


                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Nama
                        </label>

                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            value="{{ old(
                                'name',
                                $user->name
                            ) }}"
                            required>

                    </div>


                    <div class="mb-4">

                        <label class="form-label fw-semibold">
                            Email
                        </label>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            value="{{ old(
                                'email',
                                $user->email
                            ) }}"
                            required>

                    </div>


                    <button
                        type="submit"
                        class="btn btn-admin-primary">

                        Simpan Informasi

                    </button>

                </form>

            </div>

        </div>

    </div>


    <div class="col-lg-6">

        <div class="admin-card h-100">

            <div class="admin-card-header">

                <div>

                    <h5 class="fw-bold mb-1">
                        Keamanan
                    </h5>

                    <small class="text-muted">
                        Ganti password akun administrator.
                    </small>

                </div>

            </div>


            <div class="admin-card-body">

                <form
                    action="{{ route(
                        'admin.account.password.update'
                    ) }}"
                    method="POST">

                    @csrf
                    @method('PUT')


                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Password Saat Ini
                        </label>

                        <input
                            type="password"
                            name="current_password"
                            class="form-control"
                            autocomplete="current-password"
                            required>

                    </div>


                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Password Baru
                        </label>

                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            minlength="8"
                            autocomplete="new-password"
                            required>

                        <small class="text-muted">
                            Minimal 8 karakter.
                        </small>

                    </div>


                    <div class="mb-4">

                        <label class="form-label fw-semibold">
                            Konfirmasi Password Baru
                        </label>

                        <input
                            type="password"
                            name="password_confirmation"
                            class="form-control"
                            minlength="8"
                            autocomplete="new-password"
                            required>

                    </div>


                    <button
                        type="submit"
                        class="btn btn-admin-primary">

                        Ganti Password

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection