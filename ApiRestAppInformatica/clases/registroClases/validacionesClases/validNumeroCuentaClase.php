<?php

    ob_start();   
    
    require_once "../../../bd/consultas.php";   

     //Clase para validar el numero de cuenta
     class ApiRestValidNumeroCuenta
     {
         
         //Funcion para validar el numero de cuenta
         public function validNumeroCuenta($numeroCuenta)
         {
             try {
                 //Declarar variables
                 $consulta = new Consultas();               
                 $respuesta = $consulta->validarNumeroCuenta($numeroCuenta);
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