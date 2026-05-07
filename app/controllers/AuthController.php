<?php
require_once __DIR__ . '/../../config/conexion.php';

class AuthController {

    public function register() {
        // 1. Incluimos el archivo de conexión para tener acceso a la variable $conexion
        require __DIR__ . '/../../config/conexion.php';

        // 2. Recoger datos del formulario
        $nome = $_POST['nome'];
        $apelidos = $_POST['apelidos'];
        $email = $_POST['email'];
        $contrasinal = password_hash($_POST['contrasinal'], PASSWORD_DEFAULT);
        $dni = $_POST['DNI'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        $data_nacemento = $_POST['data_nacemento'];

        // 3. Manejo de la foto (Permiso de conducir)
        $permiso_conducir = $_FILES['permiso_conducir']['name'];
        
        // Carpeta donde se guardarán las fotos (debes crearla en tu servidor)
        $directorio_destino = __DIR__ . "/../../public/uploads/";
        $ruta_final = $directorio_destino . basename($permiso_conducir);
        
        // Movemos el archivo de la carpeta temporal a nuestra carpeta final
        move_uploaded_file($_FILES['permiso_conducir']['tmp_name'], $ruta_final);

        // 4. Preparar e insertar en la BD
        $sql = "INSERT INTO usuarios (nome, apelidos, email, contrasinal, dni, telefono, direccion, data_nacemento, permiso_conducir) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conexion->prepare($sql);
        $stmt->execute([
            $nome, 
            $apelidos, 
            $email, 
            $contrasinal, 
            $dni, 
            $telefono, 
            $direccion, 
            $data_nacemento, 
            $permiso_conducir
        ]);

        header("Location: /prestacoche/public/login.php");
        exit();
    }

    public function login() {
        session_start();
        global $conexion;

        $email = $_POST['email'];
        $password = $_POST['contrasinal'];

        $sql = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            echo "<h3>Debug de Login:</h3>";
            echo "Contraseña escrita en el form: " . $password . "<br>";
            echo "Hash recuperado de la BD: " . $user['contrasinal'] . "<br>";
            echo "Longitud del hash en BD: " . strlen($user['contrasinal']) . " caracteres.<br>";

            if ($user && password_verify($password, $user['contrasinal'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['rol'] = $user['rol']; // <--- Guardamos el rol (admin o user)
                
                // Redirección inteligente
                if ($_SESSION['rol'] === 'admin') {
                    header("Location: /prestacoche/public/admin_dashboard.php");
                } else {
                    header("Location: /prestacoche/public/index.php");
                }
                exit();
            }
        } else {
            echo "Usuario no encontrado.";
        }
        exit(); // Detenemos la ejecución para ver los mensajes
    }
}
?>