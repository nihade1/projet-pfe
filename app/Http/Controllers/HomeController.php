<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;
use App\Models\Boutique;
use App\Models\Categorie;

class HomeController extends Controller
{
    public function index()
    {
        // Récupérer quelques produits mis en avant
        $produitsMisEnAvant = Produit::with(['boutique', 'categorie'])
            ->where('stock', '>', 0)
            ->latest()
            ->take(8)
            ->get();
        
        // Récupérer quelques boutiques
        $boutiques = Boutique::with('artisan')
            ->latest()
            ->take(6)
            ->get();
        
        // Récupérer les catégories
        $categories = Categorie::all();
        
        return view('index', compact('produitsMisEnAvant', 'boutiques', 'categories'));
    }
    
    public function recherche(Request $request)
    {
        $query = $request->get('q');
        $categorie = $request->get('categorie');
        
        $produits = Produit::query()
            ->with(['boutique', 'categorie'])
            ->where('stock', '>', 0);
        
        if ($query) {
            $produits->where(function($q) use ($query) {
                $q->where('nom', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            });
        }
        
        if ($categorie) {
            $produits->where('categorie_id', $categorie);
        }
        
        $produits = $produits->paginate(12);
        $categories = Categorie::all();
        
        return view('recherche', compact('produits', 'categories', 'query', 'categorie'));
    }
}