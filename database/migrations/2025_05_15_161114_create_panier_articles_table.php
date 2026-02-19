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
        Schema::create('panier_articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idPanier');
            $table->unsignedBigInteger('idProduit');
            $table->integer('quantite');
            $table->foreign('idPanier')->references('id')->on('paniers');
            $table->foreign('idProduit')->references('id')->on('produits');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('panier_articles');
    }
};
