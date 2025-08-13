{{-- resources/views/landing.blade.php --}}
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Kos Ibu Haji — Solusi Manajemen Kos Modern</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased text-gray-800 bg-gradient-to-br from-indigo-50 to-pink-50 min-h-screen">

  <!-- Navbar -->
  <header class="max-w-7xl mx-auto px-6 py-6 flex items-center relative">
    <!-- Brand (kiri) -->
    <a href="{{ url('/') }}" class="flex items-center gap-3">
      <div class="w-10 h-10 bg-gradient-to-br from-pink-400 to-indigo-400 rounded-lg flex items-center justify-center text-white font-bold">KI</div>
      <div>
        <div class="font-semibold">Kos Ibu Haji</div>
        <div class="text-xs text-gray-400">Manajemen Kos Modern</div>
      </div>
    </a>

    <!-- Desktop nav: diposisikan ke kanan dengan ml-auto -->
    <nav class="hidden md:flex ml-auto items-center gap-6 justify-end">
      <a href="#features" class="hover:text-indigo-600">Fitur</a>
      <a href="{{ route('contact') }}" class="hover:text-indigo-600">Kontak Kami</a>
      <a href="#testi" class="hover:text-indigo-600">Testimoni</a>

      <!-- CTA Dropdown (desktop) -->
      <div class="relative">
        <button id="ctaBtn" class="ml-4 px-4 py-2 bg-gradient-to-r from-pink-500 to-indigo-500 text-white rounded-lg shadow flex items-center gap-2">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
          Akun
          <svg class="w-3 h-3 ml-1" viewBox="0 0 20 20" fill="none" stroke="currentColor"><path d="M6 8l4 4 4-4" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </button>

        <div id="ctaMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg ring-1 ring-black/5 py-2 z-50">
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

    <!-- Mobile controls (hanya menu button, tanpa tombol kontak di luar dropdown) -->
    <div class="ml-auto md:ml-0 md:hidden">
      <button id="mobileMenuBtn" aria-expanded="false" aria-controls="mobileNav" class="p-2 bg-white rounded-lg shadow">☰</button>
    </div>
  </header>

  <!-- Mobile dropdown (appears under header, vertical list) -->
  <div id="mobileNav" class="md:hidden hidden max-w-7xl mx-auto px-6">
    <div class="bg-white/90 backdrop-blur-sm rounded-lg shadow-md mt-2 py-3">
      <nav class="flex flex-col">
        <a href="#features" class="block px-4 py-3 text-gray-700 hover:bg-gray-50">Fitur</a>
        <a href="{{ route('contact') }}" class="block px-4 py-3 text-gray-700 hover:bg-gray-50">Kontak Kami</a>
        <a href="#testi" class="block px-4 py-3 text-gray-700 hover:bg-gray-50">Testimoni</a>

        <div class="border-t my-2"></div>

        {{-- Mobile account section --}}
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

  <!-- Hero -->
  <section class="max-w-7xl mx-auto px-6 py-12 grid md:grid-cols-2 gap-8 items-center">
    <div>
      <h1 class="text-4xl md:text-5xl font-extrabold leading-tight">Kelola Kos Anda dengan Mudah — <span class="text-brand-500">Cepat & Terpercaya</span></h1>
      <p class="mt-4 text-gray-600 max-w-xl">Sistem manajemen kos lengkap: penghuni, tagihan otomatis, laporan kerusakan, dan dashboard yang ramah pengguna. Hemat waktu dan tanpa ribet.</p>
      <div class="mt-6 flex flex-wrap gap-3">
        <a href="{{ route('register') }}" class="inline-block px-6 py-3 bg-gradient-to-r from-pink-500 to-indigo-500 text-white rounded-lg shadow-lg">Mulai Gratis</a>
        <a href="#features" class="inline-block px-6 py-3 border rounded-lg text-gray-700 hover:bg-gray-50">Lihat Fitur</a>
      </div>

      <div class="mt-8 grid grid-cols-2 gap-4">
        <div class="bg-white p-4 rounded-lg shadow-sm">
          <div class="text-sm text-gray-500">Kamar Terdaftar</div>
          <div class="text-xl font-bold">{{\App\Models\Kamar::count()}}</div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-sm">
          <div class="text-sm text-gray-500">Pengguna Aktif</div>
          <div class="text-xl font-bold">{{\App\Models\User::where('role', 'user')->count()}}</div>
        </div>
      </div>
    </div>

    <div class="relative">
      <div class="rounded-2xl bg-gradient-to-tr from-white/70 to-white/40 p-6 shadow-xl">
        <img src="https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?q=80&w=1200&auto=format&fit=crop&ixlib=rb-4.0.3&s=6a1b7b2b3b4d5b6f" alt="Dashboard preview" class="rounded-xl w-full shadow">
      </div>
      <div class="absolute -bottom-6 left-6 bg-white rounded-xl px-4 py-3 shadow flex items-center gap-3">
        <div class="w-10 h-10 rounded-full bg-green-100 text-green-700 flex items-center justify-center">✓</div>
        <div>
          <div class="text-xs text-gray-500">Pembayaran Cepat</div>
          <div class="text-sm font-medium">Midtrans & Manual</div>
        </div>
      </div>
    </div>
  </section>

  <!-- Features -->
  <section id="features" class="max-w-7xl mx-auto px-6 py-12">
    <h3 class="text-2xl font-bold text-center mb-8">Fitur Unggulan</h3>
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
      <div class="bg-white rounded-xl p-6 shadow hover:shadow-lg transition">
        <div class="text-3xl">🏷️</div>
        <h4 class="mt-3 font-semibold">Manajemen Penghuni</h4>
        <p class="mt-2 text-sm text-gray-500">Tambah, edit, dan cari penghuni dengan mudah.</p>
      </div>
      <div class="bg-white rounded-xl p-6 shadow hover:shadow-lg transition">
        <div class="text-3xl">💳</div>
        <h4 class="mt-3 font-semibold">Tagihan & Pembayaran</h4>
        <p class="mt-2 text-sm text-gray-500">Tagihan otomatis, integrasi Midtrans, dan konfirmasi manual.</p>
      </div>
      <div class="bg-white rounded-xl p-6 shadow hover:shadow-lg transition">
        <div class="text-3xl">🛠️</div>
        <h4 class="mt-3 font-semibold">Laporan Kerusakan</h4>
        <p class="mt-2 text-sm text-gray-500">Penghuni kirim bukti, admin kelola status perbaikan.</p>
      </div>
      <div class="bg-white rounded-xl p-6 shadow hover:shadow-lg transition">
        <div class="text-3xl">📊</div>
        <h4 class="mt-3 font-semibold">Dashboard & Statistik</h4>
        <p class="mt-2 text-sm text-gray-500">Ringkasan kamar, pembayaran, dan laporan dalam satu tampilan.</p>
      </div>
    </div>
  </section>

  <!-- CTA / Pricing -->
  <section id="pricing" class="max-w-7xl mx-auto px-6 py-12">
    <div class="bg-white rounded-xl shadow-md p-8 text-center">
      <h3 class="text-2xl font-bold">Mulai Sekarang — Gratis 14 Hari</h3>
      <p class="mt-2 text-gray-600">Tak perlu kartu kredit. Upgrade kapan saja.</p>
      <div class="mt-6 flex justify-center gap-4">
        <a href="{{ route('register') }}" class="px-6 py-3 bg-gradient-to-r from-pink-500 to-indigo-500 text-white rounded-lg shadow-lg">Coba Gratis</a>
        <a href="{{ route('contact') }}" class="px-6 py-3 border rounded-lg text-gray-700">Kontak Kami</a>
      </div>
    </div>
  </section>

  <!-- Testimonials -->
  <section id="testi" class="max-w-7xl mx-auto px-6 py-12">
    <h3 class="text-2xl font-bold text-center mb-8">Apa Kata Mereka</h3>
    <div class="grid md:grid-cols-3 gap-6">
      <blockquote class="bg-white p-6 rounded-xl shadow">
        <p class="text-gray-700">"Sistem ini mempermudah pengelolaan kos saya — laporan & tagihan jadi teratur."</p>
        <footer class="mt-4 text-sm text-gray-500">— Ani, Pemilik Kos</footer>
      </blockquote>
      <blockquote class="bg-white p-6 rounded-xl shadow">
        <p class="text-gray-700">"Integrasi pembayaran cepat dan aman."</p>
        <footer class="mt-4 text-sm text-gray-500">— Budi, Penghuni</footer>
      </blockquote>
      <blockquote class="bg-white p-6 rounded-xl shadow">
        <p class="text-gray-700">"UI-nya bersih dan mudah dipakai."</p>
        <footer class="mt-4 text-sm text-gray-500">— Rina, Manager Kos</footer>
      </blockquote>
    </div>
  </section>

  <!-- Footer -->
  <footer class="mt-12 bg-white/70">
    <div class="max-w-7xl mx-auto px-6 py-8 flex flex-col md:flex-row justify-between items-center gap-4">
      <div class="text-sm text-gray-600">© {{ date('Y') }} Kos Ibu Haji. All rights reserved.</div>
      <div class="flex items-center gap-4">
        <a href="{{ route('contact') }}" class="text-gray-600 hover:text-gray-800">Kontak</a>
        <a href="#" class="text-gray-600 hover:text-gray-800">Privacy</a>
        <a href="#" class="text-gray-600 hover:text-gray-800">Terms</a>
      </div>
    </div>
  </footer>

  <script>
    // mobile toggle: toggle mobileNav (vertical dropdown under header)
    const mobileBtn = document.getElementById('mobileMenuBtn');
    const mobileNav = document.getElementById('mobileNav');
    mobileBtn?.addEventListener('click', () => {
      const expanded = mobileBtn.getAttribute('aria-expanded') === 'true';
      mobileBtn.setAttribute('aria-expanded', (!expanded).toString());
      mobileNav?.classList.toggle('hidden');
    });

    // CTA dropdown (desktop)
    const ctaBtn = document.getElementById('ctaBtn');
    const ctaMenu = document.getElementById('ctaMenu');
    ctaBtn?.addEventListener('click', (e) => {
      e.stopPropagation();
      ctaMenu.classList.toggle('hidden');
    });
    // close CTA when clicking outside or pressing escape
    document.addEventListener('click', () => ctaMenu?.classList.add('hidden'));
    document.addEventListener('keydown', e => { if (e.key === 'Escape') ctaMenu?.classList.add('hidden'); });
  </script>
</body>
</html>
