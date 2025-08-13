@extends('templates.admin')

@section('title', 'Detail Laporan')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        {{-- Header --}}
        <div class="px-6 py-4 border-b border-red-500">
            <h2 class="text-center text-lg font-bold text-gray-800">Detail Laporan</h2>
        </div>

        {{-- Body --}}
        <div class="p-6">
            {{-- Gambar --}}
            <div class="flex justify-center mb-6">
                <img src="{{ asset('/storage/'. $laporan->media) }}" 
                     alt="Gambar Laporan" 
                     class="max-w-[200px] rounded-lg shadow">
            </div>

            {{-- Form --}}
            <form action="{{ route('laporan.update', $laporan) }}" 
                  method="POST" 
                  enctype="multipart/form-data" 
                  onsubmit="return stripFormatting(this)"
                  class="space-y-4">
                @csrf
                @method('PUT')

                {{-- Keterangan --}}
                <div>
                    <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan</label>
                    <input type="text" name="keterangan" id="keterangan" 
                           value="{{ $laporan->keterangan }}" 
                           disabled
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                </div>

                {{-- Tanggal Laporan --}}
                <div>
                    <label for="tanggal_laporan" class="block text-sm font-medium text-gray-700">Tanggal Laporan</label>
                    <input type="text" name="tanggal_laporan" id="tanggal_laporan" 
                           value="{{ $laporan->tanggal_laporan }}" 
                           disabled
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                </div>

                {{-- Status --}}
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status Laporan</label>
                    <select name="status" id="status" 
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                        <option value="diproses" {{ $laporan->status == 'diproses' ? 'selected' : '' }}>Dalam Proses</option>
                        <option value="selesai" {{ $laporan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>

                {{-- Buttons --}}
                <div class="space-y-2">
                    <button type="submit" 
                            class="w-full bg-green-500 text-white py-2 px-4 rounded-md hover:bg-green-600 focus:outline-none">
                        Simpan
                    </button>
                    <button type="reset" 
                            class="w-full bg-red-500 text-white py-2 px-4 rounded-md hover:bg-red-600 focus:outline-none">
                        Reset
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
