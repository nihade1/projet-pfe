<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\BoutiqueController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\ArtisanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Artisan\TableauDeBordController;
use App\Http\Controllers\Artisan\BoutiqueController as ArtisanBoutiqueController;
use App\Http\Controllers\Artisan\ProduitController as ArtisanProduitController;
use App\Http\Controllers\Artisan\CommandeController as ArtisanCommandeController;
use App\Http\Controllers\Artisan\BlogPostController;
use App\Http\Controllers\Artisan\BannierePromotionController;


// Routes d'accueil et de recherche
Route::get('/', action: [HomeController::class, 'index'])->name('index');
Route::get('/recherche', [HomeController::class, 'recherche'])->name('recherche');

// Routes pour les produits
Route::get('/produits', [ProduitController::class, 'index'])->name('produits.index');
Route::get('/produits/{produit}', [ProduitController::class, 'afficher'])->name('produits.afficher');
Route::post('/produits/{produit}/avis', [ProduitController::class, 'enregistrerAvis'])->name('produits.avis');

// Routes pour les catégories
Route::get('/categories/{categorie}', [ProduitController::class, 'parCategorie'])->name('categories.produits');

// Routes pour les boutiques (interface publique)
Route::get('/boutiques', [BoutiqueController::class, 'index'])->name('boutiques.index');
Route::get('/boutiques/{boutique}', [BoutiqueController::class, 'afficher'])->name('boutiques.afficher');
Route::post('/boutiques/{boutique}/avis', [BoutiqueController::class, 'enregistrerAvis'])->name('boutiques.avis');

// Routes pour le panier
Route::middleware('auth')->group(function () {
    Route::get('/panier', [PanierController::class, 'index'])->name('panier.index');
    Route::post('/panier/ajouter', [PanierController::class, 'ajouter'])->name('panier.ajouter');
    Route::put('/panier/{produit}', [PanierController::class, 'mettreAJour'])->name('panier.mettreAJour');
    Route::delete('/panier', [PanierController::class, 'vider'])->name('panier.vider');
    Route::delete('/panier/{produit}', [PanierController::class, 'supprimer'])->name('panier.supprimer');
});

// Routes pour les commandes
Route::get('/commandes', [CommandeController::class, 'index'])->name('commandes.index');
Route::get('/commandes/paiement', [CommandeController::class, 'paiement'])->name('commandes.paiement');
Route::post('/commandes', [CommandeController::class, 'enregistrer'])->name('commandes.enregistrer');
Route::get('/commandes/{commande}', [CommandeController::class, 'afficher'])->name('commandes.afficher');

// Routes pour les artisans (inscription et profil public)
Route::get('/artisans', [ArtisanController::class, 'index'])->name('artisans.index');
Route::get('/artisans/inscription', [ArtisanController::class, 'create'])->name('artisans.create');
Route::post('/artisans', [ArtisanController::class, 'store'])->name('artisans.store');
Route::get('/artisans/{artisan}', [ArtisanController::class, 'show'])->name('artisans.show');

// Routes pour les artisans (espace protégé)
Route::middleware(\App\Http\Middleware\EnsureUserIsArtisan::class)->prefix('artisan')->name('artisan.')->group(function () {
    Route::get('/tableau-de-bord', [TableauDeBordController::class, 'index'])->name('tableau-de-bord');
    
    // Gestion de boutique
    Route::get('/boutique/creer', [ArtisanBoutiqueController::class, 'creer'])->name('boutique.creer');
    Route::post('/boutique', [ArtisanBoutiqueController::class, 'enregistrer'])->name('boutique.enregistrer');
    Route::get('/boutique', [ArtisanBoutiqueController::class, 'dashboard'])->name('boutique.dashboard');
    Route::get('/boutique/editer', [ArtisanBoutiqueController::class, 'editer'])->name('boutique.editer');
    Route::put('/boutique', [ArtisanBoutiqueController::class, 'mettreAJour'])->name('boutique.mettreAJour');
    // Gestion de produits
    Route::get('/produits', [ArtisanProduitController::class, 'index'])->name('produits.index');
    Route::get('/produits/creer', [ArtisanProduitController::class, 'creer'])->name('produits.creer');
    Route::post('/produits', [ArtisanProduitController::class, 'enregistrer'])->name('produits.enregistrer');
    Route::get('/produits/{produit}/editer', [ArtisanProduitController::class, 'editer'])->name('produits.editer');
    Route::put('/produits/{produit}', [ArtisanProduitController::class, 'mettreAJour'])->name('produits.mettreAJour');
    Route::delete('/produits/{produit}', [ArtisanProduitController::class, 'supprimer'])->name('produits.supprimer');
    // Gestion de commandes
    Route::get('/commandes', [ArtisanCommandeController::class, 'index'])->name('commandes.index');
    Route::get('/commandes/{commande}', [ArtisanCommandeController::class, 'afficher'])->name('commandes.afficher');
    Route::put('/commandes/{commande}/statut', [ArtisanCommandeController::class, 'mettreAJourStatut'])->name('commandes.statut');
    
    // Gestion du blog
    Route::get('/blog', [BlogPostController::class, 'index'])->name('blog.index');
    Route::get('/blog/creer', [BlogPostController::class, 'creer'])->name('blog.creer');
    Route::post('/blog', [BlogPostController::class, 'enregistrer'])->name('blog.enregistrer');
    Route::get('/blog/{blogPost}/editer', [BlogPostController::class, 'editer'])->name('blog.editer');
    Route::put('/blog/{blogPost}', [BlogPostController::class, 'mettreAJour'])->name('blog.mettreAJour');
    Route::delete('/blog/{blogPost}', [BlogPostController::class, 'supprimer'])->name('blog.supprimer');
    
    // Gestion des bannières promotionnelles
    Route::get('/bannieres', [BannierePromotionController::class, 'index'])->name('bannieres.index');
    Route::get('/bannieres/creer', [BannierePromotionController::class, 'creer'])->name('bannieres.creer');
    Route::post('/bannieres', [BannierePromotionController::class, 'enregistrer'])->name('bannieres.enregistrer');
    Route::get('/bannieres/{banniere}/editer', [BannierePromotionController::class, 'editer'])->name('bannieres.editer');
    Route::put('/bannieres/{banniere}', [BannierePromotionController::class, 'mettreAJour'])->name('bannieres.mettreAJour');
    Route::delete('/bannieres/{banniere}', [BannierePromotionController::class, 'supprimer'])->name('bannieres.supprimer');
});

Route::get('/dashboard', [ArtisanBoutiqueController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'dashboard'])->name('profile.dashboard');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';