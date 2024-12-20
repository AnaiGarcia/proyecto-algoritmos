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
    <title>Reportes de Gestión de Incidencias</title>
    <link rel="stylesheet" href="assets/css/reportes.css"> <!-- Enlace al archivo CSS externo -->
    <script>
        let tecnicos = [];

        async function cargarTecnicos() {
            const response = await fetch('api/tecnicos/listar.php');
            tecnicos = await response.json();

            const selectElement = document.getElementById('tecnicos');

            tecnicos.forEach(tecnico => {
                const option = document.createElement('option');
                option.value = tecnico.id;
                option.textContent = tecnico.nombres + ' ' + tecnico.apellidos;
                selectElement.appendChild(option);
            });
        }

        function reporte(event) {
            event.preventDefault();
            const report_type = document.getElementById('report-type').value;
            const start_date = document.getElementById('start-date').value;
            const end_date = document.getElementById('end-date').value;
            const tecnico = document.getElementById('tecnicos').value;
            const priority = document.getElementById('priority').value;
            const status = document.getElementById('status').value;
            if (report_type == 'incidencias') {
                window.open('http://localhost/proyecto-algoritmos/api/reporte-incidencias.php?start_date=' + start_date + '&end_date=' + end_date + '&priority=' + priority + '&tecnico=' + tecnico + '&status=' + status, "_blank");
            }
        }

        cargarTecnicos();
    </script>
</head>

<body>
    <div id="inicio" class="container">
        <h1>Reporte de Gestión de Incidencias</h1>
        <form onsubmit="reporte(event)">
            <div>
                <label for="report-type">Tipo de Reporte</label>
                <select id="report-type" name="report-type" required>
                    <option value="">Selecciona el tipo de reporte</option>
                    <option value="incidencias">Reporte de Incidencias</option>
                    <!--<option value="tecnicos">Reporte de Técnicos</option>
                    <option value="equipos">Reporte de Equipos</option>
                    <option value="sedes">Reporte de Sedes</option>
                    <option value="usuarios">Reporte de Usuarios</option>-->
                </select>
            </div>
            <div>
                <label for="start-date">Fecha de Inicio</label>
                <input type="date" id="start-date" name="start-date" required>
            </div>
            <div>
                <label for="end-date">Fecha de Fin</label>
                <input type="date" id="end-date" name="end-date" required>
            </div>
            <div>
                <label for="tecnico">Tecnico:</label>
                <select id="tecnicos" name="tecnico">
                    <option value="">Selecciona un tecnico...</option>
                </select>
            </div>
            <div>
                <label for="priority">Prioridad</label>
                <select id="priority" name="priority">
                    <option value="">Selecciona la prioridad</option>
                    <option value="alta">Alta</option>
                    <option value="media">Media</option>
                    <option value="baja">Baja</option>
                </select>
            </div>
            <div>
                <label for="status">Estado</label>
                <select id="status" name="status">
                    <option value="">Selecciona el estado</option>
                    <option value="abierta">Abierta</option>
                    <option value="cerrada">Cerrada</option>
                    <option value="en-progreso">En Progreso</option>
                </select>
            </div>
            <div>
                <button type="submit">Generar Reporte</button>
            </div>
        </form>

        <br>

        <!-- Botón para volver al inicio -->
        <div class="back-to-top">
            <a href="index.php" class="btn-back">Volver al inicio</a>
        </div>
    </div>
</body>

</html>