@extends('templates.admin')

@section('title','Dashboard Admin')

@section('content')
  <div class="mb-6">
    <h1 class="text-4xl font-extrabold text-purple-700">Dashboard</h1>
    <p class="text-gray-600 mt-1">Selamat datang di Sistem Manajemen Kos Ibu Haji</p>
  </div>
  <!-- Stat cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
  <!-- Total Penghuni -->
  <div class="p-4 bg-white/70 backdrop-blur-sm rounded-xl shadow-md hover:shadow-lg transition-shadow duration-200">
    <div class="flex items-center gap-4">
      <div class="flex-1">
        <div class="text-sm text-gray-500">Total Penghuni</div>
        <div class="mt-2">
          <div class="text-3xl font-extrabold text-gray-800">{{$penghuni}}</div>
          <div class="text-xs text-gray-400 mt-1">keseluruhan</div>
        </div>
      </div>
      <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center text-white shadow-sm">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>
    </div>
  </div>

  <!-- Kamar Tersedia -->
  <div class="p-4 bg-white/70 backdrop-blur-sm rounded-xl shadow-md hover:shadow-lg transition-shadow duration-200">
    <div class="flex items-center justify-between">
      <div>
        <div class="text-sm text-gray-500">Kamar Tersedia</div>
        <div class="mt-2">
          <div class="text-3xl font-extrabold text-gray-800">{{$kamarTersedia}}</div>
          <div class="text-xs text-gray-400">dari {{\App\Models\Kamar::count()}} kamar</div>
        </div>
      </div>
      <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center text-emerald-700 shadow-sm">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path d="M3 21h18V8l-9-5-9 5v13z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M9 21V13h6v8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M9 10h.01M15 10h.01M9 14h.01M15 14h.01" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>
    </div>
  </div>

  <!-- Pembayaran Pending -->
  <div class="p-4 bg-white/70 backdrop-blur-sm rounded-xl shadow-md hover:shadow-lg transition-shadow duration-200">
    <div class="flex items-center justify-between">
      <div>
        <div class="text-sm text-gray-500">Pembayaran Pending</div>
        <div class="mt-2">
          <div class="text-3xl font-extrabold text-gray-800">{{$pembayaranPending}}</div>
          <div class="text-xs text-gray-400">Belum Dibayar</div>
        </div>
      </div>
      <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center text-yellow-700 shadow-sm">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <rect x="2" y="7" width="20" height="10" rx="2" ry="2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M2 11h20" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>
    </div>
  </div>

  <!-- Laporan Kerusakan -->
  <div class="p-4 bg-white/70 backdrop-blur-sm rounded-xl shadow-md hover:shadow-lg transition-shadow duration-200">
    <div class="flex items-center justify-between">
      <div>
        <div class="text-sm text-gray-500">Laporan Kerusakan</div>
        <div class="mt-2">
          <div class="text-3xl font-extrabold text-gray-800">{{$laporanPending}}</div>
          <div class="text-xs text-gray-400">perlu ditangani</div>
        </div>
      </div>
      <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center text-red-600 shadow-sm">
        <!-- Icon alert segitiga -->
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v3.75m0 3.75h.007M10.29 3.86l-8.18 14.14A2 2 0 004 21h16a2 2 0 001.74-3l-8.18-14.14a2 2 0 00-3.46 0z" />
        </svg>
      </div>
    </div>
  </div>
</div>

<!-- List & Aside in two columns -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
  <!-- List kegiatan terbaru -->
  <ul class="space-y-3">
    @forelse ($logs as $log)
      <li class="p-4 bg-gray-50 rounded-lg flex items-start justify-between">
        <div>
          <div class="font-medium">{{ $log->user->name ?? 'Guest' }}</div>
          <div class="text-sm text-gray-500">{{ $log->activity }}</div>
          <div class="text-xs text-gray-400 mt-1">{{ $log->created_at->diffForHumans() }}</div>
        </div>

        {{-- Contoh badge status, bisa disesuaikan --}}
        <div class="text-green-600 text-sm font-medium bg-green-50 px-3 py-1 rounded-full">Selesai</div>
      </li>
    @empty
      <li class="text-gray-500">Belum ada aktivitas terbaru.</li>
    @endforelse
  </ul>


  <!-- Aside (ikon disesuaikan agar mirip card) -->
<aside class="p-4 bg-white/70 backdrop-blur-sm rounded-xl shadow-md">
  <h3 class="text-lg font-semibold mb-4">+ Aksi Cepat</h3>
  <div class="space-y-3">
    <!-- Tambah Penghuni -->
    <button class="w-full text-left p-3 rounded-lg border hover:shadow-sm flex items-center gap-3" type="button" onclick="window.location.href='{{ route('penghuni.create') }}'">
        <div class="relative">
            <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center text-white shadow-sm">
            <!-- User icon mirip contoh -->
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0z" />
                <path d="M12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            </div>
            <!-- tanda plus -->
            <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-white text-blue-500 rounded-full flex items-center justify-center border border-blue-100 shadow-sm">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 5v14M5 12h14" />
            </svg>
            </div>
        </div>
        <div>
            <div class="text-sm font-medium">Tambah Penghuni</div>
            <div class="text-xs text-gray-400">Daftarkan penghuni baru (Maks 2)</div>
        </div>
      </button>


    <!-- Kelola Kamar -->
    <button class="w-full text-left p-3 rounded-lg border hover:shadow-sm flex items-center gap-3" type="button" onclick="window.location.href='{{route('kamar.create')}}'">
      <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center text-emerald-700 shadow-sm">
        <!-- building/room icon -->
        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M3 21h18V8l-9-5-9 5v13z" />
          <path d="M9 21V13h6v8" />
          <path d="M9 10h.01M15 10h.01M9 14h.01M15 14h.01" />
        </svg>
      </div>
      <div>
        <div class="text-sm font-medium">Kelola Kamar</div>
        <div class="text-xs text-gray-400">Tambah, Update, Hpaus kamar</div>
      </div>
    </button>

    <!-- Verifikasi Pembayaran -->
    <button class="w-full text-left p-3 rounded-lg border hover:shadow-sm flex items-center gap-3" onclick="window.location.href='{{route('pembayaran.index')}}'">
      <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center text-yellow-700 shadow-sm">
        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <rect x="3" y="5" width="18" height="14" rx="2" ry="2" />
          <path d="M3 10h18" />
        </svg>
      </div>
      <div>
        <div class="text-sm font-medium">Riwayat Pembayaran</div>
        <div class="text-xs text-gray-400">Lihat riwayat pembayaran</div>
      </div>
    </button>

    <!-- Cek Laporan -->
    <button class="w-full text-left p-3 rounded-lg border hover:shadow-sm flex items-center gap-3" onclick="window.location.href='{{route('laporan.index')}}'">
      <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center text-red-600 shadow-sm">
        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M12 9v3.75m0 3.75h.007" />
          <path d="M10.29 3.86l-8.18 14.14A2 2 0 004 21h16a2 2 0 001.74-3L13.56 3.86a2 2 0 00-3.27 0z" />
        </svg>
      </div>
      <div>
        <div class="text-sm font-medium">Cek Laporan</div>
        <div class="text-xs text-gray-400">Review laporan Penghuni</div>
      </div>
    </button>
  </div>
</aside>

</div>

@endsection