{{-- resources/views/auth/login.blade.php --}}
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Masuk — Kos Ibu Haji</title>
  <script>
    window.tailwind = window.tailwind || {};
    window.tailwind.config = { theme: { extend: { colors: { brand:{50:'#fff9ed',100:'#fff2d2',300:'#ffd580',500:'#f9a826',700:'#c27a12'} } } } };
  </script>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-indigo-50 to-pink-50 flex items-center justify-center font-sans">
  <div class="w-full max-w-3xl mx-4 grid md:grid-cols-2 gap-8 items-center">
    <!-- Left hero -->
    <div class="hidden md:flex flex-col gap-6 p-8 rounded-2xl bg-white/90 shadow-lg">
      <div class="flex items-center gap-3">
        <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-pink-400 to-indigo-400 text-white flex items-center justify-center font-bold">KI</div>
        <div>
          <h2 class="text-xl font-semibold">Kos Ibu Haji</h2>
          <p class="text-sm text-gray-500">Manajemen kos modern — penghuni, tagihan, laporan.</p>
        </div>
      </div>
      <h3 class="text-2xl font-extrabold">Kelola kos lebih mudah</h3>
      <p class="text-sm text-gray-600">Akses dashboard, bayar tagihan, dan laporkan kerusakan hanya dengan beberapa klik.</p>
      <ul class="mt-4 space-y-2 text-sm text-gray-600">
        <li>✅ Dashboard user & admin</li>
        <li>✅ Integrasi Midtrans (opsional)</li>
        <li>✅ Laporan & status perbaikan</li>
      </ul>
    </div>

    <!-- Auth card -->
    <div class="bg-white rounded-2xl shadow-lg p-8">
      <h1 class="text-2xl font-bold mb-1">Masuk</h1>
      <p class="text-sm text-gray-500 mb-6">Masuk ke akun Anda</p>

      <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        @if ($errors->any())
          <div class="text-sm text-red-600">{{ $errors->first() }}</div>
        @endif

        <div>
          <label class="block text-sm font-medium text-gray-700">Email</label>
          <input name="email" type="email" value="{{ old('email') }}" required autofocus
                 class="mt-1 w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-200">
          @error('email') <div class="text-xs text-red-600 mt-1">{{ $message }}</div> @enderror
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Password</label>
          <div class="relative">
            <input id="password" name="password" type="password" required
                   class="mt-1 w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-200">
            <button type="button" id="togglePwd" class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-gray-500">Tampilkan</button>
          </div>
          @error('password') <div class="text-xs text-red-600 mt-1">{{ $message }}</div> @enderror
        </div>

        <div class="flex items-center justify-between text-sm">
          <label class="inline-flex items-center gap-2">
            <input type="checkbox" name="remember" class="rounded border-gray-300">
            <span class="text-gray-600">Ingat saya</span>
          </label>
          <a href="{{ route('password.request') }}" class="text-indigo-600 hover:underline">Lupa password?</a>
        </div>

        <button type="submit" class="w-full mt-2 px-4 py-2 rounded-lg bg-gradient-to-r from-pink-500 to-indigo-500 text-white font-semibold shadow">
          Masuk
        </button>

        <p class="text-center text-sm text-gray-600">Belum punya akun? <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">Daftar</a></p>
      </form>

      <div class="mt-6 text-xs text-center text-gray-400">&copy; {{ date('Y') }} Kos Ibu Haji</div>
    </div>
  </div>

<script>
  document.getElementById('togglePwd')?.addEventListener('click', function(){
    const pw = document.getElementById('password');
    if (!pw) return;
    if (pw.type === 'password') { pw.type = 'text'; this.textContent = 'Sembunyikan'; }
    else { pw.type = 'password'; this.textContent = 'Tampilkan'; }
  });
</script>
</body>
</html>
