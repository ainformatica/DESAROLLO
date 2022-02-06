<?php
    session_start();
    ob_start();   

    require_once "../../bd/conexion.php";  
    require_once "../response/httpResponseCode.php";
    require_once "../../clases/loginClases/validarLogueoClase.php";

    $conexion = new Conexion();  
    $httpResponseCode = new httpResponseCode();
    $login = new ApiRestValidLogin();


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
                    $respuestaApi = $login->validLogin($datosJson);
                    //print_r($respuestaApi);
                    if(isset($respuestaApi['nombre']))
                    {                       
                        //Se loguio correctamente               
                        http_response_code(200);                        
                        echo json_encode($respuestaApi);
                        
                    }elseif(isset($respuestaApi['acceso']))
                    {
                        //El usuario no tiene el mismo token asociado
                        http_response_code(401);
                        $mensaje = "Inicie sesión nuevamente";
                        echo json_encode($httpResponseCode->unauthorized($mensaje));
                        
                    }elseif(isset($respuestaApi['idUsuario']))
                    {
                        //El usuario no existe
                        http_response_code(403);
                        $mensaje = "Usuario incorrecto";
                        echo json_encode($httpResponseCode->forbidden($mensaje));

                    }elseif(isset($respuestaApi['p_estado']))
                    {
                        //El usuario esta desactivado
                        http_response_code(403);
                        $mensaje = "Usuario desactivado, comuniquese con el administrador de la app";
                        echo json_encode($httpResponseCode->forbidden($mensaje));
                    
                    }elseif(isset($respuestaApi['fechaVence']))
                    {
                        //La contrasena esta vencida
                        http_response_code(401);
                        $mensaje = "Contraseña vencida, por favor resetee su contraseña";
                        echo json_encode($httpResponseCode->unauthorized($mensaje)); 
                        
                    }elseif(isset($respuestaApi['tokenActivo']))
                    {
                        //Token desactivado
                        http_response_code(401);
                        $mensaje = "Este dispositivo esta desactivado, comuniquese con el administrador de la app";
                        echo json_encode($httpResponseCode->unauthorized($mensaje));
                        
                    }elseif($respuestaApi === false)
                    {
                        //Algun error en la base datos
                        http_response_code(500);
                        $mensaje = "Error al autenticarse, autentiquese nuevamente";
                        echo json_encode($httpResponseCode->internalServerError($mensaje));
                    }
                    elseif($respuestaApi === "null")
                    {
                        //Problemas con los datos del usuario en la base de datos
                        http_response_code(401);
                        $mensaje = "Problemas con sus datos de usuario, comuniquese con el administrador de la app";
                        echo json_encode($httpResponseCode->unauthorized($mensaje)); 
                        
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