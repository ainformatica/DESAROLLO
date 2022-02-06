<?php
    session_start();
    ob_start();   

    require_once "../../../bd/conexion.php";  
    require_once "../../response/httpResponseCode.php";
    require_once "../../../clases/registroClases/validacionesClases/validIdentidadClase.php";

    //Objetos
    $conexion = new Conexion();
    $valid = new ApiRestValidId();
    $httpResponseCode = new httpResponseCode();

    if($conexion->conexion_bd() == null)
    {        
        //Error en los datos para la conexion con la base de datos        
        http_response_code(500);
        $mensaje = "la API No se pudo conectar con la base de datos";
        echo json_encode($httpResponseCode->internalServerError($mensaje));

    }elseif(isset($_SERVER['REQUEST_METHOD']))
    {
        if($_SERVER['REQUEST_METHOD'] == 'GET')
        {    
            if(isset($_GET['identidad']))
            {
                if($_GET['identidad'] != null)
                {
                    $respuestaApi = $valid->validId($_GET['identidad']);

                    if($respuestaApi != false)
                    {                           
                        //Datos encontrados            
                        http_response_code(200);           
                        $mensaje = "La identidad ya existe";
                        echo json_encode($httpResponseCode->ok($mensaje));

                    }else
                    {  
                        //No se encontraron datos
                        http_response_code(404);
                        $mensaje = "La identidad no existe";
                        echo json_encode($httpResponseCode->notFound($mensaje));
                    }
                }else
                {
                    //No se consulto bien la API
                    http_response_code(400);
                    $mensaje = "Se necesita la identidad";
                    echo json_encode($httpResponseCode->badRequest($mensaje));
                }
            }else
            {
                //No se consulto bien la API
                http_response_code(400);
                $mensaje = "No es lo que la API esperaba por variable";
                echo json_encode($httpResponseCode->badRequest($mensaje));
            }           
        }else
        {
            //No se consulto bien la API
            http_response_code(400);
            $mensaje = "Solo funciona por el metodo GET";
            echo json_encode($httpResponseCode->badRequest($mensaje));
        }
    }else
    {
        //No se consulto bien la API
        http_response_code(400);
        $mensaje = "Utilice el metodo GET";
        echo json_encode($httpResponseCode->badRequest($mensaje));
    }

    ob_end_flush();