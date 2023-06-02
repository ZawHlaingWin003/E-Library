<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Genre;

class GenreController extends Controller
{
    public function index()
    {
        $genres = Genre::orderBy('id', 'desc')->get();
        return view('frontend.pages.genres.index', compact('genres'));
    }

    public function show(Genre $genre)
    {
        return view('frontend.pages.genres.show', compact('genre'));
    }
}
