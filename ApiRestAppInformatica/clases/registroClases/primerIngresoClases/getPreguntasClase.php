<?php

    ob_start();   
    
    require_once "../../../bd/consultas.php";
    //require_once ('../../clases/encriptar_desencriptar.php');
    require_once "../../../clases/encriptarPassword/encriptar_desencriptar.php";   

     //Clase para el tipo de docente
     class ApiRestQuestions
     {
         
         //Funcion para obtener el tipo de docente
         public function getQuestions($datosJson)
         {
             try {

                $datosArray = json_decode($datosJson, true);

                /* Estructura que se debe recibir
                    {
                        "usuario": "token del dispositivo",
                        "password": "android, ios, windows"
                    }
                */

                if(isset($datosArray['usuario']) && isset($datosArray['password']))
                {  
                    //Declarar variables
                    $consulta = new Consultas();   
                    
                    //encriptar contrasenia
                    $password = cifrado::encryption($datosArray['password']);

                    $respuestaTodas = $consulta->obtenerTodasPreguntas(strtoupper($datosArray['usuario']), $password);
                    $datos = array();

                    if(mysqli_num_rows($respuestaTodas) > 0)
                    {
                        $datosbdTodas = mysqli_fetch_assoc($respuestaTodas);//Para validar que viene de la db
                        
                        if(isset($datosbdTodas['Id_pregunta']) && isset($datosbdTodas['countPreguntas']))
                        {
                            $cantidadPreguntas = $datosbdTodas['cantPreguntas'] - $datosbdTodas['countPreguntas'];

                            if($datosbdTodas['countPreguntas'] > 0) //Para saber si ya tiene respuestas ingresadas
                            {
                                $respuestaUsuario = $consulta->obtenerPreguntasUsuario($datosbdTodas['idUsuario'], $password);
                                
                                if(mysqli_num_rows($respuestaUsuario) > 0)
                                {
                                    $j = 0;//Para no iterar mas en el while de validar preguntas de usuario                                   
                                   
                                    mysqli_data_seek($respuestaTodas, 0);//Poner el puntero en 0, para iterar todas las preguntas de la db

                                    //While para comparar las preguntas del usuario con todas las de la db
                                    while($datosbdTodas = mysqli_fetch_assoc($respuestaTodas))
                                    {
                                        $validar = false;
                                       
                                        if($j < mysqli_num_rows($respuestaUsuario))//Evitar iteraciones innesearias
                                        {
                                            mysqli_data_seek($respuestaUsuario, 0);//Poner el puntero en 0, para iterar las preguntas del usuarios siempre

                                            //Validar que no vaya una pregunta que ya haya ingresado el usuario
                                            while($datosbdUsuario = mysqli_fetch_assoc($respuestaUsuario))
                                            {   
                                                //echo $datosbdTodas['Id_pregunta']. " " . $datosbdUsuario['Id_pregunta'].", ";
                                                
                                                if($datosbdTodas['Id_pregunta'] == $datosbdUsuario['Id_pregunta'])
                                                {
                                                    $validar = true;  
                                                    $j= $j + 1;                               
                                                    break;
                                                }                                           
                                            } 
                                        }                                                                               

                                        if($validar === false)
                                        {
                                            //Formar array para el json
                                            $preguntas = array(
                                                'idPregunta' => $datosbdTodas['Id_pregunta'],
                                                'pregunta' => $datosbdTodas['pregunta'],
                                                'cantidadPreguntas' => $cantidadPreguntas
                                            );
                                            array_push($datos, $preguntas);
                                        } 
                                    }   
                                    
                                    return $datos;
                                }
                                else
                                {
                                    return "pregUsuario"; //No se encontraron preguntas del usuario
                                }
                            }
                            else //Todas las preguntas
                            {
                                mysqli_data_seek($respuestaTodas, 0);

                                while($datosbdTodas = mysqli_fetch_assoc($respuestaTodas))
                                {
                                    //Formar array para el json
                                    $preguntas = array(
                                        'idPregunta' => $datosbdTodas['Id_pregunta'],
                                        'pregunta' => $datosbdTodas['pregunta'],
                                        'cantidadPreguntas' => $cantidadPreguntas
                                    );
                                    array_push($datos, $preguntas);
                                }
                                
                                return $datos;
                            }                        
                        }                     
                        elseif(isset($datosbdTodas['cantPreguntas']))
                        {
                            return "completas"; //Las preguntas ya estan completas
                        }
                        else
                        {
                            return "usuario"; //Algún campo del usuario enviado no es correcto o su estado ya no es de primer ingreso
                        }                    
                    }    
                    else
                    { 
                        //No se encontraron preguntas
                        return false;
                    }
                }
                else
                {
                    //Error con las variables enviadas a la api
                    return "var";
                }
             } catch (Exception $e) {
                 return "Error:".$e->getMessage;
             }            
         }       
     }       
     
    ob_end_flush();