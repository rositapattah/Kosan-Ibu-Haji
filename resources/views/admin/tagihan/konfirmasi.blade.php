@extends('templates.admin')

@section('title', 'Tagihan')

@section('content')
<div class="max-w-xl mx-auto mt-6 px-4 sm:px-0">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-4 sm:px-6 py-4 border-b border-gray-200 text-center font-bold text-lg sm:text-xl text-gray-800">
            @if($tagihan->status == 'belum bayar')
                Konfirmasi Pembayaran Tagihan
            @else
                Detail Tagihan
            @endif
        </div>
        <div class="p-4 sm:p-6">
            <table class="w-full text-sm sm:text-base">
                <tr>
                    <th class="text-left py-2 w-32 sm:w-40 text-gray-600">Nama</th>
                    <td class="py-2 text-gray-800 break-words">{{ $tagihan->user->name }}</td>
                </tr>
                <tr>
                    <th class="text-left py-2 text-gray-600">Bulan Tagih</th>
                    <td class="py-2 text-gray-800">{{ \Carbon\Carbon::parse($tagihan->bulan_tagih)->format('F Y') }}</td>
                </tr>
                <tr>
                    <th class="text-left py-2 text-gray-600">Jumlah Tagihan</th>
                    <td class="py-2 text-gray-800">Rp {{ number_format($tagihan->jumlah_tagihan, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <th class="text-left py-2 text-gray-600">Status</th>
                    <td class="py-2">
                        @if($tagihan->status == 'lunas')
                            <span class="px-3 py-1 text-xs sm:text-sm font-medium text-green-700 bg-green-100 rounded-full">
                                Lunas
                            </span>
                        @else
                            <span class="px-3 py-1 text-xs sm:text-sm font-medium text-yellow-700 bg-yellow-100 rounded-full">
                                Belum Bayar
                            </span>
                        @endif
                    </td>
                </tr>
            </table>

            @if($tagihan->status != 'lunas')
                <form id="formKonfirmasi" action="{{ route('tagihan.konfirmasi_manual', $tagihan->id) }}" method="POST" class="mt-5 flex flex-col sm:flex-row items-center gap-3">
                    @csrf
                    <button type="button" id="btnKonfirmasi" 
                        class="w-full sm:w-auto px-5 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition">
                        Konfirmasi Pembayaran Manual
                    </button>
                    <a href="{{ route('tagihan.index') }}" 
                        class="w-full sm:w-auto text-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                        Kembali
                    </a>
                </form>
            @else
                <a href="{{ route('tagihan.index') }}" 
                    class="mt-5 inline-block w-full sm:w-auto px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition text-center">
                    Kembali
                </a>
            @endif
        </div>
    </div>
</div>

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('btnKonfirmasi')?.addEventListener('click', function () {
    Swal.fire({
        title: 'Konfirmasi Pembayaran',
        text: 'Apakah Anda yakin ingin melakukan pembayaran manual untuk tagihan ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#16A34A',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Konfirmasi!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('formKonfirmasi').submit();
        }
    });
});
</script>
@endsection
