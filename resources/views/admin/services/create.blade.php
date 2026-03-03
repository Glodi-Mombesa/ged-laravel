<x-admin-layout>
    <x-slot name="title">Créer un service</x-slot>
    <x-slot name="subtitle">Ajout d’un service administratif</x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-extrabold text-slate-900">
                        <i class="fa-solid fa-plus text-indigo-600 mr-2"></i>
                        Nouveau service
                    </h1>
                    <p class="text-slate-600 mt-1">Définissez le nom, un code unique, et le statut.</p>
                </div>
                <a href="{{ route('admin.services.index') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl border border-slate-200 hover:bg-slate-50 transition text-sm font-semibold">
                    <i class="fa-solid fa-arrow-left"></i>
                    Retour
                </a>
            </div>

            <form method="POST" action="{{ route('admin.services.store') }}" class="mt-6 space-y-5">
                @csrf

                <div>
                    <label class="text-sm font-semibold text-slate-700">
                        <i class="fa-solid fa-building text-slate-400 mr-2"></i> Nom
                    </label>
                    <input name="name" value="{{ old('name') }}"
                           class="mt-1 w-full rounded-2xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500"
                           placeholder="Ex: Secrétariat Général" required>
                    @error('name') <div class="text-sm text-rose-700 mt-1">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="text-sm font-semibold text-slate-700">
                        <i class="fa-solid fa-hashtag text-slate-400 mr-2"></i> Code (unique)
                    </label>
                    <input name="code" value="{{ old('code') }}"
                           class="mt-1 w-full rounded-2xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 uppercase"
                           placeholder="Ex: SG" required>
                    <p class="text-xs text-slate-500 mt-1">Court, lisible, unique (SG, RH, FIN…).</p>
                    @error('code') <div class="text-sm text-rose-700 mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="flex items-center gap-3 p-4 rounded-2xl border border-slate-200 bg-slate-50">
                    <input type="checkbox" name="is_active" id="is_active" value="1"
                           class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500"
                           {{ old('is_active', true) ? 'checked' : '' }}>
                    <div>
                        <label for="is_active" class="text-sm font-semibold text-slate-800">
                            Activer ce service
                        </label>
                        <div class="text-xs text-slate-500">Un service inactif peut être masqué côté utilisateurs.</div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <a href="{{ route('admin.services.index') }}"
                       class="px-4 py-2 rounded-2xl border border-slate-200 hover:bg-slate-50 transition font-semibold">
                        Annuler
                    </a>
                    <button class="px-4 py-2 rounded-2xl bg-indigo-600 text-white hover:bg-indigo-700 transition font-semibold">
                        <i class="fa-solid fa-floppy-disk mr-2"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>