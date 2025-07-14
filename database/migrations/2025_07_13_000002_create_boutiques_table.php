<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('boutiques', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('artisan_id');
            $table->string('photo')->nullable();
            $table->timestamps();
            $table->foreign('artisan_id')->references('id')->on('artisans')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('boutiques');
    }
};
