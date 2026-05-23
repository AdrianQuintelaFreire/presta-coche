<?php
session_start();
$title = 'Panel Admin';
$currentPage = 'manage-users';
require __DIR__ . '/../includes/admin_header.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: /prestacoche/public/login.php");
    exit();
}

require_once __DIR__ . '/../config/conexion.php';

$busqueda = trim($_GET['q'] ?? '');
$usuarios = [];

// 🔥 SOLO BUSCA SI HAY TEXTO
if (strlen($busqueda) >= 2) {

    $sql = "SELECT id, nome, apelidos, telefono, data_nacemento, foto_dni, DNI
        FROM usuarios
        WHERE validado = 'si'
        AND rol IN ('user')
        AND (
            nome LIKE :q1
            OR apelidos LIKE :q2
            OR DNI LIKE :q3
        )";

    $stmt = $conexion->prepare($sql);

    $stmt->execute([
        ':q1' => "%$busqueda%",
        ':q2' => "%$busqueda%",
        ':q3' => "%$busqueda%"
    ]);

    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<main class="admin">

    <?php require __DIR__ . '/../includes/admin_aside.php'; ?>

    <section class="admin-content">

        <header class="admin-content__header">
            <h1 class="admin-content__title">Buscar usuarios</h1>
        </header>

        <form method="GET" class="admin-search">
            <input type="text" name="q" placeholder="Buscar por nombre o DNI" value="<?= htmlspecialchars($busqueda) ?>"
                class="admin-search__input">

            <button class="admin-search__button">
                Buscar
            </button>
        </form>

        <div class="admin-results">

            <?php if ($busqueda === ''): ?>

                <p class="admin-results__empty">
                    Escribe algo para buscar usuarios.
                </p>

            <?php elseif (empty($usuarios)): ?>

                <p class="admin-results__empty">
                    No se han encontrado usuarios.
                </p>

            <?php else: ?>

                <?php foreach ($usuarios as $u): ?>

                    <div class="admin-user-card">

                        <div class="admin-user-card__info">
                            <p><strong><?= htmlspecialchars($u['nome']) ?>         <?= htmlspecialchars($u['apelidos']) ?></strong></p>
                            <p><?= htmlspecialchars($u['DNI']) ?></p>
                            <p><?= htmlspecialchars($u['telefono']) ?></p>
                        </div>

                        <img src="/prestacoche/storage/id/<?= htmlspecialchars($u['foto_dni']) ?>" class="admin-user-card__img"
                            alt="DNI">
                        <div class="admin-user-card__actions">

                            <button type="button" class="admin-user-card__button admin-user-card__button--admin js-make-admin"
                                data-id="<?= $u['id'] ?>">
                                Dar admin
                            </button>

                        </div>

                    </div>

                <?php endforeach; ?>

            <?php endif; ?>

        </div>

    </section>

</main>

<?php
require __DIR__ . '/../includes/admin_footer.php';
?>

<script src="/prestacoche/public/js/main.js"></script>
<script src="/prestacoche/public/js/admin-users.js"></script>
</body>

</HTML>