<?php

    ob_start(); 

    require_once "../../bd/consultas.php";   
    require_once "../../clases/enviarCorreo/enviarCorreo.php";

    //Clase para resetear la contraseña
    class ApiRestSendCode
    {

        public function sendCode($datosJson)
        {
            try {
                
                //Declarar variables
                $consulta = new Consultas();
                $datos = array();
                $datosArray = json_decode($datosJson, true);
                $enviarCorreo = new SendEmail();

                /* Estructura que se debe recibir
                    {                        
                        "correo": "correo del usuario"
                    }
                */

                //print_r($datosArray);
                if(isset($datosArray['correo']))
                {    
                    //Consulta para traer el id de usuario y validar si existe el correo
                    $respuestaValid = $consulta->validarCorreoResetPass($datosArray['correo']);

                    if(mysqli_num_rows($respuestaValid) > 0)
                    {                     
                        //codigo aleatorio
                        $codigo = bin2hex(random_bytes(10));      
                        
                        //Datos que iran en el correo
                        $asunto = "Código para resetear su contraseña";

                        $mensaje = "<tr>
                        <td colspan='4' style='padding:15px;'>
                        <p style='font-size:20px;'>Hola, Este es su código para poder resetear su contraseña: <b>$codigo</b> Por favor, ingreselo en el campo del código.</p>
                        <p style='font-size:15px; font-family:Verdana, Geneva, sans-serif;'>Si usted no intenta resetear la contraseña omita este mensaje.</p>
                        <hr />
                        <img src='' alt='imagen' title='' style='height:auto; width:auto; max-width:auto;' />
                        <p style='font-size:15px; font-family:Verdana, Geneva, sans-serif;'>Este es un correo enviado automaticamente por el sistema, no es necesario responder.</p>
                        </td>
                        </tr>";

                        $mensajeAlternativo = "Este es su código para poder resetear su contraseña: '.$codigo.' por favor, ingreselo en el campo 'código enviado a su correo.'";

                        //Enviar correo
                        $SendCorreo = $enviarCorreo->enviarCorreo($datosArray['correo'], $asunto, $mensaje, $mensajeAlternativo);
                        //print_r($SendCorreo);
                        if($SendCorreo)
                        {                            
                            $datosbdValid = mysqli_fetch_assoc($respuestaValid);//id del usuario

                            $respuesta = $consulta->insertarCodigo($datosbdValid['Id_usuario'], $codigo);

                            if($respuesta != false)
                            {
                                //print_r($respuesta);
                                
                                return true;   
                            }else
                            {
                                //Error en la base de datos
                                return false;
                            }
                        }else
                        {
                            //Problema al enviar el correo, mensaje de error
                            return "send";
                        }                                          
                    }else
                    {
                        //No se encontro el correo
                        return "correo";
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