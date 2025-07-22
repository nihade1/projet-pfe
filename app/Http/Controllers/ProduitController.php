<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;
use App\Models\Categorie;
use App\Models\Avis;

class ProduitController extends Controller
{
    public function index(Request $request)
    {
        $query = Produit::query()->with(['boutique', 'categorie']);
        
        if ($request->filled('categorie')) {
            $query->where('categorie_id', $request->categorie);
        }
        
        if ($request->filled('artisan')) {
            $query->whereHas('boutique', function($q) use ($request) {
                $q->where('artisan_id', $request->artisan);
            });
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        $produits = $query->where('stock', '>', 0)->paginate(12);
        $categories = Categorie::all();
        
        return view('produits.index', compact('produits', 'categories'));
    }

    public function afficher(Produit $produit)
    {
        $produit->load(['boutique.artisan', 'categorie', 'avis.user']);
        $produitsRelies = Produit::where('categorie_id', $produit->categorie_id)
            ->where('id', '!=', $produit->id)
            ->where('stock', '>', 0)
            ->take(4)
            ->get();
        
        return view('produits.show', compact('produit', 'produitsRelies'));
    }
    
    public function parCategorie(Categorie $categorie, Request $request)
    {
        $query = Produit::query()->with(['boutique', 'categorie'])
            ->where('categorie_id', $categorie->id);
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        $produits = $query->where('stock', '>', 0)->paginate(12);
        $categories = Categorie::all();
        
        return view('produits.categorie', compact('produits', 'categories', 'categorie'));
    }
    
    public function enregistrerAvis(Request $request, Produit $produit)
    {
        $request->validate([
            'note' => 'required|integer|min:1|max:5',
            'commentaire' => 'nullable|string|max:500',
        ]);

        $produit->avis()->create([
            'user_id' => auth()->id(),
            'note' => $request->note,
            'commentaire' => $request->commentaire,
        ]);

        return back()->with('success', 'Votre avis a été enregistré avec succès !');
    }
}
