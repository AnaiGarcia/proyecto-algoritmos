<?php
include('../../config/db.php');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        parse_str(file_get_contents("php://input"), $_PUT);

        $id = isset($_PUT['id']) ? $_PUT['id'] : '';
        $persona_id = isset($_PUT['persona_id']) ? $_PUT['persona_id'] : '';
        $nombres = isset($_PUT['nombres']) ? $_PUT['nombres'] : '';
        $apellidos = isset($_PUT['apellidos']) ? $_PUT['apellidos'] : '';
        $dni = isset($_PUT['dni']) ? $_PUT['dni'] : '';
        $experiencia = isset($_PUT['experiencia']) ? $_PUT['experiencia'] : '';
        $especialidad = isset($_PUT['especialidad']) ? $_PUT['especialidad'] : '';

        if (empty($id) || empty($nombres) || empty($apellidos) || empty($dni) || empty($especialidad) || empty($experiencia)) {
            echo json_encode(['error' => 'Todos los campos son obligatorios']);
            exit;
        }

        $stmt = $dbh->prepare("UPDATE tecnico SET experiencia = :experiencia, especialidad = :especialidad WHERE id = :id");
        $stmt->bindParam(':experiencia', $experiencia);
        $stmt->bindParam(':especialidad', $especialidad);
        $stmt->bindParam(':id', $id);

        $stmt->execute();

        $stmt = $dbh->prepare("UPDATE persona SET nombres = :nombres, apellidos = :apellidos, dni = :dni WHERE id = :persona_id");
        $stmt->bindParam(':nombres', $nombres);
        $stmt->bindParam(':apellidos', $apellidos);
        $stmt->bindParam(':dni', $dni);
        $stmt->bindParam(':persona_id', $persona_id);

        $stmt->execute();

        echo json_encode(['success' => 'Tecnico actualizado correctamente']);
    } else {
        echo json_encode(['error' => 'Método de solicitud no permitido']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error al conectar a la base de datos: ' . $e->getMessage()]);
}
