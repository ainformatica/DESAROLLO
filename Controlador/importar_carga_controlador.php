<?php

require_once('../clases/funcion_bitacora.php');


if (isset($_GET['op'])) {

    switch ($_GET['op']) {

        case 'cargarExcel':
            try {
                if (is_array($_FILES["archivoExcel"]) && count($_FILES["archivoExcel"]) > 0) {

                    //SE LLAMA A LA LIBRERIA
                    require_once('../PHPExcel/Classes/PHPExcel.php');

                    $tmpfname = $_FILES['archivoExcel']['tmp_name'];

                    //CREAR EL EXCEL PARA LUEGO LEERLO
                    $leer_excel = PHPExcel_IOFactory::createReaderForFile($tmpfname);

                    //CARGAR NUESTRO EXCELL
                    $excel_obj = $leer_excel->load($tmpfname);

                    //CARGAR EN QUE HOJA TRABAJAREMOS DEL EXCEL
                    $hoja = $excel_obj->getSheet(0);
                    $filas = $hoja->getHighestRow();
                    echo "<table id='tabla_detalle' class='table' style='width: 100%; table-layout:fixed'>
                <thead>
                    <tr bgcolor ='black' style='color: #FFFFFF'> 
                        <td>Control</td>
                        <td>Cod</td>
                        <td>Asignatura</td>
                        <td>Seccion</td>
                        <td>Hra Inicio</td>
                        <td>Hra Final</td>
                        <td>Dias</td>
                        <td>Aulas</td>
                        <td>Profesor</td>
                        <td>Matriculados</td>
            
                    </tr>
                </thead>
                <tbody id='tbody_tabla_detalle'>
                ";


                    for ($row = 2; $row <= $filas; $row++) {

                        $control = $hoja->getCell('A' . $row);
                        $cod_asig = $hoja->getCell('B' . $row);
                        $asignatura = $hoja->getCell('C' . $row);
                        $seccion = $hoja->getCell('D' . $row);
                        $hora_inicio = $hoja->getCell('E' . $row);
                        $hora_final = $hoja->getCell('F' . $row);
                        $dias = $hoja->getCell('G' . $row);
                        $aula = $hoja->getCell('H' . $row);
                        $profesor = $hoja->getCell('K' . $row);
                        $matriculados = $hoja->getCell('L' . $row);

                        if ($control == "") {
                        } else {
                            echo "<tr>";
                            echo "<td>" . $control . "</td>";
                            echo "<td>" . $cod_asig . "</td>";
                            echo "<td>" . $asignatura . "</td>";
                            echo "<td>" . $seccion . "</td>";
                            echo "<td>" . $hora_inicio . "</td>";
                            echo "<td>" . $hora_final . "</td>";
                            echo "<td>" . $dias . "</td>";
                            echo "<td>" . $aula . "</td>";
                            echo "<td>" . $profesor . "</td>";
                            echo "<td>" . $matriculados . "</td>";
                            echo "</tr>";
                        }
                    }

                    echo "</tbody></table>";
                } else {
                    return 0;
                }

                //code...
            } catch (\Throwable $th) {
                echo $th;
               
            }

           


            break;
            //aqui va la preliminar


        case 'cargarExcel_preliminar':

            if (is_array($_FILES["archivo_excel_preliminar"]) && count($_FILES["archivo_excel_preliminar"]) > 0
            ) {

                //SE LLAMA A LA LIBRERIA
                require_once('../PHPExcel/Classes/PHPExcel.php');

                $tmpfname = $_FILES['archivo_excel_preliminar']['tmp_name'];

                //CREAR EL EXCEL PARA LUEGO LEERLO
                $leer_excel = PHPExcel_IOFactory::createReaderForFile($tmpfname);

                //CARGAR NUESTRO EXCELL
                $excel_obj = $leer_excel->load($tmpfname);

                //CARGAR EN QUE HOJA TRABAJAREMOS DEL EXCEL
                $hoja = $excel_obj->getSheet(0);
                $filas = $hoja->getHighestRow();
                echo "<table id='tabla_detalle_preliminar' class='table' style='width: 100%; table-layout:fixed'>
                <thead>
                    <tr bgcolor ='black' style='color: #FFFFFF'> 
                       
                        <td>Cod</td>
                        <td>Asignatura</td>
                        <td>Seccion</td>
                        <td>Hra Inicio</td>
                        <td>Hra Final</td>
                        <td>Dias</td>
                        <td>Aulas</td>
                        <td>Profesor</td>
                        <td>Matriculados</td>
                       
            
                    </tr>
                </thead>
                <tbody id='tbody_tabla_detalle_preliminar'>
                ";


                for ($row = 5;
                    $row <= $filas;
                    $row++
                ) {

                    $cod_asig = $hoja->getCell('A' . $row);
                    $asignatura = $hoja->getCell('B' . $row);
                    $seccion = $hoja->getCell('C' . $row);
                    $hora_inicio = $hoja->getCell('E' . $row);
                    $hora_final = $hoja->getCell('F' . $row);
                    $dias = $hoja->getCell('G' . $row);
                    $aula = $hoja->getCell('H' . $row);
                    $profesor = $hoja->getCell('J' . $row);
                    $matriculados = $hoja->getCell('K' . $row);
                  //  $control = $hoja->getCell('M' . $row);

                    if ($cod_asig == "") {
                    } else {
                        echo "<tr>";
                        echo "<td>" . $cod_asig . "</td>";
                        echo "<td>" . $asignatura . "</td>";
                        echo "<td>" . $seccion . "</td>";
                        echo "<td>" . $hora_inicio . "</td>";
                        echo "<td>" . $hora_final . "</td>";
                        echo "<td>" . $dias . "</td>";
                        echo "<td>" . $aula . "</td>";
                        echo "<td>" . $profesor . "</td>";
                        echo "<td>" . $matriculados . "</td>";
                        echo "</tr>";
                    }
                }

                echo "</tbody></table>";
            } else {
                return 0;
            }



            break;
    }
};
?>