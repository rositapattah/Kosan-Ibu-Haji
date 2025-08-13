@extends('templates.user')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <h2 class="text-2xl font-bold text-gray-800">Daftar Laporan Kerusakan Anda</h2>
        <a href="{{ route('laporan.create') }}" 
           class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-500 text-white text-sm font-medium rounded-lg shadow hover:shadow-lg hover:from-blue-600 hover:to-indigo-600 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Laporan Baru
        </a>
    </div>

    {{-- Alert success --}}
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 border border-green-300 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    {{-- Empty state --}}
    @if ($laporan->isEmpty())
        <div class="p-6 bg-blue-50 border border-blue-200 rounded-lg text-center text-blue-800">
            Anda belum memiliki laporan kerusakan.<br>Buat laporan pertama Anda sekarang!
        </div>
    @else
        {{-- Cards grid --}}
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($laporan as $item)
                <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden">
                    <div class="p-5">
                        <h5 class="text-lg font-semibold text-gray-800">Laporan #{{ $item->id }}</h5>
                        <p class="text-sm text-gray-500 mb-3">
                            Tanggal: {{ \Carbon\Carbon::parse($item->tanggal_laporan)->format('d F Y') }}
                        </p>
                        <p class="mb-4 text-gray-700"><span class="font-semibold">Keterangan:</span> {{ $item->keterangan }}</p>

                        @if ($item->media)
                            <div class="mb-4">
                                <span class="block text-sm font-semibold text-gray-700">Media:</span>
                                @if (Str::endsWith($item->media, ['.jpg', '.jpeg', '.png', '.gif']))
                                    <img src="{{ asset('storage/' . $item->media) }}" 
                                         alt="Media Laporan" 
                                         class="mt-2 w-full h-40 object-cover rounded-lg border">
                                @elseif (Str::endsWith($item->media, ['.mp4', '.mov']))
                                    <video controls class="mt-2 w-full h-40 object-cover rounded-lg border">
                                        <source src="{{ asset('storage/' . $item->media) }}" type="video/mp4">
                                        Browser Anda tidak mendukung tag video.
                                    </video>
                                @else
                                    <a href="{{ asset('storage/' . $item->media) }}" target="_blank" 
                                       class="text-blue-500 hover:underline mt-2 inline-block">
                                        Lihat Media
                                    </a>
                                @endif
                            </div>
                        @endif

                        {{-- Status badge --}}
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                            {{ $item->status == 'diproses' 
                                ? 'bg-yellow-100 text-yellow-800' 
                                : 'bg-green-100 text-green-800' }}">
                            @if ($item->status == 'diproses')
                                ⏳
                            @else
                                ✅
                            @endif
                            <span class="ml-1">{{ ucfirst($item->status) }}</span>
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
