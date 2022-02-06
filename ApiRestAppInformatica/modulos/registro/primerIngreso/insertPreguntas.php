<?php
    session_start();
    ob_start();   

    require_once "../../../bd/conexion.php";  
    require_once "../../response/httpResponseCode.php";
    require_once "../../../clases/registroClases/primerIngresoClases/insertPreguntasClase.php";

    $conexion = new Conexion();  
    $httpResponseCode = new httpResponseCode();
    $preguntas = new ApiRestInsertQuestions();


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
                    $respuestaApi = $preguntas->insertQuestions($datosJson);
                    
                    if(isset($respuestaApi['correcto']))
                    {
                        //Se inserto correctamente
                        http_response_code(200);
                        $mensaje = "Se inserto correctamente";
                        echo json_encode($httpResponseCode->ok($mensaje));

                    }
                    elseif($respuestaApi === false)
                    {
                        //Error al insertar en la base datos
                        http_response_code(500);
                        $mensaje = "Error al insertar en la base de datos";
                        echo json_encode($httpResponseCode->internalServerError($mensaje));
                    }
                    elseif(isset($respuestaApi['idUsuario']))
                    {
                        //Error al insertar en la base datos
                        http_response_code(401);
                        $mensaje = "Algún campo del usuario enviado no es correcto o usted ya no ingresa por primera vez";
                        echo json_encode($httpResponseCode->unauthorized($mensaje));
                    }
                    elseif(isset($respuestaApi['p_intentos']))
                    {
                        //Intento registrar varias veces preguntas con datos de usuario incorrectos
                        http_response_code(401);
                        $mensaje = "Su usuario fue bloqueado por intentar registrar varias veces preguntas con datos de usuario incorrectos";
                        echo json_encode($httpResponseCode->unauthorized($mensaje));
                    }
                    elseif(isset($respuestaApi['countPreguntas']))
                    {
                        //Cantidad de preguntas ya fueron ingresadas
                        http_response_code(401);
                        $mensaje = "La cantidad máxima de preguntas ya fueron ingresadas";
                        echo json_encode($httpResponseCode->unauthorized($mensaje));
                    }
                    elseif(isset($respuestaApi['p_id_pregunta']))
                    {
                        //La cantidad de preguntas ya fueron ingresadas
                        http_response_code(401);
                        $mensaje = "La pregunta ya fue ingresada una vez, cambie de pregunta y respuesta";
                        echo json_encode($httpResponseCode->unauthorized($mensaje));
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

     
    ob_end_flush();