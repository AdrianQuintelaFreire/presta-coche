<?php

session_start();

require_once __DIR__ . '/../config/conexion.php';

if (
    !isset($_SESSION['rol']) ||
    $_SESSION['rol'] !== 'admin'
) {
    header("Location: /prestacoche/public/login.php");
    exit();
}

$id_usuario = $_GET['id'] ?? '';

if (empty($id_usuario)) {

    header("Location: /prestacoche/pages/admin_validate-users.php");
    exit();

}

/*
|--------------------------------------------------------------------------
| Obtener usuario para borrar archivos
|--------------------------------------------------------------------------
*/

$sqlUser = "SELECT *
            FROM usuarios
            WHERE id = :id";

$stmtUser = $conexion->prepare($sqlUser);

$stmtUser->execute([
    ':id' => $id_usuario
]);

$usuario = $stmtUser->fetch(PDO::FETCH_ASSOC);

if ($usuario) {

    $ruta_dni =
        __DIR__ .
        '/../storage/id/' .
        $usuario['foto_dni'];

    $ruta_permiso =
        __DIR__ .
        '/../storage/license/' .
        $usuario['permiso_conducir'];

    if (file_exists($ruta_dni)) {
        unlink($ruta_dni);
    }

    if (file_exists($ruta_permiso)) {
        unlink($ruta_permiso);
    }
}

/*
|--------------------------------------------------------------------------
| Eliminar usuario
|--------------------------------------------------------------------------
*/

$sql = "DELETE FROM usuarios
        WHERE id = :id";

$stmt = $conexion->prepare($sql);

$stmt->execute([
    ':id' => $id_usuario
]);

header("Location: /prestacoche/pages/admin_validate-users.php");
exit();