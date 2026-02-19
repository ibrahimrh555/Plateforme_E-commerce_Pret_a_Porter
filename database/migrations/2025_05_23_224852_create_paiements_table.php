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
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idCommande');
            $table->dateTime('datePaiement')->useCurrent();
            $table->decimal('montant', 10, 2);
            $table->enum('methode', ['carte', 'paypal', 'virement']);
            $table->enum('statut', ['réussi', 'échoué', 'en attente'])->default('en attente');
            $table->foreign('idCommande')->references('id')->on('commandes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
