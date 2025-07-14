<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Artisan extends Model
{
    protected $fillable = ['user_id', 'bio', 'photo'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function boutique()
    {
        return $this->hasOne(Boutique::class);
    }
}
