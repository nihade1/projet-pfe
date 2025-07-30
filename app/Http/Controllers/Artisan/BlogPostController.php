<?php

namespace App\Http\Controllers\Artisan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogPostController extends Controller
{
    /**
     * Affiche la liste des articles de blog de l'artisan.
     */
    public function index()
    {
        $artisan = auth()->user()->artisan;
        $boutique = $artisan->boutique;
        
        if (!$boutique) {
            return redirect()->route('artisan.boutique.creer')
                ->with('info', 'Vous devez d\'abord créer votre boutique.');
        }
        
        $blogPosts = $boutique->blogPosts()->latest()->get();
        
        return view('artisan.blog.index', compact('blogPosts', 'boutique'));
    }

    /**
     * Affiche le formulaire de création d'un article de blog.
     */
    public function creer()
    {
        $artisan = auth()->user()->artisan;
        $boutique = $artisan->boutique;
        
        if (!$boutique) {
            return redirect()->route('artisan.boutique.creer')
                ->with('info', 'Vous devez d\'abord créer votre boutique.');
        }
        
        return view('artisan.blog.create', compact('boutique'));
    }

    /**
     * Enregistre un nouvel article de blog.
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
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg',
            'publie' => 'boolean',
        ]);
        
        $blogPost = new \App\Models\BlogPost([
            'titre' => $request->titre,
            'contenu' => $request->contenu,
            'publie' => $request->has('publie'),
            'boutique_id' => $boutique->id,
        ]);
        
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('blog', 'public');
            $blogPost->image = $path;
        }
        
        $blogPost->save();
        
        return redirect()->route('artisan.blog.index')
            ->with('success', 'Votre article a été créé avec succès !');
    }

    /**
     * Affiche le formulaire d'édition d'un article de blog.
     */
    public function editer(\App\Models\BlogPost $blogPost)
    {
        $artisan = auth()->user()->artisan;
        $boutique = $artisan->boutique;
        
        // Vérifier que l'article appartient bien à la boutique de l'artisan
        if ($blogPost->boutique_id != $boutique->id) {
            abort(403, 'Non autorisé');
        }
        
        return view('artisan.blog.edit', compact('blogPost', 'boutique'));
    }

    /**
     * Met à jour un article de blog.
     */
    public function mettreAJour(Request $request, \App\Models\BlogPost $blogPost)
    {
        $artisan = auth()->user()->artisan;
        $boutique = $artisan->boutique;
        
        // Vérifier que l'article appartient bien à la boutique de l'artisan
        if ($blogPost->boutique_id != $boutique->id) {
            abort(403, 'Non autorisé');
        }
        
        $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg',
            'publie' => 'boolean',
        ]);
        
        $blogPost->titre = $request->titre;
        $blogPost->contenu = $request->contenu;
        $blogPost->publie = $request->has('publie');
        
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($blogPost->image) {
                Storage::disk('public')->delete($blogPost->image);
            }
            
            $path = $request->file('image')->store('blog', 'public');
            $blogPost->image = $path;
        }
        
        $blogPost->save();
        
        return redirect()->route('artisan.blog.index')
            ->with('success', 'Votre article a été mis à jour avec succès !');
    }

    /**
     * Supprime un article de blog.
     */
    public function supprimer(\App\Models\BlogPost $blogPost)
    {
        $artisan = auth()->user()->artisan;
        $boutique = $artisan->boutique;
        
        // Vérifier que l'article appartient bien à la boutique de l'artisan
        if ($blogPost->boutique_id != $boutique->id) {
            abort(403, 'Non autorisé');
        }
        
        // Supprimer l'image si elle existe
        if ($blogPost->image) {
            Storage::disk('public')->delete($blogPost->image);
        }
        
        $blogPost->delete();
        
        return redirect()->route('artisan.blog.index')
            ->with('success', 'Votre article a été supprimé avec succès !');
    }
}
