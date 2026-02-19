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
        Schema::create('commande_articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idCommande');
            $table->unsignedBigInteger('idProduit');
            $table->integer('quantite');
            $table->decimal('prix_unitaire', 10, 2);
            $table->decimal('total', 10, 2);

            $table->foreign('idCommande')->references('id')->on('commandes')->onDelete('cascade');
            $table->foreign('idProduit')->references('id')->on('produits')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commande_articles');
    }
};
