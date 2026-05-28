@extends('layouts.app')

@section('title', 'Profil')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Informasi Profil -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-xl font-bold text-primary">Informasi Profil</h3>
            <p class="text-sm text-gray-500 mt-1">Perbarui informasi profil dan alamat email akun Anda.</p>
        </div>

        <form method="post" action="{{ route('profile.update') }}" class="p-6 space-y-6">
            @csrf
            @method('patch')

            @if (session('status') === 'profile-updated')
                <div class="bg-green-100 border-l-4 border-success p-4 text-green-700 text-sm rounded-r-lg shadow-sm flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Profil berhasil diperbarui.
                </div>
            @endif

            <div>
                <label for="name" class="block text-xs font-bold text-gray-500 uppercase mb-1">Nama</label>
                <input
                    id="name"
                    name="name"
                    type="text"
                    class="w-full rounded-lg border-gray-200 focus:border-accent focus:ring-accent text-sm"
                    value="{{ old('name', auth()->user()->name) }}"
                    required
                    autofocus
                >
                @if($errors->updateProfileInformation->has('name'))
                    <p class="mt-1 text-xs text-red-500">{{ $errors->updateProfileInformation->first('name') }}</p>
                @endif
            </div>

            <div>
                <label for="email" class="block text-xs font-bold text-gray-500 uppercase mb-1">Email</label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    class="w-full rounded-lg border-gray-200 focus:border-accent focus:ring-accent text-sm"
                    value="{{ old('email', auth()->user()->email) }}"
                    required
                >
                @if($errors->updateProfileInformation->has('email'))
                    <p class="mt-1 text-xs text-red-500">{{ $errors->updateProfileInformation->first('email') }}</p>
                @endif
            </div>

            <div class="flex items-center gap-4">
                <button type="submit" class="bg-accent hover:bg-blue-500 text-white px-6 py-2 rounded-lg font-bold text-sm transition duration-150 shadow-sm">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <!-- Ubah Password -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-xl font-bold text-primary">Ubah Password</h3>
            <p class="text-sm text-gray-500 mt-1">Pastikan akun Anda menggunakan password yang panjang dan acak untuk tetap aman.</p>
        </div>

        <form method="post" action="{{ route('password.update') }}" class="p-6 space-y-6">
            @csrf
            @method('put')

            @if (session('status') === 'password-updated')
                <div class="bg-green-100 border-l-4 border-success p-4 text-green-700 text-sm rounded-r-lg shadow-sm flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Password berhasil diperbarui.
                </div>
            @endif

            <div>
                <label for="current_password" class="block text-xs font-bold text-gray-500 uppercase mb-1">Password Saat Ini</label>
                <input id="current_password" name="current_password" type="password" class="w-full rounded-lg border-gray-200 focus:border-accent focus:ring-accent text-sm" autocomplete="current-password" required>
                @if($errors->updatePassword->has('current_password'))
                    <p class="mt-1 text-xs text-red-500">{{ $errors->updatePassword->first('current_password') }}</p>
                @endif
            </div>

            <div>
                <label for="password" class="block text-xs font-bold text-gray-500 uppercase mb-1">Password Baru</label>
                <input id="password" name="password" type="password" class="w-full rounded-lg border-gray-200 focus:border-accent focus:ring-accent text-sm" autocomplete="new-password" required>
                @if($errors->updatePassword->has('password'))
                    <p class="mt-1 text-xs text-red-500">{{ $errors->updatePassword->first('password') }}</p>
                @endif
            </div>

            <div>
                <label for="password_confirmation" class="block text-xs font-bold text-gray-500 uppercase mb-1">Konfirmasi Password Baru</label>
                <input id="password_confirmation" name="password_confirmation" type="password" class="w-full rounded-lg border-gray-200 focus:border-accent focus:ring-accent text-sm" autocomplete="new-password" required>
                @if($errors->updatePassword->has('password_confirmation'))
                    <p class="mt-1 text-xs text-red-500">{{ $errors->updatePassword->first('password_confirmation') }}</p>
                @endif
            </div>

            <div class="flex items-center gap-4">
                <button type="submit" class="bg-accent hover:bg-blue-500 text-white px-6 py-2 rounded-lg font-bold text-sm transition duration-150 shadow-sm">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
