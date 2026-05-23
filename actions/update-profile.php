<?php

session_start();

require_once __DIR__ . '/../config/conexion.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: /prestacoche/public/login.php");
    exit();
}

$id_usuario = $_SESSION['user_id'];

$telefono = $_POST['telefono'];
$direccion = $_POST['direccion'];

/*
|--------------------------------------------------------------------------
| Obtener usuario actual
|--------------------------------------------------------------------------
*/

$sqlUser = "SELECT * FROM usuarios WHERE id = ?";

$stmtUser = $conexion->prepare($sqlUser);

$stmtUser->execute([$id_usuario]);

$usuario = $stmtUser->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    session_destroy();
    header("Location: /prestacoche/public/login.php");
    exit();
}

/*
|--------------------------------------------------------------------------
| Contraseña
|--------------------------------------------------------------------------
*/

$contrasinal = $usuario['contrasinal']; // por defecto: NO cambiar

$contrasinal_nova = $_POST['contrasinal'] ?? '';
$contrasinal_confirm = $_POST['contrasinal_confirm'] ?? '';

if ($contrasinal_nova !== '' || $contrasinal_confirm !== '') {

    if ($contrasinal_nova !== $contrasinal_confirm) {

        header("Location: /prestacoche/pages/profile.php?error=pass_mismatch");
        exit();

    }

    // AQUÍ decides si usas hash o no (recomendado)
    $contrasinal = $contrasinal_nova;
}

/*
|--------------------------------------------------------------------------
| FOTO DNI / NIE
|--------------------------------------------------------------------------
*/

$foto_dni = $usuario['foto_dni'];

if (
    isset($_FILES['dni_nie']) &&
    $_FILES['dni_nie']['error'] === 0
) {

    $numero_aleatorio_dni = rand(1, 1000);

    $extension_dni = pathinfo(
        $_FILES['dni_nie']['name'],
        PATHINFO_EXTENSION
    );

    $foto_dni_nombre =
        $usuario['DNI'] . "_" .
        $numero_aleatorio_dni .
        "_dni." .
        $extension_dni;

    $directorio_dni =
        __DIR__ . "/../storage/id/";

    $ruta_dni =
        $directorio_dni .
        $foto_dni_nombre;

    move_uploaded_file(
        $_FILES['dni_nie']['tmp_name'],
        $ruta_dni
    );

    $foto_dni = $foto_dni_nombre;
}

/*
|--------------------------------------------------------------------------
| FOTO PERMISO CONDUCIR
|--------------------------------------------------------------------------
*/

$permiso_conducir = $usuario['permiso_conducir'];

if (
    isset($_FILES['permiso_conducir']) &&
    $_FILES['permiso_conducir']['error'] === 0
) {

    $numero_aleatorio_license = rand(1, 1000);

    $extension_license = pathinfo(
        $_FILES['permiso_conducir']['name'],
        PATHINFO_EXTENSION
    );

    $permiso_nombre =
        $usuario['DNI'] . "_" .
        $numero_aleatorio_license .
        "_carnet." .
        $extension_license;

    $directorio_permiso =
        __DIR__ . "/../storage/license/";

    $ruta_permiso =
        $directorio_permiso .
        $permiso_nombre;

    move_uploaded_file(
        $_FILES['permiso_conducir']['tmp_name'],
        $ruta_permiso
    );

    $permiso_conducir = $permiso_nombre;
}

/*
|--------------------------------------------------------------------------
| UPDATE
|--------------------------------------------------------------------------
*/

$sql = "UPDATE usuarios SET
            telefono = ?,
            direccion = ?,
            contrasinal = ?,
            foto_dni = ?,
            permiso_conducir = ?
        WHERE id = ?";

$stmt = $conexion->prepare($sql);

$stmt->execute([
    $telefono,
    $direccion,
    $contrasinal,
    $foto_dni,
    $permiso_conducir,
    $id_usuario
]);

header("Location: /prestacoche/pages/profile.php?success=1");
exit();