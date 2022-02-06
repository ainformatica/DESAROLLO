<?php
session_start();
require_once "../Modelos/objetos_modelo.php";
require_once ('../clases/funcion_bitacora.php'); 

$modulo = isset($_POST["modulo"]) ? limpiarCadena1($_POST["modulo"]) : "";
$id_modulo = isset($_POST["id_modulo"]) ? limpiarCadena1($_POST["id_modulo"]) : "";
$descripcion = isset($_POST["descripcion"]) ? limpiarCadena1($_POST["descripcion"]) : "";
$id_objeto1=285;//registrar objetos
$id_objeto2=286;//gestion objetos


$instancia_modelo=new objetos();

switch ($_GET["op"])
{
  

  case"listar":
   
      $rspta = $instancia_modelo->listar_modulos(); //instancia a la funcion listar

      //  
      //Vamos a declarar un array
      $data = array();
     while ($reg = $rspta->fetch_object()) {
        $boton_modificar=' <td style="text-align: center;"><a id="'.$reg->id_modulo.'" class="btn btn-primary btn-raised btn-xs modificar_modulo" onclick="modificar(this)" data-toggle="modal" data-target="#modal_modificar_modulo"><i class="far fa-edit" style=""></i></a></td>';
        $boton_eliminar='<td style="text-align: center;"><button type="button" id="'.$reg->id_modulo.'" class="btn btn-danger btn-raised btn-xs eliminar_modulo" onclick="eliminar(this)"><i class="far fa-trash-alt" style=""></i></button><div class="RespuestaAjax"></div></td>';
        $data[] = array(

          "0" => $reg->nombre,
          "1" => $reg->descripcion,
          "2" => $boton_modificar,
        
        );
      }
      $results = array(
        "sEcho" => 1, //Información para el datatables
        "iTotalRecords" => count($data), //enviamos el total registros al datatable
        "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
        "aaData" => $data
      );
      echo json_encode($results);

      break;
  
  case 'registrar_modulo':
  
    $rspta= $instancia_modelo->registrar_modulo($modulo,$descripcion);
    if ($rspta) {
      # code...
      bitacora::evento_bitacora($id_objeto1, $_SESSION['id_usuario'],'INSERTO' , 'EL MODULO '.$modulo.'');
     echo 1;
    }else{
      echo 0;
    }
   
    break;
   
  case 'actualizar_modulo':
      $rspta= $instancia_modelo->actualizar_modulo($id_modulo,$modulo,$descripcion);
     
        if ($rspta) {
          # code...
        echo 1;
        }else{
          echo 0;
        }

    break;
  case 'mostrar':
    # code...
    $rspta=$instancia_modelo->mostrar_modulo($id_modulo);
   
    echo json_encode($rspta);
    break;
  
  case 'desactivar':
   break;
  
  
  case 'listar_modulos':
    if (isset($_POST['activar'])) {
      $data=array();
      
      
      $respuesta=$instancia_modelo->listar_select_modulos();
    
        while ($r=$respuesta->fetch_object()) {
            
            echo '<div class="card card-default collapsed-card " ><div class="card-header"><h3 class="card-title">'.$r->nombre.'</h3>&nbsp;  &nbsp;  &nbsp;  &nbsp;  <input type="checkbox" estado="0" onclick="checked_input(this,'.$r->id_modulo.');" class="principal-input" name="" id="modulo_input'.$r->id_modulo.'" ><div class="card-tools" ><button type="button" name[]="" id="34" class="btn btn-tool obj-listar" data-card-widget="collapse"><i class="fas fa-plus"></i></button></div></div><!-- /.card-header --><div class="card-body" style="position: relative; display: none;" id="bodycard'.$r->id_modulo.'"><div id="'.$r->id_modulo.'" class="modulo-div"></div></div></div>';
         
        }

         
       }
       else{
         echo 'No hay informacion';
       }

    break;
  case 'listar_objetos_modulo':
      $respuesta=$instancia_modelo->listar_objeto_modulos();
      echo json_encode($respuesta->fetch_all());
      
         
  
  
      break;
  
  




 }




?>