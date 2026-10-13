<?php
/**
 * Acceso independiente para altas de miniaturas.
 * Nunca consulta main_users ni acepta credenciales antiguas.
 */
declare(strict_types=1);

if (PHP_SAPI !== 'cli' && !defined('DND_MINI_ADMIN_INCLUDED')) {
    http_response_code(404);
    exit;
}

function dnd_mini_config_path(): string
{
    // En la Raspberry: /mnt/ssd/dnd-miniatures-auth.php, FUERA de /mnt/ssd/html/.
    return dirname(__DIR__, 3) . '/dnd-miniatures-auth.php';
}

function dnd_mini_admin_config(): ?array
{
    $path = dnd_mini_config_path();
    if (!is_file($path) || !is_readable($path)) {
        return null;
    }
    $config = require $path;
    if (!is_array($config)
        || !isset($config['persona'], $config['hash'])
        || !is_string($config['persona'])
        || !is_string($config['hash'])) {
        return null;
    }
    return $config;
}

function dnd_mini_on_lan(?string $ip = null): bool
{
    $ip = $ip ?? (string)($_SERVER['REMOTE_ADDR'] ?? '');
    // Deliberadamente restringido a la LAN de esta instalación y loopback.
    return in_array($ip, ['127.0.0.1', '::1'], true)
        || (bool)preg_match('/\A192\.168\.1\.(?:[0-9]{1,3})\z/', $ip)
            && filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false;
}

