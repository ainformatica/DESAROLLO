<?php

    require_once "../../bd/consultas.php";

    //Clase para las noticias
    class ApiGetSession
    {

        //Funcion para obtener las sessiones
        public function getSession($token, $session)
        {
            try {
                //Declarar variables
                $consulta = new Consultas();
                $respuesta = $consulta->obtenerSesiones($token, $session);
                $datos = array();   
                
                if(mysqli_num_rows($respuesta) > 0)
                {               
                    //Preparacion del array para el json
                    while($datosbd = mysqli_fetch_assoc($respuesta))
                    {          
                        //Datos de los usuarios
                        $datosArray = array(
                            'idSession' => $datosbd['id_session_chat'],
                            'nombreCompleto' => ucwords(strtolower($datosbd['nombres']." ".$datosbd['apellidos'])),
                            'usuario' => $datosbd['Usuario'],
                            'tipoPersona' => ucfirst(strtolower($datosbd['tipo_persona'])),  
                            'correo' => strtolower($datosbd['valor'])             
                        );                             
                        array_push($datos, $datosArray);
                    }

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