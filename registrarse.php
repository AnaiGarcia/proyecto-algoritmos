<?php
session_start();
error_reporting(0);
if(strlen($_SESSION['auth_user'])=="")
{   header("Location: login.php"); }
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro de Usuario</title>
  <link rel="stylesheet" href="assets/css/registro.css"> <!-- Vinculación del archivo CSS -->
</head>
<body>
  <div class="card">
    <div class="card-header">
      <h1>Registro de Usuario</h1>
      <p>Cree una nueva cuenta para acceder al sistema</p>
    </div>
    <form id="register-form">
      <div class="form-group">
        <label for="fullName">Nombre Completo</label>
        <input type="text" id="fullName" required>
      </div>
      <div class="form-group">
        <label for="email">Correo Electrónico</label>
        <input type="email" id="email" required>
      </div>
      <div class="form-group">
        <label for="password">Contraseña</label>
        <input type="password" id="password" required>
      </div>
      <div class="form-group">
        <label for="confirmPassword">Confirmar Contraseña</label>
        <input type="password" id="confirmPassword" required>
      </div>
      <div class="form-group">
        <label for="role">Rol</label>
        <select id="role" required>
          <option value="" disabled selected>Seleccione un rol</option>
          <option value="tecnico">Técnico</option>
          <option value="administrador">Administrador</option>
        </select>
      </div>
      <div id="alert" class="alert" style="display: none;">
        <h2>Error</h2>
        <p id="alert-message"></p>
      </div>
      <button type="submit" class="button" id="submit-button">Registrar</button>
    </form>
    <div class="card-footer">
      ¿Ya tienes una cuenta? <a href="login.php">Iniciar Sesión</a>
    </div>
  </div>
  <div class="back-to-top">
    <a href="INDEX.html" class="btn">Volver al Inicio</a>
  </div>
  <script>
    document.getElementById('register-form').addEventListener('submit', async function(e) {
      e.preventDefault();

      const fullName = document.getElementById('fullName').value;
      const email = document.getElementById('email').value;
      const password = document.getElementById('password').value;
      const confirmPassword = document.getElementById('confirmPassword').value;
      const role = document.getElementById('role').value;
      const alert = document.getElementById('alert');
      const alertMessage = document.getElementById('alert-message');
      const submitButton = document.getElementById('submit-button');

      alert.style.display = 'none';
      submitButton.disabled = true;

      if (password !== confirmPassword) {
        alertMessage.textContent = 'Las contraseñas no coinciden.';
        alert.style.display = 'block';
        submitButton.disabled = false;
        return;
      }

      if (!role) {
        alertMessage.textContent = 'Por favor, seleccione un rol.';
        alert.style.display = 'block';
        submitButton.disabled = false;
        return;
      }

      setTimeout(() => {
        // Aquí iría la lógica real de registro
        console.log('Registro exitoso', { fullName, email, role });
        submitButton.disabled = false;
        // Redirigir o mostrar mensaje de éxito (no implementado aquí)
      }, 1500);
    });
  </script>
</body>
</html>