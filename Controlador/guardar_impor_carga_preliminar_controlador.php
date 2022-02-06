<?php
require '../Modelos/importar_carga_modelo.php';

$ME = new modelo_excel();


//$control = htmlspecialchars($_POST['control'], ENT_QUOTES, 'UTF-8');
$cod_asig = htmlspecialchars($_POST['cod'],ENT_QUOTES,'UTF-8');
$seccion = htmlspecialchars($_POST['seccion'],ENT_QUOTES,'UTF-8');
$hora_inicio = htmlspecialchars($_POST['hra_inicio'],ENT_QUOTES,'UTF-8');
$hora_final = htmlspecialchars($_POST['hra_final'],ENT_QUOTES,'UTF-8');
$dias = htmlspecialchars($_POST['dias'],ENT_QUOTES,'UTF-8');
$aula = htmlspecialchars($_POST['aula'],ENT_QUOTES,'UTF-8');
$profesor = htmlspecialchars($_POST['prof'],ENT_QUOTES,'UTF-8');
$matriculados = htmlspecialchars($_POST['matri'],ENT_QUOTES,'UTF-8');

//CUANDOE ENCONTRAMOS UNA COMA LO SEPARA Y LO CONVIERTE EN UN ARREGLO
//$array_control = explode(",",$control); 
$array_cod = explode(",",$cod_asig);
$array_seccion = explode(",",$seccion);
$array_hra_inicio = explode(",",$hora_inicio);
$array_hra_final = explode(",",$hora_final);
$array_dias = explode(",",$dias);
$array_aula = explode(",",$aula);
$array_profesor = explode(",",$profesor);
$array_matri = explode(",",$matriculados);




for ($i=0; $i< count($array_cod); $i++) { 
    
    $consulta = $ME->registrar_excel_preliminar($array_profesor[$i], $array_aula[$i], $array_cod[$i], $array_seccion[$i], $array_matri[$i], $array_dias[$i], $array_hra_inicio[$i], $array_hra_final[$i]);

   

}
echo $consulta;
?>

