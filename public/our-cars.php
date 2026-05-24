<?php

session_start();

require_once __DIR__ . '/../config/conexion.php';

// Filtros
$tamano = $_GET['tamano'] ?? '';

$date_range = $_GET['date_range'] ?? '';

$fecha_inicio = '';
$fecha_fin = '';

if (!empty($date_range)) {

    $fechas = explode(" a ", $date_range);

    $fecha_inicio = trim($fechas[0] ?? '');

    $fecha_fin = (count($fechas) === 2)
        ? trim($fechas[1])
        : $fecha_inicio; // si solo hay 1 día, es rango de 1 día
}

$sin_fechas = empty($fecha_inicio) || empty($fecha_fin);
// Consulta base
$sql = "SELECT * FROM vehiculos WHERE estado = 'validado'";
$params = [];

// Disponibilidad
if (!$sin_fechas) {

    $sql .= " AND matricula IN (
        SELECT matricula
        FROM vehiculos_disponibilidad
        WHERE fecha BETWEEN :f_inicio AND :f_fin
        AND disponible = 1
        GROUP BY matricula
        HAVING COUNT(*) = DATEDIFF(:f_fin_diff, :f_inicio_diff) + 1
    )";

    $params[':f_inicio'] = $fecha_inicio;
    $params[':f_fin'] = $fecha_fin;
    $params[':f_inicio_diff'] = $fecha_inicio;
    $params[':f_fin_diff'] = $fecha_fin;
}

// Filtro tamaño
if (!empty($tamano)) {
    $sql .= " AND tamano = :tamano";
    $params[':tamano'] = $tamano;
}

$stmt = $conexion->prepare($sql);
$stmt->execute($params);
$vehiculos = $stmt->fetchAll();

$title = 'Nuestros coches';
require __DIR__ . '/../includes/header.php';
?>

<main class="our-cars">

    <aside class="filter">
        <input type="checkbox" id="filter-toggle" class="filter__toggle">

        <label for="filter-toggle" class="filter__button button">
            Filtros
        </label>

        <form action="" method="get" class="filter__form search search--our-cars">

            <!-- FECHAS -->
            <div class="search__group search__group--first">
                <label for="date-range" class="search__label">Fechas de alquiler</label>
                <input type="text" id="date-range" name="date_range" class="search__input"
                    placeholder="Selecciona fechas" value="<?= htmlspecialchars($date_range) ?>">
            </div>

            <!-- TAMANO -->
            <div class="search__group search__group--second">

                <label for="tamano" class="search__label">Tamaño del vehículo</label>
                <select name="tamano" id="tamano" class="search__select">
                    <option value="" <?= $tamano === '' ? 'selected' : '' ?>>Cualquiera</option>
                    <option value="utilitario" <?= $tamano === 'utilitario' ? 'selected' : '' ?>>Utilitario</option>
                    <option value="mediano" <?= $tamano === 'mediano' ? 'selected' : '' ?>>Mediano</option>
                    <option value="grande" <?= $tamano === 'grande' ? 'selected' : '' ?>>Grande</option>
                </select>
                <div class="search__button">
                    <button type="submit" class="button">
                        Aplicar
                    </button>
                </div>

            </div>

        </form>
    </aside>
    <?php if ($sin_fechas): ?>

        <div class="no-dates-message">
            <h2>¿Cuándo quieres conducir? 🚗</h2>
            <p>
                Selecciona las fechas de recogida y devolución para ver los vehículos disponibles.
            </p>
        </div>

    <?php else: ?>

        <section class="cars">

            <?php if ($vehiculos): ?>
                <?php foreach ($vehiculos as $v): ?>
                    <article class="car-card">

                        <div class="car-card__image-wrapper">
                            <img src="/prestacoche/storage/cars/<?= htmlspecialchars($v['foto']) ?>" class="car-card__image">
                        </div>

                        <div class="car-card__content">

                            <p class="car-card__price-day">
                                <?= htmlspecialchars($v['precio_dia']) ?> €/día
                            </p>

                            <p class="car-card__price-km">
                                <?= htmlspecialchars($v['precio_km']) ?> €/km
                            </p>

                            <div class="car-card__details">
                                <p><strong>Marca:</strong> <?= htmlspecialchars($v['marca']) ?></p>
                                <p><strong>Modelo:</strong> <?= htmlspecialchars($v['modelo']) ?></p>
                                <p><strong>Combustible:</strong> <?= $v['combustible'] ?></p>
                                <p><strong>Kilometraje:</strong> <?= number_format($v['kilometraxe']) ?> km</p>
                                <p><strong>Año:</strong> <?= $v['año'] ?></p>
                            </div>

                            <a href="../public/vehicle.php?matricula=<?= urlencode($v['matricula']) ?>&date_range=<?= urlencode($date_range) ?>&tamano=<?= urlencode($tamano) ?>"
                                class="car-card__button">
                                Ver detalles
                            </a>

                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="grid-column:1/-1;text-align:center;">
                    No hay vehículos disponibles.
                </p>
            <?php endif; ?>

        </section>
    <?php endif; ?>

</main>
<?php require __DIR__ . '/../includes/footer.php'; ?>
<script src="/prestacoche/public/js/flatpickr.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
<script src="/prestacoche/public/js/main.js"></script>

</body>

</HTML>