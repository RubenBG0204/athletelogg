<?php
declare(strict_types=1);

/**
 * Pinta una tabla HTML con una lista de deportes.
 */
function renderSportsTable(array $sports, string $title): void
{
    ?>
    <h2><?= e($title) ?></h2>
    <table class="data-table">
        <thead>
            <tr>
                <th>Clave</th>
                <th>Deporte</th>
                <th>Unidad</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sports as $key => $sport): ?>
                <tr>
                    <td><?= e($key) ?></td>
                    <td><?= e($sport['name']) ?></td>
                    <td><?= e($sport['unit']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php
}

/**
 * Pinta el mensaje de error de un campo (si lo tiene), junto al campo.
 */
function renderFieldError(array $errors, string $field): void
{
    if (isset($errors[$field])) {
        echo '<span class="field-error">' . e($errors[$field]) . '</span>';
    }
}

/**
 * Pinta la tabla de entrenamientos (un array de arrays asociativos).
 */
function renderTrainingsTable(array $trainings): void
{
    ?>
    <table class="data-table">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Tipo</th>
                <th>Duración (min)</th>
                <th>RPE</th>
                <th>Carga</th>
                <th>Sensaciones</th>
                <th>Lesión</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($trainings as $training): ?>
                <tr>
                    <td><?= e($training['date']) ?></td>
                    <td><?= e(SESSION_TYPES[$training['type']]) ?></td>
                    <td><?= e((string) $training['duration']) ?></td>
                    <td><?= e((string) $training['rpe']) ?></td>
                    <td><?= e((string) calculateLoad($training['duration'], $training['rpe'])) ?></td>
                    <td><?= e($training['notes']) ?></td>
                    <td><?= $training['injury'] === '' ? '-' : e($training['injury']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php
}