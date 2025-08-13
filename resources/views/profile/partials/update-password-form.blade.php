<section>
    <header>
        <h2 class="text-lg font-semibold text-gray-800">Ubah Password</h2>
        <p class="mt-1 text-sm text-gray-500">Gunakan password yang kuat untuk keamanan akun Anda.</p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-5">
        @csrf
        @method('put')

        {{-- Current password --}}
        <div>
            <label for="update_password_current_password" class="block text-sm font-medium text-gray-700 mb-1">Password Saat Ini</label>
            <input id="update_password_current_password" name="current_password" type="password"
                   class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 bg-white"
                   autocomplete="current-password">
            @error('updatePassword.current_password')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- New password --}}
        <div>
            <label for="update_password_password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
            <input id="update_password_password" name="password" type="password"
                   class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 bg-white"
                   autocomplete="new-password">
            @error('updatePassword.password')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Confirm password --}}
        <div>
            <label for="update_password_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                   class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 bg-white"
                   autocomplete="new-password">
            @error('updatePassword.password_confirmation')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="flex items-center gap-4">
            <button type="submit"
                class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-soft transition">
                Simpan
            </button>

            @if (session('status') === 'password-updated')
                <p class="text-sm text-green-600">Tersimpan.</p>
            @endif
        </div>
    </form>
</section>
