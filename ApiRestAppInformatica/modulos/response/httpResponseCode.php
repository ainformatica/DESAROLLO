<?php

    ob_start();   
    
    class httpResponseCode
    {

        public function ok($mensaje)
        {
            $respuestaApi= array(
                'http_response_code' => 200,
                'mensaje' => $mensaje
            );

            return $respuestaApi;
        }

        
        public function badRequest($mensaje)
        {
            $respuestaApi= array(
                'http_response_code' => 400,
                'mensaje' => $mensaje.", revise la documentacion de la API"
            );

            return $respuestaApi;
        }

        public function notFound($mensaje)
        {
            $respuestaApi= array(
                'http_response_code' => 404,
                'mensaje' => $mensaje
            );

            return $respuestaApi;
        }

        public function internalServerError($mensaje)
        {
            $respuestaApi= array(
                'http_response_code' => 500,
                'mensaje' => $mensaje
            );

            return $respuestaApi;
        }
        
        public function forbidden($mensaje)
        {
            $respuestaApi= array(
                'http_response_code' => 403,
                'mensaje' => $mensaje
            );

            return $respuestaApi;
        }

        public function unauthorized($mensaje)
        {
            $respuestaApi= array(
                'http_response_code' => 401,
                'mensaje' => $mensaje
            );

            return $respuestaApi;
        }
           
    }
     
    ob_end_flush(); 
?>