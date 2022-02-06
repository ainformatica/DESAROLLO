<?php

    require_once "../../bd/consultas.php";

    //Clase para las noticias
    class ApiGetFragLectura
    {

        //Funcion para obtener las noticias por rol
        public function getFragLectura($token,  $idMensaje, $session)
        {
            try {
                //Declarar variables
                $consulta = new Consultas();
                $respuesta = $consulta->obtenerFragLectura($token, $idMensaje, $session);
                $datos = array();   
                
                if(mysqli_num_rows($respuesta) > 0)
                {               
                    $datosbd = mysqli_fetch_assoc($respuesta);
                   
                    //Cuantos fueron leidos
                    $datos = array(
                        'count' => $datosbd['count(id_mensaje)']           
                    );    

                    //Datos para el consumidor
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