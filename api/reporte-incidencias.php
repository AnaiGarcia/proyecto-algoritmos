<?php

require __DIR__ . '/../vendor/autoload.php';
include('../config/db.php');
include_once '../TDA/Pila.php';

use Mpdf\Mpdf;

$start_date = $_GET['start_date'] ?? null;
$end_date = $_GET['end_date'] ?? null;
$tecnico = $_GET['tecnico'] ?? -1;
$priority = $_GET['priority'] ?? -1;
$status = $_GET['status'] ?? -1;

$sqlWhere = '';

if ($tecnico != null && $tecnico != -1) {
    $sqlWhere .= " and i.tecnico_id = '$tecnico' ";
}

if ($priority != null && $priority != -1) {
    $sqlWhere .= " and i.prioridad = '$priority' ";
}

if ($status != null && $status != -1) {
    if ($status == 'abierta' || $status == 'en-progreso') {
        $sqlWhere .= " and i.fecha_cierre is null ";
    } else {
        $sqlWhere .= " and i.fecha_cierre is not null ";
    }
}

$stmt = $dbh->query("SELECT * FROM incidencia i inner join equipo e on e.id = i.equipo_id inner join tecnico t on t.id = i.tecnico_id inner join persona p on p.id = t.persona_id where 1 = 1 ".$sqlWhere);
$incidencias = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pila = new Pila();

$fechaInicio = new DateTime($start_date);
$fechaFin = new DateTime($end_date);

foreach ($incidencias as $incidencia) {
    $fechaApertura = new DateTime($incidencia['fecha_apertura']);
    $fechaValida = true;
    if ($fechaInicio && $fechaApertura < $fechaInicio) {
        $fechaValida = false;
    }
    if ($fechaFin && $fechaApertura > $fechaFin) {
        $fechaValida = false;
    }
    if ($fechaValida) {
        $pila->push($incidencia);
    }
}

$for = '
<table class="items" width="100%" style="border-collapse: collapse; font-size: 12px;" cellpadding="8">
            <thead>
                <tr>
                    <td style="font-weight: bold; text-align: center" width="4%">#</td>
                    <td style="font-weight: bold" width="15%">Equipo</td>
                    <td style="font-weight: bold" width="15%">Tecnico</td>
                    <td style="font-weight: bold" width="12%">Fecha apertura</td>
                    <td style="font-weight: bold" width="12%">Fecha cierre</td>
                    <td style="font-weight: bold" width="12%">Motivo</td>
                    <td style="font-weight: bold" width="15%">Prioridad</td>
                    <td style="font-weight: bold" width="15%">Estado</td>
                </tr>
            </thead>
            <tbody>
            ';
foreach ($pila->obtenerPila() as $index => $incidencia) {
    $estado = $incidencia['fecha_cierre'] == null ? 'Cerrada' : 'En proceso';
    $for .= '<tr>
                <td style="font-weight: bold; text-align: center" width="4%">' . ($index + 1) . '</td>
                <td style="font-weight: bold" width="15%">' . $incidencia['nombre'] . '</td>
                <td style="font-weight: bold" width="15%">' . $incidencia['nombres'] . '</td>
                <td style="font-weight: bold" width="12%">' . $incidencia['fecha_apertura'] . '</td>
                <td style="font-weight: bold" width="12%">' . $incidencia['fecha_cierre'] . '</td>
                <td style="font-weight: bold" width="12%">' . $incidencia['descripcion'] . '</td>
                <td style="font-weight: bold" width="15%">' . $incidencia['prioridad'] . '</td>
                <td style="font-weight: bold" width="15%">' . $estado . '</td>
            </tr>';
}
$for .= '</tbody>
        </table>
';

$plantilla =
    "<html>
<head>
    <style>
        p {
            margin: 0pt;
        }

        table.items {
            border: 0.1mm solid #000000;
        }

        td {
            vertical-align: top;
        }

        .items td {
            border-left: 0.1mm solid #000000;
            border-right: 0.1mm solid #000000;
            border-bottom: 0.1mm solid #000000;
        }

        table thead td {
            background-color: #EEEEEE;
            border: 0.1mm solid #000000;
        }
    </style>
</head>
<body>
    <div style='text-align: center; font-size: 20px; font-weight: bold; text-decoration: underline; margin-bottom: 20px'>
        Reporte de incidencias
    </div>
    " . $for . "
</body>

</html>";

ob_start();

$mpdf = new Mpdf(
    array(
        'mode' => 'c',
        'format' => 'A4-P',
        'default_font_size' => 0,
        'default_font' => 'Arial',
        'margin_left' => 10,
        'margin_right' => 10,
        'margin_top' => 10,
        'margin_bottom' => 10,
        'tempDir' => sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'mpdf'
    )
);
$mpdf->SetDisplayMode('fullpage');

$mpdf->list_indent_first_level = 0;
$mpdf->WriteHTML($plantilla);
$mpdf->Output("report.pdf", "I");

return $this->headerResponse($response, 'pdf');
