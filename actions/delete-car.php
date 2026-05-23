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
| Eliminar vehículo
|--------------------------------------------------------------------------
*/

$sql = "DELETE FROM vehiculos
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

$redirect = $_GET['from'] ?? '/prestacoche/pages/admin_validate-cars.php';

header("Location: $redirect");
exit();