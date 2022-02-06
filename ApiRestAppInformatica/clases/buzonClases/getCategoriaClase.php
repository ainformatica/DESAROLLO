<?php

    ob_start();   

    require_once "../../bd/consultas.php";

    //Clase para insertar o actualizar likes
    class ApiRestCategoria
    {
        //Insertar y actualizar likes
        public function getCategoria()
        {
            try {
                //Declarar variables
                $consulta = new Consultas();               
                $respuesta = $consulta->obtenerCategoria();
                $datos = array();
                
                //Preparacion de datos en array
                if(mysqli_num_rows($respuesta) > 0)
                {
                    while($datosbd = mysqli_fetch_assoc($respuesta))
                    {
                        //Formar array para el json
                        $categorias = array(
                            'idCategoria' => $datosbd['id_categoria'],
                            'categoria' => $datosbd['categoria']
                        );
                        array_push($datos, $categorias);
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