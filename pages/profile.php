<?php

session_start();



// Si no está logueado
if (!isset($_SESSION['user_id'])) {

    header("Location: /prestacoche/public/login.php");
    exit();

}

/*
|--------------------------------------------------------------------------
| Conexión BD
|--------------------------------------------------------------------------
*/

require_once '../config/conexion.php';

/*
|--------------------------------------------------------------------------
| Obtener usuario logueado
|--------------------------------------------------------------------------
*/

$id_usuario = $_SESSION['user_id'];

$sql = "SELECT * FROM usuarios WHERE id = ?";

$stmt = $conexion->prepare($sql);

$stmt->execute([$id_usuario]);

$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| Seguridad extra
|--------------------------------------------------------------------------
*/

if (!$usuario) {

    session_destroy();

    header("Location: /prestacoche/public/login.php");
    exit();

}

$title = 'Perfil';
require __DIR__ . '/../includes/header.php';

?>

<main class="profile">

    <section class="profile__container">

        <h1 class="profile__title">
            Mi perfil
        </h1>

        <form id="profile-form" action="/prestacoche/actions/update-profile.php" method="POST"
            enctype="multipart/form-data" class="profile__form">

            <div class="profile__group">

                <label class="profile__label">
                    Nombre
                </label>

                <input type="text" value="<?= htmlspecialchars($usuario['nome']) ?>" disabled
                    class="profile__input profile__input--disabled">

            </div>

            <div class="profile__group">

                <label class="profile__label">
                    Apellidos
                </label>

                <input type="text" value="<?= htmlspecialchars($usuario['apelidos']) ?>" disabled
                    class="profile__input profile__input--disabled">

            </div>

            <div class="profile__group">

                <label class="profile__label">
                    Email
                </label>

                <input type="email" value="<?= htmlspecialchars($usuario['email']) ?>" disabled
                    class="profile__input profile__input--disabled">

            </div>

            <div class="profile__group">

                <label class="profile__label">
                    DNI
                </label>

                <input type="text" value="<?= htmlspecialchars($usuario['DNI']) ?>" disabled
                    class="profile__input profile__input--disabled">

            </div>

            <div class="profile__group">

                <label class="profile__label">
                    Fecha de nacimiento
                </label>

                <input type="date" value="<?= htmlspecialchars($usuario['data_nacemento']) ?>" disabled
                    class="profile__input profile__input--disabled">

            </div>

            <div class="profile__group">

                <label class="profile__label">
                    Teléfono
                </label>

                <input type="text" name="telefono" value="<?= htmlspecialchars($usuario['telefono']) ?>" required
                    class="profile__input">

            </div>

            <div class="profile__group">

                <label class="profile__label">
                    Dirección
                </label>

                <input type="text" name="direccion" value="<?= htmlspecialchars($usuario['direccion']) ?>" required
                    class="profile__input">

            </div>

            <div class="profile__group">

                <label class="profile__label">
                    Nueva contraseña
                </label>

                <input id="contrasinal" type="password" name="contrasinal" placeholder="Introduce una nueva contraseña"
                    class="profile__input">

            </div>

            <div class="profile__group">

                <label class="profile__label">
                    Confirmar contraseña
                </label>

                <input id="contrasinal_confirm" type="password" name="contrasinal_confirm"
                    placeholder="Confirma la nueva contraseña" class="profile__input">

            </div>

            <div class="profile__group">

                <label class="profile__label">
                    Foto del DNI / NIE
                </label>

                <input type="file" name="dni_nie" accept="image/*,.pdf" class="profile__input">

            </div>

            <div class="profile__group">

                <label class="profile__label">
                    Foto del permiso de conducir
                </label>

                <input type="file" name="permiso_conducir" accept="image/*,.pdf" class="profile__input">

            </div>

            <button type="submit" class="profile__button">

                Guardar cambios

            </button>

        </form>

    </section>

    <?php if (isset($_GET['success'])): ?>

        <div class="success-popup">

            <div class="success-popup__content">

                <h2 class="success-popup__title">
                    Perfil actualizado correctamente
                </h2>

            </div>

        </div>

    <?php endif; ?>

</main>
<?php require __DIR__ . '/../includes/footer.php'; ?>
<script src="/prestacoche/public/js/main.js"></script>
<script src="/prestacoche/public/js/profile.js"></script>
</body>

</HTML>