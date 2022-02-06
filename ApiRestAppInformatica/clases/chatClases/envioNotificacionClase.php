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
                        "token": "Para saber quien envia la notificacion, Titulo de la notificacion y sera el nombre de quien envia la notificacion",
                        "usuarioReceptor": "Para quien va dirigida la notificacion",
                        "mensaje": "body de la notificacion y mensaje que envia el usuario",
                        "urlRecurso": "url de la imagen"
                    }
                */

                if(isset($datosArray['token']) && isset($datosArray['usuarioReceptor']) && 
                isset($datosArray['mensaje']) && isset($datosArray['urlRecurso']))
                {
                    if($datosArray['usuarioReceptor'] == "ADMIN")
                    {

                    }else
                    {
                        //Token receptor
                        $respToken = $consulta->obtenerToken(strtoupper($datosArray['usuarioReceptor']));

                        if(mysqli_num_rows($respToken) > 0)
                        {
                            //Del remitente
                            $respNombre = $consulta->obtenerNombre($datosArray['token']);

                            if(mysqli_num_rows($respNombre) > 0)
                            {
                                //Declaracion de variables

                                //Token receptor y su id
                                $datosToken = mysqli_fetch_assoc($respToken);
                                $tokenVar = array();
                                array_push($tokenVar, $datosToken["token"]);
                                //Solo el valor del token
                                $token = array_values($tokenVar);
                                $idToken = $datosToken["UuidFromBin(tk.id_token)"];
                                $idUsuarioReceptor = $datosToken["id_usuario"];

                                //Nombre remitente y usuario
                                $datosNombre = mysqli_fetch_assoc($respNombre);
                                $titulo = ucwords(strtolower($datosNombre["nombres"]." ". $datosNombre["apellidos"]));
                                $remitente = $datosNombre["Usuario"];
                                $idUsuarioRemitente = $datosNombre['Id_usuario'];                                

                                $body = $datosArray['mensaje'];
                                $imagen = $datosArray['urlRecurso'];
                                
                                //Insertar la notificacion y transaccion en la base de datos
                                $respIdNotificacion = $consulta->insertarNotificacionTransaccion($titulo, $body, $imagen, $remitente, $idToken, $idUsuarioReceptor);

                                //print_r($respIdNotificacion);
                                if($respIdNotificacion != false)
                                {
                                    //id de la notificacion
                                    $datosIdNotificacion = mysqli_fetch_assoc($respIdNotificacion);
                                    $idNotificacion = $datosIdNotificacion['idNotificacion'];

                                    //Obtener el id de la session
                                    $respIdSession = $consulta->obtenerIdSession($idUsuarioRemitente, $idUsuarioReceptor);
                                    $idSession = -1; //Valor por si no se obtiene una session de la db

                                    if(mysqli_num_rows($respIdSession) > 0)
                                    {
                                        //asignar el id de la session obtenida de la base de datos
                                        $datosIdSession= mysqli_fetch_assoc($respIdSession);
                                        $idSession = $datosIdSession['id_session_chat'];
                                    }

                                    //Validar que se envio la notificacion                                       
                                    $respuestaApi = $this->pushNotification($idNotificacion, $titulo, $body, $imagen, $token, $idSession);

                                    if($respuestaApi != true)
                                    {
                                        //Se deberia guardar en algun lugar, para revisar por que no se envian las notificaciones
                                    }  

                                    if($respuestaApi == true) return "ok";
                                    else return $respuestaApi;
                                }else
                                {
                                    //Error al insertar 
                                    return "insert";
                                }                                
                            }else
                            {
                                //No tiene nombre el usuario
                                return "nombre";
                            }
                        }else
                        {
                            //No se encontro el token de usuario
                            return "user";
                        }   
                    }                                                          
                }else
                {
                    //Error con los valores de las variables enviadas
                    return "var";
                }    
            } catch (Exception $e) {
                return "Error:".$e->getMessage;
            }
        }


        //Funcion para arreglar los datos para firebase y enviar la notificacion
        private function pushNotification($pIdNotificacion, $pTitle, $pBody, $pImagen, $pToken, $pIdSession)
        {
            $serverKey = "AAAA8N_ptdQ:APA91bHUhJcUhDl4zqsE6bWe6QyEEaDrqr7WE5xMTlcOxxUhEmQ4WKTDoohnQJ-LebsDt7KEUASOB4dZFtM7iSyx8lR6ZHfz-uaGFlmBYar5ejM3gorNtI11nEF6gk1JMO2jVeF3Iehc";
            $tipoNotificacion = "chat";                         

            //Valores requeridos por la app
            $dataNotification = array(
                'idNotificacion' => $pIdNotificacion,
                'title' => $pTitle, 
                'body' => $pBody,
                'image' => $pImagen,
                'tipoNotificacion' => $tipoNotificacion,
                'idSession' => $pIdSession
            );

            $fieldsFirebase = array(
                'registration_ids' => $pToken, 
                // 'notification'=> array notification
                'data' => $dataNotification,
                //'priority'=> 'high'
            );

            $headers = array('Content-Type: application/json',
            'Authorization:key='.$serverKey
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