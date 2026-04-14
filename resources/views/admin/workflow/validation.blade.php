<x-admin-layout>
    <x-slot name="title">Validation</x-slot>
    <x-slot name="subtitle">Documents en brouillon à valider ou archiver</x-slot>

    <div class="max-w-7xl mx-auto">
        {{-- Header --}}
        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 flex items-center gap-3">
                    <span class="h-10 w-10 rounded-2xl bg-emerald-50 text-emerald-700 grid place-items-center">
                        <i class="fa-solid fa-circle-check"></i>
                    </span>
                    Validation
                </h1>
                <p class="text-slate-600 mt-1">
                    Liste des documents en <span class="font-semibold text-slate-900">brouillon</span> à traiter.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row gap-2">
                <a href="{{ route('admin.documents.create') }}"
                   class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-2xl bg-indigo-600 text-white font-semibold shadow-sm hover:bg-indigo-700 transition">
                    <i class="fa-solid fa-upload"></i>
                    Nouveau document
                </a>

                <a href="{{ route('admin.documents.index') }}"
                   class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-2xl border border-slate-200 text-slate-700 hover:bg-slate-50 transition font-semibold">
                    <i class="fa-solid fa-folder-open"></i>
                    Voir documents
                </a>
            </div>
        </div>

        {{-- Alert success --}}
        @if(session('success'))
            <div class="mb-4 px-4 py-3 rounded-2xl border border-emerald-200 bg-emerald-50 text-emerald-800 flex items-start gap-3">
                <i class="fa-solid fa-circle-check mt-0.5"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        {{-- Search / Filter bar --}}
        <form method="GET"
              class="bg-white rounded-3xl shadow-sm border border-slate-200 p-3 sm:p-4 mb-5">
            <div class="flex flex-col lg:flex-row lg:items-center gap-3">
                <div class="flex items-center gap-2 flex-1 bg-slate-50 border border-slate-200 rounded-2xl px-3 py-2">
                    <i class="fa-solid fa-magnifying-glass text-slate-400"></i>
                    <input name="q" value="{{ $q }}"
                           placeholder="Rechercher (titre, ref, fichier...)"
                           class="w-full bg-transparent border-0 focus:ring-0 text-sm text-slate-700 placeholder:text-slate-400">
                </div>

                <div class="flex items-center gap-2">
                    <button class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-slate-900 text-white font-semibold hover:bg-slate-800 transition">
                        <i class="fa-solid fa-filter"></i>
                        Rechercher
                    </button>

                    <a href="{{ route('admin.workflow.validation') }}"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl border border-slate-200 text-slate-700 hover:bg-slate-50 transition font-semibold">
                        <i class="fa-solid fa-rotate-left"></i>
                        Reset
                    </a>
                </div>
            </div>
        </form>

        {{-- Table card --}}
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-200 flex items-center justify-between">
                <div class="text-sm text-slate-600">
                    Total : <span class="font-semibold text-slate-900">{{ $documents->total() }}</span>
                </div>

                <div class="text-xs text-slate-500 hidden md:flex items-center gap-2">
                    <i class="fa-solid fa-circle-info"></i>
                    Seuls les documents en brouillon apparaissent ici.
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="text-left font-semibold px-5 py-3">Document</th>
                        <th class="text-left font-semibold px-5 py-3">Service</th>
                        <th class="text-left font-semibold px-5 py-3">Dossier</th>
                        <th class="text-left font-semibold px-5 py-3">Ajouté par</th>
                        <th class="text-right font-semibold px-5 py-3">Actions</th>
                    </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                    @forelse($documents as $doc)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-5 py-4">
                                <div class="font-extrabold text-slate-900">{{ $doc->title }}</div>
                                <div class="text-xs text-slate-500 mt-1">
                                    {{ $doc->reference ? "Ref: {$doc->reference} • " : "" }}
                                    {{ $doc->original_name }}
                                </div>
                                <div class="mt-2">
                                    <span class="inline-flex items-center gap-2 px-2.5 py-1 rounded-xl bg-slate-100 text-slate-700 border border-slate-200 font-semibold text-xs">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                        Brouillon
                                    </span>
                                </div>
                            </td>

                            <td class="px-5 py-4 text-slate-700">
                                {{ $doc->service?->name ?? '—' }}
                            </td>

                            <td class="px-5 py-4 text-slate-700">
                                {{ $doc->folder?->name ?? '—' }}
                            </td>

                            <td class="px-5 py-4 text-slate-700">
                                <div class="font-semibold text-slate-900">{{ $doc->uploader?->name ?? '—' }}</div>
                                <div class="text-xs text-slate-500">{{ $doc->created_at->format('d/m/Y H:i') }}</div>
                            </td>

                            <td class="px-5 py-4">
                                <div class="flex justify-end flex-wrap gap-2">

                                    {{-- Télécharger --}}
                                    <a href="{{ route('admin.documents.download', $doc) }}"
                                       class="inline-flex items-center gap-2 px-3 py-2 rounded-2xl border border-slate-200 text-slate-700 hover:bg-white font-semibold transition">
                                        <i class="fa-solid fa-download"></i>
                                        Télécharger
                                    </a>

                                    {{-- Valider --}}
                                    <form method="POST" action="{{ route('admin.documents.status', $doc) }}">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="validated">
                                        <button class="inline-flex items-center gap-2 px-3 py-2 rounded-2xl bg-emerald-600 text-white font-semibold hover:bg-emerald-700 transition">
                                            <i class="fa-solid fa-circle-check"></i>
                                            Valider
                                        </button>
                                    </form>

                                    {{-- Archiver --}}
                                    <form method="POST" action="{{ route('admin.documents.status', $doc) }}"
                                          onsubmit="return confirm('Archiver ce document ?');">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="archived">
                                        <button class="inline-flex items-center gap-2 px-3 py-2 rounded-2xl bg-amber-600 text-white font-semibold hover:bg-amber-700 transition">
                                            <i class="fa-solid fa-box-archive"></i>
                                            Archiver
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-14 text-center text-slate-600">
                                <div class="text-4xl mb-3 text-green-500">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="font-extrabold text-slate-900 text-lg">Aucun document à valider</div>
                                <div class="text-sm mt-1">Tous les documents ont été traités.</div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-5 py-4 border-t border-slate-200">
                {{ $documents->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>