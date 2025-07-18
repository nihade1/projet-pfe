<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artisan;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ArtisanController extends Controller
{
    /**
     * Affiche le formulaire d'inscription pour un artisan
     */
    public function create()
    {
        return view('artisans.create');
    }

    /**
     * Enregistre un nouvel artisan
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'required|string|max:255',
            'ville' => 'required|string|max:100',
            'code_postal' => 'required|string|max:10',
            'specialite' => 'required|string|max:255',
            'experience' => 'required|integer|min:0',
        ]);

        // Créer l'utilisateur
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'artisan',
        ]);

        // Créer le profil artisan
        Artisan::create([
            'user_id' => $user->id,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
            'ville' => $request->ville,
            'code_postal' => $request->code_postal,
            'specialite' => $request->specialite,
            'experience' => $request->experience,
        ]);

        return redirect()->route('artisan.boutique.creer')
            ->with('success', 'Votre compte artisan a été créé avec succès ! Créez maintenant votre boutique.');
    }

    /**
     * Affiche le profil public d'un artisan
     */
    public function show(Artisan $artisan)
    {
        $artisan->load(['user', 'boutique.produits']);
        return view('artisans.show', compact('artisan'));
    }
    
    /**
     * Affiche la liste des artisans
     */
    public function index()
    {
        $artisans = Artisan::with(['user', 'boutique'])
            ->latest()
            ->paginate(12);
        
        return view('artisans.index', compact('artisans'));
    }
}
