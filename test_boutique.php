<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Boutique;

try {
    echo "Test de récupération des boutiques...\n";
    
    $boutiques = Boutique::all();
    echo "Nombre de boutiques: " . $boutiques->count() . "\n";
    
    if ($boutiques->count() > 0) {
        $boutique = $boutiques->first();
        echo "Test boutique: " . $boutique->nom . " (ID: " . $boutique->id . ")\n";
        
        // Test de la méthode avis() corrigée
        echo "Test de récupération des avis...\n";
        $avis = $boutique->avis()->get();
        echo "Nombre d'avis: " . $avis->count() . "\n";
        
        echo "✅ Test réussi ! Aucune erreur de base de données.\n";
    } else {
        echo "❌ Aucune boutique trouvée.\n";
    }
    
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
}
