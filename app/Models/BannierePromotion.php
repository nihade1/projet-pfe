<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannierePromotion extends Model
{
    protected $fillable = [
        'boutique_id',
        'image',
        'titre',
        'description',
        'lien',
        'date_debut',
        'date_fin',
        'active',
        'ordre'
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'active' => 'boolean'
    ];

    public function boutique()
    {
        return $this->belongsTo(Boutique::class);
    }
}
