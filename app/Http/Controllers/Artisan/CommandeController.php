<?php

namespace App\Http\Controllers\Artisan;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\ArticleCommande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommandeController extends Controller
{
    /**
     * Affiche la liste des commandes de l'artisan.
     */
    public function index()
    {
        $artisan = Auth::user()->artisan;
        $boutique = $artisan->boutique;
        
        if (!$boutique) {
            return redirect()->route('artisan.boutique.creer')
                ->with('info', 'Vous devez d\'abord créer votre boutique.');
        }
        
        // Récupérer les commandes liées aux produits de cette boutique
        $commandes = Commande::whereHas('articles', function($query) use ($boutique) {
            $query->whereHas('produit', function($query) use ($boutique) {
                $query->where('boutique_id', $boutique->id);
            });
        })->with(['user', 'articles.produit'])->latest()->paginate(10);
        
        // Calculer les montants et statuts pour chaque commande
        foreach ($commandes as $commande) {
            // Calculer le montant des articles de cette boutique
            $commande->montant_boutique = $commande->articles()
                ->whereHas('produit', function($query) use ($boutique) {
                    $query->where('boutique_id', $boutique->id);
                })
                ->sum(\DB::raw('prix * quantite'));
            
            // Déterminer le statut prédominant des articles de cette boutique
            $articles = $commande->articles()
                ->whereHas('produit', function($query) use ($boutique) {
                    $query->where('boutique_id', $boutique->id);
                })
                ->get();
            
            $statut = 'en_attente'; // Par défaut
            if ($articles->where('statut', 'en_preparation')->count() > 0) $statut = 'en_preparation';
            if ($articles->where('statut', 'expediee')->count() == $articles->count()) $statut = 'expediee';
            if ($articles->where('statut', 'livree')->count() == $articles->count()) $statut = 'livree';
            if ($articles->where('statut', 'annulee')->count() == $articles->count()) $statut = 'annulee';
            
            $commande->statut_boutique = $statut;
        }
        
        return view('artisan.commandes.index', compact('commandes', 'boutique'));
    }

    /**
     * Affiche les détails d'une commande.
     */
    public function afficher(Commande $commande)
    {
        $artisan = Auth::user()->artisan;
        $boutique = $artisan->boutique;
        
        if (!$boutique) {
            return redirect()->route('artisan.boutique.creer')
                ->with('info', 'Vous devez d\'abord créer votre boutique.');
        }
        
        // Vérifier que la commande contient au moins un produit de la boutique de l'artisan
        $peutVoir = $commande->articles()->whereHas('produit', function($query) use ($boutique) {
            $query->where('boutique_id', $boutique->id);
        })->exists();
        
        if (!$peutVoir) {
            return redirect()->route('artisan.commandes.index')
                ->with('error', 'Vous n\'avez pas l\'autorisation de voir cette commande.');
        }
        
        // Filtrer les articles de la commande pour ne montrer que ceux liés à cette boutique
        $articles = $commande->articles()->whereHas('produit', function($query) use ($boutique) {
            $query->where('boutique_id', $boutique->id);
        })->get();
        
        return view('artisan.commandes.show', compact('commande', 'articles', 'boutique'));
    }

    /**
     * Met à jour le statut d'une commande.
     */
    public function mettreAJourStatut(Request $request, Commande $commande)
    {
        $request->validate([
            'statut' => 'required|in:en_preparation,expediee,livree,annulee',
        ]);

        $artisan = Auth::user()->artisan;
        $boutique = $artisan->boutique;
        
        // Vérifier que la commande contient au moins un produit de la boutique de l'artisan
        $peutModifier = $commande->articles()->whereHas('produit', function($query) use ($boutique) {
            $query->where('boutique_id', $boutique->id);
        })->exists();
        
        if (!$peutModifier) {
            return redirect()->route('artisan.commandes.index')
                ->with('error', 'Vous n\'avez pas l\'autorisation de modifier cette commande.');
        }
        
        // Mettre à jour uniquement les articles liés à cette boutique
        $articles = $commande->articles()->whereHas('produit', function($query) use ($boutique) {
            $query->where('boutique_id', $boutique->id);
        })->get();
        
        foreach ($articles as $article) {
            $article->statut = $request->statut;
            $article->save();
        }

        return redirect()->route('artisan.commandes.afficher', $commande)
            ->with('success', 'Statut des articles de la commande mis à jour avec succès !');
    }
}
