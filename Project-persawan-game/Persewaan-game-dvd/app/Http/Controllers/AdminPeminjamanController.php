<?php

namespace App\Http\Controllers;

use App\Models\Peminjamen;

use Illuminate\Http\Request;

class AdminPeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjamen::with('game')->orderBy('created_at', 'desc')->get();
        return view('admin.history', compact('peminjamans'));
    }

   public function destroy($id)
{
    $peminjaman = Peminjamen::findOrFail($id);
    $peminjaman->delete();

    // Redirect ke route 'admin.history' yang otomatis memanggil index()
return redirect()->route('history.index')->with('success', 'Data peminjaman berhasil dihapus.');
}

}
