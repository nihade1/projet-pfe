<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    protected $fillable = [
        'boutique_id',
        'titre',
        'contenu',
        'image',
        'publie'
    ];

    public function boutique()
    {
        return $this->belongsTo(Boutique::class);
    }
}
