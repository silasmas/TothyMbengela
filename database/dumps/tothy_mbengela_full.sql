-- -----------------------------------------------------------------
-- Export MySQL — TothyMbengela
-- Généré le 2026-03-27T20:28:52+00:00
-- Base : `tothyMbengelaDB`
-- Réimport : mysql -u USER -p < ce_fichier.sql
-- (ajustez le nom de la base ci-dessous si besoin)
-- -----------------------------------------------------------------

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE='NO_AUTO_VALUE_ON_ZERO';

CREATE DATABASE IF NOT EXISTS `tothyMbengelaDB` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `tothyMbengelaDB`;


-- -----------------------------
-- Structure : `admin_password_reset_tokens`
-- -----------------------------
DROP TABLE IF EXISTS `admin_password_reset_tokens`;
CREATE TABLE `admin_password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'E-mail de l’admin concerné.',
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Jeton de reset envoyé par e-mail.',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'Création du jeton.',
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Réinitialisation mot de passe pour la table admins (séparée des utilisateurs site).';


-- -----------------------------
-- Structure : `admins`
-- -----------------------------
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique de l’administrateur.',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nom affiché dans le panel Filament.',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'E-mail de connexion au panel admin.',
  `email_verified_at` timestamp NULL DEFAULT NULL COMMENT 'Validation e-mail admin si activée.',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Mot de passe admin haché.',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Jeton « se souvenir de moi » pour la garde admin.',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Comptes d’administration Filament ; distincts des utilisateurs publics (garde session séparée).';

-- Données : `admins` (1 ligne(s))
INSERT INTO `admins` (`id`,`name`,`email`,`email_verified_at`,`password`,`remember_token`,`created_at`,`updated_at`) VALUES (1,'Admin','admin@example.com','2026-03-27 20:27:37','$2y$12$KYTt9aQ1MqHNkJvUpDo69u0wac.W1WLGBm8iDfI4Q2QYfrA3o4CK.','UILer3jjHu','2026-03-27 20:27:38','2026-03-27 20:27:38');


-- -----------------------------
-- Structure : `appointment_requests`
-- -----------------------------
DROP TABLE IF EXISTS `appointment_requests`;
CREATE TABLE `appointment_requests` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identifiant de la demande.',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nom du demandeur.',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'E-mail de confirmation et suivi.',
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Téléphone pour rappel ou WhatsApp.',
  `preferred_date` date DEFAULT NULL COMMENT 'Date souhaitée par le visiteur.',
  `preferred_time` time DEFAULT NULL COMMENT 'Créneau horaire souhaité (fuseau à clarifier côté app).',
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Motif ou message détaillé de la demande.',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending' COMMENT 'pending, confirmed, cancelled, completed, etc.',
  `admin_notes` text COLLATE utf8mb4_unicode_ci COMMENT 'Notes internes (disponibilités, décision).',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Demandes de rendez-vous avec la pasteure (prise de contact structurée).';


-- -----------------------------
-- Structure : `books`
-- -----------------------------
DROP TABLE IF EXISTS `books`;
CREATE TABLE `books` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identifiant du livre.',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Titre commercial de l’ouvrage.',
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Slug URL pour la fiche produit.',
  `description` text COLLATE utf8mb4_unicode_ci COMMENT 'Description marketing et table des matières courte.',
  `price` decimal(12,2) NOT NULL COMMENT 'Prix unitaire TTC ou HT selon règle métier (à documenter en facturation).',
  `currency` char(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'USD' COMMENT 'Code devise ISO 4217 (USD, CDF, EUR, etc.).',
  `cover_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Image de couverture (fichier stocké).',
  `digital_file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Fichier téléchargeable après achat (e-book, PDF).',
  `isbn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Numéro ISBN international si disponible.',
  `is_active` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Si false, le livre n’apparaît plus en vente.',
  `stock_quantity` int unsigned DEFAULT NULL COMMENT 'Stock physique ; null = illimité ou uniquement numérique.',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `books_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Librairie en ligne : ouvrages numériques ou physiques vendus sur le site.';

-- Données : `books` (4 ligne(s))
INSERT INTO `books` (`id`,`title`,`slug`,`description`,`price`,`currency`,`cover_path`,`digital_file_path`,`isbn`,`is_active`,`stock_quantity`,`created_at`,`updated_at`,`deleted_at`) VALUES (1,'7 Bénéfices de la Résolution','7-benefices-de-la-resolution','Découvrez les sept bénéfices puissants qui découlent d\'une résolution ferme en Dieu. Cet ouvrage de la Pasteure Tothy Mbengela vous guide dans la compréhension de la force d\'une décision ancrée dans la foi et vous encourage à tenir ferme dans vos engagements spirituels.','10.00','USD',NULL,NULL,NULL,1,NULL,'2026-03-27 20:27:22','2026-03-27 20:27:22',NULL);
INSERT INTO `books` (`id`,`title`,`slug`,`description`,`price`,`currency`,`cover_path`,`digital_file_path`,`isbn`,`is_active`,`stock_quantity`,`created_at`,`updated_at`,`deleted_at`) VALUES (2,'À l\'Instar d\'Élie','a-linstar-delie','Inspiré par la vie du prophète Élie, ce livre vous invite à vivre une foi audacieuse et courageuse. La Pasteure Tothy Mbengela explore les leçons tirées de la vie d\'Élie pour fortifier votre marche avec Dieu et vous préparer aux défis de la vie chrétienne.','10.00','USD',NULL,NULL,NULL,1,NULL,'2026-03-27 20:27:22','2026-03-27 20:27:22',NULL);
INSERT INTO `books` (`id`,`title`,`slug`,`description`,`price`,`currency`,`cover_path`,`digital_file_path`,`isbn`,`is_active`,`stock_quantity`,`created_at`,`updated_at`,`deleted_at`) VALUES (3,'Attends-la cette Promesse !','attends-la-cette-promesse','Les promesses de Dieu sont certaines, mais elles demandent patience et persévérance. Dans cet ouvrage, la Pasteure Tothy Mbengela vous encourage à ne pas abandonner, à garder la foi et à attendre avec confiance l\'accomplissement des promesses divines dans votre vie.','10.00','USD',NULL,NULL,NULL,1,NULL,'2026-03-27 20:27:22','2026-03-27 20:27:22',NULL);
INSERT INTO `books` (`id`,`title`,`slug`,`description`,`price`,`currency`,`cover_path`,`digital_file_path`,`isbn`,`is_active`,`stock_quantity`,`created_at`,`updated_at`,`deleted_at`) VALUES (4,'Sois Daniel ! La Préparation','sois-daniel-la-preparation','Faisant partie de la Collection S.D., ce livre s\'inspire de la vie de Daniel pour vous préparer à vivre une vie d\'excellence et d\'intégrité au milieu d\'un monde hostile. La Pasteure Tothy Mbengela partage des clés pratiques pour rester fidèle à Dieu en toutes circonstances.','10.00','USD',NULL,NULL,NULL,1,NULL,'2026-03-27 20:27:23','2026-03-27 20:27:23',NULL);


-- -----------------------------
-- Structure : `cache`
-- -----------------------------
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Clé unique de l’entrée de cache.',
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Valeur sérialisée (résultats de requêtes, vues, etc.).',
  `expiration` bigint NOT NULL COMMENT 'Timestamp Unix après lequel l’entrée est considérée comme expirée.',
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Cache applicatif en base (driver database) : paires clé / valeur avec expiration.';


-- -----------------------------
-- Structure : `cache_locks`
-- -----------------------------
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Clé de la ressource verrouillée.',
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Identifiant du détenteur actuel du verrou.',
  `expiration` bigint NOT NULL COMMENT 'Fin de validité du verrou (timestamp Unix).',
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Verrous distribués pour éviter courses critiques sur certaines opérations (cache locks).';


-- -----------------------------
-- Structure : `contact_messages`
-- -----------------------------
DROP TABLE IF EXISTS `contact_messages`;
CREATE TABLE `contact_messages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identifiant du message.',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nom de l’expéditeur.',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'E-mail pour réponse.',
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Téléphone optionnel.',
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Sujet ou motif du message.',
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Corps du message.',
  `is_read` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Lu ou non par l’équipe (file d’attente admin).',
  `read_at` timestamp NULL DEFAULT NULL COMMENT 'Horodatage de première lecture.',
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'IP source (modération / anti-spam).',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Messages reçus via le formulaire de contact public.';


-- -----------------------------
-- Structure : `content_comment_likes`
-- -----------------------------
DROP TABLE IF EXISTS `content_comment_likes`;
CREATE TABLE `content_comment_likes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `content_comment_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `liker_fingerprint` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cc_likes_comment_fp_unique` (`content_comment_id`,`liker_fingerprint`),
  KEY `content_comment_likes_user_id_foreign` (`user_id`),
  CONSTRAINT `content_comment_likes_content_comment_id_foreign` FOREIGN KEY (`content_comment_id`) REFERENCES `content_comments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `content_comment_likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- -----------------------------
-- Structure : `content_comments`
-- -----------------------------
DROP TABLE IF EXISTS `content_comments`;
CREATE TABLE `content_comments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `content_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `author_name` varchar(160) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `content_comments_user_id_foreign` (`user_id`),
  KEY `content_comments_content_id_created_at_index` (`content_id`,`created_at`),
  CONSTRAINT `content_comments_content_id_foreign` FOREIGN KEY (`content_id`) REFERENCES `contents` (`id`) ON DELETE CASCADE,
  CONSTRAINT `content_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- -----------------------------
