<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        /* DB::listen(function ($query) {
            logger($query->sql, $query->bindings);
        }); */

        $books = Book::with('author')->latest()->get();
        return view('frontend.pages.home.home', compact('books'));
    }
}
