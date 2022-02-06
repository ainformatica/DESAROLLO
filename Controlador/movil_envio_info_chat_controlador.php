<?php 
if(!isset($_SESSION)){ 
    session_start();
}
ob_start();
require_once('../clases/Conexion.php');

if (isset($_POST)) {
    if($_POST['funcion']=='enviarINFO'){
     enviarDatos();
    }    
}

function enviarDatos(){
    global $mysqli;
    require_once('../Controlador/movil_api_controlador.php');
    require_once('../Controlador/movil_transacciones_controlador.php');
    require_once('../clases/funcion_bitacora_movil.php');
    require_once('../Controlador/movil_helpers_controlador.php');
    $datos = array();
    $url_notificacion_chat = parametrizacion('EnvioNotificacionChat');
    $url = base_url.$url_notificacion_chat;
    $id_chat= isset($_POST['id_chat']) ? $_POST['id_chat'] : '';; 
    $message= isset($_POST['message']) ? $_POST['message'] : '';;
    
    $sql = "INSERT INTO `tbl_movil_mensajes_chat` VALUES (NULL, $id_chat, 1, '$message', 0, 1, sysdate())";
    $resultado = $mysqli->query($sql);
    $sql_user2 = "SELECT u.Usuario as receptor from tbl_movil_session_chats sc inner join tbl_usuarios u on sc.id_usuario2=u.Id_usuario where sc.id_session_chat = $id_chat";
    $resultado2 = $mysqli->query($sql_user2);
    $row = $resultado2->fetch_assoc();
    $usuarioReceptor = $row['receptor'];
    $datos = array("usuarioRemitente" => 'Informatica Administrativa',
                   "usuarioReceptor" => "$usuarioReceptor",
                   "mensaje" => $message,
                   "urlRecurso" => 'null');
        $response = consumoApi($url, $datos);
        $response2 = $response['mensaje'];
        if($response2 != 'Se envio la notificacion correctamente'){
        $resultado_transaccion = 'No Completada';
        }else{
        $resultado_transaccion = 'Completada';
        }
        transaccion('envio de notificaciones chat',"$response2","$resultado_transaccion",$mysqli);
            if($resultado == true){
                return 'enviado';
            }else{
                return 'no enviado';
            }
        }

ob_end_flush();
?>