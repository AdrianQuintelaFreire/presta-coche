<?php

session_start();

require_once '../config/conexion.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION['user_id'];

$sql = "UPDATE vehiculos SET
            precio_dia = ?,
            precio_km = ?
        WHERE matricula = ?
        AND id_usuario = ?";

$stmt = $conexion->prepare($sql);

$stmt->execute([
    $_POST['precio_dia'],
    $_POST['precio_km'],
    $_POST['matricula'],
    $id_usuario
]);

header("Location: my-cars.php");
exit();