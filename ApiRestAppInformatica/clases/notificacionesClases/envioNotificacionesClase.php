<?php

    ob_start();   

    require_once "../../bd/consultas.php";   

    //Clase para envio de notificaciones
    class ApiRestSendNotification
    {

        public function sendNotification($datosJson)
        {
            try {
                
                //Declarar variables
                $consulta = new Consultas();

                $datosArray = json_decode($datosJson, true);

                 /* Estructura que se debe recibir
                    {
                        "idLote": "id del lote, de momento el id de la notificacion en la base de datos",
                        "usuario": "usuario de quien envia la notificacion",
                        "password": "password de usuario que envia la notificacion",
                        "titulo": "Titulo de la notificacion",
                        "contenido": "body de la notificacion",
                        "urlRecurso": "url de la imagen",
                        "segmento": "id del segmento de personas"
                    }

                    pendiente: prioridad high = se envian inmediatamente al dispositivo
                                normal = se envia periodicamente, default si no se especifica
                */

                if(isset($datosArray['idLote']) && isset($datosArray['titulo']) && isset($datosArray['contenido']) &&
                    isset($datosArray['urlRecurso']) && isset($datosArray['segmento']))
                {       
                    if(is_numeric($datosArray['segmento']) && is_numeric($datosArray['idLote']))
                    {
                        //Extraer tokens de base de datos.
                        $respuesta = $consulta->obtenerTokensAndroid($datosArray['segmento']);
                        
                        if(mysqli_num_rows($respuesta) > 0)
                        {
                            //Declaracion de variable
                            $serverKey = "AAAA8N_ptdQ:APA91bHUhJcUhDl4zqsE6bWe6QyEEaDrqr7WE5xMTlcOxxUhEmQ4WKTDoohnQJ-LebsDt7KEUASOB4dZFtM7iSyx8lR6ZHfz-uaGFlmBYar5ejM3gorNtI11nEF6gk1JMO2jVeF3Iehc";
                            $titulo = $datosArray['titulo'];
                            $body = $datosArray['contenido'];
                            $imagen = $datosArray['urlRecurso'];
                            $idLote = $datosArray['idLote'];
                            $tokensbd = array();
                            $tokens = array();
                            $i = 0;//Contador de la cantidad de tokens en cada lote

                            
                            //Insertar todas las transacciones en la base de datos
                            $transaccion = $consulta->insertarTransaccionesAndroid($datosArray['segmento'], $datosArray['idLote']);

                            if($transaccion != false)
                            {

                                //Preparacion del array para el json de los token
                                while($datosbd = mysqli_fetch_assoc($respuesta))
                                { 
                                    array_push($tokensbd, $datosbd['token']);
                                    $i++;                               
                                    
                                    //Preparacion de lotes, Firebase solo permite un maximo de 500 tokens a la vez
                                    if($i == 500)
                                    {
                                        $i = 0;     

                                        //Formato del array de los tokens (solo los valores del array)
                                        $tokens = array_values($tokensbd);

                                        //Validar que se envien los lotes                                  
                                        $respuestaApi = $this->pushNotification($idLote, $titulo, $body, $imagen, $tokens, $serverKey);

                                        if($respuestaApi != true)
                                        {
                                            //Se deberia guardar en algun lugar, para revisar por que no se envian las notificaciones
                                        }                                        
                                        
                                        $tokensbd = array();
                                    }                                
                                }  

                                //Por si el lote o ultimo lote no llega a los 500 tokens
                                if($i > 0)
                                {       
                                    $i = 0;   

                                    //Formato del array de los tokens (solo los valores del array)
                                    $tokens = array_values($tokensbd);

                                    //Validar que se envien los lotes                                        
                                    $respuestaApi = $this->pushNotification($idLote, $titulo, $body, $imagen, $tokens, $serverKey);

                                    if($respuestaApi != true)
                                    {
                                        //Se deberia guardar en algun lugar, para revisar por que no se envian las notificaciones
                                    }                             
                                }
                                
                                //Formato del array de los tokens (solo los valores del array)
                                //$tokens = array_values($tokensbd);

                                //$respuestaApi = $this->pushNotification($titulo, $body, $imagen, $tokens, $serverKey);

                                if($respuestaApi == true) return "ok";
                                else return $respuestaApi; 
                            
                            }else
                            {
                                //Ocurrio algun error al insertar las transacciones en la db
                                return "error";
                            }

                        }else
                        {
                            //No se encontraron tokens en la base de datos
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


        //Funcion para arreglar los datos para firebase y enviar la notificacion
        private function pushNotification($pIdNotificacion, $pTitle, $pBody, $pImagen, $pTokens, $pServerKey)
        {
            //Valores requeridos para firebase
            $dataNotification = array(
                'idNotificacion' => $pIdNotificacion,
                'title' => $pTitle, 
                'body' => $pBody,
                'image' => $pImagen,
                'tipoNotificacion' => "not" 
            );

            $fieldsFirebase = array(
                'registration_ids' => $pTokens, 
                // 'notification'=> array notification
                'data' => $dataNotification,
                //'priority'=> 'high'
            );

            $headers = array('Content-Type: application/json',
            'Authorization:key='.$pServerKey
            );

            // Ejecutar Api de Firebase
            $url = 'https://fcm.googleapis.com/fcm/send';
            $sesion = curl_init($url);
            curl_setopt($sesion, CURLOPT_POST, true);
            curl_setopt($sesion, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($sesion, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($sesion, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($sesion, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($sesion, CURLOPT_POSTFIELDS, json_encode($fieldsFirebase));
            $resultado = curl_exec($sesion);

            if ($resultado == FALSE){ 
                return curl_error($sesion);
            }else{
                return true;
            }

            curl_close($sesion);
        }
}


ob_end_flush();