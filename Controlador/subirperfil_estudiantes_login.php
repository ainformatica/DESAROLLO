<?php
require_once "../Modelos/reg_estudiantes_login_modelo.php";
ob_start();
session_start();

$MP = new modelo_reg_estudiantes2();

$id_persona2= $_SESSION['id_persona'];

if(is_array($_FILES) && count($_FILES)>0){

    if(move_uploaded_file($_FILES["f"]["tmp_name"],"../Imagenes_Perfil_Estudiantes/".$_FILES["f"]["name"])){
      $nombrearchivo= '../Imagenes_Perfil_Estudiantes/'.$_FILES["f"]["name"];
      $consulta=$MP-> Registrar_foto($id_persona2, $nombrearchivo);  
      echo $consulta;
    }else{
        echo 0;
    }

}else{
    echo 0;
}

?>