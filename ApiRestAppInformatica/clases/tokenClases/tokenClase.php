<?php

    ob_start(); 

    require_once "../../bd/consultas.php";

    //Clase para insertar el token
    class ApiRestToken
    {

        public function insertToken($datosJson)
        {
            try {
                
                //Declarar variables
                $consulta = new Consultas();

                $datosArray = json_decode($datosJson, true);

                /* Estructura que se debe recibir
                    {
                        "token": "token del dispositivo",
                        "tipoPlataforma": "android, ios, windows"
                    }
                */

                //print_r($datosArray);
                if(isset($datosArray['token']) && isset($datosArray['tipoPlataforma']))
                {
                    //Cambiar si se necesita en implementacion
                    $usuario = "invitados";

                    /*Validar el tipo de plataforma, tipos de resultados consultados de la propiedad 
                    DeviceInfo.Platform de Xamarin */
                    switch ($datosArray['tipoPlataforma']) {
                        case 'Android':
                            $tipoPlataforma = 1; //id en base de datos
                            break;
                        case 'iOS':
                            $tipoPlataforma = 2; //id en base de datos
                            break;                        
                        default:
                            $tipoPlataforma = 3; //id en base datos para UWP (Windows)
                            break; 
                        }                           

                    $respuesta = $consulta->insertarToken($datosArray['token'], $usuario,
                                        $tipoPlataforma);
                    
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