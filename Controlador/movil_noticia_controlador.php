<?php
if(!isset($_SESSION)){ 
    session_start();
}
ob_start();
require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora_movil.php');
require_once("../Modelos/movil_noticia_modelo.php");
require_once("../Controlador/movil_api_controlador.php");
//id_objeto vista noticias
$Id_objeto = 168;
if (isset($_GET['op'])) {
    $datos = [];
    switch ($_GET['op']) {
    
        case 'insert':
            $modelo = new modelo_registro_noticia();
            $titulo = isset($_POST['titulo']) ? ucfirst($_POST['titulo']) : '';
            $subtitulo = isset($_POST['subtitulo']) ? ucfirst($_POST['subtitulo']) : '';
            $contenido = isset($_POST['Contenido']) ? mysqli_real_escape_string($mysqli,$_POST['Contenido']) : '';
            $segmento = isset($_POST['Segmentos']) ? $_POST['Segmentos'] : '';
            $fecha_publicacion = date('Y-m-d H:i:s',strtotime($_POST['txt_fecha_Publicacion']));
            $fecha_vencimiento= date('Y-m-d H:i:s',strtotime($_POST['txt_fecha_vencimiento']));
            $sql = "INSERT into tbl_movil_noticias (titulo,subtitulo,descripcion,fecha,fecha_vencimiento,remitente,segmento_id) VALUES ('$titulo','$subtitulo','$contenido','$fecha_publicacion','$fecha_vencimiento','ADMIN',$segmento)";
            $resultado = $mysqli->query($sql);
            bitacora_movil::evento_bitacora($_SESSION['id_usuario'],$Id_objeto,'INSERTO',strtoupper("$sql"));   
            if($resultado === TRUE){
                   $idNoticia = $modelo->buscar_id_noticia($titulo,$fecha_publicacion);
                   $i = 0;
                   foreach ($_FILES['txt_documentos'] as $item){
                        $idRecurso = subirDocumentos($i);
                        $modelo->insert_noticia_recurso((int)$idNoticia['id'],(int)$idRecurso['id']); 
                       $i += 1;
                   }
                    
                    header('location: ../vistas/movil_gestion_noticia_vista.php?msj=2');
                
                }
              break;
            
        case 'editar':
            $modelo = new modelo_registro_noticia();
            $id = $_GET['id'];
            $titulo = isset($_POST['titulo']) ? ucfirst(mysqli_real_escape_string($mysqli,$_POST['titulo'])) : '';
            $subtitulo = isset($_POST['subtitulo']) ? ucfirst(mysqli_real_escape_string($mysqli,$_POST['subtitulo'])) : '';
            $contenido = isset($_POST['Contenido']) ? ucfirst(mysqli_real_escape_string($mysqli,$_POST['Contenido'])) : '';
            $segmento = $_POST['Segmentos'];
            $fecha_publicacion = date('Y-m-d H:i:s',strtotime($_POST['txt_fecha_Publicacion']));
            $fecha_vencimiento = date('Y-m-d H:i:s',strtotime($_POST['txt_fecha_vencimiento']));
            $sql = "UPDATE tbl_movil_noticias SET titulo = '$titulo', subtitulo = '$subtitulo', descripcion = '$contenido', fecha = '$fecha_publicacion',fecha_vencimiento = '$fecha_vencimiento', remitente = 'ADMIN', segmento_id = $segmento where id = $id";
            
            $resultado = $mysqli->query($sql);
            bitacora_movil::evento_bitacora($_SESSION['id_usuario'],$Id_objeto,'MODIFICO',strtoupper("$sql"));
            if($resultado === TRUE){
                    $i = 0;
                    foreach ($_FILES['txt_documentos'] as $item){
                        
                         $idRecurso = subirDocumentos($i);
                        
                         $modelo->insert_noticia_recurso((int)$id,(int)$idRecurso['id']); 
                        $i += 1;
                    }
                   
                    header('location: ../vistas/movil_gestion_noticia_vista.php?msj=2'); 
                }
            break;
        
    }
    
    
}


if (isset($_POST['funcion'])) {
    if ($_POST['funcion']=='eliminar') {
        $id = (int)$_POST['id'];
                //se ejecuta el sql respectivo
                $sql = "DELETE FROM tbl_movil_noticias where id = $id";
                $resultado = $mysqli->query($sql);
                bitacora_movil::evento_bitacora($_SESSION['id_usuario'],$Id_objeto,'ELIMINO',strtoupper("$sql"));
                if ($resultado) {
                    echo 'hola mundo';
                }else{
                    echo '';
                }
    }
}


function subirDocumentos($i){
    
    $MP = new modelo_registro_noticia();
    $tmp_name = $_FILES['txt_documentos']['tmp_name']["$i"];
    $name = $_FILES['txt_documentos']['name']["$i"];
    if(is_array($_FILES) && count($_FILES)>0){
        if(move_uploaded_file($tmp_name,"../archivos/movil/".$name)){
          $ext_url = 'http://desarrollo.informaticaunah.com';
          $nombrearchivo= '/archivos/movil/'.$name;
          $MP->Registrar_foto($ext_url.$nombrearchivo);  
          $idRecurso = $MP->buscar_id_recurso($ext_url.$nombrearchivo);
          return $idRecurso;
        }else{
            echo 0;
        }
    }else{
        echo 0;
    }
}

ob_end_flush();
?>