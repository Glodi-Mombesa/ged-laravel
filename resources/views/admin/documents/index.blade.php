<x-admin-layout>
    <x-slot name="title">Documents</x-slot>
    <x-slot name="subtitle">Ajout, recherche, téléchargement et statut des documents.</x-slot>

    @php
        // Petite fonction d’icône/type (frontend seulement)
        $iconByMime = function (?string $mime) {
            $m = strtolower((string)$mime);
            if (str_contains($m,'pdf')) return ['fa-file-pdf','text-rose-600','PDF'];
            if (str_contains($m,'word') || str_contains($m,'msword')) return ['fa-file-word','text-blue-600','Word'];
            if (str_contains($m,'excel') || str_contains($m,'spreadsheet')) return ['fa-file-excel','text-emerald-600','Excel'];
            if (str_contains($m,'powerpoint') || str_contains($m,'presentation')) return ['fa-file-powerpoint','text-amber-600','PowerPoint'];
            return ['fa-file-lines','text-slate-600','Fichier'];
        };
    @endphp

    <div class="max-w-7xl mx-auto">

        {{-- Header --}}
        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900">
                    <i class="fa-solid fa-file-circle-check text-indigo-600 mr-2"></i>
                    Documents
                </h1>
                <p class="text-slate-600 mt-1">
                    Formats : PDF, Word, Excel, PowerPoint (max 20MB).
                    <span class="text-slate-500">Prévisualisation : PDF uniquement.</span>
                </p>
            </div>

            <div class="flex flex-col sm:flex-row gap-2">
                <a href="{{ route('admin.documents.create') }}"
                   class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-2xl bg-indigo-600 text-white font-semibold shadow-sm hover:bg-indigo-700 transition">
                    <i class="fa-solid fa-upload"></i>
                    Nouveau document
                </a>
            </div>
        </div>

        {{-- Flash --}}
        @if(session('success'))
            <div class="mb-4 px-4 py-3 rounded-2xl bg-emerald-50 text-emerald-800 border border-emerald-200">
                <i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}
            </div>
        @endif

        {{-- Filters --}}
        <form class="bg-white rounded-3xl shadow-sm border border-slate-200 p-4 mb-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input name="q" value="{{ $q }}"
                           placeholder="Recherche (titre, ref, fichier)..."
                           class="w-full pl-10 rounded-2xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <select name="status" class="w-full rounded-2xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Tous statuts</option>
                    <option value="draft" @selected($status==='draft')>Brouillon</option>
                    <option value="validated" @selected($status==='validated')>Validé</option>
                    <option value="archived" @selected($status==='archived')>Archivé</option>
                </select>

                <select name="service_id" class="w-full rounded-2xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Tous services</option>
                    @foreach($services as $s)
                        <option value="{{ $s->id }}" @selected((int)$serviceId === (int)$s->id)>{{ $s->name }}</option>
                    @endforeach
                </select>

                <div class="flex gap-2">
                    <button class="flex-1 px-4 py-2 rounded-2xl bg-slate-900 text-white font-semibold hover:bg-slate-800 transition">
                        <i class="fa-solid fa-filter mr-2"></i> Filtrer
                    </button>
                    <a href="{{ route('admin.documents.index') }}"
                       class="px-4 py-2 rounded-2xl border border-slate-200 text-slate-700 hover:bg-slate-50 transition">
                        Reset
                    </a>
                </div>
            </div>
        </form>

        {{-- Table --}}
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-200 flex items-center justify-between">
                <div class="text-sm text-slate-600">
                    Total : <span class="font-semibold text-slate-900">{{ $documents->total() }}</span>
                </div>
                <div class="text-xs text-slate-500">
                    <i class="fa-solid fa-circle-info mr-1"></i> Preview PDF uniquement.
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="text-left font-semibold px-5 py-3">Document</th>
                        <th class="text-left font-semibold px-5 py-3">Service</th>
                        <th class="text-left font-semibold px-5 py-3">Statut</th>
                        <th class="text-left font-semibold px-5 py-3">Ajouté par</th>
                        <th class="text-right font-semibold px-5 py-3">Actions</th>
                    </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                    @forelse($documents as $doc)
                        @php
                            $mime = strtolower((string)($doc->mime_type ?? ''));
                            $isPdf = str_contains($mime, 'pdf');
                            [$fa, $color, $short] = $iconByMime($doc->mime_type);
                            $map = [
                                'draft' => ['Brouillon','bg-slate-50 text-slate-700 border-slate-200'],
                                'validated' => ['Validé','bg-emerald-50 text-emerald-700 border-emerald-200'],
                                'archived' => ['Archivé','bg-amber-50 text-amber-700 border-amber-200'],
                            ];
                            [$label, $cls] = $map[$doc->status] ?? ['Inconnu','bg-slate-50 text-slate-700 border-slate-200'];
                        @endphp

                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-4">
                                <div class="flex items-start gap-3">
                                    <div class="h-10 w-10 rounded-2xl bg-slate-50 border border-slate-200 grid place-items-center shrink-0">
                                        <i class="fa-solid {{ $fa }} {{ $color }}"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="font-extrabold text-slate-900 truncate">{{ $doc->title }}</div>
                                        <div class="text-xs text-slate-500 mt-0.5">
                                            <span class="font-semibold">{{ $short }}</span>
                                            • {{ $doc->reference ? "Ref: {$doc->reference} • " : "" }}
                                            {{ $doc->original_name }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-5 py-4 text-slate-700">
                                {{ $doc->service?->name ?? '—' }}
                            </td>

                            <td class="px-5 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-xl border font-semibold {{ $cls }}">
                                    {{ $label }}
                                </span>
                            </td>

                            <td class="px-5 py-4 text-slate-700">
                                <div class="font-semibold">{{ $doc->uploader?->name ?? '—' }}</div>
                                <div class="text-xs text-slate-500">{{ $doc->created_at->format('d/m/Y H:i') }}</div>
                            </td>

                            <td class="px-5 py-4">
                                <div class="flex justify-end flex-wrap gap-2">

                                    {{-- Preview (PDF seulement) --}}
                                    @if($isPdf)
                                        <a target="_blank" href="{{ route('admin.documents.preview', $doc) }}"
                                           class="inline-flex items-center gap-2 px-3 py-2 rounded-2xl border border-slate-200 text-slate-700 hover:bg-slate-50 transition">
                                            <i class="fa-solid fa-eye"></i> Prévisualiser
                                        </a>
                                    @else
                                        <span title="Prévisualisation PDF uniquement"
                                              class="inline-flex items-center gap-2 px-3 py-2 rounded-2xl border border-slate-100 text-slate-400 cursor-not-allowed">
                                            <i class="fa-solid fa-eye-slash"></i> Prévisualiser
                                        </span>
                                    @endif

                                    {{-- Download --}}
                                    <a href="{{ route('admin.documents.download', $doc) }}"
                                       class="inline-flex items-center gap-2 px-3 py-2 rounded-2xl border border-slate-200 text-slate-700 hover:bg-slate-50 transition">
                                        <i class="fa-solid fa-download"></i> Télécharger
                                    </a>

                                    {{-- Workflow --}}
                                    @if($doc->status === 'draft')
                                        <form method="POST" action="{{ route('admin.documents.status', $doc) }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="validated">
                                            <button class="inline-flex items-center gap-2 px-3 py-2 rounded-2xl bg-emerald-600 text-white font-semibold hover:bg-emerald-700 transition">
                                                <i class="fa-solid fa-check"></i> Valider
                                            </button>
                                        </form>
                                    @elseif($doc->status === 'validated')
                                        <form method="POST" action="{{ route('admin.documents.status', $doc) }}"
                                              onsubmit="return confirm('Archiver ce document ?');">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="archived">
                                            <button class="inline-flex items-center gap-2 px-3 py-2 rounded-2xl bg-amber-600 text-white font-semibold hover:bg-amber-700 transition">
                                                <i class="fa-solid fa-box-archive"></i> Archiver
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Edit --}}
                                    <a href="{{ route('admin.documents.edit', $doc) }}"
                                       class="inline-flex items-center gap-2 px-3 py-2 rounded-2xl border border-slate-200 text-slate-700 hover:bg-slate-50 transition">
                                        <i class="fa-solid fa-pen"></i> Modifier
                                    </a>

                                    {{-- Delete --}}
                                    <form action="{{ route('admin.documents.destroy', $doc) }}" method="POST"
                                          onsubmit="return confirm('Supprimer ce document ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="inline-flex items-center gap-2 px-3 py-2 rounded-2xl border border-rose-200 text-rose-700 hover:bg-rose-50 transition">
                                            <i class="fa-solid fa-trash-can"></i> Supprimer
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-14 text-center text-slate-600">
                                <div class="text-4xl mb-3">📄</div>
                                <div class="font-extrabold text-slate-900 text-lg mb-1">Aucun document</div>
                                <div class="text-sm">Commence par uploader un document.</div>
                                <a href="{{ route('admin.documents.create') }}"
                                   class="inline-flex mt-4 items-center gap-2 px-4 py-2 rounded-2xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition">
                                    <i class="fa-solid fa-upload"></i> Nouveau document
                                </a>
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