<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';

requireLogin();

$pageTitle = 'Nuevo entrenamiento';

// Valores iniciales (formulario vacío).
$input = [
    'date'               => '',
    'type'               => '',
    'duration'           => '',
    'rpe'                => '',
    'notes'              => '',
    'has_injury'         => false,
    'injury_description' => '',
];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = [
        'date'               => trim(getPostString('date')),
        'type'               => getPostString('type'),
        'duration'           => trim(getPostString('duration')),
        'rpe'                => getPostString('rpe'),
        'notes'              => trim(getPostString('notes')),
        'has_injury'         => isset($_POST['has_injury']),
        'injury_description' => trim(getPostString('injury_description')),
    ];

    $errors = validateTraining($input);

    if (count($errors) === 0) {
        // Cada entrenamiento es un array asociativo. Duración y RPE se
        // convierten a int porque ya están validados.
        $_SESSION['trainings'][] = [
            'date'     => $input['date'],
            'type'     => $input['type'],
            'duration' => (int) $input['duration'],
            'rpe'      => (int) $input['rpe'],
            'notes'    => $input['notes'],
            'injury'   => $input['has_injury'] ? $input['injury_description'] : '',
        ];

        // Se redirige para que recargar la página (F5) no vuelva a enviar
        // el formulario y duplique el entrenamiento.
        header('Location: training.php?status=saved');
        exit;
    }
}

$trainings = $_SESSION['trainings'] ?? [];
$saved     = isset($_GET['status']) && $_GET['status'] === 'saved';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>
<main class="content">
    <h1>Nuevo entrenamiento</h1>

    <?php if ($saved): ?>
        <div class="success-box">Entrenamiento guardado.</div>
    <?php endif; ?>

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

    <form method="post" action="training.php" class="form" novalidate>

        <div class="form-group">
            <label for="date">Fecha</label>
            <input type="date" id="date" name="date" max="<?= e(date('Y-m-d')) ?>"
                   value="<?= e($input['date']) ?>">
            <?php renderFieldError($errors, 'date'); ?>
        </div>

        <fieldset class="form-group">
            <legend>Tipo de sesión</legend>
            <?php foreach (SESSION_TYPES as $key => $label): ?>
                <label class="inline-option">
                    <input type="radio" name="type" value="<?= e($key) ?>"
                        <?= $input['type'] === $key ? 'checked' : '' ?>>
                    <?= e($label) ?>
                </label>
            <?php endforeach; ?>
            <?php renderFieldError($errors, 'type'); ?>
        </fieldset>

        <div class="form-group">
            <label for="duration">Duración (minutos)</label>
            <input type="number" id="duration" name="duration" min="5" max="360"
                   value="<?= e($input['duration']) ?>">
            <?php renderFieldError($errors, 'duration'); ?>
        </div>

        <fieldset class="form-group">
            <legend>Esfuerzo percibido (RPE, de 1 a 10)</legend>
            <?php foreach (range(1, 10) as $value): ?>
                <label class="inline-option">
                    <input type="radio" name="rpe" value="<?= $value ?>"
                        <?= $input['rpe'] === (string) $value ? 'checked' : '' ?>>
                    <?= $value ?>
                </label>
            <?php endforeach; ?>
            <?php renderFieldError($errors, 'rpe'); ?>
        </fieldset>

        <div class="form-group">
            <label for="notes">Sensaciones (máximo 200 caracteres)</label>
            <textarea id="notes" name="notes" rows="3"><?= e($input['notes']) ?></textarea>
            <?php renderFieldError($errors, 'notes'); ?>
        </div>

        <div class="form-group">
            <label class="inline-option">
                <input type="checkbox" name="has_injury" value="1"
                    <?= $input['has_injury'] ? 'checked' : '' ?>>
                Tengo una lesión o molestia
            </label>
            <label for="injury_description">Descríbela (obligatorio si marcas la casilla)</label>
            <input type="text" id="injury_description" name="injury_description"
                   value="<?= e($input['injury_description']) ?>">
            <?php renderFieldError($errors, 'injury'); ?>
        </div>

        <button type="submit" class="btn">Guardar entrenamiento</button>
    </form>

    <h2>Entrenamientos registrados</h2>

    <?php if (count($trainings) === 0): ?>
        <p>Todavía no has registrado ningún entrenamiento.</p>
    <?php else: ?>
        <?php renderTrainingsTable($trainings); ?>

        <section class="stats-box">
            <h2>Estadísticas</h2>
            <ul>
                <li><strong>Total de sesiones:</strong> <?= e((string) countSessions($trainings)) ?></li>
                <li><strong>Minutos totales:</strong> <?= e((string) getTotalMinutes($trainings)) ?></li>
                <li><strong>RPE medio:</strong> <?= e(number_format(getAverageRpe($trainings), 1, ',', '.')) ?></li>
                <li><strong>Carga total:</strong> <?= e((string) getTotalLoad($trainings)) ?></li>
            </ul>
        </section>
    <?php endif; ?>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>