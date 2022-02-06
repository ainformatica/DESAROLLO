<?php

    ob_start();   

    require_once "../../bd/consultas.php";

    //Clase para insertar o actualizar likes
    class ApiRestLikes
    {
        //Insertar y actualizar likes
        public function insertUpdateLikes($datosJson)
        {
            try {
                
                //Declarar variables
                $consulta = new Consultas();

                $datosArray = json_decode($datosJson, true);

                /* Estructura que se debe recibir
                    {
                        "token": "token del dispositivo",
                        "idNoticia": "id de la noticia a la que se le dio like"
                    }
                */

                //print_r($datosArray);
                if(isset($datosArray['token']) && isset($datosArray['idNoticia']))
                {
                    $respuesta = $consulta->insertUpdateLikes($datosArray['token'], $datosArray['idNoticia']);
                    
                    if($respuesta != false)
                    {
                        //Se inserto correctamente
                        return true;

                    }else
                    {
                        //Error al insertar en la base de datos
                        return false;
                    }
                }else
                {
                    //Error con las variables enviadas a la API REST;
                    return "error";
                }  
            } catch (Exception $e) {
                return "Error:".$e->getMessage;
            }
        }

        //Funcion para obtener cantidad de likes y estado del like
        public function getLikes($token, $idNoticia)
        {
            try {
                //Declarar variables
                $consulta = new Consultas();
                $respEstado = $consulta->obtenerEstadoLike($token, $idNoticia);
                $respCount = $consulta->obtenerLikes($idNoticia);
                
                //Validar que le habia dado like a la noticia
                if(mysqli_num_rows($respEstado) > 0)
                {
                    //Datos de la bd
                    $estado = mysqli_fetch_assoc($respEstado);
                                         
                    $estadoRequest = $estado['likes'];

                }else{
                    $estadoRequest = 0;
                }
                
                //Cantidad de likes
                if(mysqli_num_rows($respCount) > 0) 
                {                               
                    //Datos de la bd
                    $count = mysqli_fetch_assoc($respCount);                   
                }

                //Array para el json
                $datos = array(
                    'estado' => $estadoRequest,
                    'count' => $count['count(*)']                     
                );                             

                //Datos para el consumidor
                return json_encode($datos);

            } catch (Exception $e) {
                return "Error:".$e->getMessage;
            }            
        }
    }

    ob_end_flush();