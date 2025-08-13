@extends('templates.admin')

@section('content')
<div class="max-w-6xl mx-auto mt-4 px-2 sm:px-0">

    {{-- Statistik Tagihan --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6 max-w-md sm:max-w-full mx-auto sm:mx-0">
        <div class="bg-white rounded-xl shadow-md p-3 sm:p-4 text-center sm:text-left">
            <div class="text-xs sm:text-sm text-gray-500">Sudah Dibayar</div>
            <div class="text-xl sm:text-2xl font-bold text-green-600">{{ $sudahDibayar ?? 0 }}</div>
        </div>
        <div class="bg-white rounded-xl shadow-md p-3 sm:p-4 text-center sm:text-left">
            <div class="text-xs sm:text-sm text-gray-500">Belum Dibayar</div>
            <div class="text-xl sm:text-2xl font-bold text-red-600">{{ $belumDibayar ?? 0 }}</div>
        </div>
        <div class="bg-white rounded-xl shadow-md p-3 sm:p-4 text-center sm:text-left">
            <div class="text-xs sm:text-sm text-gray-500">Total Tagihan</div>
            <div class="text-xl sm:text-2xl font-bold text-gray-800">{{ $total ?? 0 }}</div>
        </div>
    </div>

    {{-- Tabel Tagihan (hidden sm:block) --}}
    <div class="bg-white rounded-xl shadow-lg overflow-hidden hidden sm:block">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-bold text-center text-gray-800">Data Tagihan</h2>
        </div>

        <div class="p-4 sm:p-6 overflow-x-auto">
            <table class="min-w-full text-xs sm:text-sm text-center border border-gray-200">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-2 sm:px-4 py-1 sm:py-2 border">No</th>
                        <th class="px-2 sm:px-4 py-1 sm:py-2 border">Nama</th>
                        <th class="px-2 sm:px-4 py-1 sm:py-2 border">Tanggal</th>
                        <th class="px-2 sm:px-4 py-1 sm:py-2 border">Jumlah</th>
                        <th class="px-2 sm:px-4 py-1 sm:py-2 border">Status</th>
                        <th class="px-2 sm:px-4 py-1 sm:py-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600">
                    @foreach ($tagihan as $data)
                        <tr class="hover:bg-gray-50">
                            <td class="px-2 sm:px-4 py-1 sm:py-2 border">{{ $loop->iteration }}</td>
                            <td class="px-2 sm:px-4 py-1 sm:py-2 border">{{ optional($data->user)->name ?? '-' }}</td>
                            <td class="px-2 sm:px-4 py-1 sm:py-2 border">{{ \Carbon\Carbon::parse($data->bulan_tagih)->format('F Y') }}</td>
                            <td class="px-2 sm:px-4 py-1 sm:py-2 border">{{ $data->jumlah_tagihan }}</td>
                            <td class="px-2 sm:px-4 py-1 sm:py-2 border">
                                @if($data->status == 'belum bayar')
                                    <span class="px-2 sm:px-3 py-0.5 text-xs font-medium text-red-700 bg-red-100 rounded-full">
                                        Belum Bayar
                                    </span>
                                @else
                                    <span class="px-2 sm:px-3 py-0.5 text-xs font-medium text-green-700 bg-green-100 rounded-full">
                                        Sudah Bayar
                                    </span>
                                @endif
                            </td>
                            <td class="px-2 sm:px-4 py-1 sm:py-2 border">
                                @if($data->status == 'belum bayar')
                                    <form action="{{ route('tagihan.bayar_manual', $data->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="px-3 py-1 text-xs sm:text-sm text-white bg-blue-500 rounded-md hover:bg-blue-600 transition whitespace-nowrap">
                                            Bayar Manual
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('tagihan.bayar_manual', $data->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="px-3 py-1 text-xs sm:text-sm text-white bg-green-500 rounded-md hover:bg-green-600 transition whitespace-nowrap">
                                            Detail Bayar
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Card List Tagihan for mobile (sm:hidden) --}}
    <div class="space-y-4 sm:hidden mt-4 max-w-md mx-auto">
        @foreach ($tagihan as $data)
            <div class="bg-white rounded-xl shadow-md p-4">
                <div class="flex justify-between items-center mb-1">
                    <div class="font-semibold text-gray-800 text-sm">{{ optional($data->user)->name ?? '-' }}</div>
                    <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($data->bulan_tagih)->format('F Y') }}</div>
                </div>
                <div class="text-gray-600 mb-2">
                    Jumlah: <span class="font-medium">{{ $data->jumlah_tagihan }}</span>
                </div>
                <div class="mb-3">
                    @if($data->status == 'belum bayar')
                        <span class="px-3 py-1 text-xs font-medium text-red-700 bg-red-100 rounded-full inline-block">
                            Belum Bayar
                        </span>
                    @else
                        <span class="px-3 py-1 text-xs font-medium text-green-700 bg-green-100 rounded-full inline-block">
                            Sudah Bayar
                        </span>
                    @endif
                </div>
                <form action="{{ route('tagihan.bayar_manual', $data->id) }}" method="POST" class="inline-block w-full">
                    @csrf
                    <button type="submit" 
                        class="w-full py-2 text-sm text-white rounded-md transition
                        @if($data->status == 'belum bayar') bg-blue-500 hover:bg-blue-600 @else @endif
                        ">
                        @if($data->status == 'belum bayar')
                            Bayar Manual
                        @else
                            Detail Bayar
                        @endif
                    </button>
                </form>
            </div>
        @endforeach
    </div>
</div>
@endsection
