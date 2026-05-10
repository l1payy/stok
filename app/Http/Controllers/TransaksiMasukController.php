<?php

namespace App\Http\Controllers;

use App\Models\TransaksiMasuk;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiMasukController extends Controller
{
    public function index()
    {
        $transaksi = TransaksiMasuk::with('obat', 'user')->latest()->paginate(10);
        $obat = Obat::all();
        return view('transaksi-masuk.index', compact('transaksi', 'obat'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'obat_id' => 'required|exists:obat,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_masuk' => 'required|date',
        ]);

        DB::transaction(function () use ($validated) {
            $validated['created_by'] = auth()->id();
            TransaksiMasuk::create($validated);

            $obat = Obat::find($validated['obat_id']);
            $obat->increment('stok_sekarang', $validated['jumlah']);
        });

        return redirect()->route('transaksi-masuk.index')->with('success', 'Stok masuk berhasil dicatat.');
    }

    public function destroy(TransaksiMasuk $transaksiMasuk)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('transaksi-masuk.index')->with('error', 'Hanya admin yang dapat menghapus data.');
        }

        DB::transaction(function () use ($transaksiMasuk) {
            $obat = Obat::find($transaksiMasuk->obat_id);
            $obat->decrement('stok_sekarang', $transaksiMasuk->jumlah);
            $transaksiMasuk->delete();
        });

        return redirect()->route('transaksi-masuk.index')->with('success', 'Catatan stok masuk berhasil dihapus.');
    }
}
