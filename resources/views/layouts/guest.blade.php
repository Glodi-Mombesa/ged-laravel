<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GED') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:300,400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Font Awesome (icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-slate-900">
    <!-- Background -->
    <div class="min-h-screen relative overflow-hidden bg-slate-950">
        <!-- blobs -->
        <div class="pointer-events-none absolute -top-24 -left-24 h-80 w-80 rounded-full bg-indigo-600/30 blur-3xl"></div>
        <div class="pointer-events-none absolute top-1/3 -right-24 h-96 w-96 rounded-full bg-sky-500/20 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-24 left-1/3 h-96 w-96 rounded-full bg-purple-500/20 blur-3xl"></div>

        <!-- Center -->
        <div class="relative min-h-screen flex items-center justify-center px-4 py-10">
            <div class="w-full max-w-5xl grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                <!-- Left branding -->
                <div class="text-white hidden lg:block">
                    <div class="inline-flex items-center gap-3">
                        <div class="h-12 w-12 rounded-2xl bg-white/10 grid place-items-center border border-white/10">
                            <i class="fa-solid fa-folder-open text-xl"></i>
                        </div>
                        <div>
                            <div class="text-xl font-bold tracking-tight">GED Administration</div>
                            <div class="text-white/70 text-sm">Gestion électronique des documents</div>
                        </div>
                    </div>

                    <h1 class="mt-10 text-4xl font-extrabold leading-tight">
                        Une GED moderne, claire<br>
                        <span class="text-indigo-300"> pour la gestion</span> des vos documents
                    </h1>
                    <p class="mt-4 text-white/75 max-w-md">
                        Centralise les documents, organise par services et dossiers,
                        contrôle les validations et garde un historique (audit).
                    </p>

                    <div class="mt-8 grid grid-cols-1 gap-3 max-w-md">
                        <div class="flex items-center gap-3 rounded-2xl bg-white/5 border border-white/10 px-4 py-3">
                            <i class="fa-solid fa-shield-halved text-indigo-300"></i>
                            <div class="text-sm">
                                <div class="font-semibold">Sécurisé</div>
                                <div class="text-white/70">Accès par rôle et traçabilité</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 rounded-2xl bg-white/5 border border-white/10 px-4 py-3">
                            <i class="fa-solid fa-magnifying-glass text-indigo-300"></i>
                            <div class="text-sm">
                                <div class="font-semibold">Rapide</div>
                                <div class="text-white/70">Recherche & workflow clair</div>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('welcome') }}"
                    class="inline-flex items-center gap-2 mt-10 text-white/80 hover:text-white transition">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>Retour à l’accueil</span>
                    </a>
                </div>

                <!-- Right card -->
                <div class="w-full">
                    <div class="fade-in-up bg-white/95 backdrop-blur rounded-3xl shadow-2xl border border-white/30 p-6 sm:p-8">
                        <!-- top mini brand (mobile) -->
                        <div class="flex items-center gap-3 lg:hidden mb-6">
                            <div class="h-11 w-11 rounded-2xl bg-indigo-600 text-white grid place-items-center">
                                <i class="fa-solid fa-folder-open"></i>
                            </div>
                            <div>
                                <div class="font-bold leading-tight">GED Administration</div>
                                <div class="text-slate-500 text-sm">Zone Authentification</div>
                            </div>
                        </div>

                        {{ $slot }}

                        <div class="mt-6 text-center text-xs text-slate-500">
                            © {{ date('Y') }} GED — Projet académique
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- small helper: fade animation -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.fade-in-up').forEach(el => el.classList.add('is-visible'));
        });
    </script>
</body>
</html>