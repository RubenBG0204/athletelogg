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

/**
 * Devuelve solo los deportes de una categoría ('individual' o 'equipo').
 * Conserva las claves originales para poder seguir usándolas como identificador.
 */
function getSportsByCategory(array $sports, string $category): array
{
    $filteredSports = [];

    foreach ($sports as $key => $sport) {
        if ($sport['category'] === $category) {
            // Se guarda con la misma clave que tenía en el array original.
            $filteredSports[$key] = $sport;
        }
    }

    return $filteredSports;
}