<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio de sesión - PrestaCoche</title>
    <link rel="stylesheet" href="./css/main.css">
</head>
<body class="body-login">

    <main class="login-container">
        <section class="login-form">
            <!-- Enlace para volver atrás -->
            <a href="./index.php" class="login-form__back">← Volver al inicio</a>

            <h1 class="login-form__title">Inicia Sesión</h1>

            <form action="/prestacoche/routes/web.php?action=login" method="POST" class="login-form__form">
                <div class="login-form__field">
                    <input type="email" name="email" class="login-form__input" placeholder="Correo" required>
                </div>
                
                <div class="login-form__field">
                    <input type="password" name="password" class="login-form__input" placeholder="Contraseña" required>
                </div>

                <button type="submit" class="login-form__button">Iniciar sesión</button>
            </form>

            <div class="login-form__footer">
                <a href="./register.php" class="login-form__link">Todavía no tengo cuenta</a>
            </div>
        </section>
    </main>

</body>
</html>