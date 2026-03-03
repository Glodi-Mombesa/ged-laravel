<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>GED Administration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">
</head>

<body class="font-[Inter] bg-slate-950 text-white overflow-x-hidden">

{{-- ================= DECOR BACKGROUND (blobs + grid) ================= --}}
<div aria-hidden="true" class="pointer-events-none fixed inset-0 -z-10">
    <div class="absolute -top-24 -left-24 h-80 w-80 rounded-full bg-indigo-600/25 blur-3xl floating"></div>
    <div class="absolute top-1/4 -right-24 h-96 w-96 rounded-full bg-fuchsia-500/20 blur-3xl floating2"></div>
    <div class="absolute bottom-0 left-1/3 h-96 w-96 rounded-full bg-cyan-400/10 blur-3xl floating3"></div>

    <div class="absolute inset-0 opacity-[0.08]"
         style="background-image: radial-gradient(circle at 1px 1px, rgb(255 255 255 / 1) 1px, transparent 0);
                background-size: 28px 28px;">
    </div>
</div>

<!-- ================= NAVBAR ================= -->
<nav id="navbar" class="fixed w-full z-50 transition duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4 flex justify-between items-center gap-3">
        <a href="{{ route('welcome') }}" class="flex items-center gap-3 group min-w-0">
            <span class="h-10 w-10 rounded-2xl bg-indigo-600/20 border border-indigo-400/20 grid place-items-center shadow-lg shadow-indigo-600/10 shrink-0">
                <i class="fa-solid fa-folder-open text-indigo-300 text-xl group-hover:scale-110 transition"></i>
            </span>
            <div class="leading-tight min-w-0">
                <div class="font-extrabold tracking-tight text-white truncate">GED Administration</div>
                <div class="text-xs text-slate-400 truncate">Gestion électronique des documents</div>
            </div>
        </a>

        {{-- Bouton intelligent --}}
        <div class="flex items-center gap-2 shrink-0">
            @auth
                @php
                    $u = auth()->user();
                    $isAdmin = $u && method_exists($u,'hasRole') && $u->hasRole('admin');
                    $target = $isAdmin
                        ? (Route::has('admin.dashboard') ? route('admin.dashboard') : url('/admin'))
                        : (Route::has('user.home') ? route('user.home') : url('/user'));
                    $label = $isAdmin ? 'Espace admin' : 'Mon espace';
                    $icon  = $isAdmin ? 'fa-shield-halved' : 'fa-house';
                @endphp

                <a href="{{ $target }}"
                   class="hidden sm:inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 transition shadow-lg shadow-indigo-600/20">
                    <i class="fa-solid {{ $icon }}"></i>
                    <span class="font-semibold">{{ $label }}</span>
                </a>

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-white/10 bg-white/5 hover:bg-white/10 transition">
                        <i class="fa-solid fa-right-from-bracket text-slate-200"></i>
                        <span class="font-semibold text-slate-100 hidden sm:inline">Déconnexion</span>
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 transition shadow-lg shadow-indigo-600/20">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    <span class="font-semibold">Connexion</span>
                </a>
            @endauth
        </div>
    </div>
</nav>

