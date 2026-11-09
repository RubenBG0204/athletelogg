<?php
declare(strict_types=1);

// Fichero de arranque: todas las páginas lo cargan primero.
// Las rutas con __DIR__ evitan errores según desde dónde se ejecute el script.
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/data.php';
require_once __DIR__ . '/components.php';