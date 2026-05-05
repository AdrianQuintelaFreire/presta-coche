<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - PrestaCoche</title>
    <link rel="stylesheet" href="./css/main.css">
</head>
<body class="body-login"> <!-- Para el fondo gris -->
    <main class="login-container"> <!-- Para el centrado -->
        <section class="register-form"> <!-- La caja blanca -->
            <!-- Enlace para volver atrás -->
            <a href="index.php" class="register-form__back">← Volver al inicio</a>
            <h1 class="register-form__title">Crear cuenta</h1>

            <form action="/prestacoche/routes/web.php?action=register" method="POST" class="register-form__form">
                <!-- Nome -->
                <input type="text" name="nome" class="register-form__input" placeholder="Nombre" required>

                <!-- Apelidos -->
                <input type="text" name="apelidos" class="register-form__input" placeholder="Apellidos" required>

                <!-- Email -->
                <input type="email" name="email" class="register-form__input" placeholder="Correo electrónico" required>

                <!-- Contrasinal -->
                <input type="password" name="contrasinal" class="register-form__input" placeholder="Contraseña" required>

                <!-- DNI -->
                <input type="text" name="DNI" class="register-form__input" placeholder="DNI / NIE" required>

                <!-- Teléfono -->
                <input type="tel" name="telefono" class="register-form__input" placeholder="Teléfono" required>

                <!-- Dirección -->
                <input type="text" name="direccion" class="register-form__input" placeholder="Dirección completa" required>

                <!-- Data de nacemento -->
                <label for="data_nacemento" class="register-form__label">Fecha de nacimiento:</label>
                <input type="date" name="data_nacemento" id="data_nacemento" class="register-form__input" required>

                <!-- Permiso de conducir (Archivo) -->
                <label for="permiso_conducir" class="register-form__label">Foto del permiso de conducir:</label>
                <input type="file" name="permiso_conducir" id="permiso_conducir" class="register-form__input" accept="image/*" required>
                
                <button type="submit" class="register-form__button">Registrarse</button>
            </form>

            <div class="register-form__footer">
                <a href="login.php" class="register-form__link">Ya tengo cuenta</a>
            </div>
        </section>
    </main>
</body>
</html>