<!-- ================= HERO ================= -->
<header class="relative min-h-screen flex items-center">
    <img src="https://images.pexels.com/photos/3182764/pexels-photo-3182764.jpeg"
         class="absolute inset-0 w-full h-full object-cover opacity-25 scale-110"
         id="parallax-bg" alt="hero"/>

    <div class="absolute inset-0 bg-gradient-to-b from-slate-950/85 via-slate-950/75 to-slate-950"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 pt-24 sm:pt-28 pb-14 sm:pb-16 grid lg:grid-cols-2 gap-10 lg:gap-12 items-center">
        <div class="reveal">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full border border-white/10 bg-white/5 text-slate-200 text-xs sm:text-sm">
                <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                Plateforme GED • Moderne • Sécurisée
            </div>

            <h1 class="mt-5 text-4xl sm:text-5xl xl:text-6xl font-extrabold leading-tight tracking-tight">
                Centralisez, organisez et
                <span class="text-indigo-300 glow">sécurisez</span>
                vos documents
            </h1>

            <p class="mt-5 text-base sm:text-lg text-slate-300 max-w-xl">
                Une solution claire et professionnelle pour gérer les documents de l’entreprise :
                classement par services/dossiers, recherche rapide, preview PDF et téléchargement.
            </p>

            <div class="mt-8 flex flex-col sm:flex-row gap-3">
                @auth
                    @php
                        $u = auth()->user();
                        $isAdmin = $u && method_exists($u,'hasRole') && $u->hasRole('admin');
                        $target = $isAdmin
                            ? (Route::has('admin.dashboard') ? route('admin.dashboard') : url('/admin'))
                            : (Route::has('user.home') ? route('user.home') : url('/user'));
                        $label = $isAdmin ? 'Aller au dashboard admin' : 'Entrer dans mon espace';
                    @endphp

                    <a href="{{ $target }}"
                       class="inline-flex justify-center items-center gap-2 px-6 py-3 rounded-2xl bg-indigo-600 hover:bg-indigo-700 font-semibold shadow-xl shadow-indigo-600/25 hover:scale-[1.02] transition">
                        <i class="fa-solid fa-arrow-right"></i>
                        {{ $label }}
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="inline-flex justify-center items-center gap-2 px-6 py-3 rounded-2xl bg-indigo-600 hover:bg-indigo-700 font-semibold shadow-xl shadow-indigo-600/25 hover:scale-[1.02] transition">
                        <i class="fa-solid fa-arrow-right"></i>
                        Accéder à la plateforme
                    </a>
                @endauth

                <a href="#features"
                   class="inline-flex justify-center items-center gap-2 px-6 py-3 rounded-2xl border border-white/10 bg-white/5 hover:bg-white/10 font-semibold transition">
                    <i class="fa-regular fa-circle-play"></i>
                    Découvrir
                </a>
            </div>

            <!-- ✅ responsive: 1 col (xs) -> 2 cols (sm) -> 3 cols (lg) -->
            <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 max-w-xl">
                <div class="stat-card reveal">
                    <div class="text-xs text-slate-400">Workflow</div>
                    <div class="text-base sm:text-lg font-extrabold">Brouillon → Validé</div>
                </div>
                <div class="stat-card reveal">
                    <div class="text-xs text-slate-400">Formats</div>
                    <div class="text-base sm:text-lg font-extrabold">PDF • DOCX • XLSX</div>
                </div>
                <div class="stat-card reveal">
                    <div class="text-xs text-slate-400">Accès</div>
                    <div class="text-base sm:text-lg font-extrabold">Rôles & traçabilité</div>
                </div>
            </div>
        </div>

        {{-- Mockup --}}
        <div class="reveal">
            <div class="relative rounded-3xl border border-white/10 bg-white/5 p-4 sm:p-5 shadow-2xl shadow-indigo-600/10 overflow-hidden">
                <div class="absolute -top-10 -right-10 h-40 w-40 rounded-full bg-indigo-500/20 blur-3xl"></div>

                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2 text-slate-200">
                        <span class="h-3 w-3 rounded-full bg-rose-400/80"></span>
                        <span class="h-3 w-3 rounded-full bg-amber-400/80"></span>
                        <span class="h-3 w-3 rounded-full bg-emerald-400/80"></span>
                    </div>
                    <div class="text-xs text-slate-400">Aperçu interface</div>
                </div>

                <div class="rounded-2xl bg-slate-950/60 border border-white/10 p-3 sm:p-4">
                    <div class="flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <span class="h-10 w-10 rounded-2xl bg-indigo-600/20 grid place-items-center shrink-0">
                                <i class="fa-solid fa-file-lines text-indigo-200"></i>
                            </span>
                            <div class="min-w-0">
                                <div class="font-bold truncate">Documents de l’entreprise</div>
                                <div class="text-xs text-slate-400 truncate">Recherche + filtres + preview PDF</div>
                            </div>
                        </div>
                        <div class="hidden sm:inline-flex px-3 py-2 rounded-xl bg-indigo-600/20 border border-indigo-400/20 text-sm font-semibold shrink-0">
                            <i class="fa-solid fa-magnifying-glass mr-2"></i>Rechercher
                        </div>
                    </div>

                    <div class="mt-4 space-y-3">
                        <div class="mock-row">
                            <i class="fa-solid fa-file-pdf text-rose-300"></i>
                            <div class="min-w-0">
                                <div class="font-semibold truncate">Procédure interne - Validation</div>
                                <div class="text-xs text-slate-400 truncate">Service RH • PDF • Validé</div>
                            </div>
                            <span class="badge badge-ok">Preview</span>
                        </div>

                        <div class="mock-row">
                            <i class="fa-solid fa-file-excel text-emerald-300"></i>
                            <div class="min-w-0">
                                <div class="font-semibold truncate">Tableau suivi</div>
                                <div class="text-xs text-slate-400 truncate">Finance • XLSX • Validé</div>
                            </div>
                            <span class="badge badge-dl">Télécharger</span>
                        </div>

                        <div class="mock-row">
                            <i class="fa-solid fa-file-word text-sky-300"></i>
                            <div class="min-w-0">
                                <div class="font-semibold truncate">Note de service</div>
                                <div class="text-xs text-slate-400 truncate">Secrétariat • DOCX • Validé</div>
                            </div>
                            <span class="badge badge-dl">Télécharger</span>
                        </div>
                    </div>
                </div>

                <div class="mt-4 text-xs text-slate-400">
                    * Les utilisateurs consultent uniquement les documents “validés” publiés par l’administration.
                </div>
            </div>
        </div>
    </div>
