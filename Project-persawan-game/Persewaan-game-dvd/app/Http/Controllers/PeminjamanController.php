<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjamen;
use App\Models\Game;

class PeminjamanController extends Controller
{

    public function index()
    {
        $peminjamans = Peminjamen::with('game')->orderBy('created_at', 'desc')->get();

        return view('customer.peminjaman.history', compact('peminjamans'));
    }

    public function create($game_id)
    {
        $game = Game::findOrFail($game_id);
        return view('customer.peminjaman.create', compact('game'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_customer' => 'required|string|max:255',
            'id_game' => 'required|exists:games,id',
            'waktu_peminjaman' => 'required|date',
            'waktu_kembalian' => 'required|date|after_or_equal:waktu_peminjaman',
        ]);

        Peminjamen::create([
            'nama_customer' => $request->nama_customer,
            'id_game' => $request->id_game,
            'waktu_peminjaman' => $request->waktu_peminjaman,
            'waktu_kembalian' => $request->waktu_kembalian,
        ]);

        return redirect()->route('customer.dashboard')->with('success', 'Peminjaman berhasil dibuat!');
    }

    
}
