<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TableauBordArtisanController extends Controller
{
    public function index()
    {
        // ... logique pour afficher les statistiques, ventes, alertes stock ...
        return view('artisan.dashboard');
    }
}