</header>

<!-- ================= FEATURES ================= -->
<section id="features" class="py-20 sm:py-24 bg-slate-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="text-center reveal">
            <h2 class="text-3xl sm:text-4xl font-extrabold">Une GED simple, pro et efficace</h2>
            <p class="mt-3 text-slate-400 max-w-2xl mx-auto">
                L’admin publie les documents de l’entreprise. Les utilisateurs recherchent, prévisualisent (PDF) et téléchargent.
            </p>
        </div>

        <div class="mt-12 grid md:grid-cols-3 gap-6">
            <div class="feature-card reveal">
                <div class="icon-bubble">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <h3 class="text-lg font-bold mt-4">Sécurité & rôles</h3>
                <p class="text-slate-400 mt-2">
                    Accès contrôlé : admin pour gérer, user pour consulter.
                </p>
            </div>

            <div class="feature-card reveal">
                <div class="icon-bubble">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <h3 class="text-lg font-bold mt-4">Recherche rapide</h3>
                <p class="text-slate-400 mt-2">
                    Trouve un document par titre, référence, service ou dossier.
                </p>
            </div>

            <div class="feature-card reveal">
                <div class="icon-bubble">
                    <i class="fa-solid fa-file-circle-check"></i>
                </div>
                <h3 class="text-lg font-bold mt-4">Workflow</h3>
                <p class="text-slate-400 mt-2">
                    Brouillon → Validé → Archivé, avec traçabilité.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- ================= HOW IT WORKS ================= -->
<section class="py-20 sm:py-24 bg-slate-900/40 border-y border-white/5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 grid lg:grid-cols-2 gap-10 lg:gap-12 items-center">

        <div class="reveal">
            <div class="rounded-3xl overflow-hidden border border-white/10 shadow-2xl shadow-black/30">
                <img src="https://images.pexels.com/photos/3183150/pexels-photo-3183150.jpeg"
                     class="w-full h-[280px] sm:h-[360px] object-cover hover:scale-105 transition duration-700" alt="how"/>
            </div>
        </div>

        <div class="reveal">
            <h2 class="text-3xl sm:text-4xl font-extrabold mb-6">Comment ça marche ?</h2>

            <div class="space-y-5 text-slate-300">
                <div class="step">
                    <span class="step-num">1</span>
                    <div>
                        <div class="font-bold">Admin structure</div>
                        <div class="text-slate-400 text-sm">Services, dossiers et publication des documents.</div>
                    </div>
                </div>

                <div class="step">
                    <span class="step-num">2</span>
                    <div>
                        <div class="font-bold">Validation</div>
                        <div class="text-slate-400 text-sm">Seuls les documents “validés” sont visibles côté user.</div>
                    </div>
                </div>

                <div class="step">
                    <span class="step-num">3</span>
                    <div>
                        <div class="font-bold">Consultation</div>
                        <div class="text-slate-400 text-sm">Recherche, filtres, preview PDF et téléchargement.</div>
                    </div>
                </div>

                <div class="step">
                    <span class="step-num">4</span>
                    <div>
                        <div class="font-bold">Traçabilité</div>
                        <div class="text-slate-400 text-sm">Audit pour garder un historique des actions.</div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- ================= CTA ================= -->
