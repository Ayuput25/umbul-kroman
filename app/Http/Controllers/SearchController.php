<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'q' =>
                'nullable|string|max:100',
        ]);

        $query = trim(
            (string) (
                $validated['q']
                ?? ''
            )
        );

        $destinations = null;
        $posts = null;

        $destinationTotal = 0;
        $postTotal = 0;
        $totalResults = 0;

        if ($query !== '') {

            /*
            |--------------------------------------------------------------------------
            | DESTINATIONS
            |--------------------------------------------------------------------------
            */

            $destinations =
                Destination::query()
                    ->where(
                        'is_active',
                        true
                    )
                    ->where(
                        function ($builder)
                        use ($query) {
                            $builder
                                ->where(
                                    'name',
                                    'like',
                                    '%' . $query . '%'
                                )
                                ->orWhere(
                                    'address',
                                    'like',
                                    '%' . $query . '%'
                                )
                                ->orWhere(
                                    'description',
                                    'like',
                                    '%' . $query . '%'
                                )
                                ->orWhere(
                                    'facilities',
                                    'like',
                                    '%' . $query . '%'
                                );
                        }
                    )
                    ->latest()
                    ->paginate(
                        9,
                        ['*'],
                        'destination_page'
                    )
                    ->withQueryString();


            /*
            |--------------------------------------------------------------------------
            | POSTS
            |--------------------------------------------------------------------------
            */

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
                    ->where(
                        function ($builder)
                        use ($query) {
                            $builder
                                ->where(
                                    'title',
                                    'like',
                                    '%' . $query . '%'
                                )
                                ->orWhere(
                                    'excerpt',
                                    'like',
                                    '%' . $query . '%'
                                )
                                ->orWhere(
                                    'content',
                                    'like',
                                    '%' . $query . '%'
                                );
                        }
                    )
                    ->latest(
                        'published_at'
                    )
                    ->paginate(
                        9,
                        ['*'],
                        'post_page'
                    )
                    ->withQueryString();


            $destinationTotal =
                $destinations->total();

            $postTotal =
                $posts->total();

            $totalResults =
                $destinationTotal
                +
                $postTotal;
        }

        return view(
            'search.index',
            compact(
                'query',
                'destinations',
                'posts',
                'destinationTotal',
                'postTotal',
                'totalResults'
            )
        );
    }
}