<?php
require_once "../Modelos/reg_estudiantes_login_modelo.php";
ob_start();
session_start();
/*1-*/ $id_persona2 = isset($_POST["id_persona2"]) ? limpiarCadena1($_POST["id_persona2"]) : "";
/*2-*/ $identidad = isset($_POST["identidad"]) ? limpiarCadena1($_POST["identidad"]) : "";
/*3-*/ $nacionalidad=isset($_POST["nacionalidad"]) ? limpiarCadena1($_POST["nacionalidad"]) : "";
/*4-*/ $ecivil = isset($_POST["ecivil"]) ? limpiarCadena1($_POST["ecivil"]) : "";
/*5-*/ $fecha_nacimiento=isset($_POST["fecha_nacimiento"]) ? limpiarCadena1($_POST["fecha_nacimiento"]) : "";
/*6-*/ $lugar_nacimiento=isset($_POST["lugar_nacimiento"]) ? limpiarCadena1($_POST["lugar_nacimiento"]) : "";
/*7-*/ $trabajo = isset($_POST["trabajo"]) ? limpiarCadena1($_POST["trabajo"]) : "";
/*8-*/ $egresado = isset($_POST["egresado"]) ? limpiarCadena1($_POST["egresado"]) : "";
/*9-*/ $carrera = isset($_POST["carrera"]) ? limpiarCadena1($_POST["carrera"]) : "";
/*10-*/ $cregional = isset($_POST["cregional"]) ? limpiarCadena1($_POST["cregional"]) : "";
/*11-*/ $curriculo = isset($_POST["curriculo"]) ? limpiarCadena1($_POST["curriculo"]) : "";
/*12-*/ $foto = isset($_POST["foto"]) ? limpiarCadena1($_POST["foto"]) : "";
/*12-*/ $telefono = isset($_POST["telefono"]) ? limpiarCadena1($_POST["telefono"]) : "";


$instancia_modelo= new modelo_reg_estudiantes2();

$id_persona2= $_SESSION['id_persona'];
//echo $id_persona2;
switch ($_GET["op"]){
  
  case 'traerId_estudiante':
    
    $respuesta= $instancia_modelo-> traerId_estudiante($_SESSION['usuario']) -> fetch_object();
    echo $respuesta->id_persona;
    break;


case 'ExisteIdentidad':
    $respuesta=$instancia_modelo->ExisteIdentidad($identidad);
    echo json_encode($respuesta);
    
  break;
  
 
  case 'completar_registro':
    $respuesta=$instancia_modelo->completar_registro($id_persona2,$identidad,$nacionalidad,$ecivil,$fecha_nacimiento,$lugar_nacimiento,$trabajo, $egresado,$carrera,$cregional, $telefono);
    echo json_encode($respuesta);
   
     
  break;

  
  case 'validar_depto':
    $respuesta = $instancia_modelo->validar_depto($codigo);
    echo json_encode($respuesta);
  
    break;

 }
?>
