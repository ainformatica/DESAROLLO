<?php

    ob_start();   
    
    require_once "../../bd/consultas.php";   

     //Clase para las notificaciones
     class ApiRestNotification
     {
         
         //Funcion para obtener las notificaciones por el token
         public function getNotification($token)
         {
             try {
                 //Declarar variables
                 $consulta = new Consultas();                
                 $httpResponseCode = new httpResponseCode();
                 $respuesta = $consulta->obtenerNotificaciones($token);
                 $datos = array();

                //Para pasar informacion a los clientes del estado de la respuesta
                //$mensaje = "Datos entregados correctamente";
                //array_push($datos, $httpResponseCode->ok($mensaje));
                 
                 //Preparacion de datos en array
                 if(mysqli_num_rows($respuesta) > 0)
                 {
                     while($datosbd = mysqli_fetch_assoc($respuesta))
                     {
                        //convertir estado para que vaya como booleano
                        if($datosbd['notif_leida'] == 0) $estado = false;
                        else $estado = true;

                         //Formar array para el json
                         $notificaciones = array(
                             'notifUsuario' => $datosbd['id_notificacion_usuario'],
                             'titulo' => $datosbd['titulo'],
                             'contenido' => $datosbd['descripcion'],
                             'fechaHora' => $datosbd['fecha_hora'],
                             'tipoNotificacion' => $datosbd['tipo_notificacion'],
                             'urlRecurso' => $datosbd['image_url'],
                             'estado' => $estado
                         );
                         array_push($datos, $notificaciones);
                     }   

                    //Datos para el consumidor
                    //$datos =  mysqli_fetch_all($respuesta, MYSQLI_ASSOC);
                    //array_push($datos, $httpResponseCode->ok($mensaje));
 
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