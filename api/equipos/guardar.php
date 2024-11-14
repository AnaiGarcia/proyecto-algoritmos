<?php

include('../../config/db.php');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
        $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : '';
        $ubicacion = isset($_POST['ubicacion']) ? $_POST['ubicacion'] : '';
        if (empty($nombre) || empty($tipo) || empty($ubicacion)) {
            echo json_encode(['error' => 'Todos los campos son obligatorios']);
            exit;
        }

        $stmt = $dbh->prepare("INSERT INTO equipo (nombre, tipo, ubicacion) VALUES (:nombre, :tipo, :ubicacion)");
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':ubicacion', $ubicacion);

        $stmt->execute();
        echo json_encode(['success' => 'Equipo guardado correctamente']);
    } else {
        echo json_encode(['error' => 'Método de solicitud no permitido']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error al conectar a la base de datos: ' . $e->getMessage()]);
}
?>
