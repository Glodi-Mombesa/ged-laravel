<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        // ✅ Seul un admin connecté peut ouvrir /register
        if (!auth()->check() || !auth()->user()->hasRole('admin')) {
            abort(403, 'Accès refusé.');
        }

        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // ✅ Seul un admin connecté peut créer un compte
        if (!auth()->check() || !auth()->user()->hasRole('admin')) {
            abort(403, 'Accès refusé.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // (Optionnel mais utile) : déclenche l’événement d’inscription
        event(new Registered($user));

        // ✅ IMPORTANT : On NE connecte PAS le nouvel utilisateur
        // Auth::login($user);

        return redirect()->route('dashboard');
    }
}