<?php

    ob_start();   
    
    require_once "../../../bd/consultas.php";   

     //Clase para validar el correo
     class ApiRestValidCorreo
     {
         
         //Funcion para validar el correo
         public function validCorreo($correo)
         {
             try {
                 //Declarar variables
                 $consulta = new Consultas();               
                 $respuesta = $consulta->validarCorreo($correo);
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