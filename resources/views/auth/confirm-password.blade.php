{{-- resources/views/auth/confirm-password.blade.php --}}
@extends('templates.user')

@section('title', 'Konfirmasi Password')

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
        <h2 class="text-lg font-semibold text-gray-800">Konfirmasi Password</h2>
        <p class="text-sm text-gray-600 mt-1">
          {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </p>

        <form method="POST" action="{{ route('password.confirm') }}" class="mt-4">
          @csrf

          <!-- Password -->
          <div>
            <label for="password" class="text-sm font-medium text-gray-700">Password</label>
            <input id="password" name="password" type="password" required autocomplete="current-password"
                   class="mt-1 block w-full rounded-lg border border-gray-200 bg-white/90 px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-200" />

            @error('password')
              <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="flex justify-end mt-4">
            <button type="submit"
                    class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-200
                           bg-gradient-to-br from-brand-500 to-indigo-600 text-white">
              {{ __('Confirm') }}
            </button>
          </div>
        </form>

        <p class="text-xs text-gray-400 mt-3">
          Jika Anda lupa password, gunakan <a href="{{ route('password.request') }}" class="underline text-gray-600 hover:text-gray-900">fitur lupa password</a>.
        </p>
      </div>
    </div>
  </div>
</div>
@endsection
