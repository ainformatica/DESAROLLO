<?php

    ob_start();   

    require_once "../../bd/consultas.php";

    //Clase para las noticias
    class ApiRestNews
    {

        //Funcion para obtener las noticias por rol
        public function getNewsByToken($token)
        {
            try {
                //Declarar variables
                $consulta = new Consultas();
                $respuesta = $consulta->obtenerNoticias($token);
                $datos = array();
                $idNoticia = null;                
                $i = 0; 
                $push = false;
                
                //print_r($respuesta);
                if(mysqli_num_rows($respuesta) > 0)
                {
                    //Preparacion del array para el json
                    while($datosbd = mysqli_fetch_assoc($respuesta))
                    { 
                        //Validar si una noticia tiene mas de un recurso para no mandar datos de la noticia repetidos
                        if($idNoticia != $datosbd['id'])
                        {                                 
                            //Insertar en array si solo hay una imagen en la noticia
                            if($push == true) array_push($datos, $datosArray);

                            //Datos de las noticias
                            $datosArray = array(
                                'idNoticia' => $datosbd['id'],
                                'titulo' => $datosbd['titulo'],
                                'subtitulo' => $datosbd['subtitulo'],
                                'contenido' => $datosbd['descripcion'],
                                'fechaHora' => $datosbd['fecha'],
                                'publicadoPor' => $datosbd['remitente'],                       
                                'urlRecurso' => $datosbd['url']                          
                            );     
                            
                            //array_push($datos, $datosArray);
                            $push = true;
                            $i = 1;
                        }else
                        {                                
                            //Recursos extras de las noticias
                            $recursos = array(                           
                                'urlRecurso '.$i => $datosbd['url']
                            );

                            //Formato de array cuando hay mas de un recurso en una noticia
                            $datosArray = array_merge($datosArray, $recursos);
                            //array_push($datos, $datosArray);

                            $i++;
                        }
                        
                        //Captura de id para validar en siguiente ciclo del while
                        $idNoticia = $datosbd['id'];
                    }
                                
                    //Insertar ultimo registro
                    if($i >= 1) array_push($datos, $datosArray);

                    //Datos para el consumidor
                    return json_encode($datos); 
                }
                else
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