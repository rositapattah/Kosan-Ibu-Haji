<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Lupa Password</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4 font-sans">

  <div class="max-w-md w-full bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-semibold mb-4 text-gray-800">Lupa Password?</h1>
    <p class="text-sm text-gray-600 mb-6">
      Masukkan alamat email Anda, dan kami akan mengirimkan tautan untuk membuat password baru.
    </p>

    @if (session('status'))
      <div class="mb-4 rounded-lg bg-green-50 border border-green-200 p-3 text-green-700 text-sm">
        {{ session('status') }}
      </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" id="forgotPasswordForm" class="space-y-4">
      @csrf

      <div>
        <label for="email" class="block mb-1 text-sm font-medium text-gray-700">Email</label>
        <input type="email" name="email" id="email" required autofocus
          class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400" />
        @error('email')
          <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div class="flex items-center justify-between">
        <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">Kembali ke Login</a>

        <button type="submit" id="submitBtn" class="relative inline-flex items-center px-4 py-2 rounded-lg bg-indigo-600 text-white font-semibold text-sm shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2">
          <svg id="spinner" class="animate-spin -ml-1 mr-2 h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
          </svg>
          Kirim Tautan Reset Password
        </button>
      </div>
    </form>

    <p class="mt-4 text-xs text-gray-400">
      Jika tidak menerima email, cek folder spam atau hubungi admin.
    </p>
  </div>

  <script>
    const form = document.getElementById('forgotPasswordForm');
    const btn = document.getElementById('submitBtn');
    const spinner = document.getElementById('spinner');

    form.addEventListener('submit', () => {
      btn.disabled = true;
      spinner.classList.remove('hidden');
    });
  </script>
</body>
</html>
