<x-admin-layout>
    <x-slot name="title">Dossiers</x-slot>
    <x-slot name="subtitle">Arborescence GED : dossiers et sous-dossiers</x-slot>

    <div class="max-w-7xl mx-auto">
        {{-- Header (comme Documents) --}}
        <div class="flex items-start justify-between gap-4 mb-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900">
                    <i class="fa-solid fa-folder-tree text-indigo-600 mr-2"></i>
                    Dossiers
                </h1>

                <p class="text-slate-600 mt-1">
                    Arborescence GED : dossiers et sous-dossiers.
                    @if($currentParent)
                        <span class="font-semibold text-slate-900">• Dans :</span> {{ $currentParent->name }}
                    @endif
                </p>

                {{-- Breadcrumb --}}
                <div class="mt-3 flex flex-wrap items-center gap-2 text-sm">
                    <a href="{{ route('admin.folders.index', ['service_id'=>$serviceId]) }}"
                       class="inline-flex items-center gap-2 px-3 py-2 rounded-2xl border border-slate-200 hover:bg-slate-50 transition">
                        <i class="fa-solid fa-house text-slate-500"></i>
                        Racine
                    </a>

                    @if($currentParent)
                        <span class="text-slate-400">/</span>
                        <span class="inline-flex items-center gap-2 px-3 py-2 rounded-2xl bg-slate-900 text-white">
                            <i class="fa-solid fa-folder-open"></i>
                            {{ $currentParent->name }}
                        </span>
                    @endif
                </div>
            </div>

            <a href="{{ route('admin.folders.create', ['service_id'=>$serviceId, 'parent_id'=>$parentId]) }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-indigo-600 text-white font-semibold shadow-sm hover:bg-indigo-700 transition">
                <i class="fa-solid fa-plus"></i>
                Nouveau dossier
            </a>
        </div>

        {{-- Bouton retour (si sous-dossier) --}}
        @if($currentParent)
            <div class="mb-4">
                <a href="{{ route('admin.folders.index', ['service_id'=>$serviceId, 'parent_id'=>$currentParent->parent_id]) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl border border-slate-200 hover:bg-slate-50 transition font-semibold text-sm">
                    <i class="fa-solid fa-arrow-left text-slate-600"></i>
                    Retour
                </a>
            </div>
        @endif

        {{-- Barre filtre (comme Documents) --}}
        <form method="GET" class="bg-white rounded-3xl border border-slate-200 shadow-sm p-4 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                <div class="md:col-span-2 flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-3 py-2">
                    <i class="fa-solid fa-magnifying-glass text-slate-400"></i>
                    <input name="q" value="{{ $q }}"
                           placeholder="Rechercher un dossier..."
                           class="w-full border-0 focus:ring-0 text-sm text-slate-700 placeholder:text-slate-400">
                </div>

                <select name="service_id"
                        class="w-full rounded-2xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    <option value="">Tous services</option>
                    @foreach($services as $s)
                        <option value="{{ $s->id }}" @selected((int)$serviceId === (int)$s->id)>{{ $s->name }}</option>
                    @endforeach
                </select>

                <input type="hidden" name="parent_id" value="{{ $parentId ?? '' }}">

                <div class="flex gap-2">
                    <button class="flex-1 px-4 py-2 rounded-2xl bg-slate-900 text-white font-semibold hover:bg-slate-800 transition">
                        <i class="fa-solid fa-filter mr-2"></i> Filtrer
                    </button>

                    <a href="{{ route('admin.folders.index') }}"
                       class="px-4 py-2 rounded-2xl border border-slate-200 text-slate-700 hover:bg-slate-50 transition">
                        Reset
                    </a>
                </div>
            </div>
        </form>

        {{-- Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($folders as $folder)
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-5 hover:shadow-md transition">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <div class="flex items-center gap-3">
                                <span class="h-10 w-10 rounded-2xl bg-indigo-50 text-indigo-700 grid place-items-center shrink-0">
                                    <i class="fa-solid fa-folder"></i>
                                </span>

                                <div class="min-w-0">
                                    <div class="text-lg font-extrabold text-slate-900 truncate">
                                        {{ $folder->name }}
                                    </div>
                                    <div class="text-xs text-slate-500">
                                        slug : <span class="font-semibold">{{ $folder->slug }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3 text-sm text-slate-600">
                                <i class="fa-solid fa-building text-slate-400 mr-2"></i>
                                Service :
                                <span class="font-semibold text-slate-900">{{ $folder->service?->name ?? '—' }}</span>
                            </div>

                            <div class="mt-2">
                                @if($folder->is_active)
                                    <span class="inline-flex items-center gap-2 px-2.5 py-1 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200 font-semibold text-xs">
                                        <i class="fa-solid fa-circle-check"></i> Actif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-2 px-2.5 py-1 rounded-xl bg-slate-100 text-slate-700 border border-slate-200 font-semibold text-xs">
                                        <i class="fa-solid fa-circle-minus"></i> Inactif
                                    </span>
                                @endif
                            </div>
                        </div>

                        <a href="{{ route('admin.folders.index', ['service_id'=>$serviceId, 'parent_id'=>$folder->id]) }}"
                           class="inline-flex items-center gap-2 px-3 py-2 rounded-2xl border border-slate-200 hover:bg-slate-50 text-sm font-semibold transition">
                            <i class="fa-solid fa-arrow-right"></i>
                            Ouvrir
                        </a>
                    </div>

                    <div class="mt-5 flex items-center justify-end gap-2">
                        <a href="{{ route('admin.folders.edit', $folder) }}"
                           class="inline-flex items-center gap-2 px-3 py-2 rounded-2xl border border-slate-200 hover:bg-slate-50 text-sm font-semibold transition">
                            <i class="fa-solid fa-pen"></i> Modifier
                        </a>

                        <form action="{{ route('admin.folders.destroy', $folder) }}" method="POST"
                              onsubmit="return confirm('Supprimer ce dossier ?');">
                            @csrf
                            @method('DELETE')
                            <button class="inline-flex items-center gap-2 px-3 py-2 rounded-2xl border border-rose-200 text-rose-700 hover:bg-rose-50 text-sm font-semibold transition">
                                <i class="fa-solid fa-trash-can"></i> Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-3xl border border-slate-200 p-12 text-center text-slate-600">
                    <div class="text-4xl mb-3">📁</div>
                    <div class="font-extrabold text-slate-900 text-lg">Aucun dossier</div>
                    <div class="text-sm mt-1">Crée ton premier dossier GED.</div>
                </div>
            @endforelse
        </div>

        <div class="mt-5">
            {{ $folders->links() }}
        </div>
    </div>
</x-admin-layout>