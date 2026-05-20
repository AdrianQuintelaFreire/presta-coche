<?php
session_start();

// Si no está logueado o si está logueado pero NO es admin, fuera.
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: /prestacoche/public/login.php");
    exit();
}

// El resto del código de la página de admin va aquí...
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PrestaAuto - Alquiler de Coches</title>
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
                    <li class="menu__item"><a href="../public/how-it-works.php" class="menu__link">¿Cómo funciona?</a></li>
                </ul>
                <div class="nav-secondary__actions">
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <span class="user-welcome">
                            Hola, <?php echo $_SESSION['nome']; ?>
                        </span>
                        <a href="./logout.php" class="btn btn--primary">
                            Cerrar sesión
                        </a>
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
                    <li class="menu__item"><a href="../public/how-it-works.php" class="menu__link">¿Cómo funciona?</a></li>
                </ul>
                <div class="nav-primary__actions">
                    <a href="./login.php" class="btn btn--primary">Iniciar Sesión</a>
                    <a href="./rent-your-car.php" class="btn btn--secondary">Alquila tu coche</a>
                </div>
            </div>
        </nav>
    </header>
    <main>
                        <h1>Estás en zona admin</h1>
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


<!--
Hacer updates de consultas de usuarios no validados
require 'conexion.php';

$hoy = date('Y-m-d');

$sql = "UPDATE usuarios
        SET validado = 'no'
        WHERE fecha_caducidad_dni < ?";

$stmt = $conexion->prepare($sql);
$stmt->execute([$hoy]);
-->
</body>
</HTML>