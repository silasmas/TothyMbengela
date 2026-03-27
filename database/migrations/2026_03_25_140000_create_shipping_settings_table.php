<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipping_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(false)->comment('Proposer la livraison sur le site.');
            $table->char('domestic_country_code', 2)->default('CD')->comment('Code ISO pays « national » (ex. RDC = CD) : tarif domestique.');
            $table->decimal('price_domestic', 12, 2)->default(0)->comment('Frais pour le pays défini ci-dessus (ex. RDC / Lubumbashi).');
            $table->decimal('price_international', 12, 2)->default(0)->comment('Frais pour tout autre pays.');
            $table->char('currency', 3)->default('USD');
            $table->timestamps();
        });

        DB::table('shipping_settings')->insert([
            'is_active' => false,
            'domestic_country_code' => 'CD',
            'price_domestic' => 5,
            'price_international' => 25,
            'currency' => 'USD',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('shipping_settings');
    }
};
