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

/**
 * Lee un campo de texto de $_POST y siempre devuelve un string.
 * Si el cliente manda otra cosa (p. ej. un array), se devuelve '' para
 * que el resto del código no falle: nunca se confía en lo que llega.
 */
function getPostString(string $key): string
{
    if (isset($_POST[$key]) && is_string($_POST[$key])) {
        return $_POST[$key];
    }

    return '';
}

/**
 * Lee un campo múltiple (checkboxes) de $_POST y devuelve un array de strings.
 */
function getPostArray(string $key): array
{
    $values = [];

    if (isset($_POST[$key]) && is_array($_POST[$key])) {
        foreach ($_POST[$key] as $value) {
            if (is_string($value)) {
                $values[] = $value;
            }
        }
    }

    return $values;
}

/**
 * Valida los datos del registro y devuelve un array de errores.
 * Clave = nombre del campo, valor = mensaje. Si está vacío, todo es correcto.
 */
function validateRegistration(array $input, array $sports, array $levels, array $weekDays): array
{
    $errors = [];

    // Nombre completo: no vacío, entre 3 y 50 caracteres.
    $nameLength = mb_strlen($input['full_name']);
    if ($nameLength < 3 || $nameLength > 50) {
        $errors['full_name'] = 'El nombre completo debe tener entre 3 y 50 caracteres.';
    }

    // Usuario: letras, números y _, entre 4 y 15 caracteres.
    // La D final evita que un salto de línea sobrante pase la validación.
    if (preg_match('/^[A-Za-z0-9_]{4,15}$/D', $input['username']) !== 1) {
        $errors['username'] = 'El usuario solo admite letras, números y _ (entre 4 y 15 caracteres).';
    }

    // Email.
    if (filter_var($input['email'], FILTER_VALIDATE_EMAIL) === false) {
        $errors['email'] = 'El email no tiene un formato válido.';
    }

    // Contraseña: mínimo 8 caracteres y las dos iguales.
    if (strlen($input['password']) < 8) {
        $errors['password'] = 'La contraseña debe tener al menos 8 caracteres.';
    } elseif ($input['password'] !== $input['password_repeat']) {
        $errors['password_repeat'] = 'Las contraseñas no coinciden.';
    }

    // Edad: entero entre 16 y 60. Se compara con === false porque 0 también es "falso".
    $age = filter_var($input['age'], FILTER_VALIDATE_INT);
    if ($age === false || $age < 16 || $age > 60) {
        $errors['age'] = 'La edad debe ser un número entre 16 y 60.';
    }

    // Deporte: tiene que existir como clave en $sports.
    if (!array_key_exists($input['sport'], $sports)) {
        $errors['sport'] = 'Selecciona un deporte de la lista.';
    }

    // Nivel: tiene que existir como clave en $levels.
    if (!array_key_exists($input['level'], $levels)) {
        $errors['level'] = 'Selecciona un nivel competitivo.';
    }

    // Días: al menos uno, y todos deben existir en $weekDays.
    if (count($input['days']) === 0) {
        $errors['days'] = 'Marca al menos un día de entrenamiento.';
    } else {
        foreach ($input['days'] as $day) {
            if (!array_key_exists($day, $weekDays)) {
                $errors['days'] = 'Alguno de los días marcados no es válido.';
                break;
            }
        }
    }

    // Aceptación de datos: obligatoria.
    if ($input['privacy'] === false) {
        $errors['privacy'] = 'Debes aceptar el tratamiento de tus datos.';
    }

    return $errors;
}

/**
 * Indica si hay un usuario autenticado en la sesión
 */
function isLoggedIn(): bool
{
    return isset($_SESSION['user']);
}

/**
 * Protege una página: si no hay sesión, redirige al login y corta la ejecución.
 * El exit es imprescindible: sin él, PHP seguiría ejecutando el resto de la
 * página y el contenido privado se enviaría igualmente.
 */
function requireLogin(): void
{
    if (!isLoggedIn()){
        header('Location: login.php');
        exit;
    }
}