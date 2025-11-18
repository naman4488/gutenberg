<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Subject;
use App\Models\Bookshelf;
use Illuminate\Http\Request;
use App\Http\Resources\BookResource;

class BookController extends Controller
{
    /**
     * -------------------------------------------------
     * GET /api/books
     * Paginated Book Listing + Filters
     * -------------------------------------------------
     */
    public function index(Request $request)
    {
        $query = Book::with([
            'authors', 'subjects', 'bookshelves', 'languages', 'formats'
        ])
        ->whereNotNull('title')
        ->whereNotNull('download_count')
        ->where('title', '!=', '')
        ->where('download_count', '>', 0);

        // Filter: book ID(s)
        if ($request->has('ids')) {
            $ids = explode(',', $request->ids);
            $query->whereIn('id', $ids);
        }

        // Filter: title (partial match)
        if ($request->has('title')) {
            $query->where('title', 'ILIKE', "%{$request->title}%");
        }

        // Filter: author (partial match)
        if ($request->has('author')) {
            $author = $request->author;
            $query->whereHas('authors', function ($q) use ($author) {
                $q->where('books_author.name', 'ILIKE', "%$author%");
            });
        }

        // Filter: languages
        if ($request->has('language')) {
            $langs = explode(',', $request->language);
            $query->whereHas('languages', function ($q) use ($langs) {
                $q->whereIn('books_language.code', $langs);
            });
        }

        // Filter: mime-type
        if ($request->has('mime_type')) {
            $mimes = explode(',', $request->mime_type);
            $query->whereHas('formats', function ($q) use ($mimes) {
                $q->whereIn('mime_type', $mimes);
            });
        }

        if ($request->filled('subject')) {

            // Accept multiple subjects: ?subject=History,Fiction
            $subjects = explode(',', $request->subject);

            $query->whereHas('subjects', function ($q) use ($subjects) {
                $q->whereIn('name', $subjects);
            });
        }

   
        if ($request->filled('bookshelf')) {

            // Accept multiple bookshelves: ?bookshelf=Children,Adventure
            $bookshelves = explode(',', $request->bookshelf);

            $query->whereHas('bookshelves', function ($q) use ($bookshelves) {
                $q->whereIn('name', $bookshelves);
            });
        }

        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'title_asc':
                    $query->orderBy('title', 'asc');
                    break;

                case 'title_desc':
                    $query->orderBy('title', 'desc');
                    break;

                case 'downloads_desc':
                    $query->orderBy('download_count', 'desc');
                    break;

                case 'downloads_asc':
                    $query->orderBy('download_count', 'asc');
                    break;
            }
        }
        else {
            $query->orderBy('download_count', 'desc');
        }
            
        // Pagination (25 books at a time)
        $books = $query->paginate(25);

        return BookResource::collection($books);
    }


    /**
     * -------------------------------------------------
     * GET /api/books/{id}
     * Book Full Detail
     * -------------------------------------------------
     */
    public function show($id)
    {
        $book = Book::with([
            'authors', 'subjects', 'bookshelves', 'languages', 'formats'
        ])->findOrFail($id);

        return new BookResource($book);
    }


    /**
     * -------------------------------------------------
     * GET /api/search?q=
     * Search across title, author, subject, bookshelf
     * -------------------------------------------------
     */
    public function search(Request $request)
    {
        $q = $request->q;

        $query = Book::with(['authors', 'subjects', 'bookshelves']);

        $query->where('title', 'ILIKE', "%$q%")
            ->orWhereHas('authors', function ($a) use ($q) {
                $a->where('books_author.name', 'ILIKE', "%$q%");
            })
            ->orWhereHas('subjects', function ($s) use ($q) {
                $s->where('books_subject.name', 'ILIKE', "%$q%");
            })
            ->orWhereHas('bookshelves', function ($b) use ($q) {
                $b->where('books_bookshelf.name', 'ILIKE', "%$q%");
            });

        return BookResource::collection(
            $query->orderBy('download_count', 'desc')->paginate(25)
        );
    }


    /**
     * -------------------------------------------------
     * GET /api/books/{id}/related
     * Find Related Books using:
     * Author, Subject, Bookshelf Matches
     * -------------------------------------------------
     */
    public function related($id)
    {
        $book = Book::with(['authors', 'subjects', 'bookshelves'])->findOrFail($id);

        $authorIds = $book->authors->pluck('id')->toArray();
        $subjectIds = $book->subjects->pluck('id')->toArray();
        $bookshelfIds = $book->bookshelves->pluck('id')->toArray();

        $related = Book::where('id', '!=', $id)
            ->where(function ($query) use ($authorIds, $subjectIds, $bookshelfIds) {

                if (!empty($authorIds)) {
                    $query->orWhereHas('authors', function ($q) use ($authorIds) {
                        $q->whereIn('books_author.id', $authorIds);
                    });
                }

                if (!empty($subjectIds)) {
                    $query->orWhereHas('subjects', function ($q) use ($subjectIds) {
                        $q->whereIn('books_subject.id', $subjectIds);
                    });
                }

                if (!empty($bookshelfIds)) {
                    $query->orWhereHas('bookshelves', function ($q) use ($bookshelfIds) {
                        $q->whereIn('books_bookshelf.id', $bookshelfIds);
                    });
                }

            })
            ->orderBy('download_count', 'desc')
            ->limit(10)
            ->get();

        return BookResource::collection($related);
    }
}
