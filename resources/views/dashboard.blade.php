@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Stat Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Jenis Obat -->
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-accent">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Jenis Obat</p>
                    <h3 class="text-3xl font-bold text-primary mt-1">{{ $stats['total_obat'] }}</h3>
                </div>
                <div class="p-2 bg-blue-50 rounded-lg text-accent">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Stok Aman -->
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-success">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Stok Aman</p>
                    <h3 class="text-3xl font-bold text-primary mt-1">{{ $stats['stok_aman'] }}</h3>
                </div>
                <div class="p-2 bg-green-50 rounded-lg text-success">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Stok Menipis -->
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-warning">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Stok Menipis</p>
                    <h3 class="text-3xl font-bold text-primary mt-1">{{ $stats['stok_menipis'] }}</h3>
                </div>
                <div class="p-2 bg-amber-50 rounded-lg text-warning">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Stok Habis -->
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-danger">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Stok Habis</p>
                    <h3 class="text-3xl font-bold text-primary mt-1">{{ $stats['stok_habis'] }}</h3>
                </div>
                <div class="p-2 bg-red-50 rounded-lg text-danger">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Peringatan Stok Menipis Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-lg font-bold text-primary">Peringatan Stok Menipis</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4 font-semibold">No</th>
                        <th class="px-6 py-4 font-semibold">Nama Obat</th>
                        <th class="px-6 py-4 font-semibold text-center">Satuan</th>
                        <th class="px-6 py-4 font-semibold text-center">Stok Sekarang</th>
                        <th class="px-6 py-4 font-semibold text-center">Stok Minimum</th>
                        <th class="px-6 py-4 font-semibold text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($peringatan_stok as $index => $obat)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 text-sm font-bold text-primary">{{ $obat->nama_obat }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 text-center">{{ $obat->satuan }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 text-center">{{ $obat->stok_sekarang }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 text-center">{{ $obat->stok_minimum }}</td>
                            <td class="px-6 py-4 text-center">
                                @if($obat->stok_sekarang == 0)
                                    <span class="px-3 py-1 text-[10px] font-bold uppercase rounded-full bg-red-100 text-danger">Habis</span>
                                @else
                                    <span class="px-3 py-1 text-[10px] font-bold uppercase rounded-full bg-amber-100 text-warning">Menipis</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-400 italic">Tidak ada stok yang menipis. Semua stok aman!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Riwayat Transaksi Terakhir -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-lg font-bold text-primary">Riwayat Transaksi Terakhir</h3>
            <a href="{{ route('laporan.index') }}" class="text-sm font-medium text-accent hover:underline">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Tanggal</th>
                        <th class="px-6 py-4 font-semibold">Nama Obat</th>
                        <th class="px-6 py-4 font-semibold text-center">Jenis</th>
                        <th class="px-6 py-4 font-semibold text-center">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($transaksi_terakhir as $trx)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 text-sm text-gray-600">{{ \Carbon\Carbon::parse($trx->tanggal)->format('d M Y, H:i') }}</td>
                            <td class="px-6 py-4 text-sm font-bold text-primary">{{ $trx->obat->nama_obat }}</td>
                            <td class="px-6 py-4 text-center">
                                @if($trx->tipe == 'Masuk')
                                    <span class="flex items-center justify-center text-success text-xs font-semibold">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Masuk
                                    </span>
                                @else
                                    <span class="flex items-center justify-center text-warning text-xs font-semibold">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                                        Keluar
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm font-bold text-center {{ $trx->tipe == 'Masuk' ? 'text-primary' : 'text-gray-700' }}">
                                {{ $trx->jumlah }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
