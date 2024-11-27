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
    <title>Gestión de Equipos</title>
    <link rel="stylesheet" href="assets/css/equipos.css">
    <script src="assets/js/equipos.js" defer></script>
</head>
<body>
    <a name="inicio"></a>
    <div class="container">
        <h1 class="title">Gestión de Equipos</h1>
        
        <div class="actions">
            <button class="btn btn-save" id="btn-agregar" onclick="mostrarFormulario()">Registrar Equipo</button>
            <button class="btn" onclick="pdf()">Descargar PDF</button>
        </div>

        <div class="search-box">
            <input type="text" id="busqueda" placeholder="Buscar equipo por nombre..." oninput="filtrarEquipos()">
            <button class="btn" id="btn-buscar" onclick="filtrarEquipos()">Buscar</button>
        </div>

        <div id="formulario" class="formulario" style="display:none;">
            <input type="text" id="nombre" placeholder="Nombre" required>
            <input type="text" id="tipo" placeholder="Tipo" required>
            <input type="text" id="ubicacion" placeholder="Ubicación" required>
            <button class="btn" onclick="agregarEquipo()">Guardar datos</button>
            <button class="btn" onclick="resetearFormulario()">Cancelar</button>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Ubicación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="equipos-body">
            </tbody>
        </table>
    </div>

    <div class="back-to-top">
        <a href="index.php" class="btn">Volver al Inicio</a>
    </div>
</body>
</html>