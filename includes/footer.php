<?php
declare(strict_types=1);

/** @var int $visitCount Definido en includes/bootstrap.php */

?>
    <footer class="footer">
        <p>&copy; <?= date('Y') ?> <?= e(APP_NAME) ?> · <?= e(STUDENT_NAME) ?></p>
        <p>Visitas: <?= e((string) $visitCount) ?></p>
    </footer>
</body>
</html>