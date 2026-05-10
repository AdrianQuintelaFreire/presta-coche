<?php

session_start();

require_once '../config/conexion.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION['user_id'];

$matricula = $_POST['matricula'];
$marca = $_POST['marca'];
$modelo = $_POST['modelo'];
$combustible = $_POST['combustible'];
$kilometraxe = $_POST['kilometraxe'];
$tipo_cambio = $_POST['tipo_cambio'];
$año = $_POST['año'];
$precio_dia = $_POST['precio_dia'];
$precio_km = $_POST['precio_km'];
$direccion = $_POST['direccion'];

$estado = 'pendente';

/*
|--------------------------------------------------------------------------
| SUBIDA FOTO
|--------------------------------------------------------------------------
*/

$foto = $_FILES['foto'];

$nombreFoto = time() . "_" . basename($foto['name']);

$rutaDestino = "../storage/" . $nombreFoto;

move_uploaded_file($foto['tmp_name'], $rutaDestino);

/*
|--------------------------------------------------------------------------
| INSERT
|--------------------------------------------------------------------------
*/

$sql = "INSERT INTO vehiculos (
            matricula,
            id_usuario,
            marca,
            modelo,
            combustible,
            kilometraxe,
            tipo_cambio,
            estado,
            año,
            precio_dia,
            precio_km,
            direccion,
            foto
        ) VALUES (
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
        )";

$stmt = $conexion->prepare($sql);

$stmt->execute([
    $matricula,
    $id_usuario,
    $marca,
    $modelo,
    $combustible,
    $kilometraxe,
    $tipo_cambio,
    $estado,
    $año,
    $precio_dia,
    $precio_km,
    $direccion,
    $nombreFoto
]);

header("Location: rent-your-car.php?success=1");
exit();