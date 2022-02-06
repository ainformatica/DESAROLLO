<?php
session_start();
require_once('../clases/conexion_mantenimientos.php');
require_once "../Modelos/reporte_docentes_modelo.php";
require_once('../Reporte/pdf/fpdf.php');
$instancia_conexion = new conexion();


//$stmt = $instancia_conexion->query("SELECT tp.nombres FROM tbl_personas tp INNER JOIN tbl_usuarios us ON us.id_persona=tp.id_persona WHERE us.Id_usuario= 8");



class myPDF extends FPDF
{
    function header()
    {
        //h:i:s
        date_default_timezone_set("America/Tegucigalpa");
        $fecha = date('d-m-Y h:i:s');
        //$fecha = date("Y-m-d ");
      
            $this->Image('../dist/img/logo_ia.jpg', 30, 10, 35);
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(330, 10, utf8_decode("UNIVERSIDAD NACIONAL AUTÓNOMA DE HONDURAS"), 0, 0, 'C');
            $this->ln(7);
            $this->Cell(325, 10, utf8_decode("FACULTAD DE CIENCIAS ECONÓMICAS, ADMINISTRATIVAS Y CONTABLES"), 0, 0, 'C');
            $this->ln(7);
            $this->Cell(330, 10, utf8_decode("DEPARTAMENTO DE INFORMÁTICA "), 0, 0, 'C');
            $this->ln(10);
            $this->SetFont('times', 'B', 20);
            $this->Cell(330, 10, utf8_decode("REPORTEq DE ACTAS PENDIENTES"), 0, 0, 'C');
            $this->ln(17);
            $this->SetFont('Arial', '', 12);
        $this->Cell(55, 10, utf8_decode("ACTAS PENDIENTES"), 0, 0, 'C');
            $this->Cell(420, 10, "FECHA: " . $fecha, 0, 0, 'C');
            $this->ln();
         
    }
    function footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', '', 10);
        $this->cell(0, 10, 'Pagina' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    function headerTable()
    {
        $this->SetFont('Times', 'B', 10);
        $this->SetLineWidth(0.3);
        $this->Cell(55, 7, "Num. Acta", 1, 0, 'C');
        $this->Cell(55, 7, "Modalidad", 1, 0, 'C');
        $this->Cell(55, 7, "Lugar", 1, 0, 'C');
        $this->Cell(55, 7, "Fecha", 1, 0, 'C');
        $this->Cell(55, 7, "Hora Inicio", 1, 0, 'C');
        $this->Cell(55, 7, "Hora Final", 1, 0, 'C');

        $this->ln();
    }
    function viewTable()
    {
        global $instancia_conexion;
        $sql="SELECT a.num_acta, ta.tipo, r.lugar, a.fecha, a.hora_inicial, a.hora_final FROM tbl_acta a
            INNER JOIN tbl_reunion r ON r.id_reunion = a.id_reunion
            INNER JOIN tbl_tipo_reunion_acta ta ON ta.id_tipo = a.id_tipo
            where a.id_estado = 1 order by a.num_acta asc";
        $stmt = $instancia_conexion->ejecutarConsulta($sql);
       
        while ($actap = $stmt->fetch_object()) {

            $this->SetFont('Times', '', 9);
            $this->Cell(55, 7, $actap->num_acta, 1, 0, 'C');
            $this->Cell(55, 7, $actap->tipo, 1, 0, 'C');
            $this->Cell(55, 7, $actap->lugar, 1, 0, 'C');
            $this->Cell(55, 7, $actap->fecha, 1, 0, 'C');
            $this->Cell(55, 7, $actap->hora_inicial, 1, 0, 'C');
            $this->Cell(55, 7, $actap->hora_final, 1, 0, 'C');
            $this->ln();
        }
    }
}


$pdf = new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('C', 'Legal', 0);
$pdf->headerTable();
$pdf->viewTable();

//$pdf->viewTable2($instancia_conexion);
$pdf->SetFont('Arial', '', 15);


$pdf->Output();

?>