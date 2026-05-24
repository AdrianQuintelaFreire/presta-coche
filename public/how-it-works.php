<?php
session_start();
$title = '¿Cómo funciona?';
require __DIR__ . '/../includes/header.php';
?>
<main class="how-it-works">
    <div class="how-it-works__container">

        <h2 class="how-it-works__title">Cómo funciona</h2>

        <div class="how-it-works__block">
            <h3 class="how-it-works__subtitle">Si aún no tienes cuenta</h3>
            <p class="how-it-works__text">
                Puedes navegar por la plataforma y ver los vehículos disponibles, consultando sus características,
                ubicación aproximada y fechas disponibles.
            </p>
            <p class="how-it-works__text">
                Para poder reservar un coche o publicar el tuyo, necesitas registrarte e iniciar sesión.
            </p>
        </div>

        <div class="how-it-works__block">
            <h3 class="how-it-works__subtitle">Si ya tienes cuenta</h3>

            <div class="how-it-works__item">
                <h4 class="how-it-works__item-title">Alquila un coche</h4>
                <p class="how-it-works__text">
                    Busca vehículos según las fechas que necesites, revisa sus detalles y realiza una reserva de
                    forma sencilla.
                    Después, solo tendrás que acordar con el propietario la recogida y devolución.
                </p>
            </div>

            <div class="how-it-works__item">
                <h4 class="how-it-works__item-title">Publica tu coche</h4>
                <p class="how-it-works__text">
                    Añade tu vehículo con su información, documentación y disponibilidad.
                    El coche será revisado antes de publicarse para garantizar la seguridad.
                </p>
            </div>

            <div class="how-it-works__item">
                <h4 class="how-it-works__item-title">Gestiona tu actividad</h4>
                <p class="how-it-works__text">
                    Desde tu perfil podrás consultar tus reservas, gestionar tus vehículos y actualizar tus datos
                    personales.
                </p>
            </div>

        </div>

    </div>
</main>
<?php require __DIR__ . '/../includes/footer.php'; ?>

<script src="/prestacoche/public/js/main.js"></script>
</body>

</HTML>