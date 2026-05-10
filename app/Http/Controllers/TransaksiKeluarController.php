<?php

namespace App\Http\Controllers;

use App\Models\TransaksiKeluar;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiKeluarController extends Controller
{
    public function index()
    {
        $transaksi = TransaksiKeluar::with('obat', 'user')->latest()->paginate(10);
        $obat = Obat::where('stok_sekarang', '>', 0)->get();
        return view('transaksi-keluar.index', compact('transaksi', 'obat'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'obat_id' => 'required|exists:obat,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_keluar' => 'required|date',
        ]);

        $obat = Obat::find($validated['obat_id']);
        
        if ($obat->stok_sekarang < $validated['jumlah']) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi. Stok saat ini: ' . $obat->stok_sekarang);
        }

        DB::transaction(function () use ($validated, $obat) {
            $validated['created_by'] = auth()->id();
            TransaksiKeluar::create($validated);

            $obat->decrement('stok_sekarang', $validated['jumlah']);
        });

        return redirect()->route('transaksi-keluar.index')->with('success', 'Stok keluar berhasil dicatat.');
    }

    public function destroy(TransaksiKeluar $transaksiKeluar)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('transaksi-keluar.index')->with('error', 'Hanya admin yang dapat menghapus data.');
        }

        DB::transaction(function () use ($transaksiKeluar) {
            $obat = Obat::find($transaksiKeluar->obat_id);
            $obat->increment('stok_sekarang', $transaksiKeluar->jumlah);
            $transaksiKeluar->delete();
        });

        return redirect()->route('transaksi-keluar.index')->with('success', 'Catatan stok keluar berhasil dihapus.');
    }
}
