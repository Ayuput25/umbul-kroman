<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DestinationController extends Controller
{
    public function __construct(
        private ImageService $imageService
    ) {
        //
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $search = trim(
            (string) $request->get('q')
        );

        $status = $request->get('status');

        $destinations = Destination::query()
            ->when(
                $search,
                function ($query) use ($search) {
                    $query->where(
                        function ($subQuery) use ($search) {
                            $subQuery
                                ->where(
                                    'name',
                                    'like',
                                    '%' . $search . '%'
                                )
                                ->orWhere(
                                    'slug',
                                    'like',
                                    '%' . $search . '%'
                                )
                                ->orWhere(
                                    'address',
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
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'admin.destinations.index',
            compact(
                'destinations',
                'search',
                'status'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view(
            'admin.destinations.create'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' =>
                'required|string|max:255',

            'description' =>
                'nullable|string',

            'address' =>
                'nullable|string|max:500',

            'google_maps_url' =>
                'nullable|url|max:1000',

            'opening_hours' =>
                'nullable|string|max:255',

            'ticket_price' =>
                'nullable|numeric|min:0',

            'facilities' =>
                'nullable|string',

            'image' =>
                'nullable|image|mimes:jpg,jpeg,png,webp|max:15360',
        ]);

        $validated['slug'] =
            $this->generateUniqueSlug(
                $validated['name']
            );

        $validated['is_active'] =
            $request->boolean(
                'is_active'
            );

        if ($request->hasFile('image')) {
            $validated['image'] =
                $this->imageService->store(
                    $request->file('image'),
                    'destinations',
                    1600,
                    1200,
                    82,
                    true,
                    640,
                    420
                );
        }

        Destination::create(
            $validated
        );

        return redirect()
            ->route('destinations.index')
            ->with(
                'success',
                'Destinasi berhasil ditambahkan.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit(
        Destination $destination
    ) {
        return view(
            'admin.destinations.edit',
            compact('destination')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Destination $destination
    ) {
        $validated = $request->validate([
            'name' =>
                'required|string|max:255',

            'description' =>
                'nullable|string',

            'address' =>
                'nullable|string|max:500',

            'google_maps_url' =>
                'nullable|url|max:1000',

            'opening_hours' =>
                'nullable|string|max:255',

            'ticket_price' =>
                'nullable|numeric|min:0',

            'facilities' =>
                'nullable|string',

            'image' =>
                'nullable|image|mimes:jpg,jpeg,png,webp|max:15360',
        ]);

        $validated['slug'] =
            $this->generateUniqueSlug(
                $validated['name'],
                $destination->id
            );

        $validated['is_active'] =
            $request->boolean(
                'is_active'
            );

        if ($request->hasFile('image')) {
            $newImage =
                $this->imageService->store(
                    $request->file('image'),
                    'destinations',
                    1600,
                    1200,
                    82,
                    true,
                    640,
                    420
                );

            $this->imageService->delete(
                $destination->image
            );

            $validated['image'] =
                $newImage;
        }

        $destination->update(
            $validated
        );

        return redirect()
            ->route('destinations.index')
            ->with(
                'success',
                'Destinasi berhasil diperbarui.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy(
        Destination $destination
    ) {
        $this->imageService->delete(
            $destination->image
        );

        $destination->delete();

        return redirect()
            ->route('destinations.index')
            ->with(
                'success',
                'Destinasi berhasil dihapus.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | BULK ACTION
    |--------------------------------------------------------------------------
    */

    public function bulkAction(
        Request $request
    ) {
        $validated = $request->validate([
            'ids' =>
                'required|array|min:1',

            'ids.*' =>
                'required|integer|exists:destinations,id',

            'action' =>
                'required|in:activate,deactivate,delete',
        ]);

        $destinations =
            Destination::whereIn(
                'id',
                $validated['ids']
            )->get();

        if (
            $validated['action']
            === 'activate'
        ) {
            Destination::whereIn(
                'id',
                $validated['ids']
            )->update([
                'is_active' => true,
            ]);

            return back()->with(
                'success',
                count($validated['ids'])
                . ' destinasi berhasil diaktifkan.'
            );
        }

        if (
            $validated['action']
            === 'deactivate'
        ) {
            Destination::whereIn(
                'id',
                $validated['ids']
            )->update([
                'is_active' => false,
            ]);

            return back()->with(
                'success',
                count($validated['ids'])
                . ' destinasi berhasil dinonaktifkan.'
            );
        }

        if (
            $validated['action']
            === 'delete'
        ) {
            foreach (
                $destinations
                as $destination
            ) {
                $this->imageService->delete(
                    $destination->image
                );

                $destination->delete();
            }

            return back()->with(
                'success',
                count($validated['ids'])
                . ' destinasi berhasil dihapus.'
            );
        }

        return back();
    }

    /*
    |--------------------------------------------------------------------------
    | PUBLIC INDEX + PAGINATION
    |--------------------------------------------------------------------------
    */

    public function publicIndex()
    {
        $destinations =
            Destination::query()
                ->where(
                    'is_active',
                    true
                )
                ->latest()
                ->paginate(9)
                ->withQueryString();

        return view(
            'destinations.index',
            compact('destinations')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PUBLIC DETAIL + RELATED
    |--------------------------------------------------------------------------
    */

    public function showPublic(
        string $slug
    ) {
        $destination =
            Destination::query()
                ->where(
                    'slug',
                    $slug
                )
                ->where(
                    'is_active',
                    true
                )
                ->firstOrFail();

        $relatedDestinations =
            Destination::query()
                ->where(
                    'is_active',
                    true
                )
                ->where(
                    'id',
                    '!=',
                    $destination->id
                )
                ->latest()
                ->take(3)
                ->get();

        return view(
            'destinations.show',
            compact(
                'destination',
                'relatedDestinations'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UNIQUE SLUG
    |--------------------------------------------------------------------------
    */

    private function generateUniqueSlug(
        string $name,
        ?int $ignoreId = null
    ): string {
        $baseSlug =
            Str::slug($name);

        if (empty($baseSlug)) {
            $baseSlug =
                'destinasi';
        }

        $slug =
            $baseSlug;

        $counter = 1;

        while (
            Destination::where(
                'slug',
                $slug
            )
                ->when(
                    $ignoreId,
                    function ($query)
                    use ($ignoreId) {
                        $query->where(
                            'id',
                            '!=',
                            $ignoreId
                        );
                    }
                )
                ->exists()
        ) {
            $slug =
                $baseSlug
                . '-'
                . $counter;

            $counter++;
        }

        return $slug;
    }
}