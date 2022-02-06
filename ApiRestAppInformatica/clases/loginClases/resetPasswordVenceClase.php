<?php

    ob_start();   

    require_once "../../bd/consultas.php";    
    require_once "../../clases/enviarCorreo/enviarCorreo.php";
    //require_once ('../../clases/encriptar_desencriptar.php');
    require_once "../../clases/encriptarPassword/encriptar_desencriptar.php";

    //Clase para resetear la contrasena
    class ApiRestResetPasswordVence
    {

        public function resetPasswordVence($datosJson)
        {
            try {
                
                //Declarar variables
                $consulta = new Consultas();
                $enviarCorreo = new SendEmail();

                $datosArray = json_decode($datosJson, true);

                /* Estructura que se debe recibir para confirmar que se recibio la notificacion
                    {
                        "usuario": "Codigo que se envio al correo",
                        "password": "Contrasena actual",
                        "nuevoPassword": "Nueva contrasena"
                    }
                */

                //print_r($datosArray);
                if(isset($datosArray['usuario']) && isset($datosArray['password']) && isset($datosArray['nuevoPassword']))
                {
                    //encriptar contrasenas
                    $password = cifrado::encryption($datosArray['password']);
                    $nuevoPassword = cifrado::encryption($datosArray['nuevoPassword']);

                    $respuesta = $consulta->resetearPasswordVence(strtoupper($datosArray['usuario']), $password, $nuevoPassword);  
                    
                    //Respuesta del servidor
                    if($respuesta != false)
                    {
                        $datosbd = mysqli_fetch_assoc($respuesta);
                        
                        if(isset($datosbd['valor']) or isset($datosbd['dias']))
                        {
                            //Mensaje que ira en el correo
                            $asunto = "Reseteo de contraseña";

                            $mensaje = "<tr>
                                        <td colspan='4' style='padding:15px;'>
                                        <p style='font-size:20px;'>Se reseteo la contraseña de su usuario de la APP de la carrera Informática Administrativa, si no ha sido usted por favor informe a las autoridades para que bloqueen su usuario.</p>
                                        <p style='font-size:15px; font-family:Verdana, Geneva, sans-serif;'>Si fue usted que cambio la contraseña omita este correo.</p>
                                        <hr />
                                        <img src='' alt='imagen' title='' style='height:auto; width:auto; max-width:auto;' />
                                        <p style='font-size:15px; font-family:Verdana, Geneva, sans-serif;'>Este es un correo enviado automaticamente por el sistema, no es necesario responder.</p>
                                        </td>
                                        </tr>";

                            $mensajeAlternativo = "Se cambio la contraseña de su usuario de la APP de la carrera Informática Administrativa, si no ha sido usted por favor informe a las autoridades para que bloqueen su usuario";

                            mysqli_data_seek($respuesta, 0);

                            //Enviar a todos los correos registrados por el usuario
                            while($datosbd = mysqli_fetch_assoc($respuesta))
                            {
                                //Enviar correo
                                $SendCorreo = $enviarCorreo->enviarCorreo($datosbd['valor'], $asunto, $mensaje, $mensajeAlternativo);

                            }
                            
                            //Se actualizo correctamente
                            return "ok";  

                        }elseif(isset($datosbd['idUsuario']))
                        {
                            //Datos del usuario incorrectos
                            return "user";

                        }elseif(isset($datosbd['fechaVenceContra']))
                        {
                            //Vencio el codigo
                            return "vencido";

                        }else
                        {
                            //Error al actualizar en la base de datos
                            return "bd";
                        }    
                    }else
                    {
                        //Error al actualizar en la base de datos
                        return "bd";
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