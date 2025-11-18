<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->filled('q')) {
            return response()->json([
                'results' => []
            ]);
        }

        $query = trim($request->q);

        // Search titles
        $titleResults = Book::where('title', 'ILIKE', "%{$query}%")
                            ->limit(10)
                            ->pluck('title');

        // Search authors
        $authorResults = Author::where('name', 'ILIKE', "%{$query}%")
                               ->limit(10)
                               ->pluck('name');

        return response()->json([
            'titles' => $titleResults,
            'authors' => $authorResults
        ]);
    }
}
