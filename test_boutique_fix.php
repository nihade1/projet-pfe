<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Boutique;

try {
    echo "Test de la correction de l'erreur boutique...\n";
    
    $boutiques = Boutique::with(['artisan.user', 'produits.categorie'])->get();
    echo "Nombre de boutiques: " . $boutiques->count() . "\n";
    
    if ($boutiques->count() > 0) {
        $boutique = $boutiques->first();
        echo "Test boutique: " . $boutique->nom . " (ID: " . $boutique->id . ")\n";
        
        // Test de l'accès aux produits
        echo "Nombre de produits: " . $boutique->produits->count() . "\n";
        
        if ($boutique->produits->count() > 0) {
            $produit = $boutique->produits->first();
            echo "Premier produit: " . $produit->nom . "\n";
            echo "Photo du produit: " . ($produit->photo ? $produit->photo : 'Aucune photo') . "\n";
        }
        
        // Test de la méthode avis() corrigée
        echo "Test de récupération des avis...\n";
        $avis = $boutique->avis()->get();
        echo "Nombre d'avis: " . $avis->count() . "\n";
        
        echo "✅ Test réussi ! La correction semble fonctionner.\n";
    } else {
        echo "❌ Aucune boutique trouvée.\n";
    }
    
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
