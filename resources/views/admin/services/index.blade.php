<x-admin-layout>
    <x-slot name="title">Services</x-slot>
    <x-slot name="subtitle">Gestion des services de l’administration (création, statut, actions).</x-slot>

    <div class="max-w-7xl mx-auto">
        {{-- Header (comme Documents) --}}
        <div class="flex items-start justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900">
                    <i class="fa-solid fa-building text-indigo-600 mr-2"></i>
                    Services
                </h1>
                <p class="text-slate-600 mt-1">Active/Inactif contrôle l’affichage côté utilisateurs.</p>
            </div>

            <a href="{{ route('admin.services.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-indigo-600 text-white font-semibold shadow-sm hover:bg-indigo-700 transition">
                <i class="fa-solid fa-plus"></i>
                Nouveau service
            </a>
        </div>

        {{-- Barre filtre (comme Documents) --}}
        <form method="GET" class="bg-white rounded-3xl border border-slate-200 shadow-sm p-4 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                <div class="md:col-span-2 flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-3 py-2">
                    <i class="fa-solid fa-magnifying-glass text-slate-400"></i>
                    <input name="q" value="{{ request('q') }}"
                           placeholder="Recherche (nom, code)..."
                           class="w-full border-0 focus:ring-0 text-sm text-slate-700 placeholder:text-slate-400">
                </div>

                <select name="active"
                        class="w-full rounded-2xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    <option value="">Tous statuts</option>
                    <option value="1" @selected(request('active')==='1')>Actifs</option>
                    <option value="0" @selected(request('active')==='0')>Inactifs</option>
                </select>

                <div class="flex gap-2">
                    <button class="flex-1 px-4 py-2 rounded-2xl bg-slate-900 text-white font-semibold hover:bg-slate-800 transition">
                        <i class="fa-solid fa-filter mr-2"></i> Filtrer
                    </button>

                    <a href="{{ route('admin.services.index') }}"
                       class="px-4 py-2 rounded-2xl border border-slate-200 text-slate-700 hover:bg-slate-50 transition">
                        Reset
                    </a>
                </div>
            </div>
        </form>

        {{-- Mini cards (optionnel mais joli) --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-5">
                <div class="text-sm text-slate-500">Total</div>
                <div class="text-3xl font-extrabold text-slate-900 mt-1">{{ $services->total() }}</div>
                <div class="text-xs text-slate-500 mt-1">Tous services</div>
            </div>

            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-5">
                <div class="text-sm text-slate-500">Astuce</div>
                <div class="text-lg font-bold text-slate-900 mt-1">
                    <i class="fa-solid fa-toggle-on text-emerald-600 mr-2"></i>
                    Active/Inactif
                </div>
                <div class="text-xs text-slate-500 mt-1">Contrôle l’accès et l’affichage côté utilisateurs</div>
            </div>

            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-5">
                <div class="text-sm text-slate-500">Bonnes pratiques</div>
                <div class="text-lg font-bold text-slate-900 mt-1">
                    <i class="fa-solid fa-hashtag text-indigo-600 mr-2"></i>
                    Code unique
                </div>
                <div class="text-xs text-slate-500 mt-1">Court, lisible (ex: SG, FIN, RH...)</div>
            </div>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-200 flex items-center justify-between">
                <div class="text-sm text-slate-600">
                    Total : <span class="font-semibold text-slate-900">{{ $services->total() }}</span>
                </div>
                <div class="text-xs text-slate-500 hidden md:flex items-center gap-2">
                    <i class="fa-solid fa-circle-info"></i>
                    Cliquez sur “Modifier” pour ajuster un service.
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="text-left px-5 py-3 font-semibold">Service</th>
                        <th class="text-left px-5 py-3 font-semibold">Code</th>
                        <th class="text-left px-5 py-3 font-semibold">Statut</th>
                        <th class="text-right px-5 py-3 font-semibold">Actions</th>
                    </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                    @forelse($services as $service)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-5 py-4">
                                <div class="font-semibold text-slate-900 flex items-center gap-2">
                                    <span class="h-9 w-9 rounded-2xl bg-indigo-50 text-indigo-700 grid place-items-center">
                                        <i class="fa-solid fa-building"></i>
                                    </span>
                                    <div>
                                        <div class="leading-5">{{ $service->name }}</div>
                                        <div class="text-xs text-slate-500">ID: {{ $service->id }}</div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-5 py-4 text-slate-700">
                                <span class="inline-flex items-center gap-2 px-2.5 py-1 rounded-xl border border-slate-200 bg-white">
                                    <i class="fa-solid fa-hashtag text-slate-400"></i>
                                    <span class="font-semibold">{{ $service->code }}</span>
                                </span>
                            </td>

                            <td class="px-5 py-4">
                                @if($service->is_active)
                                    <span class="inline-flex items-center gap-2 px-2.5 py-1 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200 font-semibold">
                                        <i class="fa-solid fa-circle-check"></i> Actif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-2 px-2.5 py-1 rounded-xl bg-slate-100 text-slate-700 border border-slate-200 font-semibold">
                                        <i class="fa-solid fa-circle-minus"></i> Inactif
                                    </span>
                                @endif
                            </td>

                            <td class="px-5 py-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.services.edit', $service) }}"
                                       class="inline-flex items-center gap-2 px-3 py-2 rounded-2xl border border-slate-200 hover:bg-white text-slate-700 text-sm font-semibold transition">
                                        <i class="fa-solid fa-pen"></i> Modifier
                                    </a>

                                    <form action="{{ route('admin.services.destroy', $service) }}" method="POST"
                                          onsubmit="return confirm('Supprimer ce service ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="inline-flex items-center gap-2 px-3 py-2 rounded-2xl border border-rose-200 text-rose-700 hover:bg-rose-50 text-sm font-semibold transition">
                                            <i class="fa-solid fa-trash-can"></i> Supprimer
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-5 py-12 text-center text-slate-600" colspan="4">
                                <div class="font-extrabold text-slate-900 text-lg">Aucun service</div>
                                <div class="text-sm mt-1">Commencez par créer un premier service.</div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-5 py-4 border-t border-slate-200">
                {{ $services->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>