-- -----------------------------------------------------------------
-- Export MySQL — Alliance / Ministère Tothy Mbengela
-- Généré le 2026-03-31T16:57:07Z
-- Base : `tothyMbengelaDB`
--
-- Aligné sur le schéma Laravel (migrations) + données de démo :
--   php artisan migrate:fresh --seed --force
--
-- Comptes de démonstration (à changer en production) :
--   - Site : visiteur@alliance-ministere.com / password
--   - Admin Filament : admin@alliance-ministere.com / password
--
-- Réimport :
--   mysql -u USER -p < database/dumps/tothy_mbengela_full.sql
--
-- Catalogue vidéos / playlists (source MinistryYoutubeSeeder) :
--   database/data/tothy_mbengela_youtube.php
-- -----------------------------------------------------------------
-- MySQL dump 10.13  Distrib 8.4.3, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: tothyMbengelaDB
-- ------------------------------------------------------
-- Server version	8.4.3

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `tothyMbengelaDB`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `tothyMbengelaDB` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `tothyMbengelaDB`;

--
-- Table structure for table `admin_password_reset_tokens`
--

DROP TABLE IF EXISTS `admin_password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'E-mail de l’admin concerné.',
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Jeton de reset envoyé par e-mail.',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'Création du jeton.',
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Réinitialisation mot de passe pour la table admins (séparée des utilisateurs site).';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_password_reset_tokens`
--

LOCK TABLES `admin_password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `admin_password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (1,'Administrateur Alliance','admin@alliance-ministere.com','2026-03-31 08:08:33','$2y$12$D2Lo4aN1U7fK2fZPTCq2xeWLNcdDB9lpkZjLTJE6Ty1/m0rtoU5qm',NULL,'2026-03-31 08:08:33','2026-03-31 08:08:33');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `appointment_requests`
--

DROP TABLE IF EXISTS `appointment_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `appointment_requests`
--

LOCK TABLES `appointment_requests` WRITE;
/*!40000 ALTER TABLE `appointment_requests` DISABLE KEYS */;
/*!40000 ALTER TABLE `appointment_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `books`
--

DROP TABLE IF EXISTS `books`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `books`
--

