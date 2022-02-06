<?php

    ob_start();   
    
    require_once "../../bd/consultas.php";   

     //Clase para obtener las preguntas del usuario
     class ApiRestQuestionsUser
     {
         
         //Funcion para obtener el las preguntas del usuario
         public function getQuestionsUser($datosJson)
         {
             try {
                 //Declarar variables
                 $consulta = new Consultas();               
                 $datos = array();
                 $datosArray = json_decode($datosJson, true);

                 /* Estructura que se debe recibir para confirmar que se recibio la notificacion
                    {
                        "usuario": "usuario, correo, numero de cuenta o empleado"
                    }
                */
                 
                if(isset($datosArray['usuario']))
                {                    
                    $respuesta = $consulta->obtenerPreguntasUser(strtoupper($datosArray['usuario']));

                    //Preparacion de datos en array
                    if(mysqli_num_rows($respuesta) > 0)
                    {         
                        $datosbd = mysqli_fetch_assoc($respuesta);   

                        if(isset($datosbd['pregunta'])){

                            mysqli_data_seek($respuesta, 0);//Volver a posicion 0 los datos

                            while($datosbd = mysqli_fetch_assoc($respuesta))
                            {
                                //Formar array para el json
                                $estados = array(
                                    'idPregunta' => $datosbd['Id_pregunta'],
                                    'pregunta' => $datosbd['pregunta']
                                );
                                array_push($datos, $estados);
                            }  

                            return $datos;
                        }
                        else if(isset($datosbd['idUsuario']))
                        {
                            //Usuario no existe
                            return "user";
                        }   
                        else
                        {
                            //Algo salio mal
                            return "error";
                        }   
                    }else
                    { 
                        //No se encontraron datos
                        return "vacio";
                    }
                }
                else
                {
                    //Variable no valida
                    return "var";
                }
             } catch (Exception $e) {
                 return "Error:".$e->getMessage;
             }            
         }       
     }       
     
    ob_end_flush();