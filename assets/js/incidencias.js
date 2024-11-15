let incidencias = [];
var incidenciaSeleccionado = null;
let equipos = [];

function registrarIncidencia() {
    document.getElementById('formularioIncidenciaContenedor').style.display = 'block';
}

async function guardarIncidencia(event) {
    event.preventDefault();

    const descripcion = document.getElementById('descripcion').value;
    const equipo_id = document.getElementById('equipos').value;
    const prioridad = document.getElementById('prioridad').value;

    if (descripcion && equipos && prioridad) {

        const body = new FormData();
        body.append('descripcion', descripcion);
        body.append('equipo_id', equipo_id);
        body.append('prioridad', prioridad);
        const response = await fetch('api/incidencias/guardar.php', {
            method: 'POST',
            body
        });

        const result = await response.json();

        if (result.success) {
            alert(result.success);
        } else {
            alert('Error: ' + result.error);
        }

        cargarIncidencias();
        cancelarFormulario();
    }
}

function cancelarFormulario() {
    document.getElementById('formularioIncidenciaContenedor').style.display = 'none';
    document.getElementById('descripcion').value = '';
    document.getElementById('equipos').value = '';
    document.getElementById('prioridad').value = '';
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

async function cargarIncidencias() {
    const tbody = document.getElementById('incidenciasTableBody');
    tbody.innerHTML = '';

    const response = await fetch('api/incidencias/listar.php');
    incidencias = await response.json();

    incidencias.forEach(incidencia => {
        const row = document.createElement('tr');
        row.innerHTML = `
                    <td>${incidencia.id}</td>
                    <td>${incidencia.equipo_nombre}</td>
                    <td>${incidencia.descripcion}</td>
                    <td>${incidencia.fecha_apertura}</td>
                    <td>${incidencia.prioridad}</td>
                    <td>${incidencia.situacion}</td>
                    <td>
                        <button class="btn" onclick="cambiarEstado(${incidencia.id})">Cambiar Estado</button>
                    </td>
                `;
        tbody.appendChild(row);
    });
}

async function cargarEquipos() {
    const response = await fetch('api/equipos/listar.php');
    equipos = await response.json();

    const selectElement = document.getElementById('equipos');

    equipos.forEach(equipo => {
        const option = document.createElement('option');
        option.value = equipo.id;
        option.textContent = equipo.nombre + ' ' + equipo.tipo;
        selectElement.appendChild(option);
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
    window.location.href = 'index.php';
}

cargarIncidencias();
cargarEquipos();