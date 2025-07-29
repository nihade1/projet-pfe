<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produit extends Model
{
    protected $fillable = [
        'nom', 'prix', 'stock', 'photo', 'description', 'boutique_id', 'categorie_id'
    ];

    public function boutique(): BelongsTo
    {
        return $this->belongsTo(Boutique::class);
    }

    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Categorie::class);
    }

    public function avis(): HasMany
    {
        return $this->hasMany(Avis::class);
    }
    
    public function articleCommandes(): HasMany
    {
        return $this->hasMany(ArticleCommande::class);
    }
}
