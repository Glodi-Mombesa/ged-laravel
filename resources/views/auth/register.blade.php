<x-guest-layout>
    <div class="space-y-6">
        <div>
            <h2 class="text-2xl font-extrabold text-slate-900">Créer un compte</h2>
            <p class="text-sm text-slate-600 mt-1">
                Inscris-toi pour accéder à la GED.
            </p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Nom complet')" />
                <div class="mt-1 relative">
                    <span class="absolute inset-y-0 left-3 flex items-center text-slate-400">
                        <i class="fa-regular fa-user"></i>
                    </span>
                    <x-text-input
                        id="name"
                        class="block w-full pl-10 rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500"
                        type="text"
                        name="name"
                        :value="old('name')"
                        required
                        autofocus
                        autocomplete="name"
                        placeholder="Ex: Glodi M."
                    />
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <div class="mt-1 relative">
                    <span class="absolute inset-y-0 left-3 flex items-center text-slate-400">
                        <i class="fa-regular fa-envelope"></i>
                    </span>
                    <x-text-input
                        id="email"
                        class="block w-full pl-10 rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autocomplete="username"
                        placeholder="ex: glodi@gmail.com"
                    />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Mot de passe')" />
                <div class="mt-1 relative">
                    <span class="absolute inset-y-0 left-3 flex items-center text-slate-400">
                        <i class="fa-solid fa-lock"></i>
                    </span>

                    <x-text-input
                        id="password"
                        class="block w-full pl-10 pr-12 rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500"
                        type="password"
                        name="password"
                        required
                        autocomplete="new-password"
                        placeholder="Minimum 6 caractères"
                    />

                    <button type="button"
                            class="absolute inset-y-0 right-3 flex items-center text-slate-400 hover:text-slate-600"
                            data-toggle-password="#password"
                            aria-label="Afficher/Masquer">
                        <i class="fa-regular fa-eye"></i>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" />
                <div class="mt-1 relative">
                    <span class="absolute inset-y-0 left-3 flex items-center text-slate-400">
                        <i class="fa-solid fa-lock"></i>
                    </span>

                    <x-text-input
                        id="password_confirmation"
                        class="block w-full pl-10 pr-12 rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500"
                        type="password"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                        placeholder="Répète le mot de passe"
                    />

                    <button type="button"
                            class="absolute inset-y-0 right-3 flex items-center text-slate-400 hover:text-slate-600"
                            data-toggle-password="#password_confirmation"
                            aria-label="Afficher/Masquer">
                        <i class="fa-regular fa-eye"></i>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="pt-2 flex items-center justify-between gap-3">
                <a href="{{ route('login') }}"
                   class="text-sm font-semibold text-indigo-700 hover:text-indigo-900">
                    Déjà inscrit ? Se connecter
                </a>

                <button
                    class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl bg-indigo-600 text-white font-semibold shadow hover:bg-indigo-700 active:scale-[0.99] transition"
                >
                    <i class="fa-solid fa-user-plus"></i>
                    <span>S’inscrire</span>
                </button>
            </div>
        </form>
    </div>

    <script>
        // Toggle password visibility
        document.querySelectorAll('[data-toggle-password]').forEach(btn => {
            btn.addEventListener('click', () => {
                const selector = btn.getAttribute('data-toggle-password');
                const input = document.querySelector(selector);
                if (!input) return;

                const isPassword = input.getAttribute('type') === 'password';
                input.setAttribute('type', isPassword ? 'text' : 'password');

                const icon = btn.querySelector('i');
                if (icon) {
                    icon.classList.toggle('fa-eye', !isPassword);
                    icon.classList.toggle('fa-eye-slash', isPassword);
                }
            });
        });
    </script>
</x-guest-layout>