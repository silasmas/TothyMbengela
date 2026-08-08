<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Historique des seeders exécutés depuis le dashboard admin.
 */
return new class extends Migration
{
    /**
     * Crée la table ops_seeder_runs.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('ops_seeder_runs', function (Blueprint $table) {
            $table->id();
            $table->string('seeder')->unique();
            $table->timestamp('ran_at');
            $table->timestamps();
        });
    }

    /**
     * Supprime la table ops_seeder_runs.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('ops_seeder_runs');
    }
};
