<?php
declare(strict_types=1);

// Fichero de arranque: todas las páginas lo cargan primero.
// Las rutas con __DIR__ evitan errores según desde dónde se ejecute el script.
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/data.php';
require_once __DIR__ . '/components.php';

// La sesión se inicia aquí, una sola vez, antes de imprimir nada de HTML.
// httponly: JavaScript no puede leer la cookie de sesión (limita el robo por XSS).
// samesite: el navegador no la envía en peticiones que vienen de otras webs.
if (session_status() === PHP_SESSION_NONE){
    session_set_cookie_params([
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}