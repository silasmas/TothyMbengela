<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->boolean('shipping_opt_in')->default(false)->after('subtotal');
            $table->char('shipping_country', 2)->nullable()->after('shipping_opt_in');
            $table->string('shipping_city', 120)->nullable()->after('shipping_country');
            $table->decimal('shipping_cost', 12, 2)->default(0)->after('shipping_city');
            $table->decimal('grand_total', 12, 2)->nullable()->after('shipping_cost');
        });

        DB::table('orders')->whereNull('grand_total')->update([
            'grand_total' => DB::raw('subtotal'),
        ]);
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'shipping_opt_in',
                'shipping_country',
                'shipping_city',
                'shipping_cost',
                'grand_total',
            ]);
        });
    }
};
