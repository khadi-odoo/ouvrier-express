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
        Schema::create('prestation_services', function (Blueprint $table) {
            $table->id();
            $table->string('nomService')->nullable();
            $table->string('image')->nullable();
            $table->string('presentation')->nullable();
            $table->boolean('disponibilite')->default(true);
            $table->string('experience')->nullable();
            $table->string('competence')->nullable();
            $table->string('motivation')->nullable();
            $table->unsignedBigInteger('prestataire_id');
            $table->foreign('prestataire_id')->references('id')->on('prestataires')->onDelete('cascade');
            $table->unsignedBigInteger('categorie_id');
            $table->foreign('categorie_id')->references('id')->on('categorie_services')->onDelete('cascade');
            $table->boolean('estArchive')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestation_services');
    }
};
