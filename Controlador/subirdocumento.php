<?php
require_once "../Modelos/registro_docente_modelo.php";
$MP = new modelo_registro_docentes();
//$nombrearchivo2 = isset($_POST["nombrearchivo2"]) ? limpiarCadena1($_POST["nombrearchivo2"]) : "";

if(is_array($_FILES) && count($_FILES)>0){

    if(move_uploaded_file($_FILES["c"]["tmp_name"],"../curriculum_docentes/".$_FILES["c"]["name"])){
      $nombrearchivo2= '../curriculum_docentes/'.$_FILES["c"]["name"];
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