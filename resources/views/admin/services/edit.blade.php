<x-admin-layout>
    <x-slot name="title">Modifier le service</x-slot>
    <x-slot name="subtitle">Mise à jour d’un service administratif</x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-extrabold text-slate-900">
                        <i class="fa-solid fa-pen text-indigo-600 mr-2"></i>
                        Modifier : {{ $service->name }}
                    </h1>
                    <p class="text-slate-600 mt-1">Mettez à jour le nom, le code et le statut.</p>
                </div>
                <a href="{{ route('admin.services.index') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl border border-slate-200 hover:bg-slate-50 transition text-sm font-semibold">
                    <i class="fa-solid fa-arrow-left"></i>
                    Retour
                </a>
            </div>

            <form method="POST" action="{{ route('admin.services.update', $service) }}" class="mt-6 space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="text-sm font-semibold text-slate-700">
                        <i class="fa-solid fa-building text-slate-400 mr-2"></i> Nom
                    </label>
                    <input name="name" value="{{ old('name', $service->name) }}"
                           class="mt-1 w-full rounded-2xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500"
                           required>
                    @error('name') <div class="text-sm text-rose-700 mt-1">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="text-sm font-semibold text-slate-700">
                        <i class="fa-solid fa-hashtag text-slate-400 mr-2"></i> Code (unique)
                    </label>
                    <input name="code" value="{{ old('code', $service->code) }}"
                           class="mt-1 w-full rounded-2xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 uppercase"
                           required>
                    @error('code') <div class="text-sm text-rose-700 mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="flex items-center gap-3 p-4 rounded-2xl border border-slate-200 bg-slate-50">
                    <input type="checkbox" name="is_active" id="is_active" value="1"
                           class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500"
                           {{ old('is_active', $service->is_active) ? 'checked' : '' }}>
                    <div>
                        <label for="is_active" class="text-sm font-semibold text-slate-800">
                            Service actif
                        </label>
                        <div class="text-xs text-slate-500">Désactivez pour le masquer côté utilisateurs.</div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <a href="{{ route('admin.services.index') }}"
                       class="px-4 py-2 rounded-2xl border border-slate-200 hover:bg-slate-50 transition font-semibold">
                        Annuler
                    </a>
                    <button class="px-4 py-2 rounded-2xl bg-indigo-600 text-white hover:bg-indigo-700 transition font-semibold">
                        <i class="fa-solid fa-rotate mr-2"></i> Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>