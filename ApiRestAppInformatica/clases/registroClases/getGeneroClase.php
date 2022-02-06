<?php

    ob_start();   
    
    require_once "../../bd/consultas.php";   

     //Clase para el genero
     class ApiRestGenre
     {
         
         //Funcion para obtener el genero
         public function getGenre()
         {
             try {
                 //Declarar variables
                 $consulta = new Consultas();               
                 $respuesta = $consulta->obtenerGenero();
                 $datos = array();
                 
                 //Preparacion de datos en array
                 if(mysqli_num_rows($respuesta) > 0)
                 {
                     while($datosbd = mysqli_fetch_assoc($respuesta))
                     {
                         //Formar array para el json
                         $generos = array(
                             'genero' => $datosbd['genero']
                         );
                         array_push($datos, $generos);
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