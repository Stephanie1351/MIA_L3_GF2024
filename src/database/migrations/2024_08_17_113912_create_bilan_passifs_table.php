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
        Schema::create('bilan_passifs', function (Blueprint $table) {
            $table->foreignId('bilan_id')->references('id')->on('bilans');
            $table->foreignId('passif_id')->references('id')->on('passifs');
            $table->decimal('montant', total: 10, places: 2)->unsigned();

            $table->primary(['bilan_id', 'passif_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bilan_passifs');
    }
};
