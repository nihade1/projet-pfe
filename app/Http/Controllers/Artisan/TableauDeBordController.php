<?php

namespace App\Http\Controllers\Artisan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TableauDeBordController extends Controller
{
    /**
     * Affiche le tableau de bord de l'artisan.
     */
    public function index()
    {
        $artisan = Auth::user()->artisan;
        
        // Si l'artisan a une boutique, le rediriger vers le tableau de bord de sa boutique
        if ($artisan->boutique) {
            return redirect()->route('artisan.boutique.dashboard');
        }
        
        // Sinon, le rediriger vers la page de création de boutique
        return redirect()->route('artisan.boutique.creer')
            ->with('info', 'Bienvenue ! Pour commencer, créez votre boutique d\'artisan.');
    }
}
