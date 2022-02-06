<?php

    ob_start();   

    require_once "../../bd/consultas.php";    

    //Clase para insertar el token
    class ApiRestDeleteNotification
    {

        public function notificacionEliminada($datosJson)
        {
            try {
                
                //Declarar variables
                $consulta = new Consultas();

                $datosArray = json_decode($datosJson, true);

                /* Estructura que se debe recibir para eliminar solo un registro
                    {
                        "notifUsuario": "El id de la tabla notificacion usuario en la base de datos",
                    }
                */

                /* Estructura que se debe recibir para eliminar todos los registros
                    {
                        "token": "El id de la transaccion en la base de datos",
                    }
                */

                //print_r($datosArray);
                if(isset($datosArray['notifUsuario']))
                {
                    if(is_numeric($datosArray['notifUsuario']))
                    {
                        $respuesta = $consulta->NotificacionEliminada($datosArray['notifUsuario']);  
                        
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

                /*}elseif(isset($datosArray['token']))
                {
                    $respuesta = $consulta->actualizarAllNotLeida($datosArray['token']); */                   
                }else
                {
                    //Error con las variables enviadas a la API REST;
                    return "var";
                }  

                /*//Respuesta del servidor
                if($respuesta != false)
                {
                    //Se actualizo correctamente
                    return "ok";

                }else
                {
                    //Error al actualizar en la base de datos
                    return "bd";
                }*/
            } catch (Exception $e) {
                return "Error:".$e->getMessage;
            }
        }
    }
    
    ob_end_flush();