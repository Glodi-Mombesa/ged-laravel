<x-user-layout title="Documents" subtitle="Rechercher, filtrer, prévisualiser (PDF) et télécharger.">

    {{-- Top summary + toolbar --}}
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

        {{-- Header --}}
        <div class="p-5 sm:p-6 border-b border-slate-200 bg-gradient-to-r from-indigo-50/60 via-white to-white">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div class="min-w-0">
                    <div class="flex items-center gap-3">
                        <span class="h-11 w-11 rounded-2xl bg-indigo-600/10 text-indigo-700 grid place-items-center border border-indigo-200">
                            <i class="fa-solid fa-file-lines text-lg"></i>
                        </span>
                        <div class="min-w-0">
                            <div class="text-lg sm:text-xl font-extrabold text-slate-900">Documents de l’entreprise</div>
                            <div class="text-sm text-slate-600">
                                <span class="font-semibold text-slate-900">{{ $documents->total() }}</span> résultat(s) •
                                <span class="inline-flex items-center gap-2">
                                    <i class="fa-solid fa-circle-info text-slate-400"></i>
                                    Prévisualisation : <span class="font-semibold">PDF uniquement</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Quick actions (optional look) --}}
                <div class="flex items-center gap-2">
                    <span class="hidden sm:inline-flex items-center gap-2 px-3 py-2 rounded-2xl border border-slate-200 bg-white shadow-sm text-sm text-slate-600">
                        <i class="fa-solid fa-shield-halved text-indigo-600"></i>
                        Accès en lecture
                    </span>
                </div>
            </div>

            {{-- Toolbar --}}
            <form method="GET" class="mt-5 grid grid-cols-1 lg:grid-cols-12 gap-3 items-stretch">
                {{-- Search --}}
                <div class="lg:col-span-5">
                    <label class="sr-only">Recherche</label>
                    <div class="group flex items-center gap-2 bg-white border border-slate-200 rounded-2xl px-3 py-2 shadow-sm focus-within:ring-4 focus-within:ring-indigo-100 focus-within:border-indigo-300 transition">
                        <i class="fa-solid fa-magnifying-glass text-slate-400 group-focus-within:text-indigo-600 transition"></i>
                        <input
                            name="q"
                            value="{{ $q }}"
                            placeholder="Recherche (titre, ref, fichier)…"
                            class="w-full bg-transparent border-0 focus:ring-0 text-sm text-slate-700 placeholder:text-slate-400"
                        >
                    </div>
                </div>

                {{-- Service --}}
                <div class="lg:col-span-3">
                    <label class="sr-only">Service</label>
                    <select
                        name="service_id"
                        class="w-full rounded-2xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm shadow-sm"
                    >
                        <option value="">Tous services</option>
                        @foreach($services as $s)
                            <option value="{{ $s->id }}" @selected((int)$serviceId === (int)$s->id)>{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Folder --}}
                <div class="lg:col-span-2">
                    <label class="sr-only">Dossier</label>
                    <select
                        name="folder_id"
                        class="w-full rounded-2xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm shadow-sm"
                    >
                        <option value="">Tous dossiers</option>
                        @foreach($folders as $f)
                            <option value="{{ $f->id }}" @selected((int)$folderId === (int)$f->id)>{{ $f->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Buttons --}}
                <div class="lg:col-span-2 flex gap-2">
                    <button
                        class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 rounded-2xl bg-slate-900 text-white font-semibold hover:bg-slate-800 active:scale-[0.99] transition shadow-sm text-sm"
                    >
                        <i class="fa-solid fa-filter"></i>
                        Filtrer
                    </button>

                    <a
                        href="{{ route('user.documents.index') }}"
                        class="inline-flex items-center justify-center px-4 py-2 rounded-2xl border border-slate-200 hover:bg-white transition text-sm font-semibold text-slate-700 shadow-sm"
                    >
                        Reset
                    </a>
                </div>
            </form>
        </div>

        {{-- List --}}
        <div class="p-4 sm:p-6">
            <div class="grid gap-3">
                @forelse($documents as $doc)
                    @php
                        $mime = strtolower((string)($doc->mime_type ?? ''));
                        $isPdf = str_contains($mime, 'pdf');
                        $ext = strtolower(pathinfo((string)($doc->original_name ?? ''), PATHINFO_EXTENSION));
                        $icon = $isPdf ? 'fa-file-pdf'
                              : (in_array($ext, ['xlsx','xls','csv']) ? 'fa-file-excel'
                              : (in_array($ext, ['doc','docx']) ? 'fa-file-word'
                              : (in_array($ext, ['ppt','pptx']) ? 'fa-file-powerpoint'
                              : 'fa-file-lines')));
                        $iconColor = $isPdf ? 'text-rose-600 bg-rose-50 border-rose-200'
                                   : (in_array($ext, ['xlsx','xls','csv']) ? 'text-emerald-700 bg-emerald-50 border-emerald-200'
                                   : (in_array($ext, ['doc','docx']) ? 'text-sky-700 bg-sky-50 border-sky-200'
                                   : (in_array($ext, ['ppt','pptx']) ? 'text-amber-700 bg-amber-50 border-amber-200'
                                   : 'text-indigo-700 bg-indigo-50 border-indigo-200')));
                    @endphp

                    <div class="doc-card group">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            {{-- Left --}}
                            <div class="min-w-0">
                                <div class="flex items-start gap-3">
                                    <span class="h-11 w-11 rounded-2xl grid place-items-center border {{ $iconColor }} shrink-0 transition group-hover:scale-[1.02]">
                                        <i class="fa-solid {{ $icon }} text-lg"></i>
                                    </span>

                                    <div class="min-w-0">
                                        <div class="flex items-center gap-2 min-w-0">
                                            <div class="font-extrabold text-slate-900 truncate">
                                                {{ $doc->title }}
                                            </div>

                                            @if($isPdf)
                                                <span class="hidden sm:inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                    <i class="fa-solid fa-eye"></i> Preview
                                                </span>
                                            @endif
                                        </div>

                                        <div class="text-xs text-slate-500 mt-1 flex flex-wrap items-center gap-x-3 gap-y-1">
                                            <span class="inline-flex items-center gap-2">
                                                <i class="fa-solid fa-building text-slate-400"></i>
                                                <span class="font-semibold text-slate-700">{{ $doc->service?->name ?? '—' }}</span>
                                            </span>
                                            <span class="inline-flex items-center gap-2">
                                                <i class="fa-solid fa-folder text-slate-400"></i>
                                                <span class="font-semibold text-slate-700">{{ $doc->folder?->name ?? '—' }}</span>
                                            </span>

                                            @if($doc->reference)
                                                <span class="inline-flex items-center gap-2">
                                                    <i class="fa-solid fa-hashtag text-slate-400"></i>
                                                    <span class="font-semibold text-slate-700">{{ $doc->reference }}</span>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="text-xs text-slate-500 mt-2 truncate">
                                            <i class="fa-solid fa-paperclip mr-1 text-slate-400"></i>
                                            {{ $doc->original_name }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Right --}}
                            <div class="flex items-center gap-2 shrink-0">
                                @if($isPdf)
                                    <a target="_blank"
                                       href="{{ route('user.documents.preview', $doc) }}"
                                       class="btn-soft">
                                        <i class="fa-solid fa-eye text-slate-600"></i>
                                        <span class="hidden sm:inline">Prévisualiser</span>
                                        <span class="sm:hidden">Voir</span>
                                    </a>
                                @else
                                    <span class="btn-disabled" title="Prévisualisation disponible uniquement pour PDF">
                                        <i class="fa-solid fa-eye-slash"></i>
                                        <span class="hidden sm:inline">Preview</span>
                                        <span class="sm:hidden">—</span>
                                    </span>
                                @endif

                                <a href="{{ route('user.documents.download', $doc) }}"
                                   class="btn-primary">
                                    <i class="fa-solid fa-download"></i>
                                    <span class="hidden sm:inline">Télécharger</span>
                                    <span class="sm:hidden">DL</span>
                                </a>
                            </div>
                        </div>
                    </div>

                @empty
                    <div class="p-10 text-center text-slate-600 border border-slate-200 rounded-3xl bg-slate-50">
                        <div class="text-4xl mb-2 text-blue-500">
                            <i class="fa-solid fa-file-lines"></i>
                        </div>
                        <div class="font-extrabold text-slate-900 text-lg">Aucun document</div>
                        <div class="text-sm mt-1">Aucun document validé ne correspond à tes filtres.</div>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $documents->links() }}
            </div>
        </div>
    </div>

    {{-- Tiny CSS helpers (safe, local to this view) --}}
    <style>
        .doc-card{
            border: 1px solid rgb(226 232 240);
            border-radius: 1.5rem;
            background: #fff;
            padding: 1rem;
            box-shadow: 0 1px 2px rgba(15, 23, 42, .06);
            transition: transform .18s ease, box-shadow .18s ease, background .18s ease, border-color .18s ease;
        }
        @media (min-width: 640px){
            .doc-card{ padding: 1.25rem; }
        }
        .doc-card:hover{
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(15, 23, 42, .10);
            border-color: rgba(99, 102, 241, .28);
            background: linear-gradient(180deg, rgba(99,102,241,.03), transparent 55%);
        }

        .btn-soft{
            display:inline-flex; align-items:center; gap:.5rem;
            padding:.6rem .9rem;
            border-radius: 1rem;
            border: 1px solid rgb(226 232 240);
            background: #fff;
            font-weight: 800;
            font-size: .875rem;
            color: rgb(51 65 85);
            transition: transform .12s ease, background .12s ease, border-color .12s ease;
        }
        .btn-soft:hover{
            background: rgb(248 250 252);
            border-color: rgba(99, 102, 241, .28);
            transform: translateY(-1px);
        }

        .btn-primary{
            display:inline-flex; align-items:center; gap:.5rem;
            padding:.6rem .95rem;
            border-radius: 1rem;
            background: rgb(15 23 42);
            color: #fff;
            font-weight: 900;
            font-size: .875rem;
            transition: transform .12s ease, background .12s ease;
        }
        .btn-primary:hover{ background: rgb(30 41 59); transform: translateY(-1px); }

        .btn-disabled{
            display:inline-flex; align-items:center; gap:.5rem;
            padding:.6rem .9rem;
            border-radius: 1rem;
            border: 1px solid rgb(241 245 249);
            color: rgb(148 163 184);
            background: rgb(248 250 252);
            font-weight: 800;
            font-size: .875rem;
            cursor: not-allowed;
        }
    </style>

</x-user-layout>