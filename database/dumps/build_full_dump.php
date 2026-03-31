<?php

/**
 * Fusionne l’en-tête documentaire avec le dump mysqldump brut.
 * Usage (après mysqldump vers tothy_mbengela_full_new.sql) :
 *   php database/dumps/build_full_dump.php
 */
declare(strict_types=1);

$dir = __DIR__;
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
--
-- Catalogue vidéos / playlists (source MinistryYoutubeSeeder) :
--   database/data/tothy_mbengela_youtube.php
-- -----------------------------------------------------------------

HDR;

file_put_contents($out, $header.file_get_contents($raw));

echo "Écrit : {$out} (".strlen($header).' octets d’en-tête + dump)'."\n";
