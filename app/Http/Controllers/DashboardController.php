<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\StokMasuk;
use App\Models\StokKeluar;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $oneMonthFromNow = Carbon::now()->addMonth();
        
        $stats = [
            'total_obat' => Obat::count(),
            'stok_aman' => Obat::whereColumn('stok_sekarang', '>', 'stok_minimum')->count(),
            'stok_menipis' => Obat::whereColumn('stok_sekarang', '<=', 'stok_minimum')
                ->where('stok_sekarang', '>', 0)
                ->count(),
            'stok_habis' => Obat::where('stok_sekarang', 0)->count(),
            // Hitung jumlah item obat yang akan kadaluarsa dalam 1 bulan
            'kadaluarsa_sebulan' => StokMasuk::whereBetween('tanggal_kadaluarsa', [$now, $oneMonthFromNow])
                ->distinct('obat_id')
                ->count('obat_id'),
            // Hitung jumlah item obat yang sudah kadaluarsa
            'sudah_kadaluarsa' => StokMasuk::where('tanggal_kadaluarsa', '<', $now)
                ->distinct('obat_id')
                ->count('obat_id'),
        ];

        $peringatan_stok = Obat::whereColumn('stok_sekarang', '<=', 'stok_minimum')
            ->orderBy('stok_sekarang', 'asc')
            ->get();

        $transaksi_terakhir = collect();
        
        $masuk = StokMasuk::with('obat', 'user')->latest()->take(5)->get()->map(function($item) {
            $item->tipe = 'Masuk';
            $item->display_date = $item->created_at;
            return $item;
        });

        $keluar = StokKeluar::with('obat', 'user')->latest()->take(5)->get()->map(function($item) {
            $item->tipe = 'Keluar';
            $item->display_date = $item->created_at;
            return $item;
        });

        $transaksi_terakhir = $masuk->concat($keluar)->sortByDesc('display_date')->take(5);

        return view('dashboard', compact('stats', 'peringatan_stok', 'transaksi_terakhir'));
    }
}
