<?php
declare(strict_types=1);

/**
 * Escapa un texto para imprimirlo de forma segura en HTML.
 * Se usa siempre que se imprima un dato que pueda venir del usuario,
 * para evitar inyección de HTML/JS (XSS).
 */
function e(string $text): string
{
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

/**
 * Indica si el enlace pertenece a la página actual,
 * para poder resaltarlo en la navbar.
 */
function isActivePage(string $file): bool
{
    return basename($_SERVER['PHP_SELF']) === $file;
}