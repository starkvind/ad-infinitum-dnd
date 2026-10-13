<?php
declare(strict_types=1);
define('DND_MINI_ADMIN_INCLUDED', true);
require_once __DIR__ . '/../content/miniatures_admin_lib.php';
$_SESSION = [];
function ok(bool $condition, string $message): void {
    if (!$condition) { throw new RuntimeException($message); }
    echo "OK: {$message}\n";
}
ok(dnd_mini_on_lan('192.168.1.80'), 'Red doméstica permitida');
ok(dnd_mini_on_lan('127.0.0.1'), 'Loopback permitido');
ok(!dnd_mini_on_lan('8.8.8.8'), 'Internet no permitido');
ok(!dnd_mini_on_lan('192.168.11.80'), 'Otra subred no permitida');
ok(!dnd_mini_on_lan('192.168.1.999'), 'IPv4 inválida rechazada');
ok(dnd_mini_price_cents('1,95') === 195, 'Precio español');
ok(dnd_mini_price_cents('19.5') === 1950, 'Precio con punto');
ok(dnd_mini_price_cents('0') === 0, 'Precio cero');
ok(dnd_mini_price_cents('1e9') === null, 'Precio inválido rechazado');
$csrf = dnd_mini_csrf_token();
ok(strlen($csrf) === 64 && dnd_mini_csrf_valid($csrf), 'Token de formulario válido');
ok(!dnd_mini_csrf_valid('incorrecto'), 'CSRF incorrecto rechazado');
ok(!dnd_mini_authenticated(), 'Acceso desactivado por defecto');
ok(str_ends_with(dnd_mini_config_path(), '/dnd-miniatures-auth.php'), 'Config fuera de directorio público');
