<?php
require_once "../Modelos/personas_modelo.php";
$MP = new personas();

//$nombrearchivo2 = isset($_POST["nombrearchivo2"]) ? limpiarCadena1($_POST["nombrearchivo2"]) : "";

if(is_array($_FILES) && count($_FILES)>0){

    if(move_uploaded_file($_FILES["f"]["tmp_name"],"../Imagenes_Perfil_Docente/".$_FILES["f"]["name"])){
      $nombrearchivo2= '../Imagenes_Perfil_Docente/'.$_FILES["f"]["name"];
      $consulta=$MP-> Registrar_foto($nombrearchivo2);  
      echo 1;
    }else{
        echo 0;
    }

}else{
    echo 0;
}
