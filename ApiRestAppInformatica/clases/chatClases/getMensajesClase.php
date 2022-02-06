<?php

    require_once "../../bd/consultas.php";

    //Clase para las noticias
    class ApiGetMessage
    {

        //Funcion para obtener las noticias por rol
        public function getMessage($token, $session, $idMensaje)
        {
            try {
                //Declarar variables
                $consulta = new Consultas();
                $respuestaId = $consulta->obtenerIdUsuario($token);
                $datos = array();   
                
                if(mysqli_num_rows($respuestaId) > 0)
                {       
                    $idUsuario = mysqli_fetch_assoc($respuestaId);                    
                    $respuesta = $consulta->obtenerMensajes($token, $session, $idMensaje);

                    if(mysqli_num_rows($respuesta) > 0)
                    {         
                        //Preparacion del array para el json
                        while($datosbd = mysqli_fetch_assoc($respuesta))
                        {     
                            
                            //Saber quien envio el mensaje
                            if($idUsuario['Id_usuario'] == $datosbd['id_usuario'])
                            {
                                $usuarioSend = true;
                            }else  $usuarioSend = false;
                            
                            
                            //Para saber el tipo de mensaje
                            switch ($datosbd['id_tipo_mensaje']) {
                                case 1:
                                $tipoMensaje = 'texto';
                                break;
                                case 2:
                                $tipoMensaje = 'imagen';
                                break;
                                case 3:
                                $tipoMensaje = 'archivo';
                                break;
                                case 4:
                                $tipoMensaje = 'audio';
                                break;   
                                case 5:
                                $tipoMensaje = 'video';
                                break;                      
                                default:
                                $tipoMensaje = 'texto';
                                break;
                            }

                            //Datos de los usuarios
                            $datosArray = array(
                                'idMensaje' => $datosbd['id_mensaje'],
                                'idSession' => $datosbd['id_session_chat'],                                
                                'usuarioSend' => $usuarioSend,
                                'mensaje' => $datosbd['mensaje'],
                                'leido' => $datosbd['flag_lectura'],
                                'tipoMensaje' => $tipoMensaje,
                                'fechaHora' => $datosbd['fecha']                      
                            );                             
                            array_push($datos, $datosArray);
                        }

                        //Datos para el consumidor
                        return json_encode($datos);
                    }else{
                        //No se encontraron datos
                        return false;
                    } 
                }else
                {
                    //No se encontraron datos
                    return false;
                }
            } catch (Exception $e) {
                return "Error:".$e->getMessage;
            }            
        }
    }