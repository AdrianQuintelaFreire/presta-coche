<?php
session_start();

// Si no está logueado o si está logueado pero NO es admin, fuera.
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: /prestacoche/public/login.php");
    exit();
}

// El resto del código de la página de admin va aquí...
?>

    <main>
                        <h1>Estás en zona admin</h1>
    </main>



<!--
Hacer updates de consultas de usuarios no validados
require 'conexion.php';

$hoy = date('Y-m-d');

$sql = "UPDATE usuarios
        SET validado = 'no'
        WHERE fecha_caducidad_dni < ?";

$stmt = $conexion->prepare($sql);
$stmt->execute([$hoy]);
-->
</body>
</HTML>