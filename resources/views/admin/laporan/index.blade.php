@extends('templates.admin')

@section('title', 'Laporan')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    {{-- Card Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 max-w-md sm:max-w-full mx-auto sm:mx-0">
        <div class="bg-white shadow rounded-lg p-4 sm:p-5 text-center sm:text-left">
            <p class="text-xs sm:text-sm text-gray-500">Total Laporan</p>
            <p class="text-xl sm:text-2xl font-bold text-gray-800">{{ $laporan->count() }}</p>
        </div>
        <div class="bg-white shadow rounded-lg p-4 sm:p-5 text-center sm:text-left">
            <p class="text-xs sm:text-sm text-green-600">Laporan Selesai</p>
            <p class="text-xl sm:text-2xl font-bold text-green-600">{{ $laporan->where('status', 'selesai')->count() }}</p>
        </div>
        <div class="bg-white shadow rounded-lg p-4 sm:p-5 text-center sm:text-left">
            <p class="text-xs sm:text-sm text-yellow-500">Laporan Proses</p>
            <p class="text-xl sm:text-2xl font-bold text-yellow-500">{{ $laporan->where('status', 'diproses')->count() }}</p>
        </div>
        {{-- Jika mau tambah pending, aktifkan kembali:
        <div class="bg-white shadow rounded-lg p-4 sm:p-5 text-center sm:text-left">
            <p class="text-xs sm:text-sm text-red-500">Laporan Pending</p>
            <p class="text-xl sm:text-2xl font-bold text-red-500">{{ $laporan->where('status', 'Pending')->count() }}</p>
        </div>
        --}}
    </div>

    {{-- Tabel Laporan (hidden on small) --}}
    <div class="bg-white shadow rounded-lg overflow-hidden hidden sm:block">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-bold text-gray-800">Data Laporan</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm text-center">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 font-semibold text-gray-600">No</th>
                        <th class="px-4 py-2 font-semibold text-gray-600">Keterangan</th>
                        <th class="px-4 py-2 font-semibold text-gray-600">Tanggal Laporan</th>
                        <th class="px-4 py-2 font-semibold text-gray-600">Status</th>
                        <th class="px-4 py-2 font-semibold text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($laporan as $data)
                        <tr>
                            <td class="px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2">{{ $data->keterangan }}</td>
                            <td class="px-4 py-2">{{ $data->tanggal_laporan }}</td>
                            <td class="px-4 py-2">
                                @if($data->status === 'selesai')
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                        {{ $data->status }}
                                    </span>
                                @elseif($data->status === 'diproses')
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">
                                        {{ $data->status }}
                                    </span>
                                @else
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                        {{ $data->status }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                <a href="{{ route('laporan.edit', $data->id) }}" 
                                   class="inline-block px-3 py-1 bg-yellow-500 text-white text-xs rounded hover:bg-yellow-600">
                                   Detail
                                </a>
                            </td>                                        
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Card list for mobile (sm:hidden) --}}
    <div class="space-y-4 sm:hidden mt-4 max-w-md mx-auto">
        @foreach ($laporan as $data)
            <div class="bg-white shadow rounded-lg p-4">
                <div class="flex justify-between items-center mb-2">
                    <div class="font-semibold text-gray-800 text-sm truncate">{{ $data->keterangan }}</div>
                    <div class="text-xs text-gray-500">{{ $data->tanggal_laporan }}</div>
                </div>
                <div class="mb-2">
                    @if($data->status === 'selesai')
                        <span class="px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                            {{ $data->status }}
                        </span>
                    @elseif($data->status === 'diproses')
                        <span class="px-2 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">
                            {{ $data->status }}
                        </span>
                    @else
                        <span class="px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                            {{ $data->status }}
                        </span>
                    @endif
                </div>
                <a href="{{ route('laporan.edit', $data->id) }}" 
                   class="inline-block px-3 py-1 bg-yellow-500 text-white text-xs rounded hover:bg-yellow-600">
                   Detail
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection
