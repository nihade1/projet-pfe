<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\ArticleCommande;
use App\Models\Commande;
use App\Models\Avis;

class Boutique extends Model
{
    protected $fillable = ['nom', 'description', 'artisan_id', 'photo'];

    public function artisan(): BelongsTo
    {
        return $this->belongsTo(Artisan::class);
    }

    public function produits(): HasMany
    {
        return $this->hasMany(Produit::class);
    }
    
    /**
     * Obtient les avis associés à cette boutique via ses produits
     */
    public function avis()
    {
        // Récupère les IDs des produits de cette boutique
        $produitIds = $this->produits()->pluck('id')->toArray();
        
        if (empty($produitIds)) {
            // Si aucun produit n'existe encore, retourner une collection vide
            return Avis::whereRaw('1 = 0');
        }
        
        return Avis::whereHas('produit', function ($query) use ($produitIds) {
            $query->whereIn('id', $produitIds);
        });
    }
    
    /**
     * Obtient les commandes associées à cette boutique via les articles de commande
     */
    public function commandes()
    {
        // Récupère les IDs des produits de cette boutique
        $produitIds = $this->produits()->pluck('id')->toArray();
        
        if (empty($produitIds)) {
            // Si aucun produit n'existe encore, retourner une collection vide
            return Commande::whereRaw('1 = 0');
        }
        
        // Récupère les IDs de commandes qui contiennent ces produits
        $commandeIds = ArticleCommande::whereIn('produit_id', $produitIds)->pluck('commande_id')->unique()->toArray();
        
        if (empty($commandeIds)) {
            // Si aucune commande n'existe encore, retourner une collection vide
            return Commande::whereRaw('1 = 0');
        }
        
        // Retourne les commandes correspondantes
        return Commande::whereIn('id', $commandeIds);
    }
}
