@extends('layouts.app')

@section('title', 'Manajemen Stok Masuk')

@section('content')
<div class="space-y-6" x-data="{ showModal: false }">
    <!-- Header Actions -->
    <div class="flex justify-between items-center">
        <p class="text-sm text-gray-500">Catat penerimaan obat baru ke gudang</p>
        <button @click="showModal = true" class="bg-accent hover:bg-blue-500 text-white px-6 py-2 rounded-lg font-bold text-sm flex items-center transition duration-150 shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Catat Stok Masuk
        </button>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-success p-4 text-green-700 text-sm rounded-r-lg shadow-sm flex items-center">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Data Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 font-semibold">No</th>
                        <th class="px-6 py-4 font-semibold">Tanggal</th>
                        <th class="px-6 py-4 font-semibold">Nama Obat</th>
                        <th class="px-6 py-4 font-semibold text-center">Satuan</th>
                        <th class="px-6 py-4 font-semibold text-center">Jumlah Masuk</th>
                        <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($transaksi as $index => $item)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $transaksi->firstItem() + $index }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ \Carbon\Carbon::parse($item->tanggal_masuk)->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-sm font-bold text-primary">{{ $item->obat->nama_obat }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 text-center">{{ ucfirst($item->obat->satuan) }}</td>
                            <td class="px-6 py-4 text-sm font-bold text-center text-accent">+ {{ $item->jumlah }}</td>
                            <td class="px-6 py-4 text-center">
                                @if(auth()->user()->role === 'admin')
                                    <form action="{{ route('transaksi-masuk.destroy', $item) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan ini? Stok akan dikurangi kembali.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center text-gray-400 italic">Belum ada riwayat stok masuk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($transaksi->hasPages())
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                <div class="text-xs text-gray-500">
                    Menampilkan {{ $transaksi->firstItem() }}-{{ $transaksi->lastItem() }} dari {{ $transaksi->total() }} data
                </div>
                {{ $transaksi->links() }}
            </div>
        @endif
    </div>

    <!-- Modal Form -->
    <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity" @click="showModal = false">
                <div class="absolute inset-0 bg-black opacity-50"></div>
            </div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>&#8203;

            <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form action="{{ route('transaksi-masuk.store') }}" method="POST">
                    @csrf
                    <div class="bg-white px-6 py-6 border-b border-gray-100">
                        <h3 class="text-xl font-bold text-primary">Catat Stok Masuk</h3>
                    </div>

                    <div class="bg-white px-6 py-6 space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Pilih Obat</label>
                            <select name="obat_id" required class="w-full rounded-lg border-gray-200 focus:border-accent focus:ring-accent text-sm">
                                <option value="">-- Pilih Obat --</option>
                                @foreach($obat as $o)
                                    <option value="{{ $o->id }}">{{ $o->kode_obat }} - {{ $o->nama_obat }} (Stok: {{ $o->stok_sekarang }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Jumlah Masuk</label>
                                <input type="number" name="jumlah" required min="1" class="w-full rounded-lg border-gray-200 focus:border-accent focus:ring-accent text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Tanggal Masuk</label>
                                <input type="date" name="tanggal_masuk" value="{{ date('Y-m-d') }}" required class="w-full rounded-lg border-gray-200 focus:border-accent focus:ring-accent text-sm">
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse space-x-2 space-x-reverse">
                        <button type="submit" class="bg-accent hover:bg-blue-500 text-white px-6 py-2 rounded-lg font-bold text-sm transition duration-150">Simpan Catatan</button>
                        <button type="button" @click="showModal = false" class="bg-white hover:bg-gray-100 text-gray-600 px-6 py-2 rounded-lg font-bold text-sm border border-gray-200 transition duration-150">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
