@extends('templates.admin')

@section('title','Manajemen Penghuni')

@section('content')
<div class="space-y-6">

  {{-- Page header --}}
  <div class="flex items-center justify-between flex-wrap gap-4">
    <div>
      <h2 class="text-2xl font-semibold text-gray-800">Manajemen Penghuni</h2>
      <p class="text-sm text-gray-500 mt-1">Kelola data penghuni kos — tambah, edit, atau hapus.</p>
    </div>

    <div class="flex items-center gap-3">
      <a href="{{ route('penghuni.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-500 text-white shadow hover:opacity-95">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path d="M12 5v14M5 12h14" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Tambah Penghuni
      </a>
    </div>
  </div>

  {{-- search / filter card --}}
  <div class="p-4 bg-white/70 backdrop-blur-sm rounded-xl shadow-md">
    <div class="flex flex-col md:flex-row md:items-center md:gap-4">
      <div class="flex-1">
        <label class="sr-only" for="q">Cari penghuni</label>
        <div class="relative">
          <input id="q" type="search" placeholder="Cari penghuni berdasarkan nama, email, atau nomor kamar..." class="w-full rounded-full pl-4 pr-10 py-3 border border-transparent focus:outline-none focus:ring-2 focus:ring-amber-200 bg-white/80 text-sm">
          <svg class="w-4 h-4 absolute right-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M21 21l-4.35-4.35" stroke-width="1.5"/>
          </svg>
        </div>
      </div>
    </div>
  </div>

  {{-- Table + Card view --}}
  <div class="p-4 bg-white/70 backdrop-blur-sm rounded-xl shadow-md">
    <div class="mb-4 flex items-center justify-between flex-wrap gap-2">
      <h3 class="text-lg font-semibold text-gray-700">Daftar Penghuni <span class="text-sm text-gray-400">({{ $penghunis->count() }}/{{ $penghunis->total() }})</span></h3>
      <div class="text-sm text-gray-500">Menampilkan {{ $penghunis->firstItem() }}–{{ $penghunis->lastItem() }} dari {{ $penghunis->total() }}</div>
    </div>

    {{-- Table view for desktop --}}
    <div class="overflow-x-auto hidden sm:block">
      <table class="w-full min-w-[720px] text-left text-sm sm:text-xs">
        <thead class="text-xs text-gray-500 uppercase">
          <tr>
            <th class="px-4 sm:px-2 py-3">Nama</th>
            <th class="px-4 sm:px-2 py-3">Email</th>
            <th class="px-4 sm:px-2 py-3">No. Kamar</th>
            <th class="px-4 sm:px-2 py-3">Tanggal Masuk</th>
            <th class="px-4 sm:px-2 py-3">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y">
          @forelse ($penghunis as $p)
            <tr class="bg-white/40">
              <td class="px-4 sm:px-2 py-3 sm:py-2 font-medium text-gray-700">{{ $p->name }}</td>
              <td class="px-4 sm:px-2 py-3 sm:py-2 text-gray-500">{{ $p->email }}</td>
              <td class="px-4 sm:px-2 py-3 sm:py-2">
                <span class="inline-block px-3 sm:px-2 py-1 rounded-full bg-indigo-100 text-indigo-700 text-xs font-semibold">
                  {{ $p->kamar->nomor_kamar ?? '-' }}
                </span>
              </td>
              <td class="px-4 sm:px-2 py-3 sm:py-2 text-gray-600">
                {{ \Carbon\Carbon::parse($p->tanggal_masuk)->format('d/m/Y') }}
              </td>
              <td class="px-4 sm:px-2 py-3 sm:py-2">
                <div class="flex items-center gap-2">
                  <a href="{{ route('penghuni.edit', $p->id) }}" class="flex-1 flex items-center justify-center gap-1 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-xs font-semibold transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M15.232 5.232l3.536 3.536M9 11l6-6 3 3-6 6H9v-3z" />
                      <path d="M4 20h16" />
                    </svg>
                    Edit
                  </a>

                  <form action="{{ route('penghuni.destroy', $p->id) }}" method="post" class="flex-1 form-delete">
                    @csrf
                    @method('delete')
                    <button type="submit" class="w-full flex items-center justify-center gap-1 py-1 bg-red-600 hover:bg-red-700 text-white rounded-md text-xs font-semibold transition">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 18L18 6M6 6l12 12" />
                      </svg>
                      Hapus
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="px-4 py-4 text-center text-gray-500">Tidak ada data penghuni</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- Card view for mobile --}}
    <div class="space-y-4 sm:hidden">
      @forelse ($penghunis as $p)
        <div class="bg-white rounded-lg shadow p-4 space-y-2">
          <div class="flex justify-between items-center">
            <h4 class="font-semibold text-gray-800 text-sm">{{ $p->name }}</h4>
            <span class="px-2 py-1 text-xs rounded-full bg-indigo-100 text-indigo-700">{{ $p->kamar->nomor_kamar ?? '-' }}</span>
          </div>
          <div class="text-xs text-gray-500">{{ $p->email }}</div>
          <div class="text-xs text-gray-600">Masuk: {{ \Carbon\Carbon::parse($p->tanggal_masuk)->format('d/m/Y') }}</div>
          <div class="flex gap-2 pt-2">
            <a href="{{ route('penghuni.edit', $p->id) }}" class="flex-1 flex items-center justify-center gap-1 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-xs font-semibold transition">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M15.232 5.232l3.536 3.536M9 11l6-6 3 3-6 6H9v-3z" />
                <path d="M4 20h16" />
              </svg>
              Edit
            </a>

            <form action="{{ route('penghuni.destroy', $p->id) }}" method="post" class="flex-1 form-delete">
              @csrf
              @method('delete')
              <button type="submit" class="w-full flex items-center justify-center gap-1 py-1 bg-red-600 hover:bg-red-700 text-white rounded-md text-xs font-semibold transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M6 18L18 6M6 6l12 12" />
                </svg>
                Hapus
              </button>
            </form>
          </div>
        </div>
      @empty
        <div class="text-center text-sm text-gray-500">Tidak ada data penghuni</div>
      @endforelse
    </div>

    {{-- pagination --}}
    @if ($penghunis->hasPages())
      <div class="mt-4 flex items-center justify-between flex-wrap gap-2 text-sm">
        <div class="text-gray-500">
          Menampilkan {{ $penghunis->firstItem() }} sampai {{ $penghunis->lastItem() }} dari {{ $penghunis->total() }} data
        </div>
        <div class="flex items-center gap-1">
          @if ($penghunis->onFirstPage())
            <span class="px-3 py-1 rounded-md border bg-gray-200 text-gray-400">Prev</span>
          @else
            <a href="{{ $penghunis->previousPageUrl() }}" class="px-3 py-1 rounded-md border bg-white/70">Prev</a>
          @endif

          @foreach ($penghunis->getUrlRange(1, $penghunis->lastPage()) as $page => $url)
            @if ($page == $penghunis->currentPage())
              <span class="px-3 py-1 rounded-md border bg-blue-500 text-white">{{ $page }}</span>
            @else
              <a href="{{ $url }}" class="px-3 py-1 rounded-md border bg-white/70">{{ $page }}</a>
            @endif
          @endforeach

          @if ($penghunis->hasMorePages())
            <a href="{{ $penghunis->nextPageUrl() }}" class="px-3 py-1 rounded-md border bg-white/70">Next</a>
          @else
            <span class="px-3 py-1 rounded-md border bg-gray-200 text-gray-400">Next</span>
          @endif
        </div>
      </div>
    @endif
  </div>
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
            text: 'Apakah Anda yakin ingin menghapus penghuni ini?',
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

  
