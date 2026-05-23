<?php
session_start();

// Si no está logueado o si está logueado pero NO es admin, fuera.
if (!isset($_SESSION['user_id'])) {
    header("Location: /prestacoche/public/login.php");
    exit();
}
$title = 'Alquila tu coche';
require __DIR__ . '/../includes/header.php';
?>
<main class="rent-car">

    <section class="rent-car__container">

        <h1 class="rent-car__title">
            Añadir vehículo
        </h1>

        <form action="/prestacoche/actions/add-vehicle.php" method="POST" enctype="multipart/form-data" class="rent-car__form">

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
<?php require __DIR__ . '/../includes/footer.php'; ?>
<script src="/prestacoche/public/js/main.js"></script>
<script src="/prestacoche/public/js/rent-your-car.js"></script>
</body>

</html>