<?php

session_start();

require_once '../config/conexion.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['matricula'])) {
    header("Location: my-cars.php");
    exit();
}

$matricula = $_GET['matricula'];
$id_usuario = $_SESSION['user_id'];

// Elimina SOLO vehículos del usuario logueado
$sql = "DELETE FROM vehiculos 
        WHERE matricula = ? 
        AND id_usuario = ?";

$stmt = $conexion->prepare($sql);

$stmt->execute([$matricula, $id_usuario]);

header("Location: my-cars.php");
exit();
?>