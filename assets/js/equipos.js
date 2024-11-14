var equipos = [];

async function  listarEquipos   () {
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
    document.getElementById('formulario').style.display = 'block';
}

function cancelarFormulario() {
    document.getElementById('formulario').style.display = 'none';
    document.getElementById('nombre').value = '';
    document.getElementById('tipo').value = '';
    document.getElementById('ubicacion').value = '';
}

function agregarEquipo() {
    const nombre = document.getElementById('nombre').value;
    const tipo = document.getElementById('tipo').value;
    const ubicacion = document.getElementById('ubicacion').value;

    if (nombre && tipo && ubicacion) {
        const nuevoEquipo = {
            nombre: nombre,
            tipo: tipo,
            ubicacion: ubicacion,
        };

        equipos.push(nuevoEquipo);
        actualizarTabla();
        cancelarFormulario();
    } else {
        alert('Por favor, complete todos los campos.');
    }
}

function actualizarTabla() {
    const tabla = document.getElementById('equipos-body');
    tabla.innerHTML = ''; // Limpiar tabla existente

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
}

function filtrarEquipos() {
    const busqueda = document.getElementById('busqueda').value.toLowerCase();
    const tabla = document.getElementById('equipos-body');
    tabla.innerHTML = ''; // Limpiar tabla existente

    equipos.filter(equipo => equipo.nombre.toLowerCase().includes(busqueda)).forEach((equipo) => {
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
}

function editarEquipo(index) {
    const equipo = equipos[index];
    document.getElementById('nombre').value = equipo.nombre;
    document.getElementById('tipo').value = equipo.tipo;
    document.getElementById('ubicacion').value = equipo.ubicacion;
    document.getElementById('formulario').style.display = 'block';
    eliminarEquipo(index); // Elimina el equipo que se está editando
}

function eliminarEquipo(index) {
    equipos.splice(index, 1);
    actualizarTabla();
}

listarEquipos();