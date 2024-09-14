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
        Schema::create('compte_resultat_produits', function (Blueprint $table) {
            $table->foreignId('compte_resultat_id')->references('id')->on('compte_resultats');
            $table->foreignId('produit_id')->references('id')->on('produits');
            $table->decimal('montant', total: 10, places: 2)->unsigned();

            $table->primary(['compte_resultat_id', 'produit_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compte_resultat_produits');
    }
};