-- Structure : `content_likes`
-- -----------------------------
DROP TABLE IF EXISTS `content_likes`;
CREATE TABLE `content_likes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `content_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `content_likes_content_id_user_id_unique` (`content_id`,`user_id`),
  KEY `content_likes_user_id_foreign` (`user_id`),
  CONSTRAINT `content_likes_content_id_foreign` FOREIGN KEY (`content_id`) REFERENCES `contents` (`id`) ON DELETE CASCADE,
  CONSTRAINT `content_likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- -----------------------------
-- Structure : `contents`
-- -----------------------------
DROP TABLE IF EXISTS `contents`;
CREATE TABLE `contents` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identifiant du contenu.',
  `rubrique_id` bigint unsigned NOT NULL,
  `series_id` bigint unsigned DEFAULT NULL,
  `theme_id` bigint unsigned DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Type logique : video, audio, podcast, article (contrôlé côté app / Filament).',
  `source` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'internal' COMMENT 'Origine du média : internal (fichier ou URL maison), youtube (lecture via API/embed), external (autre hébergeur).',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Titre affiché sur les listes et la page détail.',
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Slug unique pour l’URL publique.',
  `excerpt` text COLLATE utf8mb4_unicode_ci COMMENT 'Accroche courte pour cartes et partages sociaux.',
  `body` longtext COLLATE utf8mb4_unicode_ci COMMENT 'Texte riche ou description longue (articles, notes d’étude).',
  `media_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'URL de lecture ou téléchargement si hébergement direct (non YouTube).',
  `youtube_video_id` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Identifiant vidéo YouTube (ex. dQw4w9WgXcQ) quand source=youtube ; sert aux embeds et oEmbed.',
  `youtube_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'URL canonique de la vidéo YouTube (watch ou youtu.be) pour lien « voir sur YouTube ».',
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Chemin fichier sur disque si média stocké localement (MP3, MP4, PDF lié, etc.).',
  `thumbnail_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Vignette personnalisée ; si null et YouTube, peut être dérivée via API.',
  `duration_seconds` int unsigned DEFAULT NULL COMMENT 'Durée en secondes pour lecteurs et filtres.',
  `allow_streaming` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Autorise la lecture en ligne sur le site.',
  `allow_download` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Autorise le téléchargement du fichier si applicable.',
  `is_published` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Brouillon vs publié ; combiné à published_at.',
  `published_at` timestamp NULL DEFAULT NULL COMMENT 'Date/heure de mise en ligne effective (ordonnancement, « nouveautés »).',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Mise en avant sur l’accueil ou blocs « à la une ».',
  `position` int unsigned NOT NULL DEFAULT '0' COMMENT 'Ordre manuel dans une liste ou une série.',
  `meta` json DEFAULT NULL COMMENT 'Métadonnées extensibles (IDs externes, stats, champs spécifiques sans migration).',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `contents_slug_unique` (`slug`),
  KEY `contents_series_id_foreign` (`series_id`),
  KEY `contents_theme_id_foreign` (`theme_id`),
  KEY `contents_rubrique_id_type_is_published_index` (`rubrique_id`,`type`,`is_published`),
  CONSTRAINT `contents_rubrique_id_foreign` FOREIGN KEY (`rubrique_id`) REFERENCES `rubriques` (`id`) ON DELETE CASCADE,
  CONSTRAINT `contents_series_id_foreign` FOREIGN KEY (`series_id`) REFERENCES `series` (`id`) ON DELETE SET NULL,
  CONSTRAINT `contents_theme_id_foreign` FOREIGN KEY (`theme_id`) REFERENCES `themes` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Contenus ministère : vidéo, audio, podcast, article ; une partie peut être hébergée sur YouTube (source externe).';

