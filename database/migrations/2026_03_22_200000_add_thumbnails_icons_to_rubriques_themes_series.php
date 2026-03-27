<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rubriques', function (Blueprint $table) {
            $table->string('thumbnail_path')->nullable()->after('icon')->comment('Image de couverture / vignette pour cartes et listes.');
        });

        Schema::table('themes', function (Blueprint $table) {
            $table->string('icon')->nullable()->after('slug')->comment('Clé ou chemin d’icône (UI).');
            $table->string('thumbnail_path')->nullable()->after('icon')->comment('Vignette pour le thème.');
        });

        Schema::table('series', function (Blueprint $table) {
            $table->string('icon')->nullable()->after('slug')->comment('Clé ou chemin d’icône (UI).');
            $table->string('thumbnail_path')->nullable()->after('icon')->comment('Vignette de la série.');
        });
    }

    public function down(): void
    {
        Schema::table('rubriques', function (Blueprint $table) {
            $table->dropColumn('thumbnail_path');
        });

        Schema::table('themes', function (Blueprint $table) {
            $table->dropColumn(['icon', 'thumbnail_path']);
        });

        Schema::table('series', function (Blueprint $table) {
            $table->dropColumn(['icon', 'thumbnail_path']);
        });
    }
};
