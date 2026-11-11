<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';

// 1. Vaciar los datos de la sesión.
$_SESSION = [];

// 2. Borrar también la cookie PHPSESSID del navegador.
$cookieParams = session_get_cookie_params();
setcookie(session_name(), '', [
    'expires'  => time() - 3600,
    'path'     => $cookieParams['path'],
    'domain'   => $cookieParams['domain'],
    'secure'   => $cookieParams['secure'],
    'httponly' => true,
    'samesite' => 'Lax',
]);

// 3. Destruir la sesión en el servidor.
session_destroy();

header('Location: login.php');
exit;