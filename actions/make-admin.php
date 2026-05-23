<?php

session_start();
require_once __DIR__ . '/../config/conexion.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    http_response_code(403);
    exit('No autorizado');
}

$id = $_POST['id'] ?? null;

if (!$id) {
    exit('ID inválido');
}

$sql = "UPDATE usuarios SET rol = 'admin' WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->execute([$id]);

echo "OK";