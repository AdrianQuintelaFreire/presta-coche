<?php
require_once __DIR__ . '/../../config/conexion.php';

class AuthController {

    public function register() {
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        global $conexion;

        $sql = "INSERT INTO usuarios (nome, email, contrasinal) VALUES (?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$nombre, $email, $password]);

        header("Location: /prestacoche/public/login.php");
    }

    public function login() {
        session_start();

        $email = $_POST['email'];
        $password = $_POST['password'];

        global $conexion;

        $sql = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$email]);

        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['contrasinal'])) {
            $_SESSION['user_id'] = $user['id_usuario'];
            header("Location: /prestacoche/public/index.php");
        } else {
            echo "Credenciales incorrectas";
        }
    }
}
?>