<?php

    require_once "../../bd/consultas.php";

    //Clase para insertar el token
    class ApiRestInsertMessage
    {

        public function insertMessage($datosJson)
        {
            try {
                
                //Declarar variables
                $consulta = new Consultas();

                $datosArray = json_decode($datosJson, true);

                /* Estructura que se debe recibir
                    {
                        "mensaje": "Mensaje que envian al receptor",
                        "tipoMensaje": "tipo de mensaje, texto, imagen, etc",
                        "session": "Id de la sesion",
                        "token" : "token del dispositivo"
                    }
                */

                //print_r($datosArray);
                if(isset($datosArray['mensaje']) && isset($datosArray['tipoMensaje']) && isset($datosArray['session']) && isset($datosArray['token']))
                {
                    switch ($datosArray['tipoMensaje']) {
                        case 'texto':
                        $tipoMensaje = 1;
                        break;
                        case 'imagen':
                        $tipoMensaje = 2;
                        break;
                        case 'archivo':
                        $tipoMensaje = 3;
                        break;
                        case 'audio':
                        $tipoMensaje = 4;
                        break;   
                        case 'video':
                        $tipoMensaje = 5;
                        break;                      
                        default:
                        $tipoMensaje = 1;
                        break;
                    }

                    $respuesta = $consulta->insertarMensaje($datosArray['mensaje'], $tipoMensaje, $datosArray['session'], $datosArray['token']);
                    
                    if($respuesta != false)
                    {
                        //Se inserto correctamente
                        $datosbd = mysqli_fetch_assoc($respuesta);
                        return $datos = array('idMensaje' => $datosbd['LAST_INSERT_ID()']);

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