LOCK TABLES `books` WRITE;
/*!40000 ALTER TABLE `books` DISABLE KEYS */;
INSERT INTO `books` VALUES (1,'7 Bénéfices de la Résolution','7-benefices-de-la-resolution','Découvrez les sept bénéfices puissants qui découlent d\'une résolution ferme en Dieu. Cet ouvrage de la Pasteure Tothy Mbengela vous guide dans la compréhension de la force d\'une décision ancrée dans la foi et vous encourage à tenir ferme dans vos engagements spirituels.',10.00,'USD',NULL,NULL,NULL,1,NULL,'2026-03-31 08:08:34','2026-03-31 08:08:34',NULL),(2,'À l\'Instar d\'Élie','a-linstar-delie','Inspiré par la vie du prophète Élie, ce livre vous invite à vivre une foi audacieuse et courageuse. La Pasteure Tothy Mbengela explore les leçons tirées de la vie d\'Élie pour fortifier votre marche avec Dieu et vous préparer aux défis de la vie chrétienne.',10.00,'USD',NULL,NULL,NULL,1,NULL,'2026-03-31 08:08:34','2026-03-31 08:08:34',NULL),(3,'Attends-la cette Promesse !','attends-la-cette-promesse','Les promesses de Dieu sont certaines, mais elles demandent patience et persévérance. Dans cet ouvrage, la Pasteure Tothy Mbengela vous encourage à ne pas abandonner, à garder la foi et à attendre avec confiance l\'accomplissement des promesses divines dans votre vie.',10.00,'USD',NULL,NULL,NULL,1,NULL,'2026-03-31 08:08:34','2026-03-31 08:08:34',NULL),(4,'Sois Daniel ! La Préparation','sois-daniel-la-preparation','Faisant partie de la Collection S.D., ce livre s\'inspire de la vie de Daniel pour vous préparer à vivre une vie d\'excellence et d\'intégrité au milieu d\'un monde hostile. La Pasteure Tothy Mbengela partage des clés pratiques pour rester fidèle à Dieu en toutes circonstances.',10.00,'USD',NULL,NULL,NULL,1,NULL,'2026-03-31 08:08:34','2026-03-31 08:08:34',NULL);
/*!40000 ALTER TABLE `books` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Clé unique de l’entrée de cache.',
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Valeur sérialisée (résultats de requêtes, vues, etc.).',
  `expiration` bigint NOT NULL COMMENT 'Timestamp Unix après lequel l’entrée est considérée comme expirée.',
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Cache applicatif en base (driver database) : paires clé / valeur avec expiration.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Clé de la ressource verrouillée.',
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Identifiant du détenteur actuel du verrou.',
  `expiration` bigint NOT NULL COMMENT 'Fin de validité du verrou (timestamp Unix).',
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Verrous distribués pour éviter courses critiques sur certaines opérations (cache locks).';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_messages`
--

DROP TABLE IF EXISTS `contact_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_messages`
--

LOCK TABLES `contact_messages` WRITE;
/*!40000 ALTER TABLE `contact_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `contact_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `content_comment_likes`
--

DROP TABLE IF EXISTS `content_comment_likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `content_comment_likes`
--

LOCK TABLES `content_comment_likes` WRITE;
/*!40000 ALTER TABLE `content_comment_likes` DISABLE KEYS */;
/*!40000 ALTER TABLE `content_comment_likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `content_comments`
--

DROP TABLE IF EXISTS `content_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `content_comments`
--

LOCK TABLES `content_comments` WRITE;
/*!40000 ALTER TABLE `content_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `content_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `content_likes`
--

DROP TABLE IF EXISTS `content_likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `content_likes`
--

LOCK TABLES `content_likes` WRITE;
/*!40000 ALTER TABLE `content_likes` DISABLE KEYS */;
/*!40000 ALTER TABLE `content_likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contents`
--

DROP TABLE IF EXISTS `contents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contents`
--

LOCK TABLES `contents` WRITE;
/*!40000 ALTER TABLE `contents` DISABLE KEYS */;
INSERT INTO `contents` VALUES (1,1,1,NULL,'video','youtube','Première vidéo — Proverbes','youtube-9MwDprKBkRg',NULL,NULL,NULL,'9MwDprKBkRg','https://www.youtube.com/watch?v=9MwDprKBkRg',NULL,NULL,NULL,1,0,1,'2026-03-30 08:08:34',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2s1I1uJ5EHDGBfZvQaOJ3K8\"}','2026-03-31 08:08:34','2026-03-31 08:08:34',NULL),(2,2,2,NULL,'video','youtube','Première vidéo — les minutes de ta destinée','youtube-GXQDovOqoBA',NULL,NULL,NULL,'GXQDovOqoBA','https://www.youtube.com/watch?v=GXQDovOqoBA',NULL,NULL,NULL,1,0,1,'2026-03-29 08:08:34',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2uCPMwKNnlFI-1v1es7AhjA\"}','2026-03-31 08:08:34','2026-03-31 08:08:34',NULL),(3,3,3,NULL,'video','youtube','Première vidéo — S’ACCOMPLIR','youtube-3FIhRR3qRog',NULL,NULL,NULL,'3FIhRR3qRog','https://www.youtube.com/watch?v=3FIhRR3qRog',NULL,NULL,NULL,1,0,1,'2026-03-28 09:08:34',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2vCBsN91hMIfQz5PHaiRlgX\"}','2026-03-31 08:08:34','2026-03-31 08:08:34',NULL),(4,2,4,NULL,'video','youtube','Première vidéo — SHORTS','youtube-J_CliWzm8ss',NULL,NULL,NULL,'J_CliWzm8ss','https://www.youtube.com/watch?v=J_CliWzm8ss',NULL,NULL,NULL,1,0,1,'2026-03-27 09:08:34',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2vFc808uhHmMBfyPaXXqKyI\"}','2026-03-31 08:08:34','2026-03-31 08:08:34',NULL),(5,4,5,NULL,'video','youtube','Première vidéo — PREDICATIONS','youtube-cFQT1lpg5Xw',NULL,NULL,NULL,'cFQT1lpg5Xw','https://www.youtube.com/watch?v=cFQT1lpg5Xw',NULL,NULL,NULL,1,0,1,'2026-03-26 09:08:34',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2tZGNj2cS8PElJCyc3-UoAX\"}','2026-03-31 08:08:34','2026-03-31 08:08:34',NULL),(6,4,6,NULL,'video','youtube','Première vidéo — NE POUR VAINCRE','youtube-oSUTbflBQsg',NULL,NULL,NULL,'oSUTbflBQsg','https://www.youtube.com/watch?v=oSUTbflBQsg',NULL,NULL,NULL,1,0,1,'2026-03-25 09:08:34',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2uzP1ZWOokLxP-coaOx2kgb\"}','2026-03-31 08:08:34','2026-03-31 08:08:34',NULL),(7,1,7,NULL,'video','youtube','Première vidéo — LES COMMENT','youtube-vYerKexKZyk',NULL,NULL,NULL,'vYerKexKZyk','https://www.youtube.com/watch?v=vYerKexKZyk',NULL,NULL,NULL,1,0,1,'2026-03-24 09:08:34',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2uiRaa-pyd5HXhx7qQ_iTXg\"}','2026-03-31 08:08:34','2026-03-31 08:08:34',NULL),(8,4,8,NULL,'video','youtube','VEUILLE SEULEMENT L’ÉTERNEL, TON DIEU, ÊTRE AVEC TOI | Pasteure Tothy Mbengela','youtube-Asc3iaC4IK4',NULL,NULL,NULL,'Asc3iaC4IK4','https://www.youtube.com/watch?v=Asc3iaC4IK4',NULL,NULL,NULL,1,0,1,'2026-03-17 07:14:06',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2sD9r4q7PdGyZo5puKtFvx9\"}','2026-03-31 08:08:34','2026-03-31 08:08:34',NULL),(9,5,9,NULL,'video','youtube','Première vidéo — FEMME DISCIPLE DE JESUS','youtube-7flJZzwDy_Q',NULL,NULL,NULL,'7flJZzwDy_Q','https://www.youtube.com/watch?v=7flJZzwDy_Q',NULL,NULL,NULL,1,0,1,'2026-03-22 09:08:34',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2v_8yPCFZhkQ9bXcT-oRjJr\"}','2026-03-31 08:08:34','2026-03-31 08:08:34',NULL),(10,6,10,NULL,'video','youtube','MES DECLARATIONS | Mars 2026 | Pasteure Tothy MBENGELA','youtube-6K1sZTwY9Vs',NULL,NULL,NULL,'6K1sZTwY9Vs','https://www.youtube.com/watch?v=6K1sZTwY9Vs',NULL,NULL,NULL,1,0,1,'2026-03-01 09:35:49',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2vf9n2r_mdvtPB6UhVf2aAC\"}','2026-03-31 08:08:34','2026-03-31 08:08:34',NULL),(11,3,11,NULL,'video','youtube','Première vidéo — ET SI TU PRIAIS / Court-Métrage','youtube-fPNDYt4WZog',NULL,NULL,NULL,'fPNDYt4WZog','https://www.youtube.com/watch?v=fPNDYt4WZog',NULL,NULL,NULL,1,0,1,'2026-03-20 09:08:34',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2uby5SrqpArUStxfl8cj1n4\"}','2026-03-31 08:08:34','2026-03-31 08:08:34',NULL),(12,2,4,NULL,'video','youtube','MES 4 LIVRES SONT DESORMAIS DISPONIBLES #livresinspirants','youtube-C7qfNyJKRn0','Les livres sont désormais disponibles et à votre portée.',NULL,NULL,'C7qfNyJKRn0','https://www.youtube.com/watch?v=C7qfNyJKRn0',NULL,NULL,NULL,1,0,1,'2026-03-18 11:43:29',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2vFc808uhHmMBfyPaXXqKyI\"}','2026-03-31 08:08:34','2026-03-31 08:08:34',NULL),(13,3,3,NULL,'video','youtube','MON HISTOIRE VERS L’ÉCRITURE | VERNISSAGE DE QUATRE LIVRES','youtube-0BH75IkAuq4',NULL,NULL,NULL,'0BH75IkAuq4','https://www.youtube.com/watch?v=0BH75IkAuq4',NULL,NULL,NULL,1,0,1,'2026-02-28 20:44:20',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2vCBsN91hMIfQz5PHaiRlgX\"}','2026-03-31 08:08:34','2026-03-31 08:08:34',NULL),(14,4,8,NULL,'video','youtube','IL PEUT FAIRE INFINIMENT AU DELÀ | Pasteure Tothy Mbengela','youtube-460ftY_DReE',NULL,NULL,NULL,'460ftY_DReE','https://www.youtube.com/watch?v=460ftY_DReE',NULL,NULL,NULL,1,0,1,'2026-02-16 12:03:26',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2sD9r4q7PdGyZo5puKtFvx9\"}','2026-03-31 08:08:34','2026-03-31 08:08:34',NULL),(15,4,8,NULL,'video','youtube','QUE L’ÉTERNEL VOUS BÉNISSE COMME IL VOUS L’A PROMIS | Pasteure Tothy Mbengela','youtube-ipfxjB-9KZ0',NULL,NULL,NULL,'ipfxjB-9KZ0','https://www.youtube.com/watch?v=ipfxjB-9KZ0',NULL,NULL,NULL,1,0,1,'2026-02-03 04:09:39',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2sD9r4q7PdGyZo5puKtFvx9\"}','2026-03-31 08:08:34','2026-03-31 08:08:34',NULL),(16,6,10,NULL,'video','youtube','MES DECLARATIONS | Février 2026 | Maman Lévi NGALULA','youtube-3HXUCDTAItE',NULL,NULL,NULL,'3HXUCDTAItE','https://www.youtube.com/watch?v=3HXUCDTAItE',NULL,NULL,NULL,1,0,1,'2026-02-01 09:27:51',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2vf9n2r_mdvtPB6UhVf2aAC\"}','2026-03-31 08:08:34','2026-03-31 08:08:34',NULL),(17,6,10,NULL,'video','youtube','MES DECLARATIONS | Février 2026 | Maman Lévi NGALULA','youtube-fc1CQ6g2GTU',NULL,NULL,NULL,'fc1CQ6g2GTU','https://www.youtube.com/watch?v=fc1CQ6g2GTU',NULL,NULL,NULL,1,0,1,'2026-01-31 20:27:15',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2vf9n2r_mdvtPB6UhVf2aAC\"}','2026-03-31 08:08:34','2026-03-31 08:08:34',NULL),(18,4,5,NULL,'video','youtube','FAITES DONC MOURIR VOTRE CHAIR | Pasteure Tothy Mbengela','youtube-d0cnu_4z2Jc',NULL,NULL,NULL,'d0cnu_4z2Jc','https://www.youtube.com/watch?v=d0cnu_4z2Jc',NULL,NULL,NULL,1,0,1,'2026-01-28 15:01:15',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2tZGNj2cS8PElJCyc3-UoAX\"}','2026-03-31 08:08:34','2026-03-31 08:08:34',NULL),(19,4,5,NULL,'video','youtube','SOUVIENS-TOI QUE TU ES EN VOYAGE | Pasteure Tothy Mbengela','youtube-7OkAo286H40',NULL,NULL,NULL,'7OkAo286H40','https://www.youtube.com/watch?v=7OkAo286H40',NULL,NULL,NULL,1,0,1,'2026-01-19 13:26:50',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2tZGNj2cS8PElJCyc3-UoAX\"}','2026-03-31 08:08:34','2026-03-31 08:08:34',NULL),(20,4,6,NULL,'video','youtube','VAINCRE LA COLÈRE PAR LA PRIÈRE - Pasteure Tothy Mbengela','youtube-qbQ2DOc_r4c',NULL,NULL,NULL,'qbQ2DOc_r4c','https://www.youtube.com/watch?v=qbQ2DOc_r4c',NULL,NULL,NULL,1,0,1,'2026-01-12 07:32:20',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2uzP1ZWOokLxP-coaOx2kgb\"}','2026-03-31 08:08:34','2026-03-31 08:08:34',NULL),(21,6,10,NULL,'video','youtube','MES DECLARATIONS | DÉCEMBRE 2025 | Pasteure Tothy MBENGELA','youtube-q4RsEMhO1WM',NULL,NULL,NULL,'q4RsEMhO1WM','https://www.youtube.com/watch?v=q4RsEMhO1WM',NULL,NULL,NULL,1,0,1,'2025-12-01 09:51:03',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2vf9n2r_mdvtPB6UhVf2aAC\"}','2026-03-31 08:08:34','2026-03-31 08:08:34',NULL),(22,6,10,NULL,'video','youtube','MES DÉCLARATIONS | NOVEMBRE 2025 | Pasteure Tothy MBENGELA','youtube-TzHPp3DgRuA',NULL,NULL,NULL,'TzHPp3DgRuA','https://www.youtube.com/watch?v=TzHPp3DgRuA',NULL,NULL,NULL,1,0,1,'2025-11-01 09:10:50',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2vf9n2r_mdvtPB6UhVf2aAC\"}','2026-03-31 08:08:34','2026-03-31 08:08:34',NULL),(23,6,10,NULL,'video','youtube','MES DECLARATIONS | OCTOBRE | Pasteure Tothy MBENGELA','youtube-ywJ81B3IQjs',NULL,NULL,NULL,'ywJ81B3IQjs','https://www.youtube.com/watch?v=ywJ81B3IQjs',NULL,NULL,NULL,1,0,1,'2025-09-30 19:59:36',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2vf9n2r_mdvtPB6UhVf2aAC\"}','2026-03-31 08:08:34','2026-03-31 08:08:34',NULL),(24,6,10,NULL,'video','youtube','MES DECLARATIONS | Mois de Septembre | Maman Lévi NGALULA','youtube-yfGCHRZIvDo',NULL,NULL,NULL,'yfGCHRZIvDo','https://www.youtube.com/watch?v=yfGCHRZIvDo',NULL,NULL,NULL,1,0,1,'2025-09-01 08:25:11',0,0,'{\"youtube_channel_id\": \"UCLp18bcg9ZMQWXaaqtqJn_A\", \"youtube_playlist_id\": \"PLsE9YNHy_f2vf9n2r_mdvtPB6UhVf2aAC\"}','2026-03-31 08:08:34','2026-03-31 08:08:34',NULL);
/*!40000 ALTER TABLE `contents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `donations`
--

DROP TABLE IF EXISTS `donations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `donations`
--

LOCK TABLES `donations` WRITE;
/*!40000 ALTER TABLE `donations` DISABLE KEYS */;
/*!40000 ALTER TABLE `donations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_03_21_122508_create_admins_table',1),(5,'2026_03_22_100000_create_rubriques_table',1),(6,'2026_03_22_100001_create_themes_table',1),(7,'2026_03_22_100002_create_series_table',1),(8,'2026_03_22_100003_create_contents_table',1),(9,'2026_03_22_100004_create_books_table',1),(10,'2026_03_22_100005_create_orders_table',1),(11,'2026_03_22_100006_create_order_items_table',1),(12,'2026_03_22_100007_create_newsletter_subscribers_table',1),(13,'2026_03_22_100008_create_contact_messages_table',1),(14,'2026_03_22_100009_create_appointment_requests_table',1),(15,'2026_03_22_100010_create_donations_table',1),(16,'2026_03_22_100011_create_partner_commitments_table',1),(17,'2026_03_22_130000_sync_users_contents_partners_schema',1),(18,'2026_03_22_200000_add_thumbnails_icons_to_rubriques_themes_series',1),(19,'2026_03_23_161437_create_permission_tables',1),(20,'2026_03_25_014650_create_testimonials_table',1),(21,'2026_03_25_120000_add_payment_reference_columns',1),(22,'2026_03_25_120000_add_reference_and_external_to_orders_table',1),(23,'2026_03_25_140000_create_shipping_settings_table',1),(24,'2026_03_25_140001_add_shipping_and_grand_total_to_orders_table',1),(25,'2026_03_26_100000_add_shipping_address_and_phone_to_orders_table',1),(26,'2026_03_26_120000_add_confirmation_token_to_newsletter_subscribers_table',1),(27,'2026_03_27_180000_create_content_comments_and_likes_tables',1),(28,'2026_03_27_180001_create_content_comment_likes_table_if_missing',1),(29,'2026_03_27_184204_create_content_likes_table',1),(30,'2026_03_27_220000_create_team_members_table',1),(31,'2026_03_31_120000_create_pastor_activities_table',1),(32,'2026_03_31_200000_create_pastor_activity_gallery_items_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\Admin',1);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `newsletter_subscribers`
--

DROP TABLE IF EXISTS `newsletter_subscribers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `newsletter_subscribers`
--

LOCK TABLES `newsletter_subscribers` WRITE;
/*!40000 ALTER TABLE `newsletter_subscribers` DISABLE KEYS */;
/*!40000 ALTER TABLE `newsletter_subscribers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `partner_commitments`
--

DROP TABLE IF EXISTS `partner_commitments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `partner_commitments`
--

LOCK TABLES `partner_commitments` WRITE;
/*!40000 ALTER TABLE `partner_commitments` DISABLE KEYS */;
/*!40000 ALTER TABLE `partner_commitments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'E-mail du compte concerné ; clé primaire logique.',
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Jeton signé ou hashé envoyé par lien dans l’e-mail.',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'Date de création du jeton (expiration gérée par l’application).',
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Jetons de réinitialisation de mot de passe pour les utilisateurs (file d’attente e-mail).';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pastor_activities`
--

DROP TABLE IF EXISTS `pastor_activities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pastor_activities` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `starts_at` datetime NOT NULL,
  `ends_at` datetime DEFAULT NULL,
  `poster_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `spot_image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `spot_url` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int unsigned NOT NULL DEFAULT '0',
  `is_published` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pastor_activities_slug_unique` (`slug`),
  KEY `pastor_activities_is_published_starts_at_index` (`is_published`,`starts_at`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pastor_activities`
--

LOCK TABLES `pastor_activities` WRITE;
/*!40000 ALTER TABLE `pastor_activities` DISABLE KEYS */;
INSERT INTO `pastor_activities` VALUES (1,'Atelier des femmes — session de mars','atelier-femmes-session-mars','Temps d’enseignement, d’échange et de prière entre sœurs. Thème : grandir dans la grâce au quotidien.','Centre Missionnaire Philadelphie, Lubumbashi','2026-03-13 15:00:00','2026-03-13 18:30:00','pastor-activities/posters/seed/atelier-femmes-affiche.jpeg','pastor-activities/posters/seed/atelier-femmes-affiche.jpeg','https://www.youtube.com/watch?v=7flJZzwDy_Q',10,1,'2026-03-31 08:08:36','2026-03-31 08:08:36'),(2,'Soirée louange et témoignages','soiree-louange-temoignages','Soirée ouverte : adoration et partage autour de la foi.','Alliance — Ministère Tothy Mbengela','2026-03-25 18:00:00','2026-03-25 20:30:00','pastor-activities/posters/seed/wa-01.jpeg','pastor-activities/posters/seed/wa-01.jpeg','https://www.youtube.com/watch?v=0BH75IkAuq4',20,1,'2026-03-31 08:08:36','2026-03-31 08:08:36'),(3,'Matinée de formation — leadership au féminin','matinee-formation-leadership-feminin','Aujourd’hui : atelier pratique pour servir avec sagesse dans la famille, l’église et la cité.','Lubumbashi','2026-03-31 10:00:00','2026-03-31 12:30:00','pastor-activities/posters/seed/wa-02.jpeg','pastor-activities/posters/seed/wa-02.jpeg','https://www.youtube.com/watch?v=C7qfNyJKRn0',30,1,'2026-03-31 08:08:36','2026-03-31 08:08:36'),(4,'Culte de célébration — soirée de gloire','culte-celebration-soiree-gloire','Ce soir : louange, Parole et moment de communion.','Centre Missionnaire Philadelphie, Lubumbashi','2026-03-31 18:30:00','2026-03-31 20:30:00','pastor-activities/posters/seed/wa-03.jpeg','pastor-activities/posters/seed/wa-03.jpeg','https://www.youtube.com/watch?v=Asc3iaC4IK4',40,1,'2026-03-31 08:08:36','2026-03-31 08:08:36'),(5,'Prière des femmes — intercession','priere-femmes-intercession','Rendez-vous de prière pour les familles, l’église et la nation.','Lubumbashi','2026-04-02 15:00:00','2026-04-02 17:00:00','pastor-activities/posters/seed/wa-04.jpeg','pastor-activities/posters/seed/wa-04.jpeg','https://www.youtube.com/watch?v=6K1sZTwY9Vs',50,1,'2026-03-31 08:08:36','2026-03-31 08:08:36'),(6,'Étude biblique — série « S’accomplir »','etude-biblique-serie-saccomplir','Approfondissement biblique (série disponible sur la chaîne YouTube du ministère).','Lubumbashi','2026-04-04 17:00:00','2026-04-04 18:45:00','pastor-activities/posters/seed/wa-05.jpeg','pastor-activities/posters/seed/wa-05.jpeg','https://www.youtube.com/watch?v=3FIhRR3qRog',60,1,'2026-03-31 08:08:36','2026-03-31 08:08:36'),(7,'Veillée de prière de fin de semaine','veillee-priere-fin-de-semaine','Moment de prière pour clôturer la semaine dans la présence de Dieu.','Alliance — Ministère Tothy Mbengela','2026-04-05 20:00:00','2026-04-05 22:30:00','pastor-activities/posters/seed/wa-06.jpeg','pastor-activities/posters/seed/wa-06.jpeg','https://www.youtube.com/watch?v=460ftY_DReE',70,1,'2026-03-31 08:08:36','2026-03-31 08:08:36'),(8,'Conférence — « Femme disciple de Jésus »','conference-femme-disciple-de-jesus','Grande matinée d’enseignement : suivre Christ au quotidien.','Lubumbashi','2026-04-12 09:30:00','2026-04-12 13:00:00','pastor-activities/posters/seed/wa-07.jpeg','pastor-activities/posters/seed/wa-07.jpeg','https://www.youtube.com/watch?v=7flJZzwDy_Q',80,1,'2026-03-31 08:08:36','2026-03-31 08:08:36');
/*!40000 ALTER TABLE `pastor_activities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pastor_activity_gallery_items`
--

DROP TABLE IF EXISTS `pastor_activity_gallery_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pastor_activity_gallery_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pastor_activity_id` bigint unsigned NOT NULL,
  `type` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `external_url` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `caption` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pa_gallery_activity_sort` (`pastor_activity_id`,`sort_order`),
  CONSTRAINT `pastor_activity_gallery_items_pastor_activity_id_foreign` FOREIGN KEY (`pastor_activity_id`) REFERENCES `pastor_activities` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pastor_activity_gallery_items`
--

LOCK TABLES `pastor_activity_gallery_items` WRITE;
/*!40000 ALTER TABLE `pastor_activity_gallery_items` DISABLE KEYS */;
INSERT INTO `pastor_activity_gallery_items` VALUES (1,2,'image','pastor-activities/posters/seed/wa-08.jpeg',NULL,'Moment de l’événement — Soirée louange et témoignages',0,'2026-03-31 08:08:36','2026-03-31 08:08:36'),(2,2,'image','pastor-activities/posters/seed/wa-09.jpeg',NULL,'Moment de l’événement — Soirée louange et témoignages',1,'2026-03-31 08:08:36','2026-03-31 08:08:36'),(3,2,'image','pastor-activities/posters/seed/atelier-femmes-affiche.jpeg',NULL,'Moment de l’événement — Soirée louange et témoignages',2,'2026-03-31 08:08:36','2026-03-31 08:08:36'),(4,2,'image','pastor-activities/posters/seed/wa-01.jpeg',NULL,'Moment de l’événement — Soirée louange et témoignages',3,'2026-03-31 08:08:36','2026-03-31 08:08:36'),(5,2,'video',NULL,'https://www.youtube.com/watch?v=7flJZzwDy_Q','Retour en images (vidéo)',4,'2026-03-31 08:08:36','2026-03-31 08:08:36'),(6,1,'image','pastor-activities/posters/seed/wa-08.jpeg',NULL,'Moment de l’événement — Atelier des femmes — session de mars',0,'2026-03-31 08:08:36','2026-03-31 08:08:36'),(7,1,'image','pastor-activities/posters/seed/wa-09.jpeg',NULL,'Moment de l’événement — Atelier des femmes — session de mars',1,'2026-03-31 08:08:36','2026-03-31 08:08:36'),(8,1,'image','pastor-activities/posters/seed/atelier-femmes-affiche.jpeg',NULL,'Moment de l’événement — Atelier des femmes — session de mars',2,'2026-03-31 08:08:36','2026-03-31 08:08:36'),(9,1,'image','pastor-activities/posters/seed/wa-01.jpeg',NULL,'Moment de l’événement — Atelier des femmes — session de mars',3,'2026-03-31 08:08:36','2026-03-31 08:08:36'),(10,1,'video',NULL,'https://www.youtube.com/watch?v=7flJZzwDy_Q','Retour en images (vidéo)',4,'2026-03-31 08:08:36','2026-03-31 08:08:36');
/*!40000 ALTER TABLE `pastor_activity_gallery_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=197 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'ViewAny:AppointmentRequest','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(2,'View:AppointmentRequest','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(3,'Create:AppointmentRequest','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(4,'Update:AppointmentRequest','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(5,'Delete:AppointmentRequest','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(6,'DeleteAny:AppointmentRequest','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(7,'Restore:AppointmentRequest','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(8,'ForceDelete:AppointmentRequest','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(9,'ForceDeleteAny:AppointmentRequest','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(10,'RestoreAny:AppointmentRequest','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(11,'Replicate:AppointmentRequest','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(12,'Reorder:AppointmentRequest','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(13,'ViewAny:Book','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(14,'View:Book','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(15,'Create:Book','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(16,'Update:Book','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(17,'Delete:Book','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(18,'DeleteAny:Book','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(19,'Restore:Book','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(20,'ForceDelete:Book','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(21,'ForceDeleteAny:Book','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(22,'RestoreAny:Book','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(23,'Replicate:Book','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(24,'Reorder:Book','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(25,'ViewAny:ContactMessage','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(26,'View:ContactMessage','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(27,'Create:ContactMessage','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(28,'Update:ContactMessage','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(29,'Delete:ContactMessage','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(30,'DeleteAny:ContactMessage','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(31,'Restore:ContactMessage','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(32,'ForceDelete:ContactMessage','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(33,'ForceDeleteAny:ContactMessage','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(34,'RestoreAny:ContactMessage','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(35,'Replicate:ContactMessage','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(36,'Reorder:ContactMessage','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(37,'ViewAny:Content','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(38,'View:Content','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(39,'Create:Content','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(40,'Update:Content','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(41,'Delete:Content','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(42,'DeleteAny:Content','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(43,'Restore:Content','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(44,'ForceDelete:Content','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(45,'ForceDeleteAny:Content','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(46,'RestoreAny:Content','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(47,'Replicate:Content','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(48,'Reorder:Content','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(49,'ViewAny:Donation','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(50,'View:Donation','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(51,'Create:Donation','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(52,'Update:Donation','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(53,'Delete:Donation','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(54,'DeleteAny:Donation','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(55,'Restore:Donation','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(56,'ForceDelete:Donation','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(57,'ForceDeleteAny:Donation','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(58,'RestoreAny:Donation','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(59,'Replicate:Donation','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(60,'Reorder:Donation','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(61,'ViewAny:NewsletterSubscriber','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(62,'View:NewsletterSubscriber','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(63,'Create:NewsletterSubscriber','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(64,'Update:NewsletterSubscriber','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(65,'Delete:NewsletterSubscriber','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(66,'DeleteAny:NewsletterSubscriber','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(67,'Restore:NewsletterSubscriber','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(68,'ForceDelete:NewsletterSubscriber','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(69,'ForceDeleteAny:NewsletterSubscriber','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(70,'RestoreAny:NewsletterSubscriber','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(71,'Replicate:NewsletterSubscriber','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(72,'Reorder:NewsletterSubscriber','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(73,'ViewAny:Order','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(74,'View:Order','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(75,'Create:Order','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(76,'Update:Order','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(77,'Delete:Order','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(78,'DeleteAny:Order','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(79,'Restore:Order','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(80,'ForceDelete:Order','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(81,'ForceDeleteAny:Order','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(82,'RestoreAny:Order','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(83,'Replicate:Order','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(84,'Reorder:Order','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(85,'ViewAny:PartnerCommitment','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(86,'View:PartnerCommitment','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(87,'Create:PartnerCommitment','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(88,'Update:PartnerCommitment','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(89,'Delete:PartnerCommitment','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(90,'DeleteAny:PartnerCommitment','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(91,'Restore:PartnerCommitment','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(92,'ForceDelete:PartnerCommitment','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(93,'ForceDeleteAny:PartnerCommitment','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(94,'RestoreAny:PartnerCommitment','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(95,'Replicate:PartnerCommitment','admin','2026-03-31 08:08:33','2026-03-31 08:08:33'),(96,'Reorder:PartnerCommitment','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(97,'ViewAny:PastorActivity','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(98,'View:PastorActivity','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(99,'Create:PastorActivity','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(100,'Update:PastorActivity','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(101,'Delete:PastorActivity','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(102,'DeleteAny:PastorActivity','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(103,'Restore:PastorActivity','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(104,'ForceDelete:PastorActivity','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(105,'ForceDeleteAny:PastorActivity','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(106,'RestoreAny:PastorActivity','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(107,'Replicate:PastorActivity','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(108,'Reorder:PastorActivity','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(109,'ViewAny:Rubrique','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(110,'View:Rubrique','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(111,'Create:Rubrique','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(112,'Update:Rubrique','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(113,'Delete:Rubrique','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(114,'DeleteAny:Rubrique','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(115,'Restore:Rubrique','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(116,'ForceDelete:Rubrique','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(117,'ForceDeleteAny:Rubrique','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(118,'RestoreAny:Rubrique','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(119,'Replicate:Rubrique','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(120,'Reorder:Rubrique','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(121,'ViewAny:Series','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(122,'View:Series','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(123,'Create:Series','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(124,'Update:Series','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(125,'Delete:Series','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(126,'DeleteAny:Series','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(127,'Restore:Series','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(128,'ForceDelete:Series','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(129,'ForceDeleteAny:Series','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(130,'RestoreAny:Series','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(131,'Replicate:Series','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(132,'Reorder:Series','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(133,'ViewAny:ShippingSetting','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(134,'View:ShippingSetting','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(135,'Create:ShippingSetting','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(136,'Update:ShippingSetting','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(137,'Delete:ShippingSetting','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(138,'DeleteAny:ShippingSetting','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(139,'Restore:ShippingSetting','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(140,'ForceDelete:ShippingSetting','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(141,'ForceDeleteAny:ShippingSetting','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(142,'RestoreAny:ShippingSetting','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(143,'Replicate:ShippingSetting','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(144,'Reorder:ShippingSetting','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(145,'ViewAny:TeamMember','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(146,'View:TeamMember','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(147,'Create:TeamMember','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(148,'Update:TeamMember','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(149,'Delete:TeamMember','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(150,'DeleteAny:TeamMember','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(151,'Restore:TeamMember','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(152,'ForceDelete:TeamMember','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(153,'ForceDeleteAny:TeamMember','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(154,'RestoreAny:TeamMember','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(155,'Replicate:TeamMember','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(156,'Reorder:TeamMember','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(157,'ViewAny:Theme','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(158,'View:Theme','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(159,'Create:Theme','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(160,'Update:Theme','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(161,'Delete:Theme','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(162,'DeleteAny:Theme','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(163,'Restore:Theme','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(164,'ForceDelete:Theme','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(165,'ForceDeleteAny:Theme','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(166,'RestoreAny:Theme','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(167,'Replicate:Theme','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(168,'Reorder:Theme','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(169,'ViewAny:User','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(170,'View:User','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(171,'Create:User','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(172,'Update:User','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(173,'Delete:User','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(174,'DeleteAny:User','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(175,'Restore:User','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(176,'ForceDelete:User','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(177,'ForceDeleteAny:User','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(178,'RestoreAny:User','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(179,'Replicate:User','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(180,'Reorder:User','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(181,'ViewAny:Role','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(182,'View:Role','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(183,'Create:Role','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(184,'Update:Role','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(185,'Delete:Role','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(186,'DeleteAny:Role','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(187,'Restore:Role','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(188,'ForceDelete:Role','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(189,'ForceDeleteAny:Role','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(190,'RestoreAny:Role','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(191,'Replicate:Role','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(192,'Reorder:Role','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(193,'View:ContenuMinistereStatsWidget','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(194,'View:BoutiqueStatsWidget','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(195,'View:EngagementStatsWidget','admin','2026-03-31 08:08:34','2026-03-31 08:08:34'),(196,'View:ComptesSiteStatsWidget','admin','2026-03-31 08:08:34','2026-03-31 08:08:34');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(9,1),(10,1),(11,1),(12,1),(13,1),(14,1),(15,1),(16,1),(17,1),(18,1),(19,1),(20,1),(21,1),(22,1),(23,1),(24,1),(25,1),(26,1),(27,1),(28,1),(29,1),(30,1),(31,1),(32,1),(33,1),(34,1),(35,1),(36,1),(37,1),(38,1),(39,1),(40,1),(41,1),(42,1),(43,1),(44,1),(45,1),(46,1),(47,1),(48,1),(49,1),(50,1),(51,1),(52,1),(53,1),(54,1),(55,1),(56,1),(57,1),(58,1),(59,1),(60,1),(61,1),(62,1),(63,1),(64,1),(65,1),(66,1),(67,1),(68,1),(69,1),(70,1),(71,1),(72,1),(73,1),(74,1),(75,1),(76,1),(77,1),(78,1),(79,1),(80,1),(81,1),(82,1),(83,1),(84,1),(85,1),(86,1),(87,1),(88,1),(89,1),(90,1),(91,1),(92,1),(93,1),(94,1),(95,1),(96,1),(97,1),(98,1),(99,1),(100,1),(101,1),(102,1),(103,1),(104,1),(105,1),(106,1),(107,1),(108,1),(109,1),(110,1),(111,1),(112,1),(113,1),(114,1),(115,1),(116,1),(117,1),(118,1),(119,1),(120,1),(121,1),(122,1),(123,1),(124,1),(125,1),(126,1),(127,1),(128,1),(129,1),(130,1),(131,1),(132,1),(133,1),(134,1),(135,1),(136,1),(137,1),(138,1),(139,1),(140,1),(141,1),(142,1),(143,1),(144,1),(145,1),(146,1),(147,1),(148,1),(149,1),(150,1),(151,1),(152,1),(153,1),(154,1),(155,1),(156,1),(157,1),(158,1),(159,1),(160,1),(161,1),(162,1),(163,1),(164,1),(165,1),(166,1),(167,1),(168,1),(169,1),(170,1),(171,1),(172,1),(173,1),(174,1),(175,1),(176,1),(177,1),(178,1),(179,1),(180,1),(181,1),(182,1),(183,1),(184,1),(185,1),(186,1),(187,1),(188,1),(189,1),(190,1),(191,1),(192,1),(193,1),(194,1),(195,1),(196,1);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'super_admin','admin','2026-03-31 08:08:34','2026-03-31 08:08:34');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rubriques`
--

DROP TABLE IF EXISTS `rubriques`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rubriques`
--

LOCK TABLES `rubriques` WRITE;
/*!40000 ALTER TABLE `rubriques` DISABLE KEYS */;
INSERT INTO `rubriques` VALUES (1,'Proverbes','proverbes','Méditations et commentaires autour des Proverbes.',NULL,NULL,10,1,'2026-03-31 08:08:34','2026-03-31 08:08:34'),(2,'Minutes de ta destinée','minutes-de-ta-destinee','Capsules courtes pour avancer dans votre destinée.',NULL,NULL,20,1,'2026-03-31 08:08:34','2026-03-31 08:08:34'),(3,'S’accomplir','s-accomplir','Série dédiée à l’accomplissement selon Dieu.',NULL,NULL,30,1,'2026-03-31 08:08:34','2026-03-31 08:08:34'),(4,'Prédications','predications','Messages et cultes en vidéo.',NULL,NULL,40,1,'2026-03-31 08:08:34','2026-03-31 08:08:34'),(5,'Femme disciple de Jésus','femme-disciple-de-jesus','Enseignements pour la femme disciple.',NULL,NULL,50,1,'2026-03-31 08:08:34','2026-03-31 08:08:34'),(6,'Mes déclarations','mes-declarations','Le programme Mes déclarations.',NULL,NULL,60,1,'2026-03-31 08:08:34','2026-03-31 08:08:34');
/*!40000 ALTER TABLE `rubriques` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `series`
--

DROP TABLE IF EXISTS `series`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `series`
--

LOCK TABLES `series` WRITE;
/*!40000 ALTER TABLE `series` DISABLE KEYS */;
INSERT INTO `series` VALUES (1,1,NULL,'Proverbes','playlist-proverbes',NULL,NULL,'Playlist YouTube « Proverbes » (chaîne @tothy_mbengela).',0,'2026-03-31 08:08:34','2026-03-31 08:08:34'),(2,2,NULL,'les minutes de ta destinée','playlist-minutes-de-ta-destinee',NULL,NULL,'Playlist YouTube « les minutes de ta destinée » (chaîne @tothy_mbengela).',1,'2026-03-31 08:08:34','2026-03-31 08:08:34'),(3,3,NULL,'S’ACCOMPLIR','playlist-s-accomplir',NULL,NULL,'Playlist YouTube « S’ACCOMPLIR » (chaîne @tothy_mbengela).',2,'2026-03-31 08:08:34','2026-03-31 08:08:34'),(4,2,NULL,'SHORTS','playlist-shorts',NULL,NULL,'Playlist YouTube « SHORTS » (chaîne @tothy_mbengela).',3,'2026-03-31 08:08:34','2026-03-31 08:08:34'),(5,4,NULL,'PREDICATIONS','playlist-predications',NULL,NULL,'Playlist YouTube « PREDICATIONS » (chaîne @tothy_mbengela).',4,'2026-03-31 08:08:34','2026-03-31 08:08:34'),(6,4,NULL,'NE POUR VAINCRE','playlist-ne-pour-vaincre',NULL,NULL,'Playlist YouTube « NE POUR VAINCRE » (chaîne @tothy_mbengela).',5,'2026-03-31 08:08:34','2026-03-31 08:08:34'),(7,1,NULL,'LES COMMENT','playlist-les-comment',NULL,NULL,'Playlist YouTube « LES COMMENT » (chaîne @tothy_mbengela).',6,'2026-03-31 08:08:34','2026-03-31 08:08:34'),(8,4,NULL,'PAROLE DE LA SEMAINE','playlist-parole-de-la-semaine',NULL,NULL,'Playlist YouTube « PAROLE DE LA SEMAINE » (chaîne @tothy_mbengela).',7,'2026-03-31 08:08:34','2026-03-31 08:08:34'),(9,5,NULL,'FEMME DISCIPLE DE JESUS','playlist-femme-disciple-de-jesus',NULL,NULL,'Playlist YouTube « FEMME DISCIPLE DE JESUS » (chaîne @tothy_mbengela).',8,'2026-03-31 08:08:34','2026-03-31 08:08:34'),(10,6,NULL,'MES DECLARATIONS','playlist-mes-declarations',NULL,NULL,'Playlist YouTube « MES DECLARATIONS » (chaîne @tothy_mbengela).',9,'2026-03-31 08:08:34','2026-03-31 08:08:34'),(11,3,NULL,'ET SI TU PRIAIS / Court-Métrage','playlist-et-si-tu-priais-court-metrage',NULL,NULL,'Playlist YouTube « ET SI TU PRIAIS / Court-Métrage » (chaîne @tothy_mbengela).',10,'2026-03-31 08:08:34','2026-03-31 08:08:34');
/*!40000 ALTER TABLE `series` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shipping_settings`
--

DROP TABLE IF EXISTS `shipping_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shipping_settings`
--

LOCK TABLES `shipping_settings` WRITE;
/*!40000 ALTER TABLE `shipping_settings` DISABLE KEYS */;
INSERT INTO `shipping_settings` VALUES (1,1,'CD',5.00,28.00,'USD','2026-03-31 08:08:32','2026-03-31 08:08:34');
/*!40000 ALTER TABLE `shipping_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `team_members`
--

DROP TABLE IF EXISTS `team_members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `team_members` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Fonction affichée (ex. Pasteure, enseignante)',
  `excerpt` text COLLATE utf8mb4_unicode_ci COMMENT 'Texte court pour les cartes',
  `body` longtext COLLATE utf8mb4_unicode_ci COMMENT 'Biographie page détail',
  `photo_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Lien principal sur la photo (ex. chaîne YouTube)',
  `social_facebook` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `social_youtube` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `social_instagram` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `social_tiktok` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int unsigned NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `team_members_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `team_members`
--

LOCK TABLES `team_members` WRITE;
/*!40000 ALTER TABLE `team_members` DISABLE KEYS */;
INSERT INTO `team_members` VALUES (1,'Tothy Mbengela','tothy-mbengela','Pasteure, enseignante & auteure','Pasteure Tothy Mbengela — Parole, enseignement et ressources pour édifier la foi.','Alliance est le ministère de la Pasteure Tothy Mbengela. À travers des enseignements bibliques, des prédications et des ouvrages, elle sert la communauté à Lubumbashi et au-delà, en ligne.\n\nSa mission : restaurer les cœurs, encourager la marche avec Dieu et rendre la Parole accessible à tous.',NULL,'https://www.youtube.com/@tothymbengela','https://www.facebook.com/tothymbengela','https://www.youtube.com/@tothymbengela','https://www.instagram.com/tothymbengela','https://www.tiktok.com/@tothymbengela',0,1,'2026-03-31 08:08:34','2026-03-31 08:08:34');
/*!40000 ALTER TABLE `team_members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `testimonials`
--

DROP TABLE IF EXISTS `testimonials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `testimonials`
--

LOCK TABLES `testimonials` WRITE;
/*!40000 ALTER TABLE `testimonials` DISABLE KEYS */;
INSERT INTO `testimonials` VALUES (1,'Grace Mutombo','Membre fidèle','Lubumbashi, RDC','Les enseignements de la Pasteure Tothy m\'ont profondément transformée. J\'ai retrouvé ma foi et compris ma destinée en Christ. Que Dieu continue à bénir ce ministère !',NULL,5,1,1,'2026-03-31 08:08:35','2026-03-31 08:08:35'),(2,'Patrick Kabongo','Partenaire du ministère','Kinshasa, RDC','Depuis que je suis les prédications d\'Alliance, ma vie spirituelle a pris un tournant incroyable. Les livres de la Pasteure sont de véritables trésors de sagesse.',NULL,5,1,2,'2026-03-31 08:08:35','2026-03-31 08:08:35'),(3,'Marie-Claire Ilunga','Responsable cellule de prière','Likasi, RDC','Le livre \'7 Bénéfices de la Résolution\' a changé ma façon de voir les engagements envers Dieu. Je recommande vivement les ouvrages de la Pasteure Tothy.',NULL,5,1,3,'2026-03-31 08:08:35','2026-03-31 08:08:35'),(4,'Jean-Pierre Mwamba','Pasteur associé','Kolwezi, RDC','Un ministère puissant et ancré dans la Parole de Dieu. Les enseignements sont clairs, profonds et applicables au quotidien. Merci Pasteure !',NULL,5,1,4,'2026-03-31 08:08:35','2026-03-31 08:08:35'),(5,'Rachel Kisimba','Étudiante en théologie','Lubumbashi, RDC','\'À l\'Instar d\'Élie\' m\'a appris à développer une foi audacieuse. Ce livre est devenu mon compagnon de méditation quotidienne.',NULL,5,1,5,'2026-03-31 08:08:35','2026-03-31 08:08:35'),(6,'David Ngoy','Entrepreneur chrétien','Lubumbashi, RDC','Les contenus en ligne d\'Alliance sont une bénédiction pour ceux qui ne peuvent pas toujours être présents physiquement. La qualité est exceptionnelle.',NULL,5,1,6,'2026-03-31 08:08:35','2026-03-31 08:08:35'),(7,'Esther Kapinga','Femme au foyer','Kipushi, RDC','Le programme \'Femme Disciple\' m\'a aidée à trouver mon identité en Christ en tant que femme et mère. Merci pour cette vision !',NULL,5,1,7,'2026-03-31 08:08:35','2026-03-31 08:08:35'),(8,'Samuel Tshilumba','Diacre','Kamina, RDC','Chaque prédication est une nourriture spirituelle qui fortifie l\'âme. La Pasteure Tothy a un don unique pour rendre la Parole accessible à tous.',NULL,5,1,8,'2026-03-31 08:08:35','2026-03-31 08:08:35'),(9,'Béatrice Lunda','Enseignante','Kasumbalesa, RDC','\'Sois Daniel ! La Préparation\' m\'a donné le courage de rester intègre dans mon milieu professionnel. Un livre indispensable pour tout chrétien.',NULL,5,1,9,'2026-03-31 08:08:35','2026-03-31 08:08:35'),(10,'Joseph Kalala','Médecin','Lubumbashi, RDC','Je suis les vidéos YouTube du ministère depuis 2 ans. Chaque contenu est une source d\'inspiration et de renouvellement spirituel.',NULL,5,1,10,'2026-03-31 08:08:35','2026-03-31 08:08:35'),(11,'Chantal Mbuyu','Commerçante','Likasi, RDC','\'Attends-la cette Promesse !\' m\'a appris la patience dans l\'attente. Dieu est fidèle et ce livre m\'a aidée à le comprendre profondément.',NULL,5,1,11,'2026-03-31 08:08:35','2026-03-31 08:08:35'),(12,'François Kasongo','Musicien gospel','Kinshasa, RDC','Le ministère Alliance est une référence pour l\'édification de la foi en RDC. Les enseignements sont solides et équilibrés.',NULL,4,1,12,'2026-03-31 08:08:35','2026-03-31 08:08:35'),(13,'Nadine Kyungu','Infirmière','Lubumbashi, RDC','Grâce aux séries d\'enseignements, j\'ai pu approfondir ma connaissance des Écritures. C\'est un vrai séminaire spirituel en ligne !',NULL,5,1,13,'2026-03-31 08:08:35','2026-03-31 08:08:35'),(14,'Albert Mukendi','Ingénieur','Fungurume, RDC','La Pasteure Tothy a un cœur pour les âmes. Son authenticité et sa passion pour la Parole transparaissent dans chaque message.',NULL,5,1,14,'2026-03-31 08:08:35','2026-03-31 08:08:35'),(15,'Joséphine Mwila','Responsable jeunesse','Lubumbashi, RDC','Les jeunes de notre assemblée ont été profondément touchés par les enseignements du ministère. Un impact réel sur la nouvelle génération.',NULL,5,1,15,'2026-03-31 08:08:35','2026-03-31 08:08:35'),(16,'Pierre Banza','Comptable','Kolwezi, RDC','Les 4 livres de la Pasteure sont un coffret de sagesse divine. Je les ai tous lus et ils ont transformé ma vision de la vie chrétienne.',NULL,5,1,16,'2026-03-31 08:08:35','2026-03-31 08:08:35'),(17,'Carine Mujinga','Pharmacienne','Lubumbashi, RDC','Le vernissage des 4 livres a été un moment inoubliable. Voir l\'aboutissement du travail de la Pasteure m\'a inspirée à poursuivre mes propres rêves.',NULL,5,1,17,'2026-03-31 08:08:35','2026-03-31 08:08:35'),(18,'Moïse Katanga','Étudiant','Lubumbashi, RDC','En tant que jeune, les contenus d\'Alliance m\'aident à rester connecté à Dieu malgré les distractions du monde moderne. Merci infiniment !',NULL,4,1,18,'2026-03-31 08:08:35','2026-03-31 08:08:35'),(19,'Henriette Numbi','Missionnaire','Kalemie, RDC','Depuis la brousse où je sers, je peux suivre les enseignements en ligne. Alliance brise les barrières géographiques pour toucher les cœurs partout.',NULL,5,1,19,'2026-03-31 08:08:35','2026-03-31 08:08:35'),(20,'Thierry Kazadi','Avocat','Lubumbashi, RDC','La rigueur et la profondeur des enseignements bibliques du ministère Alliance sont remarquables. C\'est un phare spirituel pour notre communauté.',NULL,5,1,20,'2026-03-31 08:08:35','2026-03-31 08:08:35');
/*!40000 ALTER TABLE `testimonials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `themes`
--

DROP TABLE IF EXISTS `themes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `themes`
--

LOCK TABLES `themes` WRITE;
/*!40000 ALTER TABLE `themes` DISABLE KEYS */;
INSERT INTO `themes` VALUES (1,'Parole & prière','parole-et-priere',NULL,NULL,'Enseignements et temps de prière.','2026-03-31 08:08:34','2026-03-31 08:08:34'),(2,'Identité & destinée','identite-et-destinee',NULL,NULL,'Vocation, accomplissement et promesses.','2026-03-31 08:08:34','2026-03-31 08:08:34');
/*!40000 ALTER TABLE `themes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Visiteur démonstration','visiteur@alliance-ministere.com','2026-03-31 08:08:33','$2y$12$VOfWXM0Gr/aQKbzvXVHqk.H6r2fHU33irCw5V2rM/MKpZMD5jPeWK',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'fr',NULL,NULL,NULL,'2026-03-31 08:08:33','2026-03-31 08:08:33');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-03-31 18:56:41
