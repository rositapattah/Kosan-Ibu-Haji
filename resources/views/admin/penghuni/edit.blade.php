{{-- resources/views/admin/penghuni/edit.blade.php --}}
@extends('templates.admin')

@section('title', 'Edit Penghuni')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Edit Penghuni</h1>

    <div class="bg-white/70 backdrop-blur-sm p-6 rounded-xl shadow-md max-w-2xl">
        <form action="{{ route('penghuni.update', $penghuni->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Nama --}}
            <div class="mb-4">
                <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" id="nama" 
                    value="{{ old('name', $penghuni->name) }}"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Masukkan nama penghuni" required>
            </div>

            {{-- Nomor Telepon --}}
            <div class="mb-4">
                <label for="telepon" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                <input type="text" name="no_hp" id="telepon" 
                    value="{{ old('no_hp', $penghuni->no_hp) }}"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="08xxxxxxxxxx" required>
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" id="email" 
                    value="{{ old('email', $penghuni->email) }}"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="email@example.com">
            </div>

            {{-- Kamar --}}
            <div class="mb-4">
                <label for="kamar_id" class="block text-sm font-medium text-gray-700 mb-1">Kamar</label>
                <select name="kamar_id" id="kamar_id" 
                    class="block w-full border border-gray-300 rounded-md shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                    @foreach ($kamars as $kamar)
                        <option value="{{ $kamar->id }}" 
                            {{ old('kamar_id', $penghuni->kamar_id) == $kamar->id ? 'selected' : '' }}>
                            {{ $kamar->nomor_kamar }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Password --}}
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password (Kosongkan jika tidak diubah)</label>
                <input type="password" name="password" id="password" 
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            {{-- Password Confirmation --}}
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" 
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            {{-- Tanggal Masuk --}}
            <div class="mb-4">
                <label for="tanggal_masuk" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Masuk</label>
                <input type="date" name="tanggal_masuk" id="tanggal_masuk"
                    value="{{ old('tanggal_masuk', $penghuni->tanggal_masuk ? $penghuni->tanggal_masuk->format('Y-m-d') : '') }}"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
            </div>

            {{-- Tombol --}}
            <div class="flex items-center gap-3">
                <button type="submit" 
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Update
                </button>
                <a href="{{ route('penghuni.index') }}" 
                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
