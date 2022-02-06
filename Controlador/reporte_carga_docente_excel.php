
<?php
//export.php  
$servidor = "167.114.169.207";
$usuario = "informat_desarrollo";
$password = "!fuRCr3XR-tz";
$base = "informat_desarrollo_automatizacion";


$connect = mysqli_connect($servidor, $usuario, $password, $base);
$output = '';
if (isset($_POST["export"])) {
    $query = "call sel_reporte_preliminar_carga()";
    $result = mysqli_query($connect, $query);
    if (mysqli_num_rows($result) > 0) {
        $output .= '
        
   <table class="table table-bordered table-striped" bordered="1" style="color: black;">  
     <h1>Reporte Carga Academica Docente </h1>
                    <tr>  
                        <th>#</th>
                        <th>COD</th>  
                        <th>Asignatura</th>  
                        <th>Seccion</th>
                        <th>HI</th>
                        <th>HF</th>
                        <th>Dias</th>
                        <th>Aula</th>
                        <th>Edificio</th>
                        <th>N</th>
                        <th>Profesor</th>
                        <th>Cupos</th>
                    </tr>
  ';
        while ($row = mysqli_fetch_array($result)) {
            $output .= '
    <tr>                         
                            <td>' . $row["numero"] . '</td>  
                            <td>' . $row["codigo"] . '</td>  
                            <td>' . $row["asignatura"] . '</td>  
                            <td>' . $row["seccion"] . '</td>
                            <td>' . $row["hra_inicial"] . '</td>
                            <td>' . $row["hra_final"] . '</td> 
                            <td>' . $row["dia"] . '</td> 
                            <td>' . $row["aula"] . '</td> 
                            <td>' . $row["edificio"] . '</td>
                            <td>' . $row["num_empleado"] . '</td>
                            <td>' . $row["docente"] . '</td>
                            <td>' . $row["num_alumnos"] . '</td>
                    </tr>
   ';
        }
        $output .= '</table>';
        header('Content-Type: application/xls');
        header('Content-Disposition: attachment; filename=reporte_carga.xls');

        echo $output;
    }
}
?>