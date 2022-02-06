<?php 

ob_start();
require_once dirname(dirname(__DIR__))."/clases/global.php";
class Conexion{

    public function conexion_bd(){

        $server = DB_HOST;
        $user = DB_USERNAME;
        $password = DB_PASSWORD;
        $dataBase = DB_NAME;
        $port = 3306;

        $conexion = @mysqli_connect($server, $user, $password, $dataBase, $port);

        if(!empty($conexion))
        {
            return $conexion;
        }else
        {
            return null; //"Error, no se pudo conectar con la base de datos";
        }
    }
}

ob_end_flush();
//$conexion = new conexion;
//echo $conexion->conexion_bd();
