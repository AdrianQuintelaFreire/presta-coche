<!DOCTYPE html>
<HTML lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'PestaCoche' ?></title>
    <link rel="stylesheet" href="/prestacoche/public/css/main.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>

<body>
    <header class="header">
        <nav class="nav">
            <a href="/prestacoche/public/index.php" class="nav__logo">
                <img src="/prestacoche/public/img/logo_prestacoche.png" alt="Logotipo de PrestaCoche" class="nav__img">
            </a>
            <input type="checkbox" id="menu-toggle" class="nav__checkbox">
            <label for="menu-toggle" class="nav__label">
                <span class="nav__hamburger"></span>
            </label>
            <div class="nav-secondary">
                <ul class="menu menu--secondary">
                    <li class="menu__item"><a href="/prestacoche/public/our-cars.php" class="menu__link">Nuestros
                            coches</a></li>
                    <li class="menu__item"><a href="/prestacoche/public/how-it-works.php" class="menu__link">¿Cómo
                            funciona?</a>
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

                                <a href="/prestacoche/pages/profile.php" class="account-menu__link">
                                    Perfil
                                </a>

                                <a href="/prestacoche/pages/my-booking.php" class="account-menu__link">
                                    Reservas
                                </a>

                                <a href="/prestacoche/pages/my-cars.php" class="account-menu__link">
                                    Coches
                                </a>

                                <a href="/prestacoche/actions/logout.php" class="account-menu__link">
                                    Cerrar sesión
                                </a>

                            </div>

                        </div>
                    <?php else: ?>
                        <a href="/prestacoche/public/login.php" class="btn btn--primary">
                            Iniciar Sesión
                        </a>
                    <?php endif; ?>
                    <a href="/prestacoche/public/rent-your-car.php" class="btn btn--secondary">Alquila tu coche</a>
                </div>
            </div>
            <div class="nav-primary">
                <ul class="menu menu--primary">
                    <li class="menu__item"><a href="/prestacoche/public/our-cars.php" class="menu__link">Nuestros
                            coches</a></li>
                    <li class="menu__item"><a href="/prestacoche/public/how-it-works.php" class="menu__link">¿Cómo
                            funciona?</a>
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

                                <a href="/prestacoche/pages/profile.php" class="account-menu__link">
                                    Perfil
                                </a>

                                <a href="/prestacoche/pages/my-booking.php" class="account-menu__link">
                                    Reservas
                                </a>

                                <a href="/prestacoche/pages/my-cars.php" class="account-menu__link">
                                    Coches
                                </a>

                                <a href="/prestacoche/actions/logout.php" class="account-menu__link">
                                    Cerrar sesión
                                </a>

                            </div>

                        </div>

                    <?php else: ?>

                        <a href="/prestacoche/public/login.php" class="btn btn--primary">
                            Iniciar Sesión
                        </a>

                    <?php endif; ?>
                    <a href="/prestacoche/public/rent-your-car.php" class="btn btn--secondary">Alquila tu coche</a>
                </div>
            </div>
        </nav>
    </header>