<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Sedes</title>
    <link rel="stylesheet" href="assets/css/sedes.css"> <!-- Enlazando el archivo CSS -->
</head>
<body>
    <div class="container">
        <h1 class="title">Gestión de Sedes</h1>
        
        <div class="actions">
            <button class="btn" onclick="registrarSede()">Registrar Sede</button>
            <input type="text" id="search" placeholder="Buscar sede..." class="search-input" />
            <button class="btn" onclick="buscarSede()">Buscar</button>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>Ciudad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="sedesTableBody">
                <!-- Las filas de las sedes se generarán aquí dinámicamente -->
            </tbody>
        </table>
    </div>

    <!-- Botón de volver al inicio fuera del contenedor y centrado -->
    <div class="volver">
        <button class="btn volver-btn" onclick="volverAlInicio()">Volver al Inicio</button>
    </div>

    <script>
        // Datos de ejemplo
        const sedes = [
            { id: 1, nombre: "Sede Central", direccion: "Calle Principal 123", ciudad: "Ciudad A" },
            { id: 2, nombre: "Sede Norte", direccion: "Avenida Norte 456", ciudad: "Ciudad B" },
            { id: 3, nombre: "Sede Sur", direccion: "Bulevar Sur 789", ciudad: "Ciudad C" },
        ];

        function cargarSedes() {
            const tbody = document.getElementById('sedesTableBody');
            tbody.innerHTML = ''; // Limpiar tabla
            sedes.forEach(sede => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${sede.nombre}</td>
                    <td>${sede.direccion}</td>
                    <td>${sede.ciudad}</td>
                    <td>
                        <button class="btn" onclick="modificarSede(${sede.id})">Modificar</button>
                        <button class="btn" onclick="eliminarSede(${sede.id})">Eliminar</button>
                    </td>
                `;
                tbody.appendChild(row);
            });
        }

        function registrarSede() {
            alert("Función para registrar una nueva sede");
            // Implementar lógica para registrar sede aquí
        }

        function modificarSede(id) {
            alert(`Modificar sede con ID: ${id}`);
            // Implementar lógica para modificar sede aquí
        }

        function eliminarSede(id) {
            alert(`Eliminar sede con ID: ${id}`);
            // Implementar lógica para eliminar sede aquí
        }

        function buscarSede() {
            const searchTerm = document.getElementById('search').value.toLowerCase();
            const filteredSedes = sedes.filter(sede => 
                sede.nombre.toLowerCase().includes(searchTerm) || 
                sede.ciudad.toLowerCase().includes(searchTerm)
            );
            // Cargar las sedes filtradas
            const tbody = document.getElementById('sedesTableBody');
            tbody.innerHTML = '';
            filteredSedes.forEach(sede => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${sede.nombre}</td>
                    <td>${sede.direccion}</td>
                    <td>${sede.ciudad}</td>
                    <td>
                        <button class="btn" onclick="modificarSede(${sede.id})">Modificar</button>
                        <button class="btn" onclick="eliminarSede(${sede.id})">Eliminar</button>
                    </td>
                `;
                tbody.appendChild(row);
            });
        }

        function volverAlInicio() {
            window.location.href = 'index.php'; // Cambia esto a la ruta de tu página de inicio
        }

        // Cargar las sedes iniciales al cargar la página
        cargarSedes();
    </script>
</body>
</html>