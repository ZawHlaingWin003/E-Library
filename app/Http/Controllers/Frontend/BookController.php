<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Genre;
use App\Models\Author;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('author')->latest()->get();
        $genres = Genre::has('books')->get();
        $authors = Author::has('books')->orderBy('name')->get();

        $groupedAuthors = $authors->groupBy(function ($author) {
            return strtoupper(substr($author->name, 0, 1));
        });

        return view('frontend.pages.books.index', compact('books', 'genres', 'groupedAuthors'));
    }

    public function getBooks()
    {
        if (request()->page) {
            $perPage = request()->perPage; // Number of records per page
            $page = request()->get('page', 1); // Get the requested page number
            $books = Book::filter(request(['search', 'genre', 'author']))
            ->with(['author', 'genres'])
            ->latest()
            ->paginate($perPage, ['*'], 'page', $page);
        } else {
            $books = Book::filter(request(['search', 'genre', 'author']))
                ->with(['author', 'genres'])
                ->latest()
                ->get();
        }

        return ApiResponse::success($books);
    }

    public function show(Book $book)
    {
        return view('frontend.pages.books.show', compact('book'));
    }
}
