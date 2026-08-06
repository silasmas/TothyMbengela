<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Boutique multi-devises, galerie produits et slides dynamiques.
 */
return new class extends Migration
{
    /**
     * Crée shop_settings, slides, gallery_paths sur books.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('shop_settings', function (Blueprint $table) {
            $table->comment('Paramètres globaux boutique (taux de change, devise d’affichage).');
            $table->id();
            $table->decimal('usd_to_cdf_rate', 14, 4)
                ->default(2850)
                ->comment('Combien de CDF pour 1 USD.');
            $table->char('default_currency', 3)
                ->default('USD')
                ->comment('Devise d’affichage par défaut (USD ou CDF).');
            $table->boolean('allow_currency_switch')
                ->default(true)
                ->comment('Si true, le client peut choisir USD ou CDF.');
            $table->timestamps();
        });

        Schema::table('books', function (Blueprint $table) {
            $table->json('gallery_paths')
                ->nullable()
                ->after('cover_path')
                ->comment('Images supplémentaires du produit (chemins storage public).');
        });

        Schema::create('slides', function (Blueprint $table) {
            $table->comment('Slides du carrousel d’accueil (produits ou actions personnalisées).');
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('body')->nullable();
            $table->string('image_path')->nullable();
            $table->string('slide_type', 32)
                ->default('custom')
                ->comment('product, custom, donate.');
            $table->foreignId('book_id')
                ->nullable()
                ->constrained('books')
                ->nullOnDelete();
            $table->string('primary_action', 32)
                ->default('none')
                ->comment('add_cart, buy, link, donate, partner, contents, about, none.');
            $table->string('primary_label')->nullable();
            $table->string('primary_url')->nullable();
            $table->string('secondary_action', 32)
                ->default('none');
            $table->string('secondary_label')->nullable();
            $table->string('secondary_url')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Annule shop_settings, slides et gallery_paths.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('slides');

        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn('gallery_paths');
        });

        Schema::dropIfExists('shop_settings');
    }
};
