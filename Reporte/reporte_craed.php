<?php
//require '../clases/conexion3.php';

require('../clases/Conexion.php');
//$conexion = conexion();

if (isset($_GET['enviar'])) {
    $id_craed = $_GET['id_archivo'];
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
$anio = date("Y");

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
      <!--  <img src="../img/UNAH_CARGA.png" style="width:200px;height:200px;">-->
        <center>
            <h2>Departamento de Informática</h2>
            <table bgcolor='ffbb00' BORDERCOLOR='ffbb00' style="width:100%">
                <td style="height:50%">
                    <h2 style="text-align: center;"> CRAED: PERIODO <?php echo $periodo_letra; ?> <?php echo $fecha; ?></h2>
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

        $sql = "SELECT DISTINCT(`Centro_cr`) as centros FROM tbl_carga_craed WHERE id_craed_jefa = " . $id_craed . "";
        $resultado = $mysqli->query($sql);
        while ($fila_plan = $resultado->fetch_assoc()) {
            echo "<h2>" . $fila_plan['centros'] . "</h2>";
            echo "<table class='table'>";
            echo "<tr>
                    <th bgcolor='b4c6e7'>CODIGO</th>
                    <th bgcolor='b4c6e7'>ASIGNATURA</th>
                    <th bgcolor='b4c6e7'>SECCION</th>                    
                    <th bgcolor='b4c6e7'>HI</th>
                    <th bgcolor='b4c6e7'>HF</th>
                    <th bgcolor='b4c6e7'>DIAS</th>
                    <th bgcolor='b4c6e7'>NUMERO</th>
                    <th bgcolor='b4c6e7'>PROFESOR</th>
                    <th bgcolor='b4c6e7'>CUPOS</th>
                    <th bgcolor='b4c6e7'>SEMANA</th>
            </tr>";
            $sql4 = "SELECT * from tbl_carga_craed WHERE Centro_cr = '" . $fila_plan['centros'] . "'";
            $query4 = $mysqli->query($sql4);
            //$query4 = $db->query("SELECT `trimestre_1`, `trimestre_2`, `trimestre_3`, `trimestre_4` FROM `tbl_metas` WHERE id_indicador = " . $fila_ind['id_indicador'] . " ");
            while ($fila_met = $query4->fetch_assoc()) {
                echo "<tr><td>" . $fila_met['Codigo_cr'] . "</td>";
                echo "<td>" . $fila_met['Asignatura_cr'] . "";
                echo "<td>" . $fila_met['Seccion_cr'] . "</td>";
                echo "<td>" . $fila_met['HI_cr'] . "</td>";
                echo "<td>" . $fila_met['HF_cr'] . "</td>";
                echo "<td>" . $fila_met['Dias_cr'] . "</td>";
                echo "<td>" . $fila_met['Numero'] . "</td>";
                echo "<td>" . $fila_met['Profesor'] . "</td>";
                echo "<td>" . $fila_met['Cupos'] . "</td>";
                echo "<td>" . $fila_met['Semana'] . "</td></tr>";
            }
            echo "</table><br>";
        }
       
        ?>
    </div>
</body>

</html>
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>