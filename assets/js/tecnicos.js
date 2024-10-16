let tecnicoParaEditar = null; // Variable para almacenar el técnico que se va a editar
let tecnicos = []; // Array para almacenar técnicos

// Cargar técnicos del almacenamiento local al cargar la página
window.onload = function () {
  tecnicos = JSON.parse(localStorage.getItem('tecnicos')) || [];
  tecnicos.forEach(tecnico => {
    agregarTecnicoTabla(tecnico.nombre, tecnico.especialidad, tecnico.experiencia);
  });
};

function mostrarFormulario() {
  document.getElementById('formulario-tecnico').style.display = 'block';
  document.getElementById('nombre').value = '';
  document.getElementById('especialidad').value = '';
  document.getElementById('experiencia').value = '';
  document.getElementById('btn-guardar').style.display = 'inline-block';
  document.getElementById('btn-editar').style.display = 'none';
}

function agregarTecnico() {
  const nombre = document.getElementById('nombre').value;
  const especialidad = document.getElementById('especialidad').value;
  const experiencia = document.getElementById('experiencia').value;

  if (nombre && especialidad && experiencia) {
    // Verificar si ya existe un técnico con el mismo nombre
    if (!tecnicoYaExiste(nombre)) {
      agregarTecnicoTabla(nombre, especialidad, experiencia);
      guardarTecnicosEnLocalStorage();
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

function agregarTecnicoTabla(nombre, especialidad, experiencia) {
  const tbody = document.getElementById('tecnicos-body');
  const row = tbody.insertRow();
  row.innerHTML = `
    <td>${nombre}</td>
    <td>${especialidad}</td>
    <td>${experiencia}</td>
    <td>
      <button class="btn-icon" onclick="editarDatos(this)">✏️</button>
      <button class="btn-icon" onclick="eliminarTecnico(this)">🗑️</button>
    </td>
  `;
}

function eliminarTecnico(button) {
  const row = button.closest('tr');
  const nombre = row.cells[0].innerText;
  tecnicos = tecnicos.filter(tecnico => tecnico.nombre !== nombre); // Actualizar array
  row.remove();
  guardarTecnicosEnLocalStorage(); // Actualizar localStorage después de eliminar
}

function editarDatos(button) {
  const row = button.closest('tr');
  tecnicoParaEditar = row; // Guardamos la referencia a la fila que se va a editar
  const celdas = row.getElementsByTagName('td');
  document.getElementById('nombre').value = celdas[0].innerText;
  document.getElementById('especialidad').value = celdas[1].innerText;
  document.getElementById('experiencia').value = celdas[2].innerText;
  document.getElementById('btn-guardar').style.display = 'none';
  document.getElementById('btn-editar').style.display = 'inline-block';
  document.getElementById('formulario-tecnico').style.display = 'block';
}

function editarTecnico() {
  if (tecnicoParaEditar) {
    const nombre = document.getElementById('nombre').value;
    const especialidad = document.getElementById('especialidad').value;
    const experiencia = document.getElementById('experiencia').value;

    if (nombre && especialidad && experiencia) {
      // Verificar si el nombre ya existe en otras filas
      if (!tecnicoYaExiste(nombre)) {
        tecnicoParaEditar.cells[0].innerText = nombre;
        tecnicoParaEditar.cells[1].innerText = especialidad;
        tecnicoParaEditar.cells[2].innerText = experiencia;

        guardarTecnicosEnLocalStorage(); // Actualizar localStorage después de editar
        document.getElementById('formulario-tecnico').style.display = 'none';
      } else {
        alert('Ya existe un técnico con ese nombre.');
      }
    } else {
      alert('Por favor, complete todos los campos.');
    }
  }
}

function cancelarEdicion() {
  document.getElementById('formulario-tecnico').style.display = 'none';
}

function guardarTecnicosEnLocalStorage() {
  const tbody = document.getElementById('tecnicos-body');
  tecnicos = []; // Limpiar el array antes de llenarlo nuevamente
  for (let row of tbody.rows) {
    const nombre = row.cells[0].innerText;
    const especialidad = row.cells[1].innerText;
    const experiencia = row.cells[2].innerText;
    tecnicos.push({ nombre, especialidad, experiencia });
  }
  localStorage.setItem('tecnicos', JSON.stringify(tecnicos));
}

// Funciones de búsqueda y ordenación
document.getElementById('searchBtn').addEventListener('click', function () {
  const input = document.getElementById('searchInput').value.toLowerCase();
  const filteredTechnicians = tecnicos.filter(tecnico =>
    tecnico.nombre.toLowerCase().includes(input) ||
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
    agregarTecnicoTabla(tecnico.nombre, tecnico.especialidad, tecnico.experiencia);
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
