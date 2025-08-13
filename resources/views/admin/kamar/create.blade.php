{{-- resources/views/kamar/create.blade.php --}}
@extends('templates.admin')

@section('content')
<div class="p-6">
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
            🏠 Tambah Kamar
        </h2>

        {{-- Form create --}}
        <form action="{{ route('kamar.store') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Nomor Kamar --}}
            <div>
                <label for="nomor_kamar" class="block text-sm font-semibold text-gray-700 mb-1">
                    Nomor Kamar
                </label>
                <input type="text" name="nomor_kamar" id="nomor_kamar"
                       class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 text-gray-700 shadow-sm focus:border-indigo-400 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition"
                       placeholder="Contoh: 101"
                       required>
            </div>

            {{--  --}}

            {{-- Status --}}
            <div>
                <label for="status" class="block text-sm font-semibold text-gray-700 mb-1">
                    Status
                </label>
                <select name="status_kamar" id="status"
                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 text-gray-700 shadow-sm focus:border-indigo-400 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition">
                    <option value="tersedia">Tersedia</option>
                    <option value="penuh">Terisi</option>
                </select>
            </div>

            {{-- Tombol --}}
            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('kamar.index') }}"
                   class="px-4 py-2 bg-gray-200 rounded-lg text-gray-700 hover:bg-gray-300 transition">
                    Batal
                </a>
                <button type="submit"
                        class="px-5 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 focus:ring focus:ring-indigo-200 transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
