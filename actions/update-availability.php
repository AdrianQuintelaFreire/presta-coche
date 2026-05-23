<?php

require_once __DIR__ . '/../config/conexion.php';

$matricula = $_POST['matricula'];

$fechas = explode(", ", $_POST['fechas']);

// borrar antiguas
$sqlDelete = "
DELETE FROM vehiculos_disponibilidad
WHERE matricula = ?
";

$stmtDelete = $conexion->prepare($sqlDelete);

$stmtDelete->execute([$matricula]);

// insertar nuevas
$sqlInsert = "
INSERT INTO vehiculos_disponibilidad
(matricula, fecha, disponible)
VALUES (?, ?, 1)
";

$stmtInsert = $conexion->prepare($sqlInsert);

foreach ($fechas as $fecha) {

    $stmtInsert->execute([
        $matricula,
        $fecha
    ]);

}

header("Location: /prestacoche/pages/my-cars.php");
exit;
?>