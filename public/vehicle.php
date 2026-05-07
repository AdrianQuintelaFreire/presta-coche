<?php
// 1. Importamos la conexión
require_once __DIR__ . '/../config/conexion.php';

// 2. Recogemos la matrícula de la URL (GET)
// Usamos el operador null coalescing (??) para evitar errores si no existe
$matricula = $_GET['matricula'] ?? '';

if (empty($matricula)) {
    // Si alguien entra a vehicle.php sin matrícula, lo mandamos de vuelta
    header('Location: our-cars.php');
    exit;
}

// 3. Consultamos solo ESE vehículo
$sql = "SELECT * FROM vehiculos WHERE matricula = :matricula AND estado = 'validado' LIMIT 1";
$stmt = $conexion->prepare($sql);
$stmt->execute([':matricula' => $matricula]);
$coche = $stmt->fetch();

// 4. Si el coche no existe en la base de datos
if (!$coche) {
    die("Lo sentimos, el vehículo con matrícula " . htmlspecialchars($matricula) . " no existe o no está disponible.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalles del <?= htmlspecialchars($coche['marca'] . " " . $coche['modelo']) ?></title>
    <link rel="stylesheet" href="./css/main.css">
</head>
<body>
    <h1>Detalles del vehículo</h1>
    
    <div class="vehicle-detail">
        <!-- Aquí ya tienes acceso a todo el array $coche -->
        <p><strong>Matrícula:</strong> <?= htmlspecialchars($coche['matricula']) ?></p>
        <p><strong>Marca:</strong> <?= htmlspecialchars($coche['marca']) ?></p>
        <p><strong>Modelo:</strong> <?= htmlspecialchars($coche['modelo']) ?></p>
        <p><strong>Precio por día:</strong> <?= htmlspecialchars($coche['precio_dia']) ?> €</p>
        
        <!-- Puedes añadir más campos según tu base de datos -->
    </div>

    <a href="our-cars.php">Volver al catálogo</a>
</body>
</html>