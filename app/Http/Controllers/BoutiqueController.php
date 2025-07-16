<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Boutique;

class BoutiqueController extends Controller
{
    /**
     * Affiche la liste des boutiques pour les visiteurs du site
     */
    public function index()
    {
        $boutiques = Boutique::all();
        return view('boutiques.index', compact('boutiques'));
    }

    /**
     * Affiche une boutique pour les visiteurs
     */
    public function afficher(Boutique $boutique)
    {
        return view('boutiques.show', compact('boutique'));
    }
    
    /**
     * Enregistre un avis sur une boutique
     */
    public function enregistrerAvis(Request $request, Boutique $boutique)
    {
        $request->validate([
            'note' => 'required|integer|min:1|max:5',
            'commentaire' => 'nullable|string|max:500',
        ]);

        $boutique->avis()->create([
            'user_id' => auth()->id(),
            'note' => $request->note,
            'commentaire' => $request->commentaire,
        ]);

        return back()->with('success', 'Votre avis a été enregistré avec succès !');
    }
}
