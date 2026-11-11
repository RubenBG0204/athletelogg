<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';

requireLogin();

$pageTitle = 'Preferencias';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>
<main class="content">
    <h1>Preferencias</h1>
    <p>Próximamente: preferencias de la aplicación.</p>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>