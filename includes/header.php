<?php
declare(strict_types=1);

/** @var array $preferences Definido en includes/bootstrap.php */

// Si la página no define título, se usa el nombre de la app.
$pageTitle = $pageTitle ?? APP_NAME;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?> | <?= e(APP_NAME)?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="theme-<?= e($preferences['theme']) ?>">
    
</body>
</html>