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
        Schema::create('cache', function (Blueprint $table) {
            $table->comment('Cache applicatif en base (driver database) : paires clé / valeur avec expiration.');
            $table->string('key')->primary()->comment('Clé unique de l’entrée de cache.');
            $table->mediumText('value')->comment('Valeur sérialisée (résultats de requêtes, vues, etc.).');
            $table->bigInteger('expiration')->index()->comment('Timestamp Unix après lequel l’entrée est considérée comme expirée.');
        });

        Schema::create('cache_locks', function (Blueprint $table) {
            $table->comment('Verrous distribués pour éviter courses critiques sur certaines opérations (cache locks).');
            $table->string('key')->primary()->comment('Clé de la ressource verrouillée.');
            $table->string('owner')->comment('Identifiant du détenteur actuel du verrou.');
            $table->bigInteger('expiration')->index()->comment('Fin de validité du verrou (timestamp Unix).');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cache');
        Schema::dropIfExists('cache_locks');
    }
};
