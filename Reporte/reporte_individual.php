<?php
require_once("../Controlador/db.php");
$db = new db;

if (isset($_GET['enviar'])) {
    $id_coordAcademica = $_GET['id_coordAcademica'];
    $nombre_docente = $_GET['nombre_docente'];
    $arrayNombre = explode(" ", $nombre_docente, 3);
    $nombre_buscar = $arrayNombre[0] . " " . $arrayNombre[1];

    $identidad = $db->get_id($nombre_buscar);
    if ($identidad == false) {
        $nombre_buscar = $arrayNombre[0];
        $n_identidad = $db->get_id($nombre_buscar);
        $id_final = $n_identidad['identidad'];
        if ($id_final == false) {
            $id_final = '0000-0000-00000';
        }
    } else {
        $id_final = $identidad['identidad'];
    }

    //$nombre_jefe = $_GET['nombre_jefe'];
    $depto = $_GET['depto'];
    //$identidad = $_GET['identidad'];
    $periodo = $_GET['periodo'];
    $fecha = $_GET['fecha'];
    $profesion_jefe = $_GET['profesion_jefe'];  
    $profesion_docente = $_GET['profesion_docente'];    


    switch($periodo)
            {    
             case "PERIODO I":
             $periodo_letra = "Primer";
             break;

             case "PERIODO II":
             $periodo_letra = "Segundo";
             break;

             case "PERIODO III":
             $periodo_letra = "Tercer";
             break;
            }

}
require '../clases/conexion3.php';
$conexion = conexion();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../">
</head>

<body>
    <?php 
    header('Content-type: application/vnd.ms-word');
    header("Content-Disposition: attachment; filename=Declaración Jurada $nombre_docente.doc");
    header("Pragma: no-cache");
    header("Expires: 0"); ?>
    <div class="container"
        <p align="center" class="f0">
           <!-- <img src="/xampp/htdocs/COPIA_AUTOMATIZACION_IMPLE_GRUPOS/dist/img/UNAH_este.png" style="width:200px;height:200px;">-->
            <strong>DECLARACIÓN JURADA DE ASIGNACIÓN ACADÉMICA</strong><br>
        </p>
        <br>
        <?php
           $consulta_estado = "SELECT estado_civil FROM tbl_personas WHERE nombres='". $nombre_buscar ."'";
           $resultado = mysqli_query($conexion, $consulta_estado);
           $fila = mysqli_fetch_assoc($resultado);

           $consulta_jefe = "SELECT * FROM `tbl_personas` WHERE `id_tipo_persona` = 4";
           $resultado_jefe = mysqli_query($conexion, $consulta_jefe);
           $fila_jefe = mysqli_fetch_assoc($resultado_jefe);
        ?>
        <p style="font-family:Calibri; text-align:justify;">
            Nosotros, <u><strong><?php echo $fila_jefe['nombres'].' '.$fila_jefe['apellidos']; ?> </strong> </u> Jefe del Departamento de <u><strong><?php echo $depto; ?> </strong></u>, hondureño (a) mayor de edad, <u><strong><?php echo $fila_jefe['estado_civil'] ?> </strong></u> con tarjeta de identidad número <u><strong><?php echo $fila_jefe['identidad'] ?> </strong></u>, de profesión <u><strong><?php echo $profesion_jefe;?> </strong></u>, y de este domicilio, <u><strong><?php echo $nombre_docente; ?></strong></u> Profesor por Hora Hondureño (a) mayor de edad, <u><strong><?php echo $fila['estado_civil']; ?></strong></u> con tarjeta de identidad número <u><strong><?php echo $id_final; ?></strong></u>, de profesión <u><strong><?php echo $profesion_docente; ?></strong></u>  y de este domicilio.
            Mediante el presente documento, libre y espontáneamente declaramos bajo juramento, que la carga académica asignada al Lic. <u><strong><?php echo $nombre_docente; ?></strong>  </u> , Profesor por Hora del Departamento de <u><strong><?php echo $depto; ?> </strong></u>, durante el <u><strong><?php echo $periodo_letra; ?></strong></u> Período Académico de <u><strong><?php echo $fecha; ?></strong></u>, es la siguiente:
        </p>

        <br>
        <br>

        <?php
        echo "<table class='table'><tr><th bgcolor='b4c6e7'>CODIGO</th><th bgcolor='b4c6e7'>ASIGNATURA</th><th bgcolor='b4c6e7'>UV</th><th bgcolor='b4c6e7'>SECCION</th><th bgcolor='b4c6e7'>N° ALUMNOS</th></tr>";
        //$consulta1 = "SELECT Codigo from tbl_carga_academica_temporal WHERE Nombre = '".$row['Nombre']."'"; 
        $consulta1 = "SELECT DISTINCT Codigo, Asignatura,UV,Seccion,N_Alumnos FROM tbl_carga_academica_temporal WHERE Nombre = '" . $nombre_docente . "' AND id_coordAcademica = ".$id_coordAcademica." group by Seccion";
        $resultado = mysqli_query($conexion, $consulta1);
        while ($row = mysqli_fetch_array($resultado)) {
            echo "<tr><td>" . $row['Codigo'] . "</td>";
            echo "<td>" . $row['Asignatura'] . "</td>";
            echo "<td>" . $row['UV'] . "</td>";
            echo "<td>" . $row['Seccion'] . "</td>";
            echo "<td>" . $row['N_Alumnos'] . "</td></tr>";
        }
        echo "</table><br>";
        ?>

       <br>
       <?php
          setlocale(LC_TIME,'es_HN');
          date_default_timezone_set("America/Tegucigalpa");
          $dia = date("d");
          $mes = date("F");
          $añito = date("Y");

          switch($mes)
            {    
             case "January":
             $mes_español = "Enero";
             break;

             case "February":
             $mes_español = "Febrero";

             case "March":
             $mes_español = "Marzo";
             break;

             case "April":
             $mes_español = "Abril";
             break;

             case "May":
             $mes_español = "Mayo";
             break;

             case "June":
             $mes_español = "Junio";
             break;

             case "July":
             $mes_español = "Julio";
             break;

             case "August":
             $mes_español = "Agosto";
             break;

             case "September":
             $mes_español = "Septiembre";
             break;

             case "October":
             $mes_español = "Octubre";
             break;

             case "November":
             $mes_español = "Noviembre";
             break;

             case "December":
             $mes_español = "Diciembre";
             break;
            }
       ?>
       <p style="font-family:Calibri; text-align:justify;">
       <b>Hacemos constar, además, que es la misma carga académica registrada en el sistema de la DIPP.</b>
       <br>
       <br>
       Y para los efectos de Ley, firmamos y extendemos esta declaración jurada en la Ciudad de Tegucigalpa, Municipio del Distrito Central a los <u><?php echo $dia;?></u> días del mes de <u><?php echo $mes_español;?></u> del año <u><?php echo $añito;?></u>.
        </p>

        <br>
        <br>
        <br>
        <br>
        <p style="font-family:Calibri;">
        <u><?php echo $nombre_docente;?></u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  ___________________________   <br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Profesor por hora&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Firma
        </p>
        <br>
        <br>
        <br>
        <br>
        <p style="font-family:Calibri;">
        <u><?php echo $fila_jefe['nombres'], $fila_jefe['apellidos'];?></u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  ___________________________   <br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jefe del Departamento&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Firma
        </p>

    </div>
</body>

</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>