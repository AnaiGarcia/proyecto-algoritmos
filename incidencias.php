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
    <title>Gestión de Incidencias</title>
    <link rel="stylesheet" href="assets/css/incidencias.css">
    <script src="assets/js/incidencias.js" defer></script>
</head>
<body>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Gestión de Incidencias</h1>
         <!-- Contenedor para centrar el botón Registrar Incidencia -->
         <div class="contenedor-boton">
            <button class="btn" onclick="registrarIncidencia()">Registrar Incidencia</button>
        </div>
         <!-- Contenedor para centrar el campo de búsqueda y el botón Buscar -->
         <div class="contenedor-busqueda">
            <input type="text" id="busquedaId" placeholder="Buscar por ID" class="max-w-[200px]" />
            <button class="btn" onclick="buscarPorId()">Buscar</button>
        </div>

        <!-- Contenedor para el formulario de registrar incidencia -->
        <div id="formularioIncidenciaContenedor" style="display: none;">
           
            <form id="formIncidencia" onsubmit="guardarIncidencia(event)">
                <label for="descripcion">Descripción:</label>
                <input type="text" id="descripcion" name="descripcion" required>

                <label for="equipo">Equipo:</label>
                <select id="equipos" name="equipo">
                    <option value="">Selecciona un equipo...</option>
                </select>

                <label for="prioridad">Prioridad:</label>
                <select id="prioridad" name="prioridad">
                    <option value="">Selecciona la prioridad...</option>
                    <option value="Baja">Baja</option>
                    <option value="Media">Media</option>
                    <option value="Alta">Alta</option>
                </select>

                <button type="submit" class="btn">Guardar Incidencia</button>
                <button type="button" class="btn" onclick="cancelarFormulario()">Cancelar</button>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Equipo</th>
                    <th>Problema</th>
                    <th>Aperturado</th>
                    <th>Prioridad</th>
                    <th>Situacion</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="incidenciasTableBody">
                <!-- Las filas de las incidencias se generarán aquí dinámicamente -->
            </tbody>
        </table>
    </div>

    <!-- Botón de volver al inicio fuera del contenedor y centrado -->
    <div class="volver">
        <button class="btn" onclick="volverAlInicio()">Volver al Inicio</button>
    </div>
</body>
</html>