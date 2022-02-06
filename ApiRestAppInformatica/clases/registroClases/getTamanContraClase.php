<?php

    ob_start();   
    
    require_once "../../bd/consultas.php";   

     //Clase para el genero
     class ApiRestTamanPassword
     {
         
         //Funcion para obtener el genero
         public function getTamanPassword()
         {
             try {
                 //Declarar variables
                 $consulta = new Consultas();               
                 $respuesta = $consulta->obtenerTamanContra();
                 
                 //Preparacion de datos en array
                 if(mysqli_num_rows($respuesta) > 0)
                 {
                    $datosbd = mysqli_fetch_assoc($respuesta);
                    
                    $datos = array(
                        'minLength' => $datosbd['minLength'],
                        'maxLength' => $datosbd['maxLength']
                    );
 
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