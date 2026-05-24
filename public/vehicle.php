<?php

session_start();

// 1. Importamos la conexión
require_once __DIR__ . '/../config/conexion.php';

// 2. Recogemos la matrícula de la URL (GET)
// Usamos el operador null coalescing (??) para evitar errores si no existe
$matricula = $_GET['matricula'] ?? '';

if (empty($matricula)) {
    // Si alguien entra a vehicle.php sin matrícula, lo mandamos de vuelta
    header('Location: our-cars.php');
    exit;
}

$date_range = $_POST['date_range'] ?? ($_GET['date_range'] ?? '');

$fecha_inicio = '';
$fecha_fin = '';

if (!empty($date_range)) {
    $fechas = explode(" a ", $date_range);

    // si solo viene una fecha → misma fecha inicio y fin
    if (count($fechas) === 1) {
        $fecha_inicio = trim($fechas[0]);
        $fecha_fin = trim($fechas[0]);
    }

    // rango normal
    if (count($fechas) === 2) {
        $fecha_inicio = trim($fechas[0]);
        $fecha_fin = trim($fechas[1]);
    }
}

// 3. Consultamos solo ESE vehículo
$sql = "SELECT * FROM vehiculos WHERE matricula = :matricula AND estado = 'validado' LIMIT 1";
$stmt = $conexion->prepare($sql);
$stmt->execute([':matricula' => $matricula]);
$coche = $stmt->fetch();

// Comprobar si el usuario está validado
$usuarioValidado = false;

if (isset($_SESSION['user_id'])) {

    $sqlUsuario = "SELECT validado FROM usuarios WHERE id = ? LIMIT 1";

    $stmtUsuario = $conexion->prepare($sqlUsuario);

    $stmtUsuario->execute([$_SESSION['user_id']]);

    $usuario = $stmtUsuario->fetch(PDO::FETCH_ASSOC);

    if ($usuario && $usuario['validado'] === 'si') {
        $usuarioValidado = true;
    }
}

$usuarioLogueado = isset($_SESSION['user_id']);

$esMiVehiculo = false;

if (isset($_SESSION['user_id'])) {
    $esMiVehiculo = (
        (int) $coche['id_usuario'] === (int) $_SESSION['user_id']
    );
}

// 4. Si el coche no existe en la base de datos
if (!$coche) {
    die("Lo sentimos, el vehículo con matrícula " . htmlspecialchars($matricula) . " no existe o no está disponible.");
}

$date_range = $_GET['date_range'] ?? '';
$tamano = $_GET['tamano'] ?? '';
$max_precio = $_GET['max_precio'] ?? '';

$backParams = [
    'date_range' => $date_range,
    'tamano' => $tamano,
    'max_precio' => $max_precio
];

$backUrl = './our-cars.php?' . http_build_query($backParams);

$title = 'Detalles del coche';
require __DIR__ . '/../includes/header.php';
?>

