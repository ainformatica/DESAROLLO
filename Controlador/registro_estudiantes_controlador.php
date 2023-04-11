<?php
require_once "../Modelos/registro_estudiantes_modelo.php";
require_once('../clases/encriptar_desencriptar.php');
require_once('../Controlador/import_registro_estudiantes_controlador2.php');

$nombre=isset($_POST["nombre"]) ? limpiarCadena1($_POST["nombre"]) : "";
$apellidos=isset($_POST["apellidos"]) ? limpiarCadena1($_POST["apellidos"]) : "";
$sexo=isset($_POST["sexo"]) ? limpiarCadena1($_POST["sexo"]) : "";
$identidad=isset($_POST["identidad"]) ? limpiarCadena1($_POST["identidad"]) : "";
$nacionalidad=isset($_POST["nacionalidad"]) ? limpiarCadena1($_POST["nacionalidad"]) : "";
$estado=isset($_POST["estado"]) ? limpiarCadena1($_POST["estado"]) : "";
$fecha_nacimiento=isset($_POST["fecha_nacimiento"]) ? limpiarCadena1($_POST["fecha_nacimiento"]) : "";
$lugar_nacimiento=isset($_POST["lugar_nacimiento"]) ? limpiarCadena1($_POST["lugar_nacimiento"]) : "";
$ncuenta=isset($_POST["ncuenta"]) ? limpiarCadena1($_POST["ncuenta"]) : "";
$tipo_estudiante=isset($_POST["tipo_estudiante"]) ? limpiarCadena1($_POST["tipo_estudiante"]) : "";
$trabajo=isset($_POST["trabajo"]) ? limpiarCadena1($_POST["trabajo"]) : "";
$idcarrera=isset($_POST["idcarrera"]) ? limpiarCadena1($_POST["idcarrera"]) : "";
$idcr=isset($_POST["idcr"]) ? limpiarCadena1($_POST["idcr"]) : "";
$usuario=isset($_POST["usuario"]) ? limpiarCadena1($_POST["usuario"]) : "";
$contrasena=isset($_POST["contrasena"]) ? limpiarCadena1($_POST["contrasena"]) : "";
$telefono=isset($_POST["telefono"]) ? limpiarCadena1($_POST["telefono"]) : "";
$correo=isset($_POST["correo"]) ? limpiarCadena1($_POST["correo"]) : "";

$num_user = token_u(4);
$letra = substr($nombre, 0, 1);//Tomar la primera letra del string
$palabra = explode(" ", $apellidos);//Tomar la primera palabra de todo el string usando el indice[0]
$usuario2 = $letra . $palabra[0] . $num_user;//Concatenación de la primera letra del nombre, primer apellido para crear el usuario y número para que haga único al usuario
$usuario = strtoupper($usuario2);//Convertir el nombre de usuario en mayuscula

$contrasena2 = gtoken(8);

$instancia_modelo = new modelo_registro_estudiantes();

switch ($_GET["op"]){


  case 'registrar':
    print_r($_POST);

    $contrasena = cifrado::encryption($contrasena2);
    $respuesta = $instancia_modelo->registrar($nombre, $apellidos, $sexo, $identidad, $nacionalidad, $estado, $fecha_nacimiento, $lugar_nacimiento, $ncuenta, $tipo_estudiante, $trabajo, $idcarrera, $idcr, $usuario,$contrasena,$telefono, $correo);
    if ($respuesta) {
      enviar_mail($correo, $usuario, $contrasena2);      
    }
    break;

  case 'selectGEN':
    if (isset($_POST['activar'])) {
      $data = array();
      $respuesta = $instancia_modelo->listar_selectGEN();

      while ($r = $respuesta->fetch_object()) {


        # code...
        echo "<option value='" . $r->genero . "'> " . $r->genero . " </option>";
      }
    } else {
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
 /* 
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
       
break;*/

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
