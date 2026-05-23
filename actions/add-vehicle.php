<?php

session_start();

require_once __DIR__ . '/../config/conexion.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: /prestacoche/public/login.php");
    exit();
}

$id_usuario = $_SESSION['user_id'];

$matricula = $_POST['matricula'];
$marca = $_POST['marca'];
$modelo = $_POST['modelo'];
$potencia = $_POST['potencia'];
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

// Número aleatorio entre 0 y 1000
$numeroAleatorio = rand(0, 1000);

// Obtener extensión del archivo (jpg, png, jpeg...)
$extension = pathinfo($foto['name'], PATHINFO_EXTENSION);

// Nombre final:
// matricula_numeroaleatorio_coche.ext
$nombreFoto = $matricula . "_" . $numeroAleatorio . "_coche." . $extension;

// Carpeta destino
$rutaDestino = "../storage/car/" . $nombreFoto;

// Mover archivo
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
            potencia,
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
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
        )";

$stmt = $conexion->prepare($sql);

$stmt->execute([
    $matricula,
    $id_usuario,
    $marca,
    $modelo,
    $potencia,
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

header("Location: /prestacoche/public/rent-your-car.php?success=1");
exit();