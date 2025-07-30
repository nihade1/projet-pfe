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
        Schema::create('banniere_promotions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('boutique_id');
            $table->string('image');
            $table->string('titre')->nullable();
            $table->string('description')->nullable();
            $table->string('lien')->nullable();
            $table->date('date_debut');
            $table->date('date_fin')->nullable();
            $table->boolean('active')->default(true);
            $table->integer('ordre')->default(0);
            $table->timestamps();
            
            $table->foreign('boutique_id')->references('id')->on('boutiques')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banniere_promotions');
    }
};
