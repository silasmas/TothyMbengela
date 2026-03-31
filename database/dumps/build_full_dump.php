<?php

/**
 * Fusionne l’en-tête documentaire avec le dump mysqldump brut.
 * Réordonne les blocs CREATE TABLE selon les dépendances FK (mysqldump trie par nom, ce qui casse phpMyAdmin).
 * Usage (après mysqldump vers tothy_mbengela_full_new.sql) :
 *   php database/dumps/build_full_dump.php
 *
 * Réécrit le dump complet déjà généré (même en-tête projet) :
 *   php database/dumps/build_full_dump.php --normalize database/dumps/tothy_mbengela_full.sql
 */
declare(strict_types=1);

$dir = __DIR__;

/**
 * @return array{0: string, 1: string|null} [docHeader, body] body commence par « -- MySQL dump » si en-tête projet présent
 */
function split_dump_doc_and_body(string $full): array
{
    $pos = strpos($full, '-- MySQL dump');
    if ($pos === false) {
        return ['', $full];
    }

    return [substr($full, 0, $pos), substr($full, $pos)];
}

/** Ordre topologique des tables (parents avant enfants) pour FK valides avec FOREIGN_KEY_CHECKS=1. */
function dump_table_dependency_order(): array
{
    return [
        'admin_password_reset_tokens',
        'admins',
        'appointment_requests',
        'books',
        'cache',
        'cache_locks',
        'contact_messages',
        'donations',
        'failed_jobs',
        'job_batches',
        'jobs',
        'migrations',
        'newsletter_subscribers',
        'password_reset_tokens',
        'permissions',
        'roles',
        'rubriques',
        'themes',
        'series',
        'users',
        'contents',
        'content_comments',
        'content_comment_likes',
        'content_likes',
        'orders',
        'order_items',
        'partner_commitments',
        'pastor_activities',
        'pastor_activity_gallery_items',
        'role_has_permissions',
        'model_has_permissions',
        'model_has_roles',
        'sessions',
        'shipping_settings',
        'team_members',
        'testimonials',
    ];
}

function normalize_mysqldump_body(string $sql): string
{
    $tableStart = "--\n-- Table structure for table ";
    $pos = strpos($sql, $tableStart);
    if ($pos === false) {
        return $sql;
    }

    $pre = substr($sql, 0, $pos);
    $pre = preg_replace(
        '/^(USE `[^`]+`;)\R+/m',
        "$1\n\nSET FOREIGN_KEY_CHECKS=0;\nSET UNIQUE_CHECKS=0;\n\n",
        $pre,
        1
    ) ?? $pre;

    $fromTables = substr($sql, $pos);
    $epilogue = '';
    $tablesBody = $fromTables;
    $epMarker = "\n/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;";
    $epPos = strpos($fromTables, $epMarker);
    if ($epPos !== false) {
        $tablesBody = substr($fromTables, 0, $epPos);
        $epilogue = substr($fromTables, $epPos + 1);
    }

    $chunks = preg_split('/(?=^--\R-- Table structure for table `)/m', $tablesBody, -1, PREG_SPLIT_NO_EMPTY);
    if ($chunks === false || $chunks === []) {
        return $sql;
    }

    $map = [];
    $originalNames = [];

    foreach ($chunks as $chunk) {
        if (! preg_match('/^--\R-- Table structure for table `([^`]+)`/m', $chunk, $mn)) {
            continue;
        }
        $name = $mn[1];
        $originalNames[] = $name;
        $map[$name] = $chunk;
    }
    $preferred = dump_table_dependency_order();
    $emitted = [];
    $out = $pre;

    foreach ($preferred as $t) {
        if (isset($map[$t]) && ! isset($emitted[$t])) {
            $out .= $map[$t];
            $emitted[$t] = true;
        }
    }

    foreach ($originalNames as $t) {
        if (isset($map[$t]) && ! isset($emitted[$t])) {
            $out .= $map[$t];
            $emitted[$t] = true;
        }
    }

    return $out.$epilogue;
}

// --- CLI : normaliser un fichier déjà produit ---
if (isset($argv[1], $argv[2]) && $argv[1] === '--normalize') {
    $path = $argv[2];
    if (! is_file($path)) {
        fwrite(STDERR, "Fichier introuvable : {$path}\n");
        exit(1);
    }
    $full = file_get_contents($path);
    if ($full === false) {
        fwrite(STDERR, "Lecture impossible : {$path}\n");
        exit(1);
    }
    [$doc, $body] = split_dump_doc_and_body($full);
    $body = normalize_mysqldump_body($body);
    file_put_contents($path, $doc.$body);
    echo "Normalisé : {$path}\n";
    exit(0);
}

$raw = $dir.'/tothy_mbengela_full_new.sql';
$out = $dir.'/tothy_mbengela_full.sql';

if (! is_file($raw)) {
    fwrite(STDERR, "Fichier manquant : {$raw}. Lancez d’abord mysqldump.\n");
    exit(1);
}

$iso = (new DateTimeImmutable('now', new DateTimeZone('UTC')))->format('Y-m-d\TH:i:s\Z');

$header = <<<HDR
-- -----------------------------------------------------------------
-- Export MySQL — Alliance / Ministère Tothy Mbengela
-- Généré le {$iso}
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
-- phpMyAdmin : importer le fichier entier (ordre des tables + SET FOREIGN_KEY_CHECKS).
-- Sur hébergement : sélectionnez votre base puis importez, ou remplacez le nom de base dans CREATE DATABASE / USE.
--
-- Catalogue vidéos / playlists (source MinistryYoutubeSeeder) :
--   database/data/tothy_mbengela_youtube.php
-- -----------------------------------------------------------------

HDR;

$body = file_get_contents($raw);
if ($body === false) {
    fwrite(STDERR, "Lecture impossible : {$raw}\n");
    exit(1);
}

$body = normalize_mysqldump_body($body);
file_put_contents($out, $header.$body);

echo "Écrit : {$out} (en-tête + dump normalisé)\n";
