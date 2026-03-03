<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GED') }} — Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:300,400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-slate-50 text-slate-900">
<div class="min-h-screen flex">

    {{-- Mobile backdrop --}}
    <div id="sidebarBackdrop"
         class="fixed inset-0 bg-slate-950/40 backdrop-blur-sm z-40 hidden lg:hidden"
         aria-hidden="true"></div>

    {{-- Sidebar (Desktop + Mobile drawer) --}}
    <aside id="sidebar"
           class="fixed lg:static inset-y-0 left-0 z-50 w-[18.5rem] bg-white border-r border-slate-200
                  -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-out
                  flex flex-col">

        {{-- Brand --}}
        <div class="h-16 flex items-center justify-between px-5 border-b border-slate-200">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
                <div class="h-10 w-10 rounded-2xl bg-indigo-600 text-white grid place-items-center font-extrabold shadow-sm">
                    G
                </div>
                <div>
                    <div class="text-sm font-extrabold leading-4 text-slate-900 group-hover:text-indigo-700 transition">
                        GED Administration
                    </div>
                    <div class="text-xs text-slate-500">Zone administrateur</div>
                </div>
            </a>

            <button id="closeSidebar"
                    class="lg:hidden h-10 w-10 rounded-xl hover:bg-slate-100 grid place-items-center text-slate-600">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        {{-- Nav --}}
        <nav class="p-4 space-y-2">
            <a href="{{ route('admin.dashboard') }}"
               class="nav-link {{ request()->routeIs('admin.dashboard') ? 'nav-active' : '' }}">
                <i class="fa-solid fa-gauge-high"></i>
                <span>Dashboard</span>
            </a>

            <div class="pt-3 pb-1 text-[11px] uppercase tracking-wider text-slate-400 px-3">
                Gestion
            </div>

            <a href="{{ route('admin.services.index') }}"
               class="nav-link {{ request()->routeIs('admin.services.*') ? 'nav-active' : '' }}">
                <i class="fa-solid fa-building"></i>
                <span>Services</span>
            </a>

            <a href="{{ route('admin.folders.index') }}"
               class="nav-link {{ request()->routeIs('admin.folders.*') ? 'nav-active' : '' }}">
                <i class="fa-solid fa-folder-tree"></i>
                <span>Dossiers</span>
            </a>

            <a href="{{ route('admin.documents.index') }}"
               class="nav-link {{ request()->routeIs('admin.documents.*') ? 'nav-active' : '' }}">
                <i class="fa-solid fa-file-lines"></i>
                <span>Documents</span>
            </a>

            <a href="{{ route('admin.workflow.validation') }}"
               class="nav-link {{ request()->routeIs('admin.workflow.*') ? 'nav-active' : '' }}">
                <i class="fa-solid fa-circle-check"></i>
                <span>Validation</span>
                @isset($draftDocs)
                    <span class="ml-auto text-xs px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                        {{ $draftDocs }}
                    </span>
                @endisset
            </a>

            <a href="{{ route('admin.users.index') }}"
               class="nav-link {{ request()->routeIs('admin.users.*') ? 'nav-active' : '' }}">
                <i class="fa-solid fa-users"></i>
                <span>Utilisateurs</span>
            </a>

            <a href="{{ route('admin.audit.index') }}"
               class="nav-link {{ request()->routeIs('admin.audit.*') ? 'nav-active' : '' }}">
                <i class="fa-solid fa-receipt"></i>
                <span>Historique</span>
            </a>

            <div class="pt-3 pb-1 text-[11px] uppercase tracking-wider text-slate-400 px-3">
                Compte
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full nav-link text-left hover:bg-rose-50 hover:text-rose-700">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Se déconnecter</span>
                </button>
            </form>
        </nav>

        {{-- Footer user --}}
        <div class="mt-auto p-4 border-t border-slate-200">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-2xl bg-slate-900 text-white grid place-items-center font-bold">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <div class="text-sm font-semibold truncate">{{ auth()->user()->name }}</div>
                    <div class="text-xs text-slate-500 truncate">{{ auth()->user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 text-xs text-slate-500 flex items-center gap-2">
                <i class="fa-solid fa-shield-halved text-emerald-600"></i>
                <span>Accès : Admin</span>
            </div>
        </div>
    </aside>

    {{-- Main --}}
    <div class="flex-1 flex flex-col min-w-0">

        {{-- Topbar --}}
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 lg:px-8">
            <div class="flex items-center gap-3 min-w-0">
                <button id="openSidebar"
                        class="lg:hidden h-10 w-10 rounded-xl hover:bg-slate-100 grid place-items-center text-slate-700">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <div class="min-w-0">
                    <div class="text-sm font-extrabold text-slate-900 truncate">
                        {{ $title ?? 'Admin' }}
                    </div>
                    <div class="text-xs text-slate-500 truncate">
                        {{ $subtitle ?? 'Gestion électronique des documents' }}
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-2">

                {{-- Profile chip --}}
                <div class="hidden sm:flex items-center gap-2 px-3 py-2 rounded-2xl bg-slate-50 border border-slate-200">
                    <i class="fa-regular fa-user text-slate-500"></i>
                    <span class="text-sm font-semibold text-slate-800">{{ auth()->user()->name }}</span>
                </div>
            </div>
        </header>

        {{-- Content --}}
        <main class="p-4 lg:p-8">
            @if(session('success'))
                <div class="mb-4 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800 flex items-start gap-3">
                    <i class="fa-solid fa-circle-check mt-0.5"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-rose-800">
                    <div class="font-semibold mb-1 flex items-center gap-2">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        Erreurs :
                    </div>
                    <ul class="list-disc pl-5 text-sm">
                        @foreach($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{ $slot }}
        </main>
    </div>
</div>

{{-- Styles (petit, sans casser Tailwind) --}}
<style>
    .nav-link{
        display:flex; align-items:center; gap:.75rem;
        padding:.65rem .8rem;
        border-radius: 1rem;
        color: rgb(51 65 85);
        transition: background .2s ease, color .2s ease, transform .2s ease;
        border: 1px solid transparent;
        font-weight: 600;
        font-size: .92rem;
    }
    .nav-link i{ width: 1.1rem; text-align:center; color: rgb(100 116 139); }
    .nav-link:hover{
        background: rgb(248 250 252);
        transform: translateY(-1px);
        border-color: rgb(226 232 240);
    }
    .nav-active{
        background: rgb(238 242 255);
        border-color: rgb(199 210 254);
        color: rgb(30 64 175);
    }
    .nav-active i{
        color: rgb(67 56 202);
    }
</style>

{{-- JS Sidebar mobile --}}
<script>
    const sidebar = document.getElementById('sidebar');
    const backdrop = document.getElementById('sidebarBackdrop');
    const openBtn = document.getElementById('openSidebar');
    const closeBtn = document.getElementById('closeSidebar');

    function openSidebar(){
        sidebar.classList.remove('-translate-x-full');
        backdrop.classList.remove('hidden');
    }
    function closeSidebar(){
        sidebar.classList.add('-translate-x-full');
        backdrop.classList.add('hidden');
    }

    if(openBtn) openBtn.addEventListener('click', openSidebar);
    if(closeBtn) closeBtn.addEventListener('click', closeSidebar);
    if(backdrop) backdrop.addEventListener('click', closeSidebar);

    // ESC close
    window.addEventListener('keydown', (e) => {
        if(e.key === 'Escape') closeSidebar();
    });
</script>

</body>
</html>