function dnd_mini_csrf_token(): string
{
    if (!isset($_SESSION['dnd_mini_csrf']) || !is_string($_SESSION['dnd_mini_csrf'])) {
        $_SESSION['dnd_mini_csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['dnd_mini_csrf'];
}

function dnd_mini_csrf_valid(mixed $token): bool
{
    return is_string($token)
        && isset($_SESSION['dnd_mini_csrf'])
        && hash_equals($_SESSION['dnd_mini_csrf'], $token);
}

function dnd_mini_authenticated(): bool
{
    $since = (int)($_SESSION['dnd_mini_active_at'] ?? 0);
    return ($_SESSION['dnd_mini_authenticated'] ?? false) === true
        && $since > 0 && $since > time() - 1800;
}

function dnd_mini_price_cents(mixed $value): ?int
{
    if (!is_string($value) || !preg_match('/\A(0|[1-9][0-9]{0,6})(?:[.,]([0-9]{1,2}))?\z/', trim($value), $match)) {
        return null;
    }
    return (int)$match[1] * 100 + (int)str_pad($match[2] ?? '0', 2, '0');
}

function dnd_mini_schema_ready(mysqli $link): bool
{
    try {
        $res = mysqli_query($link, "SHOW COLUMNS FROM dnd_miniatures LIKE 'id'");
        if (!$res instanceof mysqli_result) {
            return false;
        }
        $col = mysqli_fetch_assoc($res);
        mysqli_free_result($res);
        return is_array($col)
            && ($col['Key'] ?? '') === 'PRI'
            && str_contains(strtolower((string)($col['Extra'] ?? '')), 'auto_increment');
    } catch (Throwable $e) {
        error_log('Ad Infinitum: fallo al comprobar esquema de miniaturas.');
        return false;
    }
}

function dnd_mini_validate_photo(mixed $image): ?string
{
    if (!is_array($image) || ($image['error'] ?? -1) !== UPLOAD_ERR_OK
        || !isset($image['tmp_name'], $image['size'])
        || !is_string($image['tmp_name'])
        || (int)$image['size'] < 100
        || (int)$image['size'] > 5 * 1024 * 1024
        || !is_uploaded_file($image['tmp_name'])) {
        return 'Selecciona una fotografía JPEG de hasta 5 MB.';
    }
    $file = $image['tmp_name'];
    $info = @getimagesize($file);
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($file);
    if (!$info || ($info[2] ?? null) !== IMAGETYPE_JPEG || $mime !== 'image/jpeg'
        || $info[0] < 16 || $info[1] < 16
        || $info[0] > 5000 || $info[1] > 5000) {
        return 'La fotografía debe ser un JPEG válido (16–5000 píxeles por lado).';
    }
    return null;
}

/**
 * Alta limitada al esquema declarado y a fotografías JPEG.
 * Devuelve ['id' => ...] o ['error' => ...] sin divulgar errores de SQL.
 * Se invoca exclusivamente tras la autenticación y comprobación CSRF de la vista.
 */
function dnd_mini_insert(mysqli $link, array $post, mixed $photo): array
{
    if (!dnd_mini_schema_ready($link)) {
        return ['error' => 'La tabla aún no tiene ID autoincremental. Alta desactivada hasta preparar la base de datos.'];
    }

    $name = trim((string)($post['name'] ?? ''));
    $collection = trim((string)($post['collection'] ?? ''));
    $avatar = trim((string)($post['avatar'] ?? ''));
    $infotext = trim((string)($post['infotext'] ?? ''));
    $externalId = (string)($post['id_mini'] ?? '');
    $priceCents = dnd_mini_price_cents($post['price'] ?? '');

    if ($name === '' || strlen($name) > 100 || strlen($collection) > 100
        || strlen($avatar) > 100 || strlen($infotext) > 5000
        || !preg_match('/\A[0-9]{1,10}\z/', $externalId)
        || (float)$externalId > 2147483647 || $priceCents === null) {
        return ['error' => 'Comprueba el nombre, referencia, precio y longitud de los textos.'];
    }

    $badPhoto = dnd_mini_validate_photo($photo);
    if ($badPhoto !== null) {
        return ['error' => $badPhoto];
    }

    $directory = dirname(__DIR__) . '/media/figurine';
    if (!is_dir($directory) || !is_writable($directory)) {
        return ['error' => 'El servidor web no tiene permiso para guardar imágenes en media/figurine/.'];
    }

    $random = bin2hex(random_bytes(12));
    $picture = 'mini-' . $random;
    $url = 'mini-' . substr($random, 0, 12);
    $dest = $directory . '/' . $picture . '.jpg';
    $externalIdInt = (int)$externalId;
    $date = date('Y-m-d');
    $transaction = false;
    $savedFile = false;

    try {
        if (!mysqli_begin_transaction($link)) {
            throw new RuntimeException('transaction');
        }
        $transaction = true;
        $sql = 'INSERT INTO dnd_miniatures (url,id_mini,name,price,collection,picture,infotext,avatar,date) '
            . 'VALUES (?,?,?,?,?,?,?,?,?)';
        $stmt = mysqli_prepare($link, $sql);
        if (!$stmt instanceof mysqli_stmt) {
            throw new RuntimeException('prepare');
        }
        if (!mysqli_stmt_bind_param(
            $stmt, 'sisisssss',
            $url, $externalIdInt, $name, $priceCents, $collection,
            $picture, $infotext, $avatar, $date
        ) || !mysqli_stmt_execute($stmt)) {
            throw new RuntimeException('insert');
        }
        $id = (int)mysqli_insert_id($link);
        mysqli_stmt_close($stmt);
        if ($id < 1) {
            throw new RuntimeException('auto_increment');
        }
        if (!move_uploaded_file($photo['tmp_name'], $dest)) {
            throw new RuntimeException('image');
        }
        $savedFile = true;
        @chmod($dest, 0644);
        if (!mysqli_commit($link)) {
            throw new RuntimeException('commit');
        }
        return ['id' => $id];
    } catch (Throwable $e) {
        if ($transaction) {
            @mysqli_rollback($link);
        }
        if ($savedFile && is_file($dest)) {
            @unlink($dest);
        }
        error_log('Ad Infinitum: no se pudo insertar miniatura (' . $e->getMessage() . ').');
        return ['error' => 'No se pudo guardar la miniatura. Comprueba los permisos y los registros del servidor.'];
    }
}
