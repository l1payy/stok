<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ObatController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $obat = Obat::when($search, function($query, $search) {
            return $query->where('nama_obat', 'like', "%{$search}%")
                         ->orWhere('kode_obat', 'like', "%{$search}%");
        })
        ->paginate(10);

        return view('obat.index', compact('obat'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_obat' => 'required',
            'satuan' => 'required',
            'harga_satuan' => 'required|numeric|min:0',
            'sumber_obat' => 'required|in:APBD,JKN',
            'tanggal_kadaluarsa' => 'nullable|date',
            'stok_sekarang' => 'required|integer|min:0',
            'stok_minimum' => 'required|integer|min:0',
        ]);

        $validated['kode_obat'] = 'OBT-' . strtoupper(uniqid());

        Obat::create($validated);

        return redirect()->route('obat.index')->with('success', 'Data obat berhasil ditambahkan.');
    }

    public function update(Request $request, Obat $obat)
    {
        $validated = $request->validate([
            'nama_obat' => 'required',
            'satuan' => 'required',
            'harga_satuan' => 'required|numeric|min:0',
            'sumber_obat' => 'required|in:APBD,JKN',
            'tanggal_kadaluarsa' => 'nullable|date',
            'stok_sekarang' => 'required|integer|min:0',
            'stok_minimum' => 'required|integer|min:0',
        ]);

        $obat->update($validated);

        return redirect()->route('obat.index')->with('success', 'Data obat berhasil diperbarui.');
    }

    public function destroy(Obat $obat)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('obat.index')->with('error', 'Hanya admin yang dapat menghapus data.');
        }

        $obat->delete();

        return redirect()->route('obat.index')->with('success', 'Data obat berhasil dihapus.');
    }
}
