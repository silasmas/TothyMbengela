<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('themes', function (Blueprint $table) {
            $table->comment('Thèmes transverses pour classer séries et contenus (ex. foi, famille).');
            $table->id()->comment('Identifiant du thème.');
            $table->string('name')->comment('Libellé du thème affiché aux visiteurs.');
            $table->string('slug')->unique()->comment('Slug URL unique pour filtrage ou pages thème.');
            $table->text('description')->nullable()->comment('Description optionnelle du regroupement thématique.');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('themes');
    }
};
