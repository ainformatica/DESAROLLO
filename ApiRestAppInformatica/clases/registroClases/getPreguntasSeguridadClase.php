<?php

    ob_start();   
    
    require_once "../../bd/consultas.php";   

     //Clase para el tipo de docente
     class ApiRestSecurityQuestions
     {
         
         //Funcion para obtener el tipo de docente
         public function getSecurityQuestions()
         {
             try {
                 //Declarar variables
                 $consulta = new Consultas();               
                 $respuesta = $consulta->obtenerPreguntasSeguridad();
                 $datos = array();
                 
                 //Preparacion de datos en array
                 if(mysqli_num_rows($respuesta) > 0)
                 {
                     while($datosbd = mysqli_fetch_assoc($respuesta))
                     {
                         //Formar array para el json
                         $estados = array(
                             'idPregunta' => $datosbd['Id_pregunta'],
                             'pregunta' => $datosbd['pregunta']
                         );
                         array_push($datos, $estados);
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