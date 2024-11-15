<?php
include('../../config/db.php');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        parse_str(file_get_contents("php://input"), $_PUT);

        $id = isset($_PUT['id']) ? $_PUT['id'] : '';
        $nombre = isset($_PUT['nombre']) ? $_PUT['nombre'] : '';
        $tipo = isset($_PUT['tipo']) ? $_PUT['tipo'] : '';
        $ubicacion = isset($_PUT['ubicacion']) ? $_PUT['ubicacion'] : '';

        if (empty($id) || empty($nombre) || empty($tipo) || empty($ubicacion)) {
            echo json_encode(['error' => 'Todos los campos son obligatorios']);
            exit;
        }

        $stmt = $dbh->prepare("UPDATE equipo SET nombre = :nombre, tipo = :tipo, ubicacion = :ubicacion WHERE id = :id");
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':ubicacion', $ubicacion);
        $stmt->bindParam(':id', $id);

        $stmt->execute();

        echo json_encode(['success' => 'Equipo actualizado correctamente']);
    } else {
        echo json_encode(['error' => 'Método de solicitud no permitido']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error al conectar a la base de datos: ' . $e->getMessage()]);
}
