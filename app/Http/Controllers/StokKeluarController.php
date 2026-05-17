<?php

namespace App\Http\Controllers;

use App\Models\StokKeluar;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokKeluarController extends Controller
{
    public function index()
    {
        $transaksi = StokKeluar::with('obat', 'user')->latest()->paginate(10);
        $obat = Obat::where('stok_sekarang', '>', 0)->get();
        return view('stok-keluar.index', compact('transaksi', 'obat'));
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
            StokKeluar::create([
                'obat_id' => $request->obat_id,
                'jumlah' => $request->jumlah,
                'tanggal_keluar' => $request->tanggal_keluar,
                'created_by' => auth()->id(),
            ]);

            $obat->decrement('stok_sekarang', $request->jumlah);
        });

        return redirect()->route('stok-keluar.index')->with('success', 'Stok keluar berhasil dicatat.');
    }

    public function update(Request $request, StokKeluar $stokKeluar)
    {
        $request->validate([
            'obat_id' => 'required|exists:obat,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_keluar' => 'required|date',
        ]);

        $obat = Obat::find($request->obat_id);
        $selisih = $request->jumlah - $stokKeluar->jumlah;

        if ($obat->stok_sekarang < $selisih) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Stok tidak mencukupi untuk pembaruan ini. Stok saat ini: ' . $obat->stok_sekarang);
        }

        DB::transaction(function () use ($request, $stokKeluar, $obat, $selisih) {
            $stokKeluar->update([
                'obat_id' => $request->obat_id,
                'jumlah' => $request->jumlah,
                'tanggal_keluar' => $request->tanggal_keluar,
            ]);

            $obat->decrement('stok_sekarang', $selisih);
        });

        return redirect()->route('stok-keluar.index')->with('success', 'Catatan stok keluar berhasil diperbarui.');
    }

    public function destroy(StokKeluar $stokKeluar)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('stok-keluar.index')->with('error', 'Hanya admin yang dapat menghapus data.');
        }

        DB::transaction(function () use ($stokKeluar) {
            $obat = Obat::find($stokKeluar->obat_id);
            $obat->increment('stok_sekarang', $stokKeluar->jumlah);
            $stokKeluar->delete();
        });

        return redirect()->route('stok-keluar.index')->with('success', 'Catatan stok keluar berhasil dihapus.');
    }
}
