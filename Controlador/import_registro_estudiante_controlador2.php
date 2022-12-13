<?php


require_once ('../vendor/autoload.php');
require_once('../clases/Conexion.php');
require_once ('../clases/encriptar_desencriptar.php'); 

session_start();//para llamar el número de id del usuario

use PhpOffice\PhpSpreadsheet\IOFactory;

$nombreArchivo = 'import reg-estudiantes.xlsx';
$documento = IOFactory::load($nombreArchivo);
$totalHojas = $documento->getSheetCount();

$hojaActual = $documento->getsheet(0);
$numeroFilas = $hojaActual ->getHighestDataRow();
$letra = $hojaActual ->getHigestColumn();

$numeroLetra = Coordinate::columnIndexFromString($letra);

$id_usuario2= $_SESSION['id_usuario'];

for ($indiceFila=1; $indiceFila <= $numeroFilas ; $ndiceFila++) {
    for ($indiceColumna=1; $indiceColumna <= $numeroLetra ; $indiceColumna++) { 

        $valorA = $hojaActual ->getCellByColumnAndRown(1, $indiceFila);
        $valorB = $hojaActual ->getCellByColumnAndRown(2, $indiceFila);
        $valorC = $hojaActual ->getCellByColumnAndRown(3, $indiceFila);
        $valorD = $hojaActual ->getCellByColumnAndRown(4, $indiceFila);
        $valorE = $hojaActual ->getCellByColumnAndRown(5, $indiceFila);
        $valorF = $hojaActual ->getCellByColumnAndRown(6, $indiceFila);
        $valorG = $hojaActual ->getCellByColumnAndRown(7, $indiceFila);
        $valorH = $hojaActual ->getCellByColumnAndRown(8, $indiceFila);
        $valorI = $hojaActual ->getCellByColumnAndRown(9, $indiceFila);
        $valorJ = $hojaActual ->getCellByColumnAndRown(10, $indiceFila);

        $letra=substr($valorA, 0, 1);
        $palabra = explode (" ", $valoB);
        $usuario=$letra.$palabra[0];
        $usuario_final = strtoupper($usuario);

        function gtoken ($longitud){
            $cadena = "_@&1Aa2Bb3Cc4Dd5Ee6Ff7Gg8Hh9Ii0JjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz_";
            $token = "";
        
            for ($i=0; $i < $longitud; $i++) { 
                # code...
                $token .= $cadena[rand(0, $longitud)]; //rand genera un número aleatorio desde un mínimo a un máximo, en este caso el mínimo será cero y el máximo la longitud
            }
            return $token;
        }
        
        $password = gtoken(8);
        
        $password=cifrado::encryption($contrasena);

        $sql="call proc_insert_usuario_estudiantes_IMPORT (nombres, apellidos, identidad, sexo, nacionalidad,fecha_nacimiento, id_tipo_persona, ncuenta, telefono, email, usuario, contrasena) VALUES ('$valorA', '$valorB', '$valorC', '$valorD', '$valorE', '$valorF', '$valorG', '$valorH', '$valorI', '$valorJ', '$usuario_final', '$password')";
        $mysqli->query($sql);
        # code...
    }
    echo 'Carga completa';
    # code...
}
?>


