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
        $correo = isset($_PUT['correo']) ? $_PUT['correo'] : '';
        $nick = isset($_PUT['nick']) ? $_PUT['nick'] : '';
        $clave = isset($_PUT['clave']) ? md5($_PUT['clave']) : '';
        $rol = isset($_PUT['rol']) ? $_PUT['rol'] : '';

        if (empty($id) || empty($nombres) || empty($apellidos) || empty($dni) || empty($rol) || empty($correo) || empty($nick) || empty($clave)) {
            echo json_encode(['error' => 'Todos los campos son obligatorios']);
            exit;
        }

        $stmt = $dbh->prepare("UPDATE usuario SET nick = :nick, clave = :clave, rol = :rol WHERE id = :id");
        $stmt->bindParam(':nick', $nick);
        $stmt->bindParam(':clave', $clave);
        $stmt->bindParam(':rol', $rol);
        $stmt->bindParam(':id', $id);

        $stmt->execute();

        $stmt = $dbh->prepare("UPDATE persona SET nombres = :nombres, apellidos = :apellidos, dni = :dni, correo = :correo WHERE id = :persona_id");
        $stmt->bindParam(':nombres', $nombres);
        $stmt->bindParam(':apellidos', $apellidos);
        $stmt->bindParam(':dni', $dni);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':persona_id', $persona_id);

        $stmt->execute();

        echo json_encode(['success' => 'Usuario actualizado correctamente']);
    } else {
        echo json_encode(['error' => 'Método de solicitud no permitido']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error al conectar a la base de datos: ' . $e->getMessage()]);
}
