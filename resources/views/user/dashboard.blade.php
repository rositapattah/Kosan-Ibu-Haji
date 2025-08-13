{{-- resources/views/user/dashboard.blade.php --}}
@extends('templates.user')

@section('title','Dashboard Penghuni')

@section('content')
<div class="space-y-6">
  {{-- Top cards --}}
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Info Kamar --}}
    {{-- <div class="bg-white/90 rounded-xl shadow-soft p-5">
      <div class="flex items-center justify-between">
        <h3 class="font-semibold text-gray-700">Info Kamar</h3>
        <div class="text-sm text-gray-400">🏠</div>
      </div>

      <div class="mt-4 text-sm text-gray-500">Nomor Kamar</div>
      <div class="text-lg font-bold text-gray-800">{{ $kamar->nomor_kamar ?? '-' }}</div>

      <div class="mt-3 text-sm text-gray-500">Tipe</div>
      <div class="text-sm text-gray-700">{{ $kamar->tipe ?? '-' }}</div>

      <div class="mt-3 text-sm text-gray-500">Harga</div>
      <div class="text-green-600 font-semibold">Rp {{ number_format($kamar->harga_sewa ?? 0,0,',','.') }}/bulan</div>

      <div class="mt-4">
        <span class="inline-block px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs">Aktif</span>
      </div>
    </div> --}}

    {{-- Tagihan (center big) --}}
    <div class="bg-white/90 rounded-xl shadow-soft p-6 flex flex-col items-center justify-center">
      <div class="w-full flex items-start justify-between">
        <h3 class="font-semibold text-gray-700">Tagihan</h3>
        <div class="text-sm text-gray-400">💳</div>
      </div>

      <div class="mt-4 text-red-500 text-3xl font-extrabold">
        Rp {{ number_format($tagihanSummary['totalBelum'] ?? 0,0,',','.') }}
      </div>
      <div class="text-xs text-gray-400 mt-1">Total Belum Dibayar</div>

      <a href="{{ route('tagihan.index') }}" class="mt-6 w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-lg text-white bg-gradient-to-r from-pink-500 to-indigo-500 shadow hover:opacity-95">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 10h18M7 6h10M7 14h10M7 18h10" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
        Bayar Sekarang
      </a>
    </div>

    {{-- Laporan --}}
    <div class="bg-white/90 rounded-xl shadow-soft p-5">
      <div class="flex items-center justify-between">
        <h3 class="font-semibold text-gray-700">Laporan</h3>
        <div class="text-sm text-gray-400">⚠️</div>
      </div>

      <p class="mt-4 text-sm text-gray-500">Jumlah laporan</p>
      <div class="text-lg font-bold">{{ $laporanCount ?? 0 }}</div>

      <a href="{{ route('laporan.index') }}" class="mt-5 inline-block px-4 py-2 bg-gray-100 rounded hover:bg-gray-200 text-sm">Laporkan Kerusakan</a>
    </div>
  </div>

  {{-- Detail Tagihan list (large panel) --}}
  <div class="bg-white/90 rounded-xl shadow-soft p-6">
    <div class="flex items-center justify-between mb-4">
      <h4 class="text-lg font-semibold text-gray-700">Detail Tagihan</h4>
      <div class="text-sm text-gray-400">{{ $tagihanList->sum('jumlah_tagihan') ?? 0 }} item</div>
    </div>

    <div class="space-y-3">
      @foreach($tagihanList as $item)
        <div class="flex items-center justify-between gap-4 p-4 rounded-lg bg-white/60 hover:bg-white/70 transition shadow-sm border border-transparent">
          <div class="flex items-center gap-4">
            {{-- icon --}}
            <div class="w-10 h-10 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600">
              @if(Str::contains(strtolower($item->nama), 'sewa')) 🏠 
              @elseif(Str::contains(strtolower($item->nama), 'listrik')) ⚡ 
              @elseif(Str::contains(strtolower($item->nama), 'air')) 💧 
              @elseif(Str::contains(strtolower($item->nama), 'internet')) 📶 
              @else 💼 @endif
            </div>

            <div>
              <div class="font-medium text-gray-700">{{ $item->nama }}</div>
              <div class="text-xs text-gray-500">Jatuh tempo: {{ \Carbon\Carbon::parse($item->jatuh_tempo)->format('d/m/Y') }}</div>
            </div>
          </div>

          <div class="flex items-center gap-4">
            <div class="text-sm font-semibold text-gray-800">Rp {{ number_format($item->jumlah_tagihan,0,',','.') }}</div>

            @if($item->status === 'belum bayar' || Str::lower($item->status) === 'belum bayar')
              <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs">Belum Bayar</span>
              <a href="{{ route('tagihan.index', $item->id) }}" class="px-3 py-1 bg-blue-500 text-white rounded text-sm">Bayar</a>
            @else
              <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs">Lunas</span>
            @endif
          </div>
        </div>
      @endforeach
    </div>
  </div>
</div>
@endsection
