# Régénère database/dumps/tothy_mbengela_full.sql depuis la base du .env
# Usage (racine du projet) : powershell -ExecutionPolicy Bypass -File database/dumps/regenerate-from-local-mysql.ps1

$ErrorActionPreference = "Stop"
$root = Resolve-Path (Join-Path $PSScriptRoot "..\..")
Set-Location $root

$mysqldumpCandidates = @(
    "C:\laragon\bin\mysql\mysql-8.4.3-winx64\bin\mysqldump.exe",
    "C:\laragon\bin\mysql\mysql-8.0.30-winx64\bin\mysqldump.exe",
    "C:\xampp\mysql\bin\mysqldump.exe"
)
$mysqldump = $mysqldumpCandidates | Where-Object { Test-Path $_ } | Select-Object -First 1
if (-not $mysqldump) {
    Write-Error "mysqldump.exe introuvable. Éditez ce script pour indiquer le chemin MySQL."
}

$cfgJson = php -r "require 'vendor/autoload.php'; `$a=require 'bootstrap/app.php'; `$a->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap(); `$c=config('database.connections.mysql'); echo json_encode(['host'=>`$c['host'],'port'=>(string)(`$c['port']??3306),'database'=>`$c['database'],'username'=>`$c['username'],'password'=>(string)(`$c['password']??'')]);"
$cfg = $cfgJson | ConvertFrom-Json

$raw = Join-Path $root "database\dumps\tothy_mbengela_full_new.sql"
$dumpArgs = @(
    "-h$($cfg.host)",
    "-P$($cfg.port)",
    "-u$($cfg.username)"
)
if ($cfg.password) {
    $dumpArgs += "-p$($cfg.password)"
}
$dumpArgs += @(
    "--default-character-set=utf8mb4",
    "--single-transaction",
    "--set-charset",
    "--databases",
    $cfg.database,
    "-r",
    $raw
)

& $mysqldump @dumpArgs
if ($LASTEXITCODE -ne 0) { exit $LASTEXITCODE }

php database/dumps/build_full_dump.php
Remove-Item -Force $raw
Write-Host "OK : database/dumps/tothy_mbengela_full.sql"
