<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Artisan;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['nullable', 'string', 'in:artisan,customer'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? 'customer',
        ]);

        event(new Registered($user));

        Auth::login($user);
        
        // Si l'utilisateur est un artisan, créer un profil artisan et rediriger vers la création de boutique
        if ($user->role === 'artisan') {
            try {
                Artisan::create([
                    'user_id' => $user->id,
                ]);
                
                return redirect()->route('artisan.boutique.creer')->with('success', 'Inscription réussie ! Créez maintenant votre boutique.');
            } catch (\Exception $e) {
                // En cas d'erreur, loguer et rediriger avec un message d'erreur
                Log::error('Erreur création artisan: ' . $e->getMessage());
                return redirect()->route('register')->with('error', 'Erreur lors de la création du profil artisan: ' . $e->getMessage());
            }
        }

        return redirect()->route('index')->with('success', 'Inscription réussie ! Bienvenue sur ArtisanMarket.');
    }
}
