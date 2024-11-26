<?php
include('../../config/db.php');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        parse_str(file_get_contents("php://input"), $_PUT);

        $id = isset($_PUT['id']) ? $_PUT['id'] : '';

        if (empty($id)) {
            echo json_encode(['error' => 'Todos los campos son obligatorios']);
            exit;
        }

        $stmt = $dbh->prepare("UPDATE usuario SET activo = 0 WHERE id = :id");
        $stmt->bindParam(':id', $id);

        $stmt->execute();

        echo json_encode(['success' => 'Usuario eliminado correctamente']);
    } else {
        echo json_encode(['error' => 'Método de solicitud no permitido']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error al conectar a la base de datos: ' . $e->getMessage()]);
}
