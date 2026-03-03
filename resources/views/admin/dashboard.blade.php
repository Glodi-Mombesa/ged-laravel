<x-admin-layout title="Dashboard">
    {{-- Header --}}
    <div class="mb-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900">
                    <i class="fa-solid fa-gauge-high text-indigo-600 mr-2"></i>
                    Dashboard GED
                </h1>
                <p class="text-slate-600 mt-1">Vue globale : documents, validation et activité.</p>
            </div>

            <div class="flex flex-col sm:flex-row gap-2 sm:items-center">
                {{-- Search --}}
                <form action="{{ route('admin.search.index') }}" method="GET"
                      class="flex items-center gap-2 bg-white border border-slate-200 rounded-2xl px-3 py-2 shadow-sm">
                    <i class="fa-solid fa-magnifying-glass text-slate-400"></i>
                    <input name="q"
                           placeholder="Recherche globale (titre, ref, service, dossier...)"
                           class="w-72 max-w-full border-0 focus:ring-0 text-sm text-slate-700 placeholder:text-slate-400">
                    <button class="px-3 py-2 rounded-xl bg-slate-900 text-white text-sm font-semibold hover:bg-slate-800 transition">
                        Rechercher
                    </button>
                </form>

                {{-- CTA buttons --}}
                <div class="flex gap-2">
                    <a href="{{ route('admin.workflow.validation') }}"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-emerald-600 text-white font-semibold shadow hover:bg-emerald-700 transition">
                        <i class="fa-solid fa-circle-check"></i>
                        Validation
                        <span class="ml-1 inline-flex items-center justify-center px-2 py-0.5 rounded-full bg-white/15 text-xs">
                            {{ $draftDocs }}
                        </span>
                    </a>

                    <a href="{{ route('admin.documents.create') }}"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-indigo-600 text-white font-semibold shadow hover:bg-indigo-700 transition">
                        <i class="fa-solid fa-plus"></i>
                        Nouveau
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- KPI --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
        {{-- Total --}}
        <div class="kpi-card">
            <div class="kpi-icon bg-indigo-50 text-indigo-700">
                <i class="fa-solid fa-file-lines"></i>
            </div>
            <div class="flex-1">
                <div class="text-sm text-slate-500">Total documents</div>
                <div class="text-3xl font-extrabold text-slate-900 counter" data-target="{{ $totalDocs }}">0</div>
                <div class="text-xs text-slate-500 mt-1">Tous statuts confondus</div>
            </div>
        </div>

        {{-- Draft --}}
        <div class="kpi-card">
            <div class="kpi-icon bg-slate-50 text-slate-700">
                <i class="fa-solid fa-pen-to-square"></i>
            </div>
            <div class="flex-1">
                <div class="text-sm text-slate-500">Brouillons</div>
                <div class="text-3xl font-extrabold text-slate-900 counter" data-target="{{ $draftDocs }}">0</div>
                <div class="text-xs text-slate-500 mt-1">En attente de validation</div>
            </div>
        </div>

        {{-- Validated --}}
        <div class="kpi-card">
            <div class="kpi-icon bg-emerald-50 text-emerald-700">
                <i class="fa-solid fa-check"></i>
            </div>
            <div class="flex-1">
                <div class="text-sm text-slate-500">Validés</div>
                <div class="text-3xl font-extrabold text-slate-900 counter" data-target="{{ $validatedDocs }}">0</div>
                <div class="text-xs text-slate-500 mt-1">Prêts à être consultés</div>
            </div>
        </div>

        {{-- Archived --}}
        <div class="kpi-card">
            <div class="kpi-icon bg-amber-50 text-amber-700">
                <i class="fa-solid fa-box-archive"></i>
            </div>
            <div class="flex-1">
                <div class="text-sm text-slate-500">Archivés</div>
                <div class="text-3xl font-extrabold text-slate-900 counter" data-target="{{ $archivedDocs }}">0</div>
                <div class="text-xs text-slate-500 mt-1">Historique / archives</div>
            </div>
        </div>
    </div>

    {{-- Charts --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-5 xl:col-span-2 fade-in">
            <div class="flex items-center justify-between gap-3 mb-4">
                <div>
                    <div class="font-extrabold text-slate-900">
                        <i class="fa-solid fa-chart-column text-indigo-600 mr-2"></i>
                        Répartition des statuts
                    </div>
                    <div class="text-sm text-slate-600">Brouillons, validés et archivés</div>
                </div>
                <div class="text-xs text-slate-500">
                    Mise à jour : {{ now()->format('d/m/Y H:i') }}
                </div>
            </div>
            <div class="h-72">
                <canvas id="statusChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-5 fade-in">
            <div class="flex items-center justify-between gap-3 mb-4">
                <div>
                    <div class="font-extrabold text-slate-900">
                        <i class="fa-solid fa-chart-line text-emerald-600 mr-2"></i>
                        Activité (7 jours)
                    </div>
                    <div class="text-sm text-slate-600">Tendance (démo) — amélioré après</div>
                </div>
            </div>
            <div class="h-72">
                <canvas id="activityChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Lists --}}
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        {{-- Latest docs --}}
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden fade-in">
            <div class="px-5 py-4 border-b border-slate-200 flex items-center justify-between">
                <div>
                    <div class="font-extrabold text-slate-900">
                        <i class="fa-solid fa-clock text-slate-700 mr-2"></i>
                        Derniers documents
                    </div>
                    <div class="text-sm text-slate-600">Les 8 derniers ajouts</div>
                </div>
                <a href="{{ route('admin.documents.index') }}"
                   class="inline-flex items-center gap-2 px-3 py-2 rounded-2xl border border-slate-200 hover:bg-slate-50 text-sm transition">
                    Voir tout <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($latestDocuments as $doc)
                    <div class="px-5 py-4 flex items-start justify-between gap-4 hover:bg-slate-50 transition">
                        <div class="min-w-0">
                            <div class="flex items-center gap-2">
                                <div class="font-semibold text-slate-900 truncate">{{ $doc->title }}</div>
                                {{-- status badge --}}
                                @php
                                    $badge = [
                                        'draft' => 'bg-slate-100 text-slate-700',
                                        'validated' => 'bg-emerald-100 text-emerald-700',
                                        'archived' => 'bg-amber-100 text-amber-700',
                                    ][$doc->status] ?? 'bg-slate-100 text-slate-700';
                                    $label = [
                                        'draft' => 'Brouillon',
                                        'validated' => 'Validé',
                                        'archived' => 'Archivé',
                                    ][$doc->status] ?? 'Inconnu';
                                @endphp
                                <span class="px-2 py-1 rounded-xl text-xs font-semibold {{ $badge }}">{{ $label }}</span>
                            </div>

                            <div class="text-xs text-slate-500 mt-1">
                                <i class="fa-solid fa-hashtag"></i>
                                {{ $doc->reference ?? '—' }}
                                <span class="mx-2">•</span>
                                <i class="fa-solid fa-building"></i>
                                {{ $doc->service?->name ?? '—' }}
                                <span class="mx-2">•</span>
                                <i class="fa-solid fa-folder"></i>
                                {{ $doc->folder?->name ?? '—' }}
                            </div>

                            <div class="text-xs text-slate-500 mt-1">
                                <i class="fa-regular fa-user"></i>
                                {{ $doc->uploader?->name ?? '—' }}
                                <span class="mx-2">•</span>
                                <i class="fa-regular fa-calendar"></i>
                                {{ $doc->created_at->format('d/m/Y H:i') }}
                            </div>
                        </div>

                        <div class="flex items-center gap-2 shrink-0">
                            <a href="{{ route('admin.documents.download', $doc) }}"
                               class="inline-flex items-center gap-2 px-3 py-2 rounded-2xl border border-slate-200 hover:bg-white text-sm transition">
                                <i class="fa-solid fa-download"></i>
                                Télécharger
                            </a>

                            @if($doc->status === 'draft')
                                <form method="POST" action="{{ route('admin.documents.status', $doc) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="validated">
                                    <button class="inline-flex items-center gap-2 px-3 py-2 rounded-2xl bg-emerald-600 text-white font-semibold hover:bg-emerald-700 text-sm transition">
                                        <i class="fa-solid fa-check"></i>
                                        Valider
                                    </button>
                                </form>
                            @elseif($doc->status === 'validated')
                                <form method="POST" action="{{ route('admin.documents.status', $doc) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="archived">
                                    <button class="inline-flex items-center gap-2 px-3 py-2 rounded-2xl bg-amber-600 text-white font-semibold hover:bg-amber-700 text-sm transition">
                                        <i class="fa-solid fa-box-archive"></i>
                                        Archiver
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="px-5 py-10 text-center text-slate-600">
                        Aucun document.
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Latest audit --}}
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden fade-in">
            <div class="px-5 py-4 border-b border-slate-200 flex items-center justify-between">
                <div>
                    <div class="font-extrabold text-slate-900">
                        <i class="fa-solid fa-receipt text-slate-700 mr-2"></i>
                        Dernières actions
                    </div>
                    <div class="text-sm text-slate-600">Traçabilité récente (audit)</div>
                </div>
                <a href="{{ route('admin.audit.index') }}"
                   class="inline-flex items-center gap-2 px-3 py-2 rounded-2xl border border-slate-200 hover:bg-slate-50 text-sm transition">
                    Historique <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($latestLogs as $log)
                    <div class="px-5 py-4 hover:bg-slate-50 transition">
                        <div class="flex items-center justify-between gap-3">
                            <div class="font-semibold text-slate-900">
                                <span class="inline-flex items-center gap-2">
                                    <i class="fa-solid fa-bolt text-indigo-600"></i>
                                    {{ $log->action }} • {{ $log->entity_type }}
                                </span>
                                <span class="text-slate-500 font-normal">#{{ $log->entity_id ?? '—' }}</span>
                            </div>
                            <div class="text-xs text-slate-500">
                                <i class="fa-regular fa-clock"></i>
                                {{ $log->created_at->format('d/m/Y H:i') }}
                            </div>
                        </div>

                        <div class="text-sm text-slate-600 mt-1">
                            Par : <span class="font-medium text-slate-900">{{ $log->user?->name ?? '—' }}</span>
                            <span class="text-slate-500">({{ $log->user?->email ?? '' }})</span>
                        </div>

                        <div class="text-xs text-slate-500 mt-1">
                            Route: {{ $log->route ?? '—' }} • IP: {{ $log->ip ?? '—' }}
                        </div>
                    </div>
                @empty
                    <div class="px-5 py-10 text-center text-slate-600">
                        Aucun log.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // --- Counter animation ---
        document.querySelectorAll('.counter').forEach(el => {
            const target = Number(el.dataset.target || 0);
            const duration = 800;
            const start = performance.now();

            const tick = (now) => {
                const p = Math.min((now - start) / duration, 1);
                el.textContent = Math.round(target * p).toLocaleString('fr-FR');
                if (p < 1) requestAnimationFrame(tick);
            };
            requestAnimationFrame(tick);
        });

        // --- Fade-in ---
        document.querySelectorAll('.fade-in').forEach((el, i) => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(12px)';
            el.style.transition = 'opacity .5s ease, transform .5s ease';
            setTimeout(() => {
                el.style.opacity = '1';
                el.style.transform = 'translateY(0)';
            }, 80 + i * 80);
        });

        // --- Status chart ---
        const statusCtx = document.getElementById('statusChart');
        if (statusCtx) {
            new Chart(statusCtx, {
                type: 'bar',
                data: {
                    labels: ['Brouillons', 'Validés', 'Archivés'],
                    datasets: [{
                        label: 'Documents',
                        data: [{{ (int)$draftDocs }}, {{ (int)$validatedDocs }}, {{ (int)$archivedDocs }}],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: { enabled: true }
                    },
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        }

        // --- Activity chart (démo) ---
        const actCtx = document.getElementById('activityChart');
        if (actCtx) {
            const labels = ['J-6','J-5','J-4','J-3','J-2','J-1','Aujourd’hui'];

            // Demo data : on part de totalDocs (évite d’avoir un graphique vide).
            const base = {{ (int)$totalDocs }};
            const demo = [0,1,2,3,2,4,3].map(v => Math.max(0, Math.round(base/50) + v));

            new Chart(actCtx, {
                type: 'line',
                data: {
                    labels,
                    datasets: [{
                        label: 'Actions',
                        data: demo,
                        tension: 0.35,
                        fill: true,
                        borderWidth: 2,
                        pointRadius: 3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        }
    </script>

    {{-- small page styles --}}
    <style>
        .kpi-card{
            display:flex; gap:16px; align-items:flex-start;
            background:#fff; border:1px solid rgb(226 232 240);
            border-radius:24px; padding:20px;
            box-shadow: 0 1px 2px rgba(15,23,42,.06);
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .kpi-card:hover{
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(15,23,42,.08);
        }
        .kpi-icon{
            height:44px; width:44px; border-radius:16px;
            display:grid; place-items:center;
        }
    </style>
</x-admin-layout>