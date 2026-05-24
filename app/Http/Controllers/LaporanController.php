<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\StokMasuk;
use App\Models\StokKeluar;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        $rekap = $this->getRekapData($startDate, $endDate);

        $summary = [
            'total_masuk' => collect($rekap)->sum('masuk'),
            'total_keluar' => collect($rekap)->sum('keluar'),
            'sisa_stok' => Obat::sum('stok_sekarang'),
        ];

        return view('laporan.index', compact('rekap', 'summary', 'startDate', 'endDate'));
    }

    public function export(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        $rekap = $this->getRekapData($startDate, $endDate);
        
        $pdf = Pdf::loadView('laporan.pdf', [
            'rekap' => $rekap,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);

        return $pdf->download('laporan-stok-obat-'.$startDate.'-ke-'.$endDate.'.pdf');
    }

    private function getRekapData($startDate, $endDate)
    {
        $obat = Obat::all();
        $rekap = [];

        foreach ($obat as $item) {
            $masuk = StokMasuk::where('obat_id', $item->id)
                ->whereBetween('tanggal_masuk', [$startDate, $endDate])
                ->sum('jumlah');

            $keluar = StokKeluar::where('obat_id', $item->id)
                ->whereBetween('tanggal_keluar', [$startDate, $endDate])
                ->sum('jumlah');

            // Only add to rekap if there is a transaction (masuk or keluar > 0)
            if ($masuk > 0 || $keluar > 0) {
                $rekap[] = (object) [
                    'nama_obat' => $item->nama_obat,
                    'satuan' => $item->satuan,
                    'harga_satuan' => $item->harga_satuan,
                    'masuk' => $masuk,
                    'keluar' => $keluar,
                    'sisa_stok' => $item->stok_sekarang
                ];
            }
        }

        return $rekap;
    }
}
