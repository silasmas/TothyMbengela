<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use PDO;

class ExportDatabaseSqlCommand extends Command
{
    protected $signature = 'db:export-sql
        {--path= : Chemin du fichier .sql (défaut: database/dumps/tothy_mbengela_full.sql)}
        {--connection=mysql : Nom de la connexion Laravel}';

    protected $description = 'Exporte la base (structure + données) vers un fichier SQL MySQL réimportable.';

    public function handle(): int
    {
        $connName = (string) $this->option('connection');
        $connection = DB::connection($connName);
        $driver = $connection->getDriverName();

        if (! in_array($driver, ['mysql', 'mariadb'], true)) {
            $this->error("Connexion « {$connName} » : pilote « {$driver} » non pris en charge (utilisez mysql/mariadb).");

            return self::FAILURE;
        }

        $defaultPath = database_path('dumps/tothy_mbengela_full.sql');
        $path = $this->option('path') ?: $defaultPath;
        $dir = dirname($path);
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $pdo = $connection->getPdo();
        $database = $connection->getDatabaseName();

        $this->info("Export « {$database} » ({$connName}) vers {$path} …");

        $fh = fopen($path, 'wb');
        if ($fh === false) {
            $this->error("Impossible d’écrire : {$path}");

            return self::FAILURE;
        }

        fwrite($fh, "-- -----------------------------------------------------------------\n");
        fwrite($fh, "-- Export MySQL — ".config('app.name', 'Laravel')."\n");
        fwrite($fh, '-- Généré le '.date('c')."\n");
        fwrite($fh, "-- Base : `{$database}`\n");
        fwrite($fh, "-- Réimport : mysql -u USER -p < ce_fichier.sql\n");
        fwrite($fh, "-- (ajustez le nom de la base ci-dessous si besoin)\n");
        fwrite($fh, "-- -----------------------------------------------------------------\n\n");

        fwrite($fh, "SET NAMES utf8mb4;\n");
        fwrite($fh, "SET FOREIGN_KEY_CHECKS=0;\n");
        fwrite($fh, "SET SQL_MODE='NO_AUTO_VALUE_ON_ZERO';\n\n");

        fwrite($fh, "CREATE DATABASE IF NOT EXISTS `{$database}` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;\n");
        fwrite($fh, "USE `{$database}`;\n\n");

        $tables = $connection->select(
            'SELECT TABLE_NAME AS name FROM information_schema.TABLES WHERE TABLE_SCHEMA = ? AND TABLE_TYPE = \'BASE TABLE\' ORDER BY TABLE_NAME',
            [$database]
        );

        foreach ($tables as $row) {
            $table = $row->name;
            $this->line("  Table `{$table}` …");

            fwrite($fh, "\n-- -----------------------------\n");
            fwrite($fh, "-- Structure : `{$table}`\n");
            fwrite($fh, "-- -----------------------------\n");
            fwrite($fh, "DROP TABLE IF EXISTS `{$table}`;\n");

            $createRow = $connection->selectOne('SHOW CREATE TABLE `'.$this->quoteIdent($table).'`');
            $createKey = 'Create Table';
            $createSql = $createRow->$createKey ?? $createRow->{'Create Table'};
            fwrite($fh, $createSql.";\n\n");

            $columns = $connection->select('SHOW FULL COLUMNS FROM `'.$this->quoteIdent($table).'`');
            $colNames = array_map(fn ($c) => $c->Field, $columns);

            $rowCount = (int) $connection->selectOne('SELECT COUNT(*) AS c FROM `'.$this->quoteIdent($table).'`')->c;
            if ($rowCount === 0) {
                continue;
            }

            fwrite($fh, "-- Données : `{$table}` ({$rowCount} ligne(s))\n");

            $connection->table($table)->orderBy($colNames[0])->chunk(200, function ($rows) use ($fh, $pdo, $table, $colNames) {
                $colsSql = '`'.implode('`,`', array_map([$this, 'quoteIdent'], $colNames)).'`';
                foreach ($rows as $model) {
                    $arr = (array) $model;
                    $vals = [];
                    foreach ($colNames as $cn) {
                        $vals[] = $this->sqlValue($pdo, $arr[$cn] ?? null);
                    }
                    $line = 'INSERT INTO `'.$this->quoteIdent($table)."` ({$colsSql}) VALUES (".implode(',', $vals).");\n";
                    fwrite($fh, $line);
                }
            });
            fwrite($fh, "\n");
        }

        fwrite($fh, "SET FOREIGN_KEY_CHECKS=1;\n");
        fclose($fh);

        $this->info('Terminé : '.number_format(filesize($path) / 1024, 1).' Ko');

        return self::SUCCESS;
    }

    private function quoteIdent(string $ident): string
    {
        return str_replace('`', '``', $ident);
    }

    private function sqlValue(PDO $pdo, mixed $value): string
    {
        if ($value === null) {
            return 'NULL';
        }
        if ($value === true || $value === false) {
            return $value ? '1' : '0';
        }
        if (is_int($value) || is_float($value)) {
            if (is_nan((float) $value)) {
                return 'NULL';
            }

            return (string) $value;
        }
        if ($value instanceof \Stringable) {
            return $pdo->quote((string) $value);
        }
        if (is_resource($value)) {
            return $pdo->quote(stream_get_contents($value) ?: '');
        }

        return $pdo->quote((string) $value);
    }
}
