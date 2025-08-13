{{-- resources/views/contact.blade.php --}}
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Kontak Kami — Kos Ibu Haji</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased text-gray-800 bg-gradient-to-br from-indigo-50 to-pink-50 min-h-screen">

  <!-- Header -->
  <header class="max-w-7xl mx-auto px-6 py-6 flex items-center relative">
    <a href="{{ url('/') }}" class="flex items-center gap-3">
      <div class="w-10 h-10 bg-gradient-to-br from-pink-400 to-indigo-400 rounded-lg flex items-center justify-center text-white font-bold">KI</div>
      <div>
        <div class="font-semibold">Kos Ibu Haji</div>
        <div class="text-xs text-gray-400">Manajemen Kos Modern</div>
      </div>
    </a>

    <!-- Desktop nav (posisi kanan) -->
    <nav class="hidden md:flex ml-auto items-center gap-6">
      <a href="{{ url('/') }}#features" class="hover:text-indigo-600">Fitur</a>
      <a href="{{ route('contact') }}" class="hover:text-indigo-600 font-medium">Kontak Kami</a>
      <a href="{{ url('/') }}#testi" class="hover:text-indigo-600">Testimoni</a>

      <!-- akun dropdown (sederhana) -->
      <div class="relative">
        <button id="ctaBtn" class="ml-4 px-4 py-2 bg-gradient-to-r from-pink-500 to-indigo-500 text-white rounded-lg shadow flex items-center gap-2">
          Akun
          <svg class="w-3 h-3 ml-1" viewBox="0 0 20 20" fill="none" stroke="currentColor"><path d="M6 8l4 4 4-4" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </button>
        <div id="ctaMenu" class="hidden absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-lg ring-1 ring-black/5 py-2 z-50">
          @auth
            @php $dashRoute = auth()->user()->role === 'admin' ? route('dashboard') : route('user.dashboard'); @endphp
            <a href="{{ $dashRoute }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Dashboard</a>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-50">Logout</button>
            </form>
          @else
            <a href="{{ route('register') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Daftar</a>
            <a href="{{ route('login') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Masuk</a>
          @endauth
        </div>
      </div>
    </nav>

    <!-- Mobile menu button -->
    <div class="ml-auto md:ml-0 md:hidden">
      <button id="mobileMenuBtn" aria-expanded="false" aria-controls="mobileNav" class="p-2 bg-white rounded-lg shadow">☰</button>
    </div>
  </header>

  <!-- Mobile dropdown (stacked) -->
  <div id="mobileNav" class="md:hidden hidden max-w-7xl mx-auto px-6">
    <div class="bg-white/90 backdrop-blur-sm rounded-lg shadow-md mt-2 py-3">
      <nav class="flex flex-col">
        <a href="{{ url('/') }}#features" class="block px-4 py-3 text-gray-700 hover:bg-gray-50">Fitur</a>
        <a href="{{ route('contact') }}" class="block px-4 py-3 text-gray-700 hover:bg-gray-50">Kontak Kami</a>
        <a href="{{ url('/') }}#testi" class="block px-4 py-3 text-gray-700 hover:bg-gray-50">Testimoni</a>
        <div class="border-t my-2"></div>

        @auth
          @php $dashRoute = auth()->user()->role === 'admin' ? route('dashboard') : route('user.dashboard'); @endphp
          <a href="{{ $dashRoute }}" class="block px-4 py-3 text-gray-700 hover:bg-gray-50">Dashboard</a>
          <form method="POST" action="{{ route('logout') }}" class="px-4 py-0">
            @csrf
            <button type="submit" class="w-full text-left px-0 py-3 text-red-600 hover:bg-gray-50">Logout</button>
          </form>
        @else
          <a href="{{ route('register') }}" class="block px-4 py-3 text-gray-700 hover:bg-gray-50">Daftar</a>
          <a href="{{ route('login') }}" class="block px-4 py-3 text-gray-700 hover:bg-gray-50">Masuk</a>
        @endauth
      </nav>
    </div>
  </div>

  <!-- Main content -->
  <main class="max-w-5xl mx-auto px-6 py-8">
    <div class="bg-white rounded-2xl shadow-xl p-6 md:p-10">
      <h1 class="text-2xl font-bold mb-2">Kontak Kami</h1>
      <p class="text-gray-600 mb-6">Butuh bantuan? Hubungi kami melalui saluran di bawah ini. Kami siap membantu untuk support, demo, atau kerjasama.</p>

      <!-- GRID: 1 column on small, 2 columns on md+ -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Left: kontak cards -->
        <div class="space-y-4">
          <a href="https://wa.me/6281234567890?text=Halo%20Kos%20Ibu%20Haji%2C%20saya%20ingin%20bertanya..." target="_blank" class="flex items-center gap-4 p-4 rounded-lg shadow hover:shadow-md bg-gradient-to-r from-green-50 to-white">
            <div class="w-12 h-12 rounded-lg bg-green-500 text-white flex items-center justify-center font-semibold">WA</div>
            <div>
              <div class="font-semibold">WhatsApp</div>
              <div class="text-sm text-gray-500">+62 812-3456-7890</div>
            </div>
          </a>

          <a href="mailto:info@kosibuhaji.id" class="flex items-center gap-4 p-4 rounded-lg shadow hover:shadow-md bg-gradient-to-r from-indigo-50 to-white">
            <div class="w-12 h-12 rounded-lg bg-indigo-500 text-white flex items-center justify-center font-semibold">@</div>
            <div>
              <div class="font-semibold">Email</div>
              <div class="text-sm text-gray-500">info@kosibuhaji.id</div>
            </div>
          </a>

          <a href="https://www.facebook.com/yourpage" target="_blank" class="flex items-center gap-4 p-4 rounded-lg shadow hover:shadow-md bg-gradient-to-r from-blue-50 to-white">
            <div class="w-12 h-12 rounded-lg bg-blue-600 text-white flex items-center justify-center font-semibold">f</div>
            <div>
              <div class="font-semibold">Facebook</div>
              <div class="text-sm text-gray-500">/KosIbuHaji</div>
            </div>
          </a>

          <a href="https://www.instagram.com/yourhandle" target="_blank" class="flex items-center gap-4 p-4 rounded-lg shadow hover:shadow-md bg-gradient-to-r from-pink-50 to-white">
            <div class="w-12 h-12 rounded-lg bg-pink-500 text-white flex items-center justify-center font-semibold">ig</div>
            <div>
              <div class="font-semibold">Instagram</div>
              <div class="text-sm text-gray-500">@kosibuhaji</div>
            </div>
          </a>
        </div>

        <!-- Right: office info + quick actions (NO FORM) -->
        <div class="p-6 rounded-lg bg-gradient-to-br from-white to-indigo-50 shadow-inner flex flex-col justify-between">
          <div>
            <h3 class="font-semibold mb-2">Kantor & Jam Operasional</h3>
            <p class="text-sm text-gray-600 mb-4">Jl. Contoh No.123, Kota — Senin - Jumat: 08:00 - 17:00</p>

            <h3 class="font-semibold mb-2">Hubungi Kami</h3>
            <p class="text-sm text-gray-600 mb-4">Untuk jawaban cepat: WhatsApp. Untuk dokumen/pertanyaan resmi: email.</p>
          </div>

          <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3">
            <a href="https://wa.me/6281234567890" target="_blank" class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-green-500 text-white shadow hover:opacity-95">
              <!-- WA icon simple -->
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 11.5a8.5 8.5 0 1 0-1.9 4.9L21 21l-3.6-1.1A8.5 8.5 0 0 0 21 11.5z" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
              Chat via WhatsApp
            </a>
            <a href="mailto:info@kosibuhaji.id" class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg border bg-white hover:bg-gray-50">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-indigo-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 8.5v7a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/><path d="M21 7l-9 6-9-6" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
              Kirim Email
            </a>
          </div>

          <div class="mt-4 text-sm text-gray-500">Preferensi: gunakan WhatsApp untuk respons paling cepat.</div>
        </div>
      </div>
    </div>
  </main>

  <footer class="max-w-7xl mx-auto px-6 py-8 text-center text-sm text-gray-500">© {{ date('Y') }} Kos Ibu Haji</footer>

  <script>
    // mobile toggle
    const mobileBtn = document.getElementById('mobileMenuBtn');
    const mobileNav = document.getElementById('mobileNav');
    mobileBtn?.addEventListener('click', () => {
      const expanded = mobileBtn.getAttribute('aria-expanded') === 'true';
      mobileBtn.setAttribute('aria-expanded', (!expanded).toString());
      mobileNav?.classList.toggle('hidden');
    });

    // desktop account dropdown
    const ctaBtn = document.getElementById('ctaBtn');
    const ctaMenu = document.getElementById('ctaMenu');
    ctaBtn?.addEventListener('click', (e) => {
      e.stopPropagation();
      ctaMenu.classList.toggle('hidden');
    });
    document.addEventListener('click', () => ctaMenu?.classList.add('hidden'));
    document.addEventListener('keydown', e => { if (e.key === 'Escape') ctaMenu?.classList.add('hidden'); });
  </script>
</body>
</html>
