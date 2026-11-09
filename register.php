<?php
/**
 * name="days[]" hace que PHP reciba los días marcados como un array.
 * Los value de los campos de texto llevan e(): si no, alguien podría escribir "><script> y romper la página.
 * Las contraseñas no llevan value, así que nunca se rellenan.
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';

/** @var array $sports Definido en includes/data.php */
/** @var array $levels Definido en includes/data.php */
/** @var array $weekDays Definido en includes/data.php */

$pageTitle = 'Registro';

// Valores iniciales (formulario vacío).
$input = [
    'full_name'       => '',
    'username'        => '',
    'email'           => '',
    'password'        => '',
    'password_repeat' => '',
    'age'             => '',
    'sport'           => '',
    'level'           => '',
    'days'            => [],
    'privacy'         => false,
];
$errors  = [];
$success = false;

// El mismo fichero procesa el formulario (POST) y lo pinta (GET).
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = [
        'full_name'       => trim(getPostString('full_name')),
        'username'        => trim(getPostString('username')),
        'email'           => trim(getPostString('email')),
        // Las contraseñas no se recortan: los espacios podrían ser intencionados.
        'password'        => getPostString('password'),
        'password_repeat' => getPostString('password_repeat'),
        'age'             => trim(getPostString('age')),
        'sport'           => getPostString('sport'),
        'level'           => getPostString('level'),
        'days'            => getPostArray('days'),
        'privacy'         => isset($_POST['privacy']),
    ];

    $errors  = validateRegistration($input, $sports, $levels, $weekDays);
    $success = count($errors) === 0;
}

// Para el resumen de éxito: nombres legibles de los días marcados.
$selectedDayNames = [];
if ($success) {
    foreach ($input['days'] as $day) {
        $selectedDayNames[] = $weekDays[$day];
    }
}

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>
<main class="content">
    <h1>Registro de deportista</h1>

    <?php if ($success): ?>
        <section class="success-box">
            <h2>¡Registro correcto!</h2>
            <ul>
                <li><strong>Nombre:</strong> <?= e($input['full_name']) ?></li>
                <li><strong>Usuario:</strong> <?= e($input['username']) ?></li>
                <li><strong>Email:</strong> <?= e($input['email']) ?></li>
                <li><strong>Edad:</strong> <?= e($input['age']) ?></li>
                <li><strong>Deporte:</strong> <?= e($sports[$input['sport']]['name']) ?></li>
                <li><strong>Nivel:</strong> <?= e($levels[$input['level']]) ?></li>
                <li><strong>Días:</strong> <?= e(implode(', ', $selectedDayNames)) ?></li>
            </ul>
        </section>
    <?php else: ?>

        <?php if (count($errors) > 0): ?>
            <div class="error-box">
                <p>Revisa los siguientes errores:</p>
                <ul>
                    <?php foreach ($errors as $message): ?>
                        <li><?= e($message) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php /* novalidate: desactiva la validación del navegador para que se vea la del servidor */ ?>
        <form method="post" action="register.php" class="form" novalidate>

            <div class="form-group">
                <label for="full_name">Nombre completo</label>
                <input type="text" id="full_name" name="full_name"
                       value="<?= e($input['full_name']) ?>">
                <?php renderFieldError($errors, 'full_name'); ?>
            </div>

            <div class="form-group">
                <label for="username">Usuario</label>
                <input type="text" id="username" name="username"
                       value="<?= e($input['username']) ?>">
                <?php renderFieldError($errors, 'username'); ?>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email"
                       value="<?= e($input['email']) ?>">
                <?php renderFieldError($errors, 'email'); ?>
            </div>

            <?php /* Las contraseñas nunca llevan value: no se rellenan jamás */ ?>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password">
                <?php renderFieldError($errors, 'password'); ?>
            </div>

            <div class="form-group">
                <label for="password_repeat">Repite la contraseña</label>
                <input type="password" id="password_repeat" name="password_repeat">
                <?php renderFieldError($errors, 'password_repeat'); ?>
            </div>

            <div class="form-group">
                <label for="age">Edad</label>
                <input type="number" id="age" name="age" min="16" max="60"
                       value="<?= e($input['age']) ?>">
                <?php renderFieldError($errors, 'age'); ?>
            </div>

            <div class="form-group">
                <label for="sport">Deporte principal</label>
                <select id="sport" name="sport">
                    <option value="">-- Elige un deporte --</option>
                    <?php foreach ($sports as $key => $sport): ?>
                        <option value="<?= e($key) ?>"
                            <?= $input['sport'] === $key ? 'selected' : '' ?>>
                            <?= e($sport['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php renderFieldError($errors, 'sport'); ?>
            </div>

            <fieldset class="form-group">
                <legend>Nivel competitivo</legend>
                <?php foreach ($levels as $key => $label): ?>
                    <label class="inline-option">
                        <input type="radio" name="level" value="<?= e($key) ?>"
                            <?= $input['level'] === $key ? 'checked' : '' ?>>
                        <?= e($label) ?>
                    </label>
                <?php endforeach; ?>
                <?php renderFieldError($errors, 'level'); ?>
            </fieldset>

            <fieldset class="form-group">
                <legend>Días de entrenamiento</legend>
                <?php foreach ($weekDays as $key => $label): ?>
                    <label class="inline-option">
                        <input type="checkbox" name="days[]" value="<?= e($key) ?>"
                            <?= in_array($key, $input['days'], true) ? 'checked' : '' ?>>
                        <?= e($label) ?>
                    </label>
                <?php endforeach; ?>
                <?php renderFieldError($errors, 'days'); ?>
            </fieldset>

            <div class="form-group">
                <label class="inline-option">
                    <input type="checkbox" name="privacy" value="1"
                        <?= $input['privacy'] ? 'checked' : '' ?>>
                    Acepto el tratamiento de mis datos
                </label>
                <?php renderFieldError($errors, 'privacy'); ?>
            </div>

            <button type="submit" class="btn">Registrarme</button>
        </form>

    <?php endif; ?>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>