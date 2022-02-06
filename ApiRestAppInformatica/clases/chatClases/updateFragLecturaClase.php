<?php

    ob_start();   
    
    require_once "../../bd/consultas.php";    

    //Clase para insertar el token
    class ApiRestFragLectura
    {

        public function mensajesLeidos($datosJson)
        {
            try {
                
                //Declarar variables
                $consulta = new Consultas();

                $datosArray = json_decode($datosJson, true);

                /* Estructura que se debe recibir al actualizar solo un registro
                    {
                        "token": "El token del dispositivo",
                        "session": "el id de la session",
                        "idMensaje": "El ultimo mensaje recibido"
                    }
                */

                //print_r($datosArray);
                if(isset($datosArray['token']) && isset($datosArray['session']) && isset($datosArray['idMensaje']))
                {
                    $respuesta = $consulta->updateFragLectura($datosArray['token'], $datosArray['session'], $datosArray['idMensaje']);
                    
                    if($respuesta != false)
                    {
                        //Se actualizo correctamente
                        return true;

                    }else
                    {
                        //Error al actualizar en la base de datos
                        return false;
                    }
                }else
                {
                    //Error con las variables enviadas a la API REST;
                    return "var";
                }  

            } catch (Exception $e) {
                return "Error:".$e->getMessage;
            }
        }
    }
    
    ob_end_flush();