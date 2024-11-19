<?php

require __DIR__ . '/../vendor/autoload.php';

use Mpdf\Mpdf;

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
