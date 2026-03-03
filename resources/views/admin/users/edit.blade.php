<x-admin-layout title="Modifier utilisateur">
    <div class="max-w-3xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-extrabold text-slate-900 flex items-center gap-3">
                <span class="h-10 w-10 rounded-2xl bg-indigo-50 text-indigo-700 grid place-items-center">
                    <i class="fa-solid fa-user-gear"></i>
                </span>
                Modifier l’utilisateur
            </h1>
            <p class="text-slate-600 mt-1">Mets à jour les infos et le rôle. Mot de passe optionnel.</p>
        </div>

        <form method="POST" action="{{ route('admin.users.update', $user) }}"
              class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
            @csrf
            @method('PUT')

            <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex items-center justify-between">
                <div class="text-sm text-slate-600">
                    <span class="font-semibold text-slate-900">{{ $user->name }}</span>
                    <span class="text-slate-400">•</span>
                    <span class="text-slate-600">{{ $user->email }}</span>
                </div>
                <span class="text-xs px-2.5 py-1 rounded-xl border border-slate-200 bg-white text-slate-700 font-semibold">
                    ID: {{ $user->id }}
                </span>
            </div>

            <div class="p-6 space-y-5">
                <div>
                    <label class="text-sm font-semibold text-slate-700">Nom</label>
                    <input name="name" value="{{ old('name', $user->name) }}" required
                           class="mt-1 w-full rounded-2xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                    @error('name') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="text-sm font-semibold text-slate-700">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                           class="mt-1 w-full rounded-2xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                    @error('email') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="text-sm font-semibold text-slate-700">Rôle</label>
                    @php $role = $user->getRoleNames()->first() ?? 'user'; @endphp
                    <select name="role" required
                            class="mt-1 w-full rounded-2xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="user" @selected(old('role', $role)==='user')>User</option>
                        <option value="admin" @selected(old('role', $role)==='admin')>Admin</option>
                    </select>
                    @error('role') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Nouveau mot de passe (optionnel)</label>
                        <div class="mt-1 relative">
                            <input id="password" type="password" name="password"
                                   class="w-full rounded-2xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 pr-12">
                            <button type="button" data-toggle-password="#password"
                                    class="absolute inset-y-0 right-0 px-4 text-slate-500 hover:text-slate-900">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                        @error('password') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-slate-700">Confirmation</label>
                        <div class="mt-1 relative">
                            <input id="password_confirmation" type="password" name="password_confirmation"
                                   class="w-full rounded-2xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 pr-12">
                            <button type="button" data-toggle-password="#password_confirmation"
                                    class="absolute inset-y-0 right-0 px-4 text-slate-500 hover:text-slate-900">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-slate-200 bg-white flex items-center justify-between">
                <a href="{{ route('admin.users.index') }}"
                   class="px-4 py-2 rounded-2xl border border-slate-200 text-slate-700 hover:bg-slate-50">
                    Retour
                </a>
                <button class="px-5 py-2.5 rounded-2xl bg-indigo-600 text-white font-semibold shadow-sm hover:bg-indigo-700 transition">
                    Mettre à jour
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>