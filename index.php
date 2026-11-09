<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';

$pageTitle = 'Inicio';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>
<main class="content">
    <h1>Bienvenido/a a AthleteLog</h1>
    <p>
        AthleteLog es una aplicación web para deportistas de competición.
        Regístrate, inicia sesión, anota tus entrenamientos y consulta tu
        historial para entrenar con método.
    </p>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>