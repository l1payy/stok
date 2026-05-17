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
        $request->validate([
            'obat_id' => 'required|exists:obat,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_keluar' => 'required|date',
        ]);

        $obat = Obat::find($request->obat_id);
        
        if ($obat->stok_sekarang < $request->jumlah) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Stok tidak mencukupi. Stok saat ini: ' . $obat->stok_sekarang);
        }

        DB::transaction(function () use ($request, $obat) {
            TransaksiKeluar::create([
                'obat_id' => $request->obat_id,
                'jumlah' => $request->jumlah,
                'tanggal_keluar' => $request->tanggal_keluar,
                'created_by' => auth()->id(),
            ]);

            $obat->decrement('stok_sekarang', $request->jumlah);
        });

        return redirect()->route('transaksi-keluar.index')->with('success', 'Stok keluar berhasil dicatat.');
    }

    public function update(Request $request, TransaksiKeluar $transaksiKeluar)
    {
        $request->validate([
            'obat_id' => 'required|exists:obat,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_keluar' => 'required|date',
        ]);

        $obat = Obat::find($request->obat_id);
        $selisih = $request->jumlah - $transaksiKeluar->jumlah;

        if ($obat->stok_sekarang < $selisih) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Stok tidak mencukupi untuk pembaruan ini. Stok saat ini: ' . $obat->stok_sekarang);
        }

        DB::transaction(function () use ($request, $transaksiKeluar, $obat, $selisih) {
            $transaksiKeluar->update([
                'obat_id' => $request->obat_id,
                'jumlah' => $request->jumlah,
                'tanggal_keluar' => $request->tanggal_keluar,
            ]);

            $obat->decrement('stok_sekarang', $selisih);
        });

        return redirect()->route('transaksi-keluar.index')->with('success', 'Catatan stok keluar berhasil diperbarui.');
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
