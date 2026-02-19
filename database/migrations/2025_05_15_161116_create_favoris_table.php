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
        Schema::create('favoris', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idUtilisateur');
            $table->foreign('idUtilisateur')->references('id')->on('utilisateurs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favoris');
    }
};
