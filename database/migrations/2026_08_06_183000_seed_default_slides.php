<?php

use App\Models\Slide;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

/**
 * Insère les slides d’accueil par défaut (modifiables / supprimables en admin).
 */
return new class extends Migration
{
    /**
     * Crée les slides par défaut si la table est vide.
     *
     * @return void
     */
    public function up(): void
    {
        if (! Schema::hasTable('slides')) {
            return;
        }

        Slide::ensureDefaults();
    }

    /**
     * Ne supprime pas les slides (elles peuvent avoir été modifiées).
     *
     * @return void
     */
    public function down(): void
    {
        //
    }
};
