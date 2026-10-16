<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
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

        $status =
            $request->get('status');

        $posts = Post::query()
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
                                    'slug',
                                    'like',
                                    '%' . $search . '%'
                                )
                                ->orWhere(
                                    'excerpt',
                                    'like',
                                    '%' . $search . '%'
                                )
                                ->orWhere(
                                    'content',
                                    'like',
                                    '%' . $search . '%'
                                );
                        }
                    );
                }
            )
            ->when(
                $status === 'draft',
                fn ($query) =>
                    $query->where(
                        'is_published',
                        false
                    )
            )
            ->when(
                $status === 'published',
                fn ($query) =>
                    $query
                        ->where(
                            'is_published',
                            true
                        )
                        ->whereNotNull(
                            'published_at'
                        )
                        ->where(
                            'published_at',
                            '<=',
                            now()
                        )
            )
            ->when(
                $status === 'scheduled',
                fn ($query) =>
                    $query
                        ->where(
                            'is_published',
                            true
                        )
                        ->whereNotNull(
                            'published_at'
                        )
                        ->where(
                            'published_at',
                            '>',
                            now()
                        )
            )
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'admin.posts.index',
            compact(
                'posts',
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
            'admin.posts.create'
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
            'title' =>
                'required|string|max:255',

            'excerpt' =>
                'nullable|string|max:1000',

            'content' =>
                'required|string',

            'image' =>
                'nullable|image|mimes:jpg,jpeg,png,webp|max:15360',

            'published_at' =>
                'nullable|date',
        ]);

        $validated['slug'] =
            $this->generateUniqueSlug(
                $validated['title']
            );

        $validated['is_published'] =
            $request->boolean(
                'is_published'
            );

        if (
            $validated['is_published']
        ) {
            $validated['published_at'] =
                $validated['published_at']
                ?? now();
        } else {
            $validated['published_at'] =
                null;
        }

        if ($request->hasFile('image')) {
            $validated['image'] =
                $this->imageService->store(
                    $request->file('image'),
                    'posts',
                    1600,
                    1200,
                    82,
                    true,
                    640,
                    420
                );
        }

        Post::create(
            $validated
        );

        return redirect()
            ->route('posts.index')
            ->with(
                'success',
                'Artikel berhasil ditambahkan.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit(Post $post)
    {
        return view(
            'admin.posts.edit',
            compact('post')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Post $post
    ) {
        $validated = $request->validate([
            'title' =>
                'required|string|max:255',

            'excerpt' =>
                'nullable|string|max:1000',

            'content' =>
                'required|string',

            'image' =>
                'nullable|image|mimes:jpg,jpeg,png,webp|max:15360',

            'published_at' =>
                'nullable|date',
        ]);

        $validated['slug'] =
            $this->generateUniqueSlug(
                $validated['title'],
                $post->id
            );

        $validated['is_published'] =
            $request->boolean(
                'is_published'
            );

        if (
            $validated['is_published']
        ) {
            $validated['published_at'] =
                $validated['published_at']
                ?? $post->published_at
                ?? now();
        } else {
            $validated['published_at'] =
                null;
        }

        if ($request->hasFile('image')) {
            $newImage =
                $this->imageService->store(
                    $request->file('image'),
                    'posts',
                    1600,
                    1200,
                    82,
                    true,
                    640,
                    420
                );

            $this->imageService->delete(
                $post->image
            );

            $validated['image'] =
                $newImage;
        }

        $post->update(
            $validated
        );

        return redirect()
            ->route('posts.index')
            ->with(
                'success',
                'Artikel berhasil diperbarui.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy(Post $post)
    {
        $this->imageService->delete(
            $post->image
        );

        $post->delete();

        return redirect()
            ->route('posts.index')
            ->with(
                'success',
                'Artikel berhasil dihapus.'
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
                'required|integer|exists:posts,id',

            'action' =>
                'required|in:publish,draft,delete',
        ]);

        $posts =
            Post::whereIn(
                'id',
                $validated['ids']
            )->get();

        if (
            $validated['action']
            === 'publish'
        ) {
            foreach ($posts as $post) {
                $post->update([
                    'is_published' =>
                        true,

                    'published_at' =>
                        $post->published_at
                        ?? now(),
                ]);
            }

            return back()->with(
                'success',
                count($validated['ids'])
                . ' artikel berhasil dipublish.'
            );
        }

        if (
            $validated['action']
            === 'draft'
        ) {
            Post::whereIn(
                'id',
                $validated['ids']
            )->update([
                'is_published' =>
                    false,

                'published_at' =>
                    null,
            ]);

            return back()->with(
                'success',
                count($validated['ids'])
                . ' artikel berhasil dijadikan draft.'
            );
        }

        if (
            $validated['action']
            === 'delete'
        ) {
            foreach ($posts as $post) {
                $this->imageService->delete(
                    $post->image
                );

                $post->delete();
            }

            return back()->with(
                'success',
                count($validated['ids'])
                . ' artikel berhasil dihapus.'
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
        $posts =
            Post::query()
                ->where(
                    'is_published',
                    true
                )
                ->whereNotNull(
                    'published_at'
                )
                ->where(
                    'published_at',
                    '<=',
                    now()
                )
                ->latest(
                    'published_at'
                )
                ->paginate(9)
                ->withQueryString();

        return view(
            'blog.index',
            compact('posts')
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
        $post =
            Post::query()
                ->where(
                    'slug',
                    $slug
                )
                ->where(
                    'is_published',
                    true
                )
                ->whereNotNull(
                    'published_at'
                )
                ->where(
                    'published_at',
                    '<=',
                    now()
                )
                ->firstOrFail();

        $relatedPosts =
            Post::query()
                ->where(
                    'is_published',
                    true
                )
                ->whereNotNull(
                    'published_at'
                )
                ->where(
                    'published_at',
                    '<=',
                    now()
                )
                ->where(
                    'id',
                    '!=',
                    $post->id
                )
                ->latest(
                    'published_at'
                )
                ->take(3)
                ->get();

        return view(
            'blog.show',
            compact(
                'post',
                'relatedPosts'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UNIQUE SLUG
    |--------------------------------------------------------------------------
    */

    private function generateUniqueSlug(
        string $title,
        ?int $ignoreId = null
    ): string {
        $baseSlug =
            Str::slug($title);

        if (empty($baseSlug)) {
            $baseSlug =
                'artikel';
        }

        $slug =
            $baseSlug;

        $counter = 1;

        while (
            Post::where(
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