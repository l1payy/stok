@extends('layouts.app')

@section('title', 'Laporan Penggunaan Obat')

@section('content')
<div class="space-y-6">
    <!-- Filter Bar -->
    <div class="bg-white p-6 rounded-xl shadow-sm">
        <form action="{{ route('laporan.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Tanggal Awal</label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="w-full rounded-lg border-gray-200 focus:border-accent focus:ring-accent text-sm transition duration-150">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Tanggal Akhir</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="w-full rounded-lg border-gray-200 focus:border-accent focus:ring-accent text-sm transition duration-150">
            </div>
            <div>
                <button type="submit" class="w-full bg-primary hover:bg-blue-900 text-white px-6 py-2 rounded-lg font-bold text-sm flex items-center justify-center transition duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    Tampilkan
                </button>
            </div>
            <div>
                <a href="{{ route('laporan.export', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="w-full border border-danger text-danger hover:bg-red-50 px-6 py-2 rounded-lg font-bold text-sm flex items-center justify-center transition duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    Export PDF
                </a>
            </div>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-accent">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Obat Masuk</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($summary['total_masuk']) }}</h3>
                    <p class="text-[10px] text-gray-400 mt-1">Item Obat</p>
                </div>
                <div class="p-2 bg-gray-50 rounded-lg text-gray-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-accent">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Obat Keluar</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($summary['total_keluar']) }}</h3>
                    <p class="text-[10px] text-gray-400 mt-1">Item Obat</p>
                </div>
                <div class="p-2 bg-gray-50 rounded-lg text-gray-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-accent">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Sisa Stok</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($summary['sisa_stok']) }}</h3>
                    <p class="text-[10px] text-gray-400 mt-1">Unit Tersedia</p>
                </div>
                <div class="p-2 bg-gray-50 rounded-lg text-gray-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Rekap Transaksi Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-lg font-bold text-primary">Rekap Transaksi</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4 font-semibold">No</th>
                        <th class="px-6 py-4 font-semibold">Nama Obat</th>
                        <th class="px-6 py-4 font-semibold text-center">Satuan</th>
                        <th class="px-6 py-4 font-semibold text-center">Masuk</th>
                        <th class="px-6 py-4 font-semibold text-center">Keluar</th>
                        <th class="px-6 py-4 font-semibold text-center">Sisa Stok</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($rekap as $index => $item)
                        <tr class="hover:bg-gray-50 transition duration-150 border-b border-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 text-sm font-bold text-primary">{{ $item->nama_obat }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500 text-center">{{ ucfirst($item->satuan) }}</td>
                            <td class="px-6 py-4 text-sm font-bold text-center text-gray-900">{{ number_format($item->masuk) }}</td>
                            <td class="px-6 py-4 text-sm font-bold text-center text-gray-900">{{ number_format($item->keluar) }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 text-sm font-bold text-gray-900 rounded-lg">
                                    {{ number_format($item->sisa_stok) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-400 italic">Data transaksi tidak ditemukan untuk periode ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
