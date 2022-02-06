<?php

    require_once "../../bd/conexion.php";  
    require_once "../response/httpResponseCode.php";
    require_once "../../clases/chatClases/insertSessionClase.php";

    $conexion = new Conexion();  
    $httpResponseCode = new httpResponseCode();
    $insertSession = new ApiRestInsertSession();


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
                    $respuestaApi = $insertSession->insertSession($datosJson);
                    
                    if(isset($respuestaApi['idSession']))
                    {
                        //Se inserto correctamente o ya habia una sesion
                        http_response_code(200);           
                        echo json_encode($respuestaApi);

                    }elseif($respuestaApi === false)
                    {
                        //Error al insertar en la base datos
                        http_response_code(500);
                        $mensaje = "Error al insertar en la base de datos";
                        echo json_encode($httpResponseCode->internalServerError($mensaje));
                    }
                    else
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