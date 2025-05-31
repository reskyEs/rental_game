<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;

class ShowGameController extends Controller
{


    public function index()
    {
        $games = Game::with('genre')->get();
        return view('customer.dashboard', compact('games'));
    }

    public function show($id)
    {
        $game = Game::with('genre')->findOrFail($id);
        return view('customer.dashboard', compact('game'));
    }


}
