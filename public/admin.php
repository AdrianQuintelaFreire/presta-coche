<?php
session_start();
$title = 'Panel Admin';
$currentPage = 'manual';
require __DIR__ . '/../includes/admin_header.php';

// Si no está logueado o si está logueado pero NO es admin, fuera.
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: /prestacoche/public/login.php");
    exit();
}

// El resto del código de la página de admin va aquí...
?>

<main class="admin">

    <?php
    require __DIR__ . '/../includes/admin_aside.php';
    ?>

    <section class="admin-content">

        <header class="admin-content__header">

            <h1 class="admin-content__title">
                Manual de administración
            </h1>

            <p class="admin-content__subtitle">
                Aprende cómo gestionar usuarios,
                vehículos y permisos dentro de PrestaCoche.
            </p>

        </header>

        <div class="admin-content__grid">

            <!-- VALIDAR USUARIOS -->

            <article class="admin-content__card">

                <h2 class="admin-content__card-title">
                    Validar usuarios
                </h2>

                <p class="admin-content__text">
                    Antes de aprobar una cuenta debes comprobar
                    que toda la información subida por el usuario
                    es coherente y real.
                </p>

                <ul class="admin-content__list">

                    <li class="admin-content__list-item">
                        Verifica que el nombre y apellidos del
                        usuario coinciden con el DNI o NIE.
                    </li>

                    <li class="admin-content__list-item">
                        Comprueba que el DNI parece auténtico,
                        legible y no está manipulado.
                    </li>

                    <li class="admin-content__list-item">
                        Asegúrate de que la fotografía del
                        permiso de conducir pertenece al mismo usuario.
                    </li>

                    <li class="admin-content__list-item">
                        Comprueba que las fechas de caducidad
                        siguen siendo válidas.
                    </li>

                    <li class="admin-content__list-item">
                        Si los datos no coinciden o existe duda,
                        rechaza la validación.
                    </li>

                </ul>

            </article>

            <!-- VALIDAR VEHÍCULOS -->

            <article class="admin-content__card">

                <h2 class="admin-content__card-title">
                    Validar vehículos
                </h2>

                <p class="admin-content__text">
                    Todo vehículo debe revisarse antes de aparecer
                    públicamente en la plataforma.
                </p>

                <ul class="admin-content__list">

                    <li class="admin-content__list-item">
                        Comprueba que la fotografía del coche
                        es reales y visible.
                    </li>

                    <li class="admin-content__list-item">
                        Revisa que marca, modelo y datos
                        coinciden correctamente.
                    </li>

                    <li class="admin-content__list-item">
                        Detecta posibles publicaciones falsas,
                        spam o contenido engañoso.
                    </li>

                    <li class="admin-content__list-item">
                        Si un vehículo incumple normas,
                        debe rechazarse.
                    </li>

                </ul>

            </article>

            <!-- GESTIONAR USUARIOS -->

            <article class="admin-content__card">

                <h2 class="admin-content__card-title">
                    Gestionar usuarios
                </h2>

                <p class="admin-content__text">
                    Desde esta sección puedes administrar
                    cuentas registradas.
                </p>

                <ul class="admin-content__list">

                    <li class="admin-content__list-item">
                        Convertir un usuario en administrador.
                    </li>

                </ul>

            </article>

            <!-- GESTIONAR VEHÍCULOS -->

            <article class="admin-content__card">

                <h2 class="admin-content__card-title">
                    Gestionar vehículos
                </h2>

                <p class="admin-content__text">
                    Mantén el catálogo limpio y seguro
                    para los usuarios.
                </p>

                <ul class="admin-content__list">

                    <li class="admin-content__list-item">
                        Eliminar vehículos fraudulentos.
                    </li>


                </ul>

            </article>

        </div>

    </section>

</main>
<?php
require __DIR__ . '/../includes/admin_footer.php';
?>

<script src="/prestacoche/public/js/main.js"></script>
</body>

</HTML>