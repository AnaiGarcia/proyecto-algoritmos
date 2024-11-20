<?php

require __DIR__ . '/../vendor/autoload.php';
include('../config/db.php');

use Mpdf\Mpdf;

$start_date = $_GET['start_date'];
$end_date = $_GET['end_date'];
$priority = $_GET['priority'];
$status = $_GET['status'];

$stmt = $dbh->query("SELECT * FROM incidencia i inner join equipo e on e.id = i.equipo_id");
$incidencias = $stmt->fetchAll(PDO::FETCH_ASSOC);

$for = '
<table class="items" width="100%" style="border-collapse: collapse; font-size: 12px;" cellpadding="8">
            <thead>
                <tr>
                    <td style="font-weight: bold; text-align: center" width="4%">#</td>
                    <td style="font-weight: bold" width="15%">Equipo</td>
                    <td style="font-weight: bold" width="12%">Fecha apertura</td>
                    <td style="font-weight: bold" width="12%">Motivo</td>
                    <td style="font-weight: bold" width="15%">Prioridad</td>
                </tr>
            </thead>
            <tbody>
            ';
            foreach($incidencias as $index => $incidencia) {
                $for .='<tr>
                <td style="font-weight: bold; text-align: center" width="4%">'.($index + 1).'</td>
                <td style="font-weight: bold" width="15%">'.$incidencia['nombre'].'</td>
                <td style="font-weight: bold" width="12%">'.$incidencia['fecha_apertura'].'</td>
                <td style="font-weight: bold" width="12%">'.$incidencia['descripcion'].'</td>
                <td style="font-weight: bold" width="15%">'.$incidencia['prioridad'].'</td>
            </tr>';
            }
            $for .='</tbody>
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
