<x-admin-layout title="Utilisateurs">
    <div class="max-w-7xl mx-auto">

        {{-- Header (comme Documents) --}}
        <div class="mb-6 flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 flex items-center gap-3">
                    <span class="h-10 w-10 rounded-2xl bg-indigo-50 text-indigo-700 grid place-items-center">
                        <i class="fa-solid fa-users"></i>
                    </span>
                    Utilisateurs
                </h1>
                <p class="text-slate-600 mt-1">
                    Gestion des comptes : création, rôles et sécurité.
                </p>
            </div>

            <a href="{{ route('admin.users.create') }}"
               class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-2xl bg-indigo-600 text-white font-semibold shadow-sm hover:bg-indigo-700 transition">
                <i class="fa-solid fa-user-plus"></i>
                Nouvel utilisateur
            </a>
        </div>

        {{-- Mini stats --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-5">
                <div class="text-sm text-slate-500">Total</div>
                <div class="text-3xl font-extrabold text-slate-900 mt-1">{{ $total ?? $users->total() }}</div>
                <div class="text-xs text-slate-500 mt-1">Tous comptes</div>
            </div>
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-5">
                <div class="text-sm text-slate-500">Admins</div>
                <div class="text-3xl font-extrabold text-slate-900 mt-1">{{ $adminsCount ?? '—' }}</div>
                <div class="text-xs text-slate-500 mt-1">Accès complet admin</div>
            </div>
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-5">
                <div class="text-sm text-slate-500">Users</div>
                <div class="text-3xl font-extrabold text-slate-900 mt-1">{{ $usersCount ?? '—' }}</div>
                <div class="text-xs text-slate-500 mt-1">Accès standard</div>
            </div>
        </div>

        {{-- Filtres (comme Documents : une barre propre et responsive) --}}
        <form method="GET" class="bg-white rounded-3xl border border-slate-200 shadow-sm p-4 mb-6">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-3 items-center">
                <div class="lg:col-span-6 flex items-center gap-2 rounded-2xl border border-slate-200 px-3 py-2">
                    <i class="fa-solid fa-magnifying-glass text-slate-400"></i>
                    <input name="q" value="{{ $q ?? request('q') }}"
                           placeholder="Recherche (nom ou email)..."
                           class="w-full border-0 focus:ring-0 text-sm text-slate-700 placeholder:text-slate-400">
                </div>

                <div class="lg:col-span-3">
                    <select name="role"
                            class="w-full rounded-2xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        <option value="">Tous rôles</option>
                        <option value="admin" @selected(($role ?? request('role'))==='admin')>Admin</option>
                        <option value="user" @selected(($role ?? request('role'))==='user')>User</option>
                    </select>
                </div>

                <div class="lg:col-span-3 flex gap-2">
                    <button class="flex-1 px-4 py-2 rounded-2xl bg-slate-900 text-white font-semibold hover:bg-slate-800 transition text-sm inline-flex items-center justify-center gap-2">
                        <i class="fa-solid fa-filter"></i>
                        Filtrer
                    </button>
                    <a href="{{ route('admin.users.index') }}"
                       class="px-4 py-2 rounded-2xl border border-slate-200 text-slate-700 hover:bg-slate-50 transition text-sm">
                        Reset
                    </a>
                </div>
            </div>

            <div class="mt-3 text-xs text-slate-500 flex items-center gap-2">
                <i class="fa-solid fa-circle-info"></i>
                Astuce : évite de donner le rôle <b>admin</b> à tout le monde.
            </div>
        </form>

        {{-- Table --}}
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-200 flex items-center justify-between">
                <div class="text-sm text-slate-600">
                    Total affiché : <span class="font-semibold text-slate-900">{{ $users->total() }}</span>
                </div>
                <div class="text-xs text-slate-500 hidden md:flex items-center gap-2">
                    <i class="fa-solid fa-shield-halved"></i>
                    Supprime avec prudence (comptes et accès).
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 text-slate-600">
                        <tr>
                            <th class="text-left font-semibold px-5 py-3">Utilisateur</th>
                            <th class="text-left font-semibold px-5 py-3">Email</th>
                            <th class="text-left font-semibold px-5 py-3">Rôle</th>
                            <th class="text-right font-semibold px-5 py-3">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @forelse($users as $user)
                            @php $roleName = $user->getRoleNames()->first() ?? 'user'; @endphp

                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <span class="h-10 w-10 rounded-2xl bg-indigo-50 text-indigo-700 grid place-items-center shrink-0">
                                            <i class="fa-solid fa-user"></i>
                                        </span>
                                        <div class="min-w-0">
                                            <div class="font-semibold text-slate-900 truncate">{{ $user->name }}</div>
                                            <div class="text-xs text-slate-500">ID : {{ $user->id }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-5 py-4 text-slate-700">
                                    <div class="inline-flex items-center gap-2">
                                        <i class="fa-solid fa-envelope text-slate-400"></i>
                                        <span class="break-all">{{ $user->email }}</span>
                                    </div>
                                </td>

                                <td class="px-5 py-4">
                                    @if($roleName === 'admin')
                                        <span class="inline-flex items-center gap-2 px-2.5 py-1 rounded-xl bg-indigo-50 text-indigo-700 border border-indigo-200 font-semibold">
                                            <i class="fa-solid fa-user-shield"></i> Admin
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-2 px-2.5 py-1 rounded-xl bg-slate-50 text-slate-700 border border-slate-200 font-semibold">
                                            <i class="fa-solid fa-user-check"></i> User
                                        </span>
                                    @endif
                                </td>

                                <td class="px-5 py-4">
                                    <div class="flex justify-end flex-wrap gap-2">
                                        <a href="{{ route('admin.users.edit', $user) }}"
                                           class="inline-flex items-center gap-2 px-3 py-2 rounded-2xl border border-slate-200 hover:bg-white text-slate-700 text-sm font-semibold transition">
                                            <i class="fa-solid fa-pen"></i>
                                            Modifier
                                        </a>

                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                              onsubmit="return confirm('Supprimer cet utilisateur ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="inline-flex items-center gap-2 px-3 py-2 rounded-2xl border border-rose-200 text-rose-700 hover:bg-rose-50 text-sm font-semibold transition">
                                                <i class="fa-solid fa-trash-can"></i>
                                                Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-5 py-12 text-center text-slate-600">
                                    <div class="font-extrabold text-slate-900 text-lg">Aucun utilisateur</div>
                                    <div class="text-sm mt-1">Crée ton premier compte utilisateur.</div>
                                    <a href="{{ route('admin.users.create') }}"
                                       class="inline-flex items-center gap-2 mt-4 px-5 py-2.5 rounded-2xl bg-indigo-600 text-white hover:bg-indigo-700 font-semibold transition">
                                        <i class="fa-solid fa-user-plus"></i>
                                        Nouvel utilisateur
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-5 py-4 border-t border-slate-200">
                {{ $users->links() }}
            </div>
        </div>

    </div>
</x-admin-layout>