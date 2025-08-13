@extends('templates.user')

@section('content')
<div class="max-w-4xl mx-auto py-6">
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="bg-blue-600 px-6 py-4">
            <h4 class="text-white font-semibold text-lg">
                {{ isset($laporan) ? 'Edit Laporan Kerusakan' : 'Buat Laporan Kerusakan Baru' }}
            </h4>
        </div>
        <div class="p-6">
            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ isset($laporan) ? route('laporan.update', $laporan->id) : route('laporan.store') }}" 
                  method="POST" 
                  enctype="multipart/form-data"
                  class="space-y-4">
                @csrf
                @if(isset($laporan))
                    @method('PUT')
                @endif

                <div>
                    <label for="keterangan" class="block text-gray-700 font-medium mb-1">
                        Keterangan Kerusakan <span class="text-red-500">*</span>
                    </label>
                    <textarea id="keterangan" 
                              name="keterangan" 
                              rows="5" 
                              required 
                              class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    >{{ old('keterangan', $laporan->keterangan ?? '') }}</textarea>
                </div>

                <input type="hidden" name="tanggal_laporan" value="{{ now() }}">

                <div>
                    <label for="media" class="block text-gray-700 font-medium mb-1">
                        Unggah Foto/Video (Opsional)
                    </label>
                    <input type="file" 
                           id="media" 
                           name="media" 
                           accept="image/*,video/*" 
                           class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                    <p class="text-sm text-gray-500 mt-1">
                        Maksimal 2MB. Format: JPG, PNG, GIF, MP4, MOV.
                    </p>

                    @if(isset($laporan) && $laporan->media)
                        <div class="mt-3">
                            <p class="text-sm text-gray-600 mb-1">Media Saat Ini:</p>
                            @if(Str::contains($laporan->media, ['.mp4', '.mov']))
                                <video controls class="max-w-xs rounded">
                                    <source src="{{ asset('storage/'.$laporan->media) }}" type="video/mp4">
                                </video>
                            @else
                                <img src="{{ asset('storage/'.$laporan->media) }}" alt="Media" class="max-w-xs rounded shadow">
                            @endif
                        </div>
                    @endif
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('laporan.index') }}" 
                       class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        {{ isset($laporan) ? 'Perbarui Laporan' : 'Kirim Laporan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
