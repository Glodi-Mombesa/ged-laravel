<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Affiche la page login
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Gère la tentative de connexion
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Authentifie l'utilisateur
        $request->authenticate();

        // Régénère la session pour sécurité
        $request->session()->regenerate();

        $user = $request->user();

        // 🔐 Sécurité : si pour une raison quelconque pas d'utilisateur
        if (!$user) {
            return redirect()->route('login');
        }

        /*
        |--------------------------------------------------------------------------
        | Redirection selon le rôle
        |--------------------------------------------------------------------------
        */

        // ✅ Admin → /admin
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        // ✅ User → /user
        if ($user->hasRole('user')) {
            return redirect()->route('user.home');
        }

        // ⚠️ Si aucun rôle valide → on déconnecte
        Auth::logout();

        return redirect()
            ->route('login')
            ->with('status', 'Compte non autorisé.');
    }

    /**
     * Déconnexion
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome');
    }
}