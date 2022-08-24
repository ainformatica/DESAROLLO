<?php
require_once "../Modelos/registro_estudiantes_modelo.php";

$nombre=isset($_POST["nombre"]) ? limpiarCadena1($_POST["nombre"]) : "";
$apellidos=isset($_POST["apellidos"]) ? limpiarCadena1($_POST["apellidos"]) : "";
$identidad=isset($_POST["identidad"]) ? limpiarCadena1($_POST["identidad"]) : "";
$nacionalidad=isset($_POST["nacionalidad"]) ? limpiarCadena1($_POST["nacionalidad"]) : "";
$fecha_nacimiento=isset($_POST["fecha_nacimiento"]) ? limpiarCadena1($_POST["fecha_nacimiento"]) : "";
$estado=isset($_POST["estado"]) ? limpiarCadena1($_POST["estado"]) : "";
$sexo=isset($_POST["sexo"]) ? limpiarCadena1($_POST["sexo"]) : "";
$trabajo=isset($_POST["trabajo"]) ? limpiarCadena1($_POST["trabajo"]) : "";
$ncuenta=isset($_POST["ncuenta"]) ? limpiarCadena1($_POST["ncuenta"]) : "";
$tipo_estudiante=isset($_POST["tipo_estudiante"]) ? limpiarCadena1($_POST["tipo_estudiante"]) : "";
$idcarrera=isset($_POST["idcarrera"]) ? limpiarCadena1($_POST["idcarrera"]) : "";
$idcr=isset($_POST["idcr"]) ? limpiarCadena1($_POST["idcr"]) : "";



$instancia_modelo = new modelo_registro_estudiantes();




switch ($_GET["op"]){
    
       case 'selectGEN':
        if (isset($_POST['activar'])) {
            $data=array();
            $respuesta=$instancia_modelo->listar_selectGEN();
           
              while ($r=$respuesta->fetch_object()) {
           
                 
                   # code...
                   echo "<option value='". $r->genero."'> ".$r->genero." </option>";
                   
               }
           
            
             }
             else{
               echo 'No hay informacion';
             }
           
    break;
      

    case 'selectEST':
      if (isset($_POST['activar'])) {
          $data=array();
          $respuesta=$instancia_modelo->listar_selectEST();
         
            while ($r=$respuesta->fetch_object()) {
         
               
                 # code...
                 echo "<option value='". $r->estado_civil."'> ".$r->estado_civil." </option>";
                 
             }
         
          
           }
           else{
             echo 'No hay informacion';
           }
         
  break;
  
  case 'selectNAC':
    if (isset($_POST['activar'])) {
        $data=array();
        $respuesta=$instancia_modelo->listar_selectNAC();
       
          while ($r=$respuesta->fetch_object()) {
       
             
               # code...
               echo "<option value='". $r->nacionalidad."'> ".$r->nacionalidad." </option>";
               
           }
       
        
         }
         else{
           echo 'No hay informacion';
         }
       
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
         echo 'No hay informacion';
       }
     
break;

case 'ExisteIdentidad':
  $respuesta=$instancia_modelo->ExisteIdentidad($identidad);
  echo json_encode($respuesta);
  
break;

case 'ExisteNCuenta':
  $respuesta=$instancia_modelo->ExisteNCuenta($ncuenta);
  echo json_encode($respuesta);  
break;

case 'registrar':
      $respuesta=$instancia_modelo->registrar($nombre,$apellidos, $sexo, $identidad, $nacionalidad, $estado, $fecha_nacimiento, 
      $trabajo, $ncuenta, $idcarrera, $idcr, $tipo_estudiante);
break;

case 'mayoria_edad':
  $rspta = $instancia_modelo->mayoria_edad();
  //Codificar el resultado utilizando json
  echo json_encode($rspta);
  break;

case 'validar_depto':
  $respuesta = $instancia_modelo->validardepto($codigo);
  echo json_encode($respuesta);

  break;

}
