<?php

    ob_start();   
    
    require_once "../../../bd/consultas.php";   

     //Clase para el estado civil
     class ApiRestValidUser
     {
         
         //Funcion para obtener el estado civil
         public function validUser($usuario)
         {
             try {
                 //Declarar variables
                 $consulta = new Consultas();               
                 $respuesta = $consulta->validarUsuario($usuario);
                 $datos = array();
                 
                 //Preparacion de datos en array
                 if(mysqli_num_rows($respuesta) > 0)
                 {
                         /*$datos = array(
                             'idUsuario' => $datosbd['Id_usuario']
                         );
 
                     return json_encode($datos);*/
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