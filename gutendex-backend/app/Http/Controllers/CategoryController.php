<?php

namespace App\Http\Controllers;

use App\Models\Bookshelf;
use App\Models\Subject;

class CategoryController extends Controller
{
    public function index()
    {
        // Get all bookshelf names
        $bookshelves = Bookshelf::pluck('name')->toArray();

        // Get all subject names
        $subjects = Subject::pluck('name')->toArray();

        // Merge & unique
        $categories = array_unique(array_merge($bookshelves, $subjects));

        sort($categories);

        return response()->json([
            'categories' => array_values($categories)
        ]);
    }
}
