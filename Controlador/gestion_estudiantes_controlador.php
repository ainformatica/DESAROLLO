<?php
require_once "../Modelos/gestion_estudiantes_modelo.php";

$id_persona = isset($_POST["id_persona"]) ? limpiarCadena1($_POST["id_persona"]) : "";
$id_persona_ = isset($_POST["id_persona_"]) ? limpiarCadena1($_POST["id_persona_"]) : "";
$id_persona1 = isset($_POST["id_persona1"]) ? limpiarCadena1($_POST["id_persona1"]) : "";
$nombre = isset($_POST["nombre"]) ? limpiarCadena1($_POST["nombre"]) : "";
$Estado = isset($_POST["Estado"]) ? limpiarCadena1($_POST["Estado"]) : "";
$trabajo = isset($_POST["trabajo"]) ? limpiarCadena1($_POST["trabajo"]) : "";
$egresado = isset($_POST["egresado"]) ? limpiarCadena1($_POST["egresado"]) : "";
$identidad = isset($_POST["identidad"]) ? limpiarCadena1($_POST["identidad"]) : "";
$ncuenta = isset($_POST["ncuenta"]) ? limpiarCadena1($_POST["ncuenta"]) : "";
$carrera_ = isset($_POST["carrera_"]) ? limpiarCadena1($_POST["carrera_"]) : "";
$cregional_ = isset($_POST["cregional_"]) ? limpiarCadena1($_POST["cregional_"]) : "";


$instancia_modelo=new modelo_gestion_estudiante();

switch ($_GET["op"])
{

  case 'estado':
    $rspta = $instancia_modelo->actualizarestado( $Estado, $id_persona_);
  break;

  case 'selectCAR':
    if (isset($_POST['activar'])) {
        $data=array();
        $respuesta=$instancia_modelo->listar_selectCAR();       
          while ($r=$respuesta->fetch_object()) {                   
               # code...
               echo "<option value='". $r->Descripcion."'> ".$r->Descripcion." </option>";               
           }              
         }
         else{
           echo 'No hay información';
         }       
  break;

  case 'selectCR':
    if (isset($_POST['activar'])) {
        $data=array();
        $respuesta=$instancia_modelo->listar_selectCR();       
          while ($r=$respuesta->fetch_object()) {     
             
               # code...
               echo "<option value='". $r->centro_regional."'> ".$r->centro_regional." </option>";
               
           }  
         }
         else{
           echo 'No hay información';
         }
  break;

  case 'selectNACI':
    if (isset($_POST['activar'])) {
        $data=array();
        $respuesta=$instancia_modelo->listar_selectNACI();       
          while ($r=$respuesta->fetch_object()) {
               # code...
               echo "<option value='". $r->nacionalidad."'> ".$r->nacionalidad." </option>";               
           }
         }
         else{
           echo 'No hay información';
         }    
break;

  case 'modificar_gestion_estudiante':
    $rspta = $instancia_modelo->modificar_gestion_estudiante($identidad, $ncuenta, $carrera_, $cregional_, $egresado, $id_persona1);
    //Codificar el resultado utilizando json
    echo json_encode($rspta);
    break;

 }
?>
