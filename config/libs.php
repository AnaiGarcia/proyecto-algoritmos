<?php

require __DIR__ . '/../vendor/autoload.php';

date_default_timezone_set('America/Lima');

$baseDir = __DIR__ . '/../';
$dotenv = Dotenv\Dotenv::createImmutable($baseDir);
$envFile = $baseDir . '.env';
if (file_exists($envFile)) {
    $dotenv->load();
}