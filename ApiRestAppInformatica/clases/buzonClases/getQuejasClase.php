<?php

    ob_start();   

    require_once "../../bd/consultas.php";

    //Clase para obtener las quejas
    class ApiRestGetQuejas
    {
        //Funcion para obtener las quejas
        public function getQuejas($token)
        {
            try {
                //Declarar variables
                $consulta = new Consultas();
                $respuesta = $consulta->obtenerQuejas($token);
                $datos = array();
                
                //Preparacion de datos en array
                if(mysqli_num_rows($respuesta) > 0)
                {
                    while($datosbd = mysqli_fetch_assoc($respuesta))
                    {
                        if($datosbd['id_estado'] == 7)//Estado nuevo
                        {
                            $estado = false;
                        }else
                        {
                            $estado = true; //Estado respondido
                        }

                        //Formar array para el json
                        $quejas = array(
                            'titulo' => $datosbd['titulo'],
                            'descripcion' => $datosbd['descripcion'],
                            'fechaQueja' => $datosbd['fecha_queja'],
                            'respuesta' => $datosbd['respuesta'],
                            'fechaRespuesta' => $datosbd['fecha_respuesta'],
                            'estado' => $estado
                        );
                        array_push($datos, $quejas);
                    }   

                    return json_encode($datos);
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

    ob_end_flush();