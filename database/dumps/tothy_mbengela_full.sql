-- -----------------------------------------------------------------
-- Export MySQL — TothyMbengela
-- Généré le 2026-03-27T16:35:36+00:00
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
INSERT INTO `admins` (`id`,`name`,`email`,`email_verified_at`,`password`,`remember_token`,`created_at`,`updated_at`) VALUES (1,'Admin','admin@example.com','2026-03-27 16:34:17','$2y$12$H8MZN/W.2WJSXJwgcACgNOPn96h6vvAKOBtjIqA1PI3UmSst3YTLm','4HSXHa8ZkV','2026-03-27 16:34:17','2026-03-27 16:34:17');


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Librairie en ligne : ouvrages numériques ou physiques vendus sur le site.';


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
INSERT INTO `contents` (`id`,`rubrique_id`,`series_id`,`theme_id`,`type`,`source`,`title`,`slug`,`excerpt`,`body`,`media_url`,`youtube_video_id`,`youtube_url`,`file_path`,`thumbnail_path`,`duration_seconds`,`allow_streaming`,`allow_download`,`is_published`,`published_at`,`is_featured`,`position`,`meta`,`created_at`,`updated_at`,`deleted_at`) VALUES (1,1,1,NULL,'video','youtube','Première vidéo — Proverbes','youtube-9MwDprKBkRg',NULL,NULL,NULL,'9MwDprKBkRg','https://www.youtube.com/watch?v=9MwDprKBkRg',NULL,NULL,NULL,1,0,1,'2026-03-26 16:34:17',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2s1I1uJ5EHDGBfZvQaOJ3K8\"}','2026-03-27 16:34:17','2026-03-27 16:34:17',NULL);
INSERT INTO `contents` (`id`,`rubrique_id`,`series_id`,`theme_id`,`type`,`source`,`title`,`slug`,`excerpt`,`body`,`media_url`,`youtube_video_id`,`youtube_url`,`file_path`,`thumbnail_path`,`duration_seconds`,`allow_streaming`,`allow_download`,`is_published`,`published_at`,`is_featured`,`position`,`meta`,`created_at`,`updated_at`,`deleted_at`) VALUES (2,2,2,NULL,'video','youtube','Première vidéo — les minutes de ta destinée','youtube-GXQDovOqoBA',NULL,NULL,NULL,'GXQDovOqoBA','https://www.youtube.com/watch?v=GXQDovOqoBA',NULL,NULL,NULL,1,0,1,'2026-03-25 16:34:17',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2uCPMwKNnlFI-1v1es7AhjA\"}','2026-03-27 16:34:17','2026-03-27 16:34:17',NULL);
INSERT INTO `contents` (`id`,`rubrique_id`,`series_id`,`theme_id`,`type`,`source`,`title`,`slug`,`excerpt`,`body`,`media_url`,`youtube_video_id`,`youtube_url`,`file_path`,`thumbnail_path`,`duration_seconds`,`allow_streaming`,`allow_download`,`is_published`,`published_at`,`is_featured`,`position`,`meta`,`created_at`,`updated_at`,`deleted_at`) VALUES (3,3,3,NULL,'video','youtube','Première vidéo — S’ACCOMPLIR','youtube-3FIhRR3qRog',NULL,NULL,NULL,'3FIhRR3qRog','https://www.youtube.com/watch?v=3FIhRR3qRog',NULL,NULL,NULL,1,0,1,'2026-03-24 16:34:17',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2vCBsN91hMIfQz5PHaiRlgX\"}','2026-03-27 16:34:17','2026-03-27 16:34:17',NULL);
INSERT INTO `contents` (`id`,`rubrique_id`,`series_id`,`theme_id`,`type`,`source`,`title`,`slug`,`excerpt`,`body`,`media_url`,`youtube_video_id`,`youtube_url`,`file_path`,`thumbnail_path`,`duration_seconds`,`allow_streaming`,`allow_download`,`is_published`,`published_at`,`is_featured`,`position`,`meta`,`created_at`,`updated_at`,`deleted_at`) VALUES (4,2,4,NULL,'video','youtube','Première vidéo — SHORTS','youtube-J_CliWzm8ss',NULL,NULL,NULL,'J_CliWzm8ss','https://www.youtube.com/watch?v=J_CliWzm8ss',NULL,NULL,NULL,1,0,1,'2026-03-23 16:34:17',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2vFc808uhHmMBfyPaXXqKyI\"}','2026-03-27 16:34:17','2026-03-27 16:34:17',NULL);
INSERT INTO `contents` (`id`,`rubrique_id`,`series_id`,`theme_id`,`type`,`source`,`title`,`slug`,`excerpt`,`body`,`media_url`,`youtube_video_id`,`youtube_url`,`file_path`,`thumbnail_path`,`duration_seconds`,`allow_streaming`,`allow_download`,`is_published`,`published_at`,`is_featured`,`position`,`meta`,`created_at`,`updated_at`,`deleted_at`) VALUES (5,4,5,NULL,'video','youtube','Première vidéo — PREDICATIONS','youtube-cFQT1lpg5Xw',NULL,NULL,NULL,'cFQT1lpg5Xw','https://www.youtube.com/watch?v=cFQT1lpg5Xw',NULL,NULL,NULL,1,0,1,'2026-03-22 16:34:17',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2tZGNj2cS8PElJCyc3-UoAX\"}','2026-03-27 16:34:17','2026-03-27 16:34:17',NULL);
INSERT INTO `contents` (`id`,`rubrique_id`,`series_id`,`theme_id`,`type`,`source`,`title`,`slug`,`excerpt`,`body`,`media_url`,`youtube_video_id`,`youtube_url`,`file_path`,`thumbnail_path`,`duration_seconds`,`allow_streaming`,`allow_download`,`is_published`,`published_at`,`is_featured`,`position`,`meta`,`created_at`,`updated_at`,`deleted_at`) VALUES (6,4,6,NULL,'video','youtube','Première vidéo — NE POUR VAINCRE','youtube-oSUTbflBQsg',NULL,NULL,NULL,'oSUTbflBQsg','https://www.youtube.com/watch?v=oSUTbflBQsg',NULL,NULL,NULL,1,0,1,'2026-03-21 16:34:17',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2uzP1ZWOokLxP-coaOx2kgb\"}','2026-03-27 16:34:17','2026-03-27 16:34:17',NULL);
INSERT INTO `contents` (`id`,`rubrique_id`,`series_id`,`theme_id`,`type`,`source`,`title`,`slug`,`excerpt`,`body`,`media_url`,`youtube_video_id`,`youtube_url`,`file_path`,`thumbnail_path`,`duration_seconds`,`allow_streaming`,`allow_download`,`is_published`,`published_at`,`is_featured`,`position`,`meta`,`created_at`,`updated_at`,`deleted_at`) VALUES (7,1,7,NULL,'video','youtube','Première vidéo — LES COMMENT','youtube-vYerKexKZyk',NULL,NULL,NULL,'vYerKexKZyk','https://www.youtube.com/watch?v=vYerKexKZyk',NULL,NULL,NULL,1,0,1,'2026-03-20 16:34:17',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2uiRaa-pyd5HXhx7qQ_iTXg\"}','2026-03-27 16:34:17','2026-03-27 16:34:17',NULL);
INSERT INTO `contents` (`id`,`rubrique_id`,`series_id`,`theme_id`,`type`,`source`,`title`,`slug`,`excerpt`,`body`,`media_url`,`youtube_video_id`,`youtube_url`,`file_path`,`thumbnail_path`,`duration_seconds`,`allow_streaming`,`allow_download`,`is_published`,`published_at`,`is_featured`,`position`,`meta`,`created_at`,`updated_at`,`deleted_at`) VALUES (8,4,8,NULL,'video','youtube','VEUILLE SEULEMENT L’ÉTERNEL, TON DIEU, ÊTRE AVEC TOI | Pasteure Tothy Mbengela','youtube-Asc3iaC4IK4',NULL,NULL,NULL,'Asc3iaC4IK4','https://www.youtube.com/watch?v=Asc3iaC4IK4',NULL,NULL,NULL,1,0,1,'2026-03-17 08:14:06',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2sD9r4q7PdGyZo5puKtFvx9\"}','2026-03-27 16:34:17','2026-03-27 16:34:17',NULL);
INSERT INTO `contents` (`id`,`rubrique_id`,`series_id`,`theme_id`,`type`,`source`,`title`,`slug`,`excerpt`,`body`,`media_url`,`youtube_video_id`,`youtube_url`,`file_path`,`thumbnail_path`,`duration_seconds`,`allow_streaming`,`allow_download`,`is_published`,`published_at`,`is_featured`,`position`,`meta`,`created_at`,`updated_at`,`deleted_at`) VALUES (9,5,9,NULL,'video','youtube','Première vidéo — FEMME DISCIPLE DE JESUS','youtube-7flJZzwDy_Q',NULL,NULL,NULL,'7flJZzwDy_Q','https://www.youtube.com/watch?v=7flJZzwDy_Q',NULL,NULL,NULL,1,0,1,'2026-03-18 16:34:17',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2v_8yPCFZhkQ9bXcT-oRjJr\"}','2026-03-27 16:34:17','2026-03-27 16:34:17',NULL);
INSERT INTO `contents` (`id`,`rubrique_id`,`series_id`,`theme_id`,`type`,`source`,`title`,`slug`,`excerpt`,`body`,`media_url`,`youtube_video_id`,`youtube_url`,`file_path`,`thumbnail_path`,`duration_seconds`,`allow_streaming`,`allow_download`,`is_published`,`published_at`,`is_featured`,`position`,`meta`,`created_at`,`updated_at`,`deleted_at`) VALUES (10,6,10,NULL,'video','youtube','MES DECLARATIONS | Mars 2026 | Pasteure Tothy MBENGELA','youtube-6K1sZTwY9Vs',NULL,NULL,NULL,'6K1sZTwY9Vs','https://www.youtube.com/watch?v=6K1sZTwY9Vs',NULL,NULL,NULL,1,0,1,'2026-03-01 10:35:49',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2vf9n2r_mdvtPB6UhVf2aAC\"}','2026-03-27 16:34:17','2026-03-27 16:34:17',NULL);
INSERT INTO `contents` (`id`,`rubrique_id`,`series_id`,`theme_id`,`type`,`source`,`title`,`slug`,`excerpt`,`body`,`media_url`,`youtube_video_id`,`youtube_url`,`file_path`,`thumbnail_path`,`duration_seconds`,`allow_streaming`,`allow_download`,`is_published`,`published_at`,`is_featured`,`position`,`meta`,`created_at`,`updated_at`,`deleted_at`) VALUES (11,3,11,NULL,'video','youtube','Première vidéo — ET SI TU PRIAIS / Court-Métrage','youtube-fPNDYt4WZog',NULL,NULL,NULL,'fPNDYt4WZog','https://www.youtube.com/watch?v=fPNDYt4WZog',NULL,NULL,NULL,1,0,1,'2026-03-16 16:34:17',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2uby5SrqpArUStxfl8cj1n4\"}','2026-03-27 16:34:17','2026-03-27 16:34:17',NULL);
INSERT INTO `contents` (`id`,`rubrique_id`,`series_id`,`theme_id`,`type`,`source`,`title`,`slug`,`excerpt`,`body`,`media_url`,`youtube_video_id`,`youtube_url`,`file_path`,`thumbnail_path`,`duration_seconds`,`allow_streaming`,`allow_download`,`is_published`,`published_at`,`is_featured`,`position`,`meta`,`created_at`,`updated_at`,`deleted_at`) VALUES (12,2,4,NULL,'video','youtube','MES 4 LIVRES SONT DESORMAIS DISPONIBLES #livresinspirants','youtube-C7qfNyJKRn0','Les livres sont désormais disponibles et à votre portée.',NULL,NULL,'C7qfNyJKRn0','https://www.youtube.com/watch?v=C7qfNyJKRn0',NULL,NULL,NULL,1,0,1,'2026-03-18 12:43:29',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2vFc808uhHmMBfyPaXXqKyI\"}','2026-03-27 16:34:17','2026-03-27 16:34:17',NULL);
INSERT INTO `contents` (`id`,`rubrique_id`,`series_id`,`theme_id`,`type`,`source`,`title`,`slug`,`excerpt`,`body`,`media_url`,`youtube_video_id`,`youtube_url`,`file_path`,`thumbnail_path`,`duration_seconds`,`allow_streaming`,`allow_download`,`is_published`,`published_at`,`is_featured`,`position`,`meta`,`created_at`,`updated_at`,`deleted_at`) VALUES (13,3,3,NULL,'video','youtube','MON HISTOIRE VERS L’ÉCRITURE | VERNISSAGE DE QUATRE LIVRES','youtube-0BH75IkAuq4',NULL,NULL,NULL,'0BH75IkAuq4','https://www.youtube.com/watch?v=0BH75IkAuq4',NULL,NULL,NULL,1,0,1,'2026-02-28 21:44:20',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2vCBsN91hMIfQz5PHaiRlgX\"}','2026-03-27 16:34:17','2026-03-27 16:34:17',NULL);
INSERT INTO `contents` (`id`,`rubrique_id`,`series_id`,`theme_id`,`type`,`source`,`title`,`slug`,`excerpt`,`body`,`media_url`,`youtube_video_id`,`youtube_url`,`file_path`,`thumbnail_path`,`duration_seconds`,`allow_streaming`,`allow_download`,`is_published`,`published_at`,`is_featured`,`position`,`meta`,`created_at`,`updated_at`,`deleted_at`) VALUES (14,4,8,NULL,'video','youtube','IL PEUT FAIRE INFINIMENT AU DELÀ | Pasteure Tothy Mbengela','youtube-460ftY_DReE',NULL,NULL,NULL,'460ftY_DReE','https://www.youtube.com/watch?v=460ftY_DReE',NULL,NULL,NULL,1,0,1,'2026-02-16 13:03:26',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2sD9r4q7PdGyZo5puKtFvx9\"}','2026-03-27 16:34:17','2026-03-27 16:34:17',NULL);
INSERT INTO `contents` (`id`,`rubrique_id`,`series_id`,`theme_id`,`type`,`source`,`title`,`slug`,`excerpt`,`body`,`media_url`,`youtube_video_id`,`youtube_url`,`file_path`,`thumbnail_path`,`duration_seconds`,`allow_streaming`,`allow_download`,`is_published`,`published_at`,`is_featured`,`position`,`meta`,`created_at`,`updated_at`,`deleted_at`) VALUES (15,4,8,NULL,'video','youtube','QUE L’ÉTERNEL VOUS BÉNISSE COMME IL VOUS L’A PROMIS | Pasteure Tothy Mbengela','youtube-ipfxjB-9KZ0',NULL,NULL,NULL,'ipfxjB-9KZ0','https://www.youtube.com/watch?v=ipfxjB-9KZ0',NULL,NULL,NULL,1,0,1,'2026-02-03 05:09:39',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2sD9r4q7PdGyZo5puKtFvx9\"}','2026-03-27 16:34:17','2026-03-27 16:34:17',NULL);
INSERT INTO `contents` (`id`,`rubrique_id`,`series_id`,`theme_id`,`type`,`source`,`title`,`slug`,`excerpt`,`body`,`media_url`,`youtube_video_id`,`youtube_url`,`file_path`,`thumbnail_path`,`duration_seconds`,`allow_streaming`,`allow_download`,`is_published`,`published_at`,`is_featured`,`position`,`meta`,`created_at`,`updated_at`,`deleted_at`) VALUES (16,6,10,NULL,'video','youtube','MES DECLARATIONS | Février 2026 | Maman Lévi NGALULA','youtube-3HXUCDTAItE',NULL,NULL,NULL,'3HXUCDTAItE','https://www.youtube.com/watch?v=3HXUCDTAItE',NULL,NULL,NULL,1,0,1,'2026-02-01 10:27:51',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2vf9n2r_mdvtPB6UhVf2aAC\"}','2026-03-27 16:34:17','2026-03-27 16:34:17',NULL);
INSERT INTO `contents` (`id`,`rubrique_id`,`series_id`,`theme_id`,`type`,`source`,`title`,`slug`,`excerpt`,`body`,`media_url`,`youtube_video_id`,`youtube_url`,`file_path`,`thumbnail_path`,`duration_seconds`,`allow_streaming`,`allow_download`,`is_published`,`published_at`,`is_featured`,`position`,`meta`,`created_at`,`updated_at`,`deleted_at`) VALUES (17,6,10,NULL,'video','youtube','MES DECLARATIONS | Février 2026 | Maman Lévi NGALULA','youtube-fc1CQ6g2GTU',NULL,NULL,NULL,'fc1CQ6g2GTU','https://www.youtube.com/watch?v=fc1CQ6g2GTU',NULL,NULL,NULL,1,0,1,'2026-01-31 21:27:15',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2vf9n2r_mdvtPB6UhVf2aAC\"}','2026-03-27 16:34:17','2026-03-27 16:34:17',NULL);
INSERT INTO `contents` (`id`,`rubrique_id`,`series_id`,`theme_id`,`type`,`source`,`title`,`slug`,`excerpt`,`body`,`media_url`,`youtube_video_id`,`youtube_url`,`file_path`,`thumbnail_path`,`duration_seconds`,`allow_streaming`,`allow_download`,`is_published`,`published_at`,`is_featured`,`position`,`meta`,`created_at`,`updated_at`,`deleted_at`) VALUES (18,4,5,NULL,'video','youtube','FAITES DONC MOURIR VOTRE CHAIR | Pasteure Tothy Mbengela','youtube-d0cnu_4z2Jc',NULL,NULL,NULL,'d0cnu_4z2Jc','https://www.youtube.com/watch?v=d0cnu_4z2Jc',NULL,NULL,NULL,1,0,1,'2026-01-28 16:01:15',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2tZGNj2cS8PElJCyc3-UoAX\"}','2026-03-27 16:34:17','2026-03-27 16:34:17',NULL);
INSERT INTO `contents` (`id`,`rubrique_id`,`series_id`,`theme_id`,`type`,`source`,`title`,`slug`,`excerpt`,`body`,`media_url`,`youtube_video_id`,`youtube_url`,`file_path`,`thumbnail_path`,`duration_seconds`,`allow_streaming`,`allow_download`,`is_published`,`published_at`,`is_featured`,`position`,`meta`,`created_at`,`updated_at`,`deleted_at`) VALUES (19,4,5,NULL,'video','youtube','SOUVIENS-TOI QUE TU ES EN VOYAGE | Pasteure Tothy Mbengela','youtube-7OkAo286H40',NULL,NULL,NULL,'7OkAo286H40','https://www.youtube.com/watch?v=7OkAo286H40',NULL,NULL,NULL,1,0,1,'2026-01-19 14:26:50',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2tZGNj2cS8PElJCyc3-UoAX\"}','2026-03-27 16:34:17','2026-03-27 16:34:17',NULL);
INSERT INTO `contents` (`id`,`rubrique_id`,`series_id`,`theme_id`,`type`,`source`,`title`,`slug`,`excerpt`,`body`,`media_url`,`youtube_video_id`,`youtube_url`,`file_path`,`thumbnail_path`,`duration_seconds`,`allow_streaming`,`allow_download`,`is_published`,`published_at`,`is_featured`,`position`,`meta`,`created_at`,`updated_at`,`deleted_at`) VALUES (20,4,6,NULL,'video','youtube','VAINCRE LA COLÈRE PAR LA PRIÈRE - Pasteure Tothy Mbengela','youtube-qbQ2DOc_r4c',NULL,NULL,NULL,'qbQ2DOc_r4c','https://www.youtube.com/watch?v=qbQ2DOc_r4c',NULL,NULL,NULL,1,0,1,'2026-01-12 08:32:20',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2uzP1ZWOokLxP-coaOx2kgb\"}','2026-03-27 16:34:17','2026-03-27 16:34:17',NULL);
INSERT INTO `contents` (`id`,`rubrique_id`,`series_id`,`theme_id`,`type`,`source`,`title`,`slug`,`excerpt`,`body`,`media_url`,`youtube_video_id`,`youtube_url`,`file_path`,`thumbnail_path`,`duration_seconds`,`allow_streaming`,`allow_download`,`is_published`,`published_at`,`is_featured`,`position`,`meta`,`created_at`,`updated_at`,`deleted_at`) VALUES (21,6,10,NULL,'video','youtube','MES DECLARATIONS | DÉCEMBRE 2025 | Pasteure Tothy MBENGELA','youtube-q4RsEMhO1WM',NULL,NULL,NULL,'q4RsEMhO1WM','https://www.youtube.com/watch?v=q4RsEMhO1WM',NULL,NULL,NULL,1,0,1,'2025-12-01 10:51:03',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2vf9n2r_mdvtPB6UhVf2aAC\"}','2026-03-27 16:34:17','2026-03-27 16:34:17',NULL);
INSERT INTO `contents` (`id`,`rubrique_id`,`series_id`,`theme_id`,`type`,`source`,`title`,`slug`,`excerpt`,`body`,`media_url`,`youtube_video_id`,`youtube_url`,`file_path`,`thumbnail_path`,`duration_seconds`,`allow_streaming`,`allow_download`,`is_published`,`published_at`,`is_featured`,`position`,`meta`,`created_at`,`updated_at`,`deleted_at`) VALUES (22,6,10,NULL,'video','youtube','MES DÉCLARATIONS | NOVEMBRE 2025 | Pasteure Tothy MBENGELA','youtube-TzHPp3DgRuA',NULL,NULL,NULL,'TzHPp3DgRuA','https://www.youtube.com/watch?v=TzHPp3DgRuA',NULL,NULL,NULL,1,0,1,'2025-11-01 10:10:50',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2vf9n2r_mdvtPB6UhVf2aAC\"}','2026-03-27 16:34:17','2026-03-27 16:34:17',NULL);
INSERT INTO `contents` (`id`,`rubrique_id`,`series_id`,`theme_id`,`type`,`source`,`title`,`slug`,`excerpt`,`body`,`media_url`,`youtube_video_id`,`youtube_url`,`file_path`,`thumbnail_path`,`duration_seconds`,`allow_streaming`,`allow_download`,`is_published`,`published_at`,`is_featured`,`position`,`meta`,`created_at`,`updated_at`,`deleted_at`) VALUES (23,6,10,NULL,'video','youtube','MES DECLARATIONS | OCTOBRE | Pasteure Tothy MBENGELA','youtube-ywJ81B3IQjs',NULL,NULL,NULL,'ywJ81B3IQjs','https://www.youtube.com/watch?v=ywJ81B3IQjs',NULL,NULL,NULL,1,0,1,'2025-09-30 21:59:36',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2vf9n2r_mdvtPB6UhVf2aAC\"}','2026-03-27 16:34:17','2026-03-27 16:34:17',NULL);
INSERT INTO `contents` (`id`,`rubrique_id`,`series_id`,`theme_id`,`type`,`source`,`title`,`slug`,`excerpt`,`body`,`media_url`,`youtube_video_id`,`youtube_url`,`file_path`,`thumbnail_path`,`duration_seconds`,`allow_streaming`,`allow_download`,`is_published`,`published_at`,`is_featured`,`position`,`meta`,`created_at`,`updated_at`,`deleted_at`) VALUES (24,6,10,NULL,'video','youtube','MES DECLARATIONS | Mois de Septembre | Maman Lévi NGALULA','youtube-yfGCHRZIvDo',NULL,NULL,NULL,'yfGCHRZIvDo','https://www.youtube.com/watch?v=yfGCHRZIvDo',NULL,NULL,NULL,1,0,1,'2025-09-01 10:25:11',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2vf9n2r_mdvtPB6UhVf2aAC\"}','2026-03-27 16:34:17','2026-03-27 16:34:17',NULL);


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
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Données : `migrations` (26 ligne(s))
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


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
INSERT INTO `rubriques` (`id`,`name`,`slug`,`description`,`icon`,`thumbnail_path`,`sort_order`,`is_active`,`created_at`,`updated_at`) VALUES (1,'Proverbes','proverbes','Méditations et commentaires autour des Proverbes.',NULL,NULL,10,1,'2026-03-27 16:34:17','2026-03-27 16:34:17');
INSERT INTO `rubriques` (`id`,`name`,`slug`,`description`,`icon`,`thumbnail_path`,`sort_order`,`is_active`,`created_at`,`updated_at`) VALUES (2,'Minutes de ta destinée','minutes-de-ta-destinee','Capsules courtes pour avancer dans votre destinée.',NULL,NULL,20,1,'2026-03-27 16:34:17','2026-03-27 16:34:17');
INSERT INTO `rubriques` (`id`,`name`,`slug`,`description`,`icon`,`thumbnail_path`,`sort_order`,`is_active`,`created_at`,`updated_at`) VALUES (3,'S’accomplir','s-accomplir','Série dédiée à l’accomplissement selon Dieu.',NULL,NULL,30,1,'2026-03-27 16:34:17','2026-03-27 16:34:17');
INSERT INTO `rubriques` (`id`,`name`,`slug`,`description`,`icon`,`thumbnail_path`,`sort_order`,`is_active`,`created_at`,`updated_at`) VALUES (4,'Prédications','predications','Messages et cultes en vidéo.',NULL,NULL,40,1,'2026-03-27 16:34:17','2026-03-27 16:34:17');
INSERT INTO `rubriques` (`id`,`name`,`slug`,`description`,`icon`,`thumbnail_path`,`sort_order`,`is_active`,`created_at`,`updated_at`) VALUES (5,'Femme disciple de Jésus','femme-disciple-de-jesus','Enseignements pour la femme disciple.',NULL,NULL,50,1,'2026-03-27 16:34:17','2026-03-27 16:34:17');
INSERT INTO `rubriques` (`id`,`name`,`slug`,`description`,`icon`,`thumbnail_path`,`sort_order`,`is_active`,`created_at`,`updated_at`) VALUES (6,'Mes déclarations','mes-declarations','Le programme Mes déclarations.',NULL,NULL,60,1,'2026-03-27 16:34:17','2026-03-27 16:34:17');


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
INSERT INTO `series` (`id`,`rubrique_id`,`theme_id`,`title`,`slug`,`icon`,`thumbnail_path`,`description`,`sort_order`,`created_at`,`updated_at`) VALUES (1,1,NULL,'Proverbes','playlist-proverbes',NULL,NULL,'Playlist YouTube « Proverbes » (chaîne @tothy_mbengela).',0,'2026-03-27 16:34:17','2026-03-27 16:34:17');
INSERT INTO `series` (`id`,`rubrique_id`,`theme_id`,`title`,`slug`,`icon`,`thumbnail_path`,`description`,`sort_order`,`created_at`,`updated_at`) VALUES (2,2,NULL,'les minutes de ta destinée','playlist-minutes-de-ta-destinee',NULL,NULL,'Playlist YouTube « les minutes de ta destinée » (chaîne @tothy_mbengela).',1,'2026-03-27 16:34:17','2026-03-27 16:34:17');
INSERT INTO `series` (`id`,`rubrique_id`,`theme_id`,`title`,`slug`,`icon`,`thumbnail_path`,`description`,`sort_order`,`created_at`,`updated_at`) VALUES (3,3,NULL,'S’ACCOMPLIR','playlist-s-accomplir',NULL,NULL,'Playlist YouTube « S’ACCOMPLIR » (chaîne @tothy_mbengela).',2,'2026-03-27 16:34:17','2026-03-27 16:34:17');
INSERT INTO `series` (`id`,`rubrique_id`,`theme_id`,`title`,`slug`,`icon`,`thumbnail_path`,`description`,`sort_order`,`created_at`,`updated_at`) VALUES (4,2,NULL,'SHORTS','playlist-shorts',NULL,NULL,'Playlist YouTube « SHORTS » (chaîne @tothy_mbengela).',3,'2026-03-27 16:34:17','2026-03-27 16:34:17');
INSERT INTO `series` (`id`,`rubrique_id`,`theme_id`,`title`,`slug`,`icon`,`thumbnail_path`,`description`,`sort_order`,`created_at`,`updated_at`) VALUES (5,4,NULL,'PREDICATIONS','playlist-predications',NULL,NULL,'Playlist YouTube « PREDICATIONS » (chaîne @tothy_mbengela).',4,'2026-03-27 16:34:17','2026-03-27 16:34:17');
INSERT INTO `series` (`id`,`rubrique_id`,`theme_id`,`title`,`slug`,`icon`,`thumbnail_path`,`description`,`sort_order`,`created_at`,`updated_at`) VALUES (6,4,NULL,'NE POUR VAINCRE','playlist-ne-pour-vaincre',NULL,NULL,'Playlist YouTube « NE POUR VAINCRE » (chaîne @tothy_mbengela).',5,'2026-03-27 16:34:17','2026-03-27 16:34:17');
INSERT INTO `series` (`id`,`rubrique_id`,`theme_id`,`title`,`slug`,`icon`,`thumbnail_path`,`description`,`sort_order`,`created_at`,`updated_at`) VALUES (7,1,NULL,'LES COMMENT','playlist-les-comment',NULL,NULL,'Playlist YouTube « LES COMMENT » (chaîne @tothy_mbengela).',6,'2026-03-27 16:34:17','2026-03-27 16:34:17');
INSERT INTO `series` (`id`,`rubrique_id`,`theme_id`,`title`,`slug`,`icon`,`thumbnail_path`,`description`,`sort_order`,`created_at`,`updated_at`) VALUES (8,4,NULL,'PAROLE DE LA SEMAINE','playlist-parole-de-la-semaine',NULL,NULL,'Playlist YouTube « PAROLE DE LA SEMAINE » (chaîne @tothy_mbengela).',7,'2026-03-27 16:34:17','2026-03-27 16:34:17');
INSERT INTO `series` (`id`,`rubrique_id`,`theme_id`,`title`,`slug`,`icon`,`thumbnail_path`,`description`,`sort_order`,`created_at`,`updated_at`) VALUES (9,5,NULL,'FEMME DISCIPLE DE JESUS','playlist-femme-disciple-de-jesus',NULL,NULL,'Playlist YouTube « FEMME DISCIPLE DE JESUS » (chaîne @tothy_mbengela).',8,'2026-03-27 16:34:17','2026-03-27 16:34:17');
INSERT INTO `series` (`id`,`rubrique_id`,`theme_id`,`title`,`slug`,`icon`,`thumbnail_path`,`description`,`sort_order`,`created_at`,`updated_at`) VALUES (10,6,NULL,'MES DECLARATIONS','playlist-mes-declarations',NULL,NULL,'Playlist YouTube « MES DECLARATIONS » (chaîne @tothy_mbengela).',9,'2026-03-27 16:34:17','2026-03-27 16:34:17');
INSERT INTO `series` (`id`,`rubrique_id`,`theme_id`,`title`,`slug`,`icon`,`thumbnail_path`,`description`,`sort_order`,`created_at`,`updated_at`) VALUES (11,3,NULL,'ET SI TU PRIAIS / Court-Métrage','playlist-et-si-tu-priais-court-metrage',NULL,NULL,'Playlist YouTube « ET SI TU PRIAIS / Court-Métrage » (chaîne @tothy_mbengela).',10,'2026-03-27 16:34:17','2026-03-27 16:34:17');


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
INSERT INTO `shipping_settings` (`id`,`is_active`,`domestic_country_code`,`price_domestic`,`price_international`,`currency`,`created_at`,`updated_at`) VALUES (1,0,'CD','5.00','25.00','USD','2026-03-27 16:34:15','2026-03-27 16:34:15');


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
INSERT INTO `themes` (`id`,`name`,`slug`,`icon`,`thumbnail_path`,`description`,`created_at`,`updated_at`) VALUES (1,'Parole & prière','parole-et-priere',NULL,NULL,'Enseignements et temps de prière.','2026-03-27 16:34:17','2026-03-27 16:34:17');
INSERT INTO `themes` (`id`,`name`,`slug`,`icon`,`thumbnail_path`,`description`,`created_at`,`updated_at`) VALUES (2,'Identité & destinée','identite-et-destinee',NULL,NULL,'Vocation, accomplissement et promesses.','2026-03-27 16:34:17','2026-03-27 16:34:17');


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
INSERT INTO `users` (`id`,`name`,`email`,`email_verified_at`,`password`,`phone`,`whatsapp`,`country`,`city`,`address_line`,`bio`,`avatar_path`,`preferred_locale`,`birthdate`,`gender`,`remember_token`,`created_at`,`updated_at`) VALUES (1,'Test User','test@example.com','2026-03-27 16:34:17','$2y$12$LJwQtxO72arwvFXgYr.6EO2EnjlkfdyqpKhT53D3EDWG662QIALji','+33689117527',NULL,'Tuvalu',NULL,NULL,NULL,NULL,'fr',NULL,NULL,'rRMvrhZS5E','2026-03-27 16:34:17','2026-03-27 16:34:17');

SET FOREIGN_KEY_CHECKS=1;
