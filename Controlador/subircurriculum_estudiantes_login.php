<?php
require_once "../Modelos/reg_estudiantes_login_modelo.php";
ob_start();
session_start();

$MP = new modelo_reg_estudiantes2();

$id_persona2= $_SESSION['id_persona'];
//echo $id_persona2;

if(is_array($_FILES) && count($_FILES)>0){

    if(move_uploaded_file($_FILES["c"]["tmp_name"],"../curriculum_estudiantes/".$_FILES["c"]["name"])){
      $nombrearchivo2= '../curriculum_estudiantes/'.$_FILES["c"]["name"];
      echo $nombrearchivo2;
          $consulta=$MP-> Registrar_curriculum($id_persona2, $nombrearchivo2);  
          echo $consulta;
    }else{
        echo 0;
    }

}else{
    echo 0;
}

?>