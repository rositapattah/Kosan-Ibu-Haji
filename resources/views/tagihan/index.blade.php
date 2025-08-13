@extends('templates.user')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Daftar Tagihan Anda</h2>

    {{-- Alert Messages --}}
    @foreach (['success' => 'bg-green-100 text-green-700 border-green-300', 'error' => 'bg-red-100 text-red-700 border-red-300', 'info' => 'bg-blue-100 text-blue-700 border-blue-300'] as $key => $classes)
        @if (session($key))
            <div class="mb-4 border {{ $classes }} rounded-lg p-4 flex items-center justify-between">
                <span>{{ session($key) }}</span>
                <button type="button" class="text-gray-500 hover:text-gray-700" onclick="this.parentElement.remove()">✕</button>
            </div>
        @endif
    @endforeach

    @if ($tagihan->isEmpty())
        <div class="text-center bg-blue-50 text-blue-700 border border-blue-200 p-6 rounded-lg">
            Anda belum memiliki tagihan.
        </div>
    @else
        <div class="overflow-x-auto bg-white rounded-xl shadow-lg">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gradient-to-r from-pink-500 to-indigo-500 text-white">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Bulan Tagih</th>
                        <th class="px-4 py-3">Jumlah Tagihan</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Tanggal Dibuat</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($tagihan as $item)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3">{{ \Carbon\Carbon::parse($item->bulan_tagih)->translatedFormat('F Y') }}</td>
                            <td class="px-4 py-3 font-semibold">Rp {{ number_format($item->jumlah_tagihan, 0, ',', '.') }}</td>
                            <td class="px-4 py-3">
                                @if ($item->status == 'belum bayar')
                                    <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-700 font-medium">Belum Bayar</span>
                                @else
                                    <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700 font-medium">Lunas</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">{{ $item->created_at->translatedFormat('d M Y H:i') }}</td>
                            <td class="px-4 py-3">
                                @if ($item->status == 'belum bayar')
                                    <a href="{{ route('tagihan.checkout', $item->id) }}" class="inline-flex items-center px-3 py-1.5 rounded-lg bg-green-500 text-white hover:bg-green-600 text-xs font-medium shadow">
                                        💳 Bayar Sekarang
                                    </a>
                                @else
                                    @php
                                        $pembayaran = $item->pembayaran()->latest()->first();
                                    @endphp
                                    @if ($pembayaran)
                                        <a href="{{ route('tagihan.resi', $pembayaran->id) }}" class="inline-flex items-center px-3 py-1.5 rounded-lg bg-blue-500 text-white hover:bg-blue-600 text-xs font-medium shadow">
                                            🧾 Lihat Resi
                                        </a>
                                    @else
                                        <span class="inline-block px-3 py-1.5 rounded-lg bg-gray-300 text-gray-600 text-xs font-medium">Lunas</span>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
