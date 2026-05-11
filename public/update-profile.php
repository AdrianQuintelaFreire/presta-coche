<?php

session_start();

require_once '../config/conexion.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
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

/*
|--------------------------------------------------------------------------
| Contraseña
|--------------------------------------------------------------------------
*/

$contrasinal = $usuario['contrasinal'];

if (!empty($_POST['contrasinal'])) {

    $contrasinal = $_POST['contrasinal'];

}

/*
|--------------------------------------------------------------------------
| Permiso conducir
|--------------------------------------------------------------------------
*/

$permiso = $usuario['permiso_conducir'];

if (
    isset($_FILES['permiso_conducir']) &&
    $_FILES['permiso_conducir']['error'] === 0
) {

    $archivo = $_FILES['permiso_conducir'];

    $nombreArchivo = time() . "_" . basename($archivo['name']);

    $rutaDestino = "../storage/" . $nombreArchivo;

    move_uploaded_file(
        $archivo['tmp_name'],
        $rutaDestino
    );

    $permiso = $nombreArchivo;
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
            permiso_conducir = ?
        WHERE id = ?";

$stmt = $conexion->prepare($sql);

$stmt->execute([
    $telefono,
    $direccion,
    $contrasinal,
    $permiso,
    $id_usuario
]);

header("Location: profile.php?success=1");
exit();