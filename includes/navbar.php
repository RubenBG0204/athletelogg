<?php
declare(strict_types=1);

// Clave = fichero destino, valor = texto del enlace.
$navItems = [
    'index.php'       => 'Inicio',
    'register.php'    => 'Registro',
    'login.php'       => 'Login',
    'training.php'    => 'Nuevo entrenamiento',
    'history.php'     => 'Historial',
    'preferences.php' => 'Preferencias',
];
?>

<nav class="navbar">
    <span class="navbar-brand"><?= e(APP_NAME) ?></span>
    <ul class="navbar-list">
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