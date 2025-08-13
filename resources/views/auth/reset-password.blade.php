{{-- resources/views/auth/reset-password.blade.php --}}
@extends('templates.user')

@section('title', 'Reset Password')

@section('content')
<div class="max-w-xl mx-auto">
  <div class="card">
    <div class="flex items-start gap-4">
      <!-- Icon -->
      <div class="flex-shrink-0 w-12 h-12 rounded-lg bg-brand-100 grid place-items-center text-brand-700">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path d="M12 11v2m0 4h.01M5 12a7 7 0 1114 0v5a2 2 0 01-2 2H7a2 2 0 01-2-2v-5z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>

      <div class="flex-1">
        <h2 class="text-lg font-semibold text-gray-800">Reset Password</h2>
        <p class="text-sm text-gray-600 mt-1">Masukkan email dan password baru Anda. Pastikan password kuat dan mudah diingat.</p>

        <form method="POST" action="{{ route('password.store') }}" class="mt-4 space-y-4">
          @csrf

          <!-- Token -->
          <input type="hidden" name="token" value="{{ $request->route('token') }}">

          <!-- Email -->
          <div>
            <label for="email" class="text-sm font-medium text-gray-700">Email</label>
            <input id="email" name="email" type="email" required autofocus
                   value="{{ old('email', $request->email) }}"
                   class="mt-1 block w-full rounded-lg border border-gray-200 bg-white/90 px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-200">
            @error('email')
              <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
            @enderror
          </div>

          <!-- Password -->
          <div>
            <label for="password" class="text-sm font-medium text-gray-700">Password Baru</label>
            <div class="relative mt-1">
              <input id="password" name="password" type="password" required autocomplete="new-password"
                     class="w-full rounded-lg border border-gray-200 bg-white/90 px-3 py-2 pr-10 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-200">
              <button type="button" id="togglePassword" class="absolute right-2 top-1/2 -translate-y-1/2 text-sm text-gray-500 hover:text-gray-700 focus:outline-none">
                Tampilkan
              </button>
            </div>
            @error('password')
              <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
            @enderror
          </div>

          <!-- Confirm Password -->
          <div>
            <label for="password_confirmation" class="text-sm font-medium text-gray-700">Konfirmasi Password</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                   class="mt-1 block w-full rounded-lg border border-gray-200 bg-white/90 px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-200">
            @error('password_confirmation')
              <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="flex items-center justify-end gap-3">
            <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">Kembali ke Login</a>

            <button type="submit"
                    class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-200
                           bg-gradient-to-br from-brand-500 to-indigo-600 text-white">
              Reset Password
            </button>
          </div>
        </form>

        <p class="text-xs text-gray-400 mt-3">Jika ada masalah, hubungi admin atau coba fitur lupa password lagi.</p>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  // Toggle show/hide password kecil
  (function(){
    const pw = document.getElementById('password');
    const btn = document.getElementById('togglePassword');
    if (!pw || !btn) return;
    btn.addEventListener('click', () => {
      if (pw.type === 'password') {
        pw.type = 'text';
        btn.textContent = 'Sembunyikan';
      } else {
        pw.type = 'password';
        btn.textContent = 'Tampilkan';
      }
    });
  })();
</script>
@endpush
