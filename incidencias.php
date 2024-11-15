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
    <link rel="stylesheet" href="assets/css/incidencias.css"> <!-- Enlazando el archivo CSS -->
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
                <input type="text" id="equipo" name="equipo" required>

                <label for="estado">Estado:</label>
                <select id="estado" name="estado">
                    <option value="Abierta">Abierta</option>
                    <option value="En Progreso">En Progreso</option>
                    <option value="Cerrada">Cerrada</option>
                </select>

                <label for="prioridad">Prioridad:</label>
                <select id="prioridad" name="prioridad">
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
                    <th>Descripción</th>
                    <th>Equipo</th> <!-- Nueva columna para equipo -->
                    <th>Estado</th>
                    <th>Prioridad</th>
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

    <script>
        // Datos de ejemplo
        const incidenciasIniciales = [
            { id: 1, descripcion: "Error en la página de inicio", equipo: "Servidor Web", estado: "Abierta", prioridad: "Alta" },
            { id: 2, descripcion: "Problema con el formulario de contacto", equipo: "Aplicación", estado: "En Progreso", prioridad: "Media" },
            { id: 3, descripcion: "Actualización de contenido necesaria", equipo: "CMS", estado: "Cerrada", prioridad: "Baja" },
        ];

        let incidencias = [...incidenciasIniciales];

        function registrarIncidencia() {
            document.getElementById('formularioIncidenciaContenedor').style.display = 'block';
        }

        function guardarIncidencia(event) {
            event.preventDefault();

            const descripcion = document.getElementById('descripcion').value;
            const equipo = document.getElementById('equipo').value;
            const estado = document.getElementById('estado').value;
            const prioridad = document.getElementById('prioridad').value;

            if (descripcion && equipo && estado && prioridad) {
                const id = Math.max(...incidencias.map(inc => inc.id)) + 1;
                incidencias.push({ id, descripcion, equipo, estado, prioridad });
                cargarIncidencias();
                cancelarFormulario();
            }
        }

        function cancelarFormulario() {
            document.getElementById('formularioIncidenciaContenedor').style.display = 'none';
        }

        function buscarPorId() {
            const id = document.getElementById('busquedaId').value;
            const incidencia = incidencias.find(inc => inc.id == id);
            if (incidencia) {
                alert(`Incidencia encontrada: ${JSON.stringify(incidencia)}`);
            } else {
                alert('Incidencia no encontrada');
            }
        }

        function cargarIncidencias() {
            const tbody = document.getElementById('incidenciasTableBody');
            tbody.innerHTML = '';
            incidencias.forEach(incidencia => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${incidencia.id}</td>
                    <td>${incidencia.descripcion}</td>
                    <td>${incidencia.equipo}</td> <!-- Mostrar el equipo en la tabla -->
                    <td>${incidencia.estado}</td>
                    <td>${incidencia.prioridad}</td>
                    <td>
                        <button class="btn" onclick="cambiarEstado(${incidencia.id})">Cambiar Estado</button>
                    </td>
                `;
                tbody.appendChild(row);
            });
        }

        function cambiarEstado(id) {
            const nuevoEstado = prompt("Ingrese el nuevo estado (Abierta, En Progreso, Cerrada):");
            if (nuevoEstado) {
                const incidencia = incidencias.find(inc => inc.id === id);
                if (incidencia) {
                    incidencia.estado = nuevoEstado;
                    cargarIncidencias();
                }
            }
        }

        function volverAlInicio() {
            window.location.href = 'index.php'; // Cambia esto a la ruta de tu página de inicio
        }

        // Cargar las incidencias iniciales al cargar la página
        cargarIncidencias();
    </script>
</body>
</html>