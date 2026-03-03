<x-user-layout title="Accueil" subtitle="Consulte les documents validés de l’entreprise, en toute simplicité.">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Carte principale --}}
        <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-200 shadow-sm p-6 relative overflow-hidden">
            <div class="absolute -top-24 -right-24 h-60 w-60 rounded-full bg-indigo-100 blur-2xl"></div>

            <div class="flex items-start justify-between gap-4 relative">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-2xl bg-indigo-50 text-indigo-700 border border-indigo-200 text-sm font-semibold">
                        <i class="fa-solid fa-shield-halved"></i>
                        Espace utilisateur
                    </div>

                    <h2 class="mt-3 text-2xl font-extrabold text-slate-900">
                        Bienvenue, {{ auth()->user()->name }} 👋
                    </h2>
                    <p class="text-slate-600 mt-1 max-w-xl">
                        Ici tu peux <b>rechercher</b>, <b>prévisualiser (PDF)</b> et <b>télécharger</b> les documents
                        validés publiés par l’entreprise.
                    </p>

                    <div class="mt-5 flex flex-wrap gap-2">
                        <a href="{{ route('user.documents.index') }}"
                           class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-slate-900 text-white font-semibold hover:bg-slate-800 transition">
                            <i class="fa-solid fa-folder-open"></i>
                            Parcourir les documents
                        </a>
                        <a href="{{ route('welcome') }}"
                           class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl border border-slate-200 hover:bg-slate-50 font-semibold transition">
                            <i class="fa-solid fa-house"></i>
                            Retour au site
                        </a>
                    </div>
                </div>

                <div class="hidden md:flex flex-col items-end gap-2 relative">
                    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-4 w-56">
                        <div class="text-sm text-slate-500">Documents disponibles</div>
                        <div class="text-3xl font-extrabold text-slate-900 mt-1">{{ $totalValidated }}</div>
                        <div class="text-xs text-slate-500 mt-1">validés & consultables</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Services --}}
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div class="font-extrabold text-slate-900">
                    <i class="fa-solid fa-building text-indigo-600 mr-2"></i>
                    Services
                </div>
                <span class="text-xs text-slate-500">Organisation</span>
            </div>

            <div class="mt-4 space-y-2 max-h-72 overflow-auto pr-1">
                @forelse($services as $s)
                    <a href="{{ route('user.documents.index', ['service_id' => $s->id]) }}"
                       class="flex items-center justify-between gap-3 px-3 py-2 rounded-2xl border border-slate-200 hover:bg-slate-50 transition">
                        <div class="min-w-0">
                            <div class="font-semibold text-slate-900 truncate">{{ $s->name }}</div>
                            <div class="text-xs text-slate-500">Code : {{ $s->code }}</div>
                        </div>
                        <i class="fa-solid fa-chevron-right text-slate-400"></i>
                    </a>
                @empty
                    <div class="text-slate-600">Aucun service.</div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Derniers documents --}}
    <div class="mt-6 bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
            <div>
                <div class="font-extrabold text-slate-900">
                    <i class="fa-solid fa-clock text-indigo-600 mr-2"></i>
                    Derniers documents
                </div>
                <div class="text-sm text-slate-600">Les derniers ajouts validés</div>
            </div>
            <a href="{{ route('user.documents.index') }}"
               class="inline-flex items-center gap-2 px-3 py-2 rounded-2xl border border-slate-200 hover:bg-slate-50 text-sm font-semibold">
                Voir tout
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse($latestDocuments as $doc)
                @php
                    $mime = strtolower((string)($doc->mime_type ?? ''));
                    $isPdf = str_contains($mime, 'pdf');
                @endphp

                <div class="px-6 py-4 flex items-start justify-between gap-4">
                    <div class="min-w-0">
                        <div class="font-semibold text-slate-900 truncate">
                            {{ $doc->title }}
                        </div>
                        <div class="text-xs text-slate-500 mt-1">
                            {{ $doc->reference ? "Ref: {$doc->reference} • " : "" }}
                            {{ $doc->service?->name ?? '—' }} • {{ $doc->folder?->name ?? '—' }}
                        </div>
                        <div class="text-xs text-slate-500 mt-1">
                            <i class="fa-solid fa-file-lines mr-1"></i>{{ $doc->original_name }}
                        </div>
                    </div>

                    <div class="flex items-center gap-2 shrink-0">
                        @if($isPdf)
                            <a target="_blank" href="{{ route('user.documents.preview', $doc) }}"
                               class="inline-flex items-center gap-2 px-3 py-2 rounded-2xl border border-slate-200 hover:bg-slate-50 text-sm font-semibold">
                                <i class="fa-solid fa-eye text-slate-500"></i>
                                Preview
                            </a>
                        @endif

                        <a href="{{ route('user.documents.download', $doc) }}"
                           class="inline-flex items-center gap-2 px-3 py-2 rounded-2xl bg-slate-900 text-white hover:bg-slate-800 text-sm font-semibold">
                            <i class="fa-solid fa-download"></i>
                            Télécharger
                        </a>
                    </div>
                </div>
            @empty
                <div class="px-6 py-10 text-center text-slate-600">
                    Aucun document validé pour le moment.
                </div>
            @endforelse
        </div>
    </div>
</x-user-layout>