<main class="vehicle">

    <div class="vehicle__container">

        <a href="<?= htmlspecialchars($backUrl) ?>" class="vehicle__back-button">
            ← Volver
        </a>
        <section class="vehicle__content">


            <!-- IZQUIERDA -->
            <article class="vehicle-card">

                <div class="vehicle-card__image-wrapper">
                    <img src="/prestacoche/storage/cars/<?= htmlspecialchars($coche['foto']) ?>"
                        alt="<?= htmlspecialchars($coche['marca'] . ' ' . $coche['modelo']) ?>"
                        class="vehicle-card__image">
                </div>

                <div class="vehicle-card__body">

                    <div class="vehicle-card__header">

                        <div>
                            <h1 class="vehicle-card__title">
                                <?= htmlspecialchars($coche['marca']) ?>
                                <?= htmlspecialchars($coche['modelo']) ?>
                            </h1>

                            <p class="vehicle-card__subtitle">
                                <?= ucfirst(htmlspecialchars($coche['combustible'])) ?>
                                ·
                                <?= ucfirst(htmlspecialchars($coche['tipo_cambio'])) ?>
                            </p>
                        </div>

                        <div class="vehicle-card__pricing">
                            <p class="vehicle-card__price-day">
                                <?= htmlspecialchars($coche['precio_dia']) ?>€
                                <span>/día</span>
                            </p>

                            <p class="vehicle-card__price-km">
                                <?= htmlspecialchars($coche['precio_km']) ?>€/km
                            </p>
                        </div>

                    </div>

                    <div class="vehicle-card__details">

                        <div class="vehicle-card__detail">
                            <span class="vehicle-card__label">
                                Kilometraje
                            </span>

                            <span class="vehicle-card__value">
                                <?= number_format($coche['kilometraxe'], 0, ',', '.') ?> km
                            </span>
                        </div>

                        <div class="vehicle-card__detail">
                            <span class="vehicle-card__label">
                                Combustible
                            </span>

                            <span class="vehicle-card__value">
                                <?= ucfirst(htmlspecialchars($coche['combustible'])) ?>
                            </span>
                        </div>

                        <div class="vehicle-card__detail">
                            <span class="vehicle-card__label">
                                Cambio
                            </span>

                            <span class="vehicle-card__value">
                                <?= ucfirst(htmlspecialchars($coche['tipo_cambio'])) ?>
                            </span>
                        </div>

                        <div class="vehicle-card__detail">
                            <span class="vehicle-card__label">
                                Dirección
                            </span>

                            <span class="vehicle-card__value">
                                <?= htmlspecialchars($coche['direccion']) ?>
                            </span>
                        </div>

                    </div>

                    <?php if ($esMiVehiculo): ?>

                        <button class="vehicle-card__button vehicle-card__button--own" disabled>

                            Este vehículo es tuyo

                        </button>

                    <?php elseif ($usuarioValidado): ?>

                        <form id="reserveForm">

                            <input type="hidden" name="matricula" value="<?= htmlspecialchars($matricula) ?>">

                            <input type="hidden" name="fecha_inicio" value="<?= htmlspecialchars($fecha_inicio) ?>">

                            <input type="hidden" name="fecha_fin" value="<?= htmlspecialchars($fecha_fin) ?>">

                            <button type="submit" class="vehicle-card__button vehicle-card__button--reserve">

                                Reservar vehículo

                            </button>

                        </form>

                    <?php elseif ($usuarioLogueado): ?>

                        <button class="vehicle-card__button vehicle-card__button--pending" id="pendingValidationButton">

                            Cuenta pendiente de validación

                        </button>

                    <?php else: ?>

                        <button class="vehicle-card__button vehicle-card__button--pending">

                            Inicia sesión para reservar

                        </button>

                    <?php endif; ?>

                </div>

            </article>

            <!-- DERECHA -->
            <aside class="vehicle-map">

                <h2 class="vehicle-map__title">
                    Ubicación del vehículo
                </h2>

                <iframe class="vehicle-map__iframe" loading="lazy" allowfullscreen
                    src="https://www.google.com/maps?q=<?= urlencode($coche['direccion']) ?>&output=embed">
                </iframe>

            </aside>

        </section>

    </div>

</main>
<div class="validation-popup" id="validationPopup">

    <div class="validation-popup__overlay"></div>

    <div class="validation-popup__content">

        <div class="validation-popup__icon">
            ⏳
        </div>

        <h2 class="validation-popup__title">
            Cuenta pendiente de validación
        </h2>

        <p class="validation-popup__text">
            Tu cuenta todavía no ha sido validada por un administrador.
            Cuando la validación esté completada podrás reservar vehículos.
        </p>

        <button class="vehicle-card__button vehicle-card__button--reserve" id="closeValidationPopup">

            Entendido

        </button>

    </div>

</div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
<script src="/prestacoche/public/js/vehicle.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
<script src="/prestacoche/public/js/main.js"></script>
</body>

</HTML>