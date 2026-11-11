<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';

requireLogin();

$pageTitle = 'Nuevo entrenamiento';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>
<main class="content">
    <h1>Nuevo entrenamiento</h1>
    <p>Próximamente: formulario de entrenamientos.</p>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>