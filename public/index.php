<?php
session_start();
$title = 'Inicio';
require __DIR__ . '/../includes/header.php';
?>

<main class="main-home">
    <img class="main-home__img" src="./img/fondo_home.png" alt="Imagen de PrestaCoche">
    <h1 class="main-home__title">
        Gana con tu coche.<br>Ahorra con el de otros.
    </h1>
    <p class="main-home__text">Comparte tu coche o alquila uno cerca de ti de forma fácil y segura.</p>

    <form action="/prestacoche/public/our-cars.php" method="get" class="search">
        <div class="search__group search__group--first">
            <label for="date-range" class="search__label">
                Fechas de alquiler
            </label>

            <input type="text" id="date-range" name="date_range" class="search__input" placeholder="Selecciona fechas"
                value="<?= htmlspecialchars($_GET['date_range'] ?? '') ?>" required>
        </div>



        </div>
        <div class="search__button">
            <button type="submit" class="button">Comenzar a buscar</button>
        </div>
    </form>
</main>

<?php require __DIR__ . '/../includes/footer.php'; ?>
<script src="/prestacoche/public/js/flatpickr.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
<script src="/prestacoche/public/js/main.js"></script>

</body>

</HTML>