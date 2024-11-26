let incidencias = [];
var incidenciaSeleccionado = null;
let equipos = [];
let tecnicos = [];

function registrarIncidencia() {
    document.getElementById('formularioIncidenciaContenedor').style.display = 'block';
}

async function guardarIncidencia(event) {
    event.preventDefault();

    const descripcion = document.getElementById('descripcion').value;
    const equipo_id = document.getElementById('equipos').value;
    const tecnico_id = document.getElementById('tecnicos').value;
    const prioridad = document.getElementById('prioridad').value;

    if (descripcion && equipos && prioridad) {

        const body = new FormData();
        body.append('descripcion', descripcion);
        body.append('equipo_id', equipo_id);
        body.append('tecnico_id', tecnico_id);
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
    document.getElementById('tecnicos').value = '';
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
        let accion =  ``;
        if(!incidencia.fecha_cierre){
            accion = `<button class="btn" onclick="cambiarEstado(${incidencia.id})">Finalizar</button>`;
        }
        row.innerHTML = `
                    <td>${incidencia.id}</td>
                    <td>${incidencia.equipo_nombre}</td>
                    <td>${incidencia.descripcion}</td>
                    <td>${incidencia.fecha_apertura}</td>
                    <td>${incidencia.prioridad}</td>
                    <td>${incidencia.situacion}</td>
                    <td>
                        ${accion}
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

async function cambiarEstado(id) {
    const solucion = prompt("Ingresa la solucion:");
    if (solucion) {

        const response = await fetch('api/incidencias/editar.php', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `id=${id}&solucion=${solucion}`
        });

        const result = await response.json();

        if (result.success) {
            alert(result.success);
        } else {
            alert('Error: ' + result.error);
        }

        cargarIncidencias();
    }
}

function volverAlInicio() {
    window.location.href = 'index.php';
}

cargarIncidencias();
cargarEquipos();
cargarTecnicos();