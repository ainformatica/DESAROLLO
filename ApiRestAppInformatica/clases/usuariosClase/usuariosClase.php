<?php

    require_once "../../bd/consultas.php";

    //Clase para las noticias
    class ApiUsers
    {

        //Funcion para obtener las noticias por rol
        public function getUsers($token)
        {
            try {
                //Declarar variables
                $consulta = new Consultas();
                $respuesta = $consulta->obtenerUsuarios($token);
                $respuestaAdmin = $consulta->obtenerUsuariosAdmin();
                $datos = array();   
                
                if(mysqli_num_rows($respuesta) > 0 || mysqli_num_rows($respuestaAdmin) > 0)
                {     
                    if(mysqli_num_rows($respuestaAdmin) > 0)
                    {
                        //Preparacion del array para el json
                        while($datosAdminbd = mysqli_fetch_assoc($respuestaAdmin))
                        {          
                            //Datos de los usuarios
                            $datosArrayAdmin = array(
                                'nombreCompleto' => ucwords(strtolower($datosAdminbd['nombres']." ".$datosAdminbd['apellidos'])),
                                'correo' => strtolower($datosAdminbd['valor']),
                                'tipoUsuario' => ucfirst(strtolower($datosAdminbd['tipo_persona'])),  
                                'usuarioReceptor' => $datosAdminbd['Usuario']                    
                            );                             
                            array_push($datos, $datosArrayAdmin);
                        }
                    }
                    
                    if(mysqli_num_rows($respuesta) > 0)
                    {          
                        //Preparacion del array para el json
                        while($datosbd = mysqli_fetch_assoc($respuesta))
                        {          
                            //Datos de los usuarios
                            $datosArray = array(
                                'nombreCompleto' => ucwords(strtolower($datosbd['nombres']." ".$datosbd['apellidos'])),
                                'correo' => strtolower($datosbd['valor']),
                                'tipoUsuario' => ucfirst(strtolower($datosbd['tipo_persona'])),  
                                'usuarioReceptor' => $datosbd['Usuario']                    
                            );                             
                            array_push($datos, $datosArray);
                        }
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