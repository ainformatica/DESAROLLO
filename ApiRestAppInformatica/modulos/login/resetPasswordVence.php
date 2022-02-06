<?php
    session_start();
    ob_start();  

    require_once "../../bd/conexion.php";  
    require_once "../response/httpResponseCode.php";
    require_once "../../clases/loginClases/resetPasswordVenceClase.php";

    $conexion = new Conexion();   
    $consulta = new Consultas(); 
    $httpResponseCode = new httpResponseCode();
    $reset = new ApiRestResetPasswordVence();


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
                    //Para obtener los datos que se envien por el PUT
                    $datosJson = file_get_contents("php://input");

                    //Llamado de la funcion para actualizar y validaciones
                    $respuestaApi = $reset->resetPasswordVence($datosJson);

                    switch ($respuestaApi) 
                    {
                        case "ok":
                            //Se actualizo correctamente
                            http_response_code(200);
                            $mensaje = "Se actualizo correctamente";
                            echo json_encode($httpResponseCode->ok($mensaje));
                            break;
                        case "user":
                            //Credenciales incorrectas
                            http_response_code(401);
                            $mensaje = "Datos incorrectos, revise sus datos";
                            echo json_encode($httpResponseCode->unauthorized($mensaje));
                            break;
                        case "vencido":
                            //Contraseña no esta vencida
                            http_response_code(401);
                            $mensaje = "La contraseña no esta vencida, no se cambio la contraseña";
                            echo json_encode($httpResponseCode->unauthorized($mensaje));
                            break;
                        case "bd":
                            //Error al actualizar en la base datos
                            http_response_code(500);
                            $mensaje = "Error al actualizar en la base de datos";
                            echo json_encode($httpResponseCode->internalServerError($mensaje));
                            break;
                        case "var":
                            http_response_code(400);
                            $mensaje = "Error con las variables enviadas a la API REST";
                            echo json_encode($httpResponseCode->badRequest($mensaje));
                            break;                    
                        default:
                            http_response_code(500);
                            $mensaje = "Error del servidor: ".$respuestaApi;
                            echo json_encode($httpResponseCode->internalServerError($mensaje));
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