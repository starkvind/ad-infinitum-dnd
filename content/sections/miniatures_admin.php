<?php
/**
 * Vista de alta de Miniaturas: no utiliza el sistema main_users de 2015.
 * Solo se incluye desde /dnd/miniatures/admin/ (mediante index.php).
 */
if (!defined('DND_MINI_ADMIN_INCLUDED')) {
    http_response_code(404);
    exit;
}
require_once __DIR__ . '/../miniatures_admin_lib.php';

header('Cache-Control: private, no-store, max-age=0');
$pageTitle2 = 'Miniaturas';
$pageTitle3 = 'Administrar miniaturas';
$miniUrl = $pageRoot . 'miniatures/admin/';
$esc = static fn($value): string => htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$notice = '';
$successId = null;

if (!dnd_mini_on_lan()) {
    http_response_code(403);
    echo '<h2>Acceso restringido</h2><p>Este acceso está reservado a la red local de Ad Infinitum.</p>';
    return;
}

$config = dnd_mini_admin_config();
if ($config === null) {
    http_response_code(503);
    echo '<h2>Administrar miniaturas</h2><p>Acceso pendiente de configurar en la Raspberry.</p>';
    return;
}

$logged = dnd_mini_authenticated();
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    if (!dnd_mini_csrf_valid($_POST['csrf'] ?? null)) {
        $notice = 'La sesión del formulario ha caducado. Recarga la página.';
    } else {
        $action = $_POST['mini_action'] ?? '';
        if ($action === 'login' && !$logged) {
            $until = (int)($_SESSION['dnd_mini_blocked_until'] ?? 0);
            if ($until > time()) {
                $notice = 'Espera un momento antes de volver a intentarlo.';
            } else {
                $persona = (string)($_POST['persona'] ?? '');
                $llave = (string)($_POST['llave'] ?? '');
                $ok = hash_equals($config['persona'], $persona)
                    && password_verify($llave, $config['hash']);
                if ($ok) {
                    session_regenerate_id(true);
                    $_SESSION['dnd_mini_authenticated'] = true;
                    $_SESSION['dnd_mini_active_at'] = time();
                    $_SESSION['dnd_mini_failures'] = 0;
                    unset($_SESSION['dnd_mini_blocked_until']);
                    $_SESSION['dnd_mini_csrf'] = bin2hex(random_bytes(32));
                    header('Location: ' . $miniUrl, true, 303);
                    exit;
                }
                $_SESSION['dnd_mini_failures'] = (int)($_SESSION['dnd_mini_failures'] ?? 0) + 1;
                if ($_SESSION['dnd_mini_failures'] >= 5) {
                    $_SESSION['dnd_mini_blocked_until'] = time() + 120;
                    $_SESSION['dnd_mini_failures'] = 0;
                }
                $notice = 'Persona o llave incorrectas.';
            }
        } elseif ($action === 'logout' && $logged) {
            unset($_SESSION['dnd_mini_authenticated'], $_SESSION['dnd_mini_active_at'], $_SESSION['dnd_mini_csrf']);
            header('Location: ' . $miniUrl, true, 303);
            exit;
        } elseif ($action === 'save' && $logged) {
            $result = dnd_mini_insert($link, $_POST, $_FILES['photograph'] ?? null);
            if (isset($result['id'])) {
                // PRG: evita inserciones duplicadas al recargar.
                $_SESSION['dnd_mini_saved_id'] = (int)$result['id'];
                header('Location: ' . $miniUrl, true, 303);
                exit;
            }
            $notice = (string)($result['error'] ?? 'Error de alta.');
        }
    }
}
if (dnd_mini_authenticated()) {
    $_SESSION['dnd_mini_active_at'] = time();
}
$logged = dnd_mini_authenticated();
$csrf = dnd_mini_csrf_token();
echo '<h2>Administrar miniaturas</h2>';
echo '<p><a href="' . $esc($pageRoot . 'miniatures/') . '">Volver al catálogo</a></p>';
if ($notice !== '') {
    echo '<p role="alert"><strong>' . $esc($notice) . '</strong></p>';
}
if (!$logged) {
    echo '<fieldset><legend>Acceso</legend>';
    echo '<form action="' . $esc($miniUrl) . '" method="post">';
    echo '<input type="hidden" name="csrf" value="' . $esc($csrf) . '">';
    echo '<input type="hidden" name="mini_action" value="login">';
    echo '<p><label>Persona: <input name="persona" required autocomplete="username" maxlength="40"></label></p>';
    echo '<p><label>Llave: <input name="llave" type="password" required autocomplete="current-password"></label></p>';
    echo '<p><button type="submit">Conectarse</button></p>';
    echo '</form></fieldset>';
    return;
}
if (isset($_SESSION['dnd_mini_saved_id'])) {
    $saved = (int)$_SESSION['dnd_mini_saved_id'];
    unset($_SESSION['dnd_mini_saved_id']);
    echo '<p>Miniatura añadida correctamente. <a href="' . $esc($pageRoot . 'miniatures/' . $saved . '/')
        . '">Abrir ficha #' . $saved . '</a>.</p>';
}
echo '<form action="' . $esc($miniUrl) . '" method="post">';
echo '<input type="hidden" name="csrf" value="' . $esc($csrf) . '">';
echo '<input type="hidden" name="mini_action" value="logout">';
echo '<p><button type="submit">Desconectarse</button></p>';
echo '</form>';

if (!dnd_mini_schema_ready($link)) {
    echo '<fieldset><legend>Alta de miniaturas</legend>';
    echo '<p><strong>Alta todavía desactivada.</strong> Antes debemos añadir una clave primaria '
        . 'autoincremental a la tabla, con respaldo y autorización. No se ha cambiado ningún dato.</p>';
    echo '</fieldset>';
    return;
}
echo '<fieldset><legend>Nueva miniatura</legend>';
echo '<p>La imagen debe ser JPEG; precio en euros (por ejemplo, 1,95).</p>';
echo '<form action="' . $esc($miniUrl) . '" method="post" enctype="multipart/form-data">';
echo '<input type="hidden" name="csrf" value="' . $esc($csrf) . '">';
echo '<input type="hidden" name="mini_action" value="save">';
echo '<p><label>Nombre: <input name="name" required maxlength="100" value="' . $esc($_POST['name'] ?? '') . '"></label></p>';
echo '<p><label>Referencia de miniatura: <input name="id_mini" inputmode="numeric" pattern="[0-9]+" required value="' . $esc($_POST['id_mini'] ?? '0') . '"></label></p>';
echo '<p><label>Precio (€): <input name="price" required value="' . $esc($_POST['price'] ?? '0') . '"></label></p>';
echo '<p><label>Colección: <input name="collection" maxlength="100" value="' . $esc($_POST['collection'] ?? '') . '"></label></p>';
echo '<p><label>Representa a: <input name="avatar" maxlength="100" value="' . $esc($_POST['avatar'] ?? '') . '"></label></p>';
echo '<p><label>Descripción: <textarea name="infotext" rows="5" maxlength="5000">' . $esc($_POST['infotext'] ?? '') . '</textarea></label></p>';
echo '<p><label>Fotografía (JPEG, máximo 5 MB): '
    . '<input type="file" name="photograph" accept="image/jpeg" capture="environment" required></label></p>';
echo '<p><button type="submit">Guardar miniatura</button></p>';
echo '</form></fieldset>';
