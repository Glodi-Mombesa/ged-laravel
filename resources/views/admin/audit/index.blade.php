<x-admin-layout title="Historique" subtitle="Traçabilité : qui a fait quoi, quand, depuis où.">
    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900">
                <i class="fa-solid fa-receipt text-indigo-600 mr-2"></i>
                Historique
            </h1>
            <p class="text-slate-600 mt-1">Journal d’audit des actions (sécurité et imputabilité).</p>
        </div>

        {{-- Optionnel : bouton vider selon filtres --}}
        <form method="POST" action="{{ route('admin.audit.clear') }}"
              onsubmit="return confirm('Supprimer tous les historiques correspondant aux filtres ?');"
              class="self-start">
            @csrf
            @method('DELETE')
            <input type="hidden" name="q" value="{{ $q }}">
            <input type="hidden" name="action" value="{{ $action }}">
            <input type="hidden" name="entity" value="{{ $entity }}">

            <button class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl border border-rose-200 bg-rose-50 text-rose-700 font-semibold hover:bg-rose-100 transition">
                <i class="fa-solid fa-trash-can"></i>
                Vider (filtré)
            </button>
        </form>
    </div>

    {{-- Filtres --}}
    <form class="bg-white rounded-3xl shadow-sm border border-slate-200 p-4 mb-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
            <div class="relative">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-3.5 text-slate-400"></i>
                <input name="q" value="{{ $q }}" placeholder="Recherche (route, ip, type...)"
                       class="w-full pl-10 rounded-2xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <select name="action" class="w-full rounded-2xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Toutes actions</option>
                @foreach($actions as $a)
                    <option value="{{ $a }}" @selected($action===$a)>{{ $a }}</option>
                @endforeach
            </select>

            <select name="entity" class="w-full rounded-2xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Toutes entités</option>
                @foreach($entities as $e)
                    <option value="{{ $e }}" @selected($entity===$e)>{{ $e }}</option>
                @endforeach
            </select>

            <div class="flex gap-2">
                <button class="flex-1 px-4 py-2 rounded-2xl bg-slate-900 text-white font-semibold hover:bg-slate-800 transition">
                    <i class="fa-solid fa-filter mr-2"></i> Filtrer
                </button>
                <a href="{{ route('admin.audit.index') }}"
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
                Total : <span class="font-semibold text-slate-900">{{ $logs->total() }}</span>
            </div>
            <div class="text-xs text-slate-500 hidden sm:flex items-center gap-2">
                <i class="fa-solid fa-shield-halved text-emerald-600"></i>
                Audit admin
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                <tr>
                    <th class="text-left font-semibold px-4 py-3">Date</th>
                    <th class="text-left font-semibold px-4 py-3">Utilisateur</th>
                    <th class="text-left font-semibold px-4 py-3">Action</th>
                    <th class="text-left font-semibold px-4 py-3">Entité</th>
                    <th class="text-left font-semibold px-4 py-3">Route</th>
                    <th class="text-left font-semibold px-4 py-3">IP</th>
                    <th class="text-right font-semibold px-4 py-3">Supprimer</th>
                </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                @forelse($logs as $log)
                    @php
                        $badge = match($log->action) {
                            'created' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                            'updated' => 'bg-amber-50 text-amber-700 border-amber-200',
                            'deleted' => 'bg-rose-50 text-rose-700 border-rose-200',
                            default   => 'bg-slate-50 text-slate-700 border-slate-200',
                        };
                    @endphp

                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3 text-slate-700">
                            <div class="font-medium">{{ $log->created_at->format('d/m/Y H:i') }}</div>
                        </td>

                        <td class="px-4 py-3">
                            <div class="font-semibold text-slate-900">{{ $log->user?->name ?? '—' }}</div>
                            <div class="text-xs text-slate-500">{{ $log->user?->email ?? '' }}</div>
                        </td>

                        <td class="px-4 py-3">
                            <span class="inline-flex items-center gap-2 px-2.5 py-1 rounded-xl border font-semibold {{ $badge }}">
                                <i class="fa-solid fa-bolt"></i> {{ $log->action }}
                            </span>
                        </td>

                        <td class="px-4 py-3 text-slate-700">
                            <div class="font-medium">{{ $log->entity_type }}</div>
                            <div class="text-xs text-slate-500">ID: {{ $log->entity_id ?? '—' }}</div>
                        </td>

                        <td class="px-4 py-3 text-slate-700">
                            <div class="truncate max-w-[320px]">{{ $log->route }}</div>
                        </td>

                        <td class="px-4 py-3 text-slate-700">{{ $log->ip }}</td>

                        <td class="px-4 py-3 text-right">
                            <form method="POST" action="{{ route('admin.audit.destroy', $log) }}"
                                  onsubmit="return confirm('Supprimer cet historique ?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button class="inline-flex items-center gap-2 px-3 py-2 rounded-2xl border border-rose-200 text-rose-700 hover:bg-rose-50 transition">
                                    <i class="fa-solid fa-trash-can"></i>
                                    <span class="hidden sm:inline">Supprimer</span>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-10 text-center text-slate-600">
                            Aucun log pour le moment.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-4 py-3 border-t border-slate-200">
            {{ $logs->links() }}
        </div>
    </div>
</x-admin-layout>