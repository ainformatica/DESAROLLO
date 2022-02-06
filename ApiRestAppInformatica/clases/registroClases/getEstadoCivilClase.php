<?php

    ob_start();   
    
    require_once "../../bd/consultas.php";   

     //Clase para el estado civil
     class ApiRestMaritalStatus
     {
         
         //Funcion para obtener el estado civil
         public function getMaritalStatus()
         {
             try {
                 //Declarar variables
                 $consulta = new Consultas();               
                 $respuesta = $consulta->obtenerEstadoCivil();
                 $datos = array();
                 
                 //Preparacion de datos en array
                 if(mysqli_num_rows($respuesta) > 0)
                 {
                     while($datosbd = mysqli_fetch_assoc($respuesta))
                     {
                         //Formar array para el json
                         $estados = array(
                             'estadoCivil' => $datosbd['estado_civil']
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