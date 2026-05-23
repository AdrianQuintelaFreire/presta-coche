<!DOCTYPE html>
<HTML lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - PrestaCoche</title>
    <link rel="stylesheet" href="./css/main.css">
</head>

<body class="body-login"> <!-- Para el fondo gris -->
    <main class="register-container"> <!-- Para el centrado -->
        <section class="register-form"> <!-- La caja blanca -->
            <!-- Enlace para volver atrás -->
            <a href="index.php" class="register-form__back">← Volver al inicio</a>
            <h1 class="register-form__title">Crear cuenta</h1>

            <form action="/prestacoche/routes/web.php?action=register" method="POST" class="register-form__form"
                enctype="multipart/form-data">

                <!-- Nombre -->
                <label for="nome" class="register-form__label">
                    Nombre:
                </label>
                <input type="text" name="nome" id="nome" class="register-form__input" placeholder="Ej: Juan" required>

                <!-- Apellidos -->
                <label for="apelidos" class="register-form__label">
                    Apellidos:
                </label>
                <input type="text" name="apelidos" id="apelidos" class="register-form__input"
                    placeholder="Ej: Pérez García" required>

                <!-- Email -->
                <label for="email" class="register-form__label">
                    Correo electrónico:
                </label>
                <input type="email" name="email" id="email" class="register-form__input"
                    placeholder="Ej: juanperez@gmail.com" required>

                <!-- Teléfono -->
                <label for="telefono" class="register-form__label">
                    Teléfono:
                </label>
                <input type="tel" name="telefono" id="telefono" class="register-form__input" placeholder="Ej: 612345678"
                    required>

                <!-- Contraseña -->
                <label for="contrasinal" class="register-form__label">
                    Contraseña:
                </label>
                <input type="password" name="contrasinal" id="contrasinal" class="register-form__input"
                    placeholder="Ej: MiClave123" required>

                <!-- Confirmar contraseña -->
                <label for="contrasinal_confirm" class="register-form__label">
                    Confirmar contraseña:
                </label>
                <input type="password" name="contrasinal_confirm" id="contrasinal_confirm" class="register-form__input"
                    placeholder="Ej: MiClave123" required>

                <!-- Fecha de nacimiento -->
                <label for="data_nacemento" class="register-form__label">
                    Fecha de nacimiento:
                </label>
                <input type="date" name="data_nacemento" id="data_nacemento" class="register-form__input" required>

                <!-- Dirección -->
                <label for="direccion" class="register-form__label">
                    Dirección completa:
                </label>
                <input type="text" name="direccion" id="direccion" class="register-form__input"
                    placeholder="Ej: Calle Mayor 15, Ourense" required>

                <!-- DNI -->
                <label for="dni" class="register-form__label">
                    DNI / NIE:
                </label>
                <input type="text" name="dni" id="dni" class="register-form__input" placeholder="Ej: 10203040X"
                    required>

                <!-- Fecha de caducidad DNI -->
                <label for="fecha_caducidad_dni" class="register-form__label">
                    Fecha de caducidad del DNI:
                </label>
                <input type="date" name="fecha_caducidad_dni" id="fecha_caducidad_dni" class="register-form__input"
                    required>

                <!-- Foto DNI -->
                <label for="photo_DNI" class="register-form__label">
                    Foto DNI / NIE:
                </label>
                <input type="file" name="photo_DNI" id="photo_DNI" class="register-form__input" accept="image/*"
                    required>

                <!-- Permiso de conducir -->
                <label for="permiso_conducir" class="register-form__label">
                    Foto del permiso de conducir:
                </label>
                <input type="file" name="permiso_conducir" id="permiso_conducir" class="register-form__input"
                    accept="image/*" required>

                <button type="submit" class="register-form__button">
                    Registrarse
                </button>

            </form>

            <div class="register-form__footer">
                <a href="login.php" class="register-form__link">Ya tengo cuenta</a>
            </div>
        </section>
    </main>
    <script src="/prestacoche/public/js/register.js"></script>
</body>

</HTML>