@extends('templates.admin')

@section('title', 'Manajemen Kamar')

@section('content')
<!-- Statistik Ringkas -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6 max-w-md sm:max-w-full mx-auto sm:mx-0">
    <div class="bg-white shadow rounded-lg p-3 sm:p-5 text-center sm:text-left">
        <p class="text-xs sm:text-sm text-gray-500">Kamar Tersedia</p>
        <p class="text-xl sm:text-2xl font-bold text-green-600">{{ $tersedia ?? 0 }}</p>
    </div>
    <div class="bg-white shadow rounded-lg p-3 sm:p-5 text-center sm:text-left">
        <p class="text-xs sm:text-sm text-gray-500">Kamar Terisi</p>
        <p class="text-xl sm:text-2xl font-bold text-blue-600">{{ $penuh ?? 0 }}</p>
    </div>
    <div class="bg-white shadow rounded-lg p-3 sm:p-5 text-center sm:text-left">
        <p class="text-xs sm:text-sm text-gray-500">Total Kamar</p>
        <p class="text-xl sm:text-2xl font-bold text-gray-800">{{ $total ?? 0 }}</p>
    </div>
</div>

<!-- Header + Tombol -->
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-4 sm:mb-6 gap-3">
    <h1 class="text-lg sm:text-xl font-bold text-gray-800">Manajemen Kamar</h1>
    <a href="{{ route('kamar.create') }}" 
       class="bg-gradient-to-r from-yellow-400 to-pink-400 text-white px-3 py-1.5 sm:px-4 sm:py-2 rounded-lg shadow hover:opacity-90 transition whitespace-nowrap text-sm sm:text-base">
        + Tambah Kamar
    </a>
</div>

<!-- Tabel Kamar (hide on small) -->
<div class="overflow-x-auto bg-white rounded-lg shadow hidden sm:block">
    <table class="min-w-full text-xs sm:text-sm text-left text-gray-600">
        <thead class="bg-gray-100 text-gray-700 uppercase">
            <tr>
                <th class="px-2 sm:px-4 py-2 sm:py-3">No</th>
                <th class="px-2 sm:px-4 py-2 sm:py-3">Nomor Kamar</th>
                <th class="px-2 sm:px-4 py-2 sm:py-3">Status</th>
                <th class="px-2 sm:px-4 py-2 sm:py-3">Penghuni</th>
                <th class="px-2 sm:px-4 py-2 sm:py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($kamars as $index => $kamar)
                <tr class="border-b hover:bg-yellow-50 transition-colors duration-200">
                    <td class="px-2 sm:px-4 py-2 sm:py-3">{{ $loop->iteration }}</td>
                    <td class="px-2 sm:px-4 py-2 sm:py-3">{{ $kamar->nomor_kamar }}</td>
                    <td class="px-2 sm:px-4 py-2 sm:py-3">
                        @if ($kamar->status_kamar == 'tersedia')
                            <span class="px-2 py-0.5 text-[10px] sm:text-xs bg-green-100 text-green-700 rounded-full">Tersedia</span>
                        @elseif ($kamar->status_kamar == 'penuh')
                            <span class="px-2 py-0.5 text-[10px] sm:text-xs bg-blue-100 text-blue-700 rounded-full">Terisi</span>
                        @else
                            <span class="px-2 py-0.5 text-[10px] sm:text-xs bg-yellow-100 text-yellow-700 rounded-full">Maintenance</span>
                        @endif
                    </td>
                    <td class="px-2 sm:px-4 py-2 sm:py-3">{{ $kamar->user->name ?? '-' }}</td>
                    <td class="px-2 sm:px-4 py-2 sm:py-3 text-center">
                        <div class="flex justify-center gap-1 sm:gap-2 flex-wrap sm:flex-nowrap">
                            <a href="{{ route('kamar.edit', $kamar->id) }}" 
                               class="px-2 sm:px-3 py-1 text-xs sm:text-sm bg-blue-500 text-white rounded hover:bg-blue-600 transition whitespace-nowrap">
                                Edit
                            </a>
                            <form action="{{ route('kamar.destroy', $kamar->id) }}" method="POST" class="inline-block form-delete">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                    class="w-full sm:w-auto px-2 sm:px-3 py-1 text-xs sm:text-sm bg-red-500 text-white rounded hover:bg-red-600 transition whitespace-nowrap">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="px-4 py-3 text-center text-gray-500 text-sm">Tidak ada data kamar</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Card view for mobile (only small screens) -->
<div class="space-y-3 sm:hidden mt-4">
    @forelse ($kamars as $kamar)
    <div class="bg-white rounded-lg shadow p-3 max-w-md mx-auto">
        <div class="flex justify-between items-center mb-1">
            <h4 class="font-semibold text-gray-800 text-sm">{{ $kamar->nomor_kamar }}</h4>
            @if ($kamar->status_kamar == 'tersedia')
                <span class="px-2 py-0.5 text-[10px] bg-green-100 text-green-700 rounded-full whitespace-nowrap">Tersedia</span>
            @elseif ($kamar->status_kamar == 'penuh')
                <span class="px-2 py-0.5 text-[10px] bg-blue-100 text-blue-700 rounded-full whitespace-nowrap">Terisi</span>
            @else
                <span class="px-2 py-0.5 text-[10px] bg-yellow-100 text-yellow-700 rounded-full whitespace-nowrap">Maintenance</span>
            @endif
        </div>
        <div class="text-xs text-gray-600 mb-1">
            Penghuni: {{ $kamar->user->name ?? '-' }}
        </div>
        <div class="flex gap-2">
            <a href="{{ route('kamar.edit', $kamar->id) }}" 
               class="flex-1 text-center py-1 text-xs bg-blue-500 text-white rounded hover:bg-blue-600 transition whitespace-nowrap">
                Edit
            </a>
            <form action="{{ route('kamar.destroy', $kamar->id) }}" method="POST" class="flex-1 form-delete">
                @csrf
                @method('DELETE')
                <button type="submit" 
                    class="w-full py-1 text-xs bg-red-500 text-white rounded hover:bg-red-600 transition whitespace-nowrap">
                    Hapus
                </button>
            </form>
        </div>
    </div>
    @empty
    <div class="text-center text-sm text-gray-500">Tidak ada data kamar</div>
    @endforelse
</div>

<!-- Pagination -->
<div class="mt-4">
    {{ $kamars->links() }}
</div>

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('form.form-delete').forEach(form => {
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                const formElement = event.target;
                Swal.fire({
                    title: 'Konfirmasi Hapus',
                    text: 'Apakah Anda yakin ingin menghapus kamar ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        formElement.submit();
                    }
                });
            });
        });
    });
</script>
@endsection
