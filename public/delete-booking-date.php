<?php

session_start();

require_once '../config/conexion.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ./login.php");
    exit();
}

$id_usuario = $_SESSION['user_id'];

$matricula = $_GET['matricula'] ?? null;
$fecha = $_GET['fecha'] ?? null;

if (!$matricula || !$fecha) {
    header("Location: ./my-booking.php");
    exit();
}

/*
    En vez de borrar la fila:
    - disponible vuelve a 1
    - user_id vuelve a NULL
*/
$sql = "
    UPDATE vehiculos_disponibilidad
    SET disponible = 1,
        user_id = NULL
    WHERE matricula = ?
    AND fecha = ?
    AND user_id = ?
    AND disponible = 0
";

$stmt = $conexion->prepare($sql);

$stmt->execute([
    $matricula,
    $fecha,
    $id_usuario
]);

header("Location: ./my-booking.php");
exit();