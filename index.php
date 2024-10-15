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
  <title>La Casa del Alfajor - Dashboard</title>
  <link rel="stylesheet" href="assets/css/index.css">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
  <div class="container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="sidebar-header">
        <img src="assets/images/images.png" alt="Logo de La Casa del Alfajor" class="logo">
      </div>
      
      <nav class="sidebar-nav">
        <a href="#" class="nav-link active">
          <img src="assets/images/casa.png" alt="Inicio" class="icon-img">
          Panel de inicio
        </a>
        <a href="usuarios.php" class="nav-link">
          <img src="assets/images/usuarios.png" alt="Usuarios" class="icon-img">
          Usuarios
        </a>
        <a href="tecnicos.php" class="nav-link">
          <img src="assets/images/tec.jpeg" alt="Técnicos" class="icon-img">
          Técnicos
        </a>
        <a href="incidencias.php" class="nav-link">
          <img src="assets/images/incidencias.png" alt="Incidencias" class="icon-img">
          Incidencias
        </a>
        <a href="equipos.php" class="nav-link">
          <img src="assets/images/equipos.png" alt="Equipos" class="icon-img">
          Equipos
        </a>
        <a href="sedes.php" class="nav-link">
          <img src="assets/images/sede.png" alt="Sedes" class="icon-img">
          Sedes
        </a>
        <a href="reportes.php" class="nav-link">
          <img src="assets/images/reportes.png" alt="Reportes" class="icon-img">
          Reportes
        </a>
        <a href="salir.php" class="nav-link">
          <img src="assets/images/reportes.png" alt="Reportes" class="icon-img">
          Salir
        </a>
      </nav>
    </aside>

   <!-- Main Content -->
   <main class="main-content">

  
    <!--<div class="top-buttons">
      <a href="registrarse.php" class="top-button">Registrarse</a>
      <a href="login.php" class="top-button">Iniciar Sesión</a>
    </div>-->
    <div class="content-container">
      <div class="header">
        <h1 class="main-title">La Casa del Alfajor</h1>
        <h2 class="sub-title">Gestión de Incidencias</h2>
      </div>

      <div class="image-container">
        <img src="assets/images/Firefly creame ima imagen para portada de mi pagina web que contenga alfajores de diferentes sabores.jpg" alt="Imagen representativa de La Casa del Alfajor" class="main-image">
      </div>
    </div>
  </main>
</div>
</body>
</html>