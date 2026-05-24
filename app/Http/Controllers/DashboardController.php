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
        $now = Carbon::now()->startOfDay();
        $oneMonthFromNow = Carbon::now()->addMonth()->endOfDay();
        
        $allObat = Obat::with(['stokMasuk', 'stokKeluar'])->get();
        
        $countSudahKadaluarsa = 0;
        $countAkanKadaluarsa = 0;

        foreach ($allObat as $obat) {
            // Logika FEFO untuk menentukan sisa stok per batch
            $batches = collect();
            
            $totalMasuk = $obat->stokMasuk->sum('jumlah');
            $totalKeluar = $obat->stokKeluar->sum('jumlah');
            $stokAwal = max(0, $obat->stok_sekarang + $totalKeluar - $totalMasuk);
            
            if ($stokAwal > 0) {
                $batches->push([
                    'qty' => $stokAwal,
                    'expiry' => $obat->tanggal_kadaluarsa ? Carbon::parse($obat->tanggal_kadaluarsa) : null
                ]);
            }
            
            foreach ($obat->stokMasuk as $trx) {
                $batches->push([
                    'qty' => $trx->jumlah,
                    'expiry' => $trx->tanggal_kadaluarsa ? Carbon::parse($trx->tanggal_kadaluarsa) : null
                ]);
            }

            $sortedBatches = $batches->sortByDesc(function($batch) {
                return $batch['expiry'] ? $batch['expiry']->timestamp : 9999999999;
            });

            $sisaStokTersedia = $obat->stok_sekarang;
            $isSudah = false;
            $isAkan = false;

            foreach ($sortedBatches as $batch) {
                if ($sisaStokTersedia <= 0) break;
                
                $qtyInThisBatch = min($sisaStokTersedia, $batch['qty']);
                $sisaStokTersedia -= $qtyInThisBatch;
                
                if ($batch['expiry']) {
                    if ($batch['expiry']->lt($now)) {
                        $isSudah = true;
                    } elseif ($batch['expiry']->isBetween($now, $oneMonthFromNow)) {
                        $isAkan = true;
                    }
                }
            }

            if ($isSudah) $countSudahKadaluarsa++;
            if ($isAkan) $countAkanKadaluarsa++;
        }
        
        $stats = [
            'total_obat' => $allObat->count(),
            'stok_aman' => Obat::whereColumn('stok_sekarang', '>', 'stok_minimum')->count(),
            'stok_menipis' => Obat::whereColumn('stok_sekarang', '<=', 'stok_minimum')
                ->where('stok_sekarang', '>', 0)
                ->count(),
            'stok_habis' => Obat::where('stok_sekarang', 0)->count(),
            'kadaluarsa_sebulan' => $countAkanKadaluarsa,
            'sudah_kadaluarsa' => $countSudahKadaluarsa,
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
