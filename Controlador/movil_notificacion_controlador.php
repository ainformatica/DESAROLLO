<?php
if(!isset($_SESSION)){ 
    session_start();
}
ob_start();
require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora_movil.php');
require_once('../Controlador/movil_api_controlador.php');
require_once('../Controlador/movil_transacciones_controlador.php');
if (isset($_GET['op'])) {
$url_envio_notificacion = parametrizacion('Url_Notificacion');
$url =base_url.$url_envio_notificacion;
$datos = array();
//id_objeto vista notificaciones
$Id_objeto = 169;
switch ($_GET['op']) {
    case 'insert':
        $titulo = isset($_POST['titulo']) ? ucfirst($_POST['titulo']) : '';
        $contenido = isset($_POST['Contenido']) ? ucfirst($_POST['Contenido']) : '';
        $segmento = isset($_POST['Segmentos']) ? $_POST['Segmentos'] : '';
        $fecha_publicacion = date('Y-m-d H:i:s',strtotime($_POST['txt_fecha_Publicacion']));
        $notificacion = isset($_POST['notificacion']) ? $_POST['notificacion'] : 'notificacion';
        //buscar el id notificacion normal
        $sql_id_notificacion = "SELECT id FROM tbl_movil_tipo_notificaciones WHERE tipo_notificacion = '$notificacion'";
        $resul = $mysqli->query($sql_id_notificacion);
        $id_tipo_notificacion = $resul->fetch_assoc();
        $tipo_notificacion = (int)$id_tipo_notificacion['id'];
        //subir imagen de la notificacion 
        $image = subirImagen();
        $sql = "INSERT into tbl_movil_notificaciones  VALUES (null,'$titulo','$contenido','$fecha_publicacion','ADMIN',$segmento,$tipo_notificacion,'$image',1)";
        $resultado = $mysqli->query($sql);
        bitacora_movil::evento_bitacora($_SESSION['id_usuario'],$Id_objeto,'INSERTO',strtoupper("$sql"));
            if($resultado === TRUE){
                 //Llenado del arreglo
                $id_usuario = $_SESSION['id_usuario'];
                $sql = "SELECT Usuario,contrasena FROM tbl_usuarios WHERE Id_usuario = $id_usuario";
                $resultado = $mysqli->query($sql)->fetch_assoc();
                $usuario = $resultado['Usuario'];
                $password = $resultado['contrasena'];
                //traer el id de la notificacion insertada
                $sql_id = "SELECT id FROM tbl_movil_notificaciones WHERE fecha = '$fecha_publicacion'";
                $rspta = $mysqli->query($sql_id);
                $row = $rspta->fetch_assoc();
                $id_notificacion = (int)$row['id'];
                //arreglo de datos que se envia al api
                $datos = array("idLote" => $id_notificacion,
                                 "usuario" => $usuario,
                                 "password" => $password,
                                 "titulo" => $titulo,
                                 "contenido" => $contenido,
                                 "urlRecurso" => $image,
                                 "segmento" => $segmento);
                $response = consumoApi($url, $datos);
                $response2 = $response['mensaje'];
                if($response2 != 'Se enviaron las notificaciones correctamente'){
                    $resultado_transaccion = 'No Completada';
                }else{
                    $resultado_transaccion = 'Completada';
                }
                transaccion('envio de notificaciones',"$response2","$resultado_transaccion",$mysqli);  
                header('location: ../vistas/movil_gestion_notificaciones_vista.php?msj=2');
            }
        break;
        
    case 'editar':
        $id = $_GET['id'];
        $titulo = isset($_POST['titulo']) ? ucfirst($_POST['titulo']) : '';
        $contenido = isset($_POST['Contenido']) ? ucfirst($_POST['Contenido']) : '';
        $segmento = $_POST['Segmentos'];
        $tipo_notificacion = $_POST['tipo_notificacion'];
        $fecha_publicacion = date('Y-m-d H:i:s',strtotime($_POST['txt_fecha_Publicacion']));
        //comprobar que el campo image_url sea igual a null
        $sql_comprobacion = "SELECT count(image_url) as exist from tbl_movil_notificaciones WHERE id = 1 
        and NOT image_url = 'null'";
        $comprobacion = $mysqli->query($sql_comprobacion)->fetch_assoc();
        if ($comprobacion['exist'] < 1) {
            //se puede subir una imagen
            if (is_array($_FILES) && count($_FILES)>0) {
            //se quiere subir una imagen
            $image_url = subirImagen();
            $sql = "UPDATE tbl_movil_notificaciones SET titulo = '$titulo', descripcion = '$contenido', fecha = '$fecha_publicacion', remitente = 'ADMIN', segmento_id = $segmento, tipo_notificacion_id = $tipo_notificacion, image_url = '$image_url' where id = $id";
            }else{
                //no se quiere subir una imagen
                $sql = "UPDATE tbl_movil_notificaciones SET titulo = '$titulo', descripcion = '$contenido', fecha = '$fecha_publicacion', remitente = 'ADMIN', segmento_id = $segmento, tipo_notificacion_id = $tipo_notificacion, image_url = 'null' where id = $id";
            }
        } else{
            //no se puede subir imagen ya que ya existe una
            if (is_array($_FILES) && count($_FILES)>0) {
            //se quiere subir una imagen
            header("location: ../vistas/movil_gestion_notificaciones_vista.php?id=$id&msj=5");
            }else{
                //no se quiere subir una imagen
                $sql = "UPDATE tbl_movil_notificaciones SET titulo = '$titulo', descripcion = '$contenido', fecha = '$fecha_publicacion', remitente = 'ADMIN', segmento_id = $segmento, tipo_notificacion_id = $tipo_notificacion where id = $id";
            }
            
        }
        $resultado = $mysqli->query($sql);
        $id_usuario = $_SESSION['id_usuario'];
                $sql = "SELECT Usuario,contrasena FROM tbl_usuarios WHERE Id_usuario = $id_usuario";
                $resultado = $mysqli->query($sql)->fetch_assoc();
                $usuario = $resultado['Usuario'];
                $password = $resultado['contrasena'];
                   $datos = array("idLote" => $id,
                                 "usuario" => $usuario,
                                 "password" => $password,
                                 "titulo" => $titulo,
                                 "contenido" => $contenido,
                                 "urlRecurso" => $image_url,
                                 "segmento" => $segmento);
                $response = consumoApi($url, $datos);
                $response2 = $response['mensaje'];
                if($response2 != 'Se enviaron las notificaciones correctamente'){
                    $resultado_transaccion = 'No Completada';
                }else{
                    $resultado_transaccion = 'Completada';
                }
                transaccion('envio de notificaciones',"$response2","$resultado_transaccion",$mysqli);
        bitacora_movil::evento_bitacora($_SESSION['id_usuario'],$Id_objeto,'MODIFICO',strtoupper("$sql"));   
        if($resultado){
                header('location: ../vistas/movil_gestion_notificaciones_vista.php?msj=2');
            }
        break;
    
}
}

