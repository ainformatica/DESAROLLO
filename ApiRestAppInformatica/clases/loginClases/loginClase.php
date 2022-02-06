<?php

    ob_start(); 

    require_once "../../bd/consultas.php";
    //require_once ('../../clases/encriptar_desencriptar.php');
    require_once "../../clases/encriptarPassword/encriptar_desencriptar.php";

    //Clase para insertar el token
    class ApiRestLogin
    {

        public function login($datosJson)
        {
            try {
                
                //Declarar variables
                $consulta = new Consultas();
                $datos = array();
                $datosArray = json_decode($datosJson, true);

                /* Estructura que se debe recibir
                    {
                        "usuario": "El usuario de la persona",
                        "password": "El password asociado al usuario",
                        "token": "token del dispositivo",
                        "tipoPlataforma": "android, ios, windows"
                    }
                */

                //print_r($datosArray);
                if(isset($datosArray['usuario']) && isset($datosArray['password']) && isset($datosArray['token']) && isset($datosArray['tipoPlataforma']))
                {
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

                    //encriptar contrasenia
                    $password = cifrado::encryption($datosArray['password']);

                    $respuesta = $consulta->validarLogin(strtoupper($datosArray['usuario']), $password,
                                                         $datosArray['token'], $tipoPlataforma);
                    
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
                                        "nombre" => $datosbd['nombre'],
                                        "borrarDatos" => $datosbd['borrarDatos'],
                                        "nombres" => $datosbd['nombres'],
                                        "apellidos" => $datosbd['apellidos'],
                                        "sexo" => $datosbd['sexo'],
                                        "estado" => $datosbd['estado']
                                    );
                                    break;
                                }else
                                {
                                    $datos = array(
                                        "nombre" => $datosbd['nombre'],
                                        "borrarDatos" => $datosbd['borrarDatos'],
                                        "nombres" => $datosbd['nombres'],
                                        "apellidos" => $datosbd['apellidos'],
                                        "sexo" => $datosbd['sexo'],
                                        "estado" => $datosbd['estado']
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