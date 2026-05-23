<?php

session_start();

require_once __DIR__ . '/../config/conexion.php';

/*
|--------------------------------------------------------------------------
| Seguridad admin
|--------------------------------------------------------------------------
*/

if (
    !isset($_SESSION['rol']) ||
    $_SESSION['rol'] !== 'admin'
) {
    header("Location: /prestacoche/public/login.php");
    exit();
}

/*
|--------------------------------------------------------------------------
| Obtener matrícula
|--------------------------------------------------------------------------
*/

$matricula = $_GET['matricula'] ?? '';

if (empty($matricula)) {

    header("Location: /prestacoche/pages/admin_validate-cars.php");
    exit();

}

/*
|--------------------------------------------------------------------------
| Validar vehículo
|--------------------------------------------------------------------------
*/

$sql = "UPDATE vehiculos
        SET estado = 'validado'
        WHERE matricula = :matricula";

$stmt = $conexion->prepare($sql);

$stmt->execute([
    ':matricula' => $matricula
]);

/*
|--------------------------------------------------------------------------
| Volver al listado
|--------------------------------------------------------------------------
*/

header("Location: /prestacoche/pages/admin_validate-cars.php");
exit();