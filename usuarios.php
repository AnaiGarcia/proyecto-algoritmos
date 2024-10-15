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
  <title>Gestión de Usuarios</title>
  <link rel="stylesheet" href="assets/css/usuarios.css">
</head>
<body>
  <div class="container">
    <h1 class="title">Gestión de Usuarios</h1>
    
    <div class="add-user">
      <button id="addUserBtn" class="btn">Agregar Usuario</button>
    </div>

    <table class="user-table">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Email</th>
          <th>Rol</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody id="userTableBody">
        <!-- Las filas de usuarios se generarán dinámicamente aquí -->
      </tbody>
    </table>

    
<div id="modifyUserForm" class="modify-user hidden">
  <h2 id="formTitle">Agregar Nuevo Usuario</h2>
  <input type="text" id="userName" placeholder="Nombre">
  <input type="email" id="userEmail" placeholder="Email">
  <input type="text" id="userRole" placeholder="Rol">
  <button id="saveChangesBtn" class="btn btn-save">Guardar Cambios</button>
  <button id="cancelBtn" class="btn btn-cancel">Cancelar</button>
</div>
  </div>
  <script src="assets/js/usuarios.js"></script>
  <div class="back-to-top">
    <a href="index.php">Volver al inicio</a>
</div>

</body>
</html>