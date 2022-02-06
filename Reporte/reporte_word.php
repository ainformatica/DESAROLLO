<?php
// require '../clases/conexion3.php';
// $conexion = conexion();

require('../clases/Conexion.php');

if (isset($_GET['enviar'])) {
    $id_coordAcademica = $_GET['id_archivo'];
    $nombre_master = $_GET['master_n'];
    $numero_ofi = $_GET['numero_ofi'];
    //aqui
    $periodo = $_GET['periodo'];
    $fecha = $_GET['fecha'];
}

switch ($periodo) {
    case "PERIODO I":
        $periodo_letra = "I PAC";
        break;

    case "PERIODO II":
        $periodo_letra = "II PAC";
        break;

    case "PERIODO III":
        $periodo_letra = "III PAC";
        break;
}


setlocale(LC_TIME, 'es_HN');
date_default_timezone_set("America/Tegucigalpa");
$dia = date("d");
$mes = date("F");
$añito = date("Y");

switch ($mes) {
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
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- <link rel="stylesheet" type="text/css" href="style.css"> -->
</head>

<body>
    <div class="container">
       <!-- <img src="/xampp/htdocs/COPIA_AUTOMATIZACION_IMPLE_GRUPOS/dist/img/UNAH_CARGA.png" style="width:200px;height:200px;">-->
        <br>
        <br>
        <p><strong>OFICIO No <?php echo $numero_ofi; ?> </strong> <br>
            <?php echo $dia; ?> de <?php echo $mes_español; ?> de <?php echo $añito; ?> </p>
        <!-- <label for=""><strong>27 de enero de 2021</strong></label>-->
        <br>
        <br>
        <p>MASTER<br>
            <b><?php echo $nombre_master; ?></b> <br>
            Decano de la facultad de Ciencias Económicas, Administrativas y Contables <br>
            Su Oficina
        </p>

        <strong>Estimado Máster:</strong> <br> <br>
        <p style="text-align:justify">De acuerdo con lo solicitado, remito la <strong>Carga Académica completa de profesores</strong> de este Departamento, correspondiente al <?php echo $periodo_letra; ?> <?php echo $fecha; ?></p>
        <p>Sin otro particular, me despido de Usted,</p>
        <p>Atentamente</p>

        <br>
        <br> <br> <br>
        <br> <br> <br>
        <br> <br> <br>
        <br>
        <?php
        // $consulta_jefe = "SELECT * FROM `tbl_personas` WHERE `id_tipo_persona` = 4";
        // $resultado_jefe = mysqli_query($conexion, $consulta_jefe);
        // $fila_jefe = mysqli_fetch_assoc($resultado_jefe);

        $sql0 = "SELECT * FROM `tbl_personas` WHERE `id_tipo_persona` = 4";
        $resultado = $mysqli->query($sql0);
        $fila_jefe = $resultado->fetch_assoc();
        ?>

        <p style="font-family:Calibri;">
            <?php echo $fila_jefe['nombres'] . ' ' . $fila_jefe['apellidos']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;_______________________________<br>
            &nbsp;&nbsp;&nbsp;&nbsp;<b>Jefe Departamento de Informática</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;VoBo. Msc <?php echo $nombre_master; ?>
        </p>
        <br>
        UNAH-CU
        <br>
        <br>
        <small>Cc: Archivo</small> <br>
        <small>Cc: Cronológico</small>
        <br>
        <br>


        <center>
            <h2>Departamento de Informática</h2>
            <table bgcolor='ffbb00' BORDERCOLOR='ffbb00' style="width:100%">
                <td style="height:50%">
                    <h2 style="text-align: center;"> CARGA ACADÉMICA <?php echo $periodo_letra; ?> <?php echo $fecha; ?></h2>
                </td>
            </table>
        </center>
        <br>
        <br>

        <?php

        header('Content-type: application/vnd.ms-word');
        header("Content-Disposition: attachment; filename=Carga Académica Final.doc");
        header("Pragma: no-cache");
        header("Expires: 0");

        $Conteo = 1;
        $sql1 = "SELECT DISTINCT Nombre, N_empleado from tbl_carga_academica_temporal WHERE id_coordAcademica = " . $id_coordAcademica . " ";
        $resultado = $mysqli->query($sql1);
        while ($row = $resultado->fetch_assoc()) {
            echo "<h3><b>" . $Conteo++ . ')' . '&nbsp;&nbsp;&nbsp;&nbsp;' . $row['N_empleado'] . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $row['Nombre'] . "</b></h3>";
            echo "<table class='table'>";
            echo "<tr><th bgcolor='b4c6e7'>Control</th><th bgcolor='b4c6e7'>CODIGO</th><th bgcolor='b4c6e7'>ASIGNATURA</th><th bgcolor='b4c6e7'>UV</th><th bgcolor='b4c6e7'>SECCION</th><th bgcolor='b4c6e7'>N° ALUMNOS</th></tr>";

            $sql2 = "SELECT DISTINCT N_control, Codigo, Asignatura,UV,Seccion,N_Alumnos FROM tbl_carga_academica_temporal WHERE Nombre = '" . $row['Nombre'] . "' AND id_coordAcademica = " . $id_coordAcademica . " group by Seccion";
            $resultado2 = $mysqli->query($sql2);
            while ($row1 = $resultado2->fetch_assoc()) {
                echo "<tr><td>" . $row1['N_control'] . "</td>";
                echo "<td>" . $row1['Codigo'] . "</td>";
                echo "<td>" . $row1['Asignatura'] . "</td>";
                echo "<td>" . $row1['UV'] . "</td>";
                echo "<td>" . $row1['Seccion'] . "</td>";
                echo "<td>" . $row1['N_Alumnos'] . "</td></tr>";
            }
            echo "</table><br>";
        }



        // $Conteo = 1;
        // $consulta = "SELECT DISTINCT Nombre, N_empleado from tbl_carga_academica_temporal WHERE id_coordAcademica = " . $id_coordAcademica . " ";
        // $result = mysqli_query($conexion, $consulta);
        // while ($row = mysqli_fetch_array($result)) {
        //     echo "<h3><b>" .$Conteo++.')'.'&nbsp;&nbsp;&nbsp;&nbsp;'.$row['N_empleado'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$row['Nombre'] . "</b></h3>";
        //     echo "<table class='table'>";
        //     echo "<tr><th bgcolor='b4c6e7'>Control</th><th bgcolor='b4c6e7'>CODIGO</th><th bgcolor='b4c6e7'>ASIGNATURA</th><th bgcolor='b4c6e7'>UV</th><th bgcolor='b4c6e7'>SECCION</th><th bgcolor='b4c6e7'>N° ALUMNOS</th></tr>";
        //     //$consulta1 = "SELECT Codigo from tbl_carga_academica_temporal WHERE Nombre = '".$row['Nombre']."'"; 
        //     $consulta1 = "SELECT DISTINCT N_control, Codigo, Asignatura,UV,Seccion,N_Alumnos FROM tbl_carga_academica_temporal WHERE Nombre = '" . $row['Nombre'] . "' AND id_coordAcademica = " . $id_coordAcademica . " group by Seccion";
        //     $resultado = mysqli_query($conexion, $consulta1);
        //     while ($row = mysqli_fetch_array($resultado)) {
        //         //echo "Codigo: ".$row['Codigo']."Seccion: ".$row['Seccion']. "<br>" ;

        //         echo "<tr><td>" . $row['N_control'] . "</td>";
        //         echo "<td>" . $row['Codigo'] . "</td>";
        //         echo "<td>" . $row['Asignatura'] . "</td>";
        //         echo "<td>" . $row['UV'] . "</td>";
        //         echo "<td>" . $row['Seccion'] . "</td>";
        //         echo "<td>" . $row['N_Alumnos'] . "</td></tr>";
        //     }
        //     echo "</table><br>";
        // }
        ?>
    </div>
</body>

</html>
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>