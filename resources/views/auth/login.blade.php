<x-guest-layout>

    <div class="space-y-6">

        <!-- Titre -->
        <div>
            <h2 class="text-2xl font-extrabold text-slate-900">
                Connexion Administrateur
            </h2>
            <p class="text-sm text-slate-600 mt-1">
                Accédez à la plateforme GED sécurisée.
            </p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4 text-emerald-600" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Email -->
            <div>
                <x-input-label for="email" :value="__('Adresse Email')" />
                <div class="mt-1 relative">
                    <span class="absolute inset-y-0 left-3 flex items-center text-slate-400">
                        <i class="fa-regular fa-envelope"></i>
                    </span>

                    <x-text-input
                        id="email"
                        class="block w-full pl-10 rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 transition"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="ex: admin@ged.com"
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
                        class="block w-full pl-10 pr-12 rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 transition"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        placeholder="••••••••"
                    />

                    <!-- Toggle Password -->
                    <button type="button"
                            class="absolute inset-y-0 right-3 flex items-center text-slate-400 hover:text-slate-600 transition"
                            data-toggle-password="#password">
                        <i class="fa-regular fa-eye"></i>
                    </button>

                </div>

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember -->
            <div class="flex items-center justify-between">

                <label class="inline-flex items-center text-sm text-slate-600">
                    <input type="checkbox"
                           name="remember"
                           class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 mr-2">
                    Se souvenir de moi
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                       class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition">
                        Mot de passe oublié ?
                    </a>
                @endif

            </div>

            <!-- Submit -->
            <button
                class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-indigo-600 text-white font-semibold shadow-lg hover:bg-indigo-700 hover:scale-[1.01] active:scale-[0.99] transition duration-200"
            >
                <i class="fa-solid fa-right-to-bracket"></i>
                Se connecter
            </button>

            <!-- Message pro -->
            <div class="text-xs text-center text-slate-500 pt-2 border-t border-slate-200">
                Les comptes utilisateurs sont créés uniquement par l’administrateur.
            </div>

        </form>

    </div>


    <!-- Toggle Password Script -->
    <script>
        document.querySelectorAll('[data-toggle-password]').forEach(btn => {
            btn.addEventListener('click', () => {
                const selector = btn.getAttribute('data-toggle-password');
                const input = document.querySelector(selector);

                if (!input) return;

                const isPassword = input.type === 'password';
                input.type = isPassword ? 'text' : 'password';

                const icon = btn.querySelector('i');
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
            });
        });
    </script>

</x-guest-layout>