<?php
session_start();

// Si no está logueado o si está logueado pero NO es admin, fuera.
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: /prestacoche/public/login.php");
    exit();
}

// El resto del código de la página de admin va aquí...
?>