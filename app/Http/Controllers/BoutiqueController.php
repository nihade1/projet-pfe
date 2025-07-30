<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Boutique;

class BoutiqueController extends Controller
{
    /**
     * Affiche la liste des boutiques pour les visiteurs du site
     */
    public function index(Request $request)
    {
        $query = Boutique::with(['artisan.user', 'produits']);
        
        // Recherche par nom de boutique
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('nom', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhereHas('artisan.user', function($q) use ($search) {
                      $q->where('name', 'like', '%' . $search . '%');
                  });
        }
        
        $boutiques = $query->latest()->paginate(9);
        return view('boutiques.index', compact('boutiques'));
    }

    /**
     * Affiche une boutique pour les visiteurs
     */
    public function afficher(Boutique $boutique)
    {
        $boutique->load(['artisan.user', 'produits.categorie']);
        
        // Récupérer les avis via les produits de la boutique
        // Nous nous assurons que $avis est toujours une collection, même vide
        $avis = $boutique->avis()->with('user')->get();
        
        return view('boutiques.show', compact('boutique', 'avis'));
    }
    
    /**
     * Enregistre un avis sur une boutique (via un de ses produits)
     * Note: Cette fonctionnalité nécessite de choisir un produit spécifique
     */
    public function enregistrerAvis(Request $request, Boutique $boutique)
    {
        $request->validate([
            'note' => 'required|integer|min:1|max:5',
            'commentaire' => 'nullable|string|max:500',
            'produit_id' => 'required|exists:produits,id'
        ]);

        // Vérifier que le produit appartient bien à cette boutique
        $produit = $boutique->produits()->findOrFail($request->produit_id);

        \App\Models\Avis::create([
            'user_id' => auth()->id(),
            'produit_id' => $produit->id,
            'note' => $request->note,
            'commentaire' => $request->commentaire,
        ]);

        return back()->with('success', 'Votre avis a été enregistré avec succès !');
    }
}
