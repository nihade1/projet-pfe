<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Artisan extends Model
{
    protected $fillable = [
        'user_id', 
        'bio', 
        'photo',
        'telephone',
        'adresse',
        'ville',
        'code_postal',
        'specialite',
        'experience'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function boutique(): HasOne
    {
        return $this->hasOne(Boutique::class);
    }
}
