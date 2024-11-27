var equipos = [];
var equipoSeleccionado = null;

async function listarEquipos() {
    const response = await fetch('api/equipos/listar.php');
    if (response.ok) {
        equipos = await response.json();
        if (equipos.error) {
            console.error('Error al obtener los equipos:', equipos.error);
            return;
        }
        actualizarTabla();
    } else {
        console.error('Error al conectar con el servidor');
    }
}

function mostrarFormulario() {
    equipoSeleccionado = null;
    document.getElementById('formulario').style.display = 'block';
}

function resetearFormulario() {
    document.getElementById('formulario').style.display = 'none';
    document.getElementById('nombre').value = '';
    document.getElementById('tipo').value = '';
    document.getElementById('ubicacion').value = '';
}

async function agregarEquipo() {
    const nombre = document.getElementById('nombre').value;
    const tipo = document.getElementById('tipo').value;
    const ubicacion = document.getElementById('ubicacion').value;

    if (nombre && tipo && ubicacion) {
        let response;
        if (equipoSeleccionado) {
            response = await fetch('api/equipos/editar.php', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `id=${equipoSeleccionado.id}&nombre=${nombre}&tipo=${tipo}&ubicacion=${ubicacion}`
            });
        } else {
            const body = new FormData();
            body.append('nombre', nombre);
            body.append('tipo', tipo);
            body.append('ubicacion', ubicacion);
            response = await fetch('api/equipos/guardar.php', {
                method: 'POST',
                body
            });
        }

        const result = await response.json();

        if (result.success) {
            alert(result.success);
        } else {
            alert('Error: ' + result.error);
        }

        listarEquipos();
        resetearFormulario();
    } else {
        alert('Por favor, complete todos los campos.');
    }
}

function actualizarTabla() {
    const tabla = document.getElementById('equipos-body');
    tabla.innerHTML = ''; // Limpiar tabla existente

    if (equipos.length) {
        equipos.forEach((equipo, index) => {
            const fila = document.createElement('tr');
            fila.innerHTML = `
                <td>${equipo.nombre}</td>
                <td>${equipo.tipo}</td>
                <td>${equipo.ubicacion}</td>
                <td>
                    <button class="btn" onclick="editarEquipo(${index})">Editar</button>
                    <button class="btn" onclick="eliminarEquipo(${index})">Eliminar</button>
                </td>
            `;
            tabla.appendChild(fila);
        });
    } else {
        const fila = document.createElement('tr');
        fila.innerHTML = `
                <td rowpan="4">No se encontraron resultados...</td>
            `;
        tabla.appendChild(fila);
    }
}

async function filtrarEquipos() {
    const busqueda = document.getElementById('busqueda').value.toLowerCase();
    if (busqueda != '') {
        const response = await fetch(`api/equipos/busqueda_por_nombre.php?atributo=nombre&valor=${busqueda}`);
        equipos = await response.json();
        actualizarTabla();
    } else {
        listarEquipos();
    }
}

function editarEquipo(index) {
    equipoSeleccionado = equipos[index];
    document.getElementById('nombre').value = equipoSeleccionado.nombre;
    document.getElementById('tipo').value = equipoSeleccionado.tipo;
    document.getElementById('ubicacion').value = equipoSeleccionado.ubicacion;
    document.getElementById('formulario').style.display = 'block';
}

async function eliminarEquipo(index) {
    if (confirm('Está seguro de eliminar este equipo?')) {

        equipoSeleccionado = equipos[index];

        if (equipoSeleccionado) {
            let response = await fetch('api/equipos/eliminar.php', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `id=${equipoSeleccionado.id}`
            });

            const result = await response.json();

            if (result.success) {
                alert(result.success);
            } else {
                alert('Error: ' + result.error);
            }

            listarEquipos();
            resetearFormulario();
        }
        actualizarTabla();
    }
}

function pdf() {
    window.open('http://localhost/proyecto-algoritmos/api/reporte-equipos.php', "_blank");
}

listarEquipos();