<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Étend la boutique : type de produit (livre, USB, pack…) et mise en avant (slides / modale).
 */
return new class extends Migration
{
    /**
     * Ajoute product_type et is_featured sur books.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->string('product_type', 32)
                ->default('book')
                ->after('title')
                ->comment('Type boutique : book, usb, pack, other.');
            $table->boolean('is_featured')
                ->default(false)
                ->after('is_active')
                ->comment('Si true, le produit apparaît dans le slider et la modale d’accueil.');
        });
    }

    /**
     * Annule product_type et is_featured.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn(['product_type', 'is_featured']);
        });
    }
};
