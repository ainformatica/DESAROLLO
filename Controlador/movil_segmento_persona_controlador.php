<?php 
if(!isset($_SESSION)){ 
    session_start();
}
ob_start();
require_once('../clases/Conexion.php');


if (isset($_POST)) {
    switch ($_POST['funcion']) {
        case 'insertar':
            if(isset($_POST['Segmento']) and isset($_POST['persona'])){
                //almacenar los datos en variables 
                $id_segmento = (int)$_POST['Segmento'];
                $usuario = (int)$_POST['persona'];
                
                //se ejecuta el sql respectivo
                    $sql="CALL proc_insert_segmento_usuario($usuario,$id_segmento)";
                    $resultado = $mysqli->query($sql);
                    if ($resultado) {
                        echo 'hola mundo';
                    }else{
                        echo '';
                    }
            }
            break;

        case 'eliminar':
            if (isset($_POST['id_usuario'])) {
                //se almacena los datos en variable
                $id_usuario = (int)$_POST['id_usuario'];
                //se ejecuta el sql respectivo
                $sql = "DELETE FROM tbl_movil_segmento_usuario where usuario_id = $id_usuario";
                $resultado = $mysqli->query($sql);

                if ($resultado) {
                    echo 'hola mundo';
                }else{
                    echo '';
                }
            }
            break;
      
    }
}
ob_end_flush();

