<?php

namespace App\Http\Controllers\Artisan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\BannierePromotion;

class BannierePromotionController extends Controller
{
    /**
     * Affiche la liste des bannières promotionnelles de l'artisan.
     */
    public function index()
    {
        $artisan = auth()->user()->artisan;
        $boutique = $artisan->boutique;
        
        if (!$boutique) {
            return redirect()->route('artisan.boutique.creer')
                ->with('info', 'Vous devez d\'abord créer votre boutique.');
        }
        
        $bannieres = $boutique->bannieres()->orderBy('ordre')->get();
        
        return view('artisan.bannieres.index', compact('bannieres', 'boutique'));
    }

    /**
     * Affiche le formulaire de création d'une bannière.
     */
    public function creer()
    {
        $artisan = auth()->user()->artisan;
        $boutique = $artisan->boutique;
        
        if (!$boutique) {
            return redirect()->route('artisan.boutique.creer')
                ->with('info', 'Vous devez d\'abord créer votre boutique.');
        }
        
        return view('artisan.bannieres.create', compact('boutique'));
    }

    /**
     * Enregistre une nouvelle bannière.
     */
    public function enregistrer(Request $request)
    {
        $artisan = auth()->user()->artisan;
        $boutique = $artisan->boutique;
        
        if (!$boutique) {
            return redirect()->route('artisan.boutique.creer')
                ->with('info', 'Vous devez d\'abord créer votre boutique.');
        }
        
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg',
            'titre' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'lien' => 'nullable|string|max:255',
            'date_debut' => 'required|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
            'active' => 'boolean',
            'ordre' => 'nullable|integer|min:0',
        ]);
        
        $ordre = $request->ordre;
        if (is_null($ordre)) {
            // Récupérer le plus grand ordre et ajouter 1
            $maxOrdre = $boutique->bannieres()->max('ordre') ?? 0;
            $ordre = $maxOrdre + 1;
        }
        
        $banniere = new BannierePromotion([
            'boutique_id' => $boutique->id,
            'titre' => $request->titre,
            'description' => $request->description,
            'lien' => $request->lien,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'active' => $request->has('active'),
            'ordre' => $ordre,
        ]);
        
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('bannieres', 'public');
            $banniere->image = $path;
        }
        
        $banniere->save();
        
        return redirect()->route('artisan.bannieres.index')
            ->with('success', 'Votre bannière a été créée avec succès !');
    }

    /**
     * Affiche le formulaire d'édition d'une bannière.
     */
    public function editer(BannierePromotion $banniere)
    {
        $artisan = auth()->user()->artisan;
        $boutique = $artisan->boutique;
        
        // Vérifier que la bannière appartient bien à la boutique de l'artisan
        if ($banniere->boutique_id != $boutique->id) {
            abort(403, 'Non autorisé');
        }
        
        return view('artisan.bannieres.edit', compact('banniere', 'boutique'));
    }

    /**
     * Met à jour une bannière.
     */
    public function mettreAJour(Request $request, BannierePromotion $banniere)
    {
        $artisan = auth()->user()->artisan;
        $boutique = $artisan->boutique;
        
        // Vérifier que la bannière appartient bien à la boutique de l'artisan
        if ($banniere->boutique_id != $boutique->id) {
            abort(403, 'Non autorisé');
        }
        
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg',
            'titre' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'lien' => 'nullable|string|max:255',
            'date_debut' => 'required|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
            'active' => 'boolean',
            'ordre' => 'nullable|integer|min:0',
        ]);
        
        $banniere->titre = $request->titre;
        $banniere->description = $request->description;
        $banniere->lien = $request->lien;
        $banniere->date_debut = $request->date_debut;
        $banniere->date_fin = $request->date_fin;
        $banniere->active = $request->has('active');
        $banniere->ordre = $request->ordre ?? $banniere->ordre;
        
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($banniere->image) {
                Storage::disk('public')->delete($banniere->image);
            }
            
            $path = $request->file('image')->store('bannieres', 'public');
            $banniere->image = $path;
        }
        
        $banniere->save();
        
        return redirect()->route('artisan.bannieres.index')
            ->with('success', 'Votre bannière a été mise à jour avec succès !');
    }

    /**
     * Supprime une bannière.
     */
    public function supprimer(BannierePromotion $banniere)
    {
        $artisan = auth()->user()->artisan;
        $boutique = $artisan->boutique;
        
        // Vérifier que la bannière appartient bien à la boutique de l'artisan
        if ($banniere->boutique_id != $boutique->id) {
            abort(403, 'Non autorisé');
        }
        
        // Supprimer l'image si elle existe
        if ($banniere->image) {
            Storage::disk('public')->delete($banniere->image);
        }
        
        $banniere->delete();
        
        return redirect()->route('artisan.bannieres.index')
            ->with('success', 'Votre bannière a été supprimée avec succès !');
    }
}
