<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Incidencias</title>
    <link rel="stylesheet" href="estilo(incidencias).css"> <!-- Enlazando el archivo CSS -->
</head>
<body>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Gestión de Incidencias</h1>
        
        <div class="flex space-x-2 mb-4">
            <button class="btn" onclick="reportarIncidencia()">Reportar Incidencia</button>
            <button class="btn" onclick="ordenarPorPrioridad()">Ver Incidencias por Prioridad</button>
            <input type="text" id="busquedaId" placeholder="Buscar por ID" class="max-w-[200px]" />
            <button class="btn" onclick="buscarPorId()">Buscar</button>
            <button class="btn btn-asignar" onclick="asignarTecnico()">Asignar Técnico</button> <!-- Nuevo botón -->
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

        function reportarIncidencia() {
            const descripcion = prompt("Ingrese la descripción de la incidencia:");
            const equipo = prompt("Ingrese el equipo relacionado con la incidencia:"); // Solicitar el equipo
            const prioridad = prompt("Ingrese la prioridad (Baja, Media, Alta):");
            if (descripcion && equipo && prioridad) {
                const id = Math.max(...incidencias.map(inc => inc.id)) + 1;
                incidencias.push({ id, descripcion, equipo, estado: 'Abierta', prioridad });
                cargarIncidencias();
            }
        }

        function ordenarPorPrioridad() {
            incidencias.sort((a, b) => {
                const prioridades = { 'Alta': 3, 'Media': 2, 'Baja': 1 };
                return prioridades[b.prioridad] - prioridades[a.prioridad];
            });
            cargarIncidencias();
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

        function asignarTecnico() {
            const id = prompt("Ingrese el ID de la incidencia a la que desea asignar un técnico:");
            const tecnico = prompt("Ingrese el nombre del técnico asignado:");
            const incidencia = incidencias.find(inc => inc.id == id);
            if (incidencia) {
                // Aquí podrías agregar la lógica para asignar el técnico a la incidencia
                alert(`Técnico ${tecnico} asignado a la incidencia ID ${id}`);
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