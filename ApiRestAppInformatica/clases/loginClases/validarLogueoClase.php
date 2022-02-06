<?php

    ob_start(); 

    require_once "../../bd/consultas.php";

    //Clase para insertar el token
    class ApiRestValidLogin
    {

        public function validLogin($datosJson)
        {
            try {
                
                //Declarar variables
                $consulta = new Consultas();
                $datos = array();
                $datosArray = json_decode($datosJson, true);

                /* Estructura que se debe recibir
                    {                        
                        "token": "token del dispositivo",
                        "usuario": "El usuario de la persona"
                    }
                */

                //print_r($datosArray);
                if(isset($datosArray['token']) && isset($datosArray['usuario']))
                {    
                    $respuesta = $consulta->validarLogueo($datosArray['token'], $datosArray['usuario']);
                    
                    if($respuesta != false)
                    {
                        //print_r($respuesta);
                        //Se valido algo en la base de datos 
                        if(mysqli_num_rows($respuesta) > 1)
                        {
                            while ($datosbd = mysqli_fetch_assoc($respuesta)) {
                                
                                if(strtoupper($datosbd['nombre']) != "INVITADO")
                                {
                                    $datos = array(
                                        "nombre" => $datosbd['nombre']
                                    );
                                    break;
                                }else
                                {
                                    $datos = array(
                                        "nombre" => $datosbd['nombre']
                                    );
                                }                                
                            }
                            //print_r($datosbd);
                            return $datos;
                        }elseif (mysqli_num_rows($respuesta) > 0)
                        {
                            return mysqli_fetch_assoc($respuesta);
                        }else
                        {
                            //Problemas con los datos del usuario
                            return "null";
                        }      
                    }else
                    {
                        //Error en la base de datos
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