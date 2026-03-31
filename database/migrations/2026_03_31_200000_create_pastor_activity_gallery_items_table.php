<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pastor_activity_gallery_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pastor_activity_id')->constrained('pastor_activities')->cascadeOnDelete();
            $table->string('type', 16);
            $table->string('file_path')->nullable();
            $table->string('external_url', 2048)->nullable();
            $table->string('caption', 512)->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['pastor_activity_id', 'sort_order'], 'pa_gallery_activity_sort');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pastor_activity_gallery_items');
    }
};
