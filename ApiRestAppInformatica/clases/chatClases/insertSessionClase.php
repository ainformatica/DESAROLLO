<?php

    require_once "../../bd/consultas.php";

    //Clase para insertar el token
    class ApiRestInsertSession
    {

        public function insertSession($datosJson)
        {
            try {
                
                //Declarar variables
                $consulta = new Consultas();

                $datosArray = json_decode($datosJson, true);

                /* Estructura que se debe recibir
                    {
                        "token": "token del que inicia la sesion",
                        "usuarioReceptor": "usuario con quien inicia la sesion",
                        "mensaje": "El mensaje al receptor",
                        "tipoMensaje": "El tipo de mensaje que envia desde la app, texto, imagen, etc" 
                    }
                */

                //print_r($datosArray);
                if(isset($datosArray['token']) && isset($datosArray['usuarioReceptor']) && 
                   isset($datosArray['mensaje']) && isset($datosArray['tipoMensaje']))
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

                    $respuesta = $consulta->insertarSesion($datosArray['token'], strtoupper($datosArray['usuarioReceptor']), $datosArray['mensaje'], $tipoMensaje);
                    
                    if($respuesta != false)
                    {
                        $datosbd = mysqli_fetch_assoc($respuesta);

                        if(isset($datosbd['idSession']))
                        {
                            //Regresar id de la session que ya existe
                            return $datos = array('idSession' => $datosbd['idSession']);
                        }else
                        {
                            //Regresar datos de la session creada
                            return $datos = array(
                                'idSession' => $datosbd['id_session_chat'],
                                'nombreCompleto' => ucwords(strtolower($datosbd['nombres']." ".$datosbd['apellidos'])),
                                'usuario' => $datosbd['Usuario'],
                                'tipoPersona' => ucfirst(strtolower($datosbd['tipo_persona'])),  
                                'correo' => strtolower($datosbd['valor'])             
                            );
                        }    
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