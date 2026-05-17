@extends('layouts.app')

@section('title', 'Inventaris Obat')

@section('content')
<div class="space-y-6" x-data="{ 
    showModal: false, 
    modalTitle: '', 
    modalAction: '', 
    modalMethod: 'POST',
    obat: {
        id: '',
        kode_obat: '',
        nama_obat: '',
        satuan: 'tablet',
        harga_satuan: 0,
        sumber_obat: 'APBD',
        tanggal_kadaluarsa: '',
        stok_sekarang: 0,
        stok_minimum: 0
    },
    openAddModal() {
        this.modalTitle = 'Tambah Obat Baru';
        this.modalAction = '{{ route('obat.store') }}';
        this.modalMethod = 'POST';
        this.obat = { 
            id: '', 
            kode_obat: '', 
            nama_obat: '', 
            satuan: 'tablet', 
            harga_satuan: 0, 
            sumber_obat: 'APBD', 
            tanggal_kadaluarsa: '', 
            stok_sekarang: 0, 
            stok_minimum: 0 
        };
        this.showModal = true;
    },
    openEditModal(data) {
        this.modalTitle = 'Edit Data Obat';
        this.modalAction = '/obat/' + data.id;
        this.modalMethod = 'PUT';
        this.obat = { ...data };
        this.showModal = true;
    }
}">
    <!-- Header Actions -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div class="relative w-full md:w-96">
            <form action="{{ route('obat.index') }}" method="GET">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama obat atau kode..." class="w-full pl-10 pr-4 py-2 rounded-lg border-gray-200 focus:border-accent focus:ring-accent text-sm transition duration-150">
                <div class="absolute left-3 top-2.5 text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </form>
        </div>
        <button @click="openAddModal()" class="w-full md:w-auto bg-accent hover:bg-blue-500 text-white px-6 py-2 rounded-lg font-bold text-sm flex items-center justify-center transition duration-150 shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Obat
        </button>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-success p-4 text-green-700 text-sm rounded-r-lg shadow-sm flex items-center">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-danger p-4 text-red-700 text-sm rounded-r-lg shadow-sm flex items-center">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('error') }}
        </div>
    @endif

    <!-- Data Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 font-semibold">No</th>
                        <th class="px-6 py-4 font-semibold">Nama Obat</th>
                        <th class="px-6 py-4 font-semibold text-center">Satuan</th>
                        <th class="px-6 py-4 font-semibold text-center">Harga Satuan</th>
                        <th class="px-6 py-4 font-semibold text-center">Sumber</th>
                        <th class="px-6 py-4 font-semibold text-center">Kadaluarsa (1 Bln)</th>
                        <th class="px-6 py-4 font-semibold text-center">Stok</th>
                        <th class="px-6 py-4 font-semibold text-center">Min. Stok</th>
                        <th class="px-6 py-4 font-semibold text-center">Status</th>
                        <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($obat as $index => $item)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $obat->firstItem() + $index }}</td>
                            <td class="px-6 py-4 text-sm font-bold text-primary">{{ $item->nama_obat }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 text-center">{{ ucfirst($item->satuan) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 text-center">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 text-center">{{ $item->sumber_obat }}</td>
                            <td class="px-6 py-4 text-sm text-center">
                                @php
                                    $oneMonthFromNow = \Carbon\Carbon::now()->addMonth();
                                    $nearExpiryCount = $item->stokMasuk()
                                        ->whereBetween('tanggal_kadaluarsa', [\Carbon\Carbon::now(), $oneMonthFromNow])
                                        ->sum('jumlah');
                                    
                                    // Also check the initial expiry date set on the medicine itself
                                    if ($item->tanggal_kadaluarsa && 
                                        \Carbon\Carbon::parse($item->tanggal_kadaluarsa)->isBetween(\Carbon\Carbon::now(), $oneMonthFromNow)) {
                                        // This is tricky because we don't know how much of the 'stok_sekarang' belongs to the initial expiry
                                        // But for the logic you want, we'll focus on the transactions first.
                                    }
                                @endphp

                                @if($nearExpiryCount > 0)
                                    <span class="text-gray-900 font-bold">{{ $nearExpiryCount }} (Akan Kadaluarsa)</span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm font-bold text-center text-gray-900">
                                {{ $item->stok_sekarang }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 text-center">{{ $item->stok_minimum }}</td>
                            <td class="px-6 py-4 text-center">
                                @if($item->stok_sekarang == 0)
                                    <span class="px-3 py-1 text-[10px] font-bold uppercase rounded-full bg-gray-100 text-gray-900">Habis</span>
                                @elseif($item->stok_sekarang <= $item->stok_minimum)
                                    <span class="px-3 py-1 text-[10px] font-bold uppercase rounded-full bg-gray-100 text-gray-900">Menipis</span>
                                @else
                                    <span class="px-3 py-1 text-[10px] font-bold uppercase rounded-full bg-gray-100 text-gray-900">Aman</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center space-x-3">
                                    <button @click='openEditModal(@json($item))' class="text-blue-500 hover:text-blue-700 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>
                                    @if(auth()->user()->role === 'admin')
                                        <form action="{{ route('obat.destroy', $item) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 transition">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-10 text-center text-gray-400 italic">Data obat tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($obat->hasPages())
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                <div class="text-xs text-gray-500">
                    Menampilkan {{ $obat->firstItem() }}-{{ $obat->lastItem() }} dari {{ $obat->total() }} data
                </div>
                <div class="flex space-x-2">
                    @if($obat->onFirstPage())
                        <span class="px-3 py-1 rounded-lg border border-gray-200 text-gray-300 text-xs cursor-not-allowed">Previous</span>
                    @else
                        <a href="{{ $obat->previousPageUrl() }}" class="px-3 py-1 rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-100 text-xs transition">Previous</a>
                    @endif

                    @if($obat->hasMorePages())
                        <a href="{{ $obat->nextPageUrl() }}" class="px-3 py-1 rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-100 text-xs transition">Next</a>
                    @else
                        <span class="px-3 py-1 rounded-lg border border-gray-200 text-gray-300 text-xs cursor-not-allowed">Next</span>
                    @endif
                </div>
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
                <form :action="modalAction" method="POST">
                    @csrf
                    <input type="hidden" name="_method" :value="modalMethod">

                    <div class="bg-white px-6 py-6 border-b border-gray-100">
                        <h3 class="text-xl font-bold text-primary" x-text="modalTitle"></h3>
                    </div>

                    <div class="bg-white px-6 py-6 space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Satuan</label>
                                <select name="satuan" x-model="obat.satuan" required class="w-full rounded-lg border-gray-200 focus:border-accent focus:ring-accent text-sm">
                                    <option value="tablet">Tablet</option>
                                    <option value="kapsul">Kapsul</option>
                                    <option value="botol">Botol</option>
                                    <option value="ampul">Ampul</option>
                                    <option value="tube">Tube</option>
                                    <option value="sachet">Sachet</option>
                                    <option value="vial">Vial</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Harga Satuan (Rp)</label>
                                <input type="number" name="harga_satuan" x-model="obat.harga_satuan" required min="0" class="w-full rounded-lg border-gray-200 focus:border-accent focus:ring-accent text-sm">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Sumber Obat</label>
                                <select name="sumber_obat" x-model="obat.sumber_obat" required class="w-full rounded-lg border-gray-200 focus:border-accent focus:ring-accent text-sm">
                                    <option value="APBD">APBD</option>
                                    <option value="JKN">JKN</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Tanggal Kadaluarsa</label>
                                <input type="date" name="tanggal_kadaluarsa" x-model="obat.tanggal_kadaluarsa" class="w-full rounded-lg border-gray-200 focus:border-accent focus:ring-accent text-sm">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nama Obat</label>
                            <input type="text" name="nama_obat" x-model="obat.nama_obat" required class="w-full rounded-lg border-gray-200 focus:border-accent focus:ring-accent text-sm">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Stok Sekarang</label>
                                <input type="number" name="stok_sekarang" x-model="obat.stok_sekarang" required min="0" class="w-full rounded-lg border-gray-200 focus:border-accent focus:ring-accent text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Min. Stok</label>
                                <input type="number" name="stok_minimum" x-model="obat.stok_minimum" required min="0" class="w-full rounded-lg border-gray-200 focus:border-accent focus:ring-accent text-sm">
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse space-x-2 space-x-reverse">
                        <button type="submit" class="bg-accent hover:bg-blue-500 text-white px-6 py-2 rounded-lg font-bold text-sm transition duration-150">Simpan Data</button>
                        <button type="button" @click="showModal = false" class="bg-white hover:bg-gray-100 text-gray-600 px-6 py-2 rounded-lg font-bold text-sm border border-gray-200 transition duration-150">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
