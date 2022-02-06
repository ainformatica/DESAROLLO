<?php
require '../vendor/autoload.php';
require('../clases/Conexion.php');

// $db_host = 'localhost';
// $db_username = 'root';
// $db_password = '';
// $db_name = 'informat_desarrollo_automatizacion';

// $db = new mysqli($db_host, $db_username, $db_password, $db_name);

// if ($db->connect_error) {
//     die("Unable to connect database: " . $db->connect_error);
// }

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


if (isset($_GET['enviar'])) {
    // window.location.href = "../Reporte/report_poa.php?enviar=enviar&id_planificacion=" + id_planificacion + "";
    $nombre_docente = $_GET['nombre_docente_send'];
    $id_craed = $_GET['id_craed'];

    $spreadsheet = new Spreadsheet();
    $Excel_writer = new Xlsx($spreadsheet);

    $fecha = date('d-m-Y'); //!captura la fecha y hora del dia
    $spreadsheet->setActiveSheetIndex(0);

    $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
    $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(50);
    $activeSheet = $spreadsheet->getActiveSheet();

    $spreadsheet->getActiveSheet()->getCell('H6')->setValue('FORMATO N. 003-DGTH');
    $spreadsheet->getActiveSheet(1)->mergeCells('H6:J6');
    $spreadsheet->getActiveSheet()->getStyle('H6')->getAlignment()->setHorizontal('center');

    $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
    $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
    $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
    $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
    $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
    $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);

    $spreadsheet->getActiveSheet()->getCell('B10')->setValue($nombre_docente); //!setea el nombre del docente obtenido del modal y el boton generar informe
    $spreadsheet->getActiveSheet()->getStyle('B10')->getAlignment()->setHorizontal('center');
    $spreadsheet->getActiveSheet()->getStyle('B11')->getAlignment()->setHorizontal('center');
    $spreadsheet->getActiveSheet()->getStyle('B10')->getFont()->setSize(16);
    $spreadsheet->getActiveSheet()->getStyle('B10')->getFont()->setBold(true);
    $arraystilonombre = [
        'borders' => [
            'outline' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                'color' => ['argb' => '00000a'],
            ],
        ],
    ];
    $spreadsheet->getActiveSheet()->getStyle('B10:J10')->applyFromArray($arraystilonombre);

    

    $spreadsheet->getActiveSheet()->getCell('A7')->setValue('I.-');
    $spreadsheet->getActiveSheet()->getCell('B7')->setValue('DATOS GENERALES');
    $spreadsheet->getActiveSheet()->getCell('A8')->setValue('NO. DE EMPLEADO');

    $spreadsheet->getActiveSheet(1)->mergeCells('B9:J9');
    $spreadsheet->getActiveSheet()->getStyle('B9')->getAlignment()->setHorizontal('center');
    $spreadsheet->getActiveSheet()->getCell('A9')->setValue('SOLICITUD DE:');
    $spreadsheet->getActiveSheet()->getCell('B9')->setValue('RECONTRATACIÓN');

    $spreadsheet->getActiveSheet()->getCell('A10')->setValue('NOMBRE COMPLETO:');
    $spreadsheet->getActiveSheet(1)->mergeCells('B10:J10');

    $spreadsheet->getActiveSheet()->getCell('A11')->setValue('NOMBRE DEL PUESTO Y UNIDAD EJECUTORA:');
    $spreadsheet->getActiveSheet()->getCell('B11')->setValue('Profesor por Hora/Departamento de Informàtica /Facultad de Ciencias Economicas');
    $spreadsheet->getActiveSheet(1)->mergeCells('B11:J11');

    $spreadsheet->getActiveSheet()->getCell('A12')->setValue('DURACIÓN DE LA ACCIÓN PERSONAL:');
    $spreadsheet->getActiveSheet()->getCell('A13')->setValue('II.-');
    $spreadsheet->getActiveSheet()->getCell('B13')->setValue('JUSTIFICACIÓN:');
    $spreadsheet->getActiveSheet()->getCell('A14')->setValue('DESCRIPCIÓN DE LABORATORIOS Y ACTIVIDADES ACADEMICAS');

    $spreadsheet->getActiveSheet()->getCell('B14')->setValue('DÍAS QUE SE IMPARTE');


    $spreadsheet->getActiveSheet()->getCell('C14')->setValue('SECCIÓN');
    $spreadsheet->getActiveSheet()->getCell('D14')->setValue('UV');
    $spreadsheet->getActiveSheet()->getCell('E14')->setValue('OBSERVACIONES');


    $sql = "SELECT * FROM tbl_carga_craed WHERE Profesor  = '" . $nombre_docente . "' and id_craed_jefa = '" . $id_craed . "'";
    $resultado = $mysqli->query($sql);
    //$query_planificacion = $db->query("SELECT * FROM tbl_carga_craed WHERE Profesor  = '" . $nombre_docente . "' and id_craed_jefa = '" . $id_craed . "'");
    $i = 15; //? numero de la celda donde queremos que el while empieze a escribir
    //$activeSheet->setCellValue('B1', 'Nombre POA: ' . $fila_plan['Asignatura_cr'] . $fecha);
    while ($fila_plan = $resultado->fetch_assoc()) {
        $spreadsheet->getActiveSheet()->getCell('A' . $i)->setValue($fila_plan['Asignatura_cr']);
        $spreadsheet->getActiveSheet()->getCell('B' . $i)->setValue($fila_plan['Dias_cr']);
        $spreadsheet->getActiveSheet()->getCell('C' . $i)->setValue($fila_plan['Seccion_cr']);
        $i++; //!aumenta el numero de la celda donde se escribe
    }

    //!consulta para sacar las clases

    // $query_planificacion = $db->query("SELECT * FROM tbl_carga_craed WHERE Profesor  = '" . $nombre_docente . "' and id_craed_jefa = '" . $id_craed . "'");
    // $i = 15; //? numero de la celda donde queremos que el while empieze a escribir
    // //$activeSheet->setCellValue('B1', 'Nombre POA: ' . $fila_plan['Asignatura_cr'] . $fecha);
    // while ($fila_plan = $query_planificacion->fetch_assoc()) {
    //     $spreadsheet->getActiveSheet()->getCell('A' . $i)->setValue($fila_plan['Asignatura_cr']);
    //     $spreadsheet->getActiveSheet()->getCell('B' . $i)->setValue($fila_plan['Dias_cr']);
    //     $spreadsheet->getActiveSheet()->getCell('C' . $i)->setValue($fila_plan['Seccion_cr']);
    //     $i++; //!aumenta el numero de la celda donde se escribe
    // }
    //!fin consulta para sacar las clases

    $spreadsheet->getActiveSheet(1)->mergeCells('E14:J14');
    $spreadsheet->getActiveSheet()->getStyle('E14')->getAlignment()->setHorizontal('center');

    ///!creacion de insercion de la imagen
    $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
    $drawing->setName('blue_unah');
    $drawing->setDescription('blue_unah');
    $drawing->setPath('image.png');
    $drawing->setCoordinates('A1');
    //$drawing->setOffsetX(10);
    $drawing->setHeight(200);
    $drawing->setWidth(200);
    $drawing->setRotation(0);
    $drawing->getShadow()->setVisible(true);
    $drawing->getShadow()->setDirection(0);
    $drawing->setWorksheet($spreadsheet->getActiveSheet());


    $dibujo = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
    $dibujo->setName('blue_unah');
    $dibujo->setDescription('blue_unah');
    $dibujo->setPath('sedp2.png');
    $dibujo->setCoordinates('B2');
    $dibujo->setHeight(200);
    $dibujo->setWidth(200);
    $dibujo->setRotation(0);
    $dibujo->getShadow()->setVisible(true);
    $dibujo->getShadow()->setDirection(0);
    $dibujo->setWorksheet($spreadsheet->getActiveSheet());

    //? fin insercion de la imagen


    //!bordes de la tabla clases
    $styleArray = [
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['argb' => '00000a'],
            ],
        ],
    ];
    $spreadsheet->getActiveSheet()->getStyle('A14:J' . $i . '')->applyFromArray($styleArray);
    //!fin bordes de la tabla clases

    $arraystilo = [
        'borders' => [
            'outline' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['argb' => '00000a'],
            ],
        ],
    ];
    $spreadsheet->getActiveSheet()->getStyle('A1:J6')->applyFromArray($arraystilo);


    $arraystilo = [
        'borders' => [
            'outline' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['argb' => '00000a'],
            ],
        ],
    ];
    $spreadsheet->getActiveSheet()->getStyle('A7:J13')->applyFromArray($arraystilo);
    $spreadsheet->getActiveSheet(1)->mergeCells('E15:J' . $i . '');




    $spreadsheet->getActiveSheet()->getStyle('C22')->getAlignment()->setHorizontal('center');
    $spreadsheet->getActiveSheet(1)->mergeCells('C22:J22');

    $spreadsheet->getActiveSheet()->getCell('C23')->setValue('No. DE IDENTIDAD DEL DOCENTE');
    $spreadsheet->getActiveSheet()->getStyle('C23')->getAlignment()->setHorizontal('center');
    $spreadsheet->getActiveSheet(1)->mergeCells('C23:J23');
    $arraystilo = [
        'borders' => [
            'top' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['argb' => '00000a'],
            ],
        ],
    ];
    $spreadsheet->getActiveSheet()->getStyle('C23:J23')->applyFromArray($arraystilo);

    $spreadsheet->getActiveSheet()->getCell('A25')->setValue('Patricia Ellner Villalonga');
    $spreadsheet->getActiveSheet()->getStyle('A25')->getAlignment()->setHorizontal('center');

    $spreadsheet->getActiveSheet()->getCell('A26')->setValue('NOMBRE Y FIRMA DEL JEFE DE LA UNIDAD SOLICITANTE');
    $spreadsheet->getActiveSheet()->getStyle('A26')->getAlignment()->setHorizontal('center');
    $arraystilo = [
        'borders' => [
            'top' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['argb' => '00000a'],
            ],
        ],
    ];
    $spreadsheet->getActiveSheet()->getStyle('A26')->applyFromArray($arraystilo);


    $spreadsheet->getActiveSheet()->getCell('C25')->setValue($nombre_docente);
    $spreadsheet->getActiveSheet()->getStyle('C25')->getAlignment()->setHorizontal('center');
    $spreadsheet->getActiveSheet(1)->mergeCells('C25:J25');

    $spreadsheet->getActiveSheet()->getCell('C26')->setValue('NOMBRE Y FIRMA DEL DOCENTE');
    $spreadsheet->getActiveSheet()->getStyle('C26')->getAlignment()->setHorizontal('center');
    $spreadsheet->getActiveSheet(1)->mergeCells('C26:J26');
    $arraystilo = [
        'borders' => [
            'top' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['argb' => '00000a'],
            ],
        ],
    ];
    $spreadsheet->getActiveSheet()->getStyle('C26:J26')->applyFromArray($arraystilo);

    $arraystilo = [
        'borders' => [
            'outline' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['argb' => '00000a'],
            ],
        ],
    ];
    $spreadsheet->getActiveSheet()->getStyle('A18:J27')->applyFromArray($arraystilo);


    $spreadsheet->getActiveSheet()->getCell('A28')->setValue('III-	ESTRUCTURA PRESUPUESTARIA:');

    $arraystilo = [
        'borders' => [
            'top' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE,
                'color' => ['argb' => '00000a'],
            ],
        ],
    ];
    $spreadsheet->getActiveSheet()->getStyle('A7:J7')->applyFromArray($arraystilo);

    $spreadsheet->getActiveSheet()->getCell('A30')->setValue('OBJETO DEL GASTO:');
    $spreadsheet->getActiveSheet()->getCell('A31')->setValue('CORRELATIVO:');
    $spreadsheet->getActiveSheet()->getCell('A32')->setValue('SUELDO Lps.:');

    $spreadsheet->getActiveSheet()->getStyle('A30:A32')->getAlignment()->setHorizontal('center');

    $spreadsheet->getActiveSheet()->getCell('B30')->setValue('11100-02');

    $spreadsheet->getActiveSheet()->getCell('A34')->setValue('REVISADO: ');
    $arraystilo = [
        'borders' => [
            'bottom' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['argb' => '00000a'],
            ],
        ],
    ];
    $spreadsheet->getActiveSheet()->getStyle('A34')->applyFromArray($arraystilo);

    $spreadsheet->getActiveSheet()->getCell('C35')->setValue('Administrador');
    $arraystilo = [
        'borders' => [
            'top' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['argb' => '00000a'],
            ],
        ],
    ];
    $spreadsheet->getActiveSheet()->getStyle('C35:J35')->applyFromArray($arraystilo);
    $spreadsheet->getActiveSheet(1)->mergeCells('C35:J35');
    $spreadsheet->getActiveSheet()->getStyle('C35:J35')->getAlignment()->setHorizontal('center');
    //    

    $arraystilo = [
        'borders' => [
            'outline' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['argb' => '00000a'],
            ],
        ],
    ];
    $spreadsheet->getActiveSheet()->getStyle('A28:J36')->applyFromArray($arraystilo);

    $arraystilo = [
        'borders' => [
            'top' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE,
                'color' => ['argb' => '00000a'],
            ],
        ],
    ];
    $spreadsheet->getActiveSheet()->getStyle('A28:J28')->applyFromArray($arraystilo);

    $spreadsheet->getActiveSheet()->getCell('A39')->setValue('OFICIO No.');
    $spreadsheet->getActiveSheet()->getCell('A40')->setValue('FACULTAD o CENTRO:  FACULTAD DE CIENCIAS ECONOMICAS, ADMINISTRATIVAS Y CONTABLES');
    $spreadsheet->getActiveSheet(1)->mergeCells('A40:J40');
    $spreadsheet->getActiveSheet()->getStyle('A40')->getAlignment()->setHorizontal('center');


    $spreadsheet->getActiveSheet()->getCell('A42')->setValue('MASTER IRIS YOLANDA CABALLERO LARA   / SECRETARÍA EJECUTIVA DE DESARROLLO DE PERSONAL  /  U.N.A.H.');
    $spreadsheet->getActiveSheet(1)->mergeCells('A42:J42');
    $spreadsheet->getActiveSheet()->getStyle('A42')->getAlignment()->setHorizontal('center');

    $spreadsheet->getActiveSheet()->getCell('A43')->setValue('Por medio de la presente le solicito muy respetuosamente se le dé el trámite a la solicitud de:');
    $spreadsheet->getActiveSheet(1)->mergeCells('A43:J43');
    $spreadsheet->getActiveSheet()->getStyle('A43')->getAlignment()->setHorizontal('center');

    $spreadsheet->getActiveSheet()->getCell('A44')->setValue('PAGO I PAC 2021');
    $spreadsheet->getActiveSheet(1)->mergeCells('A44:J44');
    $spreadsheet->getActiveSheet()->getStyle('A44')->getAlignment()->setHorizontal('center');

    $spreadsheet->getActiveSheet()->getCell('A45')->setValue('Conforme a la solicitud y documentos que se adjuntan.');
    $spreadsheet->getActiveSheet()->getCell('A46')->setValue('Muy Atentamente,');

    $spreadsheet->getActiveSheet()->getCell('A50')->setValue('DECANO / DIRECTOR');
    $spreadsheet->getActiveSheet(1)->mergeCells('A50:J50');
    $spreadsheet->getActiveSheet()->getStyle('A50')->getAlignment()->setHorizontal('center');

    $spreadsheet->getActiveSheet()->getCell('A51')->setValue('U.N.A.H');
    $spreadsheet->getActiveSheet(1)->mergeCells('A51:J51');
    $spreadsheet->getActiveSheet()->getStyle('A51')->getAlignment()->setHorizontal('center');

    $spreadsheet->getActiveSheet()->getCell('A52')->setValue('Original: S.E.D.P.');
    $spreadsheet->getActiveSheet()->getCell('A53')->setValue('CC:Jefe de Unidad Académica; Interesado; Administración Facultad o Centro');

    $spreadsheet->getActiveSheet(1)->mergeCells('B13:J13');
    $arraystilo = [
        'borders' => [
            'outline' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['argb' => '00000a'],
            ],
        ],
    ];
    $spreadsheet->getActiveSheet()->getStyle('A37:J44')->applyFromArray($arraystilo);

    $arraystilo = [
        'borders' => [
            'top' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE,
                'color' => ['argb' => '00000a'],
            ],
        ],
    ];
    $spreadsheet->getActiveSheet()->getStyle('A37:J37')->applyFromArray($arraystilo);
    $spreadsheet->getActiveSheet(1)->mergeCells('B13:J13');

    $arraystilo = [
        'borders' => [
            'outline' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['argb' => '00000a'],
            ],
        ],
    ];
    $spreadsheet->getActiveSheet()->getStyle('A45:J53')->applyFromArray($arraystilo);


    $filename = 'recontratacion.xlsx';

    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename=' . $filename);
    header('Cache-Control: max-age=0');
    $Excel_writer->save('php://output');
}
