<?php

namespace App\Http\Controllers\Artisan;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProduitController extends Controller
{
    /**
     * Affiche la liste des produits de l'artisan.
     */
    public function index()
    {
        $artisan = Auth::user()->artisan;
        $boutique = $artisan->boutique;
        
        if (!$boutique) {
            return redirect()->route('artisan.boutique.creer')
                ->with('info', 'Vous devez d\'abord créer votre boutique.');
        }
        
        $produits = $boutique->produits()->latest()->get();
        
        return view('artisan.produits.index', compact('produits', 'boutique'));
    }

    /**
     * Affiche le formulaire de création d'un produit.
     */
    public function creer()
    {
        $artisan = Auth::user()->artisan;
        $boutique = $artisan->boutique;
        
        if (!$boutique) {
            return redirect()->route('artisan.boutique.creer')
                ->with('info', 'Vous devez d\'abord créer votre boutique.');
        }
        
        $categories = Categorie::all();
        
        return view('artisan.produits.create', compact('categories', 'boutique'));
    }

    /**
     * Enregistre un nouveau produit.
     */
    public function enregistrer(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'description' => 'required|string',
            'prix' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categorie_id' => 'required|exists:categories,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);

        $artisan = Auth::user()->artisan;
        $boutique = $artisan->boutique;

        $produit = new Produit([
            'nom' => $request->nom,
            'description' => $request->description,
            'prix' => $request->prix,
            'stock' => $request->stock,
            'categorie_id' => $request->categorie_id,
            'boutique_id' => $boutique->id,
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('produits', 'public');
            $produit->photo = $path;
        }

        $produit->save();

        return redirect()->route('artisan.produits.index')
            ->with('success', 'Produit ajouté avec succès !');
    }

    /**
     * Affiche le formulaire de modification d'un produit.
     */
    public function editer(Produit $produit)
    {
        $artisan = Auth::user()->artisan;
        $boutique = $artisan->boutique;
        
        // Vérifier que le produit appartient bien à la boutique de l'artisan
        if ($produit->boutique_id !== $boutique->id) {
            return redirect()->route('artisan.produits.index')
                ->with('error', 'Vous n\'avez pas l\'autorisation de modifier ce produit.');
        }
        
        $categories = Categorie::all();
        
        return view('artisan.produits.edit', compact('produit', 'categories', 'boutique'));
    }

    /**
     * Met à jour un produit.
     */
    public function mettreAJour(Request $request, Produit $produit)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'description' => 'required|string',
            'prix' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categorie_id' => 'required|exists:categories,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);

        $artisan = Auth::user()->artisan;
        $boutique = $artisan->boutique;
        
        // Vérifier que le produit appartient bien à la boutique de l'artisan
        if ($produit->boutique_id !== $boutique->id) {
            return redirect()->route('artisan.produits.index')
                ->with('error', 'Vous n\'avez pas l\'autorisation de modifier ce produit.');
        }

        $produit->nom = $request->nom;
        $produit->description = $request->description;
        $produit->prix = $request->prix;
        $produit->stock = $request->stock;
        $produit->categorie_id = $request->categorie_id;

        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo si elle existe
            if ($produit->photo) {
                Storage::disk('public')->delete($produit->photo);
            }
            
            $path = $request->file('photo')->store('produits', 'public');
            $produit->photo = $path;
        }

        $produit->save();

        return redirect()->route('artisan.produits.index')
            ->with('success', 'Produit mis à jour avec succès !');
    }

    /**
     * Supprime un produit.
     */
    public function supprimer(Produit $produit)
    {
        $artisan = Auth::user()->artisan;
        $boutique = $artisan->boutique;
        
        // Vérifier que le produit appartient bien à la boutique de l'artisan
        if ($produit->boutique_id !== $boutique->id) {
            return redirect()->route('artisan.produits.index')
                ->with('error', 'Vous n\'avez pas l\'autorisation de supprimer ce produit.');
        }

        // Supprimer la photo si elle existe
        if ($produit->photo) {
            Storage::disk('public')->delete($produit->photo);
        }

        $produit->delete();

        return redirect()->route('artisan.produits.index')
            ->with('success', 'Produit supprimé avec succès !');
    }
}
