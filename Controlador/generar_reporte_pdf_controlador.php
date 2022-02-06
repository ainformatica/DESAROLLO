<?php 
require_once('../clases/conexion_mantenimientos.php');
require_once ('../clases/Conexion.php');
require_once ('../Reporte/pdf/fpdf.php');


$año=$_POST['año'];
$introduccion=$_POST['introduccion'];
$objetivos=$_POST['objetivos'];
$conclu=$_POST['conclu'];
$reco=$_POST['reco'];

$sql = "SELECT IF( EXISTS( select fch_inicial_actividad from tbl_voae_actividades where YEAR(fch_inicial_actividad) = '$año'), 1, 0) as total";
                          $result = $mysqli->query($sql);
                          $valorcuenta = $result->fetch_array(MYSQLI_ASSOC);
                          $ultim = $valorcuenta['total'];

if ($ultim == 0) {
   echo '<script type="text/javascript">
                alert("NO SE PUEDE IMPRIMIR EL INFORME; NO HAY ACTIVIDADES REGISTRADAS ");
                window.location.href="../vistas/informe_final_cve_vista.php";
        </script>';

} else {

$instancia_conexion = new conexion();
//$mem = new memorandum();


class mypdf extends FPDF
{

    public function header()
    {
        $this->SetFillColor(15,57,117);
        $this->rect(0,0,220,40,'F');
        $this->SetFont('Arial','B',10);
        $this->SetTextColor(255,255,255);
        $this->setY(13);
        $this->Image('../dist/img/kkk.png', 8, 10, 25);

        $this->setX(200);
        $this->setY(13);
        $this->Image('../dist/img/logo_unah2.png', 180, 10,25,25);

        $this->setX(35);
        $this->write(5,'Universidad Nacional Autonoma de Honduras');
        $this->ln();
        $this->setX(35);
        $this->write(5,'Facultad de Ciencias Economicas, Administrativas y Contables');
        $this->ln();
        $this->setX(35);
        $this->write(5,'Departamento de Informatica Administrativa');
        $this->ln();
        $this->setX(35);
        $this->write(5,'Comite de Vida Estudiantil');
        $this->ln();
        $this->SetX(35);
        $this->SetFont('Arial','B',8);
        $this->SetTextColor(255,255,255);
        $this->write(5,'Fecha de documento:');
        $this->SetTextColor(255,255,255);
            date_default_timezone_set("America/Tegucigalpa");
            $fecha= date('d-m-Y H:i');
        $this->write(5,'    '.$fecha);



    }

    public function portada()
    {  
        $this->SetFont('Arial','B',28);
        $this->SetTextColor(15,57,117);
        $this->setY(90);
        $this->setX(38);
        $this->multicell(150,10, utf8_decode('INFORME DE ACTIVIDADES' ), 0,'C',0);
        $this->ln();
        $año=$_POST['año'];
        $this->multicell(200,10, utf8_decode('REALIZADAS DEL AÑO '.$año=$_POST['año']), 0,'C',0);
        //$this->write(5,'INFORME DE ACTIVIDAD');

        $this->ln();
    }

    

    public function CuerpodelReporte()
    {  
        $this->SetFont('Arial','B',10);
        $this->SetTextColor(15,57,117);
        $this->setY(60);
        $this->setX(85);
        $this->write(5,'LISTADO DE ACTIVIDADES FINALIZADAS');

        $this->ln();
        $this->ln();
        $this->SetFont('Arial','',12);
        $this->SetFillColor(70, 116, 202);
        $this->SetTextColor(255,255,255);
        $this->SetDrawColor(255, 192, 0);
        $this->ln();
        $this->SetFont('Arial','',8);
        $this->cell(25,5,'Periodo',0,0,'C',1);
        $this->cell(25,5,'Actividad',0,0,'C',1);
        $this->cell(25,5,'Fecha de Activ',0,0,'C',1);
        $this->cell(60,5,'Descripcion',0,0,'C',1);
        $this->cell(30,5,'Organizadores',0,0,'C',1);
        $this->cell(35,5,'Observaciones',0,0,'C',1);

       

        $año=$_POST['año'];
        $sql="SELECT * FROM tbl_voae_actividades Where YEAR(fch_inicial_actividad)= $año and id_estado = 6 and tipo_actividad = 'ACTIVIDAD INTERNA' ";
        global $instancia_conexion;
        $stmt = $instancia_conexion->ejecutarConsulta($sql);

        while ($reg = $stmt->fetch_object()) {

            $this->ln();
            $this->SetFont('Arial','',6);
            $this->SetFillColor(247, 246, 246);
            $this->SetTextColor(0,0,0);
            $this->cell(25,5,utf8_decode($reg->periodo),0,0,'C',1);
            $this->cell(25,5,utf8_decode($reg->nombre_actividad),0,0,'C',1);
            $this->cell(25,5,utf8_decode($reg->fch_final_actividad),0,0,'C',1);
            $this->cell(60,5,utf8_decode($reg->descripcion),0,0,'C',1);
            $this->cell(30,5,utf8_decode($reg->staff_alumnos),0,0,'C',1);
            $this->cell(35,5,utf8_decode($reg->observaciones),0,0,'C',1);
            $this->Ln();
        }
        

    }

    public function Introduccion()
    {  
        $this->SetFont('Arial','B',10);
        $this->SetTextColor(15,57,117);
        $this->setY(60);
        $this->setX(85);
        $this->write(5,'INTRODUCCION');
        
        $introduccion=$_POST['introduccion'];
        $objetivos=$_POST['objetivos'];
        $conclu=$_POST['conclu'];
        $reco=$_POST['reco'];
        $año=$_POST['año'];
        
        $this->setY(70);
        $this->setX(20);
        $this->Multicell(0,5,utf8_decode($introduccion),0,'J',0);

    }

    public function Objetivos()
    {  
        $this->SetFont('Arial','B',10);
        $this->SetTextColor(15,57,117);
        $this->setY(60);
        $this->setX(85);
        $this->write(5,'OBJETIVOS');
       
        $objetivos=$_POST['objetivos'];
        
        $this->setY(70);
        $this->setX(20);
        $this->Multicell(0,5,utf8_decode($objetivos),0,'J',0);

    }

    public function Conclusiones()
    {  
        $this->SetFont('Arial','B',10);
        $this->SetTextColor(15,57,117);
        $this->setY(60);
        $this->setX(85);
        $this->write(5,'CONCLUSIONES');
        
        $conclu=$_POST['conclu'];
    
        
        $this->setY(70);
        $this->setX(20);
        $this->Multicell(0,5,utf8_decode($conclu),0,'J',0);

    }
    public function Recomendaciones()
    {  
        $this->SetFont('Arial','B',10);
        $this->SetTextColor(15,57,117);
        $this->setY(60);
        $this->setX(85);
        $this->write(5,'RECOMENDACIONES');
    
        $reco=$_POST['reco'];
       
        
        $this->setY(70);
        $this->setX(20);
        $this->Multicell(0,5,utf8_decode($reco),0,'J',0);

    }



    public function footer()
    {
        //Texto footer
        $this->SetFillColor(15,57,117);
        $this->rect(0,270,120,10,'F');
        //$this->SetFont('Arial','B',10);
        //$this->SetTextColor(0,0,0);
        //$this->cell(0,236, utf8_decode('Tegucigalpa Ciudad Universitaria '),0,1,'L');

        // Texto de orden de pagina
        $this->SetFillColor(255, 204, 15);
        $this->rect(120,270,120,10,'F');
        $this->SetFont('Arial','B',10);
        $this->SetTextColor(15,57,117);
        $this->setY(270);
        $this->setX(210);
        $this->cell(0,10, utf8_decode('Página').$this->PageNo().'/{nb}',0,1,'C');

    }
}


$fpdf = new mypdf('P', 'mm', 'letter', true);
$fpdf->AddPage('portraid', 'Letter',0);
$fpdf->portada();
$fpdf->AddPage('portraid', 'Letter',0);
$fpdf->Introduccion();
$fpdf->AddPage('portraid', 'Letter',0);
$fpdf->Objetivos();
$fpdf->AddPage('portraid', 'Letter',0);

$fpdf->CuerpodelReporte();
$fpdf->AddPage('portraid', 'Letter',0);
$fpdf->Conclusiones();
$fpdf->AddPage('portraid', 'Letter',0);
$fpdf->Recomendaciones();
$fpdf->AliasNbPages();

$fpdf->SetMargins(20,30,30,20);
$fpdf->output();
}

?>
<script src="../plugins/select2/js/select2.min.js"></script>