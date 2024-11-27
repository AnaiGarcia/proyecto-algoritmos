<?php
include('../../config/db.php');

try {
    $stmt = $dbh->query("SELECT *, u.id as id FROM usuario u, persona p where u.persona_id = p.id and u.activo = 1");
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($usuarios as &$usuario) {
        if (isset($usuario['clave'])) {
            $usuario['clave'] = '';
        }
    }
    echo json_encode($usuarios);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
