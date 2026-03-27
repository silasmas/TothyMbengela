<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->comment('Librairie en ligne : ouvrages numériques ou physiques vendus sur le site.');
            $table->id()->comment('Identifiant du livre.');
            $table->string('title')->comment('Titre commercial de l’ouvrage.');
            $table->string('slug')->unique()->comment('Slug URL pour la fiche produit.');
            $table->text('description')->nullable()->comment('Description marketing et table des matières courte.');
            $table->decimal('price', 12, 2)->comment('Prix unitaire TTC ou HT selon règle métier (à documenter en facturation).');
            $table->char('currency', 3)->default('USD')->comment('Code devise ISO 4217 (USD, CDF, EUR, etc.).');
            $table->string('cover_path')->nullable()->comment('Image de couverture (fichier stocké).');
            $table->string('digital_file_path')->nullable()->comment('Fichier téléchargeable après achat (e-book, PDF).');
            $table->string('isbn')->nullable()->comment('Numéro ISBN international si disponible.');
            $table->boolean('is_active')->default(true)->comment('Si false, le livre n’apparaît plus en vente.');
            $table->unsignedInteger('stock_quantity')->nullable()->comment('Stock physique ; null = illimité ou uniquement numérique.');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
