<?php
//BA5A41
require_once('../clases/conexion_mantenimientos.php');
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=reporte-carga");
header("Pragma: no-cache");
header("Expires: 0");
$instancia_conexion = new conexion();
?>

<table>
    <tr>
        <td style="font-weight: bold;text-align: center; background-color:#fff; color:black;" colspan="12"><?php echo utf8_decode("UNIVERSIDAD NACIONAL AUTÓNOMA DE HONDURAS"); ?> </td>
    </tr>
    <tr>
        <td style="font-weight: bold;text-align: center; background-color:#fff; color: black;" colspan="12"><?php echo utf8_decode("FACULTAD DE CIENCIAS ECONÓMICAS, ADMINISTRATIVAS Y CONTABLES"); ?></td>
    </tr>
    <tr>
        <td style="font-weight: bold;text-align: center; background-color:#fff; color: black;" colspan="12"><?php echo utf8_decode("DEPARTAMENTO DE INFORMÁTICA "); ?></td>
    </tr>
    <tr>
        <td style="font-weight: bold;text-align: center; background-color:#fff; color: black;" colspan="12"><?php echo utf8_decode("PROGRAMACIÓN ACADÉMICA"); ?></td>
    </tr>
    <!--  <tr>
        <td colspan="10"></td>
    </tr> -->


    <!--   <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      
       

        <?php
        // date_default_timezone_set("America/Tegucigalpa");
        //$fecha = date('d-m-Y h:i:s'); 
        ?>
        <td style="font-weight: bold;">FECHA:</td>
        <td><?php //echo $fecha 
            ?> </td>
    </tr> -->
    <tr>
        <td colspan="10"></td>
    </tr>

</table>
<table border="1">
    <thead>
        <!--   <tr></tr> -->
        <tr>

            <th colspan="1" style="text-align: center; background-color:darksalmon; ">#</th>
            <th colspan="1" style="text-align: center; background-color:darksalmon; "><?php echo utf8_decode("CÓD"); ?></th>
            <th colspan="1" style="text-align: center; background-color:darksalmon; ">Asignatura</th>
            <th colspan="1" style="text-align: center; background-color:darksalmon;"><?php echo utf8_decode("Sección"); ?></th>
            <th colspan="1" style="text-align: center; background-color:darksalmon;">HI</th>
            <th colspan="1" style="text-align: center; background-color:darksalmon;">HF</th>
            <th colspan="1" style="text-align: center; background-color:darksalmon;"><?php echo utf8_decode("Días"); ?></th>
            <th colspan="1" style="text-align: center; background-color:darksalmon;">Aula</th>
            <th colspan="1" style="text-align: center; background-color:darksalmon;">Edificio</th>
            <th colspan="1" style="text-align: center; background-color:darksalmon;">N.</th>
            <th colspan="1" style="text-align: center; background-color:darksalmon;">Profesor</th>
            <th colspan="1" style="text-align: center; background-color:darksalmon;">Cupos</th>


        </tr>
    </thead>
    <tbody>
        <?php global $instancia_conexion;
        $sql = "call sel_reporte_preliminar_carga()";
        $stmt = $instancia_conexion->ejecutarConsulta($sql);
        while ($reg = mysqli_fetch_assoc($stmt)) {
        ?>

            <tr>
                <td colspan="1" style="text-align: center;"><?php echo $reg['numero']; ?></td>
                <td colspan="1" style="text-align: center;"><?php echo $reg['codigo']; ?></td>
                <td colspan="1" style="text-align: center;"><?php echo utf8_decode($reg['asignatura']); ?></td>
                <td colspan="1" style="text-align: center;"><?php echo $reg['seccion']; ?></td>
                <td colspan="1" style="text-align: center;"><?php echo $reg['hra_inicial']; ?></td>
                <td colspan="1" style="text-align: center;"><?php echo $reg['hra_final']; ?></td>
                <td colspan="1" style="text-align: center;"><?php echo $reg['dia']; ?></td>
                <td colspan="1" style="text-align: center;"><?php echo $reg['aula']; ?></td>
                <td colspan="1" style="text-align: center;"><?php echo $reg['edificio']; ?></td>
                <td colspan="1" style="text-align: center;"><?php echo $reg['num_empleado']; ?></td>
                <td colspan="1" style="text-align: center;"><?php echo utf8_decode($reg['docente']); ?></td>
                <td colspan="1" style="text-align: center;"><?php echo $reg['num_alumnos']; ?></td>


            </tr>
        <?php }
        mysqli_free_result($stmt); ?>


    </tbody>
</table>