<?php
require_once __DIR__ . '/../../config/conexion.php';

class AuthController
{

    public function register()
    {
        require __DIR__ . '/../../config/conexion.php';

        // =========================
        // DATOS DEL FORMULARIO
        // =========================
        $nome = $_POST['nome'];
        $apelidos = $_POST['apelidos'];
        $email = $_POST['email'];
        $contrasinal_plano = $_POST['contrasinal'];
        // HASH
        $contrasinal = password_hash($contrasinal_plano, PASSWORD_DEFAULT);
        $dni = $_POST['dni'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        $data_nacemento = $_POST['data_nacemento'];
        $fecha_caducidad_dni = $_POST['fecha_caducidad_dni'];

        // =========================
        // FOTO DNI
        // =========================
        $numero_aleatorio_dni = rand(1, 1000);

        $extension_dni = pathinfo($_FILES['photo_DNI']['name'], PATHINFO_EXTENSION);

        $foto_dni = $dni . "_" . $numero_aleatorio_dni . "_dni." . $extension_dni;

        $directorio_dni = __DIR__ . "/../../storage/id/";

        $ruta_dni = $directorio_dni . $foto_dni;

        move_uploaded_file($_FILES['photo_DNI']['tmp_name'], $ruta_dni);

        // =========================
        // FOTO PERMISO CONDUCIR
        // =========================
        $numero_aleatorio_license = rand(1, 1000);

        $extension_license = pathinfo($_FILES['permiso_conducir']['name'], PATHINFO_EXTENSION);

        $permiso_conducir = $dni . "_" . $numero_aleatorio_license . "_carnet." . $extension_license;

        $directorio_permiso = __DIR__ . "/../../storage/license/";

        $ruta_permiso = $directorio_permiso . $permiso_conducir;

        move_uploaded_file($_FILES['permiso_conducir']['tmp_name'], $ruta_permiso);

        // =========================
        // INSERTAR EN BD
        // =========================
        $sql = "INSERT INTO usuarios 
        (
            nome,
            apelidos,
            email,
            contrasinal,
            dni,
            foto_dni,
            telefono,
            direccion,
            data_nacemento,
            permiso_conducir,
            fecha_caducidad_dni
        ) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conexion->prepare($sql);

        $stmt->execute([
            $nome,
            $apelidos,
            $email,
            $contrasinal,
            $dni,
            $foto_dni,
            $telefono,
            $direccion,
            $data_nacemento,
            $permiso_conducir,
            $fecha_caducidad_dni
        ]);

        header("Location: /prestacoche/public/login.php");
        exit();
    }

    public function login()
    {
        session_start();
        global $conexion;

        $email = $_POST['email'];
        $password = $_POST['contrasinal'];

        $sql = "SELECT * FROM usuarios WHERE email = ?";

        $stmt = $conexion->prepare($sql);

        $stmt->execute([$email]);

        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['contrasinal'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['rol'] = $user['rol'];
            $_SESSION['nome'] = $user['nome'];
            $_SESSION['email'] = $user['email'];

            if ($_SESSION['rol'] === 'admin') {
                header("Location: /prestacoche/public/admin.php");
            } else {
                header("Location: /prestacoche/public/index.php");
            }

            exit();

        } else {
            header("Location: /prestacoche/public/login.php");
            exit();
        }
    }
}
?>