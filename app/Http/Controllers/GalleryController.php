<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Services\ImageService;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function __construct(
        private ImageService $imageService
    ) {
        //
    }


    public function index(
        Request $request
    ) {
        $search =
            trim(
                (string)
                $request->get('q')
            );

        $status =
            $request->get('status');


        $galleries =
            Gallery::query()

                ->when(
                    $search,
                    function ($query)
                    use ($search) {

                        $query->where(
                            function ($subQuery)
                            use ($search) {

                                $subQuery
                                    ->where(
                                        'title',
                                        'like',
                                        '%' . $search . '%'
                                    )
                                    ->orWhere(
                                        'description',
                                        'like',
                                        '%' . $search . '%'
                                    );
                            }
                        );
                    }
                )

                ->when(
                    $status === 'active',
                    fn ($query) =>
                        $query->where(
                            'is_active',
                            true
                        )
                )

                ->when(
                    $status === 'inactive',
                    fn ($query) =>
                        $query->where(
                            'is_active',
                            false
                        )
                )

                ->orderBy(
                    'sort_order'
                )
                ->orderByDesc(
                    'created_at'
                )

                ->paginate(12)

                ->withQueryString();


        return view(
            'admin.galleries.index',
            compact(
                'galleries',
                'search',
                'status'
            )
        );
    }


    public function create()
    {
        return view(
            'admin.galleries.create'
        );
    }


    public function store(
        Request $request
    ) {
        $validated =
            $request->validate([
                'title' =>
                    'required|string|max:255',

                'description' =>
                    'nullable|string',

                'image' =>
                    'required|image|mimes:jpg,jpeg,png,webp|max:15360',

                'sort_order' =>
                    'nullable|integer|min:0',
            ]);


        $validated['sort_order'] =
            $validated['sort_order']
            ?? 0;

        $validated['is_active'] =
            $request->boolean(
                'is_active'
            );


        $validated['image'] =
            $this->imageService->store(
                $request->file('image'),
                'galleries',
                1800,
                1400,
                84,
                true,
                640,
                420
            );


        Gallery::create(
            $validated
        );


        return redirect()
            ->route(
                'galleries.index'
            )
            ->with(
                'success',
                'Foto galeri berhasil ditambahkan dan dioptimasi.'
            );
    }


    public function edit(
        Gallery $gallery
    ) {
        return view(
            'admin.galleries.edit',
            compact('gallery')
        );
    }


    public function update(
        Request $request,
        Gallery $gallery
    ) {
        $validated =
            $request->validate([
                'title' =>
                    'required|string|max:255',

                'description' =>
                    'nullable|string',

                'image' =>
                    'nullable|image|mimes:jpg,jpeg,png,webp|max:15360',

                'sort_order' =>
                    'nullable|integer|min:0',
            ]);


        $validated['sort_order'] =
            $validated['sort_order']
            ?? 0;

        $validated['is_active'] =
            $request->boolean(
                'is_active'
            );


        if (
            $request->hasFile('image')
        ) {
            $newImage =
                $this->imageService->store(
                    $request->file('image'),
                    'galleries',
                    1800,
                    1400,
                    84,
                    true,
                    640,
                    420
                );


            $this->imageService->delete(
                $gallery->image
            );


            $validated['image'] =
                $newImage;
        }


        $gallery->update(
            $validated
        );


        return redirect()
            ->route(
                'galleries.index'
            )
            ->with(
                'success',
                'Galeri berhasil diperbarui.'
            );
    }


    public function destroy(
        Gallery $gallery
    ) {
        $this->imageService->delete(
            $gallery->image
        );

        $gallery->delete();


        return redirect()
            ->route(
                'galleries.index'
            )
            ->with(
                'success',
                'Foto galeri berhasil dihapus.'
            );
    }


    public function bulkAction(
        Request $request
    ) {
        $validated =
            $request->validate([
                'ids' =>
                    'required|array|min:1',

                'ids.*' =>
                    'required|integer|exists:galleries,id',

                'action' =>
                    'required|in:activate,deactivate,delete',
            ]);


        $galleries =
            Gallery::whereIn(
                'id',
                $validated['ids']
            )->get();


        if (
            $validated['action']
            === 'activate'
        ) {
            Gallery::whereIn(
                'id',
                $validated['ids']
            )->update([
                'is_active' =>
                    true,
            ]);


            return back()->with(
                'success',
                count(
                    $validated['ids']
                )
                . ' foto berhasil diaktifkan.'
            );
        }


        if (
            $validated['action']
            === 'deactivate'
        ) {
            Gallery::whereIn(
                'id',
                $validated['ids']
            )->update([
                'is_active' =>
                    false,
            ]);


            return back()->with(
                'success',
                count(
                    $validated['ids']
                )
                . ' foto berhasil dinonaktifkan.'
            );
        }


        if (
            $validated['action']
            === 'delete'
        ) {
            foreach (
                $galleries as $gallery
            ) {
                $this->imageService->delete(
                    $gallery->image
                );

                $gallery->delete();
            }


            return back()->with(
                'success',
                count(
                    $validated['ids']
                )
                . ' foto berhasil dihapus.'
            );
        }


        return back();
    }


    public function publicIndex()
    {
        $galleries =
            Gallery::where(
                'is_active',
                true
            )
                ->orderBy(
                    'sort_order'
                )
                ->orderByDesc(
                    'created_at'
                )
                ->get();


        return view(
            'gallery.index',
            compact('galleries')
        );
    }
}