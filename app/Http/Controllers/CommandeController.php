<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\ArticleCommande;
use App\Models\Produit;

class CommandeController extends Controller
{
    public function index()
    {
        $commandes = Commande::with(['user', 'articles.produit'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();
        
        return view('commandes.index', compact('commandes'));
    }

    public function afficher(Commande $commande)
    {
        // Vérifier que la commande appartient à l'utilisateur connecté
        if ($commande->user_id !== auth()->id()) {
            abort(403, 'Accès non autorisé');
        }
        
        $commande->load(['articles.produit.boutique', 'user']);
        return view('commandes.show', compact('commande'));
    }
    
    public function paiement()
    {
        $panier = session()->get('panier', []);
        
        if (empty($panier)) {
            return redirect()->route('panier.index')
                ->with('error', 'Votre panier est vide.');
        }
        
        $produits = Produit::whereIn('id', array_keys($panier))->get();
        $total = 0;
        
        foreach ($produits as $produit) {
            $total += $produit->prix * $panier[$produit->id];
        }
        
        return view('commandes.paiement', compact('produits', 'panier', 'total'));
    }

    public function enregistrer(Request $request)
    {
        $request->validate([
            'adresse_livraison' => 'required|string|max:255',
            'code_postal_livraison' => 'required|string|max:10',
            'ville_livraison' => 'required|string|max:100',
            'pays_livraison' => 'required|string|max:100',
            'telephone' => 'nullable|string|max:20',
        ]);

        $panier = session()->get('panier', []);
        
        if (empty($panier)) {
            return redirect()->route('panier.index')
                ->with('error', 'Votre panier est vide.');
        }
        
        $produits = Produit::whereIn('id', array_keys($panier))->get();
        $total = 0;
        
        // Vérifier le stock
        foreach ($produits as $produit) {
            if ($produit->stock < $panier[$produit->id]) {
                return back()->with('error', "Stock insuffisant pour le produit {$produit->nom}");
            }
            $total += $produit->prix * $panier[$produit->id];
        }
        
        // Créer la commande
        $commande = Commande::create([
            'user_id' => auth()->id(),
            'statut' => 'en_attente',
            'montant_total' => $total,
            'adresse_livraison' => $request->adresse_livraison,
            'code_postal_livraison' => $request->code_postal_livraison,
            'ville_livraison' => $request->ville_livraison,
            'pays_livraison' => $request->pays_livraison,
            'telephone' => $request->telephone,
        ]);
        
        // Créer les articles de commande et mettre à jour le stock
        foreach ($produits as $produit) {
            ArticleCommande::create([
                'commande_id' => $commande->id,
                'produit_id' => $produit->id,
                'quantite' => $panier[$produit->id],
                'prix_unitaire' => $produit->prix,
            ]);
            
            // Réduire le stock
            $produit->decrement('stock', $panier[$produit->id]);
        }
        
        // Vider le panier
        session()->forget('panier');
        
        return redirect()->route('commandes.afficher', $commande)
            ->with('success', 'Votre commande a été enregistrée avec succès !');
    }
}
