<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Ordre d’affichage des produits + activation de la modale boutique.
 */
return new class extends Migration
{
    /**
     * Ajoute sort_order sur books et le flag modale sur site_settings.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            if (! Schema::hasColumn('books', 'sort_order')) {
                $table->unsignedInteger('sort_order')->default(0)->after('is_featured');
            }
        });

        Schema::table('site_settings', function (Blueprint $table) {
            if (! Schema::hasColumn('site_settings', 'products_welcome_modal_enabled')) {
                $table->boolean('products_welcome_modal_enabled')->default(true)->after('whatsapp_url');
            }
        });
    }

    /**
     * Retire les colonnes ajoutées.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            if (Schema::hasColumn('books', 'sort_order')) {
                $table->dropColumn('sort_order');
            }
        });

        Schema::table('site_settings', function (Blueprint $table) {
            if (Schema::hasColumn('site_settings', 'products_welcome_modal_enabled')) {
                $table->dropColumn('products_welcome_modal_enabled');
            }
        });
    }
};
