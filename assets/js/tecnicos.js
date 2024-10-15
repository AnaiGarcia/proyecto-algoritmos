let tecnicoParaEditar = null; // Variable para almacenar el técnico que se va a editar

// Cargar técnicos del almacenamiento local al cargar la página
window.onload = function () {
  const tecnicos = JSON.parse(localStorage.getItem('tecnicos')) || [];
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
      
      // Guardar en localStorage
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
  const tbody = document.getElementById('tecnicos-body');
  for (let row of tbody.rows) {
    if (row.cells[0].innerText === nombre) {
      return true; // El técnico ya existe
    }
  }
  return false; // El técnico no existe
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
  const tecnicos = [];
  const tbody = document.getElementById('tecnicos-body');
  for (let row of tbody.rows) {
    const nombre = row.cells[0].innerText;
    const especialidad = row.cells[1].innerText;
    const experiencia = row.cells[2].innerText;
    tecnicos.push({ nombre, especialidad, experiencia });
  }
  localStorage.setItem('tecnicos', JSON.stringify(tecnicos));
}