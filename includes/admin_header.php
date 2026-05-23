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
            <a href="/prestacoche/public/admin.php" class="nav__logo">
                <img src="/prestacoche/public/img/logo_prestacoche.png" alt="Logotipo de PrestaCoche" class="nav__img">
            </a>
            <input type="checkbox" id="menu-toggle" class="nav__checkbox">
            <label for="menu-toggle" class="nav__label">
                <span class="nav__hamburger"></span>
            </label>
            <div class="nav-primary">
                <ul class="menu menu--primary">
                    <li class="menu__item"><a href="/prestacoche/public/admin.php" class="menu__link">Manual</a></li>
                    <li class="menu__item"><a href="/prestacoche/pages/admin_validate-users.php" class="menu__link">Validar usuarios</a>
                    <li class="menu__item"><a href="/prestacoche/pages/admin_validate-cars.php" class="menu__link">Validar vehículos</a>
                    <li class="menu__item"><a href="/prestacoche/pages/admin_manage-users.php" class="menu__link">Gestionar usuarios</a>
                    <li class="menu__item"><a href="/prestacoche/pages/admin_manage-cars.php" class="menu__link">Gestionar vehículos</a>
                </ul>
                <div class="nav-primary__actions">
                    <a href="/prestacoche/actions/logout.php" class="btn btn--secondary">Cerrar sesión</a>
                </div>
            </div>
        </nav>
    </header>