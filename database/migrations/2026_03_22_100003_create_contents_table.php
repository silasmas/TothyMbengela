<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->comment('Contenus ministère : vidéo, audio, podcast, article ; une partie peut être hébergée sur YouTube (source externe).');
            $table->id()->comment('Identifiant du contenu.');
            $table->foreignId('rubrique_id')->constrained('rubriques')->cascadeOnDelete()->comment('Rubrique de rattachement obligatoire.');
            $table->foreignId('series_id')->nullable()->constrained('series')->nullOnDelete()->comment('Série optionnelle pour regrouper les épisodes.');
            $table->foreignId('theme_id')->nullable()->constrained('themes')->nullOnDelete()->comment('Thème optionnel pour filtres croisés.');
            $table->string('type')->comment('Type logique : video, audio, podcast, article (contrôlé côté app / Filament).');
            $table->string('source')->default('internal')->comment('Origine du média : internal (fichier ou URL maison), youtube (lecture via API/embed), external (autre hébergeur).');
            $table->string('title')->comment('Titre affiché sur les listes et la page détail.');
            $table->string('slug')->unique()->comment('Slug unique pour l’URL publique.');
            $table->text('excerpt')->nullable()->comment('Accroche courte pour cartes et partages sociaux.');
            $table->longText('body')->nullable()->comment('Texte riche ou description longue (articles, notes d’étude).');
            $table->string('media_url')->nullable()->comment('URL de lecture ou téléchargement si hébergement direct (non YouTube).');
            $table->string('youtube_video_id', 32)->nullable()->comment('Identifiant vidéo YouTube (ex. dQw4w9WgXcQ) quand source=youtube ; sert aux embeds et oEmbed.');
            $table->string('youtube_url')->nullable()->comment('URL canonique de la vidéo YouTube (watch ou youtu.be) pour lien « voir sur YouTube ».');
            $table->string('file_path')->nullable()->comment('Chemin fichier sur disque si média stocké localement (MP3, MP4, PDF lié, etc.).');
            $table->string('thumbnail_path')->nullable()->comment('Vignette personnalisée ; si null et YouTube, peut être dérivée via API.');
            $table->unsignedInteger('duration_seconds')->nullable()->comment('Durée en secondes pour lecteurs et filtres.');
            $table->boolean('allow_streaming')->default(true)->comment('Autorise la lecture en ligne sur le site.');
            $table->boolean('allow_download')->default(false)->comment('Autorise le téléchargement du fichier si applicable.');
            $table->boolean('is_published')->default(false)->comment('Brouillon vs publié ; combiné à published_at.');
            $table->timestamp('published_at')->nullable()->comment('Date/heure de mise en ligne effective (ordonnancement, « nouveautés »).');
            $table->boolean('is_featured')->default(false)->comment('Mise en avant sur l’accueil ou blocs « à la une ».');
            $table->unsignedInteger('position')->default(0)->comment('Ordre manuel dans une liste ou une série.');
            $table->json('meta')->nullable()->comment('Métadonnées extensibles (IDs externes, stats, champs spécifiques sans migration).');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['rubrique_id', 'type', 'is_published']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
