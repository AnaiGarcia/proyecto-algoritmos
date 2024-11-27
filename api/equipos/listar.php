<?php
include('../../config/db.php');

try {
    $stmt = $dbh->query("SELECT * FROM equipo where activo = 1");
    $equipos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($equipos);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
