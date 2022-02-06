<?php
    session_start();
    ob_start();  

    require_once "../../bd/conexion.php";  
    require_once "../response/httpResponseCode.php";
    require_once "../../clases/chatClases/envioNotificacionAdmonClase.php";

    $conexion = new Conexion();    
    $httpResponseCode = new httpResponseCode();
    $sendNotification = new ApiRestSendNotificationAdmon();


    if($conexion->conexion_bd() == null)
    {
        //Error en los datos para la conexion con la base de datos        
        http_response_code(500);
        $mensaje = "la API No se pudo conectar con la base de datos";
        echo json_encode($httpResponseCode->internalServerError($mensaje));

    }elseif(isset($_SERVER['REQUEST_METHOD']))
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            try {
                //Para obtener los datos que se envien por el POST
                $datosJson = file_get_contents("php://input");

                //Llamado de la funcion para insertar y validaciones
                $respuestaApi = $sendNotification->sendNotificationAdmon($datosJson);

                switch ($respuestaApi) 
                {
                    case "ok":
                        http_response_code(200);
                        $mensaje = "Se envio la notificacion correctamente";
                        echo json_encode($httpResponseCode->ok($mensaje));
                        break;
                    case "insert":
                        http_response_code(500);
                        $mensaje = "No se inserto la notificacion o transaccion";
                        echo json_encode($httpResponseCode->internalServerError($mensaje));
                        break;
                    case "nombre":
                        http_response_code(404);
                        $mensaje = "El usuario remitente no tiene un nombre y apellido asignado";
                        echo json_encode($httpResponseCode->notFound($mensaje));
                        break;
                    case "user":
                        http_response_code(404);
                        $mensaje = "El usuario receptor no tiene un token asignado";
                        echo json_encode($httpResponseCode->notFound($mensaje));
                        break;
                    case "var":
                        http_response_code(400);
                        $mensaje = "Error con las variables enviadas a la API REST";
                        echo json_encode($httpResponseCode->badRequest($mensaje));
                        break;                    
                    default:
                        //Algun error del servidor
                        http_response_code(500);
                        echo json_encode($httpResponseCode->internalServerError($respuestaApi));
                        break;
                }
            } catch(Exception $e) {
                http_response_code(500);
                $mensaje = "Error del servidor: ".$e->getMessage;
                echo json_encode($httpResponseCode->internalServerError($mensaje));
            }                    
        }else
        {
            //No se consulto bien la API
            http_response_code(400);
            $mensaje = "Solo se puede consultar por el metodo POST";
            echo json_encode($httpResponseCode->badRequest($mensaje));
        }
    }else
    {
        http_response_code(400);
        $mensaje = "Utilice el metodo POST";
        echo json_encode($httpResponseCode->badRequest($mensaje));
    }

    
    ob_end_flush();