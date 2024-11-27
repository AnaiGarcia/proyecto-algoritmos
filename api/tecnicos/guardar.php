<?php

include('../../config/db.php');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombres = isset($_POST['nombres']) ? $_POST['nombres'] : '';
        $apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : '';
        $dni = isset($_POST['dni']) ? $_POST['dni'] : '';
        $especialidad = isset($_POST['especialidad']) ? $_POST['especialidad'] : '';
        $experiencia = isset($_POST['experiencia']) ? $_POST['experiencia'] : '';
        if (empty($nombres) || empty($apellidos) || empty($dni) || empty($especialidad) || empty($experiencia)) {
            echo json_encode(['error' => 'Todos los campos son obligatorios']);
            exit;
        }

        $stmt = $dbh->prepare("INSERT INTO persona (nombres, apellidos, dni) VALUES (:nombres, :apellidos, :dni)");
        $stmt->bindParam(':nombres', $nombres);
        $stmt->bindParam(':apellidos', $apellidos);
        $stmt->bindParam(':dni', $dni);

        $stmt->execute();
        $personaid = $dbh->lastInsertId();

        $stmt = $dbh->prepare("INSERT INTO tecnico (persona_id, sede_id, especialidad, experiencia) VALUES ($personaid, 1, :especialidad, :experiencia)");
        $stmt->bindParam(':especialidad', $especialidad);
        $stmt->bindParam(':experiencia', $experiencia);
        $stmt->execute();

        echo json_encode(['success' => 'Tecnico guardado correctamente']);
    } else {
        echo json_encode(['error' => 'Método de solicitud no permitido']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error al conectar a la base de datos: ' . $e->getMessage()]);
}
?>