<section class="py-16 sm:py-20 bg-slate-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="rounded-3xl border border-white/10 bg-gradient-to-r from-indigo-600/20 via-white/5 to-fuchsia-500/10 p-6 sm:p-10 overflow-hidden relative reveal">
            <div class="absolute -right-10 -bottom-10 h-56 w-56 rounded-full bg-indigo-500/20 blur-3xl"></div>

            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                <div>
                    <h3 class="text-2xl sm:text-3xl font-extrabold">Prêt à utiliser la GED ?</h3>
                    <p class="text-slate-300 mt-2">
                        Connecte-toi pour accéder à ton espace (admin ou user).
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                    @auth
                        @php
                            $u = auth()->user();
                            $isAdmin = $u && method_exists($u,'hasRole') && $u->hasRole('admin');
                            $target = $isAdmin
                                ? (Route::has('admin.dashboard') ? route('admin.dashboard') : url('/admin'))
                                : (Route::has('user.home') ? route('user.home') : url('/user'));
                            $label = $isAdmin ? 'Ouvrir Admin' : 'Ouvrir mon espace';
                        @endphp
                        <a href="{{ $target }}"
                           class="w-full sm:w-auto inline-flex justify-center items-center gap-2 px-6 py-3 rounded-2xl bg-indigo-600 hover:bg-indigo-700 font-semibold shadow-xl shadow-indigo-600/25 transition hover:scale-[1.02]">
                            <i class="fa-solid fa-arrow-right"></i> {{ $label }}
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="w-full sm:w-auto inline-flex justify-center items-center gap-2 px-6 py-3 rounded-2xl bg-indigo-600 hover:bg-indigo-700 font-semibold shadow-xl shadow-indigo-600/25 transition hover:scale-[1.02]">
                            <i class="fa-solid fa-right-to-bracket"></i> Connexion
                        </a>
                    @endauth

                    <a href="#features"
                       class="w-full sm:w-auto inline-flex justify-center items-center gap-2 px-6 py-3 rounded-2xl border border-white/10 bg-white/5 hover:bg-white/10 font-semibold transition">
                        <i class="fa-solid fa-sparkles"></i> Voir les fonctionnalités
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ================= FOOTER ================= -->
<footer class="py-10 bg-slate-950 text-center text-slate-500 text-sm border-t border-white/5">
    © {{ date('Y') }} GED Administration — Projet académique
</footer>

