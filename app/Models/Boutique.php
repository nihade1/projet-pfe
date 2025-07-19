<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\ArticleCommande;
use App\Models\Commande;

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
     * Obtient les commandes associées à cette boutique via les articles de commande
     */
    public function commandes()
    {
        // Récupère les IDs des produits de cette boutique
        $produitIds = $this->produits()->pluck('id');
        
        // Récupère les IDs de commandes qui contiennent ces produits
        $commandeIds = ArticleCommande::whereIn('produit_id', $produitIds)->pluck('commande_id')->unique();
        
        // Retourne les commandes correspondantes
        return Commande::whereIn('id', $commandeIds);
    }
}
