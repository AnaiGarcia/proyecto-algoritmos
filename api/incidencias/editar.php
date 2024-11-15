<?php
include('../../config/db.php');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        parse_str(file_get_contents("php://input"), $_PUT);

        $id = isset($_PUT['id']) ? $_PUT['id'] : '';
        $solucion = isset($_PUT['solucion']) ? $_PUT['solucion'] : '';
        $fecha_cierre = date('Y-m-d H:i:s');

        if (empty($id) || empty($solucion)) {
            echo json_encode(['error' => 'Todos los campos son obligatorios']);
            exit;
        }

        $stmt = $dbh->prepare("UPDATE incidencia SET solucion = :solucion, fecha_cierre = :fecha_cierre WHERE id = :id");
        $stmt->bindParam(':solucion', $solucion);
        $stmt->bindParam(':fecha_cierre', $fecha_cierre);
        $stmt->bindParam(':id', $id);

        $stmt->execute();

        echo json_encode(['success' => 'Incidencia actualizada correctamente']);
    } else {
        echo json_encode(['error' => 'Método de solicitud no permitido']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error al conectar a la base de datos: ' . $e->getMessage()]);
}
