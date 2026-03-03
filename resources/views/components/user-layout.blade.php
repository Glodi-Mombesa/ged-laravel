@props(['title' => 'Portail GED', 'subtitle' => 'Consultation des documents validés'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name','GED') }} - {{ $title }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:300,400,500,600,700&display=swap" rel="stylesheet" />

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-slate-50 text-slate-900">
<div class="min-h-screen">

    {{-- Topbar --}}
    <header class="sticky top-0 z-40 bg-white/80 backdrop-blur border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 lg:px-8 h-16 flex items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <button id="btnUserMenu"
                        class="lg:hidden h-10 w-10 rounded-2xl border border-slate-200 hover:bg-slate-50 grid place-items-center">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <a href="{{ route('user.home') }}" class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-2xl bg-indigo-600 text-white grid place-items-center font-extrabold">
                        G
                    </div>
                    <div class="leading-tight hidden sm:block">
                        <div class="text-sm font-extrabold">Portail GED</div>
                        <div class="text-xs text-slate-500">Espace utilisateur</div>
                    </div>
                </a>
            </div>

            {{-- Search (simple) --}}
            <form action="{{ route('user.documents.index') }}" method="GET"
                  class="hidden md:flex items-center gap-2 w-full max-w-xl bg-slate-50 border border-slate-200 rounded-2xl px-3 py-2">
                <i class="fa-solid fa-magnifying-glass text-slate-400"></i>
                <input name="q" value="{{ request('q') }}"
                       placeholder="Rechercher un document (titre, ref, fichier)…"
                       class="w-full bg-transparent border-0 focus:ring-0 text-sm placeholder:text-slate-400">
                <button class="px-3 py-1.5 rounded-xl bg-slate-900 text-white text-sm font-semibold hover:bg-slate-800">
                    Rechercher
                </button>
            </form>

            <div class="flex items-center gap-2">
                <a href="{{ route('user.documents.index') }}"
                   class="hidden sm:inline-flex items-center gap-2 px-3 py-2 rounded-2xl border border-slate-200 hover:bg-slate-50 text-sm font-semibold">
                    <i class="fa-solid fa-folder-open text-slate-500"></i>
                    Documents
                </a>

                <div class="hidden sm:flex items-center gap-2 px-3 py-2 rounded-2xl bg-white border border-slate-200">
                    <i class="fa-solid fa-user text-slate-500"></i>
                    <div class="leading-tight">
                        <div class="text-sm font-semibold">{{ auth()->user()->name }}</div>
                        <div class="text-xs text-slate-500">{{ auth()->user()->email }}</div>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="inline-flex items-center gap-2 px-3 py-2 rounded-2xl bg-slate-900 text-white text-sm font-semibold hover:bg-slate-800">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span class="hidden sm:inline">Déconnexion</span>
                    </button>
                </form>
            </div>
        </div>

        {{-- Mobile search --}}
        <div class="md:hidden px-4 pb-3">
            <form action="{{ route('user.documents.index') }}" method="GET"
                  class="flex items-center gap-2 w-full bg-slate-50 border border-slate-200 rounded-2xl px-3 py-2">
                <i class="fa-solid fa-magnifying-glass text-slate-400"></i>
                <input name="q" value="{{ request('q') }}"
                       placeholder="Rechercher…"
                       class="w-full bg-transparent border-0 focus:ring-0 text-sm placeholder:text-slate-400">
                <button class="px-3 py-1.5 rounded-xl bg-slate-900 text-white text-sm font-semibold hover:bg-slate-800">
                    Go
                </button>
            </form>
        </div>
    </header>

    {{-- Drawer mobile --}}
    <div id="userDrawerOverlay" class="fixed inset-0 bg-black/30 hidden z-40"></div>
    <aside id="userDrawer"
           class="fixed z-50 top-0 left-0 h-full w-80 max-w-[85%] bg-white border-r border-slate-200 -translate-x-full transition-transform lg:hidden">
        <div class="h-16 px-4 border-b border-slate-200 flex items-center justify-between">
            <div class="font-extrabold">Menu</div>
            <button id="btnUserClose" class="h-10 w-10 rounded-2xl border border-slate-200 hover:bg-slate-50 grid place-items-center">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <nav class="p-4 space-y-2">
            <a href="{{ route('user.home') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-2xl hover:bg-slate-50 font-semibold">
                <i class="fa-solid fa-house text-indigo-600"></i>
                Accueil
            </a>
            <a href="{{ route('user.documents.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-2xl hover:bg-slate-50 font-semibold">
                <i class="fa-solid fa-folder-open text-indigo-600"></i>
                Documents
            </a>
        </nav>

        <div class="mt-auto p-4 border-t border-slate-200">
            <div class="text-xs text-slate-500">Connecté :</div>
            <div class="font-semibold">{{ auth()->user()->name }}</div>
            <div class="text-xs text-slate-500">{{ auth()->user()->email }}</div>
        </div>
    </aside>

    {{-- Content --}}
    <main class="max-w-7xl mx-auto px-4 lg:px-8 py-8">
        <div class="mb-6">
            <h1 class="text-2xl md:text-3xl font-extrabold">{{ $title }}</h1>
            <p class="text-slate-600 mt-1">{{ $subtitle }}</p>
        </div>

        @if(session('success'))
            <div class="mb-5 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800">
                <i class="fa-solid fa-circle-check mr-2"></i>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-5 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-rose-800">
                <div class="font-semibold mb-1">Erreurs :</div>
                <ul class="list-disc pl-5 text-sm">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div data-animate="fade-up">
            {{ $slot }}
        </div>
    </main>
</div>

<script>
    // Drawer mobile
    const btnMenu = document.getElementById('btnUserMenu');
    const btnClose = document.getElementById('btnUserClose');
    const drawer = document.getElementById('userDrawer');
    const overlay = document.getElementById('userDrawerOverlay');

    function openDrawer() {
        drawer.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
    }
    function closeDrawer() {
        drawer.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    }

    if (btnMenu) btnMenu.addEventListener('click', openDrawer);
    if (btnClose) btnClose.addEventListener('click', closeDrawer);
    if (overlay) overlay.addEventListener('click', closeDrawer);

    // Mini animations on scroll
    const items = document.querySelectorAll('[data-animate]');
    const io = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.classList.add('animate-in');
                io.unobserve(e.target);
            }
        });
    }, { threshold: 0.12 });

    items.forEach(el => io.observe(el));
</script>

<style>
    /* petite animation clean */
    [data-animate="fade-up"] { opacity: 0; transform: translateY(10px); transition: .6s ease; }
    .animate-in { opacity: 1 !important; transform: translateY(0) !important; }
</style>
</body>
</html>