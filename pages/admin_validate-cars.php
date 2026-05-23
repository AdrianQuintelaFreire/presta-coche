<?php
session_start();
$title = 'Panel Admin';
$currentPage = 'validate-cars';
require __DIR__ . '/../includes/admin_header.php';

// Si no está logueado o si está logueado pero NO es admin, fuera.
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: /prestacoche/public/login.php");
    exit();
}

require_once __DIR__ . '/../config/conexion.php';

/*
|--------------------------------------------------------------------------
| Obtener vehículos pendientes
|--------------------------------------------------------------------------
*/

$sql = "SELECT *
        FROM vehiculos
        WHERE estado = 'pendente'
        ORDER BY matricula DESC";

$params = [];

$stmt = $conexion->prepare($sql);
$stmt->execute($params);

$vehiculos = $stmt->fetchAll();

?>

<main class="admin">

    <?php
    require __DIR__ . '/../includes/admin_aside.php';
    ?>

    <section class="admin-content">

        <header class="admin-content__header">

            <h1 class="admin-content__title">
                Validar vehículos
            </h1>

            <p class="admin-content__subtitle">
                Revisa los coches pendientes
                antes de aprobarlos.
            </p>

        </header>

        <section class="admin-validate-cars">

            <?php if (empty($vehiculos)): ?>

                <div class="admin-validate-cars__empty">

                    No hay vehículos pendientes
                    de validación.

                </div>

            <?php else: ?>

                <?php foreach ($vehiculos as $vehiculo): ?>

                    <article class="admin-validate-cars__card">

                        <div class="admin-validate-cars__left">

                            <h2 class="admin-validate-cars__title">

                                <?= htmlspecialchars($vehiculo['marca']) ?>
                                <?= htmlspecialchars($vehiculo['modelo']) ?>

                            </h2>

                            <div class="admin-validate-cars__meta">

                                <span class="admin-validate-cars__text">

                                    Matrícula:
                                    <?= htmlspecialchars($vehiculo['matricula']) ?>

                                </span>

                                <span class="admin-validate-cars__text">

                                    Año:
                                    <?= htmlspecialchars($vehiculo['año']) ?>

                                </span>

                            </div>

                        </div>

                        <div class="admin-validate-cars__right">

                            <a href="/prestacoche/pages/car-validate.php?matricula=<?= urlencode($vehiculo['matricula']) ?>&from=admin_validate-cars.php"
                                class="admin-validate-cars__button">
                                Ver detalles
                            </a>

                        </div>

                    </article>

                <?php endforeach; ?>

            <?php endif; ?>

        </section>

    </section>

</main>

<?php
require __DIR__ . '/../includes/admin_footer.php';
?>

<script src="/prestacoche/public/js/main.js"></script>
</body>

</HTML>