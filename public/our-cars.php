<?php

session_start();

require_once __DIR__ . '/../config/conexion.php';

// Filtros
$tamano = $_GET['tamano'] ?? '';
$max_precio = $_GET['max_precio'] ?? '';

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

// 🔥 NUEVO: filtro precio máximo
if (!empty($max_precio)) {
    $sql .= " AND precio_dia <= :max_precio";
    $params[':max_precio'] = $max_precio;
}

// 🔥 Obtener rango real de precios (YA CON FECHAS APLICADAS)
$sqlRange = "SELECT MIN(precio_dia) AS min_precio, MAX(precio_dia) AS max_precio
             FROM vehiculos
             WHERE estado = 'validado'";

$paramsRange = [];

// aplicar mismo filtro de fechas
if (!empty($fecha_inicio) && !empty($fecha_fin)) {

    $sqlRange .= " AND matricula IN (
        SELECT matricula
        FROM vehiculos_disponibilidad
        WHERE fecha BETWEEN :f_inicio AND :f_fin
        AND disponible = 1
        GROUP BY matricula
        HAVING COUNT(*) = DATEDIFF(:f_fin_diff, :f_inicio_diff) + 1
    )";

    $paramsRange[':f_inicio'] = $fecha_inicio;
    $paramsRange[':f_fin'] = $fecha_fin;
    $paramsRange[':f_inicio_diff'] = $fecha_inicio;
    $paramsRange[':f_fin_diff'] = $fecha_fin;
}

$stmtRange = $conexion->prepare($sqlRange);
$stmtRange->execute($paramsRange);

$range = $stmtRange->fetch();

$precio_min = (int) $range['min_precio'];
$precio_max = (int) $range['max_precio'];
$max_precio = isset($_GET['max_precio']) && $_GET['max_precio'] !== ''
    ? (float) $_GET['max_precio']
    : $precio_max;

$stmt = $conexion->prepare($sql);
$stmt->execute($params);
$vehiculos = $stmt->fetchAll();

$title = 'Nuestros coches';
require __DIR__ . '/../includes/header.php';
?>

    <main class="our-cars">

        <aside class="filter">

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

                </div>

                <!-- 🔥 NUEVO: PRECIO MAXIMO -->
                <div class="search__group">
                    <label for="max_precio" class="search__label">
                        Precio máximo por día:
                        <span id="precioValue"><?= htmlspecialchars($max_precio ?: $precio_max) ?></span> €
                    </label>

                    <input type="range" id="max_precio" name="max_precio" min="<?= $precio_min ?>"
                        max="<?= $precio_max ?>" step="1" value="<?= htmlspecialchars($max_precio ?: $precio_max) ?>"
                        oninput="document.getElementById('precioValue').textContent = this.value"
                        class="search__range" />
                </div>

                <div class="search__button">
                    <button type="submit" class="button">Aplicar</button>
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
                            <img src="../storage/car/<?= htmlspecialchars($v['foto']) ?>" class="car-card__image">
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

                            <a href="../public/vehicle.php?matricula=<?= urlencode($v['matricula']) ?>&date_range=<?= urlencode($date_range) ?>&tamano=<?= urlencode($tamano) ?>&max_precio=<?= urlencode($max_precio) ?>"
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