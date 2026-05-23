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

$title = 'Mis coches';
require __DIR__ . '/../includes/header.php';
?>
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
                            <img src="../storage/car/<?= htmlspecialchars($v['foto']) ?>"
                                alt="Vehículo <?= htmlspecialchars($v['matricula']) ?>" class="car-card__image">
                        </div>

                        <div class="car-card__content">
                            <!-- Añadimos el símbolo € y formateamos el precio si es necesario -->
                            <p class="car-card__price-day"><?= htmlspecialchars($v['precio_dia']) ?> €/día</p>
                            <p class="car-card__price-km"><?= htmlspecialchars($v['precio_km']) ?> €/km</p>

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

                            <?php

                            $sqlFechas = "
                                SELECT fecha
                                FROM vehiculos_disponibilidad
                                WHERE matricula = ?
                                AND disponible = 1
                                ";

                            $stmtFechas = $conexion->prepare($sqlFechas);

                            $stmtFechas->execute([$v['matricula']]);

                            $fechasDisponibles = $stmtFechas->fetchAll(PDO::FETCH_COLUMN);

                            ?>

                            <button type="button"
                                class="car-card__button car-card__button--availability open-availability-modal"
                                data-matricula="<?= htmlspecialchars($v['matricula']) ?>"
                                data-fechas='<?= json_encode($fechasDisponibles) ?>'>
                                Disponibilidad
                            </button>
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

    <?php require __DIR__ . '/../includes/footer.php'; ?>
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

            <form action="/prestacoche/actions/update-vehicle.php" method="POST" class="modal-form">

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
    <!-- Modal disponibilidad -->
    <div class="modal" id="availabilityModal">

        <div class="modal__overlay"></div>

        <div class="modal__content">

            <h2 class="modal__title">
                Gestionar disponibilidad
            </h2>

            <p class="modal__text">
                Vehículo:
                <span id="availabilityMatricula"></span>
            </p>

            <form action="/prestacoche/actions/update-availability.php" method="POST" class="modal-form">

                <input type="hidden" name="matricula" id="availabilityInputMatricula">

                <div class="modal-form__group">

                    <label class="modal-form__label">
                        Selecciona fechas disponibles
                    </label>

                    <input type="text" name="fechas" id="availabilityCalendar" class="modal-form__input"
                        placeholder="Selecciona fechas" required>

                </div>

                <div class="modal__actions">

                    <button type="button" class="modal__button modal__button--cancel" id="cancelAvailability">
                        Cancelar
                    </button>

                    <button type="submit" class="modal__button modal__button--confirm">
                        Guardar
                    </button>

                </div>

            </form>

        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
    <script src="/prestacoche/public/js/main.js"></script>
    <script src="/prestacoche/public/js/my-cars.js"></script>
</body>

</html>