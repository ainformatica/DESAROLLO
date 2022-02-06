<?php

    ob_start();   
    
    require_once "../../bd/consultas.php";   

     //Clase para el estado civil
     class ApiRestPersonType
     {
         
         //Funcion para obtener el estado civil
         public function getPersonType()
         {
             try {
                 //Declarar variables
                 $consulta = new Consultas();               
                 $respuesta = $consulta->obtenerTipoPersona();
                 $datos = array();
                 $idUsuario = 0;
                 
                 //Preparacion de datos en array
                 if(mysqli_num_rows($respuesta) > 0)
                 {
                    while($datosbd = mysqli_fetch_assoc($respuesta))
                    {
                        if($datosbd['tipo_persona'] == "ESTUDIANTE") $idUsuario = $datosbd['id_tipo_persona'];

                        //Formar array para el json
                        $estados = array(
                            'idTipoPersona' => $datosbd['id_tipo_persona'],
                            'tipoPersona' => $datosbd['tipo_persona']
                        );
                        array_push($datos, $estados);
                    }  
                     
                    //Agregar tipo de persona egresado
                    $estados = array(
                        'idTipoPersona' => $idUsuario,
                        'tipoPersona' => "EGRESADO"
                    );
                    array_push($datos, $estados);
 
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