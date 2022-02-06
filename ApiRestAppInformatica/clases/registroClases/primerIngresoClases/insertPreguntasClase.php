<?php

    ob_start(); 

    require_once "../../../bd/consultas.php";
    //require_once ('../../clases/encriptar_desencriptar.php');
    require_once "../../../clases/encriptarPassword/encriptar_desencriptar.php";

    //Clase para insertar las preguntas cuando sean usuarios que fueron registrados en el portal
    class ApiRestInsertQuestions
    {

        public function insertQuestions($datosJson)
        {
            try {
                
                //Declarar variables
                $consulta = new Consultas();

                $datosArray = json_decode($datosJson, true);

                /* Estructura que se debe recibir
                    {
                        "usuario": "usuario, correo o numero de cuenta o empleado",
                        "password": "contrasena del usuario",
                        "pregunta": "id de la pregunta",
                        "respuesta": "respuesta de la pregunta seleccionada",
                        "nuevoPassword": "opcional: iria la nueva contrasena del usuario"
                    }
                */

                //print_r($datosArray);
                if(isset($datosArray['usuario']) && isset($datosArray['password']) &&
                   isset($datosArray['pregunta']) && isset($datosArray['respuesta']))
                {                      
                    //encriptar contrasenia
                    $password = cifrado::encryption($datosArray['password']);

                    if(isset($datosArray['nuevoPassword']))
                    {
                        //encriptar la nueva contrasenia
                        $nuevoPassword = cifrado::encryption($datosArray['nuevoPassword']);
                        
                        $respuesta = $consulta->insertarPreguntasPassword(strtoupper($datosArray['usuario']), $password,
                                        $datosArray['pregunta'], strtoupper($datosArray['respuesta']), $nuevoPassword);
                    }
                    else
                    {
                        $respuesta = $consulta->insertarPreguntas(strtoupper($datosArray['usuario']), $password,
                                                $datosArray['pregunta'], strtoupper($datosArray['respuesta']));
                    }
                    
                    
                    if($respuesta != false)
                    {
                        return mysqli_fetch_assoc($respuesta);
                        
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

    ob_end_flush();