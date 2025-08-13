<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>@yield('title', 'Admin Panel')</title>

  <!-- Tailwind CDN (cepat demo / prototyping) -->
  <script>
    // optional: custom tailwind config (ubah warna bila perlu)
    tailwind = window.tailwind || {};
    window.tailwind = {
      config: {
        theme: {
          extend: {
            colors: {
              brand: {
                50: '#fff9ed',
                100: '#fff2d2',
                300: '#ffd580',
                500: '#f9a826',
                700: '#c27a12',
              }
            }
          }
        }
      }
    }
  </script>
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <style>
    /* sedikit shadow & radius seragam */
    .card { @apply bg-white rounded-xl shadow p-5; }
  </style>
</head>
<body class="font-sans antialiased bg-gradient-to-r from-yellow-200 to-pink-200 bg-opacity-75 backdrop-blur-sm min-h-screen">
  <div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside id="sidebar" class="w-72 bg-gray-50 border-r hidden md:block">
      <div class="px-6 py-6">
        <a href="#" class="flex items-center gap-3">
          <div class="w-10 h-10 bg-gradient-to-br from-pink-400 to-indigo-400 rounded-lg flex items-center justify-center text-white font-bold">KI</div>
          <div>
            <div class="text-lg font-semibold">Kos Ibu Haji</div>
            <div class="text-xs text-gray-400">Management System</div>
          </div>
        </a>
      </div>

      <nav class="px-4 pb-6">
        <ul class="space-y-1">
          <li>
            <a href="{{route('dashboard')}}" class="flex items-center gap-3 px-3 py-2 rounded-lg bg-gradient-to-r from-yellow-100 to-yellow-50 text-yellow-800">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 12h18M3 6h18M3 18h18" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
              Dashboard
            </a>
          </li>
          <li><a href="{{ route('penghuni.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100">Manajemen Penghuni</a></li>
          <li><a href="{{route('kamar.index')}}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100">Manajemen Kamar</a></li>
          <li><a href="{{route('tagihan.index')}}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100">Tagihan</a></li>
          <li><a href="{{route('pembayaran.index')}}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100">Pembayaran</a></li>
          <li><a href="{{route('laporan.index')}}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100">Laporan Kerusakan</a></li>
          {{-- <li><a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100">Pengaturan</a></li> --}}
        </ul>
      </nav>

      <div class="mt-auto px-6 py-6">
        <form action="{{ route('logout') }}" method="POST" class="text-red-500 flex items-center gap-2">
          @csrf
          <button type="submit">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 16l4-4m0 0l-4-4m4 4H7" stroke-width="1.5"/></svg>
            Logout
          </button>
        </form>
      </div>
    </aside>

    <!-- Mobile topbar -->
    <div class="md:hidden fixed top-4 left-4 z-40">
      <button id="btn-toggle" class="bg-white p-2 rounded-lg shadow">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16" stroke-width="1.5"/></svg>
      </button>
    </div>

    <!-- Main content -->
    <div class="flex-1 flex flex-col min-h-screen">
      <!-- Topbar -->
      <header class="flex items-center justify-end px-6 py-4 border-b bg-gradient-to-r from-yellow-100 to-pink-100">
        {{-- <div class="flex items-center gap-4 w-1/2">
          <div class="relative flex-1">
            <input type="text" placeholder="Cari penghuni, kamar, atau transaksi..." class="w-full rounded-full pl-4 pr-10 py-2 border border-transparent focus:outline-none focus:ring-2 focus:ring-amber-200 bg-white/80 text-sm">
            <svg class="w-4 h-4 absolute right-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-4.35-4.35" stroke-width="1.5"/></svg>
          </div>
        </div> --}}

        <div class="flex items-center gap-4">
          <div class="bg-white/60 rounded-full px-3 py-1 text-sm shadow hidden sm:block">Minggu, <span id="date-badge">20 Juli 2025</span></div>
          <div class="text-right hidden sm:block">
            <div class="text-xs text-gray-500">Admin</div>
            <div class="text-sm font-medium">Administrator</div>
          </div>
          <img src="https://ui-avatars.com/api/?name=Admin" alt="avatar" class="w-10 h-10 rounded-full border">
        </div>
      </header>

      <!-- Page content -->
      <main class="p-6 md:p-8 flex-1 overflow-auto">
        <div class="max-w-7xl mx-auto">
          @yield('content')
        </div>
      </main>
    </div>
  </div>

  <script>
  document.addEventListener('DOMContentLoaded', function () {
    const btnToggle = document.getElementById('btn-toggle');
    const sidebar = document.getElementById('sidebar');

    if (btnToggle && sidebar) {
      btnToggle.addEventListener('click', () => {
        sidebar.classList.toggle('hidden');
        sidebar.classList.toggle('fixed');
        sidebar.classList.toggle('top-0');
        sidebar.classList.toggle('left-0');
        sidebar.classList.toggle('w-full');
        sidebar.classList.toggle('h-screen');
        sidebar.classList.toggle('bg-white');
        sidebar.classList.toggle('z-50');
        sidebar.classList.toggle('overflow-auto');
        sidebar.classList.toggle('p-4');
        sidebar.classList.toggle('transition-all');
        sidebar.classList.toggle('duration-300');
      });
    }
  });
</script>

</body>
</html>