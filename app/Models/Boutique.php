<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
}
