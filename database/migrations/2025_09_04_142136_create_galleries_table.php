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
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('adresse')->nullable();
            $table->string('code_postal')->nullable();
            $table->string('ville')->nullable();
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();
            $table->string('forme_juridique')->nullable();
            $table->string('dirigeant')->nullable();
            $table->string('immatriculation')->nullable();
            $table->integer('annee_ca')->nullable();
            $table->decimal('ca', 15, 2)->nullable(); // Pour les montants financiers
            $table->decimal('resultat', 15, 2)->nullable();
            $table->string('effectif')->nullable(); // String pour gérer des formats comme "1-3"
            $table->string('naf_ape')->nullable();
            $table->string('siret')->nullable()->unique(); // Le SIRET doit être unique
            $table->integer('effectif_min')->nullable();
            $table->integer('effectif_max')->nullable();
            $table->timestamps(); // colonnes created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};
