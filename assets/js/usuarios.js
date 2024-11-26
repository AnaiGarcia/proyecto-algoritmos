var usuarios = [];
var usuarioSeleccionado = null;

async function listarUsuarios() {
    const response = await fetch('api/usuarios/listar.php');
    if (response.ok) {
        usuarios = await response.json();
        if (usuarios.error) {
            console.error('Error al obtener los usuarios:', usuarios.error);
            return;
        }
        actualizarTabla();
    } else {
        console.error('Error al conectar con el servidor');
    }
}

function mostrarFormulario() {
    usuarioSeleccionado = null;
    document.getElementById('usuarioForm').style.display = 'block';
}

function resetearFormulario() {
    document.getElementById('usuarioForm').style.display = 'none';
    document.getElementById('nombre').value = '';
    document.getElementById('tipo').value = '';
    document.getElementById('ubicacion').value = '';
}

async function agregarUsuario() {
    const nombres = document.getElementById('nombres').value;
    const apellidos = document.getElementById('apellidos').value;
    const dni = document.getElementById('dni').value;
    const rol = document.getElementById('rol').value;
    const correo = document.getElementById('correo').value;
    const nick = document.getElementById('nick').value;
    const clave = document.getElementById('clave').value;

    if (nombres && apellidos && dni && rol && correo && nick && clave) {
        let response;
        if (usuarioSeleccionado) {
            response = await fetch('api/usuarios/editar.php', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `id=${usuarioSeleccionado.id}&nombres=${nombres}&apellidos=${apellidos}&dni=${dni}&rol=${rol}`
            });
        } else {
            const body = new FormData();
            body.append('nombres', nombres);
            body.append('apellidos', apellidos);
            body.append('dni', dni);
            body.append('rol', rol);
            body.append('correo', correo);
            body.append('nick', nick);
            body.append('clave', clave);
            response = await fetch('api/usuarios/guardar.php', {
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

        listarUsuarios();
        resetearFormulario();
    } else {
        alert('Por favor, complete todos los campos.');
    }
}

function actualizarTabla() {
    const tabla = document.getElementById('usuarios-body');
    tabla.innerHTML = '';

    if (usuarios.length) {
        const auth_rol = document.getElementById('auth_rol').value;
        usuarios.forEach((usuario, index) => {
            const fila = document.createElement('tr');
            fila.innerHTML = `
                <td>${usuario.nombres}</td>
                <td>${usuario.apellidos}</td>
                <td>${usuario.correo}</td>
                <td>${usuario.rol}</td>`;
                if (auth_rol && auth_rol == 'Administrador'){
                    fila.innerHTML += `<td><button class="btn" onclick="editarUsuario(${index})">Editar</button>
                    <button class="btn" onclick="eliminarUsuario(${index})">Eliminar</button></td>`;
                } else  {
                    fila.innerHTML += `<td></td>`;
                }
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

async function filtrarUsuarios() {
    const busqueda = document.getElementById('busqueda').value.toLowerCase();
    if (busqueda != '') {
        const response = await fetch(`api/usuarios/busqueda_por_nombre.php?atributo=nombre&valor=${busqueda}`);
        usuarios = await response.json();
        actualizarTabla();
    } else {
        listarUsuarios();
    }
}

function editarUsuario(index) {
    usuarioSeleccionado = usuarios[index];
    document.getElementById('nombres').value = usuarioSeleccionado.nombres;
    document.getElementById('apellidos').value = usuarioSeleccionado.apellidos;
    document.getElementById('dni').value = usuarioSeleccionado.dni;
    document.getElementById('rol').value = usuarioSeleccionado.rol;
    document.getElementById('correo').value = usuarioSeleccionado.correo;
    document.getElementById('nick').value = usuarioSeleccionado.nick;
    document.getElementById('clave').value = usuarioSeleccionado.clave;
    document.getElementById('usuarioForm').style.display = 'block';
}

function eliminarUsuario(index) {
    usuarios.splice(index, 1);
    actualizarTabla();
}

listarUsuarios();