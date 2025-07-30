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
            'slogan' => 'nullable|string|max:200',
            'adresse' => 'nullable|string|max:255',
            'couleur_fond' => 'nullable|string|max:7',
            'couleur_texte' => 'nullable|string|max:7',
            'couleur_accent' => 'nullable|string|max:7',
            'police' => 'nullable|string|max:50',
        ]);

        $artisan = Auth::user()->artisan;

        $boutique = new Boutique([
            'nom' => $request->nom,
            'description' => $request->description,
            'artisan_id' => $artisan->id,
            'slogan' => $request->slogan,
            'adresse' => $request->adresse,
            'couleur_fond' => $request->couleur_fond,
            'couleur_texte' => $request->couleur_texte,
            'couleur_accent' => $request->couleur_accent,
            'police' => $request->police,
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
        
        // Récupérer le nombre d'avis pour la boutique
        $nombreAvis = $boutique->avis()->count();
        
        // Calculer le revenu total
        $revenuTotal = 0;
        foreach ($commandes as $commande) {
            $revenuCommande = $commande->articles()
                ->whereHas('produit', function($query) use ($boutique) {
                    $query->where('boutique_id', $boutique->id);
                })
                ->sum(\DB::raw('prix * quantite'));
            
            $revenuTotal += $revenuCommande;
        }
        
        // Récupérer les produits en rupture de stock ou avec un stock faible
        $produitsRuptureStock = $boutique->produits()->where('stock', 0)->get();
        $produitsStockFaible = $boutique->produits()->where('stock', '>', 0)->where('stock', '<=', 5)->get();
        
        // Nombre total de produits ayant des problèmes de stock
        $nombreProduitsAlerte = $produitsRuptureStock->count() + $produitsStockFaible->count();
        
        // Récupérer les statistiques mensuelles (derniers 6 mois)
        $statsParMois = [];
        $commandesParMois = [];
        
        // Date actuelle moins 5 mois (pour avoir 6 mois au total)
        $dateDebut = now()->subMonths(5)->startOfMonth();
        
        // Pour chaque mois jusqu'à maintenant
        for ($i = 0; $i < 6; $i++) {
            $moisCourant = $dateDebut->copy()->addMonths($i);
            $moisSuivant = $moisCourant->copy()->addMonth();
            $nomMois = $moisCourant->format('M');
            
            // Commandes pour ce mois
            $commandesMois = $boutique->commandes()
                ->whereBetween('created_at', [$moisCourant, $moisSuivant])
                ->get();
            
            // Revenu pour ce mois
            $revenuMois = 0;
            foreach ($commandesMois as $commande) {
                $revenuCommande = $commande->articles()
                    ->whereHas('produit', function($query) use ($boutique) {
                        $query->where('boutique_id', $boutique->id);
                    })
                    ->sum(\DB::raw('prix * quantite'));
                
                $revenuMois += $revenuCommande;
            }
            
            $statsParMois[$nomMois] = $revenuMois;
            $commandesParMois[$nomMois] = $commandesMois->count();
        }
        
        return view('artisan.boutique.dashboard', compact(
            'boutique', 
            'produits', 
            'commandes', 
            'nombreAvis', 
            'revenuTotal', 
            'statsParMois', 
            'commandesParMois',
            'produitsRuptureStock',
            'produitsStockFaible',
            'nombreProduitsAlerte'
        ));
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
            'slogan' => 'nullable|string|max:200',
            'adresse' => 'nullable|string|max:255',
            'couleur_fond' => 'nullable|string|max:7',
            'couleur_texte' => 'nullable|string|max:7',
            'couleur_accent' => 'nullable|string|max:7',
            'police' => 'nullable|string|max:50',
        ]);

        $artisan = Auth::user()->artisan;
        $boutique = $artisan->boutique;

        $boutique->nom = $request->nom;
        $boutique->description = $request->description;
        $boutique->slogan = $request->slogan;
        $boutique->adresse = $request->adresse;
        $boutique->couleur_fond = $request->couleur_fond;
        $boutique->couleur_texte = $request->couleur_texte;
        $boutique->couleur_accent = $request->couleur_accent;
        $boutique->police = $request->police;

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
