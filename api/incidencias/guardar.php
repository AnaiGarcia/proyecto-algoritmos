<?php

include('../../config/db.php');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $equipo_id = isset($_POST['equipo_id']) ? $_POST['equipo_id'] : '';
        $usuario_id = 1;
        $tecnico_id = isset($_POST['tecnico_id']) ? $_POST['tecnico_id'] : '';
        $fecha_apertura = date('Y-m-d H:i:s');
        $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : '';
        $prioridad = isset($_POST['prioridad']) ? $_POST['prioridad'] : '';
        if (empty($equipo_id) || empty($descripcion) || empty($prioridad)) {
            echo json_encode(['error' => 'Todos los campos son obligatorios']);
            exit;
        }

        $stmt = $dbh->prepare("INSERT INTO incidencia (equipo_id, usuario_id, tecnico_id, fecha_apertura, descripcion, prioridad) VALUES (:equipo_id, :usuario_id, :tecnico_id, :fecha_apertura, :descripcion, :prioridad)");
        $stmt->bindParam(':equipo_id', $equipo_id);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->bindParam(':tecnico_id', $tecnico_id);
        $stmt->bindParam(':fecha_apertura', $fecha_apertura);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':prioridad', $prioridad);

        $stmt->execute();
        echo json_encode(['success' => 'Incidencia guardada correctamente']);
    } else {
        echo json_encode(['error' => 'Método de solicitud no permitido']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error al conectar a la base de datos: ' . $e->getMessage()]);
}
?>
