<?php
session_start();

$title = 'Validar vehículo';
$currentPage = 'validate-cars';

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

require_once __DIR__ . '/../config/conexion.php';

/*
|--------------------------------------------------------------------------
| Obtener matrícula
|--------------------------------------------------------------------------
*/

$matricula = $_GET['matricula'] ?? '';

if (empty($matricula)) {

    header(
        "Location: /prestacoche/pages/admin_validate-cars.php"
    );

    exit();
}

/*
|--------------------------------------------------------------------------
| Obtener vehículo
|--------------------------------------------------------------------------
*/

$sql = "SELECT *
        FROM vehiculos
        WHERE matricula = :matricula
        LIMIT 1";

$params = [
    ':matricula' => $matricula
];

$stmt = $conexion->prepare($sql);
$stmt->execute($params);

$vehiculo = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$vehiculo) {

    header(
        "Location: /prestacoche/pages/admin_validate-cars.php"
    );

    exit();
}

?>

<main class="admin">

    <?php
    require __DIR__ . '/../includes/admin_aside.php';
    ?>

    <section class="admin-content">

        <header class="admin-content__header">

            <h1 class="admin-content__title">
                Validar vehículo
            </h1>

            <p class="admin-content__subtitle">
                Revisa cuidadosamente los datos
                antes de aprobar el vehículo.
            </p>

        </header>

        <section class="car-validate">

            <article class="car-validate__card">

                <div class="car-validate__image-wrapper">

                    <img src="/prestacoche/storage/cars/<?= htmlspecialchars($vehiculo['foto']) ?>" alt="Vehículo"
                        class="car-validate__image">

                </div>

                <div class="car-validate__content">

                    <h2 class="car-validate__name">

                        <?= htmlspecialchars($vehiculo['marca']) ?>
                        <?= htmlspecialchars($vehiculo['modelo']) ?>

                    </h2>

                    <div class="car-validate__grid">

                        <div class="car-validate__item">
                            <span class="car-validate__label">
                                Matrícula
                            </span>

                            <span class="car-validate__value">
                                <?= htmlspecialchars($vehiculo['matricula']) ?>
                            </span>
                        </div>

                        <div class="car-validate__item">
                            <span class="car-validate__label">
                                Año
                            </span>

                            <span class="car-validate__value">
                                <?= htmlspecialchars($vehiculo['año']) ?>
                            </span>
                        </div>

                        <div class="car-validate__item">
                            <span class="car-validate__label">
                                Potencia
                            </span>

                            <span class="car-validate__value">
                                <?= htmlspecialchars($vehiculo['potencia']) ?> cv
                            </span>
                        </div>

                        <div class="car-validate__item">
                            <span class="car-validate__label">
                                Tamaño
                            </span>

                            <span class="car-validate__value">
                                <?= htmlspecialchars($vehiculo['tamano']) ?>
                            </span>
                        </div>

                        <div class="car-validate__item">
                            <span class="car-validate__label">
                                Combustible
                            </span>

                            <span class="car-validate__value">
                                <?= htmlspecialchars($vehiculo['combustible']) ?>
                            </span>
                        </div>

                        <div class="car-validate__item">
                            <span class="car-validate__label">
                                Cambio
                            </span>

                            <span class="car-validate__value">
                                <?= htmlspecialchars($vehiculo['tipo_cambio']) ?>
                            </span>
                        </div>

                        <div class="car-validate__item">
                            <span class="car-validate__label">
                                Kilometraje
                            </span>

                            <span class="car-validate__value">
                                <?= htmlspecialchars($vehiculo['kilometraxe']) ?> km
                            </span>
                        </div>

                        <div class="car-validate__item">
                            <span class="car-validate__label">
                                Precio día
                            </span>

                            <span class="car-validate__value">
                                <?= htmlspecialchars($vehiculo['precio_dia']) ?>€
                            </span>
                        </div>

                    </div>

                    <div class="car-validate__actions">

                        <a href="/prestacoche/actions/validate-car.php?matricula=<?= urlencode($vehiculo['matricula']) ?>"
                            class="car-validate__button car-validate__button--success">
                            Validar vehículo
                        </a>

                        <a href="/prestacoche/actions/delete-car.php?matricula=<?= urlencode($vehiculo['matricula']) ?>"
                            class="car-validate__button car-validate__button--danger">
                            Eliminar vehículo
                        </a>

                    </div>

                </div>

            </article>

        </section>

    </section>

</main>

<footer class="footer-admin"></footer>

<script src="/prestacoche/public/js/main.js"></script>
</body>

</HTML>