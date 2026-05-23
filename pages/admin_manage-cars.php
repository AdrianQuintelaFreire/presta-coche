<?php
session_start();
$title = 'Panel Admin';
$currentPage = 'manage-cars';
require __DIR__ . '/../includes/admin_header.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: /prestacoche/public/login.php");
    exit();
}

require_once __DIR__ . '/../config/conexion.php';

$busqueda = trim($_GET['q'] ?? '');
$vehiculos = [];

if (strlen($busqueda) >= 2) {

    $sql = "SELECT matricula, marca, modelo, precio_dia, precio_km, foto
            FROM vehiculos
            WHERE estado = 'validado'
            AND (
                marca LIKE :q1
                OR modelo LIKE :q2
                OR matricula LIKE :q3
            )";

    $stmt = $conexion->prepare($sql);

    $stmt->execute([
        ':q1' => "%$busqueda%",
        ':q2' => "%$busqueda%",
        ':q3' => "%$busqueda%"
    ]);

    $vehiculos = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<main class="admin">

    <?php require __DIR__ . '/../includes/admin_aside.php'; ?>

    <section class="admin-content">

        <header class="admin-content__header">
            <h1 class="admin-content__title">Gestionar vehículos</h1>
        </header>

        <form method="GET" class="admin-search">
            <input type="text" name="q" value="<?= htmlspecialchars($busqueda) ?>"
                placeholder="Buscar por marca, modelo o matrícula" class="admin-search__input">

            <button class="admin-search__button">
                Buscar
            </button>
        </form>

        <div class="admin-results">

            <?php if ($busqueda === ''): ?>

                <p class="admin-results__empty">
                    Escribe al menos 2 caracteres para buscar vehículos.
                </p>

            <?php elseif (empty($vehiculos)): ?>

                <p class="admin-results__empty">
                    No se han encontrado vehículos.
                </p>

            <?php else: ?>

                <?php foreach ($vehiculos as $v): ?>

                    <div class="admin-car-card">

                        <img class="admin-car-card__img" src="/prestacoche/storage/cars/<?= htmlspecialchars($v['foto']) ?>"
                            alt="Coche">

                        <div class="admin-car-card__info">

                            <p class="admin-car-card__title">
                                <?= htmlspecialchars($v['marca']) ?>
                                <?= htmlspecialchars($v['modelo']) ?>
                            </p>

                            <p class="admin-car-card__meta">
                                <?= htmlspecialchars($v['matricula']) ?>
                            </p>

                            <p class="admin-car-card__meta">
                                <?= htmlspecialchars($v['precio_dia']) ?> €/día ·
                                <?= htmlspecialchars($v['precio_km']) ?> €/km
                            </p>

                        </div>

                        <div class="admin-car-card__actions">

                            <a href="/prestacoche/actions/delete-car.php?matricula=<?= urlencode($v['matricula']) ?>&from=/prestacoche/pages/admin_manage-cars.php<?= urlencode('?q=' . $busqueda) ?>"
                                class="admin-car-card__button admin-car-card__button--delete js-delete-car">
                                Eliminar
                            </a>

                        </div>

                    </div>

                <?php endforeach; ?>

            <?php endif; ?>

        </div>

    </section>

</main>

<?php require __DIR__ . '/../includes/admin_footer.php'; ?>
<script src="/prestacoche/public/js/main.js"></script>
<script src="/prestacoche/public/js/admin-cars.js"></script>
</body>

</HTML>