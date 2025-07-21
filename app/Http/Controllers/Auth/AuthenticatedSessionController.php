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
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();
        
        if ($user->role === 'artisan') {
            // Si l'utilisateur est un artisan
            if ($user->artisan) {
                // S'il a déjà un profil artisan, vérifier s'il a une boutique
                if ($user->artisan->boutique) {
                    return redirect()->route('artisan.boutique.dashboard');
                } else {
                    return redirect()->route('artisan.boutique.creer');
                }
            } else {
                // S'il n'a pas encore de profil artisan, le rediriger vers la création
                return redirect()->route('artisan.boutique.creer');
            }
        } else {
            // Si c'est un client, le rediriger vers la page d'accueil
            return redirect()->route('index');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
