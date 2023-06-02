<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use App\Models\Author;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::orderBy('id', 'desc')->paginate(5);
        return view('dashboard.pages.authors.index', compact('authors'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        return view('dashboard.pages.authors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'biography' => 'required|string',
            'profile' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $author = new Author();
        $author->name = $request->name;
        $author->biography = $request->biography;

        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $folder = 'public/authors';

            $fileName = Helper::storeFile($file, $folder, $request->name);
            $author->profile = $fileName;
        }

        $author->save();

        return redirect()->route('authors.list')
            ->with('success', 'New author (' . $author->name . ') added successfully!');
    }

    

    public function edit(Author $author)
    {
        return view('dashboard.pages.authors.edit', compact('author'));
    }

    public function update(Request $request, Author $author)
    {
        $request->validate([
            'name' => 'required|string',
            'biography' => 'required|string',
            'profile' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $author->name = $request->name;
        $author->biography = $request->biography;

        if ($request->hasFile('profile')) {
            // Disable Profile Accessor and Delete Old File
            $folder = 'public/authors';

            $originalFile = $author->getRawOriginal('profile');
            Helper::deleteOldFile($originalFile, $folder);

            // Store File Into Storage Folder
            $file = $request->file('profile');
            $fileName = Helper::storeFile($file, $folder, $request->name);
            
            $author->profile = $fileName;
        } else {
            unset($request->profile);
        }

        $author->update();

        return redirect()->route('authors.list')
            ->with('success', 'Author updated successfully!');
    }

    public function destroy(Author $author)
    {
        $originalFile = $author->getRawOriginal('profile');
        $folder = 'public/authors';

        Helper::deleteOldFile($originalFile, $folder);

        $author->delete();
        return back()->with('success', 'Author deleted successfully!');
    }
}
