@extends('templates.user')

@section('content')
<div class="max-w-3xl mx-auto py-8 px-4">
    <div class="bg-white shadow-lg rounded-xl overflow-hidden">
        {{-- Header --}}
        <div class="flex items-center justify-between bg-blue-600 text-white px-6 py-4">
            <h4 class="text-lg font-bold">Detail Pembayaran Tagihan</h4>
            <a href="{{ route('tagihan.index') }}" class="px-3 py-1.5 rounded-lg border border-white text-white hover:bg-white hover:text-blue-600 transition text-sm font-medium">
                ← Kembali ke Daftar Tagihan
            </a>
        </div>
        {{-- Body --}}
        <div class="p-6">
            {{-- Alerts --}}
            @if (session('error'))
                <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-700 text-sm flex justify-between items-center">
                    <span>{{ session('error') }}</span>
                    <button onclick="this.parentElement.remove()" class="font-bold text-lg">&times;</button>
                </div>
            @endif

            @if (session('info'))
                <div class="mb-4 p-4 rounded-lg bg-blue-100 text-blue-700 text-sm flex justify-between items-center">
                    <span>{{ session('info') }}</span>
                    <button onclick="this.parentElement.remove()" class="font-bold text-lg">&times;</button>
                </div>
            @endif

            {{-- Detail Tagihan --}}
            <h5 class="mb-3 text-lg font-semibold">Tagihan Bulan: 
                <strong class="text-blue-600">{{ \Carbon\Carbon::parse($tagihan->bulan_tagih)->translatedFormat('F Y') }}</strong>
            </h5>
            <p class="mb-2 text-xl">Jumlah Tagihan: 
                <strong class="text-green-600">Rp {{ number_format($tagihan->jumlah_tagihan, 0, ',', '.') }}</strong>
            </p>
            <p class="mb-6">Status Saat Ini: 
                <span class="inline-block px-3 py-1 rounded-full bg-red-100 text-red-700 text-sm font-semibold">Belum Dibayar</span>
            </p>

            <hr class="my-6">

            {{-- Instruksi --}}
            <p class="text-center text-gray-700 leading-relaxed">
                Klik tombol di bawah untuk melanjutkan pembayaran melalui Midtrans.<br>
                Pastikan Anda memiliki koneksi internet yang stabil.
            </p>

            {{-- Pay Button --}}
            <div class="flex justify-center mt-6">
                <button id="pay-button" type="button" class="flex items-center justify-center px-6 py-3 rounded-lg bg-green-500 text-white hover:bg-green-600 transition font-medium shadow-lg text-lg">
                    💳 Bayar Sekarang
                </button>
            </div>

            <p class="text-center text-gray-500 mt-4 text-sm">
                Anda akan diarahkan ke halaman pembayaran Midtrans.
            </p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- Midtrans Snap JS Library --}}
<script type="text/javascript"
  src="https://app.sandbox.midtrans.com/snap/snap.js"
  data-client-key="{{ config('midtrans.client_key') }}"></script>
<script type="text/javascript">
  document.getElementById('pay-button').onclick = function(){
    snap.pay('{{ $snapToken }}', {
      onSuccess: function(result){
        alert("Pembayaran berhasil! Transaksi Anda sedang diproses.");
        console.log(result);
        window.location.href = "{{ route('tagihan.index') }}";
      },
      onPending: function(result){
        alert("Pembayaran tertunda. Silakan selesaikan pembayaran Anda.");
        console.log(result);
        window.location.href = "{{ route('tagihan.index') }}";
      },
      onError: function(result){
        alert("Pembayaran gagal. Mohon coba lagi.");
        console.log(result);
        window.location.href = "{{ route('tagihan.index') }}";
      },
      onClose: function(){
        alert('Anda menutup pop-up tanpa menyelesaikan pembayaran.');
      }
    });
  };
</script>
@endpush
