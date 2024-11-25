<?php
include('../../config/db.php');

try {
    $stmt = $dbh->query("SELECT * FROM tecnico t, persona p where t.persona_id = p.id");
    $equipos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($equipos);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>