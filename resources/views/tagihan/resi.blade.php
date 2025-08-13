@extends('templates.user')

@section('content')
<div class="max-w-3xl mx-auto py-8 px-4">
    <div class="bg-white shadow-lg rounded-xl overflow-hidden">
        {{-- Header --}}
        <div class="flex items-center justify-between bg-green-500 text-white px-6 py-4">
            <h4 class="text-lg font-bold">Resi Pembayaran</h4>
            <a href="{{ route('tagihan.index') }}" class="px-3 py-1.5 rounded-lg border border-white text-white hover:bg-white hover:text-green-600 transition text-sm font-medium">
                ← Kembali ke Tagihan
            </a>
        </div>

        {{-- Body --}}
        <div class="p-6">
            <p class="mb-2">Halo <strong>{{ Auth::user()->name }}</strong>,</p>
            <p class="mb-6">Pembayaran Anda telah berhasil. Berikut detail resi pembayaran Anda:</p>

            {{-- Detail List --}}
            <div class="divide-y divide-gray-200 border border-gray-200 rounded-lg mb-6">
                <div class="flex justify-between px-4 py-3">
                    <span class="font-medium text-gray-700">Bulan Tagih</span>
                    <span>{{ \Carbon\Carbon::parse($tagihan->bulan_tagih)->translatedFormat('F Y') }}</span>
                </div>
                <div class="flex justify-between px-4 py-3">
                    <span class="font-medium text-gray-700">Jumlah Tagihan</span>
                    <span class="font-semibold">Rp {{ number_format($tagihan->jumlah_tagihan, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between px-4 py-3">
                    <span class="font-medium text-gray-700">Tanggal Pembayaran</span>
                    <span>{{ \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->format('d-m-Y H:i') }}</span>
                </div>
                <div class="flex justify-between px-4 py-3">
                    <span class="font-medium text-gray-700">Metode Pembayaran</span>
                    <span>{{ ucfirst($pembayaran->metode_pembayaran) }}</span>
                </div>
                <div class="flex justify-between px-4 py-3">
                    <span class="font-medium text-gray-700">Status</span>
                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm font-semibold">LUNAS</span>
                </div>
            </div>

            <p class="text-center text-gray-500 mb-6">Simpan halaman ini sebagai bukti pembayaran Anda.</p>

            {{-- Button --}}
            <div class="text-center">
                <a href="{{ route('tagihan.index') }}" class="inline-flex items-center px-5 py-2.5 rounded-lg bg-blue-500 text-white hover:bg-blue-600 transition font-medium shadow">
                    🏠 Kembali ke Tagihan
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
