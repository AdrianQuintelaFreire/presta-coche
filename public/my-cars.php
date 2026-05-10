<?php
session_start();

// Si no está logueado o si está logueado pero NO es admin, fuera.
if (!isset($_SESSION['user_id'])) {
    header("Location: /prestacoche/public/login.php");
    exit();
}

// El resto del código de la página de admin va aquí...
?>
<?php
// Conexión a la base de datos
require_once '../config/conexion.php';

// Obtener el id del usuario logueado
$id_usuario = $_SESSION['user_id'];

// Consulta de los vehículos del usuario
$sql = "SELECT * FROM vehiculos WHERE id_usuario = ?";
$stmt = $conexion->prepare($sql);

$stmt->execute([$id_usuario]);

$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    <main class="cars">
        <?php if (count($resultado) > 0): ?>

            <?php foreach ($resultado as $v): ?>
                <div class="cars-container">

                    <article class="car-card">
                        <?php
                        $estado = strtolower($v['estado']);
                        ?>

                        <div class="car-card__status car-card__status--<?= $estado ?>">

                            <?php if ($estado === 'validado'): ?>
                                Validado
                            <?php elseif ($estado === 'pendente'): ?>
                                Pendiente
                            <?php else: ?>
                                Revisión
                            <?php endif; ?>

                        </div>

                        <div class="car-card__image-wrapper">
                            <img src="../storage/<?= htmlspecialchars($v['foto']) ?>"
                                alt="Vehículo <?= htmlspecialchars($v['matricula']) ?>" class="car-card__image">
                        </div>

                        <div class="car-card__content">
                            <!-- Añadimos el símbolo € y formateamos el precio si es necesario -->
                            <p class="car-card__price"><?= htmlspecialchars($v['precio_dia']) ?> €/día</p>

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
                                <p class="car-card__detail"><span class="car-card__label">Año:<br></span> <?= $v['año'] ?>
                                </p>
                            </div>

                            <!-- ENLACE CON MATRÍCULA -->
                            <button type="button" class="car-card__button open-edit-modal"
                                data-matricula="<?= htmlspecialchars($v['matricula']) ?>"
                                data-precio-dia="<?= htmlspecialchars($v['precio_dia']) ?>"
                                data-precio-km="<?= htmlspecialchars($v['precio_km']) ?>">

                                Editar
                            </button>
                            <button type="button" class="car-card__button car-card__button--delete open-delete-modal"
                                data-matricula="<?= htmlspecialchars($v['matricula']) ?>">
                                Eliminar
                            </button>
                        </div>
                    </article>
                </div>
            <?php endforeach; ?>



        <?php else: ?>

            <p>No tienes vehículos registrados.</p>

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
    <!-- Modal eliminar -->
    <div class="modal" id="deleteModal">
        <div class="modal__overlay"></div>

        <div class="modal__content">
            <h2 class="modal__title">Eliminar vehículo</h2>

            <p class="modal__text">
                ¿Estás seguro de que quieres eliminar este vehículo con matrícula
                <span id="modalMatricula"></span>?
            </p>

            <div class="modal__actions">
                <button class="modal__button modal__button--cancel" id="cancelDelete">
                    Cancelar
                </button>

                <a href="#" class="modal__button modal__button--confirm" id="confirmDelete">
                    Eliminar
                </a>
            </div>
        </div>
    </div>
    <!-- Modal editar -->
    <div class="modal" id="editModal">

        <div class="modal__overlay"></div>

        <div class="modal__content">

            <h2 class="modal__title">
                Editar precios
            </h2>

            <p class="modal__text">
                Editando vehículo con matrícula
                <span id="editModalMatricula"></span>
            </p>

            <form action="../public/update-vehicle.php" method="POST" class="modal-form">

                <input type="hidden" name="matricula" id="editMatricula">

                <div class="modal-form__group">

                    <label class="modal-form__label">
                        Precio por día (€)
                    </label>

                    <input type="number" step="0.01" name="precio_dia" id="editPrecioDia" class="modal-form__input"
                        required>

                </div>

                <div class="modal-form__group">

                    <label class="modal-form__label">
                        Precio por km (€)
                    </label>

                    <input type="number" step="0.01" name="precio_km" id="editPrecioKm" class="modal-form__input"
                        required>

                </div>

                <div class="modal__actions">

                    <button type="button" class="modal__button modal__button--cancel" id="cancelEdit">

                        Cancelar

                    </button>

                    <button type="submit" class="modal__button modal__button--confirm">

                        Guardar

                    </button>

                </div>

            </form>

        </div>

    </div>

    </div>
    <script src="./js/main.js"></script>
</body>
<script src="./js/my-cars.js"></script>

</html>