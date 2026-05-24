<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /prestacoche/public/login.php");
    exit();
}

require_once '../config/conexion.php';

$id_usuario = $_SESSION['user_id'];

/*
    Obtener coches reservados por el usuario
    sin repetir matrícula
*/
$sql = "
    SELECT DISTINCT
        v.*,
        u.telefono AS telefono_dueno
    FROM vehiculos v
    INNER JOIN vehiculos_disponibilidad vd
        ON v.matricula = vd.matricula
    INNER JOIN usuarios u
        ON v.id_usuario = u.id
    WHERE vd.user_id = ?
    AND vd.disponible = 0
";

$stmt = $conexion->prepare($sql);
$stmt->execute([$id_usuario]);

$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

$title = 'Mis reservas';
require __DIR__ . '/../includes/header.php';
?>

<main class="main-booking">

    <?php if (count($resultado) > 0): ?>

        <?php foreach ($resultado as $v): ?>

            <div class="cars-container">

                <article class="car-card">

                    <div class="car-card__status car-card__status--reserved">
                        Reservado
                    </div>

                    <div class="car-card__image-wrapper">

                        <img src="/prestacoche/storage/cars/<?= htmlspecialchars($v['foto']) ?>"
                            alt="Vehículo <?= htmlspecialchars($v['matricula']) ?>" class="car-card__image">

                    </div>

                    <div class="car-card__content">

                        <p class="car-card__price-day">
                            <?= htmlspecialchars($v['precio_dia']) ?> €/día
                        </p>

                        <p class="car-card__price-km">
                            <?= htmlspecialchars($v['precio_km']) ?> €/km
                        </p>

                        <div class="car-card__details">

                            <p class="car-card__detail">
                                <span class="car-card__label">
                                    Marca:<br>
                                </span>
                                <?= htmlspecialchars($v['marca']) ?>
                            </p>

                            <p class="car-card__detail">
                                <span class="car-card__label">
                                    Modelo:<br>
                                </span>
                                <?= htmlspecialchars($v['modelo']) ?>
                            </p>

                            <p class="car-card__detail">
                                <span class="car-card__label">
                                    Combustible:<br>
                                </span>
                                <?= ucfirst($v['combustible']) ?>
                            </p>

                            <p class="car-card__detail">
                                <span class="car-card__label">
                                    Cambio:<br>
                                </span>
                                <?= ucfirst($v['tipo_cambio']) ?>
                            </p>

                            <p class="car-card__detail">
                                <span class="car-card__label">
                                    Kilometraje:<br>
                                </span>
                                <?= number_format($v['kilometraxe'], 0, ',', '.') ?> km
                            </p>

                            <p class="car-card__detail">
                                <span class="car-card__label">
                                    Año:<br>
                                </span>
                                <?= $v['año'] ?>
                            </p>
                            <p class="car-card__detail">
                                <span class="car-card__label">
                                    Dirección:<br>
                                </span>
                                <?= htmlspecialchars($v['direccion']) ?>
                            </p>
                            <p class="car-card__detail">
                                <span class="car-card__label">
                                    Teléfono dueño:<br>
                                </span>

                                <a href="tel:<?= htmlspecialchars($v['telefono_dueno']) ?>" class="car-card__phone">
                                    <?= htmlspecialchars($v['telefono_dueno']) ?>
                                </a>
                            </p>

                        </div>

                        <?php
                        $sqlFechas = "
                            SELECT fecha
                            FROM vehiculos_disponibilidad
                            WHERE matricula = ?
                            AND user_id = ?
                            AND disponible = 0
                            ORDER BY fecha ASC
                        ";

                        $stmtFechas = $conexion->prepare($sqlFechas);

                        $stmtFechas->execute([
                            $v['matricula'],
                            $id_usuario
                        ]);

                        $fechasReservadas = $stmtFechas->fetchAll(PDO::FETCH_COLUMN);
                        ?>

                        <div class="booking-dates">

                            <p class="booking-dates__title">
                                Fechas reservadas
                            </p>

                            <?php foreach ($fechasReservadas as $fecha): ?>

                                <span class="booking-dates__item">
                                    <?= date('d/m/Y', strtotime($fecha)) ?>
                                </span>

                            <?php endforeach; ?>

                        </div>
                        <button type="button" class="car-card__button car-card__button--inspect open-booking-modal"
                            data-matricula="<?= htmlspecialchars($v['matricula']) ?>"
                            data-fechas='<?= json_encode($fechasReservadas) ?>'>

                            Modificar fechas
                        </button>

                    </div>

                </article>

            </div>

        <?php endforeach; ?>

    <?php else: ?>

        <p class="main-booking__empty">
            No tienes reservas activas.
        </p>

    <?php endif; ?>

</main>
<?php require __DIR__ . '/../includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
<script src="/prestacoche/public/js/main.js"></script>
<script src="/prestacoche/public/js/my-booking.js"></script>
<!-- Modal reservas -->
<div class="modal" id="bookingModal">

    <div class="modal__overlay"></div>

    <div class="modal__content modal__content--booking">

        <h2 class="modal__title">
            Reservas del vehículo
        </h2>

        <p class="modal__text">
            Matrícula:
            <span id="bookingMatricula"></span>
        </p>

        <div id="bookingDatesList" class="booking-modal-list">

        </div>

        <div class="modal__actions">

            <button type="button" class="modal__button modal__button--cancel" id="closeBookingModal">

                Cerrar
            </button>

        </div>

    </div>

</div>
</body>

</HTML>