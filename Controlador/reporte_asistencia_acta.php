<?php
session_start();
require_once('../clases/conexion_mantenimientos.php');
require_once('../Reporte/pdf/fpdf.php');
$instancia_conexion = new conexion();

//$stmt = $instancia_conexion->query("SELECT tp.nombres FROM tbl_personas tp INNER JOIN tbl_usuarios us ON us.id_persona=tp.id_persona WHERE us.Id_usuario= 8");

$dtz = new DateTimeZone("America/Tegucigalpa");
$dt = new DateTime("now", $dtz);
$hoy = $dt->format("Y-m-d H:i:s");
$id_objetoac = 148;
$id_userac = $_SESSION['id_usuario'];
$accionac = 'REPORTE';
$descripcionac= 'generÓ reporte de asistencia del acta con No.: '.$_GET[id];
$fechaac = $hoy;
$stmt = $mysqli->prepare("INSERT INTO `tbl_bitacora` (`Id_usuario`, `Id_objeto`, `Fecha`, `Accion`, `Descripcion`) VALUES (?,?,?,?,?)");
$stmt->bind_param("iisss", $id_userac, $id_objetoac, $fechaac, $accionac, $descripcionac);
$stmt->execute();
class myPDF extends FPDF
{
    function encabezado()
    {
        //h:i:s
        date_default_timezone_set("America/Tegucigalpa");
        $fecha = date('d-m-Y h:i:s');
        //$fecha = date("Y-m-d ");

        $this->ln(7);
        $this->Image('../dist/img/logo_ia.jpg', 30, 10, 40);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(300, 10, utf8_decode("UNIVERSIDAD NACIONAL AUTÓNOMA DE HONDURAS"), 0, 0, 'C');
        $this->ln(7);
        $this->Cell(295, 10, utf8_decode("FACULTAD DE CIENCIAS ECONÓMICAS, ADMINISTRATIVAS Y CONTABLES"), 0, 0, 'C');
        $this->ln(7);
        $this->Cell(300, 10, utf8_decode("DEPARTAMENTO DE INFORMÁTICA "), 0, 0, 'C');
        $this->ln(10);
        $this->SetFont('Arial', '', 12);
        $this->Cell(280, 10, "FECHA: " . $fecha, 0, 0, 'R');
        $this->ln();
        $this->ln();
        $this->SetFont('Arial', 'B', 18);

        global $instancia_conexion;
        $sql = "SELECT a.num_acta, tra.tipo ,a.fecha, r.lugar, r.hora_inicio, r.hora_final
                    FROM tbl_acta a
                    INNER JOIN tbl_reunion r ON r.id_reunion = a.id_reunion
                    INNER JOIN tbl_tipo_reunion_acta tra ON tra.id_tipo = r.id_tipo
                    WHERE a.id_acta = '$_GET[id]'";
        $stmt = $instancia_conexion->ejecutarConsulta($sql);

        while ($datos = $stmt->fetch_object()) {

            $this->Cell(300, 10, "REPORTE DE ASISTENCIA " . utf8_decode($datos->num_acta), 0, 0, 'C');
            $this->ln();
            $this->ln();
            $this->ln();

        }

    }
    function footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', '', 10);
        $this->cell(0, 10, 'Pagina' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    function headerTable1()
    {
        $this->SetX(50);
        $this->SetFont('Times', 'B', 16);
        $this->SetFillColor(150, 125, 255);
        $this->Cell(60, 7, utf8_decode("Promedio de Asistencia"), 0, 0, 'C');
        $this->Ln();
        $this->SetFont('Times', 'B', 12);
        $this->SetLineWidth(0.3);
        $this->SetX(50);
        $this->Cell(70, 7, utf8_decode("N°. Acta"), 1, 0, 'C');
        $this->Cell(75, 7, utf8_decode("Nombre reunión"), 1, 0, 'C');
        $this->Cell(40, 7, "Asistencia", 1, 0, 'C');
        $this->Cell(40, 7, "Inasistencia", 1, 0, 'C');
        $this->Cell(40, 7, "Excusado", 1, 0, 'C');

        $this->ln();
        
    }

    function viewTable1()
    {


        global $instancia_conexion;
        $sql = "SELECT t1.id_reunion, t1.num_acta, t3.nombre_reunion,
                ROUND(SUM(t2.id_estado_participante = 1) / COUNT(t2.id_persona) * 100) AS asistio,
                ROUND(SUM(t2.id_estado_participante = 2) / COUNT(t2.id_persona) * 100) AS inasistencia,
                ROUND(SUM(t2.id_estado_participante = 3) / COUNT(t2.id_persona) * 100) AS excusa
                FROM  tbl_acta t1
                INNER JOIN tbl_participantes t2 ON  t2.id_reunion = t1.id_reunion
                INNER JOIN tbl_reunion t3 ON t3.id_reunion = t1.id_reunion
                WHERE t1.id_acta = '$_GET[id];'";
        $stmt = $instancia_conexion->ejecutarConsulta($sql);

        while ($total_asistencia = $stmt->fetch_object()) {


            $this->SetX(50);
            $this->SetFont('Times', '', 12);
            $this->Cell(70, 7, utf8_decode($total_asistencia->num_acta), 1, 0, 'C');
            $this->Cell(75, 7, utf8_decode($total_asistencia->nombre_reunion), 1, 0, 'C');
            $this->Cell(40, 7, utf8_decode($total_asistencia->asistio . '%'), 1, 0, 'C');
            $this->Cell(40, 7, utf8_decode($total_asistencia->inasistencia . '%'), 1, 0, 'C');
            $this->Cell(40, 7, utf8_decode($total_asistencia->excusa . '%'), 1, 0, 'C');
            $this->ln();
            $this->ln();
            $this->ln();
        }
    }

    function headerTable()
    {
        $this->SetFont('Times', 'B', 16);
        $this->SetX(50);
        $this->Cell(60, 7, 'Lista de Participantes', 0, 0, 'L');
        $this->ln();

        $this->SetFont('Times', 'B', 12);
        $this->SetLineWidth(0.3);
        $this->SetX(50);
        $this->Cell(105, 7, "Nombres", 1, 0, 'C');
        $this->Cell(70, 7, "Estado Asistencia", 1, 0, 'C');
        $this->Cell(90, 7, "Firma", 1, 0, 'C');
        $this->ln();
    }
    function viewTable()
    {




        global $instancia_conexion;
        $sql = "SELECT concat_ws(' ', pe.nombres, pe.apellidos)nombres, (ep.estado)'asistencia' 
        FROM tbl_acta a 
        LEFT JOIN tbl_participantes pa ON pa.id_reunion = a.id_reunion
        LEFT JOIN tbl_personas pe ON pe.id_persona = pa.id_persona
        LEFT JOIN tbl_estado_participante ep ON ep.id_estado = pa.id_estado_participante
        WHERE a.id_acta='$_GET[id];'";
        $stmt = $instancia_conexion->ejecutarConsulta($sql);

        while ($lista = $stmt->fetch_object()) {
            $this->SetX(50);
            $this->SetFont('Times', '', 12);
            $this->Cell(105, 13, utf8_decode($lista->nombres), 1, 0, 'L');
            $this->Cell(70, 13, utf8_decode($lista->asistencia), 1, 0, 'C');
            $this->Cell(90, 13, '', 1, 0, 'C');
            $this->ln();
        }
    }

 



}


$pdf = new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('C', 'Legal', 0);
$pdf->SetMargins(40, 30, 1);
$pdf->SetAutoPageBreak(true, 25);
$pdf->encabezado();
$pdf->headerTable1();
$pdf->viewTable1();
$pdf->headerTable();
$pdf->viewTable();



//$pdf->viewTable2($instancia_conexion);
$pdf->SetFont('Arial', '', 15);


$pdf->Output();
