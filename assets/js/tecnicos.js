let tecnicoSeleccionado = null; // Variable para almacenar el técnico que se va a editar
let tecnicos = []; // Array para almacenar técnicos

// Cargar técnicos del almacenamiento local al cargar la página
window.onload = function () {
  listarTecnicos();
};

async function listarTecnicos() {
  const response = await fetch('api/tecnicos/listar.php');
  if (response.ok) {
    tecnicos = await response.json();
    if (tecnicos.error) {
      console.error('Error al obtener los tecnicos:', tecnicos.error);
      return;
    }
    actualizarTabla();
  } else {
    console.error('Error al conectar con el servidor');
  }
}

function actualizarTabla() {
  const tabla = document.getElementById('tecnicos-body');
  tabla.innerHTML = '';

  if (tecnicos.length) {
    const auth_rol = document.getElementById('auth_rol').value;
    tecnicos.forEach((tecnico, index) => {
      const fila = document.createElement('tr');
      fila.innerHTML = `
              <td>${tecnico.nombres}</td>
              <td>${tecnico.apellidos}</td>
              <td>${tecnico.especialidad}</td>
              <td>${tecnico.experiencia}</td>`;
      if (auth_rol && auth_rol == 'Administrador') {
        fila.innerHTML += `<td><button class="btn" onclick="editarUsuario(${index})">Editar</button>
                  <button class="btn" onclick="eliminarUsuario(${index})">Eliminar</button></td>`;
      } else {
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

function mostrarFormulario() {
  document.getElementById('formulario-tecnico').style.display = 'block';
  document.getElementById('nombres').value = '';
  document.getElementById('apellidos').value = '';
  document.getElementById('especialidad').value = '';
  document.getElementById('experiencia').value = '';
  document.getElementById('btn-guardar').style.display = 'inline-block';
  document.getElementById('btn-editar').style.display = 'none';
}

function agregarTecnico() {
  const nombre = document.getElementById('nombres').value;
  const especialidad = document.getElementById('especialidad').value;
  const experiencia = document.getElementById('experiencia').value;

  if (nombre && especialidad && experiencia) {
    if (!tecnicoYaExiste(nombre)) {
      agregarTecnicoTabla();
      document.getElementById('formulario-tecnico').style.display = 'none';
    } else {
      alert('Ya existe un técnico con ese nombre.');
    }
  } else {
    alert('Por favor, complete todos los campos.');
  }
}

function tecnicoYaExiste(nombre) {
  return tecnicos.some(tecnico => tecnico.nombre === nombre);
}

async function agregarTecnicoTabla() {
  const nombres = document.getElementById('nombres').value;
  const apellidos = document.getElementById('apellidos').value;
  const experiencia = document.getElementById('experiencia').value;
  const especialidad = document.getElementById('especialidad').value;

  if (nombres && apellidos && experiencia && especialidad) {
    let response;
    if (tecnicoSeleccionado) {
      response = await fetch('api/tecnicos/editar.php', {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `id=${tecnicoSeleccionado.id}&nombres=${nombres}&apellidos=${apellidos}&dni=${dni}&rol=${rol}`
      });
    } else {
      const body = new FormData();
      body.append('nombres', nombres);
      body.append('apellidos', apellidos);
      body.append('experiencia', experiencia);
      body.append('especialidad', especialidad);
      response = await fetch('api/tecnicos/guardar.php', {
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

    listarTecnicos();
    mostrarFormulario();
  } else {
    alert('Por favor, complete todos los campos.');
  }
}

function eliminarTecnico(button) {
  const row = button.closest('tr');
  const nombre = row.cells[0].innerText;
  tecnicos = tecnicos.filter(tecnico => tecnico.nombre !== nombre); // Actualizar array
  row.remove();
}

function editarDatos(button) {
  const row = button.closest('tr');
  tecnicoSeleccionado = row; // Guardamos la referencia a la fila que se va a editar
  const celdas = row.getElementsByTagName('td');
  document.getElementById('nombres').value = celdas[0].innerText;
  document.getElementById('especialidad').value = celdas[1].innerText;
  document.getElementById('experiencia').value = celdas[2].innerText;
  document.getElementById('btn-guardar').style.display = 'none';
  document.getElementById('btn-editar').style.display = 'inline-block';
  document.getElementById('formulario-tecnico').style.display = 'block';
}

function editarTecnico() {
  if (tecnicoSeleccionado) {
    const nombre = document.getElementById('nombres').value;
    const especialidad = document.getElementById('especialidad').value;
    const experiencia = document.getElementById('experiencia').value;

    if (nombre && especialidad && experiencia) {
      if (!tecnicoYaExiste(nombre)) {
        tecnicoSeleccionado.cells[0].innerText = nombre;
        tecnicoSeleccionado.cells[1].innerText = especialidad;
        tecnicoSeleccionado.cells[2].innerText = experiencia;
        document.getElementById('formulario-tecnico').style.display = 'none';
      } else {
        alert('Ya existe un técnico con ese nombre.');
      }
    } else {
      alert('Por favor, complete todos los campos.');
    }
  }
}

function agregarATabla(nombres, apellidos, especialidad, experiencia) {
  const tbody = document.getElementById('tecnicos-body');
  const row = tbody.insertRow();
  const auth_rol = document.getElementById('auth_rol').value;
  row.innerHTML = `
    <td>${nombres}</td>
    <td>${apellidos}</td>
    <td>${especialidad}</td>
    <td>${experiencia}</td>
  `;
  if (auth_rol && auth_rol == 'Administrador') {
    row.innerHTML += `<td><button class="btn-icon" onclick="editarDatos(this)">✏️</button>
      <button class="btn-icon" onclick="eliminarTecnico(this)">🗑️</button></td>`;
  } else {
    row.innerHTML += `<td></td>`;
  }
}

function cancelarEdicion() {
  document.getElementById('formulario-tecnico').style.display = 'none';
}

document.getElementById('searchBtn').addEventListener('click', function () {
  const input = document.getElementById('searchInput').value.toLowerCase();
  const filteredTechnicians = tecnicos.filter(tecnico =>
    tecnico.nombres.toLowerCase().includes(input) ||
    tecnico.especialidad.toLowerCase().includes(input ||
      tecnico.experiencia.toLowerCase().includes(input)
    ));
  mostrarTecnicos(filteredTechnicians);
});

document.getElementById('sortBtn').addEventListener('click', function () {
  const method = document.getElementById('sortSelect').value;
  let sortedTechnicians;

  if (method === 'quicksort') {
    sortedTechnicians = quicksort(tecnicos);
  } else if (method === 'bubblesort') {
    sortedTechnicians = bubblesort(tecnicos);
  } else {
    sortedTechnicians = tecnicos;
  }

  mostrarTecnicos(sortedTechnicians);
});

// Función para mostrar técnicos en la tabla
function mostrarTecnicos(tecnicos) {
  const tbody = document.getElementById('tecnicos-body');
  tbody.innerHTML = ''; // Limpiar la tabla

  tecnicos.forEach(tecnico => {
    agregarATabla(tecnico.nombres, tecnico.apellidos, tecnico.especialidad, tecnico.experiencia);
  });
}

// Algoritmo Quicksort
function quicksort(array) {
  if (array.length < 2) return array;
  const pivot = array[0];
  const less = array.slice(1).filter(item => item.nombre < pivot.nombre);
  const greater = array.slice(1).filter(item => item.nombre >= pivot.nombre);
  return [...quicksort(less), pivot, ...quicksort(greater)];
}

// Algoritmo Bubblesort
function bubblesort(array) {
  const arrCopy = [...array];
  const n = arrCopy.length;

  for (let i = 0; i < n - 1; i++) {
    for (let j = 0; j < n - i - 1; j++) {
      if (arrCopy[j].nombre > arrCopy[j + 1].nombre) {
        const temp = arrCopy[j];
        arrCopy[j] = arrCopy[j + 1];
        arrCopy[j + 1] = temp;
      }
    }
  }

  return arrCopy;
}
