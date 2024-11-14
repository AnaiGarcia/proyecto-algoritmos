<?php
session_start();
error_reporting(0);
include('config/db.php');

if ($_SESSION['auth_user'] != '') {
    header("Location: index.php");
}
if (isset($_POST['login'])) {
    $user = $_POST['user'];
    $password = md5($_POST['password']);
    $sql = "SELECT * FROM usuario WHERE nick=:user and clave=:password limit 1";
    $query = $dbh->prepare($sql);
    $query->bindParam(':user', $user, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch();
    if ($result) {
        $_SESSION['auth_user'] = $result['nick'];
        echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
    } else {
        echo "<script>alert('Datos Invalidos');</script>";
    }
}
?>
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
            <form method="POST" class="login-form">
                <div class="form-group">
                    <label for="user">Correo Electrónico</label>
                    <input type="text" id="user" name="user" placeholder="Ingresa tu usuario" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" name="login" class="submit-button">Iniciar Sesión</button>
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