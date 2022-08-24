<?php
require_once "../Modelos/registro_estudiantes_modelo.php";
$MP = new modelo_registro_estudiantes();

if(is_array($_FILES) && count($_FILES)>0){

    if(move_uploaded_file($_FILES["c"]["tmp_name"],"../curriculum_estudiantes/".$_FILES["c"]["name"])){
      $nombrearchivo2= '../curriculum_estudiantes/'.$_FILES["c"]["name"];
      echo $nombrearchivo2;
          $consulta=$MP-> Registrar_curriculum($nombrearchivo2);  
          echo $consulta;
    }else{
        echo 0;
    }

}else{
    echo 0;
}

?>