<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commande;

class CommandeController extends Controller
{
    public function index()
    {
        $commandes = Commande::all();
        return view('commandes.index', compact('commandes'));
    }

    public function show($id)
    {
        $commande = Commande::findOrFail($id);
        return view('commandes.show', compact('commande'));
    }

    public function store(Request $request)
    {
        // ... logique de création de commande ...
    }

    public function mesCommandes()
    {
        $commandes = Commande::where('user_id', auth()->id())->get();
        return view('commandes.mes', compact('commandes'));
    }
}
