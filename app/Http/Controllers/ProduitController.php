<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;

class ProduitController extends Controller
{
    public function index(Request $request)
    {
        $query = Produit::query();
        if ($request->filled('categorie')) {
            $query->where('categorie_id', $request->categorie);
        }
        if ($request->filled('artisan')) {
            $query->whereHas('boutique', function($q) use ($request) {
                $q->where('artisan_id', $request->artisan);
            });
        }
        $produits = $query->paginate(12);
        return view('produits.index', compact('produits'));
    }

    public function show($id)
    {
        $produit = Produit::findOrFail($id);
        return view('produits.show', compact('produit'));
    }

    public function create()
    {
        return view('produits.create');
    }

    public function store(Request $request)
    {
        // ... logique d'enregistrement ...
    }

    public function edit($id)
    {
        $produit = Produit::findOrFail($id);
        return view('produits.edit', compact('produit'));
    }

    public function update(Request $request, $id)
    {
        // ... logique de mise à jour ...
    }

    public function destroy($id)
    {
        // ... logique de suppression ...
    }
}
