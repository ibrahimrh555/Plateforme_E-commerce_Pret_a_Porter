<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommandesTable extends Migration
{
    public function up()
    {
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idUtilisateur');
            $table->dateTime('date_commandes')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->enum('statut', ['en attente', 'en cours', 'expédiée', 'livrée', 'annulée'])->default('en attente');
            $table->decimal('total', 10, 2)->nullable();
            $table->foreign('idUtilisateur')->references('id')->on('utilisateurs')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('commandes');
    }
}
