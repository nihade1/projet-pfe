<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;

class PanierController extends Controller
{
    public function index()
    {
        $panier = session()->get('panier', []);
        return view('panier.index', compact('panier'));
    }

    public function ajouter(Request $request, Produit $produit)
    {
        $panier = session()->get('panier', []);
        $panier[$produit->id] = ($panier[$produit->id] ?? 0) + 1;
        session(['panier' => $panier]);
        return redirect()->route('panier.index');
    }

    public function commander()
    {
        // ... logique de commande à partir du panier ...
    }
}
