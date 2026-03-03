<x-admin-layout title="Recherche">
    <div class="flex items-start justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Recherche globale</h1>
            <p class="text-slate-600">Recherche dans services, dossiers, documents, utilisateurs (et historique si activé).</p>
        </div>
    </div>

    <form class="bg-white rounded-2xl shadow border border-slate-200 p-4 mb-6">
        <div class="flex flex-col md:flex-row gap-3 md:items-center">
            <input name="q" value="{{ $q }}" autofocus
                   placeholder="Tape un mot-clé : ex. secretariat, facture, glodi, SEC-2026..."
                   class="flex-1 rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">

            <div class="flex gap-2">
                <button class="px-5 py-2.5 rounded-xl bg-slate-900 text-white font-semibold hover:bg-slate-800">
                    Rechercher
                </button>
                <a href="{{ route('admin.search.index') }}"
                   class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-50">
                    Reset
                </a>
            </div>
        </div>

        @if($q !== '')
            <div class="mt-3 text-xs text-slate-500">
                Résultats pour : <span class="font-semibold text-slate-900">{{ $q }}</span>
            </div>
        @endif
    </form>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        {{-- SERVICES --}}
        <div class="bg-white rounded-2xl shadow border border-slate-200 overflow-hidden">
            <div class="px-4 py-3 border-b border-slate-200 flex items-center justify-between">
                <div class="font-semibold text-slate-900">🏢 Services</div>
                <div class="text-xs text-slate-500">{{ $services->count() }} résultat(s)</div>
            </div>
            <div class="p-4 space-y-3">
                @forelse($services as $s)
                    <a href="{{ route('admin.services.edit', $s) }}"
                       class="block p-3 rounded-xl border border-slate-200 hover:bg-slate-50">
                        <div class="font-semibold text-slate-900">{{ $s->name }}</div>
                        <div class="text-xs text-slate-500">Code : {{ $s->code ?? '—' }}</div>
                    </a>
                @empty
                    <div class="text-sm text-slate-500">Aucun service.</div>
                @endforelse
            </div>
        </div>

        {{-- DOSSIERS --}}
        <div class="bg-white rounded-2xl shadow border border-slate-200 overflow-hidden">
            <div class="px-4 py-3 border-b border-slate-200 flex items-center justify-between">
                <div class="font-semibold text-slate-900">🗂️ Dossiers</div>
                <div class="text-xs text-slate-500">{{ $folders->count() }} résultat(s)</div>
            </div>
            <div class="p-4 space-y-3">
                @forelse($folders as $f)
                    <a href="{{ route('admin.folders.edit', $f) }}"
                       class="block p-3 rounded-xl border border-slate-200 hover:bg-slate-50">
                        <div class="font-semibold text-slate-900">{{ $f->name }}</div>
                        <div class="text-xs text-slate-500">
                            Service : {{ $f->service?->name ?? '—' }}
                            @if($f->parent) • Parent : {{ $f->parent->name }} @endif
                        </div>
                    </a>
                @empty
                    <div class="text-sm text-slate-500">Aucun dossier.</div>
                @endforelse
            </div>
        </div>

        {{-- DOCUMENTS --}}
        <div class="bg-white rounded-2xl shadow border border-slate-200 overflow-hidden lg:col-span-2">
            <div class="px-4 py-3 border-b border-slate-200 flex items-center justify-between">
                <div class="font-semibold text-slate-900">📄 Documents</div>
                <div class="text-xs text-slate-500">{{ $documents->count() }} résultat(s)</div>
            </div>
            <div class="p-4 space-y-3">
                @forelse($documents as $doc)
                    <div class="p-3 rounded-xl border border-slate-200 hover:bg-slate-50 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                        <div>
                            <div class="font-semibold text-slate-900">{{ $doc->title }}</div>
                            <div class="text-xs text-slate-500">
                                {{ $doc->reference ? "Ref: {$doc->reference} • " : "" }}
                                {{ $doc->original_name }}
                                • Service : {{ $doc->service?->name ?? '—' }}
                                • Par : {{ $doc->uploader?->name ?? '—' }}
                            </div>
                        </div>
                        <div class="flex gap-2 justify-end">
                            <a href="{{ route('admin.documents.download', $doc) }}"
                               class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-50">
                                Télécharger
                            </a>

                            {{-- Prévisualiser seulement si PDF --}}
                            @if(($doc->mime_type ?? '') === 'application/pdf' || str_ends_with(strtolower($doc->original_name ?? ''), '.pdf'))
                                <a href="{{ route('admin.documents.preview', $doc) }}"
                                   class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-50">
                                    Prévisualiser
                                </a>
                            @endif

                            <a href="{{ route('admin.documents.edit', $doc) }}"
                               class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-50">
                                Modifier
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-sm text-slate-500">Aucun document.</div>
                @endforelse
            </div>
        </div>

        {{-- UTILISATEURS --}}
        <div class="bg-white rounded-2xl shadow border border-slate-200 overflow-hidden">
            <div class="px-4 py-3 border-b border-slate-200 flex items-center justify-between">
                <div class="font-semibold text-slate-900">👤 Utilisateurs</div>
                <div class="text-xs text-slate-500">{{ $users->count() }} résultat(s)</div>
            </div>
            <div class="p-4 space-y-3">
                @forelse($users as $u)
                    <a href="{{ route('admin.users.edit', $u) }}"
                       class="block p-3 rounded-xl border border-slate-200 hover:bg-slate-50">
                        <div class="font-semibold text-slate-900">{{ $u->name }}</div>
                        <div class="text-xs text-slate-500">{{ $u->email }}</div>
                    </a>
                @empty
                    <div class="text-sm text-slate-500">Aucun utilisateur.</div>
                @endforelse
            </div>
        </div>

        {{-- HISTORIQUE (optionnel) --}}
        <div class="bg-white rounded-2xl shadow border border-slate-200 overflow-hidden">
            <div class="px-4 py-3 border-b border-slate-200 flex items-center justify-between">
                <div class="font-semibold text-slate-900">🧾 Historique</div>
                <div class="text-xs text-slate-500">{{ $audits->count() }} résultat(s)</div>
            </div>
            <div class="p-4 space-y-3">
                @forelse($audits as $a)
                    <div class="p-3 rounded-xl border border-slate-200">
                        <div class="font-semibold text-slate-900">{{ $a->action ?? 'action' }}</div>
                        <div class="text-xs text-slate-500">
                            {{ $a->entity_type ?? '—' }} #{{ $a->entity_id ?? '—' }}
                            • {{ optional($a->created_at)->format('d/m/Y H:i') }}
                        </div>
                    </div>
                @empty
                    <div class="text-sm text-slate-500">Aucun historique.</div>
                @endforelse
            </div>
        </div>
    </div>
</x-admin-layout>