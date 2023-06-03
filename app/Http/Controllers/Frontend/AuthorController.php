<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Author;

class AuthorController extends Controller
{
    public function index()
    {
        return view('frontend.pages.authors.index');
    }

    public function getAuthors()
    {
        $authors = Author::when(
            request()->search,
            fn ($query, $search) =>
            $query->where('name', 'LIKE', '%' . $search . '%')
        )
            ->latest()
            ->get();

        return ApiResponse::success($authors);
    }

    public function show(Author $author)
    {
        return view('frontend.pages.authors.show', compact('author'));
    }
}
