<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index()
    {
        $genres = Genre::all();
        return view('admin.genre.index', compact('genres'));
    }

    public function create()
    {
        return view('admin.genre.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ganre_name' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        Genre::create($request->only('ganre_name', 'deskripsi'));

        // Similarly in update:

        return redirect()->route('genres.index')->with('success', 'Genre Berhasil di buat.');
    }

    public function show($id)
    {
        $genre = Genre::findOrFail($id);
        return view('admin.genre.show', compact('genre'));
    }

    public function edit($id)
    {
        $genre = Genre::findOrFail($id);
        return view('admin.genre.edit', compact('genre'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ganre_name' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $genre = Genre::findOrFail($id);
        $genre->update($request->only('ganre_name', 'deskripsi'));

        return redirect()->route('genres.index')->with('success', 'Genre updated successfully.');
    }

    public function destroy($id)
    {
        $genre = Genre::findOrFail($id);
        $genre->delete();

        return redirect()->route('genres.index')->with('success', 'Genre deleted successfully.');
    }
}
