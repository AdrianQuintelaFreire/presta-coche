<?php

session_start();

$title = 'Validar usuario';
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
| Conexión
|--------------------------------------------------------------------------
*/

require_once __DIR__ . '/../config/conexion.php';

/*
|--------------------------------------------------------------------------
| Obtener ID usuario
|--------------------------------------------------------------------------
*/

$id_usuario = $_GET['id'] ?? '';

if (empty($id_usuario)) {

    header("Location: /prestacoche/pages/admin_validate-users.php");
    exit();

}

/*
|--------------------------------------------------------------------------
| Obtener usuario
|--------------------------------------------------------------------------
*/

$sql = "SELECT *
        FROM usuarios
        WHERE id = :id";

$stmt = $conexion->prepare($sql);

$stmt->execute([
    ':id' => $id_usuario
]);

$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {

    header("Location: /prestacoche/pages/admin_validate-users.php");
    exit();

}

?>

<main class="admin">

    <?php require __DIR__ . '/../includes/admin_aside.php'; ?>

    <section class="admin-content">

        <header class="admin-content__header">

            <h1 class="admin-content__title">
                Validar usuario
            </h1>

            <p class="admin-content__subtitle">
                Revisa la documentación y valida el usuario.
            </p>

        </header>

        <section class="user-validate">

            <div class="user-validate__card">

                <h2 class="user-validate__title">
                    Información personal
                </h2>

                <div class="user-validate__grid">

                    <div class="user-validate__item">
                        <span class="user-validate__label">
                            Nombre
                        </span>

                        <span class="user-validate__value">
                            <?= htmlspecialchars($usuario['nome']) ?>
                        </span>
                    </div>

                    <div class="user-validate__item">
                        <span class="user-validate__label">
                            Apellidos
                        </span>

                        <span class="user-validate__value">
                            <?= htmlspecialchars($usuario['apelidos']) ?>
                        </span>
                    </div>

                    <div class="user-validate__item">
                        <span class="user-validate__label">
                            Email
                        </span>

                        <span class="user-validate__value">
                            <?= htmlspecialchars($usuario['email']) ?>
                        </span>
                    </div>

                    <div class="user-validate__item">
                        <span class="user-validate__label">
                            DNI
                        </span>

                        <span class="user-validate__value">
                            <?= htmlspecialchars($usuario['DNI']) ?>
                        </span>
                    </div>

                    <div class="user-validate__item">
                        <span class="user-validate__label">
                            Teléfono
                        </span>

                        <span class="user-validate__value">
                            <?= htmlspecialchars($usuario['telefono']) ?>
                        </span>
                    </div>

                    <div class="user-validate__item">
                        <span class="user-validate__label">
                            Fecha nacimiento
                        </span>

                        <span class="user-validate__value">
                            <?= htmlspecialchars($usuario['data_nacemento']) ?>
                        </span>
                    </div>

                    <div class="user-validate__item">
                        <span class="user-validate__label">
                            Dirección
                        </span>

                        <span class="user-validate__value">
                            <?= htmlspecialchars($usuario['direccion']) ?>
                        </span>
                    </div>

                    <div class="user-validate__item">
                        <span class="user-validate__label">
                            Caducidad DNI
                        </span>

                        <span class="user-validate__value">
                            <?= htmlspecialchars($usuario['fecha_caducidad_dni']) ?>
                        </span>
                    </div>

                </div>

            </div>

            <div class="user-validate__documents">

                <article class="user-validate__document">

                    <h2 class="user-validate__document-title">
                        DNI / NIE
                    </h2>

                    <img src="/prestacoche/storage/id/<?= htmlspecialchars($usuario['foto_dni']) ?>" alt="Foto DNI"
                        class="user-validate__image">

                </article>

                <article class="user-validate__document">

                    <h2 class="user-validate__document-title">
                        Permiso de conducir
                    </h2>

                    <img src="/prestacoche/storage/license/<?= htmlspecialchars($usuario['permiso_conducir']) ?>"
                        alt="Permiso conducir" class="user-validate__image">

                </article>

            </div>

            <div class="user-validate__actions">

                <a href="/prestacoche/actions/validate-user.php?id=<?= urlencode($usuario['id']) ?>"
                    class="user-validate__button user-validate__button--success">

                    Validar usuario

                </a>

                <a href="/prestacoche/actions/delete-user.php?id=<?= urlencode($usuario['id']) ?>"
                    class="user-validate__button user-validate__button--danger">

                    Eliminar usuario

                </a>

            </div>

        </section>

    </section>

</main>

<footer class="footer-admin"></footer>

<script src="/prestacoche/public/js/main.js"></script>
</body>

</HTML>