<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Book;
use App\Models\Genre;
use App\Models\Author;
use App\Imports\BooksImport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Cviebrock\EloquentSluggable\Services\SlugService;

class BookController extends Controller
{
    public function uploadExcel()
    {
        return view('dashboard.books.import');
    }

    public function import(Request $request)
    {
        if($request->hasFile('books')){
            Excel::import(new BooksImport, $request->file('books'));
            return redirect()->route('books.index')->with('success', 'Books Imported Successfully!');
        }
    }

    public function index()
    {
        $books = Book::all();
        return view('frontend.pages.books', compact('books'));
    }

    public function list()
    {
        $books = Book::all();
        return view('dashboard.books.index', compact('books'));
    }

    public function create()
    {
        $authors = Author::latest()->get();
        $genres = Genre::latest()->get();
        return view('dashboard.books.create', compact('authors', 'genres'));
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Book::class, 'slug', $request->name);
        return response()->json(['slug' => $slug]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string',
            'slug' => 'required|alpha_dash|unique:books',
            'excerpt' => 'required|string',
            'author_id' => 'required',
            'published_at' => 'required',
            'cover' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'pdf_file' => 'required|mimes:pdf'
        ]);

        $book = new Book();
        $book->name = $request->name;
        $book->excerpt = $request->excerpt;
        $book->author_id = $request->author_id;
        $book->published_at = $request->published_at;

        $cover = $request->file('cover');
        $cover_file_path = date('YmdHis')."-".strtolower(str_replace(' ', '', $request->name)).'.'.$request->file('cover')->getClientOriginalExtension();
        $destinationPath = 'covers/';
        $cover->move($destinationPath, $cover_file_path);

        $pdf_file = $request->file('pdf_file');
        $pdf_file_path = date('YmdHis')."-".strtolower(str_replace(' ', '', $request->name)).'.'.$request->file('pdf_file')->getClientOriginalExtension();
        $destinationPath = 'pdf_files/';
        $pdf_file->move($destinationPath, $pdf_file_path);

        $book->cover = $cover_file_path;
        $book->pdf_file = $pdf_file_path;

        $book->save();

        $genres = Genre::find($request->genres);
        $book->genres()->attach($genres);

        return back()->with('success', 'New book ('.$book->name.') added successfully!');
    }

    public function show(Book $book)
    {
        return view('frontend.pages.book', compact('book'));
    }

    public function edit(Book $book)
    {
        //
    }

    public function update(Request $request, Book $book)
    {
        //
    }

    public function destroy(Book $book)
    {
        //
    }
}
