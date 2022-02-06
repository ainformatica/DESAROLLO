<?php

    ob_start();   
    
    require_once "../../bd/consultas.php";   

     //Clase para obtener nacionalidad
     class ApiRestNacionality
     {
         
         //Funcion para obtener la nacionalidad
         public function getNacionality()
         {
             try {
                 //Declarar variables
                 $consulta = new Consultas();               
                 $respuesta = $consulta->obtenerNacionalidad();
                 $datos = array();
                 
                 //Preparacion de datos en array
                 if(mysqli_num_rows($respuesta) > 0)
                 {
                     
                 //print_r(mysqli_fetch_assoc($respuesta));
                     while($datosbd = mysqli_fetch_assoc($respuesta))
                     {
                         //Formar array para el json
                         $nacionalidad = array(
                             'nacionalidad' => $datosbd['nacionalidad']
                         );
                         array_push($datos, $nacionalidad);
                     }   
                     //print_r($datos);
                     return json_encode($datos, JSON_INVALID_UTF8_IGNORE);
                 }else
                 { 
                     //No se encontraron datos
                     return false;
                 }
             } catch (Exception $e) {
                 return "Error: ";//.$e->getMessage;
             }            
         }       
     }       
     
    ob_end_flush();