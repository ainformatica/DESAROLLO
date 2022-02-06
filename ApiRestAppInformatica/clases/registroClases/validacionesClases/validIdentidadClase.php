<?php

    ob_start();   
    
    require_once "../../../bd/consultas.php";   

     //Clase para el estado civil
     class ApiRestValidId
     {
         
         //Funcion para obtener el estado civil
         public function validId($identidad)
         {
             try {
                 //Declarar variables
                 $consulta = new Consultas();               
                 $respuesta = $consulta->validarIdentidad($identidad);
                 $datos = array();
                 
                 //Preparacion de datos en array
                 if(mysqli_num_rows($respuesta) > 0)
                 {
                     //Se encontraron datos
                     return true;

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