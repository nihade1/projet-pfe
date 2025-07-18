<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Commande extends Model
{
    protected $fillable = [
        'user_id', 
        'statut', 
        'montant_total',
        'adresse_livraison',
        'code_postal_livraison',
        'ville_livraison',
        'pays_livraison',
        'telephone'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function articles(): HasMany
    {
        return $this->hasMany(ArticleCommande::class);
    }
}
