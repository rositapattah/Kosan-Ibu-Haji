<section class="space-y-6">
    <header>
        <h2 class="text-lg font-semibold text-red-600">Hapus Akun</h2>
        <p class="mt-1 text-sm text-gray-500">
            Setelah akun dihapus, semua data akan hilang secara permanen. Pastikan Anda telah menyimpan data penting sebelum melanjutkan.
        </p>
    </header>

    <button type="button"
        class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow-soft transition"
        x-data
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
        Hapus Akun
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 space-y-5">
            @csrf
            @method('delete')

            <h2 class="text-lg font-semibold text-gray-800">Yakin ingin menghapus akun?</h2>
            <p class="text-sm text-gray-500">
                Setelah dihapus, akun tidak dapat dipulihkan. Masukkan password untuk konfirmasi.
            </p>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input id="password" name="password" type="password"
                       class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-red-200 focus:border-red-400 bg-white"
                       placeholder="Password">
                @error('userDeletion.password')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')"
                        class="px-5 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition">
                    Batal
                </button>
                <button type="submit"
                        class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow-soft transition">
                    Hapus Akun
                </button>
            </div>
        </form>
    </x-modal>
</section>
