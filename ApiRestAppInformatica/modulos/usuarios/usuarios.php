<?php

    require_once "../../bd/conexion.php";  
    require_once "../response/httpResponseCode.php";
    require_once "../../clases/usuariosClase/usuariosClase.php";

    //Objetos
    $conexion = new Conexion();
    $user = new ApiUsers();
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
            if(isset($_GET['token']))
            {
                /*if($_GET['usuario'] == null || $_GET['usuario'] == "")
                {
                    $usuario = "";
                }else
                {
                    $usuario = $_GET['usuario'];
                }*/
                
                $respuestaApi = $user->getUsers($_GET['token']);

                if($respuestaApi != false)
                {   
                    //Datos encontrados  
                    http_response_code(200);           
                    echo $respuestaApi;

                }else
                {  
                    //No se encontraron datos
                    http_response_code(404);                    
                    $mensaje = "No se encontraron usuarios";
                    echo json_encode($httpResponseCode->notFound($mensaje));
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