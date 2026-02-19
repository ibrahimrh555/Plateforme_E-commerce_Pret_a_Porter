<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idVendeur');
            $table->unsignedBigInteger('idCategorie');
            $table->string('nom', 100);
            $table->text('description')->nullable();
            $table->decimal('prix', 10, 2);
            $table->integer('stock')->default(0);
            $table->string('couleur', 50)->nullable();
            $table->string('taille', 10)->nullable();
            $table->string('image', 255)->nullable();
            $table->timestamp('dateAjout')->useCurrent();

            $table->foreign('idVendeur')->references('id')->on('utilisateurs');
            $table->foreign('idCategorie')->references('idCategorie')->on('categorie');
        });

    }


    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};
