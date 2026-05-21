<?php

session_start();

require_once __DIR__ . '/../config/conexion.php';

// Filtros
$tamano = $_GET['tamano'] ?? '';
$max_precio = $_GET['max_precio'] ?? '';

$date_range = $_GET['date_range'] ?? '';

$fecha_inicio = '';
$fecha_fin = '';

if (!empty($date_range)) {

    $fechas = explode(" a ", $date_range);

    $fecha_inicio = trim($fechas[0] ?? '');

    $fecha_fin = (count($fechas) === 2)
        ? trim($fechas[1])
        : $fecha_inicio; // si solo hay 1 día, es rango de 1 día
}

$sin_fechas = empty($fecha_inicio) || empty($fecha_fin);
// Consulta base
$sql = "SELECT * FROM vehiculos WHERE estado = 'validado'";
$params = [];

// Disponibilidad
if (!$sin_fechas) {

    $sql .= " AND matricula IN (
        SELECT matricula
        FROM vehiculos_disponibilidad
        WHERE fecha BETWEEN :f_inicio AND :f_fin
        AND disponible = 1
        GROUP BY matricula
        HAVING COUNT(*) = DATEDIFF(:f_fin_diff, :f_inicio_diff) + 1
    )";

    $params[':f_inicio'] = $fecha_inicio;
    $params[':f_fin'] = $fecha_fin;
    $params[':f_inicio_diff'] = $fecha_inicio;
    $params[':f_fin_diff'] = $fecha_fin;
}

// Filtro tamaño
if (!empty($tamano)) {
    $sql .= " AND tamano = :tamano";
    $params[':tamano'] = $tamano;
}

// 🔥 NUEVO: filtro precio máximo
if (!empty($max_precio)) {
    $sql .= " AND precio_dia <= :max_precio";
    $params[':max_precio'] = $max_precio;
}

// 🔥 Obtener rango real de precios (YA CON FECHAS APLICADAS)
$sqlRange = "SELECT MIN(precio_dia) AS min_precio, MAX(precio_dia) AS max_precio
             FROM vehiculos
             WHERE estado = 'validado'";

$paramsRange = [];

// aplicar mismo filtro de fechas
if (!empty($fecha_inicio) && !empty($fecha_fin)) {

    $sqlRange .= " AND matricula IN (
        SELECT matricula
        FROM vehiculos_disponibilidad
        WHERE fecha BETWEEN :f_inicio AND :f_fin
        AND disponible = 1
        GROUP BY matricula
        HAVING COUNT(*) = DATEDIFF(:f_fin_diff, :f_inicio_diff) + 1
    )";

    $paramsRange[':f_inicio'] = $fecha_inicio;
    $paramsRange[':f_fin'] = $fecha_fin;
    $paramsRange[':f_inicio_diff'] = $fecha_inicio;
    $paramsRange[':f_fin_diff'] = $fecha_fin;
}

$stmtRange = $conexion->prepare($sqlRange);
$stmtRange->execute($paramsRange);

$range = $stmtRange->fetch();

$precio_min = (int) $range['min_precio'];
$precio_max = (int) $range['max_precio'];
$max_precio = isset($_GET['max_precio']) && $_GET['max_precio'] !== ''
    ? (float) $_GET['max_precio']
    : $precio_max;

$stmt = $conexion->prepare($sql);
$stmt->execute($params);
$vehiculos = $stmt->fetchAll();

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
    <main class="our-cars">

        <aside class="filter">

            <form action="" method="get" class="filter__form search search--our-cars">

                <!-- FECHAS -->
                <div class="search__group search__group--first">
                    <label for="date-range" class="search__label">Fechas de alquiler</label>
                    <input type="text" id="date-range" name="date_range" class="search__input"
                        placeholder="Selecciona fechas" value="<?= htmlspecialchars($date_range) ?>">
                </div>

                <!-- TAMANO -->
                <div class="search__group search__group--second">

                    <label for="tamano" class="search__label">Tamaño del vehículo</label>
                    <select name="tamano" id="tamano" class="search__select">
                        <option value="" <?= $tamano === '' ? 'selected' : '' ?>>Cualquiera</option>
                        <option value="utilitario" <?= $tamano === 'utilitario' ? 'selected' : '' ?>>Utilitario</option>
                        <option value="mediano" <?= $tamano === 'mediano' ? 'selected' : '' ?>>Mediano</option>
                        <option value="grande" <?= $tamano === 'grande' ? 'selected' : '' ?>>Grande</option>
                    </select>

                </div>

                <!-- 🔥 NUEVO: PRECIO MAXIMO -->
                <div class="search__group">
                    <label for="max_precio" class="search__label">
                        Precio máximo por día:
                        <span id="precioValue"><?= htmlspecialchars($max_precio ?: $precio_max) ?></span> €
                    </label>

                    <input type="range" id="max_precio" name="max_precio" min="<?= $precio_min ?>"
                        max="<?= $precio_max ?>" step="1" value="<?= htmlspecialchars($max_precio ?: $precio_max) ?>"
                        oninput="document.getElementById('precioValue').textContent = this.value"
                        class="search__range" />
                </div>

                <div class="search__button">
                    <button type="submit" class="button">Aplicar</button>
                </div>

            </form>
        </aside>
        <?php if ($sin_fechas): ?>

            <div class="no-dates-message">
                <h2>¿Cuándo quieres conducir? 🚗</h2>
                <p>
                    Selecciona las fechas de recogida y devolución para ver los vehículos disponibles.
                </p>
            </div>

        <?php else: ?>

        <section class="cars">

            <?php if ($vehiculos): ?>
                <?php foreach ($vehiculos as $v): ?>
                    <article class="car-card">

                        <div class="car-card__image-wrapper">
                            <img src="../storage/car/<?= htmlspecialchars($v['foto']) ?>" class="car-card__image">
                        </div>

                        <div class="car-card__content">

                            <p class="car-card__price-day">
                                <?= htmlspecialchars($v['precio_dia']) ?> €/día
                            </p>

                            <p class="car-card__price-km">
                                <?= htmlspecialchars($v['precio_km']) ?> €/km
                            </p>

                            <div class="car-card__details">
                                <p><strong>Marca:</strong> <?= htmlspecialchars($v['marca']) ?></p>
                                <p><strong>Modelo:</strong> <?= htmlspecialchars($v['modelo']) ?></p>
                                <p><strong>Combustible:</strong> <?= $v['combustible'] ?></p>
                                <p><strong>Kilometraje:</strong> <?= number_format($v['kilometraxe']) ?> km</p>
                                <p><strong>Año:</strong> <?= $v['año'] ?></p>
                            </div>

                            <a href="../public/vehicle.php?matricula=<?= urlencode($v['matricula']) ?>&date_range=<?= urlencode($date_range) ?>&tamano=<?= urlencode($tamano) ?>&max_precio=<?= urlencode($max_precio) ?>"
                                class="car-card__button">
                                Ver detalles
                            </a>

                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="grid-column:1/-1;text-align:center;">
                    No hay vehículos disponibles.
                </p>
            <?php endif; ?>

        </section>
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
    <script src="./js/our-cars.js"></script>
</body>

</HTML>