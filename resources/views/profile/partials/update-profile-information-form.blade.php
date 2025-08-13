<section>
    <header>
        <h2 class="text-lg font-semibold text-gray-800">Informasi Profil</h2>
        <p class="mt-1 text-sm text-gray-500">Perbarui nama, email, dan informasi dasar akun Anda.</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-5">
        @csrf
        @method('patch')

        {{-- Name --}}
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
            <input id="name" name="name" type="text"
                   class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 bg-white"
                   value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @error('name')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input id="email" name="email" type="email"
                   class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 bg-white"
                   value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2 text-sm text-gray-700">
                    Email Anda belum diverifikasi.
                    <button form="send-verification" class="text-indigo-600 hover:underline">
                        Klik di sini untuk mengirim ulang email verifikasi.
                    </button>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-green-600">Link verifikasi baru telah dikirim.</p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Save button --}}
        <div class="flex items-center gap-4">
            <button type="submit"
                class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-soft transition">
                Simpan
            </button>

            @if (session('status') === 'profile-updated')
                <p class="text-sm text-green-600">Tersimpan.</p>
            @endif
        </div>
    </form>
</section>