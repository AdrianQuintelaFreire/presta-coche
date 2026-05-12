<?php
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

// 3. Consultamos solo ESE vehículo
$sql = "SELECT * FROM vehiculos WHERE matricula = :matricula AND estado = 'validado' LIMIT 1";
$stmt = $conexion->prepare($sql);
$stmt->execute([':matricula' => $matricula]);
$coche = $stmt->fetch();

// 4. Si el coche no existe en la base de datos
if (!$coche) {
    die("Lo sentimos, el vehículo con matrícula " . htmlspecialchars($matricula) . " no existe o no está disponible.");
}
?>

<!DOCTYPE html>
<HTML lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalles del <?= htmlspecialchars($coche['marca'] . " " . $coche['modelo']) ?></title>
    <link rel="stylesheet" href="./css/main.css">
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
    <main class="main-vehicle">
        <h1>Detalles del vehículo</h1>
        
        <div class="vehicle-detail">
            <!-- Aquí ya tienes acceso a todo el array $coche -->
            <img src="../storage/<?= htmlspecialchars($coche['foto']) ?>"/>
            <p><strong>Marca:</strong> <?= htmlspecialchars($coche['marca']) ?></p>
            <p><strong>Combustible:</strong> <?= htmlspecialchars($coche['combustible']) ?></p>
            <p><strong>Kilometraje:</strong> <?= htmlspecialchars($coche['kilometraxe']) ?></p>
            <p><strong>Tipo de cambio:</strong> <?= htmlspecialchars($coche['tipo_cambio']) ?></p>

            <p><strong>Modelo:</strong> <?= htmlspecialchars($coche['modelo']) ?></p>
            <p><strong>Precio por día:</strong> <?= htmlspecialchars($coche['precio_dia']) ?> €</p>
            <p><strong>Precio por km:</strong> <?= htmlspecialchars($coche['precio_km']) ?> €</p>
            <p><strong>Dirección:</strong> <?= htmlspecialchars($coche['direccion']) ?> €</p>
            
            <!-- Puedes añadir más campos según tu base de datos -->
        </div>
    
        <a href="our-cars.php">Volver al catálogo</a>
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
    <script src="./js/main.js"></script>
</body>
</HTML>