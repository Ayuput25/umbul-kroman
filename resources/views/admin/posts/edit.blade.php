@extends('layouts.admin')

@section('title', 'Edit Artikel')

@section('page_title', 'Edit Artikel')

@section('content')

<div class="mb-4">

    <h2 class="fw-bold mb-1">
        Edit Artikel
    </h2>

    <p class="text-muted mb-0">
        Perbarui artikel {{ $post->title }}.
    </p>

</div>


<div class="admin-card">

    <div class="admin-card-body">

        <form
            action="{{ route(
                'posts.update',
                $post
            ) }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf
            @method('PUT')


            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Judul Artikel
                </label>

                <input
                    type="text"
                    name="title"
                    class="form-control"
                    value="{{ old(
                        'title',
                        $post->title
                    ) }}"
                    required>

            </div>


            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Ringkasan
                </label>

                <textarea
                    name="excerpt"
                    class="form-control"
                    rows="3">{{ old(
                        'excerpt',
                        $post->excerpt
                    ) }}</textarea>

            </div>


            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Isi Artikel
                </label>

                <textarea
                    name="content"
                    class="form-control"
                    rows="14"
                    required>{{ old(
                        'content',
                        $post->content
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
                    data-image-preview="#postPreview">

                <small class="text-muted">
                    Kosongkan jika tidak ingin mengganti gambar.
                </small>

            </div>


            <div class="mb-4">

                <label class="form-label fw-semibold d-block">
                    Preview
                </label>

                @if($post->image)

                    <img
                        id="postPreview"
                        src="{{ asset(
                            'storage/' .
                            $post->image
                        ) }}"
                        alt="{{ $post->title }}"
                        class="admin-image-preview">

                @else

                    <div
                        id="postPreviewEmpty"
                        class="admin-preview-empty">

                        Belum ada gambar.

                    </div>

                    <img
                        id="postPreview"
                        src=""
                        class="
                            admin-image-preview
                            d-none
                        "
                        data-empty-target="#postPreviewEmpty">

                @endif

            </div>


            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Tanggal Publish
                </label>

                <input
                    type="datetime-local"
                    name="published_at"
                    class="form-control"
                    value="{{ old(
                        'published_at',
                        $post->published_at
                            ? $post->published_at
                                ->format('Y-m-d\TH:i')
                            : ''
                    ) }}">

            </div>


            <div class="form-check form-switch mb-4">

                <input
                    class="form-check-input"
                    type="checkbox"
                    name="is_published"
                    value="1"
                    id="isPublished"
                    {{ old(
                        'is_published',
                        $post->is_published
                    ) ? 'checked' : '' }}>

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

                    Simpan Perubahan

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