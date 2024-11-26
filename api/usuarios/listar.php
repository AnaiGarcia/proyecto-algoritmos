<?php
include('../../config/db.php');

try {
    $stmt = $dbh->query("SELECT *, u.id as id FROM usuario u, persona p where u.persona_id = p.id");
    $equipos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($equipos);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
