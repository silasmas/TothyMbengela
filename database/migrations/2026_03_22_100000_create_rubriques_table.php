<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rubriques', function (Blueprint $table) {
            $table->comment('Rubriques phares du ministère (ex. Proverbes, Prédications) ; regroupe les contenus multimédias.');
            $table->id()->comment('Identifiant de la rubrique.');
            $table->string('name')->comment('Titre affiché sur le site (nom de la rubrique).');
            $table->string('slug')->unique()->comment('Fragment d’URL stable et unique pour le SEO et les liens.');
            $table->text('description')->nullable()->comment('Texte de présentation de la rubrique sur les pages liste.');
            $table->string('icon')->nullable()->comment('Clé ou chemin d’icône (UI) associée à la rubrique.');
            $table->unsignedInteger('sort_order')->default(0)->comment('Ordre d’affichage dans les menus (plus petit = plus haut).');
            $table->boolean('is_active')->default(true)->comment('Si false, la rubrique est masquée du public.');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rubriques');
    }
};
