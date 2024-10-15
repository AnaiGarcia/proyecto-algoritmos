<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestión de Técnicos</title>
  <link rel="stylesheet" href="estilo(tecnicos).CSS">
</head>
<body>
  <a name="inicio"></a> <!-- Ancla para volver al inicio -->
  <div class="container">
    <h1 class="title">Gestión de Técnicos</h1>

    <div class="buttons">
      
    
      <button class="btn btn-secondary" onclick="mostrarFormulario()">
        <span class="icon">➕</span>
        Agregar Técnico
      </button>
    </div>

    <!-- Formulario para agregar o editar técnicos -->
    <div id="formulario-tecnico" class="formulario" style="display:none;">
      <input type="text" id="nombre" placeholder="Nombre del técnico" class="input-search">
      <input type="text" id="especialidad" placeholder="Especialidad" class="input-search">
      <input type="text" id="experiencia" placeholder="Experiencia" class="input-search">
      <button class="btn btn-primary" id="btn-guardar" onclick="agregarTecnico()">Agregar Técnico</button>
      <button class="btn btn-secondary" id="btn-editar" style="display:none;" onclick="editarTecnico()">Guardar Cambios</button>
      <button class="btn btn-danger" onclick="cancelarEdicion()">Cancelar</button> <!-- Botón para cancelar -->
    </div>

    <div class="container">
    
      <div class="search-box">
        <input type="text" class="input-search" placeholder="Buscar...">
        <button class="btn-buscar">Buscar</button>
      </div>

    <table class="table" id="tabla-tecnicos">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Especialidad</th>
          <th>Experiencia</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody id="tecnicos-body">
        <!-- Las filas de técnicos se añadirán aquí dinámicamente -->
      </tbody>
    </table>
  </div>

  <!-- Enlace para volver al inicio -->
  <div class="back-to-top">
    <a href="index.php" class="btn">Volver al Inicio</a>
  </div>

  <!-- Asegúrate de que el archivo JavaScript esté correctamente vinculado -->
  <script src="SCRIPT(TECNICO).JS"></script>
</body>
</html>