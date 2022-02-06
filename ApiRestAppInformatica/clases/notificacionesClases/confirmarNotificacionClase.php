<?php

    ob_start();   

    require_once "../../bd/consultas.php";    

    //Clase para insertar el token
    class ApiRestConfirmNotification
    {

        public function confirmNotificacion($datosJson)
        {
            try {
                
                //Declarar variables
                $consulta = new Consultas();

                $datosArray = json_decode($datosJson, true);

                /* Estructura que se debe recibir para confirmar que se recibio la notificacion
                    {
                        "token": "El id de la transaccion en la base de datos",
                        "idNotificacion": "El id de la notificacion que llegue en la push"
                    }
                */

                //print_r($datosArray);
                if(isset($datosArray['token']) && isset($datosArray['idNotificacion']))
                {
                    if(is_numeric($datosArray['idNotificacion']))
                    {
                        $respuesta = $consulta->confirmarNotificacion($datosArray['token'], $datosArray['idNotificacion']);  
                        
                        //Respuesta del servidor
                        if($respuesta != false)
                        {
                            //Se actualizo correctamente
                            return "ok";

                        }else
                        {
                            //Error al actualizar en la base de datos
                            return "bd";
                        }                        
                    }else
                    {
                        //Error con los valores de las variables enviadas
                        return "val";
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