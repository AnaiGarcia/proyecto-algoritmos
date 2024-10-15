<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
    <!-- Imagen de fondo -->
    <div class="background-image"></div>
    
    <!-- Página de inicio de sesión -->
    <div class="login-container">
        <div class="login-card">
            <h1 class="card-title">Iniciar Sesión</h1>
            <p class="card-description">Ingrese sus credenciales para acceder a su cuenta</p>
            <form action="#" method="POST" class="login-form">
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" id="email" name="email" placeholder="correo@ejemplo.com" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="submit-button">Iniciar Sesión</button>
            </form>
            <div class="footer-links">
                <a href="forgot-password.html" class="link">Olvidé mi Contraseña</a>
                <p class="register-link">¿No tienes una cuenta? <a href="REGISTRARSE.html" class="link">Registrarse</a></p>
            </div>
            
        </div>
        <div class="back-to-home">
            <a href="index.php" class="btn">Volver al Inicio</a> <!-- Cambia "index.html" por la URL de tu página de inicio -->
        </div>
    </div>
</body>
</html>