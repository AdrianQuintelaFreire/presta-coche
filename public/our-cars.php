<?php

session_start();

// Importamos la conexión que ya tienes configurada
require_once __DIR__ . '/../config/conexion.php';

// Lógica de filtrado
$tipo_cambio = $_GET['shift'] ?? '';
$combustible = $_GET['fuel'] ?? '';
// Nuevos parámetros de fecha
$date_range = $_GET['date_range'] ?? '';

$fecha_inicio = '';
$fecha_fin = '';

if (!empty($date_range)) {

    $fechas = explode(" a ", $date_range);

    if (count($fechas) === 2) {

        $fecha_inicio = $fechas[0];
        $fecha_fin = $fechas[1];

    }

}

// Consulta base: Filtramos por estado y que NO esté en la subconsulta de reservas
$sql = "SELECT * FROM vehiculos WHERE estado = 'validado'";
$params = [];

// Filtro de Disponibilidad (Solo si ambas fechas están presentes)
if (!empty($fecha_inicio) && !empty($fecha_fin)) {

    $sql .= " AND matricula IN (

        SELECT matricula
        FROM vehiculos_disponibilidad

        WHERE fecha BETWEEN :f_inicio AND :f_fin
        AND disponible = 1

        GROUP BY matricula

        HAVING COUNT(fecha) = DATEDIFF(:f_fin_diff, :f_inicio_diff) + 1

    )";

    $params[':f_inicio'] = $fecha_inicio;
    $params[':f_fin'] = $fecha_fin;

    $params[':f_inicio_diff'] = $fecha_inicio;
    $params[':f_fin_diff'] = $fecha_fin;
}

if (!empty($tipo_cambio)) {
    $sql .= " AND tipo_cambio = :cambio";
    $params[':cambio'] = $tipo_cambio;
}

if (!empty($combustible)) {
    $sql .= " AND combustible = :fuel";
    $params[':fuel'] = $combustible;
}

$stmt = $conexion->prepare($sql);
echo "<pre>";
print_r($params);
echo "</pre>";
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
            <input type="checkbox" id="filter-toggle" class="filter__toggle">

            <label for="filter-toggle" class="button filter__button">
                Filtros
            </label>

            <form action="" class="filter__form search search--our-cars">
                <div class="search__group search__group--first">
                    <label for="date-range" class="search__label">
                        Fechas
                    </label>

                    <input type="text" id="date-range" name="date_range" class="search__input"
                        placeholder="Selecciona rango de fechas">
                </div>

                <div class="search__group search__group--second">
                    <label for="shift" class="search__label">Tipo de cambio</label>
                    <select name="shift" id="shift" class="search__select">
                        <option value="">Cualquiera</option>
                        <option value="manual">Manual</option>
                        <option value="automatico">Automático</option>
                    </select>

                    <label for="fuel" class="search__label">Tipo de combustible</label>
                    <select name="fuel" id="fuel" class="search__select">
                        <option value="">Cualquiera</option>
                        <option value="gasolina">Gasolina</option>
                        <option value="diesel">Diésel</option>
                    </select>
                </div>

                <div class="search__button">
                    <button type="submit" class="button">Aplicar</button>
                </div>
            </form>
        </aside>
        <section class="cars">
            <!--
       Ejemplo de car-card:
        <article class="car-card">
         <div class="car-card__image-wrapper">
           <img src="./img/Fiat.jpg" alt="Foto del coche" class="car-card__image">
         </div>
     
         <div class="car-card__content">
           <p class="car-card__price">12.500 €</p>
     
           <div class="car-card__details">
             <p class="car-card__detail"><span class="car-card__label">Marca:<br></span> Fiat</p>
             <p class="car-card__detail"><span class="car-card__label">Modelo:<br></span> 500</p>
             <p class="car-card__detail"><span class="car-card__label">Combustible:<br></span> Gasolina</p>
             <p class="car-card__detail"><span class="car-card__label">Cambio:<br></span> Manual</p>
             <p class="car-card__detail"><span class="car-card__label">Kilometraje:<br></span> 75.000 km</p>
             <p class="car-card__detail"><span class="car-card__label">Año:<br></span> 2021</p>
           </div>
     
           <button class="car-card__button">Ver detalles</button>
         </div>
       </article>
        -->
            <?php if ($vehiculos): ?>
                <?php foreach ($vehiculos as $v): ?>
                    <article class="car-card">
                        <div class="car-card__image-wrapper">
                            <img src="../storage/<?= htmlspecialchars($v['foto']) ?>"
                                alt="Vehículo <?= htmlspecialchars($v['matricula']) ?>" class="car-card__image">
                        </div>

                        <div class="car-card__content">
                            <!-- Añadimos el símbolo € y formateamos el precio si es necesario -->
                            <p class="car-card__price-day"><?= htmlspecialchars($v['precio_dia']) ?> €/día</p>
                            <p class="car-card__price-km"><?= htmlspecialchars($v['precio_km']) ?> €/km</p>

                            <div class="car-card__details">
                                <p class="car-card__detail"><span class="car-card__label">Marca:<br></span>
                                    <?= htmlspecialchars($v['marca']) ?></p>
                                <p class="car-card__detail"><span class="car-card__label">Modelo:<br></span>
                                    <?= htmlspecialchars($v['modelo']) ?></p>
                                <p class="car-card__detail"><span class="car-card__label">Combustible:<br></span>
                                    <?= ucfirst($v['combustible']) ?></p>
                                <p class="car-card__detail"><span class="car-card__label">Cambio:<br></span>
                                    <?= ucfirst($v['tipo_cambio']) ?></p>
                                <p class="car-card__detail"><span class="car-card__label">Kilometraje:<br></span>
                                    <?= number_format($v['kilometraxe'], 0, ',', '.') ?> km</p>
                                <p class="car-card__detail"><span class="car-card__label">Año:<br></span> <?= $v['año'] ?></p>
                            </div>

                            <!-- ENLACE CON MATRÍCULA -->
                            <a href="../public/vehicle.php?matricula=<?= urlencode($v['matricula']) ?>"
                                class="car-card__button">
                                Ver detalles
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="grid-column: 1 / -1; text-align: center; padding: 2rem;">No se han encontrado vehículos que
                    coincidan con tu búsqueda.</p>
            <?php endif; ?>
        </section>
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