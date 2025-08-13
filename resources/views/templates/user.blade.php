{{-- resources/views/templates/user.blade.php --}}
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>@yield('title','Dashboard Penghuni')</title>

  <script>
    window.tailwind = window.tailwind || {};
    window.tailwind.config = {
      theme: { extend: {
        colors: { brand:{50:'#f3f6ff',100:'#e6efff',300:'#bcd7ff',500:'#7fb2ff',700:'#4a86ff'} },
        boxShadow: { soft: '0 6px 20px rgba(13,30,57,0.06)' }
      }}
    };
  </script>
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <style>
    .card { @apply bg-white/80 backdrop-blur-sm rounded-xl shadow-soft p-5; }
    .shadow-soft { box-shadow: 0 10px 30px rgba(13,30,57,0.06); }
  </style>
</head>
<body class="font-sans bg-gradient-to-br from-indigo-50 to-pink-50 min-h-screen text-gray-700">
  <div class="flex min-h-screen">

    {{-- Sidebar --}}
    <aside id="sidebar" class="w-72 bg-white/60 backdrop-blur-md border-r hidden md:block">
      <div class="px-6 py-6">
        <a href="#" class="flex items-center gap-3">
          <div class="w-10 h-10 bg-gradient-to-br from-pink-400 to-indigo-400 rounded-lg flex items-center justify-center text-white font-bold">KI</div>
          <div>
            <div class="text-lg font-semibold">Kos Ibu Haji</div>
            <div class="text-xs text-gray-400">Penghuni</div>
          </div>
        </a>
      </div>

      <nav class="px-4 pb-6">
        <ul class="space-y-1">
          <li><a href="{{ route('user.dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg bg-white text-indigo-700">Dashboard</a></li>
          <li><a href="{{ route('tagihan.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100">Tagihan</a></li>
          <li><a href="{{ route('laporan.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100">Laporan</a></li>
          <li><a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100">Profil</a></li>
        </ul>
      </nav>

      <div class="mt-auto px-6 py-6">
        <form action="{{ route('logout') }}" method="POST">@csrf
          <button class="text-red-500 flex items-center gap-2">⤴ Logout</button>
        </form>
      </div>
    </aside>

    {{-- Mobile toggle --}}
    <div class="md:hidden fixed top-4 left-4 z-40">
      <button id="btn-toggle" class="bg-white p-2 rounded-lg shadow">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </button>
    </div>

    {{-- Main --}}
    <div class="flex-1 flex flex-col">

      {{-- Top banner --}}
      <header class="px-6 py-6 bg-gradient-to-r from-indigo-100 via-purple-50 to-pink-50 border-b">
        <div class="max-w-7xl mx-auto">
          <div class="flex items-center justify-between gap-4">
            <div>
              <h1 class="text-2xl font-bold text-gray-800">Dashboard Penghuni</h1>
              <div class="text-sm text-gray-500">Kos Ibu Haji — Kamar {{ $kamar->nomor_kamar ?? '-' }}</div>
            </div>

            {{-- <div class="flex-1 max-w-xl mx-6">
              <div class="relative">
                <input type="search" placeholder="Cari penghuni, kamar, atau transaksi..." class="w-full rounded-full pl-4 pr-12 py-3 border border-transparent focus:outline-none focus:ring-2 focus:ring-indigo-200 bg-white/90 text-sm shadow-sm">
                <svg class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-4.35-4.35" stroke-width="1.5"/></svg>
              </div>
            </div> --}}

            <div class="flex items-center gap-4">
              {{-- <button class="relative p-2 bg-white rounded-full shadow-sm">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118.6 14.6V11a6 6 0 10-12 0v3.6c0 .538-.214 1.055-.595 1.435L4 17h5" stroke-width="1.5"/></svg>
                <span class="absolute -top-1 -right-1 bg-pink-500 text-white text-xs rounded-full px-1.5">21</span>
              </button> --}}

              <div class="text-right hidden sm:block">
                <div class="text-xs text-gray-500">Penghuni</div>
                <div class="text-sm font-medium">{{ auth()->user()->name ?? 'User' }}</div>
              </div>

              <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'User') }}" class="w-10 h-10 rounded-full border"/>
            </div>
          </div>
        </div>
      </header>

      {{-- Content area --}}
      <main class="p-6 overflow-auto">
        <div class="max-w-7xl mx-auto space-y-6">
          @yield('content')
        </div>
      </main>
    </div>
  </div>

<script>
  // date badge (if needed in content)
  document.querySelectorAll('[data-now]').forEach(el=>{
    el.textContent = new Date().toLocaleDateString('id-ID', { weekday:'long', day:'numeric', month:'long', year:'numeric' });
  });

  // mobile sidebar toggle
  const btn = document.getElementById('btn-toggle');
  const sidebar = document.getElementById('sidebar');
  btn?.addEventListener('click', () => {
    sidebar.classList.toggle('hidden');
    sidebar.classList.toggle('absolute');
    sidebar.classList.toggle('z-50');
    sidebar.classList.toggle('left-0');
    sidebar.classList.toggle('top-0');
    sidebar.classList.toggle('h-screen');
  });
</script>
@yield('scripts')
@stack('scripts')
</body>
</html>
