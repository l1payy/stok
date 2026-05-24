<?php

namespace App\Http\Controllers;

use App\Models\StokMasuk;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokMasukController extends Controller
{
    public function index()
    {
        $transaksi = StokMasuk::with('obat', 'user')->latest()->paginate(10);
        $obat = Obat::all();
        return view('stok-masuk.index', compact('transaksi', 'obat'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'obat_id' => 'required|exists:obat,id',
            'jumlah' => 'required|integer|min:1',
            'sumber_obat' => 'required|in:APBD,JKN',
            'tanggal_kadaluarsa' => 'nullable|date',
            'tanggal_masuk' => 'required|date',
        ]);

        DB::transaction(function () use ($validated) {
            $validated['created_by'] = auth()->id();
            StokMasuk::create($validated);

            $obat = Obat::find($validated['obat_id']);
            $obat->increment('stok_sekarang', $validated['jumlah']);
            
            // Update obat's source only, DON'T overwrite expiry date
            $obat->update([
                'sumber_obat' => $validated['sumber_obat'],
            ]);
        });

        return redirect()->route('stok-masuk.index')->with('success', 'Stok masuk berhasil dicatat.');
    }

    public function update(Request $request, StokMasuk $stokMasuk)
    {
        $request->validate([
            'obat_id' => 'required|exists:obat,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_masuk' => 'required|date',
        ]);

        $obat = Obat::find($request->obat_id);
        $selisih = $request->jumlah - $stokMasuk->jumlah;

        DB::transaction(function () use ($request, $stokMasuk, $obat, $selisih) {
            $stokMasuk->update([
                'obat_id' => $request->obat_id,
                'jumlah' => $request->jumlah,
                'tanggal_masuk' => $request->tanggal_masuk,
            ]);

            $obat->increment('stok_sekarang', $selisih);
        });

        return redirect()->route('stok-masuk.index')->with('success', 'Catatan stok masuk berhasil diperbarui.');
    }

    public function destroy(StokMasuk $stokMasuk)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('stok-masuk.index')->with('error', 'Hanya admin yang dapat menghapus data.');
        }

        DB::transaction(function () use ($stokMasuk) {
            $obat = Obat::find($stokMasuk->obat_id);
            $obat->decrement('stok_sekarang', $stokMasuk->jumlah);
            $stokMasuk->delete();
        });

        return redirect()->route('stok-masuk.index')->with('success', 'Catatan stok masuk berhasil dihapus.');
    }
}
