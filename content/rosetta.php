<?php
/**
 * Private MariaDB connection for Ad Infinitum.
 *
 * Credential values are deliberately NOT stored in the public repository.
 * Read docs/CONFIGURACION_BD_PRIVADA.md before deploying this change.
 */
include_once(__DIR__ . '/mysql_compat.php');
include_once(__DIR__ . '/stone.php');

$configPath = getenv('AD_INFINITUM_DB_CONFIG');
if (!is_string($configPath) || $configPath === '') {
    // On the Raspberry: /mnt/ssd/private/ad-infinitum-db.php
    // when the application lives at /mnt/ssd/html/dnd.
    $configPath = dirname(__DIR__, 3) . '/private/ad-infinitum-db.php';
}
if (!is_file($configPath) || !is_readable($configPath)) {
    error_log('Ad Infinitum: private MariaDB configuration is missing or unreadable.');
    http_response_code(503);
    exit('Servicio temporalmente no disponible.');
}

$dbConfig = require $configPath;
if (!is_array($dbConfig) ||
    !isset($dbConfig['user'], $dbConfig['password'], $dbConfig['database'])) {
    error_log('Ad Infinitum: incomplete private MariaDB configuration.');
    http_response_code(503);
    exit('Servicio temporalmente no disponible.');
}

$dbHost = (string) ($dbConfig['host'] ?? 'localhost');
$dbUser = (string) $dbConfig['user'];
$dbPassword = (string) $dbConfig['password'];
$bdd = (string) $dbConfig['database'];
$dbPort = (int) ($dbConfig['port'] ?? 3306);

try {
    $link = new mysqli($dbHost, $dbUser, $dbPassword, $bdd, $dbPort);
    if (!mysqli_set_charset($link, 'utf8mb4')) {
        throw new RuntimeException('Could not set utf8mb4 character set.');
    }
} catch (Throwable $exception) {
    error_log('Ad Infinitum: MariaDB connection or charset initialization failed.');
    http_response_code(503);
    exit('Servicio temporalmente no disponible.');
}
$GLOBALS['__mysql_compat_link'] = $link;
unset($dbConfig, $dbHost, $dbUser, $dbPassword, $dbPort, $configPath);
