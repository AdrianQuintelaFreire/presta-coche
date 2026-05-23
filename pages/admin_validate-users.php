<?php

session_start();

$title = 'Panel Admin';
$currentPage = 'validate-users';

require __DIR__ . '/../includes/admin_header.php';

/*
|--------------------------------------------------------------------------
| Seguridad admin
|--------------------------------------------------------------------------
*/

if (
    !isset($_SESSION['rol']) ||
    $_SESSION['rol'] !== 'admin'
) {
    header("Location: /prestacoche/public/login.php");
    exit();
}

/*
|--------------------------------------------------------------------------
| Conexión BD
|--------------------------------------------------------------------------
*/

require_once __DIR__ . '/../config/conexion.php';

/*
|--------------------------------------------------------------------------
| Obtener usuarios pendientes
|--------------------------------------------------------------------------
*/

$sql = "SELECT *
        FROM usuarios
        WHERE validado = 'no'
        ORDER BY id DESC";

$stmt = $conexion->prepare($sql);

$stmt->execute();

$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<main class="admin">

    <?php require __DIR__ . '/../includes/admin_aside.php'; ?>

    <section class="admin-content">

        <header class="admin-content__header">

            <h1 class="admin-content__title">
                Validar usuarios
            </h1>

            <p class="admin-content__subtitle">
                Revisa los usuarios pendientes de validación.
            </p>

        </header>

        <div class="admin-users">

            <?php if (empty($usuarios)): ?>

                <div class="admin-users__empty">

                    <h2 class="admin-users__empty-title">
                        No hay usuarios pendientes
                    </h2>

                    <p class="admin-users__empty-text">
                        Todos los usuarios están validados.
                    </p>

                </div>

            <?php else: ?>

                <?php foreach ($usuarios as $usuario): ?>

                    <article class="admin-users__card">

                        <div class="admin-users__info">

                            <h2 class="admin-users__name">
                                <?= htmlspecialchars($usuario['nome']) ?>
                                <?= htmlspecialchars($usuario['apelidos']) ?>
                            </h2>

                            <p class="admin-users__meta">
                                <?= htmlspecialchars($usuario['email']) ?>
                            </p>

                            <p class="admin-users__meta">
                                DNI:
                                <?= htmlspecialchars($usuario['DNI']) ?>
                            </p>

                        </div>

                        <div class="admin-users__actions">

                            <a href="/prestacoche/pages/user-validate.php?id=<?= urlencode($usuario['id']) ?>"
                                class="admin-users__button">

                                Ver detalles

                            </a>

                        </div>

                    </article>

                <?php endforeach; ?>

            <?php endif; ?>

        </div>

    </section>

</main>

<?php
require __DIR__ . '/../includes/admin_footer.php';
?>

<script src="/prestacoche/public/js/main.js"></script>
</body>

</HTML>