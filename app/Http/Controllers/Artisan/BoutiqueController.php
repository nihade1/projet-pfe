<?php

namespace App\Http\Controllers\Artisan;

use App\Http\Controllers\Controller;
use App\Models\Boutique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BoutiqueController extends Controller
{
    /**
     * Affiche le formulaire de création de boutique.
     */
    public function creer()
    {
        // Vérifier si l'artisan a déjà une boutique
        $artisan = Auth::user()->artisan;
        if ($artisan->boutique) {
            return redirect()->route('artisan.boutique.editer')
                ->with('info', 'Vous avez déjà une boutique. Vous pouvez la modifier ici.');
        }
        
        return view('boutiques.create');
    }

    /**
     * Enregistre une nouvelle boutique.
     */
    public function enregistrer(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'description' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);

        $artisan = Auth::user()->artisan;

        $boutique = new Boutique([
            'nom' => $request->nom,
            'description' => $request->description,
            'artisan_id' => $artisan->id,
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('boutiques', 'public');
            $boutique->photo = $path;
        }

        $boutique->save();

        return redirect()->route('artisan.boutique.dashboard')
            ->with('success', 'Votre boutique a été créée avec succès ! Vous pouvez maintenant ajouter des produits à votre boutique.');
    }

    /**
     * Affiche le tableau de bord de la boutique.
     */
    public function dashboard()
    {
        $artisan = Auth::user()->artisan;
        $boutique = $artisan->boutique;
        
        if (!$boutique) {
            return redirect()->route('artisan.boutique.creer')
                ->with('info', 'Vous devez d\'abord créer votre boutique.');
        }

        $produits = $boutique->produits()->latest()->get();
        $commandes = $boutique->commandes()->orderBy('created_at', 'desc')->take(5)->get();
        
        return view('artisan.boutique.dashboard', compact('boutique', 'produits', 'commandes'));
    }

    /**
     * Affiche le formulaire de modification de la boutique.
     */
    public function editer()
    {
        $artisan = Auth::user()->artisan;
        $boutique = $artisan->boutique;
        
        if (!$boutique) {
            return redirect()->route('artisan.boutique.creer')
                ->with('info', 'Vous devez d\'abord créer votre boutique.');
        }
        
        return view('artisan.boutique.edit', compact('boutique'));
    }

    /**
     * Met à jour la boutique.
     */
    public function mettreAJour(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'description' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);

        $artisan = Auth::user()->artisan;
        $boutique = $artisan->boutique;

        $boutique->nom = $request->nom;
        $boutique->description = $request->description;

        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo si elle existe
            if ($boutique->photo) {
                Storage::disk('public')->delete($boutique->photo);
            }
            
            $path = $request->file('photo')->store('boutiques', 'public');
            $boutique->photo = $path;
        }

        $boutique->save();

        return redirect()->route('artisan.boutique.dashboard')
            ->with('success', 'Votre boutique a été mise à jour avec succès !');
    }
}
