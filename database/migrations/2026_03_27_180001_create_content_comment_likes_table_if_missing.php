<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('content_comment_likes')) {
            return;
        }

        Schema::create('content_comment_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('content_comment_id')->constrained('content_comments')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('liker_fingerprint', 120);
            $table->timestamps();

            $table->unique(['content_comment_id', 'liker_fingerprint'], 'cc_likes_comment_fp_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('content_comment_likes');
    }
};
