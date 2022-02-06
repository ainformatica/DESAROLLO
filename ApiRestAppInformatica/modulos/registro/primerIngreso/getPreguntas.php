<?php
    session_start();
    ob_start();   

    require_once "../../../bd/conexion.php";  
    require_once "../../response/httpResponseCode.php";
    require_once "../../../clases/registroClases/primerIngresoClases/getPreguntasClase.php";

    //Objetos
    $conexion = new Conexion();
    $question = new ApiRestQuestions();
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
            //Para obtener los datos que se envien por el POST
            $datosJson = file_get_contents("php://input");
            
            $respuestaApi = $question->getQuestions($datosJson);

            //print_r($respuestaApi);
            if(!is_string($respuestaApi))
            {   
                //Datos encontrados  
                http_response_code(200);           
                echo json_encode($respuestaApi);

            }elseif($respuestaApi === false)
            {  
                //No se encontraron datos
                http_response_code(404);
                $mensaje = "No se encontraron preguntas, intentelo nuevamente";
                echo json_encode($httpResponseCode->notFound($mensaje));

            }elseif($respuestaApi == "pregUsuario"){

                //No se encontraron datos
                http_response_code(404);
                $mensaje = "No se encontraron las preguntas del usuario, intentelo nuevamente";
                echo json_encode($httpResponseCode->notFound($mensaje));

            }elseif($respuestaApi == "completas"){

                //No se encontraron datos
                http_response_code(401);
                $mensaje = "Ya tiene todas las preguntas de seguridad registradas, Su usuario fue bloqueado, comuniquese con el administrador de la APP";
                echo json_encode($httpResponseCode->unauthorized($mensaje));

            }elseif($respuestaApi == "usuario"){

                //No se encontraron datos
                http_response_code(401);
                $mensaje = "Algún campo del usuario enviado no es correcto o su estado ya no es de primer ingreso";
                echo json_encode($httpResponseCode->unauthorized($mensaje));
            }
            elseif($respuestaApi == "var"){

                //No se encontraron datos
                http_response_code(404);
                $mensaje = "Error con las variables enviadas a la Api";
                echo json_encode($httpResponseCode->badRequest($mensaje));
            }
            else
            {
                //Error del servidor
                http_response_code(500);
                $mensaje = "Ocurrio algún error en el servidor: ".$respuestaApi;
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