if (isset($_POST['funcion'])) {
    if ($_POST['funcion']=='eliminar') {
        $id = (int)$_POST['id'];
                //se ejecuta el sql respectivo
                $sql = "UPDATE tbl_movil_notificaciones set estado = 0 where id = $id";
                $resultado = $mysqli->query($sql);
                bitacora_movil::evento_bitacora($_SESSION['id_usuario'],$Id_objeto,'DESACTIVO',strtoupper("$sql"));
                if ($resultado) {
                    echo 'hola mundo';
                }else{
                    echo '';
                }
    }
}
if (isset($_POST['funcion'])) {
    if ($_POST['funcion']=='eliminar_imagen') {
        $id = (int)$_POST['id'];
                //se ejecuta el sql respectivo
                $sql = "UPDATE tbl_movil_notificaciones set image_url='null' where id = $id";
                $resultado = $mysqli->query($sql);
                if ($resultado) {
                    echo 'hola mundo';
                }else{
                    echo '';
                }
    }
}


function subirImagen(){
    $tmp_name = $_FILES['subir_archivo']['tmp_name'];
    $name = $_FILES['subir_archivo']['name'];
    if(is_array($_FILES) && count($_FILES) > 0){
        if(move_uploaded_file($tmp_name,"../archivos/movil/notificacion/".$name)){
          $nombrearchivo= '/archivos/movil/notificacion/'.$name;
          return base_url.$nombrearchivo;
        }else{
            echo 0;
        }
    }else{
        return $nombrearchivo = "NULL";
    }
}

ob_end_flush();