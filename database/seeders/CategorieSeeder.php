<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categorie;

class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Décoration',
            'Bijoux faits main',
            'Vêtements artisanaux',
            'Accessoires en cuir',
            'Céramiques',
            'Textiles tissés',
            'Cosmétiques naturels',
            'Objets en bois',
            'Papeterie & Cartes',
            'Produits locaux (épices, miel, etc.)',
        ];

        foreach ($categories as $nom) {
            Categorie::create(['nom' => $nom]);
        }
    }
}
