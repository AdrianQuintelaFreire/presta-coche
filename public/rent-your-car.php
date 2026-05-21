<?php
session_start();

// Si no está logueado o si está logueado pero NO es admin, fuera.
if (!isset($_SESSION['user_id'])) {
    header("Location: /prestacoche/public/login.php");
    exit();
}

// El resto del código de la página de admin va aquí...
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Alquilar - PrestaCoche</title>
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

    <main class="rent-car">

        <section class="rent-car__container">

            <h1 class="rent-car__title">
                Añadir vehículo
            </h1>

            <form action="./add-vehicle.php" method="POST" enctype="multipart/form-data" class="rent-car__form">

                <div class="rent-car__group">

                    <label class="rent-car__label">
                        Matrícula
                    </label>

                    <input type="text" name="matricula" maxlength="7" required class="rent-car__input">

                </div>

                <div class="rent-car__group">

                    <label class="rent-car__label">
                        Marca
                    </label>

                    <input type="text" name="marca" required class="rent-car__input">

                </div>

                <div class="rent-car__group">

                    <label class="rent-car__label">
                        Modelo
                    </label>

                    <input type="text" name="modelo" required class="rent-car__input">

                </div>
                <div class="rent-car__group">

                    <label class="rent-car__label">
                        Potencia (CV)
                    </label>

                    <input type="number" name="potencia" min="1" required class="rent-car__input">

                </div>

                <div class="rent-car__group">

                    <label class="rent-car__label">
                        Combustible
                    </label>

                    <select name="combustible" required class="rent-car__input">

                        <option value="">Selecciona</option>
                        <option value="gasolina">Gasolina</option>
                        <option value="diesel">Diésel</option>
                        <option value="hibrido">Híbrido</option>
                        <option value="electrico">Eléctrico</option>

                    </select>

                </div>

                <div class="rent-car__group">

                    <label class="rent-car__label">
                        Kilometraje
                    </label>

                    <input type="number" name="kilometraxe" required class="rent-car__input">

                </div>

                <div class="rent-car__group">

                    <label class="rent-car__label">
                        Tipo de cambio
                    </label>

                    <select name="tipo_cambio" required class="rent-car__input">

                        <option value="">Selecciona</option>
                        <option value="manual">Manual</option>
                        <option value="automatico">Automático</option>

                    </select>

                </div>

                <div class="rent-car__group">

                    <label class="rent-car__label">
                        Año
                    </label>

                    <input type="number" name="año" min="1950" max="<?= date('Y') ?>" required class="rent-car__input">

                </div>

                <div class="rent-car__group">

                    <label class="rent-car__label">
                        Precio por día (€)
                    </label>

                    <input type="number" step="0.01" name="precio_dia" required class="rent-car__input">

                </div>

                <div class="rent-car__group">

                    <label class="rent-car__label">
                        Precio por km (€)
                    </label>

                    <input type="number" step="0.01" name="precio_km" required class="rent-car__input">

                </div>

                <div class="rent-car__group">

                    <label class="rent-car__label">
                        Dirección
                    </label>

                    <input type="text" name="direccion" required class="rent-car__input">

                </div>

                <div class="rent-car__group">

                    <label class="rent-car__label">
                        Foto del vehículo
                    </label>

                    <input type="file" name="foto" accept="image/*" required class="rent-car__input">


                </div>

                <button type="submit" class="rent-car__button">

                    Añadir vehículo

                </button>

            </form>

        </section>

        <?php if (isset($_GET['success'])): ?>

            <div class="success-popup success-popup--active">

                <div class="success-popup__content">

                    <h2 class="success-popup__title">
                        Vehículo añadido correctamente
                    </h2>

                </div>

            </div>

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
    <script src="./js/main.js"></script>
    <script src="./js/rent-your-car.js"></script>
</body>

</html>