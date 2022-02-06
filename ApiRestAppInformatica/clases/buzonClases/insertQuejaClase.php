<?php

    ob_start(); 

    require_once "../../bd/consultas.php";

    //Clase para insertar el token
    class ApiRestQueja
    {

        public function insertQueja($datosJson)
        {
            try {
                
                //Declarar variables
                $consulta = new Consultas();

                $datosArray = json_decode($datosJson, true);

                /* Estructura que se debe recibir
                    {
                        "token": "token del dispositivo",
                        "titulo": "Titulo de la queja, comentario, etc",
                        "descripcion": "Descripcion de la queja, comentario, etc",
                        "categoria": "el id de la categoria que haya escogido el usuario"
                    }
                */

                //print_r($datosArray);
                if(isset($datosArray['token']) && isset($datosArray['titulo']) && isset($datosArray['descripcion']) && isset($datosArray['categoria']))
                {                       

                    $respuesta = $consulta->insertarQueja($datosArray['token'], $datosArray['titulo'],
                                                          $datosArray['descripcion'], $datosArray['categoria']);
                    
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
    }

    ob_end_flush();