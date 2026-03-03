<x-admin-layout>
    <x-slot name="title">Modifier dossier</x-slot>
    <x-slot name="subtitle">Mise à jour d’un dossier (parent/service/statut)</x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-extrabold text-slate-900">
                        <i class="fa-solid fa-pen-to-square text-indigo-600 mr-2"></i>
                        Modifier : {{ $folder->name }}
                    </h1>
                    <p class="text-slate-600 mt-1">Ajuste le parent/service et l’état.</p>
                </div>

                <a href="{{ route('admin.folders.index') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl border border-slate-200 hover:bg-slate-50 transition text-sm font-semibold">
                    <i class="fa-solid fa-arrow-left"></i>
                    Retour
                </a>
            </div>

            <form method="POST" action="{{ route('admin.folders.update', $folder) }}"
                  class="mt-6 space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="text-sm font-semibold text-slate-700">
                        <i class="fa-solid fa-tag text-slate-400 mr-2"></i> Nom
                    </label>
                    <input name="name" value="{{ old('name', $folder->name) }}" required
                           class="mt-1 w-full rounded-2xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                    @error('name') <div class="text-sm text-rose-700 mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-semibold text-slate-700">
                            <i class="fa-solid fa-building text-slate-400 mr-2"></i> Service (optionnel)
                        </label>
                        <select name="service_id"
                                class="mt-1 w-full rounded-2xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">— Aucun —</option>
                            @foreach($services as $s)
                                <option value="{{ $s->id }}" @selected(old('service_id', $folder->service_id)==$s->id)>{{ $s->name }}</option>
                            @endforeach
                        </select>
                        @error('service_id') <div class="text-sm text-rose-700 mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-slate-700">
                            <i class="fa-solid fa-sitemap text-slate-400 mr-2"></i> Dossier parent (optionnel)
                        </label>
                        <select name="parent_id"
                                class="mt-1 w-full rounded-2xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">— Racine —</option>
                            @foreach($parents as $p)
                                <option value="{{ $p->id }}" @selected(old('parent_id', $folder->parent_id)==$p->id)>
                                    {{ $p->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('parent_id') <div class="text-sm text-rose-700 mt-1">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div>
                    <label class="text-sm font-semibold text-slate-700">
                        <i class="fa-solid fa-align-left text-slate-400 mr-2"></i> Description
                    </label>
                    <textarea name="description" rows="4"
                              class="mt-1 w-full rounded-2xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $folder->description) }}</textarea>
                    @error('description') <div class="text-sm text-rose-700 mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="flex items-center gap-3 p-4 rounded-2xl border border-slate-200 bg-slate-50">
                    <input type="checkbox" name="is_active" id="is_active" value="1"
                           class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500"
                           {{ old('is_active', $folder->is_active) ? 'checked' : '' }}>
                    <div>
                        <label for="is_active" class="text-sm font-semibold text-slate-800">Actif</label>
                        <div class="text-xs text-slate-500">Désactivez pour masquer ce dossier.</div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <a href="{{ route('admin.folders.index') }}"
                       class="px-4 py-2 rounded-2xl border border-slate-200 hover:bg-slate-50 transition font-semibold">
                        Annuler
                    </a>
                    <button class="px-4 py-2 rounded-2xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition">
                        <i class="fa-solid fa-rotate mr-2"></i> Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>