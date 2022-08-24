<?php
require_once ('../clases/conexion_mantenimientos.php');

$instancia_conexion = new conexion();

class modelo_gestion_estudiante
{

     function listar(){
     global $instancia_conexion;
		$sql="call proc_gestion_estudiante()";
    $arreglo = array();
    if ($consulta = $instancia_conexion->ejecutarConsulta($sql)) {
      while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
        $arreglo["data"][] = $consulta_VU;
      }
      return $arreglo;
    }
    }

    
  function actualizarestado($Estado,$id_persona_)
  {
    global $instancia_conexion;
    $sql = "CALL proc_estado_usuario('$Estado', '$id_persona_');";
    
    if ($consulta = $instancia_conexion->ejecutarConsulta($sql)) {
      return 1;
    } else {
      return 0;
    }
    
  }

function listar_selectCR(){
    global $instancia_conexion;
    $consulta=$instancia_conexion->ejecutarConsulta('SELECT * FROM `tbl_centros_regionales`;');
    return $consulta;
}

function listar_selectCAR(){
  global $instancia_conexion;
  $consulta=$instancia_conexion->ejecutarConsulta('SELECT * FROM `tbl_carrera`;');
  return $consulta;
}


function listar_selectNACI(){
  global $instancia_conexion;
  $consulta=$instancia_conexion->ejecutarConsulta('select * from tbl_nacionalidad');
  return $consulta;
}

  function modificar_gestion_estudiante($identidad, $ncuenta, $carrera_, $cregional_, $egresado, $id_persona1)
  {

    global $instancia_conexion;
    $sql = "call proc_modificar_gestion_estudiantes('$identidad', '$ncuenta', '$carrera_','$cregional_','$egresado','$id_persona1')";
    if ($consulta = $instancia_conexion->ejecutarConsulta($sql)) {
      return 1;
    } else {
      return 0;
    }
  }

}

?>
