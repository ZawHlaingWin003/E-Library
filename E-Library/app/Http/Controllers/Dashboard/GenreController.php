<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{

    public function index()
    {
        $genres = Genre::orderBy('id', 'desc')->paginate(5);
        return view('dashboard.genres.index', compact('genres'));
    }

    public function create()
    {
        return view('dashboard.genres.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:genres,name'
        ]);

        $names = explode(",", $request->name);

        foreach ($names as $name) {
            $genre = new Genre();
            $genre->name = $name;
            $genre->save();
        }

        return back()->with('success', 'Genres added successfully!');
    }

    public function show(Genre $genre)
    {
        //
    }

    public function edit(Genre $genre)
    {
        return view('dashboard.genres.edit', compact('genre'));
    }

    public function update(Request $request, Genre $genre)
    {
        $request->validate([
            'name' => 'required|string|unique:genres,name,'.$genre->id
        ]);

        $genre->name = $request->name;
        $genre->update();

        return redirect()->route('genres.index')->with('success', 'Genres Updated successfully!');
    }

    public function destroy(Genre $genre)
    {
        $genre->delete();
        return back()->with('success', 'Genre deleted successfully!');
    }
}
