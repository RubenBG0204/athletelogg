<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';

/** @var array $users Definido en includes/data.php */

// Si ya está autenticado, no tiene sentido mostrar login
if (isLoggedIn()){
    header('Location: index.php');
    exit;
}

$pageTitle = 'Login';
$username  = '';
$error     = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim(getPostString('username'));
    $password = getPostString('password');

    // Una sola comprobación para los dos casos (usuario inexistente o contraseña
    // incorrecta): así el mensaje no revela cuál de los dos falló.
    if (isset($users[$username])
        && password_verify($password, $users[$username]['password_hash'])
    ) {
        // Nuevo ID de sesión al autenticarse: evita la fijación de sesión.
        session_regenerate_id(true);

        $_SESSION['user'] = [
            'username' => $username,
            'name'     => $users[$username]['name'],
            'sport'    => $users[$username]['sport'],
        ];

        header('Location: index.php');
        exit;
    }

    $error = 'Usuario o contraseña incorrectos';
}

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

<main class="content">
    <h1>Iniciar sesión</h1>

    <?php if ($error !== ''): ?>
        <div class="error-box"><?= e($error) ?></div>
    <?php endif; ?>

    <form method="post" action="login.php" class="form" novalidate>
        <div class="form-group">
            <label for="username">Usuario</label>
            <input type="text" id="username" name="username"
                   value="<?= e($username) ?>">
        </div>

        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password">
        </div>

        <button type="submit" class="btn">Entrar</button>
    </form>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>