-- Données : `contents` (24 ligne(s))
INSERT INTO `contents` (`id`,`rubrique_id`,`series_id`,`theme_id`,`type`,`source`,`title`,`slug`,`excerpt`,`body`,`media_url`,`youtube_video_id`,`youtube_url`,`file_path`,`thumbnail_path`,`duration_seconds`,`allow_streaming`,`allow_download`,`is_published`,`published_at`,`is_featured`,`position`,`meta`,`created_at`,`updated_at`,`deleted_at`) VALUES (1,1,1,NULL,'video','youtube','Première vidéo — Proverbes','youtube-9MwDprKBkRg',NULL,NULL,NULL,'9MwDprKBkRg','https://www.youtube.com/watch?v=9MwDprKBkRg',NULL,NULL,NULL,1,0,1,'2026-03-26 20:27:18',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2s1I1uJ5EHDGBfZvQaOJ3K8\"}','2026-03-27 20:27:18','2026-03-27 20:27:18',NULL);
INSERT INTO `contents` (`id`,`rubrique_id`,`series_id`,`theme_id`,`type`,`source`,`title`,`slug`,`excerpt`,`body`,`media_url`,`youtube_video_id`,`youtube_url`,`file_path`,`thumbnail_path`,`duration_seconds`,`allow_streaming`,`allow_download`,`is_published`,`published_at`,`is_featured`,`position`,`meta`,`created_at`,`updated_at`,`deleted_at`) VALUES (2,2,2,NULL,'video','youtube','Première vidéo — les minutes de ta destinée','youtube-GXQDovOqoBA',NULL,NULL,NULL,'GXQDovOqoBA','https://www.youtube.com/watch?v=GXQDovOqoBA',NULL,NULL,NULL,1,0,1,'2026-03-25 20:27:18',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2uCPMwKNnlFI-1v1es7AhjA\"}','2026-03-27 20:27:18','2026-03-27 20:27:18',NULL);
INSERT INTO `contents` (`id`,`rubrique_id`,`series_id`,`theme_id`,`type`,`source`,`title`,`slug`,`excerpt`,`body`,`media_url`,`youtube_video_id`,`youtube_url`,`file_path`,`thumbnail_path`,`duration_seconds`,`allow_streaming`,`allow_download`,`is_published`,`published_at`,`is_featured`,`position`,`meta`,`created_at`,`updated_at`,`deleted_at`) VALUES (3,3,3,NULL,'video','youtube','Première vidéo — S’ACCOMPLIR','youtube-3FIhRR3qRog',NULL,NULL,NULL,'3FIhRR3qRog','https://www.youtube.com/watch?v=3FIhRR3qRog',NULL,NULL,NULL,1,0,1,'2026-03-24 20:27:18',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2vCBsN91hMIfQz5PHaiRlgX\"}','2026-03-27 20:27:18','2026-03-27 20:27:18',NULL);
INSERT INTO `contents` (`id`,`rubrique_id`,`series_id`,`theme_id`,`type`,`source`,`title`,`slug`,`excerpt`,`body`,`media_url`,`youtube_video_id`,`youtube_url`,`file_path`,`thumbnail_path`,`duration_seconds`,`allow_streaming`,`allow_download`,`is_published`,`published_at`,`is_featured`,`position`,`meta`,`created_at`,`updated_at`,`deleted_at`) VALUES (4,2,4,NULL,'video','youtube','Première vidéo — SHORTS','youtube-J_CliWzm8ss',NULL,NULL,NULL,'J_CliWzm8ss','https://www.youtube.com/watch?v=J_CliWzm8ss',NULL,NULL,NULL,1,0,1,'2026-03-23 20:27:18',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2vFc808uhHmMBfyPaXXqKyI\"}','2026-03-27 20:27:18','2026-03-27 20:27:18',NULL);
INSERT INTO `contents` (`id`,`rubrique_id`,`series_id`,`theme_id`,`type`,`source`,`title`,`slug`,`excerpt`,`body`,`media_url`,`youtube_video_id`,`youtube_url`,`file_path`,`thumbnail_path`,`duration_seconds`,`allow_streaming`,`allow_download`,`is_published`,`published_at`,`is_featured`,`position`,`meta`,`created_at`,`updated_at`,`deleted_at`) VALUES (5,4,5,NULL,'video','youtube','Première vidéo — PREDICATIONS','youtube-cFQT1lpg5Xw',NULL,NULL,NULL,'cFQT1lpg5Xw','https://www.youtube.com/watch?v=cFQT1lpg5Xw',NULL,NULL,NULL,1,0,1,'2026-03-22 20:27:18',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2tZGNj2cS8PElJCyc3-UoAX\"}','2026-03-27 20:27:18','2026-03-27 20:27:18',NULL);
INSERT INTO `contents` (`id`,`rubrique_id`,`series_id`,`theme_id`,`type`,`source`,`title`,`slug`,`excerpt`,`body`,`media_url`,`youtube_video_id`,`youtube_url`,`file_path`,`thumbnail_path`,`duration_seconds`,`allow_streaming`,`allow_download`,`is_published`,`published_at`,`is_featured`,`position`,`meta`,`created_at`,`updated_at`,`deleted_at`) VALUES (6,4,6,NULL,'video','youtube','Première vidéo — NE POUR VAINCRE','youtube-oSUTbflBQsg',NULL,NULL,NULL,'oSUTbflBQsg','https://www.youtube.com/watch?v=oSUTbflBQsg',NULL,NULL,NULL,1,0,1,'2026-03-21 20:27:18',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2uzP1ZWOokLxP-coaOx2kgb\"}','2026-03-27 20:27:18','2026-03-27 20:27:18',NULL);
INSERT INTO `contents` (`id`,`rubrique_id`,`series_id`,`theme_id`,`type`,`source`,`title`,`slug`,`excerpt`,`body`,`media_url`,`youtube_video_id`,`youtube_url`,`file_path`,`thumbnail_path`,`duration_seconds`,`allow_streaming`,`allow_download`,`is_published`,`published_at`,`is_featured`,`position`,`meta`,`created_at`,`updated_at`,`deleted_at`) VALUES (7,1,7,NULL,'video','youtube','Première vidéo — LES COMMENT','youtube-vYerKexKZyk',NULL,NULL,NULL,'vYerKexKZyk','https://www.youtube.com/watch?v=vYerKexKZyk',NULL,NULL,NULL,1,0,1,'2026-03-20 20:27:18',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2uiRaa-pyd5HXhx7qQ_iTXg\"}','2026-03-27 20:27:18','2026-03-27 20:27:18',NULL);
INSERT INTO `contents` (`id`,`rubrique_id`,`series_id`,`theme_id`,`type`,`source`,`title`,`slug`,`excerpt`,`body`,`media_url`,`youtube_video_id`,`youtube_url`,`file_path`,`thumbnail_path`,`duration_seconds`,`allow_streaming`,`allow_download`,`is_published`,`published_at`,`is_featured`,`position`,`meta`,`created_at`,`updated_at`,`deleted_at`) VALUES (8,4,8,NULL,'video','youtube','VEUILLE SEULEMENT L’ÉTERNEL, TON DIEU, ÊTRE AVEC TOI | Pasteure Tothy Mbengela','youtube-Asc3iaC4IK4',NULL,NULL,NULL,'Asc3iaC4IK4','https://www.youtube.com/watch?v=Asc3iaC4IK4',NULL,NULL,NULL,1,0,1,'2026-03-17 08:14:06',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2sD9r4q7PdGyZo5puKtFvx9\"}','2026-03-27 20:27:18','2026-03-27 20:27:18',NULL);
INSERT INTO `contents` (`id`,`rubrique_id`,`series_id`,`theme_id`,`type`,`source`,`title`,`slug`,`excerpt`,`body`,`media_url`,`youtube_video_id`,`youtube_url`,`file_path`,`thumbnail_path`,`duration_seconds`,`allow_streaming`,`allow_download`,`is_published`,`published_at`,`is_featured`,`position`,`meta`,`created_at`,`updated_at`,`deleted_at`) VALUES (9,5,9,NULL,'video','youtube','Première vidéo — FEMME DISCIPLE DE JESUS','youtube-7flJZzwDy_Q',NULL,NULL,NULL,'7flJZzwDy_Q','https://www.youtube.com/watch?v=7flJZzwDy_Q',NULL,NULL,NULL,1,0,1,'2026-03-18 20:27:18',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2v_8yPCFZhkQ9bXcT-oRjJr\"}','2026-03-27 20:27:18','2026-03-27 20:27:18',NULL);
INSERT INTO `contents` (`id`,`rubrique_id`,`series_id`,`theme_id`,`type`,`source`,`title`,`slug`,`excerpt`,`body`,`media_url`,`youtube_video_id`,`youtube_url`,`file_path`,`thumbnail_path`,`duration_seconds`,`allow_streaming`,`allow_download`,`is_published`,`published_at`,`is_featured`,`position`,`meta`,`created_at`,`updated_at`,`deleted_at`) VALUES (10,6,10,NULL,'video','youtube','MES DECLARATIONS | Mars 2026 | Pasteure Tothy MBENGELA','youtube-6K1sZTwY9Vs',NULL,NULL,NULL,'6K1sZTwY9Vs','https://www.youtube.com/watch?v=6K1sZTwY9Vs',NULL,NULL,NULL,1,0,1,'2026-03-01 10:35:49',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2vf9n2r_mdvtPB6UhVf2aAC\"}','2026-03-27 20:27:18','2026-03-27 20:27:18',NULL);
INSERT INTO `contents` (`id`,`rubrique_id`,`series_id`,`theme_id`,`type`,`source`,`title`,`slug`,`excerpt`,`body`,`media_url`,`youtube_video_id`,`youtube_url`,`file_path`,`thumbnail_path`,`duration_seconds`,`allow_streaming`,`allow_download`,`is_published`,`published_at`,`is_featured`,`position`,`meta`,`created_at`,`updated_at`,`deleted_at`) VALUES (11,3,11,NULL,'video','youtube','Première vidéo — ET SI TU PRIAIS / Court-Métrage','youtube-fPNDYt4WZog',NULL,NULL,NULL,'fPNDYt4WZog','https://www.youtube.com/watch?v=fPNDYt4WZog',NULL,NULL,NULL,1,0,1,'2026-03-16 20:27:18',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2uby5SrqpArUStxfl8cj1n4\"}','2026-03-27 20:27:18','2026-03-27 20:27:18',NULL);
INSERT INTO `contents` (`id`,`rubrique_id`,`series_id`,`theme_id`,`type`,`source`,`title`,`slug`,`excerpt`,`body`,`media_url`,`youtube_video_id`,`youtube_url`,`file_path`,`thumbnail_path`,`duration_seconds`,`allow_streaming`,`allow_download`,`is_published`,`published_at`,`is_featured`,`position`,`meta`,`created_at`,`updated_at`,`deleted_at`) VALUES (12,2,4,NULL,'video','youtube','MES 4 LIVRES SONT DESORMAIS DISPONIBLES #livresinspirants','youtube-C7qfNyJKRn0','Les livres sont désormais disponibles et à votre portée.',NULL,NULL,'C7qfNyJKRn0','https://www.youtube.com/watch?v=C7qfNyJKRn0',NULL,NULL,NULL,1,0,1,'2026-03-18 12:43:29',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2vFc808uhHmMBfyPaXXqKyI\"}','2026-03-27 20:27:18','2026-03-27 20:27:18',NULL);
INSERT INTO `contents` (`id`,`rubrique_id`,`series_id`,`theme_id`,`type`,`source`,`title`,`slug`,`excerpt`,`body`,`media_url`,`youtube_video_id`,`youtube_url`,`file_path`,`thumbnail_path`,`duration_seconds`,`allow_streaming`,`allow_download`,`is_published`,`published_at`,`is_featured`,`position`,`meta`,`created_at`,`updated_at`,`deleted_at`) VALUES (13,3,3,NULL,'video','youtube','MON HISTOIRE VERS L’ÉCRITURE | VERNISSAGE DE QUATRE LIVRES','youtube-0BH75IkAuq4',NULL,NULL,NULL,'0BH75IkAuq4','https://www.youtube.com/watch?v=0BH75IkAuq4',NULL,NULL,NULL,1,0,1,'2026-02-28 21:44:20',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2vCBsN91hMIfQz5PHaiRlgX\"}','2026-03-27 20:27:18','2026-03-27 20:27:18',NULL);
INSERT INTO `contents` (`id`,`rubrique_id`,`series_id`,`theme_id`,`type`,`source`,`title`,`slug`,`excerpt`,`body`,`media_url`,`youtube_video_id`,`youtube_url`,`file_path`,`thumbnail_path`,`duration_seconds`,`allow_streaming`,`allow_download`,`is_published`,`published_at`,`is_featured`,`position`,`meta`,`created_at`,`updated_at`,`deleted_at`) VALUES (14,4,8,NULL,'video','youtube','IL PEUT FAIRE INFINIMENT AU DELÀ | Pasteure Tothy Mbengela','youtube-460ftY_DReE',NULL,NULL,NULL,'460ftY_DReE','https://www.youtube.com/watch?v=460ftY_DReE',NULL,NULL,NULL,1,0,1,'2026-02-16 13:03:26',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2sD9r4q7PdGyZo5puKtFvx9\"}','2026-03-27 20:27:18','2026-03-27 20:27:18',NULL);
INSERT INTO `contents` (`id`,`rubrique_id`,`series_id`,`theme_id`,`type`,`source`,`title`,`slug`,`excerpt`,`body`,`media_url`,`youtube_video_id`,`youtube_url`,`file_path`,`thumbnail_path`,`duration_seconds`,`allow_streaming`,`allow_download`,`is_published`,`published_at`,`is_featured`,`position`,`meta`,`created_at`,`updated_at`,`deleted_at`) VALUES (15,4,8,NULL,'video','youtube','QUE L’ÉTERNEL VOUS BÉNISSE COMME IL VOUS L’A PROMIS | Pasteure Tothy Mbengela','youtube-ipfxjB-9KZ0',NULL,NULL,NULL,'ipfxjB-9KZ0','https://www.youtube.com/watch?v=ipfxjB-9KZ0',NULL,NULL,NULL,1,0,1,'2026-02-03 05:09:39',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2sD9r4q7PdGyZo5puKtFvx9\"}','2026-03-27 20:27:18','2026-03-27 20:27:18',NULL);
INSERT INTO `contents` (`id`,`rubrique_id`,`series_id`,`theme_id`,`type`,`source`,`title`,`slug`,`excerpt`,`body`,`media_url`,`youtube_video_id`,`youtube_url`,`file_path`,`thumbnail_path`,`duration_seconds`,`allow_streaming`,`allow_download`,`is_published`,`published_at`,`is_featured`,`position`,`meta`,`created_at`,`updated_at`,`deleted_at`) VALUES (16,6,10,NULL,'video','youtube','MES DECLARATIONS | Février 2026 | Maman Lévi NGALULA','youtube-3HXUCDTAItE',NULL,NULL,NULL,'3HXUCDTAItE','https://www.youtube.com/watch?v=3HXUCDTAItE',NULL,NULL,NULL,1,0,1,'2026-02-01 10:27:51',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2vf9n2r_mdvtPB6UhVf2aAC\"}','2026-03-27 20:27:18','2026-03-27 20:27:18',NULL);
INSERT INTO `contents` (`id`,`rubrique_id`,`series_id`,`theme_id`,`type`,`source`,`title`,`slug`,`excerpt`,`body`,`media_url`,`youtube_video_id`,`youtube_url`,`file_path`,`thumbnail_path`,`duration_seconds`,`allow_streaming`,`allow_download`,`is_published`,`published_at`,`is_featured`,`position`,`meta`,`created_at`,`updated_at`,`deleted_at`) VALUES (17,6,10,NULL,'video','youtube','MES DECLARATIONS | Février 2026 | Maman Lévi NGALULA','youtube-fc1CQ6g2GTU',NULL,NULL,NULL,'fc1CQ6g2GTU','https://www.youtube.com/watch?v=fc1CQ6g2GTU',NULL,NULL,NULL,1,0,1,'2026-01-31 21:27:15',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2vf9n2r_mdvtPB6UhVf2aAC\"}','2026-03-27 20:27:18','2026-03-27 20:27:18',NULL);
INSERT INTO `contents` (`id`,`rubrique_id`,`series_id`,`theme_id`,`type`,`source`,`title`,`slug`,`excerpt`,`body`,`media_url`,`youtube_video_id`,`youtube_url`,`file_path`,`thumbnail_path`,`duration_seconds`,`allow_streaming`,`allow_download`,`is_published`,`published_at`,`is_featured`,`position`,`meta`,`created_at`,`updated_at`,`deleted_at`) VALUES (18,4,5,NULL,'video','youtube','FAITES DONC MOURIR VOTRE CHAIR | Pasteure Tothy Mbengela','youtube-d0cnu_4z2Jc',NULL,NULL,NULL,'d0cnu_4z2Jc','https://www.youtube.com/watch?v=d0cnu_4z2Jc',NULL,NULL,NULL,1,0,1,'2026-01-28 16:01:15',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2tZGNj2cS8PElJCyc3-UoAX\"}','2026-03-27 20:27:18','2026-03-27 20:27:18',NULL);
INSERT INTO `contents` (`id`,`rubrique_id`,`series_id`,`theme_id`,`type`,`source`,`title`,`slug`,`excerpt`,`body`,`media_url`,`youtube_video_id`,`youtube_url`,`file_path`,`thumbnail_path`,`duration_seconds`,`allow_streaming`,`allow_download`,`is_published`,`published_at`,`is_featured`,`position`,`meta`,`created_at`,`updated_at`,`deleted_at`) VALUES (19,4,5,NULL,'video','youtube','SOUVIENS-TOI QUE TU ES EN VOYAGE | Pasteure Tothy Mbengela','youtube-7OkAo286H40',NULL,NULL,NULL,'7OkAo286H40','https://www.youtube.com/watch?v=7OkAo286H40',NULL,NULL,NULL,1,0,1,'2026-01-19 14:26:50',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2tZGNj2cS8PElJCyc3-UoAX\"}','2026-03-27 20:27:18','2026-03-27 20:27:18',NULL);
INSERT INTO `contents` (`id`,`rubrique_id`,`series_id`,`theme_id`,`type`,`source`,`title`,`slug`,`excerpt`,`body`,`media_url`,`youtube_video_id`,`youtube_url`,`file_path`,`thumbnail_path`,`duration_seconds`,`allow_streaming`,`allow_download`,`is_published`,`published_at`,`is_featured`,`position`,`meta`,`created_at`,`updated_at`,`deleted_at`) VALUES (20,4,6,NULL,'video','youtube','VAINCRE LA COLÈRE PAR LA PRIÈRE - Pasteure Tothy Mbengela','youtube-qbQ2DOc_r4c',NULL,NULL,NULL,'qbQ2DOc_r4c','https://www.youtube.com/watch?v=qbQ2DOc_r4c',NULL,NULL,NULL,1,0,1,'2026-01-12 08:32:20',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2uzP1ZWOokLxP-coaOx2kgb\"}','2026-03-27 20:27:18','2026-03-27 20:27:18',NULL);
INSERT INTO `contents` (`id`,`rubrique_id`,`series_id`,`theme_id`,`type`,`source`,`title`,`slug`,`excerpt`,`body`,`media_url`,`youtube_video_id`,`youtube_url`,`file_path`,`thumbnail_path`,`duration_seconds`,`allow_streaming`,`allow_download`,`is_published`,`published_at`,`is_featured`,`position`,`meta`,`created_at`,`updated_at`,`deleted_at`) VALUES (21,6,10,NULL,'video','youtube','MES DECLARATIONS | DÉCEMBRE 2025 | Pasteure Tothy MBENGELA','youtube-q4RsEMhO1WM',NULL,NULL,NULL,'q4RsEMhO1WM','https://www.youtube.com/watch?v=q4RsEMhO1WM',NULL,NULL,NULL,1,0,1,'2025-12-01 10:51:03',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2vf9n2r_mdvtPB6UhVf2aAC\"}','2026-03-27 20:27:18','2026-03-27 20:27:18',NULL);
INSERT INTO `contents` (`id`,`rubrique_id`,`series_id`,`theme_id`,`type`,`source`,`title`,`slug`,`excerpt`,`body`,`media_url`,`youtube_video_id`,`youtube_url`,`file_path`,`thumbnail_path`,`duration_seconds`,`allow_streaming`,`allow_download`,`is_published`,`published_at`,`is_featured`,`position`,`meta`,`created_at`,`updated_at`,`deleted_at`) VALUES (22,6,10,NULL,'video','youtube','MES DÉCLARATIONS | NOVEMBRE 2025 | Pasteure Tothy MBENGELA','youtube-TzHPp3DgRuA',NULL,NULL,NULL,'TzHPp3DgRuA','https://www.youtube.com/watch?v=TzHPp3DgRuA',NULL,NULL,NULL,1,0,1,'2025-11-01 10:10:50',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2vf9n2r_mdvtPB6UhVf2aAC\"}','2026-03-27 20:27:18','2026-03-27 20:27:18',NULL);
INSERT INTO `contents` (`id`,`rubrique_id`,`series_id`,`theme_id`,`type`,`source`,`title`,`slug`,`excerpt`,`body`,`media_url`,`youtube_video_id`,`youtube_url`,`file_path`,`thumbnail_path`,`duration_seconds`,`allow_streaming`,`allow_download`,`is_published`,`published_at`,`is_featured`,`position`,`meta`,`created_at`,`updated_at`,`deleted_at`) VALUES (23,6,10,NULL,'video','youtube','MES DECLARATIONS | OCTOBRE | Pasteure Tothy MBENGELA','youtube-ywJ81B3IQjs',NULL,NULL,NULL,'ywJ81B3IQjs','https://www.youtube.com/watch?v=ywJ81B3IQjs',NULL,NULL,NULL,1,0,1,'2025-09-30 21:59:36',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2vf9n2r_mdvtPB6UhVf2aAC\"}','2026-03-27 20:27:18','2026-03-27 20:27:18',NULL);
INSERT INTO `contents` (`id`,`rubrique_id`,`series_id`,`theme_id`,`type`,`source`,`title`,`slug`,`excerpt`,`body`,`media_url`,`youtube_video_id`,`youtube_url`,`file_path`,`thumbnail_path`,`duration_seconds`,`allow_streaming`,`allow_download`,`is_published`,`published_at`,`is_featured`,`position`,`meta`,`created_at`,`updated_at`,`deleted_at`) VALUES (24,6,10,NULL,'video','youtube','MES DECLARATIONS | Mois de Septembre | Maman Lévi NGALULA','youtube-yfGCHRZIvDo',NULL,NULL,NULL,'yfGCHRZIvDo','https://www.youtube.com/watch?v=yfGCHRZIvDo',NULL,NULL,NULL,1,0,1,'2025-09-01 10:25:11',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2vf9n2r_mdvtPB6UhVf2aAC\"}','2026-03-27 20:27:18','2026-03-27 20:27:18',NULL);


-- -----------------------------
-- Structure : `donations`
-- -----------------------------
DROP TABLE IF EXISTS `donations`;
CREATE TABLE `donations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identifiant du don.',
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `donor_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Nom affiché si don non anonyme.',
  `donor_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'E-mail pour reçu ou remerciement.',
  `donor_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Téléphone pour SMS de confirmation si besoin.',
  `amount` decimal(12,2) NOT NULL COMMENT 'Montant du don dans la devise indiquée.',
  `currency` char(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'USD' COMMENT 'Devise ISO 4217.',
  `frequency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'once' COMMENT 'once ou monthly selon engagement récurrent.',
  `is_anonymous` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Masquer l’identité sur les listes publiques éventuelles.',
  `message` text COLLATE utf8mb4_unicode_ci COMMENT 'Mot ou prière laissé par le donateur.',
  `payment_provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Passerelle : stripe, m_pesa, orange_money, etc.',
  `external_payment_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ID transaction côté prestataire.',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending' COMMENT 'pending, completed, failed, refunded.',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `donations_reference_unique` (`reference`),
  KEY `donations_status_created_at_index` (`status`,`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Dons ponctuels ou réguliers au ministère ; traçabilité paiement et remerciements.';


-- -----------------------------
-- Structure : `failed_jobs`
-- -----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identifiant interne de l’échec.',
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'UUID unique du job échoué.',
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Connexion queue utilisée.',
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nom de la queue d’origine.',
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Payload du job au moment de l’échec.',
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Trace ou message d’exception.',
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date/heure de l’échec.',
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Jobs définitivement en échec pour inspection et retry manuel.';


-- -----------------------------
-- Structure : `job_batches`
-- -----------------------------
DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'UUID du lot.',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nom descriptif du batch.',
  `total_jobs` int NOT NULL COMMENT 'Nombre total de jobs du lot.',
  `pending_jobs` int NOT NULL COMMENT 'Jobs encore en attente.',
  `failed_jobs` int NOT NULL COMMENT 'Jobs en échec définitif.',
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Liste des IDs des jobs échoués.',
  `options` mediumtext COLLATE utf8mb4_unicode_ci COMMENT 'Options JSON du batch.',
  `cancelled_at` int DEFAULT NULL COMMENT 'Annulation du lot si renseigné.',
  `created_at` int NOT NULL COMMENT 'Création du lot.',
  `finished_at` int DEFAULT NULL COMMENT 'Fin complète du lot.',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Lots de jobs groupés (batch) pour suivi global de progression.';


-- -----------------------------
-- Structure : `jobs`
-- -----------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identifiant du job en file.',
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nom de la queue cible (default, mails, etc.).',
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Commande sérialisée et données du job.',
  `attempts` tinyint unsigned NOT NULL COMMENT 'Nombre de tentatives déjà effectuées.',
  `reserved_at` int unsigned DEFAULT NULL COMMENT 'Timestamp de prise en charge par un worker.',
  `available_at` int unsigned NOT NULL COMMENT 'Job exécutable à partir de ce timestamp.',
  `created_at` int unsigned NOT NULL COMMENT 'Timestamp de mise en file.',
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='File d’attente des jobs Laravel (queues database) en attente d’exécution.';


-- -----------------------------
-- Structure : `migrations`
-- -----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Données : `migrations` (29 ligne(s))
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES (1,'0001_01_01_000000_create_users_table',1);
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES (2,'0001_01_01_000001_create_cache_table',1);
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES (3,'0001_01_01_000002_create_jobs_table',1);
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES (4,'2026_03_21_122508_create_admins_table',1);
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES (5,'2026_03_22_100000_create_rubriques_table',1);
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES (6,'2026_03_22_100001_create_themes_table',1);
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES (7,'2026_03_22_100002_create_series_table',1);
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES (8,'2026_03_22_100003_create_contents_table',1);
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES (9,'2026_03_22_100004_create_books_table',1);
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES (10,'2026_03_22_100005_create_orders_table',1);
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES (11,'2026_03_22_100006_create_order_items_table',1);
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES (12,'2026_03_22_100007_create_newsletter_subscribers_table',1);
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES (13,'2026_03_22_100008_create_contact_messages_table',1);
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES (14,'2026_03_22_100009_create_appointment_requests_table',1);
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES (15,'2026_03_22_100010_create_donations_table',1);
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES (16,'2026_03_22_100011_create_partner_commitments_table',1);
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES (17,'2026_03_22_130000_sync_users_contents_partners_schema',1);
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES (18,'2026_03_22_200000_add_thumbnails_icons_to_rubriques_themes_series',1);
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES (19,'2026_03_23_161437_create_permission_tables',1);
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES (20,'2026_03_25_014650_create_testimonials_table',1);
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES (21,'2026_03_25_120000_add_payment_reference_columns',1);
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES (22,'2026_03_25_120000_add_reference_and_external_to_orders_table',1);
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES (23,'2026_03_25_140000_create_shipping_settings_table',1);
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES (24,'2026_03_25_140001_add_shipping_and_grand_total_to_orders_table',1);
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES (25,'2026_03_26_100000_add_shipping_address_and_phone_to_orders_table',1);
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES (26,'2026_03_26_120000_add_confirmation_token_to_newsletter_subscribers_table',1);
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES (27,'2026_03_27_180000_create_content_comments_and_likes_tables',1);
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES (28,'2026_03_27_180001_create_content_comment_likes_table_if_missing',1);
INSERT INTO `migrations` (`id`,`migration`,`batch`) VALUES (29,'2026_03_27_184204_create_content_likes_table',1);


-- -----------------------------
-- Structure : `model_has_permissions`
-- -----------------------------
DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- -----------------------------
-- Structure : `model_has_roles`
-- -----------------------------
DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Données : `model_has_roles` (1 ligne(s))
INSERT INTO `model_has_roles` (`role_id`,`model_type`,`model_id`) VALUES (1,'App\\Models\\Admin',1);


-- -----------------------------
-- Structure : `newsletter_subscribers`
-- -----------------------------
DROP TABLE IF EXISTS `newsletter_subscribers`;
CREATE TABLE `newsletter_subscribers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identifiant de l’inscription.',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Adresse pour envoi des campagnes (clé métier).',
  `confirmation_token` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Jeton d’inscription (double opt-in) jusqu’à confirmation.',
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Numéro pour notifications SMS si intégration future.',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Prénom ou nom pour personnalisation des envois.',
  `verified_at` timestamp NULL DEFAULT NULL COMMENT 'Double opt-in : date de confirmation d’inscription.',
  `unsubscribed_at` timestamp NULL DEFAULT NULL COMMENT 'Date de désinscription (RGPD / stop envoi).',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `newsletter_subscribers_email_unique` (`email`),
  UNIQUE KEY `newsletter_subscribers_confirmation_token_unique` (`confirmation_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Inscrits newsletter / alertes nouveaux contenus (e-mail et option SMS).';


-- -----------------------------
-- Structure : `order_items`
-- -----------------------------
DROP TABLE IF EXISTS `order_items`;
CREATE TABLE `order_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identifiant de la ligne.',
  `order_id` bigint unsigned NOT NULL,
  `book_id` bigint unsigned NOT NULL,
  `quantity` int unsigned NOT NULL DEFAULT '1' COMMENT 'Nombre d’unités achetées.',
  `unit_price` decimal(12,2) NOT NULL COMMENT 'Prix unitaire au moment de la commande (historique).',
  `line_total` decimal(12,2) NOT NULL COMMENT 'quantity × unit_price ; figé pour comptabilité.',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_book_id_foreign` (`book_id`),
  CONSTRAINT `order_items_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Lignes de commande : quantité et prix figés au moment de l’achat.';


-- -----------------------------
-- Structure : `orders`
-- -----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT 'Numéro interne de commande.',
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `guest_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'E-mail de l’invité pour envoi facture / lien de téléchargement.',
  `guest_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Téléphone invité pour suivi ou Mobile Money.',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending' COMMENT 'État métier : pending, paid, cancelled, refunded, etc.',
  `subtotal` decimal(12,2) NOT NULL COMMENT 'Total articles avant frais éventuels (livraison, taxes).',
  `shipping_opt_in` tinyint(1) NOT NULL DEFAULT '0',
  `shipping_country` char(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_city` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_address` text COLLATE utf8mb4_unicode_ci,
  `shipping_phone` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_cost` decimal(12,2) NOT NULL DEFAULT '0.00',
  `grand_total` decimal(12,2) DEFAULT NULL,
  `currency` char(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'USD' COMMENT 'Devise de la commande (ISO 4217).',
  `payment_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending' COMMENT 'État du paiement : pending, completed, failed.',
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Moyen utilisé : card, m_pesa, orange_money, etc.',
  `payment_reference` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Référence fournie par le prestataire de paiement.',
  `external_payment_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci COMMENT 'Remarques client ou internes (logistique).',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_reference_unique` (`reference`),
  KEY `orders_user_id_status_index` (`user_id`,`status`),
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Commandes librairie ; liées à un utilisateur connecté ou à un invité (e-mail / téléphone).';


-- -----------------------------
-- Structure : `partner_commitments`
-- -----------------------------
DROP TABLE IF EXISTS `partner_commitments`;
CREATE TABLE `partner_commitments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identifiant de l’engagement partenaire.',
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL,
  `monthly_amount` decimal(12,2) NOT NULL COMMENT 'Montant mensuel promis ou prélevé.',
  `currency` char(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'USD' COMMENT 'Devise ISO 4217 du montant.',
  `message` text COLLATE utf8mb4_unicode_ci COMMENT 'Mot du partenaire ou modalités particulières.',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending' COMMENT 'pending, active, paused, ended, rejected.',
  `payment_reference` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Référence abonnement ou mandat chez le prestataire de paiement.',
  `external_payment_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `partner_commitments_reference_unique` (`reference`),
  KEY `partner_commitments_user_id_foreign` (`user_id`),
  CONSTRAINT `partner_commitments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Partenariats financiers : chaque engagement est lié à un compte users (inscription obligatoire avant statut partenaire).';


-- -----------------------------
-- Structure : `password_reset_tokens`
-- -----------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'E-mail du compte concerné ; clé primaire logique.',
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Jeton signé ou hashé envoyé par lien dans l’e-mail.',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'Date de création du jeton (expiration gérée par l’application).',
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Jetons de réinitialisation de mot de passe pour les utilisateurs (file d’attente e-mail).';


-- -----------------------------
-- Structure : `permissions`
-- -----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=173 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Données : `permissions` (172 ligne(s))
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (1,'ViewAny:AppointmentRequest','admin','2026-03-27 20:28:11','2026-03-27 20:28:11');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (2,'View:AppointmentRequest','admin','2026-03-27 20:28:11','2026-03-27 20:28:11');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (3,'Create:AppointmentRequest','admin','2026-03-27 20:28:11','2026-03-27 20:28:11');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (4,'Update:AppointmentRequest','admin','2026-03-27 20:28:11','2026-03-27 20:28:11');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (5,'Delete:AppointmentRequest','admin','2026-03-27 20:28:11','2026-03-27 20:28:11');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (6,'DeleteAny:AppointmentRequest','admin','2026-03-27 20:28:11','2026-03-27 20:28:11');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (7,'Restore:AppointmentRequest','admin','2026-03-27 20:28:11','2026-03-27 20:28:11');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (8,'ForceDelete:AppointmentRequest','admin','2026-03-27 20:28:11','2026-03-27 20:28:11');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (9,'ForceDeleteAny:AppointmentRequest','admin','2026-03-27 20:28:11','2026-03-27 20:28:11');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (10,'RestoreAny:AppointmentRequest','admin','2026-03-27 20:28:11','2026-03-27 20:28:11');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (11,'Replicate:AppointmentRequest','admin','2026-03-27 20:28:11','2026-03-27 20:28:11');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (12,'Reorder:AppointmentRequest','admin','2026-03-27 20:28:11','2026-03-27 20:28:11');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (13,'ViewAny:Book','admin','2026-03-27 20:28:11','2026-03-27 20:28:11');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (14,'View:Book','admin','2026-03-27 20:28:11','2026-03-27 20:28:11');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (15,'Create:Book','admin','2026-03-27 20:28:11','2026-03-27 20:28:11');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (16,'Update:Book','admin','2026-03-27 20:28:11','2026-03-27 20:28:11');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (17,'Delete:Book','admin','2026-03-27 20:28:11','2026-03-27 20:28:11');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (18,'DeleteAny:Book','admin','2026-03-27 20:28:11','2026-03-27 20:28:11');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (19,'Restore:Book','admin','2026-03-27 20:28:11','2026-03-27 20:28:11');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (20,'ForceDelete:Book','admin','2026-03-27 20:28:11','2026-03-27 20:28:11');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (21,'ForceDeleteAny:Book','admin','2026-03-27 20:28:11','2026-03-27 20:28:11');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (22,'RestoreAny:Book','admin','2026-03-27 20:28:11','2026-03-27 20:28:11');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (23,'Replicate:Book','admin','2026-03-27 20:28:11','2026-03-27 20:28:11');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (24,'Reorder:Book','admin','2026-03-27 20:28:11','2026-03-27 20:28:11');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (25,'ViewAny:ContactMessage','admin','2026-03-27 20:28:11','2026-03-27 20:28:11');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (26,'View:ContactMessage','admin','2026-03-27 20:28:11','2026-03-27 20:28:11');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (27,'Create:ContactMessage','admin','2026-03-27 20:28:11','2026-03-27 20:28:11');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (28,'Update:ContactMessage','admin','2026-03-27 20:28:11','2026-03-27 20:28:11');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (29,'Delete:ContactMessage','admin','2026-03-27 20:28:11','2026-03-27 20:28:11');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (30,'DeleteAny:ContactMessage','admin','2026-03-27 20:28:11','2026-03-27 20:28:11');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (31,'Restore:ContactMessage','admin','2026-03-27 20:28:11','2026-03-27 20:28:11');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (32,'ForceDelete:ContactMessage','admin','2026-03-27 20:28:11','2026-03-27 20:28:11');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (33,'ForceDeleteAny:ContactMessage','admin','2026-03-27 20:28:11','2026-03-27 20:28:11');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (34,'RestoreAny:ContactMessage','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (35,'Replicate:ContactMessage','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (36,'Reorder:ContactMessage','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (37,'ViewAny:Content','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (38,'View:Content','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (39,'Create:Content','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (40,'Update:Content','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (41,'Delete:Content','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (42,'DeleteAny:Content','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (43,'Restore:Content','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (44,'ForceDelete:Content','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (45,'ForceDeleteAny:Content','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (46,'RestoreAny:Content','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (47,'Replicate:Content','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (48,'Reorder:Content','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (49,'ViewAny:Donation','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (50,'View:Donation','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (51,'Create:Donation','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (52,'Update:Donation','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (53,'Delete:Donation','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (54,'DeleteAny:Donation','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (55,'Restore:Donation','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (56,'ForceDelete:Donation','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (57,'ForceDeleteAny:Donation','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (58,'RestoreAny:Donation','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (59,'Replicate:Donation','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (60,'Reorder:Donation','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (61,'ViewAny:NewsletterSubscriber','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (62,'View:NewsletterSubscriber','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (63,'Create:NewsletterSubscriber','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (64,'Update:NewsletterSubscriber','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (65,'Delete:NewsletterSubscriber','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (66,'DeleteAny:NewsletterSubscriber','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (67,'Restore:NewsletterSubscriber','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (68,'ForceDelete:NewsletterSubscriber','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (69,'ForceDeleteAny:NewsletterSubscriber','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (70,'RestoreAny:NewsletterSubscriber','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (71,'Replicate:NewsletterSubscriber','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (72,'Reorder:NewsletterSubscriber','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (73,'ViewAny:Order','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (74,'View:Order','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (75,'Create:Order','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (76,'Update:Order','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (77,'Delete:Order','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (78,'DeleteAny:Order','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (79,'Restore:Order','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (80,'ForceDelete:Order','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (81,'ForceDeleteAny:Order','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (82,'RestoreAny:Order','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (83,'Replicate:Order','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (84,'Reorder:Order','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (85,'ViewAny:PartnerCommitment','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (86,'View:PartnerCommitment','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (87,'Create:PartnerCommitment','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (88,'Update:PartnerCommitment','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (89,'Delete:PartnerCommitment','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (90,'DeleteAny:PartnerCommitment','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (91,'Restore:PartnerCommitment','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (92,'ForceDelete:PartnerCommitment','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (93,'ForceDeleteAny:PartnerCommitment','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (94,'RestoreAny:PartnerCommitment','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (95,'Replicate:PartnerCommitment','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (96,'Reorder:PartnerCommitment','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (97,'ViewAny:Rubrique','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (98,'View:Rubrique','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (99,'Create:Rubrique','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (100,'Update:Rubrique','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (101,'Delete:Rubrique','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (102,'DeleteAny:Rubrique','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (103,'Restore:Rubrique','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (104,'ForceDelete:Rubrique','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (105,'ForceDeleteAny:Rubrique','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (106,'RestoreAny:Rubrique','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (107,'Replicate:Rubrique','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (108,'Reorder:Rubrique','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (109,'ViewAny:Series','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (110,'View:Series','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (111,'Create:Series','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (112,'Update:Series','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (113,'Delete:Series','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (114,'DeleteAny:Series','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (115,'Restore:Series','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (116,'ForceDelete:Series','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (117,'ForceDeleteAny:Series','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (118,'RestoreAny:Series','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (119,'Replicate:Series','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (120,'Reorder:Series','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (121,'ViewAny:ShippingSetting','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (122,'View:ShippingSetting','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (123,'Create:ShippingSetting','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (124,'Update:ShippingSetting','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (125,'Delete:ShippingSetting','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (126,'DeleteAny:ShippingSetting','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (127,'Restore:ShippingSetting','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (128,'ForceDelete:ShippingSetting','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (129,'ForceDeleteAny:ShippingSetting','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (130,'RestoreAny:ShippingSetting','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (131,'Replicate:ShippingSetting','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (132,'Reorder:ShippingSetting','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (133,'ViewAny:Theme','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (134,'View:Theme','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (135,'Create:Theme','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (136,'Update:Theme','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (137,'Delete:Theme','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (138,'DeleteAny:Theme','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (139,'Restore:Theme','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (140,'ForceDelete:Theme','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (141,'ForceDeleteAny:Theme','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (142,'RestoreAny:Theme','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (143,'Replicate:Theme','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (144,'Reorder:Theme','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (145,'ViewAny:User','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (146,'View:User','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (147,'Create:User','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (148,'Update:User','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (149,'Delete:User','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (150,'DeleteAny:User','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (151,'Restore:User','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (152,'ForceDelete:User','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (153,'ForceDeleteAny:User','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (154,'RestoreAny:User','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (155,'Replicate:User','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (156,'Reorder:User','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (157,'ViewAny:Role','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (158,'View:Role','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (159,'Create:Role','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (160,'Update:Role','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (161,'Delete:Role','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (162,'DeleteAny:Role','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (163,'Restore:Role','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (164,'ForceDelete:Role','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (165,'ForceDeleteAny:Role','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (166,'RestoreAny:Role','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (167,'Replicate:Role','admin','2026-03-27 20:28:12','2026-03-27 20:28:12');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (168,'Reorder:Role','admin','2026-03-27 20:28:13','2026-03-27 20:28:13');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (169,'View:ContenuMinistereStatsWidget','admin','2026-03-27 20:28:13','2026-03-27 20:28:13');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (170,'View:BoutiqueStatsWidget','admin','2026-03-27 20:28:13','2026-03-27 20:28:13');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (171,'View:EngagementStatsWidget','admin','2026-03-27 20:28:13','2026-03-27 20:28:13');
INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (172,'View:ComptesSiteStatsWidget','admin','2026-03-27 20:28:13','2026-03-27 20:28:13');


-- -----------------------------
-- Structure : `role_has_permissions`
-- -----------------------------
DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Données : `role_has_permissions` (172 ligne(s))
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (1,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (2,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (3,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (4,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (5,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (6,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (7,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (8,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (9,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (10,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (11,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (12,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (13,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (14,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (15,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (16,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (17,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (18,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (19,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (20,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (21,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (22,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (23,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (24,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (25,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (26,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (27,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (28,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (29,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (30,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (31,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (32,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (33,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (34,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (35,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (36,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (37,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (38,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (39,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (40,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (41,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (42,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (43,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (44,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (45,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (46,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (47,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (48,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (49,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (50,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (51,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (52,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (53,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (54,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (55,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (56,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (57,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (58,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (59,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (60,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (61,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (62,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (63,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (64,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (65,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (66,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (67,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (68,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (69,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (70,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (71,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (72,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (73,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (74,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (75,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (76,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (77,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (78,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (79,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (80,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (81,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (82,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (83,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (84,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (85,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (86,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (87,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (88,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (89,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (90,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (91,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (92,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (93,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (94,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (95,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (96,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (97,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (98,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (99,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (100,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (101,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (102,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (103,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (104,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (105,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (106,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (107,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (108,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (109,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (110,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (111,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (112,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (113,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (114,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (115,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (116,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (117,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (118,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (119,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (120,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (121,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (122,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (123,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (124,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (125,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (126,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (127,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (128,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (129,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (130,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (131,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (132,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (133,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (134,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (135,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (136,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (137,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (138,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (139,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (140,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (141,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (142,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (143,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (144,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (145,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (146,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (147,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (148,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (149,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (150,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (151,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (152,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (153,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (154,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (155,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (156,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (157,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (158,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (159,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (160,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (161,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (162,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (163,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (164,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (165,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (166,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (167,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (168,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (169,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (170,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (171,1);
INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (172,1);


-- -----------------------------
-- Structure : `roles`
-- -----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Données : `roles` (1 ligne(s))
INSERT INTO `roles` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (1,'super_admin','admin','2026-03-27 20:28:45','2026-03-27 20:28:45');


-- -----------------------------
-- Structure : `rubriques`
-- -----------------------------
DROP TABLE IF EXISTS `rubriques`;
CREATE TABLE `rubriques` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identifiant de la rubrique.',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Titre affiché sur le site (nom de la rubrique).',
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Fragment d’URL stable et unique pour le SEO et les liens.',
  `description` text COLLATE utf8mb4_unicode_ci COMMENT 'Texte de présentation de la rubrique sur les pages liste.',
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Clé ou chemin d’icône (UI) associée à la rubrique.',
  `thumbnail_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Image de couverture / vignette pour cartes et listes.',
  `sort_order` int unsigned NOT NULL DEFAULT '0' COMMENT 'Ordre d’affichage dans les menus (plus petit = plus haut).',
  `is_active` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Si false, la rubrique est masquée du public.',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rubriques_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Rubriques phares du ministère (ex. Proverbes, Prédications) ; regroupe les contenus multimédias.';

-- Données : `rubriques` (6 ligne(s))
INSERT INTO `rubriques` (`id`,`name`,`slug`,`description`,`icon`,`thumbnail_path`,`sort_order`,`is_active`,`created_at`,`updated_at`) VALUES (1,'Proverbes','proverbes','Méditations et commentaires autour des Proverbes.',NULL,NULL,10,1,'2026-03-27 20:27:18','2026-03-27 20:27:18');
INSERT INTO `rubriques` (`id`,`name`,`slug`,`description`,`icon`,`thumbnail_path`,`sort_order`,`is_active`,`created_at`,`updated_at`) VALUES (2,'Minutes de ta destinée','minutes-de-ta-destinee','Capsules courtes pour avancer dans votre destinée.',NULL,NULL,20,1,'2026-03-27 20:27:18','2026-03-27 20:27:18');
INSERT INTO `rubriques` (`id`,`name`,`slug`,`description`,`icon`,`thumbnail_path`,`sort_order`,`is_active`,`created_at`,`updated_at`) VALUES (3,'S’accomplir','s-accomplir','Série dédiée à l’accomplissement selon Dieu.',NULL,NULL,30,1,'2026-03-27 20:27:18','2026-03-27 20:27:18');
INSERT INTO `rubriques` (`id`,`name`,`slug`,`description`,`icon`,`thumbnail_path`,`sort_order`,`is_active`,`created_at`,`updated_at`) VALUES (4,'Prédications','predications','Messages et cultes en vidéo.',NULL,NULL,40,1,'2026-03-27 20:27:18','2026-03-27 20:27:18');
INSERT INTO `rubriques` (`id`,`name`,`slug`,`description`,`icon`,`thumbnail_path`,`sort_order`,`is_active`,`created_at`,`updated_at`) VALUES (5,'Femme disciple de Jésus','femme-disciple-de-jesus','Enseignements pour la femme disciple.',NULL,NULL,50,1,'2026-03-27 20:27:18','2026-03-27 20:27:18');
INSERT INTO `rubriques` (`id`,`name`,`slug`,`description`,`icon`,`thumbnail_path`,`sort_order`,`is_active`,`created_at`,`updated_at`) VALUES (6,'Mes déclarations','mes-declarations','Le programme Mes déclarations.',NULL,NULL,60,1,'2026-03-27 20:27:18','2026-03-27 20:27:18');


-- -----------------------------
-- Structure : `series`
-- -----------------------------
DROP TABLE IF EXISTS `series`;
CREATE TABLE `series` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identifiant de la série.',
  `rubrique_id` bigint unsigned NOT NULL,
  `theme_id` bigint unsigned DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Titre de la série (ex. nom de la campagne).',
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Slug unique pour URL de la série.',
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Clé ou chemin d’icône (UI).',
  `thumbnail_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Vignette de la série.',
  `description` text COLLATE utf8mb4_unicode_ci COMMENT 'Résumé ou objectifs pédagogiques de la série.',
  `sort_order` int unsigned NOT NULL DEFAULT '0' COMMENT 'Ordre d’affichage parmi les séries d’une rubrique.',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `series_slug_unique` (`slug`),
  KEY `series_rubrique_id_foreign` (`rubrique_id`),
  KEY `series_theme_id_foreign` (`theme_id`),
  CONSTRAINT `series_rubrique_id_foreign` FOREIGN KEY (`rubrique_id`) REFERENCES `rubriques` (`id`) ON DELETE CASCADE,
  CONSTRAINT `series_theme_id_foreign` FOREIGN KEY (`theme_id`) REFERENCES `themes` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Séries d’enseignements au sein d’une rubrique ; optionnellement rattachées à un thème.';

-- Données : `series` (11 ligne(s))
INSERT INTO `series` (`id`,`rubrique_id`,`theme_id`,`title`,`slug`,`icon`,`thumbnail_path`,`description`,`sort_order`,`created_at`,`updated_at`) VALUES (1,1,NULL,'Proverbes','playlist-proverbes',NULL,NULL,'Playlist YouTube « Proverbes » (chaîne @tothy_mbengela).',0,'2026-03-27 20:27:18','2026-03-27 20:27:18');
INSERT INTO `series` (`id`,`rubrique_id`,`theme_id`,`title`,`slug`,`icon`,`thumbnail_path`,`description`,`sort_order`,`created_at`,`updated_at`) VALUES (2,2,NULL,'les minutes de ta destinée','playlist-minutes-de-ta-destinee',NULL,NULL,'Playlist YouTube « les minutes de ta destinée » (chaîne @tothy_mbengela).',1,'2026-03-27 20:27:18','2026-03-27 20:27:18');
INSERT INTO `series` (`id`,`rubrique_id`,`theme_id`,`title`,`slug`,`icon`,`thumbnail_path`,`description`,`sort_order`,`created_at`,`updated_at`) VALUES (3,3,NULL,'S’ACCOMPLIR','playlist-s-accomplir',NULL,NULL,'Playlist YouTube « S’ACCOMPLIR » (chaîne @tothy_mbengela).',2,'2026-03-27 20:27:18','2026-03-27 20:27:18');
INSERT INTO `series` (`id`,`rubrique_id`,`theme_id`,`title`,`slug`,`icon`,`thumbnail_path`,`description`,`sort_order`,`created_at`,`updated_at`) VALUES (4,2,NULL,'SHORTS','playlist-shorts',NULL,NULL,'Playlist YouTube « SHORTS » (chaîne @tothy_mbengela).',3,'2026-03-27 20:27:18','2026-03-27 20:27:18');
INSERT INTO `series` (`id`,`rubrique_id`,`theme_id`,`title`,`slug`,`icon`,`thumbnail_path`,`description`,`sort_order`,`created_at`,`updated_at`) VALUES (5,4,NULL,'PREDICATIONS','playlist-predications',NULL,NULL,'Playlist YouTube « PREDICATIONS » (chaîne @tothy_mbengela).',4,'2026-03-27 20:27:18','2026-03-27 20:27:18');
INSERT INTO `series` (`id`,`rubrique_id`,`theme_id`,`title`,`slug`,`icon`,`thumbnail_path`,`description`,`sort_order`,`created_at`,`updated_at`) VALUES (6,4,NULL,'NE POUR VAINCRE','playlist-ne-pour-vaincre',NULL,NULL,'Playlist YouTube « NE POUR VAINCRE » (chaîne @tothy_mbengela).',5,'2026-03-27 20:27:18','2026-03-27 20:27:18');
INSERT INTO `series` (`id`,`rubrique_id`,`theme_id`,`title`,`slug`,`icon`,`thumbnail_path`,`description`,`sort_order`,`created_at`,`updated_at`) VALUES (7,1,NULL,'LES COMMENT','playlist-les-comment',NULL,NULL,'Playlist YouTube « LES COMMENT » (chaîne @tothy_mbengela).',6,'2026-03-27 20:27:18','2026-03-27 20:27:18');
INSERT INTO `series` (`id`,`rubrique_id`,`theme_id`,`title`,`slug`,`icon`,`thumbnail_path`,`description`,`sort_order`,`created_at`,`updated_at`) VALUES (8,4,NULL,'PAROLE DE LA SEMAINE','playlist-parole-de-la-semaine',NULL,NULL,'Playlist YouTube « PAROLE DE LA SEMAINE » (chaîne @tothy_mbengela).',7,'2026-03-27 20:27:18','2026-03-27 20:27:18');
INSERT INTO `series` (`id`,`rubrique_id`,`theme_id`,`title`,`slug`,`icon`,`thumbnail_path`,`description`,`sort_order`,`created_at`,`updated_at`) VALUES (9,5,NULL,'FEMME DISCIPLE DE JESUS','playlist-femme-disciple-de-jesus',NULL,NULL,'Playlist YouTube « FEMME DISCIPLE DE JESUS » (chaîne @tothy_mbengela).',8,'2026-03-27 20:27:18','2026-03-27 20:27:18');
INSERT INTO `series` (`id`,`rubrique_id`,`theme_id`,`title`,`slug`,`icon`,`thumbnail_path`,`description`,`sort_order`,`created_at`,`updated_at`) VALUES (10,6,NULL,'MES DECLARATIONS','playlist-mes-declarations',NULL,NULL,'Playlist YouTube « MES DECLARATIONS » (chaîne @tothy_mbengela).',9,'2026-03-27 20:27:18','2026-03-27 20:27:18');
INSERT INTO `series` (`id`,`rubrique_id`,`theme_id`,`title`,`slug`,`icon`,`thumbnail_path`,`description`,`sort_order`,`created_at`,`updated_at`) VALUES (11,3,NULL,'ET SI TU PRIAIS / Court-Métrage','playlist-et-si-tu-priais-court-metrage',NULL,NULL,'Playlist YouTube « ET SI TU PRIAIS / Court-Métrage » (chaîne @tothy_mbengela).',10,'2026-03-27 20:27:18','2026-03-27 20:27:18');


-- -----------------------------
-- Structure : `sessions`
-- -----------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Identifiant de session côté cookie.',
  `user_id` bigint unsigned DEFAULT NULL COMMENT 'Utilisateur authentifié associé à la session, si connecté.',
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Adresse IP du client lors de la dernière activité.',
  `user_agent` text COLLATE utf8mb4_unicode_ci COMMENT 'En-tête User-Agent du navigateur ou appareil.',
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Données sérialisées de la session.',
  `last_activity` int NOT NULL COMMENT 'Timestamp Unix de la dernière activité (expiration / nettoyage).',
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Sessions HTTP stockées en base (driver database) pour utilisateurs et invités.';


-- -----------------------------
-- Structure : `shipping_settings`
-- -----------------------------
DROP TABLE IF EXISTS `shipping_settings`;
CREATE TABLE `shipping_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `is_active` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Proposer la livraison sur le site.',
  `domestic_country_code` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'CD' COMMENT 'Code ISO pays « national » (ex. RDC = CD) : tarif domestique.',
  `price_domestic` decimal(12,2) NOT NULL DEFAULT '0.00' COMMENT 'Frais pour le pays défini ci-dessus (ex. RDC / Lubumbashi).',
  `price_international` decimal(12,2) NOT NULL DEFAULT '0.00' COMMENT 'Frais pour tout autre pays.',
  `currency` char(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'USD',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Données : `shipping_settings` (1 ligne(s))
INSERT INTO `shipping_settings` (`id`,`is_active`,`domestic_country_code`,`price_domestic`,`price_international`,`currency`,`created_at`,`updated_at`) VALUES (1,0,'CD','5.00','25.00','USD','2026-03-27 20:26:22','2026-03-27 20:26:22');


-- -----------------------------
-- Structure : `testimonials`
-- -----------------------------
DROP TABLE IF EXISTS `testimonials`;
CREATE TABLE `testimonials` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` tinyint unsigned NOT NULL DEFAULT '5',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- -----------------------------
-- Structure : `themes`
-- -----------------------------
DROP TABLE IF EXISTS `themes`;
CREATE TABLE `themes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identifiant du thème.',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Libellé du thème affiché aux visiteurs.',
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Slug URL unique pour filtrage ou pages thème.',
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Clé ou chemin d’icône (UI).',
  `thumbnail_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Vignette pour le thème.',
  `description` text COLLATE utf8mb4_unicode_ci COMMENT 'Description optionnelle du regroupement thématique.',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `themes_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Thèmes transverses pour classer séries et contenus (ex. foi, famille).';

-- Données : `themes` (2 ligne(s))
INSERT INTO `themes` (`id`,`name`,`slug`,`icon`,`thumbnail_path`,`description`,`created_at`,`updated_at`) VALUES (1,'Parole & prière','parole-et-priere',NULL,NULL,'Enseignements et temps de prière.','2026-03-27 20:27:18','2026-03-27 20:27:18');
INSERT INTO `themes` (`id`,`name`,`slug`,`icon`,`thumbnail_path`,`description`,`created_at`,`updated_at`) VALUES (2,'Identité & destinée','identite-et-destinee',NULL,NULL,'Vocation, accomplissement et promesses.','2026-03-27 20:27:18','2026-03-27 20:27:18');


-- -----------------------------
-- Structure : `users`
-- -----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique du compte utilisateur.',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nom complet utilisé sur le profil, les commandes et les messages.',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Adresse e-mail de connexion (Breeze) et de contact.',
  `email_verified_at` timestamp NULL DEFAULT NULL COMMENT 'Horodatage de validation de l’e-mail si la vérification est activée.',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Hachage du mot de passe (bcrypt/argon) ; jamais stocké en clair.',
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Téléphone principal pour contact ou SMS (selon intégrations futures).',
  `whatsapp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Numéro WhatsApp dédié (souvent format international sans espaces).',
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Pays de résidence (libellé ou code pays selon le front).',
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Ville de résidence.',
  `address_line` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Ligne d’adresse postale (rue, numéro, complément).',
  `bio` text COLLATE utf8mb4_unicode_ci COMMENT 'Biographie courte ou témoignage affichable sur le profil public.',
  `avatar_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Chemin relatif ou disque du fichier image d’avatar (hors web public direct si stockage privé).',
  `preferred_locale` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'fr' COMMENT 'Code langue préféré pour l’interface (ex. fr, en).',
  `birthdate` date DEFAULT NULL COMMENT 'Date de naissance ; champ sensible, usage optionnel (pastoral, stats anonymisées).',
  `gender` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Genre ou civilité déclarée ; valeur contrôlée côté application si besoin.',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Jeton opaque pour l’option « se souvenir de cet appareil ».',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Comptes publics : fidèles, acheteurs en librairie ; un partenaire doit posséder un compte ici avant tout engagement.';

-- Données : `users` (1 ligne(s))
INSERT INTO `users` (`id`,`name`,`email`,`email_verified_at`,`password`,`phone`,`whatsapp`,`country`,`city`,`address_line`,`bio`,`avatar_path`,`preferred_locale`,`birthdate`,`gender`,`remember_token`,`created_at`,`updated_at`) VALUES (1,'Test User','test@example.com','2026-03-27 20:27:37','$2y$12$sbe9D5IhGUxdx9YDfAmXJ.QNGqSz0hXxlvBYRyHtnyz18SSL3HiYe','+33805132878',NULL,'Chili','Clement',NULL,NULL,NULL,'fr',NULL,NULL,'dzwUQhVBAZ','2026-03-27 20:27:37','2026-03-27 20:27:37');

SET FOREIGN_KEY_CHECKS=1;
