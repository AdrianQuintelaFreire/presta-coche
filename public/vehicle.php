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
?>

<!DOCTYPE html>
<HTML lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del <?= htmlspecialchars($coche['marca'] . " " . $coche['modelo']) ?></title>
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>

<body>
    <header class="header">
        <nav class="nav">
            <a href="../public/index.php" class="nav__logo">
                <img src="./img/logo_prestacoche.png" alt="Logotipo de PrestaCoche" class="nav__img">
            </a>
            <input type="checkbox" id="menu-toggle" class="nav__checkbox">
            <label for="menu-toggle" class="nav__label">
                <span class="nav__hamburger"></span>
            </label>
            <div class="nav-secondary">
                <ul class="menu menu--secondary">
                    <li class="menu__item"><a href="../public/our-cars.php" class="menu__link">Nuestros coches</a></li>
                    <li class="menu__item"><a href="../public/how-it-works.php" class="menu__link">¿Cómo funciona?</a>
                    </li>
                </ul>
                <div class="nav-secondary__actions">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <span class="user-welcome">
                        </span>
                        <div class="account-menu">

                            <button type="button" class="account-menu__button" id="accountButton">
                                Mi cuenta
                                <span class="account-menu__icon">▼</span>
                            </button>

                            <div class="account-menu__dropdown" id="accountDropdown">

                                <a href="./profile.php" class="account-menu__link">
                                    Perfil
                                </a>

                                <a href="./my-booking.php" class="account-menu__link">
                                    Reservas
                                </a>

                                <a href="./my-cars.php" class="account-menu__link">
                                    Coches
                                </a>

                                <a href="./logout.php" class="account-menu__link">
                                    Cerrar sesión
                                </a>

                            </div>

                        </div>
                    <?php else: ?>
                        <a href="./login.php" class="btn btn--primary">
                            Iniciar Sesión
                        </a>
                    <?php endif; ?>
                    <a href="./rent-your-car.php" class="btn btn--secondary">Alquila tu coche</a>
                </div>
            </div>
            <div class="nav-primary">
                <ul class="menu menu--primary">
                    <li class="menu__item"><a href="../public/our-cars.php" class="menu__link">Nuestros coches</a></li>
                    <li class="menu__item"><a href="../public/how-it-works.php" class="menu__link">¿Cómo funciona?</a>
                    </li>
                </ul>
                <div class="nav-primary__actions">
                    <?php if (isset($_SESSION['user_id'])): ?>

                        <div class="account-menu">

                            <button type="button" class="account-menu__button" id="accountButtonMobile">
                                Mi cuenta
                                <span class="account-menu__icon">▼</span>
                            </button>

                            <div class="account-menu__dropdown" id="accountDropdownMobile">

                                <a href="./profile.php" class="account-menu__link">
                                    Perfil
                                </a>

                                <a href="./my-booking.php" class="account-menu__link">
                                    Reservas
                                </a>

                                <a href="./my-cars.php" class="account-menu__link">
                                    Coches
                                </a>

                                <a href="./logout.php" class="account-menu__link">
                                    Cerrar sesión
                                </a>

                            </div>

                        </div>

                    <?php else: ?>

                        <a href="./login.php" class="btn btn--primary">
                            Iniciar Sesión
                        </a>

                    <?php endif; ?>
                    <a href="./rent-your-car.php" class="btn btn--secondary">Alquila tu coche</a>
                </div>
            </div>
        </nav>
    </header>
    <main class="vehicle">

        <div class="vehicle__container">

            <a href="<?= htmlspecialchars($backUrl) ?>" class="vehicle__back-button">
                ← Volver
            </a>
            <section class="vehicle__content">


                <!-- IZQUIERDA -->
                <article class="vehicle-card">

                    <div class="vehicle-card__image-wrapper">
                        <img src="../storage/car/<?= htmlspecialchars($coche['foto']) ?>"
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

                        <?php if ($usuarioValidado): ?>

                            <form id="reserveForm">
                                <input type="hidden" name="matricula" value="<?= htmlspecialchars($matricula) ?>">
                                <input type="hidden" name="fecha_inicio" value="<?= htmlspecialchars($fecha_inicio) ?>">
                                <input type="hidden" name="fecha_fin" value="<?= htmlspecialchars($fecha_fin) ?>">

                                <button type="submit" class="vehicle-card__button vehicle-card__button--reserve">
                                    Reservar vehículo
                                </button>
                            </form>

                        <?php else: ?>

                            <button class="vehicle-card__button vehicle-card__button--pending" id="pendingValidationButton">

                                Cuenta pendiente de validación

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
    <footer class="footer">

        <div class="footer__follow">
            <h2 class="footer__title">Síguenos</h2>
            <div class="footer__social">
                <img class="footer__social-icon" src="../public/img/logo_linkedin.png" alt="Icono de Linkedin">
                <img class="footer__social-icon" src="../public/img/logo_facebook.png" alt="Icono de Facebook">
                <img class="footer__social-icon" src="../public/img/logo_instagram.png" alt="Icono de Instagram">
            </div>
            <p class="footer__copyright">&copy; 2026 PrestaCoche. Todos los derechos reservados</p>
        </div>

        <div class="footer__menus">
            <div class="footer__menu">
                <h2 class="footer__title">Enlaces</h2>
                <nav>
                    <ul class="footer__list">
                        <li class="footer__item"><a href="./our-cars.php">Nuestros Coches</a></li>
                        <li class="footer__item"><a href="./how-it-works.php">Cómo funciona</a></li>
                    </ul>
                </nav>
            </div>

            <div class="footer__menu">
                <h2 class="footer__title">Legal</h2>
                <nav>
                    <ul class="footer__list">
                        <li class="footer__item"><a href="">Política de Cookies</a></li>
                        <li class="footer__item"><a href="">Política de privacidad</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </footer>
    <script src="./js/vehicle.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
    <script src="./js/main.js"></script>
</body>

</HTML>