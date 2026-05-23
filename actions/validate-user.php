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

$sql = "UPDATE usuarios
        SET validado = 'si'
        WHERE id = :id";

$stmt = $conexion->prepare($sql);

$stmt->execute([
    ':id' => $id_usuario
]);

header("Location: /prestacoche/pages/admin_validate-users.php");
exit();