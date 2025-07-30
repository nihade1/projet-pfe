<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('boutiques', function (Blueprint $table) {
            $table->string('couleur_fond')->nullable()->default('#ffffff');
            $table->string('couleur_texte')->nullable()->default('#333333');
            $table->string('couleur_accent')->nullable()->default('#007A75');
            $table->string('police')->nullable()->default('Roboto');
            $table->string('adresse')->nullable();
            $table->string('slogan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('boutiques', function (Blueprint $table) {
            $table->dropColumn([
                'couleur_fond',
                'couleur_texte',
                'couleur_accent',
                'police',
                'adresse',
                'slogan'
            ]);
        });
    }
};
