<?php
require '../vendor/autoload.php';

class MyReadFilter implements \PhpOffice\PhpSpreadsheet\Reader\IReadFilter
{

    public function readCell($column, $row, $worksheetName = '')
    {
        // Read title row and rows 20 - 30
        if ($row > 1) {
            return true;
        }
        return false;
    }
}

$inputFileName = $_FILES['archivo_excel_preliminar']['tmp_name'];
$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
/**  Identify the type of $inputFileName  **/

$inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
/**  Create a new Reader of the type that has been identified  **/


$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);

//leo de la funcio para tener los datos de una celsa especifica mayor al nume de la funcion

//$reader->setReadFilter(new MyReadFilter());

/**  Load $inputFileName to a Spreadsheet Object  **/
$spreadsheet = $reader->load($inputFileName);

$cantidad = $spreadsheet->getActiveSheet()->toArray();

$hoja = $spreadsheet->getSheet(0);
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


for (
    $row = 5;
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
