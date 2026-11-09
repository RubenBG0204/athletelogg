<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';
/** @var array $sports Definido en includes/data.php */

$pageTitle = 'Deportes';

$individualSports = getSportsByCategory($sports, 'individual');
$teamSports       = getSportsByCategory($sports, 'equipo');

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>
<main class="content">
    <h1>Deportes disponibles</h1>

    <?php renderSportsTable($individualSports, 'Deportes individuales'); ?>
    <?php renderSportsTable($teamSports, 'Deportes de equipo'); ?>

</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>