<?php
include_once '../../TDA/Cola.php';
include('../../config/db.php');

try {
    if (isset($_GET['atributo']) && isset($_GET['valor'])) {
        $atributoBuscado = $_GET['atributo'];
        $valorBuscado = $_GET['valor'];

        $stmt = $dbh->prepare("SELECT * FROM equipo");
        $stmt->execute();

        $cola = new Cola();

        $equipos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($equipos as $equipo) {
            $cola->encolar($equipo);
        }

        $equipoEncontrado = $cola->buscarPorAtributo($atributoBuscado, $valorBuscado);

        if ($equipoEncontrado) {
            echo json_encode($equipoEncontrado);
        } else {
            echo json_encode(['error' => 'No se encontraron equipos que coincidan con el atributo y valor especificado']);
        }
    } else {
        echo json_encode(['error' => 'No se ha proporcionado un atributo o valor para la búsqueda']);
    }

} catch (PDOException $e) {
    echo json_encode(['error' => 'Error al conectar a la base de datos: ' . $e->getMessage()]);
}
?>
