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