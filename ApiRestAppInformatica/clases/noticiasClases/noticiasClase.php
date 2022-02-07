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
                
                print_r($respuesta);
                if(mysqli_num_rows($respuesta) > 0)
                {     echo " entro a la validación de rows,";
                    //Preparacion del array para el json
                    while($datosbd = mysqli_fetch_assoc($respuesta))
                    {         
                        echo " entro al while,";
                        //Validar si una noticia tiene mas de un recurso para no mandar datos de la noticia repetidos
                        if($idNoticia != $datosbd['id'])
                        {      
                            echo " entro al if de agregar nueva noticia,";                           
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
                            
                            print_r($datosArray);
                            
                            //array_push($datos, $datosArray);
                            $push = true;
                            $i = 1;
                        }else
                        {    
                            echo " entro a la validación de agregar otra imagen, ";
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
print_r($datos);
                    //Datos para el consumidor
                    return json_encode($datos); 
                }
                else
                {
                    echo " entro a la validación de ningun dato encontrado";
                    //No se encontraron datos
                    return false;
                }    
            } catch (Exception $e) {
                echo " entro al catch ".$e->getMessage;
                return "Error:".$e->getMessage;
            }             
        }
    }
    
    ob_end_flush();