<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\ArticleCommande;
use App\Models\Boutique;

class ArtisanCommandeController extends Controller
{
    public function index()
    {
        // Récupérer la boutique de l'artisan connecté
        $boutique = Boutique::where('user_id', auth()->id())->first();
        
        if (!$boutique) {
            return redirect()->route('boutiques.creer')
                ->with('error', 'Vous devez d\'abord créer votre boutique.');
        }
        
        // Récupérer les produits de la boutique
        $produitIds = $boutique->produits()->pluck('id')->toArray();
        
        // Récupérer les articles de commande liés à ces produits
        $articleCommandes = ArticleCommande::whereIn('produit_id', $produitIds)
            ->with(['commande', 'produit'])
            ->get();
        
        // Récupérer les IDs des commandes concernées
        $commandeIds = $articleCommandes->pluck('commande_id')->unique()->toArray();
        
        // Récupérer les commandes
        $commandes = Commande::whereIn('id', $commandeIds)
            ->with(['user', 'articles' => function($query) use ($produitIds) {
                $query->whereIn('produit_id', $produitIds)->with('produit');
            }])
            ->latest()
            ->get();
        
        return view('artisan.commandes.index', compact('commandes', 'boutique'));
    }
    
    public function afficher(Commande $commande)
    {
        // Récupérer la boutique de l'artisan connecté
        $boutique = Boutique::where('user_id', auth()->id())->first();
        
        if (!$boutique) {
            return redirect()->route('boutiques.creer')
                ->with('error', 'Vous devez d\'abord créer votre boutique.');
        }
        
        // Récupérer les produits de la boutique
        $produitIds = $boutique->produits()->pluck('id')->toArray();
        
        // Charger la commande avec les articles concernant uniquement cette boutique
        $commande->load([
            'user', 
            'articles' => function($query) use ($produitIds) {
                $query->whereIn('produit_id', $produitIds)->with('produit');
            }
        ]);
        
        // Vérifier que la commande contient au moins un produit de cette boutique
        if ($commande->articles->isEmpty()) {
            return redirect()->route('artisan.commandes.index')
                ->with('error', 'Cette commande ne contient aucun de vos produits.');
        }
        
        return view('artisan.commandes.show', compact('commande', 'boutique'));
    }
    
    public function mettreAJourStatut(Request $request, Commande $commande)
    {
        $request->validate([
            'article_id' => 'required|exists:article_commandes,id',
            'statut' => 'required|in:en_attente,en_preparation,expedie,livre'
        ]);
        
        $articleId = $request->input('article_id');
        $nouveauStatut = $request->input('statut');
        
        // Récupérer la boutique de l'artisan connecté
        $boutique = Boutique::where('user_id', auth()->id())->first();
        
        if (!$boutique) {
            return back()->with('error', 'Boutique introuvable.');
        }
        
        // Vérifier que l'article de commande appartient à un produit de cette boutique
        $articleCommande = ArticleCommande::find($articleId);
        
        if (!$articleCommande) {
            return back()->with('error', 'Article de commande introuvable.');
        }
        
        $produitIds = $boutique->produits()->pluck('id')->toArray();
        
        if (!in_array($articleCommande->produit_id ?? 0, $produitIds)) {
            return back()->with('error', 'Vous n\'êtes pas autorisé à modifier le statut de cet article.');
        }
        
        // Mettre à jour le statut de l'article
        $articleCommande->update(['statut' => $nouveauStatut]);
        
        return back()->with('success', 'Le statut de l\'article a été mis à jour.');
    }
}
