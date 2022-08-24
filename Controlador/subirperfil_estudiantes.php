<?php
require_once "../Modelos/registro_estudiantes_modelo.php";
$MP = new modelo_registro_estudiantes();

if(is_array($_FILES) && count($_FILES)>0){

    if(move_uploaded_file($_FILES["f"]["tmp_name"],"../Imagenes_Perfil_Estudiantes/".$_FILES["f"]["name"])){
      $nombrearchivo2= '../Imagenes_Perfil_Estudiantes/'.$_FILES["f"]["name"];
      $consulta=$MP-> Registrar_foto($nombrearchivo2);  
      echo $consulta;
    }else{
        echo 0;
    }

}else{
    echo 0;
}

?>