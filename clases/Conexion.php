<?php
require_once "global.php";
$servidor= DB_HOST;
$usuario= DB_USERNAME;
$password = DB_PASSWORD;
$base= DB_NAME;
$encode=DB_ENCODE;
	$mysqli = new mysqli($servidor, $usuario,$password,$base);
	$connection = mysqli_connect($servidor, $usuario,$password,$base) or die("Error " . mysqli_error($connection));
	
	if($mysqli->connect_error){
		echo "Nuestro sitio presenta fallas....";
		die('Error en la conexion' . $mysqli->connect_error);
		exit();	
	}
$connect = new PDO("mysql:host=".$servidor.";dbname=".$base."", $usuario, $password);

if (!mysqli_set_charset($mysqli, $encode)) {
        printf("Error cargando el conjunto de caracteres utf8: %s\n", mysqli_error($mysqli));
        exit();
    } else {
        printf("");
    }

    
	

?>