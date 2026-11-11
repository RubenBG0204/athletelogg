<?php
declare(strict_types=1);

// Enlaces comunes a todos los visitantes


$navItems = [
    'index.php'       => 'Inicio',
    'sports.php'      => 'Deportes',
];

// Resto del menú dependiendo si hay o no sessión iniciada
if (isLoggedIn()) {
    $navItems['training.php']    = 'Nuevo entrenamiento';
    $navItems['history.php']     = 'Historial';
    $navItems['preferences.php'] = 'Preferencias';
    $navItems['logout.php']      = 'Cerrar sesión';
} else {
    $navItems['register.php'] = 'Registro';
    $navItems['login.php']    = 'Login';
}
?>

<nav class="navbar">
    <span class="navbar-brand"><?= e(APP_NAME) ?></span>
    <ul class="navbar-list">
        <?php if (isLoggedIn()): ?>
            <li class="navbar-user">Hola, <?= e($_SESSION['user']['name']) ?></li>
        <?php endif; ?>

        <?php foreach ($navItems as $file => $label): ?>
            <li>
                <a href="<?= e($file) ?>"
                   class="<?= isActivePage($file) ? 'active' : '' ?>">
                    <?= e($label) ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>