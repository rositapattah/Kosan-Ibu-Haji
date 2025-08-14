@extends('templates.user')

@section('title','Dashboard Penghuni')

@section('content')
<div class="space-y-6">
  {{-- Top cards --}}
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
    {{-- Tagihan --}}
    <div class="bg-white/90 rounded-xl shadow-soft p-4 sm:p-6 flex flex-col items-center justify-center">
      <div class="w-full flex items-start justify-between">
        <h3 class="font-semibold text-gray-700 text-sm sm:text-base">Tagihan</h3>
        <div class="text-xs sm:text-sm text-gray-400">💳</div>
      </div>

      <div class="mt-4 text-red-500 text-2xl sm:text-3xl font-extrabold">
        Rp {{ number_format($tagihanSummary['totalBelum'] ?? 0,0,',','.') }}
      </div>
      <div class="text-xs text-gray-400 mt-1">Total Belum Dibayar</div>

      <a href="{{ route('tagihan.index') }}" class="mt-4 sm:mt-6 w-full inline-flex items-center justify-center gap-2 px-4 py-2 sm:py-3 rounded-lg text-white bg-gradient-to-r from-pink-500 to-indigo-500 shadow hover:opacity-95 text-sm sm:text-base">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 10h18M7 6h10M7 14h10M7 18h10" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
        Bayar Sekarang
      </a>
    </div>

    {{-- Laporan --}}
    <div class="bg-white/90 rounded-xl shadow-soft p-4 sm:p-6 flex flex-col items-center justify-center">
      <div class="w-full flex items-start justify-between">
        <h3 class="font-semibold text-gray-700 text-sm sm:text-base">Laporan</h3>
        <div class="text-xs sm:text-sm text-gray-400">⚠️</div>
      </div>

      <div class="mt-4 text-indigo-500 text-2xl sm:text-3xl font-extrabold">
        {{ $laporanCount ?? 0 }}
      </div>
      <div class="text-xs text-gray-400 mt-1">Jumlah Laporan</div>

      <a href="{{ route('laporan.index') }}"
        class="mt-4 sm:mt-6 w-full inline-flex items-center justify-center gap-2 px-4 py-2 sm:py-3 rounded-lg text-white bg-gradient-to-r from-yellow-500 to-red-500 shadow hover:opacity-95 text-sm sm:text-base">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path d="M12 20h9" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M12 4h9" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M4 9h16" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M4 15h16" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Laporkan Kerusakan
      </a>
    </div>
  </div>

  {{-- Detail Tagihan --}}
  @php
    $totalBelum = 0;
  @endphp
  @foreach ($tagihanList as $tagihan)
    @if (Str::lower($tagihan->status) === 'belum bayar')
      @php
        $totalBelum += $tagihan->jumlah_tagihan;
      @endphp
    @endif
  @endforeach

  <div class="bg-white/90 rounded-xl shadow-soft p-4 sm:p-6">
    <div class="flex flex-wrap items-center justify-between gap-2 mb-4">
      <h4 class="text-base sm:text-lg font-semibold text-gray-700">Detail Tagihan</h4>
      <div class="text-sm text-gray-400">Rp {{ number_format($totalBelum,0,',','.') }}</div>
    </div>

    <div class="space-y-3">
      @foreach($tagihanList as $item)
        <div class="flex flex-wrap sm:flex-nowrap items-center justify-between gap-3 p-4 rounded-lg bg-white/60 hover:bg-white/70 transition shadow-sm border border-transparent">
          <div class="flex items-center gap-3 sm:gap-4">
            <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600">
              @if(Str::contains(strtolower($item->nama), 'sewa')) 🏠 
              @elseif(Str::contains(strtolower($item->nama), 'listrik')) ⚡ 
              @elseif(Str::contains(strtolower($item->nama), 'air')) 💧 
              @elseif(Str::contains(strtolower($item->nama), 'internet')) 📶 
              @else 💼 @endif
            </div>
            <div>
              <div class="font-medium text-gray-700 text-sm sm:text-base">{{ \Carbon\Carbon::parse($item->bulan_tagih, 'Asia/Jayapura')->translatedFormat('F Y') }}</div>
            </div>
          </div>

          <div class="flex flex-wrap items-center gap-2 sm:gap-4">
            <div class="text-sm font-semibold text-gray-800">Rp {{ number_format($item->jumlah_tagihan,0,',','.') }}</div>

            @if($item->status === 'belum bayar' || Str::lower($item->status) === 'belum bayar')
              <span class="px-2 sm:px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs">Belum Bayar</span>
              <a href="{{ route('tagihan.index', $item->id) }}" class="px-2 sm:px-3 py-1 bg-blue-500 text-white rounded text-xs sm:text-sm">Bayar</a>
            @else
              <span class="px-2 sm:px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs">Lunas</span>
            @endif
          </div>
        </div>
      @endforeach
    </div>
  </div>
</div>
@endsection
