<?php
    session_start();
    ob_start();   

    require_once "../../bd/conexion.php";  
    require_once "../response/httpResponseCode.php";
    require_once "../../clases/loginClases/enviarCodigoClase.php";

    $conexion = new Conexion();  
    $httpResponseCode = new httpResponseCode();
    $send = new ApiRestSendCode();


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

                    //Llamado de la funcion para validaciones
                    $respuestaApi = $send->sendCode($datosJson);
                    //echo $respuestaApi;
                    if($respuestaApi === true)
                    {                       
                        //Se loguio correctamente               
                        http_response_code(200);                        
                        $mensaje = "Se envio el código a su correo electrónico, por favor ingreselo en el campo del código";
                        echo json_encode($httpResponseCode->ok($mensaje));
                        
                    }elseif($respuestaApi === false)
                    {
                        //Algun error en la base datos
                        http_response_code(500);
                        $mensaje = "Error en el servidor, intentelo nuevamente";
                        echo json_encode($httpResponseCode->internalServerError($mensaje));

                    }elseif($respuestaApi == "send")
                    {
                        //Algun error en la base datos
                        http_response_code(500);
                        $mensaje = "Error al enviar el correo electrónico, intentelo nuevamente";
                        echo json_encode($httpResponseCode->internalServerError($mensaje));
                        
                    }
                    elseif($respuestaApi == "correo")
                    {
                         //Correo no existe en la base de datos
                        http_response_code(404);
                        $mensaje = "Correo electrónico incorrecto";
                        echo json_encode($httpResponseCode->notFound($mensaje));
                        
                    }else
                    {
                        //No se consulto bien la API
                        http_response_code(400);
                        $mensaje = "Error con las variables enviadas a la API REST";
                        echo json_encode($httpResponseCode->badRequest($mensaje));
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