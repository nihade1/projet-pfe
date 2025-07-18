<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorie;

class CategorieController extends Controller
{
    public function show($id)
    {
        $categorie = Categorie::findOrFail($id);
        $produits = $categorie->produits;
        return view('categories.show', compact('categorie', 'produits'));
    }
}
