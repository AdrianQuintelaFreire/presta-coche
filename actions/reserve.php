<?php
session_start();
require_once __DIR__ . '/../config/conexion.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'ok' => false,
        'message' => 'Debes iniciar sesión'
    ]);
    exit;
}

$matricula = $_POST['matricula'] ?? null;
$fecha_inicio = $_POST['fecha_inicio'] ?? null;
$fecha_fin = $_POST['fecha_fin'] ?? null;
$user_id = $_SESSION['user_id'];

if (!$matricula || !$fecha_inicio || !$fecha_fin) {
    echo json_encode([
        'ok' => false,
        'message' => 'Faltan datos'
    ]);
    exit;
}

try {

    $inicio = new DateTime($fecha_inicio);
    $fin = new DateTime($fecha_fin);

    // si viene invertido
    if ($inicio > $fin) {
        $tmp = $inicio;
        $inicio = $fin;
        $fin = $tmp;
    }

    $conexion->beginTransaction();

    $intervalo = new DateInterval('P1D');
    $periodo = new DatePeriod($inicio, $intervalo, (clone $fin)->modify('+1 day'));

    foreach ($periodo as $dia) {

        $fecha = $dia->format('Y-m-d');

        // comprobar si ya está reservado
        $check = $conexion->prepare("
            SELECT disponible
            FROM vehiculos_disponibilidad
            WHERE matricula = ? AND fecha = ?
            LIMIT 1
        ");

        $check->execute([$matricula, $fecha]);
        $row = $check->fetch(PDO::FETCH_ASSOC);

        // si existe y NO está disponible → bloquear
        if ($row && $row['disponible'] == 0) {
            $conexion->rollBack();

            echo json_encode([
                'ok' => false,
                'message' => "El coche no está disponible el $fecha"
            ]);
            exit;
        }

        if ($row) {
            // actualizar
            $stmt = $conexion->prepare("
                UPDATE vehiculos_disponibilidad
                SET disponible = 0, user_id = ?
                WHERE matricula = ? AND fecha = ?
            ");
            $stmt->execute([$user_id, $matricula, $fecha]);

        } else {
            // insertar
            $stmt = $conexion->prepare("
                INSERT INTO vehiculos_disponibilidad (matricula, fecha, disponible, user_id)
                VALUES (?, ?, 0, ?)
            ");
            $stmt->execute([$matricula, $fecha, $user_id]);
        }
    }

    $conexion->commit();

    echo json_encode([
        'ok' => true
    ]);

} catch (Exception $e) {
    $conexion->rollBack();

    echo json_encode([
        'ok' => false,
        'message' => 'Error en la reserva'
    ]);
}
?>