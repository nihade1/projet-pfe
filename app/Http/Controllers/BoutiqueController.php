<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Boutique;

class BoutiqueController extends Controller
{
    // Affiche la liste des boutiques
    public function index()
    {
        $boutiques = Boutique::all();
        return view('boutiques.index', compact('boutiques'));
    }

    // Affiche le formulaire de création
    public function create()
    {
        return view('boutiques.create');
    }

    // Enregistre une nouvelle boutique
    public function store(Request $request)
    {
        // ... logique d'enregistrement ...
    }

    // Affiche une boutique
    public function show($id)
    {
        $boutique = Boutique::findOrFail($id);
        return view('boutiques.show', compact('boutique'));
    }
}
