<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /prestacoche/public/login.php");
    exit();
}

require_once '../config/conexion.php';

$id_usuario = $_SESSION['user_id'];

/*
    Obtener coches reservados por el usuario
    sin repetir matrícula
*/
$sql = "
    SELECT DISTINCT
        v.*,
        u.telefono AS telefono_dueno
    FROM vehiculos v
    INNER JOIN vehiculos_disponibilidad vd
        ON v.matricula = vd.matricula
    INNER JOIN usuarios u
        ON v.id_usuario = u.id
    WHERE vd.user_id = ?
    AND vd.disponible = 0
";

$stmt = $conexion->prepare($sql);
$stmt->execute([$id_usuario]);

$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<HTML lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PrestaAuto - Alquiler de Coches</title>
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
    <main class="main-booking">

        <?php if (count($resultado) > 0): ?>

            <?php foreach ($resultado as $v): ?>

                <div class="cars-container">

                    <article class="car-card">

                        <div class="car-card__status car-card__status--reserved">
                            Reservado
                        </div>

                        <div class="car-card__image-wrapper">

                            <img src="../storage/car/<?= htmlspecialchars($v['foto']) ?>"
                                alt="Vehículo <?= htmlspecialchars($v['matricula']) ?>" class="car-card__image">

                        </div>

                        <div class="car-card__content">

                            <p class="car-card__price-day">
                                <?= htmlspecialchars($v['precio_dia']) ?> €/día
                            </p>

                            <p class="car-card__price-km">
                                <?= htmlspecialchars($v['precio_km']) ?> €/km
                            </p>

                            <div class="car-card__details">

                                <p class="car-card__detail">
                                    <span class="car-card__label">
                                        Marca:<br>
                                    </span>
                                    <?= htmlspecialchars($v['marca']) ?>
                                </p>

                                <p class="car-card__detail">
                                    <span class="car-card__label">
                                        Modelo:<br>
                                    </span>
                                    <?= htmlspecialchars($v['modelo']) ?>
                                </p>

                                <p class="car-card__detail">
                                    <span class="car-card__label">
                                        Combustible:<br>
                                    </span>
                                    <?= ucfirst($v['combustible']) ?>
                                </p>

                                <p class="car-card__detail">
                                    <span class="car-card__label">
                                        Cambio:<br>
                                    </span>
                                    <?= ucfirst($v['tipo_cambio']) ?>
                                </p>

                                <p class="car-card__detail">
                                    <span class="car-card__label">
                                        Kilometraje:<br>
                                    </span>
                                    <?= number_format($v['kilometraxe'], 0, ',', '.') ?> km
                                </p>

                                <p class="car-card__detail">
                                    <span class="car-card__label">
                                        Año:<br>
                                    </span>
                                    <?= $v['año'] ?>
                                </p>
                                <p class="car-card__detail">
                                    <span class="car-card__label">
                                        Dirección:<br>
                                    </span>
                                    <?= htmlspecialchars($v['direccion']) ?>
                                </p>
                                <p class="car-card__detail">
                                    <span class="car-card__label">
                                        Teléfono dueño:<br>
                                    </span>

                                    <a href="tel:<?= htmlspecialchars($v['telefono_dueno']) ?>" class="car-card__phone">
                                        <?= htmlspecialchars($v['telefono_dueno']) ?>
                                    </a>
                                </p>

                            </div>

                            <?php
                            $sqlFechas = "
                            SELECT fecha
                            FROM vehiculos_disponibilidad
                            WHERE matricula = ?
                            AND user_id = ?
                            AND disponible = 0
                            ORDER BY fecha ASC
                        ";

                            $stmtFechas = $conexion->prepare($sqlFechas);

                            $stmtFechas->execute([
                                $v['matricula'],
                                $id_usuario
                            ]);

                            $fechasReservadas = $stmtFechas->fetchAll(PDO::FETCH_COLUMN);
                            ?>

                            <div class="booking-dates">

                                <p class="booking-dates__title">
                                    Fechas reservadas
                                </p>

                                <?php foreach ($fechasReservadas as $fecha): ?>

                                    <span class="booking-dates__item">
                                        <?= date('d/m/Y', strtotime($fecha)) ?>
                                    </span>

                                <?php endforeach; ?>

                            </div>
                            <button type="button" class="car-card__button car-card__button--inspect open-booking-modal"
                                data-matricula="<?= htmlspecialchars($v['matricula']) ?>"
                                data-fechas='<?= json_encode($fechasReservadas) ?>'>

                                Modificar fechas
                            </button>

                        </div>

                    </article>

                </div>

            <?php endforeach; ?>

        <?php else: ?>

            <p class="main-booking__empty">
                No tienes reservas activas.
            </p>

        <?php endif; ?>

    </main>
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
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
    <script src="./js/main.js"></script>
    <script src="./js/my-booking.js"></script>
    <!-- Modal reservas -->
    <div class="modal" id="bookingModal">

        <div class="modal__overlay"></div>

        <div class="modal__content modal__content--booking">

            <h2 class="modal__title">
                Reservas del vehículo
            </h2>

            <p class="modal__text">
                Matrícula:
                <span id="bookingMatricula"></span>
            </p>

            <div id="bookingDatesList" class="booking-modal-list">

            </div>

            <div class="modal__actions">

                <button type="button" class="modal__button modal__button--cancel" id="closeBookingModal">

                    Cerrar
                </button>

            </div>

        </div>

    </div>
</body>

</HTML>