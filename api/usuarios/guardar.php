<?php

include('../../config/db.php');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombres = isset($_POST['nombres']) ? $_POST['nombres'] : '';
        $apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : '';
        $dni = isset($_POST['dni']) ? $_POST['dni'] : '';
        $correo = isset($_POST['correo']) ? $_POST['correo'] : '';
        $nick = isset($_POST['nick']) ? $_POST['nick'] : '';
        $clave = isset($_POST['clave']) ? md5($_POST['clave']) : '';
        $rol = isset($_POST['rol']) ? $_POST['rol'] : '';
        if (empty($nombres) || empty($apellidos) || empty($dni) || empty($correo) || empty($nick) || empty($clave) || empty($rol)) {
            echo json_encode(['error' => 'Todos los campos son obligatorios']);
            exit;
        }

        $stmt = $dbh->prepare("INSERT INTO persona (nombres, apellidos, dni, correo) VALUES (:nombres, :apellidos, :dni, :correo)");
        $stmt->bindParam(':nombres', $nombres);
        $stmt->bindParam(':apellidos', $apellidos);
        $stmt->bindParam(':dni', $dni);
        $stmt->bindParam(':correo', $correo);

        $stmt->execute();
        $personaid = $dbh->lastInsertId();

        $stmt = $dbh->prepare("INSERT INTO usuario (persona_id, sede_id, nick, clave, rol) VALUES ($personaid, 1, :nick, :clave, :rol)");
        $stmt->bindParam(':nick', $nick);
        $stmt->bindParam(':clave', $clave);
        $stmt->bindParam(':rol', $rol);
        $stmt->execute();

        echo json_encode(['success' => 'Usuario guardado correctamente']);
    } else {
        echo json_encode(['error' => 'Método de solicitud no permitido']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error al conectar a la base de datos: ' . $e->getMessage()]);
}
?>
