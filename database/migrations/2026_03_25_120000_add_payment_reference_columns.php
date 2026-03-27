<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->string('reference')->nullable()->unique()->after('id');
        });

        Schema::table('partner_commitments', function (Blueprint $table) {
            $table->string('reference')->nullable()->unique()->after('id');
            $table->string('external_payment_id')->nullable()->after('payment_reference');
        });
    }

    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropColumn('reference');
        });

        Schema::table('partner_commitments', function (Blueprint $table) {
            $table->dropColumn(['reference', 'external_payment_id']);
        });
    }
};
