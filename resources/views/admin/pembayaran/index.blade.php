@extends('templates.admin')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-6">

    {{-- Card Ringkasan Pembayaran --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6 max-w-md sm:max-w-full mx-auto sm:mx-0">
        <div class="bg-green-100 border-l-4 border-green-500 p-3 sm:p-4 rounded shadow text-center sm:text-left">
            <div class="text-xs sm:text-sm text-gray-500">Pembayaran Berhasil</div>
            <div class="text-xl sm:text-2xl font-bold text-green-700">{{ $berhasil }}</div>
        </div>
        <div class="bg-yellow-100 border-l-4 border-yellow-500 p-3 sm:p-4 rounded shadow text-center sm:text-left">
            <div class="text-xs sm:text-sm text-gray-500">Pembayaran Belum</div>
            <div class="text-xl sm:text-2xl font-bold text-yellow-700">{{ $belum }}</div>
        </div>
        <div class="bg-blue-100 border-l-4 border-blue-500 p-3 sm:p-4 rounded shadow text-center sm:text-left">
            <div class="text-xs sm:text-sm text-gray-500">Total Tagihan</div>
            <div class="text-xl sm:text-2xl font-bold text-blue-700">{{ $total }}</div>
        </div>
    </div>

    {{-- Tabel Pembayaran (hidden sm:block) --}}
    <div class="bg-white shadow-md rounded-lg overflow-hidden hidden sm:block">
        <div class="text-center font-bold text-lg border-b-2 border-red-500 py-3">
            Data Pembayaran
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto text-center text-xs sm:text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-2 sm:px-4 py-2">No</th>
                        <th class="px-2 sm:px-4 py-2">Nama Penghuni</th>
                        <th class="px-2 sm:px-4 py-2">Tanggal</th>
                        <th class="px-2 sm:px-4 py-2">Total Harga</th>
                        <th class="px-2 sm:px-4 py-2">Metode Pembayaran</th>
                        <th class="px-2 sm:px-4 py-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pembayaran as $data)
                        <tr class="hover:bg-gray-50">
                            <td class="px-2 sm:px-4 py-1 sm:py-2">{{ $loop->iteration }}</td>
                            <td class="px-2 sm:px-4 py-1 sm:py-2 break-words">{{ $data->user->name }}</td>
                            <td class="px-2 sm:px-4 py-1 sm:py-2">{{ \Carbon\Carbon::parse($data->tanggal_bayar)->format('F Y') }}</td>
                            <td class="px-2 sm:px-4 py-1 sm:py-2">{{ $data->total_harga }}</td>
                            <td class="px-2 sm:px-4 py-1 sm:py-2">{{ $data->metode_pembayaran }}</td>
                            <td class="px-2 sm:px-4 py-1 sm:py-2 capitalize">{{ $data->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Card List Pembayaran untuk mobile (sm:hidden) --}}
    <div class="space-y-4 sm:hidden mt-4 max-w-md mx-auto">
        @foreach ($pembayaran as $data)
            <div class="bg-white rounded-lg shadow-md p-4">
                <div class="flex justify-between items-center mb-1">
                    <div class="font-semibold text-gray-800 text-sm break-words">{{ $data->user->name }}</div>
                    <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($data->tanggal_bayar)->format('F Y') }}</div>
                </div>
                <div class="text-gray-600 mb-1">Total Harga: <span class="font-medium">{{ $data->total_harga }}</span></div>
                <div class="text-gray-600 mb-2">Metode: <span class="font-medium">{{ $data->metode_pembayaran }}</span></div>
                <div>
                    <span class="px-3 py-1 text-xs font-medium rounded-full
                        {{ $data->status === 'berhasil' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                        {{ ucfirst($data->status) }}
                    </span>
                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection
