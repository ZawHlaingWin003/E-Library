<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use App\Models\Book;
use App\Models\Genre;
use App\Models\Author;
use Cviebrock\EloquentSluggable\Services\SlugService;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('author')->latest()->paginate(6);
        return view('dashboard.pages.books.index', compact('books'))
            ->with('i', (request()->input('page', 1) - 1) * 6);
    }

    public function create()
    {
        $authors = Author::latest()->get();
        $genres = Genre::latest()->get();
        return view('dashboard.pages.books.create', compact('authors', 'genres'));
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

        if ($request->hasFile('cover')) {
            $file = $request->file('cover');
            $folder = "public/books/$request->slug/covers";

            $fileName = Helper::storeFile($file, $folder, $request->slug);
            $book->cover = $fileName;
        }

        if ($request->hasFile('pdf_file')) {
            $file = $request->file('pdf_file');
            $folder = "public/books/$request->slug/pdf_files";

            $fileName = Helper::storeFile($file, $folder, $request->slug);
            $book->pdf_file = $fileName;
        }

        $book->save();

        $genres = Genre::find($request->genres);
        $book->genres()->attach($genres);

        return redirect()->route('books.list')
            ->with('success', 'New book (' . $book->name . ') added successfully!');
    }

    public function edit(Book $book)
    {
        $authors = Author::latest()->get();
        $genres = Genre::latest()->get();
        return view('dashboard.pages.books.edit', compact('book', 'authors', 'genres'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'name' => 'required|string',
            'slug' => 'required|alpha_dash|unique:books,slug,' . $book->id,
            'excerpt' => 'required|string',
            'author_id' => 'required',
            'published_at' => 'required',
            'cover' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'pdf_file' => 'mimes:pdf'
        ]);

        $book->name = $request->name;
        $book->excerpt = $request->excerpt;
        $book->author_id = $request->author_id;
        $book->published_at = $request->published_at;

        if ($request->hasFile('cover')) {
            $folder = "public/books/$request->slug/covers";
            $originalCoverFile = $book->getRawOriginal('cover');
            Helper::deleteOldFile($originalCoverFile, $folder);

            $file = $request->file('cover');
            $fileName = Helper::storeFile($file, $folder, $request->slug);
            $book->cover = $fileName;
        } else {
            unset($request->cover);
        }

        if ($request->hasFile('pdf_file')) {
            $folder = "public/books/$request->slug/pdf_files";
            $originalPdfFile = $book->getRawOriginal('pdf_file');
            Helper::deleteOldFile($originalPdfFile, $folder);

            $file = $request->file('pdf_file');
            $fileName = Helper::storeFile($file, $folder, $request->slug);
            $book->pdf_file = $fileName;
        } else {
            unset($request->pdf_file);
        }

        $genres = Genre::find($request->genres);
        $book->genres()->sync($genres);

        $book->update();

        return redirect()->route('books.list')
            ->with('success', 'Book (' . $book->name . ') updated successfully!');
    }

    public function destroy(Book $book)
    {
        $folder = "public/books/$book->slug/covers";
        $originalCoverFile = $book->getRawOriginal('cover');
        Helper::deleteOldFile($originalCoverFile, $folder);

        $folder = "public/books/$book->slug/pdf_files";
        $originalPdfFile = $book->getRawOriginal('pdf_file');
        Helper::deleteOldFile($originalPdfFile, $folder);

        $genres = $book->genres;
        $book->genres()->detach($genres);

        $book->delete();

        return back()->with('success', 'Book "' . $book->name . '" deleted successfully!');
    }
}