<!-- ================= STYLES ================= -->
<style>
    .glow { text-shadow: 0 0 24px rgba(129,140,248,.25); }

    .feature-card{
        background: rgba(255,255,255,.04);
        border: 1px solid rgba(255,255,255,.08);
        border-radius: 1.5rem;
        padding: 2rem;
        transition: .35s;
        box-shadow: 0 20px 60px rgba(0,0,0,.25);
    }
    .feature-card:hover{
        transform: translateY(-10px);
        background: rgba(255,255,255,.06);
        border-color: rgba(129,140,248,.35);
        box-shadow: 0 30px 80px rgba(79,70,229,.15);
    }

    .icon-bubble{
        height: 3rem; width: 3rem;
        border-radius: 1.25rem;
        display: grid; place-items: center;
        background: rgba(79,70,229,.18);
        border: 1px solid rgba(129,140,248,.25);
        color: #c7d2fe;
    }

    .stat-card{
        border: 1px solid rgba(255,255,255,.08);
        background: rgba(255,255,255,.04);
        border-radius: 1.25rem;
        padding: .9rem 1rem;
        transition: .35s;
    }
    .stat-card:hover{ transform: translateY(-4px); border-color: rgba(129,140,248,.35); }

    .mock-row{
        display:flex; align-items:center; gap:.75rem;
        padding:.75rem .9rem;
        border-radius: 1rem;
        border: 1px solid rgba(255,255,255,.08);
        background: rgba(255,255,255,.03);
        transition:.25s;
        flex-wrap: wrap; /* ✅ important pour mobile */
    }
    .mock-row:hover{ transform: translateX(4px); background: rgba(255,255,255,.05); border-color: rgba(129,140,248,.25); }

    .badge{
        padding:.25rem .6rem;
        border-radius: .9rem;
        font-size:.75rem;
        font-weight:700;
        border:1px solid rgba(255,255,255,.10);
        white-space:nowrap;
        margin-left:auto; /* ✅ pousse le badge à droite */
        flex: 0 0 auto;
    }
    .badge-ok{ background: rgba(16,185,129,.12); color:#a7f3d0; border-color: rgba(16,185,129,.25); }
    .badge-dl{ background: rgba(99,102,241,.12); color:#c7d2fe; border-color: rgba(129,140,248,.25); }

    .step{
        display:flex; gap:1rem; align-items:flex-start;
        padding: 1rem;
        border-radius: 1.25rem;
        border: 1px solid rgba(255,255,255,.08);
        background: rgba(255,255,255,.03);
        transition:.35s;
    }
    .step:hover{ transform: translateY(-6px); border-color: rgba(129,140,248,.25); background: rgba(255,255,255,.05); }

    .step-num{
        height:2.2rem; width:2.2rem;
        border-radius: 1rem;
        display:grid; place-items:center;
        background: rgba(79,70,229,.18);
        border: 1px solid rgba(129,140,248,.25);
        font-weight:800;
        color:#c7d2fe;
        flex: 0 0 auto;
    }

    .reveal{ opacity:0; transform: translateY(34px); transition: all .9s ease; }
    .reveal.active{ opacity:1; transform: translateY(0); }

    @keyframes floaty { 0%,100%{ transform: translateY(0)} 50%{ transform: translateY(-16px)} }
    @keyframes floaty2 { 0%,100%{ transform: translateY(0)} 50%{ transform: translateY(-24px)} }
    @keyframes floaty3 { 0%,100%{ transform: translateY(0)} 50%{ transform: translateY(-20px)} }

    .floating{ animation: floaty 6s ease-in-out infinite; }
    .floating2{ animation: floaty2 8s ease-in-out infinite; }
    .floating3{ animation: floaty3 7s ease-in-out infinite; }

    /* ✅ Responsive fix (mets ça ici, en bas du <style>) */
    @media (max-width: 420px){
        .feature-card{ padding: 1.25rem; border-radius: 1.25rem; }
        .stat-card{ padding: .75rem .85rem; }
        .mock-row{ padding: .65rem .75rem; }
        .badge{ font-size: .70rem; padding: .22rem .5rem; }
        .icon-bubble{ height: 2.6rem; width: 2.6rem; border-radius: 1.1rem; }
    }
</style>

<!-- ================= JS ================= -->
<script>
    // Navbar effect
    window.addEventListener('scroll', () => {
        const nav = document.getElementById('navbar');
        if (window.scrollY > 50) {
            nav.classList.add('bg-slate-950/70', 'backdrop-blur', 'shadow-lg');
        } else {
            nav.classList.remove('bg-slate-950/70', 'backdrop-blur', 'shadow-lg');
        }
    });

    // Reveal (IntersectionObserver = plus propre que scroll)
    const reveals = document.querySelectorAll('.reveal');
    const io = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) e.target.classList.add('active');
        });
    }, { threshold: 0.12 });
    reveals.forEach(el => io.observe(el));

    // Parallax léger
    window.addEventListener("scroll", function () {
        const bg = document.getElementById("parallax-bg");
        if (!bg) return;
        bg.style.transform = "translateY(" + (window.scrollY * 0.15) + "px) scale(1.10)";
    });
</script>

</body>
</html>