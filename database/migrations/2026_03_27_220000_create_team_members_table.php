<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('team_members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('role')->nullable()->comment('Fonction affichée (ex. Pasteure, enseignante)');
            $table->text('excerpt')->nullable()->comment('Texte court pour les cartes');
            $table->longText('body')->nullable()->comment('Biographie page détail');
            $table->string('photo_path')->nullable();
            $table->string('profile_url')->nullable()->comment('Lien principal sur la photo (ex. chaîne YouTube)');
            $table->string('social_facebook')->nullable();
            $table->string('social_youtube')->nullable();
            $table->string('social_instagram')->nullable();
            $table->string('social_tiktok')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team_members');
    }
};
