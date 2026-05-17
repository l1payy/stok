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
        $request->validate([
            'obat_id' => 'required|exists:obat,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_masuk' => 'required|date',
        ]);

        DB::transaction(function () use ($request) {
            TransaksiMasuk::create([
                'obat_id' => $request->obat_id,
                'jumlah' => $request->jumlah,
                'tanggal_masuk' => $request->tanggal_masuk,
                'created_by' => auth()->id(),
            ]);

            $obat = Obat::find($request->obat_id);
            $obat->increment('stok_sekarang', $request->jumlah);
        });

        return redirect()->route('transaksi-masuk.index')->with('success', 'Stok masuk berhasil dicatat.');
    }

    public function update(Request $request, TransaksiMasuk $transaksiMasuk)
    {
        $request->validate([
            'obat_id' => 'required|exists:obat,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_masuk' => 'required|date',
        ]);

        $obat = Obat::find($request->obat_id);
        $selisih = $request->jumlah - $transaksiMasuk->jumlah;

        DB::transaction(function () use ($request, $transaksiMasuk, $obat, $selisih) {
            $transaksiMasuk->update([
                'obat_id' => $request->obat_id,
                'jumlah' => $request->jumlah,
                'tanggal_masuk' => $request->tanggal_masuk,
            ]);

            $obat->increment('stok_sekarang', $selisih);
        });

        return redirect()->route('transaksi-masuk.index')->with('success', 'Catatan stok masuk berhasil diperbarui.');
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
