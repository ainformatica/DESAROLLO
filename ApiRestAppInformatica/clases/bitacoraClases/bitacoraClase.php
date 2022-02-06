<?php
    ob_start();   

    require_once "../../bd/consultas.php";

    //Clase para insertar en la bitacora
    class ApiRestBinnacle
    {

        public function insertBinnacle($datosJson)
        {
            try {
                
                //Declarar variables
                $consulta = new Consultas();

                $datosArray = json_decode($datosJson, true);

                /* Estructura que se debe recibir
                    {
                        "accion": "Prueba desde postman",
                        "descripcion": "Prueba desde postman",
                        "token": "token del dispositivo",
                        "idObjeto": 1
                    }
                */

                //print_r($datosArray);
                if(isset($datosArray['accion']) && isset($datosArray['descripcion']) && 
                    isset($datosArray['token']) && isset($datosArray['idObjeto']))
                {
                    $respuesta = $consulta->insertarBitacora($datosArray['accion'], $datosArray['descripcion'],
                                          $datosArray['token'], $datosArray['idObjeto']);
                    
                   if($respuesta != false)
                    {
                        //Se inserto correctamente
                        return true;

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