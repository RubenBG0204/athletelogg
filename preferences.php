<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';

/** @var array $themes Definido en includes/data.php */
/** @var array $weightUnits Definido en includes/data.php */
/** @var array $preferences Definido en includes/bootstrap.php */

requireLogin();

$pageTitle = 'Preferencias';
$errors    = [];

// El formulario arranca con las preferencias actuales.
$input = [
    'theme'       => $preferences['theme'],
    'weight_unit' => $preferences['weight_unit'],
    'tips'        => $preferences['tips'],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (getPostString('action') === 'reset') {
        // Borrar una cookie = enviarla con caducidad en el pasado.
        foreach (PREFERENCE_COOKIES as $cookieName) {
            setAppCookie($cookieName, '', time() - 3600);
        }

        // Se redirige porque $_COOKIE no se actualiza hasta la siguiente petición:
        // sin redirección, esta misma página se pintaría con el tema antiguo.
        header('Location: preferences.php?status=reset');
        exit;
    }

    $input = [
        'theme'       => getPostString('theme'),
        'weight_unit' => getPostString('weight_unit'),
        'tips'        => isset($_POST['tips']),
    ];

    $errors = validatePreferences($input, $themes, $weightUnits);

    if (count($errors) === 0) {
        $expires = time() + COOKIE_LIFETIME;

        setAppCookie('theme', $input['theme'], $expires);
        setAppCookie('weight_unit', $input['weight_unit'], $expires);
        setAppCookie('tips', $input['tips'] ? '1' : '0', $expires);

        // Misma razón que arriba: redirigir para ver los cambios al instante.
        header('Location: preferences.php?status=saved');
        exit;
    }
}

// Mensaje tras redirigir. Solo se comparan valores fijos: no se imprime nada del usuario.
$status = isset($_GET['status']) && is_string($_GET['status']) ? $_GET['status'] : '';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>
<main class="content">
    <h1>Preferencias</h1>

    <?php if ($status === 'saved'): ?>
        <div class="success-box">Preferencias guardadas.</div>
    <?php elseif ($status === 'reset'): ?>
        <div class="success-box">Preferencias restablecidas.</div>
    <?php endif; ?>

    <?php if (count($errors) > 0): ?>
        <div class="error-box">
            <ul>
                <?php foreach ($errors as $message): ?>
                    <li><?= e($message) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="preferences.php" class="form" novalidate>

        <fieldset class="form-group">
            <legend>Tema</legend>
            <?php foreach ($themes as $key => $label): ?>
                <label class="inline-option">
                    <input type="radio" name="theme" value="<?= e($key) ?>"
                        <?= $input['theme'] === $key ? 'checked' : '' ?>>
                    <?= e($label) ?>
                </label>
            <?php endforeach; ?>
            <?php renderFieldError($errors, 'theme'); ?>
        </fieldset>

        <div class="form-group">
            <label for="weight_unit">Unidad de peso</label>
            <select id="weight_unit" name="weight_unit">
                <?php foreach ($weightUnits as $key => $label): ?>
                    <option value="<?= e($key) ?>"
                        <?= $input['weight_unit'] === $key ? 'selected' : '' ?>>
                        <?= e($label) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php renderFieldError($errors, 'weight_unit'); ?>
        </div>

        <div class="form-group">
            <label class="inline-option">
                <input type="checkbox" name="tips" value="1"
                    <?= $input['tips'] ? 'checked' : '' ?>>
                Mostrar consejos
            </label>
        </div>

        <button type="submit" class="btn">Guardar preferencias</button>
    </form>

    <?php /* Formulario aparte: así el botón de restablecer no envía los campos de arriba */ ?>
    <form method="post" action="preferences.php" class="reset-form">
        <input type="hidden" name="action" value="reset">
        <button type="submit" class="btn btn-secondary">Restablecer preferencias</button>
    </form>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>