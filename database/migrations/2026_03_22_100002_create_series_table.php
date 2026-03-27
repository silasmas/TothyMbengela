<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('series', function (Blueprint $table) {
            $table->comment('Séries d’enseignements au sein d’une rubrique ; optionnellement rattachées à un thème.');
            $table->id()->comment('Identifiant de la série.');
            $table->foreignId('rubrique_id')->constrained('rubriques')->cascadeOnDelete()->comment('Rubrique parente obligatoire.');
            $table->foreignId('theme_id')->nullable()->constrained('themes')->nullOnDelete()->comment('Thème optionnel pour croiser avec la navigation par thème.');
            $table->string('title')->comment('Titre de la série (ex. nom de la campagne).');
            $table->string('slug')->unique()->comment('Slug unique pour URL de la série.');
            $table->text('description')->nullable()->comment('Résumé ou objectifs pédagogiques de la série.');
            $table->unsignedInteger('sort_order')->default(0)->comment('Ordre d’affichage parmi les séries d’une rubrique.');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('series');
    }
};
