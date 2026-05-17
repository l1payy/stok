<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\TransaksiMasuk;
use App\Models\TransaksiKeluar;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_obat' => Obat::count(),
            'stok_aman' => Obat::whereColumn('stok_sekarang', '>', 'stok_minimum')->count(),
            'stok_menipis' => Obat::whereColumn('stok_sekarang', '<=', 'stok_minimum')
                ->where('stok_sekarang', '>', 0)
                ->count(),
            'stok_habis' => Obat::where('stok_sekarang', 0)->count(),
        ];

        $peringatan_stok = Obat::whereColumn('stok_sekarang', '<=', 'stok_minimum')
            ->orderBy('stok_sekarang', 'asc')
            ->get();

        $transaksi_terakhir = collect();
        
        $masuk = TransaksiMasuk::with('obat', 'user')->latest()->take(5)->get()->map(function($item) {
            $item->tipe = 'Masuk';
            $item->display_date = $item->created_at;
            return $item;
        });

        $keluar = TransaksiKeluar::with('obat', 'user')->latest()->take(5)->get()->map(function($item) {
            $item->tipe = 'Keluar';
            $item->display_date = $item->created_at;
            return $item;
        });

        $transaksi_terakhir = $masuk->concat($keluar)->sortByDesc('display_date')->take(5);

        return view('dashboard', compact('stats', 'peringatan_stok', 'transaksi_terakhir'));
    }
}
