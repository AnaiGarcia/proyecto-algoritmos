<?php
session_start();
error_reporting(0);
if (strlen($_SESSION['auth_user']) == "") {
  header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestión de Usuarios</title>
  <link rel="stylesheet" href="assets/css/usuarios.css">
</head>

<body>
  <div class="container">
    <h1 class="title">Gestión de Usuarios</h1>
    <?php
    if ($_SESSION['auth_rol'] && $_SESSION['auth_rol'] == 'Administrador') {
      echo '
      <div class="add-user">
          <button id="addUserBtn" class="btn btn-save" onclick="mostrarFormulario()">Agregar Usuario</button>
          <button class="btn" onclick="pdf()">Descargar PDF</button>
        </div>
      ';
    }
    ?>
    <table class="user-table">
      <thead>
        <tr>
          <th>Nombres</th>
          <th>Apellidos</th>
          <th>Email</th>
          <th>Rol</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody id="usuarios-body">
      </tbody>
    </table>

    <div id="usuarioForm" class="modify-user hidden">
      <h2 id="formTitle">Agregar Nuevo Usuario</h2>
      <input type="text" id="nombres" placeholder="Nombres" required>
      <input type="text" id="apellidos" placeholder="Apellidos" required>
      <input type="text" id="dni" placeholder="DNI" required>
      <select id="rol" name="rol" required>
        <option value="">Selecciona el rol...</option>
        <option value="Administrador">Administrador</option>
        <option value="Supervisor">Supervisor</option>
      </select>
      <input type="email" id="correo" placeholder="Correo" required>
      <input type="email" id="nick" placeholder="Nick" required>
      <input type="email" id="clave" placeholder="Clave" required>
      <button id="saveChangesBtn" class="btn btn-save" onclick="agregarUsuario()">Guardar Cambios</button>
      <button id="cancelBtn" class="btn btn-cancel" onclick="resetearFormulario()">Cancelar</button>
    </div>
  </div>
  <script src="assets/js/usuarios.js"></script>
  <div class="back-to-top">
    <a href="index.php">Volver al inicio</a>
  </div>
  <input type="text" id="auth_rol" style="display:none" value="<?php echo $_SESSION['auth_rol'] ?>" >
</body>

</html>