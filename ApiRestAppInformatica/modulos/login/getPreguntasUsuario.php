<?php
    session_start();
    ob_start();   

    require_once "../../bd/conexion.php";  
    require_once "../response/httpResponseCode.php";
    require_once "../../clases/loginClases/getPreguntasUsuarioClase.php";

    //Objetos
    $conexion = new Conexion();
    $question = new ApiRestQuestionsUser();
    $httpResponseCode = new httpResponseCode();

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
            $datosJson = file_get_contents("php://input");

            $respuestaApi = $question->getQuestionsUser($datosJson);
            
            if(!is_string($respuestaApi))
            {   
                //Datos encontrados  
                http_response_code(200);           
                echo json_encode($respuestaApi);

            }else if($respuestaApi == "vacio")
            {
                //No se encontraron datos
                http_response_code(404);
                $mensaje = "No se encontraron preguntas para su usuario";
                echo json_encode($httpResponseCode->notFound($mensaje));
                
            }
            else if($respuestaApi == "user")
            {  
                //Usuario incorrecto
                http_response_code(401);
                $mensaje = "El usuario es incorrecto";
                echo json_encode($httpResponseCode->unauthorized($mensaje));
            } 
            else if($respuestaApi == "var")
            {  
                //No se consulto bien la API
                http_response_code(400);
                $mensaje = "No es lo que la API esperaba por variables";
                echo json_encode($httpResponseCode->badRequest($mensaje));
            }  
            else
            {
                http_response_code(500);
                $mensaje = "Error del servidor: ".$respuestaApi;
                echo json_encode($httpResponseCode->internalServerError($mensaje));
            }              
        }else
        {
            //No se consulto bien la API
            http_response_code(400);
            $mensaje = "Solo funciona por el metodo POST";
            echo json_encode($httpResponseCode->badRequest($mensaje));
        }
    }else
    {
        //No se consulto bien la API
        http_response_code(400);
        $mensaje = "Utilice el metodo POST";
        echo json_encode($httpResponseCode->badRequest($mensaje));
    }

    ob_end_flush();