<?php
include('../../config/db.php');

try {
    $stmt = $dbh->query("SELECT i.*, e.nombre as equipo_nombre, 
                         CASE
                             WHEN i.fecha_cierre IS NULL THEN 'En proceso'
                             ELSE 'Cerrada' 
                         END AS situacion 
                         FROM incidencia i, equipo e where e.id = i.equipo_id order by i.id");
    $equipos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($equipos);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
