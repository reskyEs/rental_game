<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GamesController extends Controller
{
    public function index()
    {
        $games = Game::all();  // Fetch all games from DB
        return view('admin.games.index', compact('games'));
    }

    public function create()
    {
        $genres = Genre::all();
        return view('admin.games.create', compact('genres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'game_name' => 'required|string|max:255',
            'title' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'id_genre' => 'required|exists:genres,id',
            'deskripsi' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'string',
        ]);

        if ($request->hasFile('title')) {
            $titleImagePath = $request->file('title')->store('game_covers', 'public');
        } else {
            $titleImagePath = null;
        }

        $data = $request->only(['game_name', 'id_genre', 'deskripsi', 'images']);
        $data['title'] = $titleImagePath;

        Game::create($data);

        return redirect()->route('games.index')->with('success', 'Game created successfully.');
    }

    public function show($id)
    {
        $game = Game::with('genre')->findOrFail($id);
        return view('admin.games.show', compact('game'));
    }

    public function edit($id)
    {
        $game = Game::findOrFail($id);
        $genres = Genre::all();
        return view('admin.games.edit', compact('game', 'genres'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'game_name' => 'required|string|max:255',
            'title' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'id_genre' => 'required|exists:genres,id',
            'deskripsi' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'string',
        ]);

        $game = Game::findOrFail($id);

        if ($request->hasFile('title')) {
            if ($game->title && Storage::disk('public')->exists($game->title)) {
                Storage::disk('public')->delete($game->title);
            }

            $titleImagePath = $request->file('title')->store('game_covers', 'public');
            $game->title = $titleImagePath;
        }

        $game->game_name = $request->game_name;
        $game->id_genre = $request->id_genre;
        $game->deskripsi = $request->deskripsi;
        $game->images = $request->images;
        $game->save();

        return redirect()->route('games.index')->with('success', 'Game updated successfully.');
    }

    public function destroy($id)
    {
        $game = Game::findOrFail($id);

        if ($game->title && Storage::disk('public')->exists($game->title)) {
            Storage::disk('public')->delete($game->title);
        }

        $game->delete();

        return redirect()->route('games.index')->with('success', 'Game deleted successfully.');
    }
}
