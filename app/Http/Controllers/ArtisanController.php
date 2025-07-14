<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArtisanController extends Controller
{
    // Affiche le formulaire de création d'un artisan
    public function create()
    {
        return view('artisans.create');
    }

    // Enregistre un nouvel artisan
    public function store(Request $request)
    {
        // ... logique d'enregistrement ...
    }

    // Affiche le profil de l'artisan
    public function show($id)
    {
        // ... logique d'affichage ...
    }
}
