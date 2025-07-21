<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;

class PanierController extends Controller
{
    public function index()
    {
        $panier = session()->get('panier', []);
        $produits = [];
        $total = 0;
        
        if (!empty($panier)) {
            $produits = Produit::whereIn('id', array_keys($panier))->get();
            
            foreach ($produits as $produit) {
                $total += $produit->prix * $panier[$produit->id];
            }
        }
        
        return view('panier.index', compact('produits', 'panier', 'total'));
    }

    public function ajouter(Request $request)
    {
        $produit = Produit::findOrFail($request->input('produit_id'));
        $quantite = $request->input('quantite', 1);
        
        // Vérifier le stock
        if ($produit->stock < $quantite) {
            return back()->with('error', 'Stock insuffisant pour ce produit.');
        }
        
        $panier = session()->get('panier', []);
        $quantiteActuelle = $panier[$produit->id] ?? 0;
        
        // Vérifier que la quantité totale ne dépasse pas le stock
        if ($quantiteActuelle + $quantite > $produit->stock) {
            return back()->with('error', 'La quantité demandée dépasse le stock disponible.');
        }
        
        $panier[$produit->id] = $quantiteActuelle + $quantite;
        session(['panier' => $panier]);
        
        return redirect()->route('panier.index')
            ->with('success', 'Produit ajouté au panier !');
    }
    
    public function mettreAJour(Request $request, $produitId)
    {
        $request->validate([
            'quantite' => 'required|integer|min:1',
        ]);
        
        $produit = Produit::findOrFail($produitId);
        $quantite = $request->input('quantite');
        
        // Vérifier le stock
        if ($produit->stock < $quantite) {
            return back()->with('error', 'Stock insuffisant pour ce produit.');
        }
        
        $panier = session()->get('panier', []);
        $panier[$produitId] = $quantite;
        session(['panier' => $panier]);
        
        return redirect()->route('panier.index')
            ->with('success', 'Quantité mise à jour !');
    }
    
    public function supprimer($produitId)
    {
        $panier = session()->get('panier', []);
        
        if (isset($panier[$produitId])) {
            unset($panier[$produitId]);
            session(['panier' => $panier]);
        }
        
        return redirect()->route('panier.index')
            ->with('success', 'Produit retiré du panier !');
    }
    
    public function vider()
    {
        session()->forget('panier');
        
        return redirect()->route('panier.index')
            ->with('success', 'Votre panier a été vidé !');
    }
}
