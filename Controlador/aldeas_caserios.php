<?php

require_once('../clases/conexion_mantenimientos.php');

$instancia_conexion = new conexion();

	$municipio = $_POST['id_municipio'];
	
	$query = $instancia_conexion->ejecutarConsulta("SELECT id_aldea_caserio, nombre_aldea_caserio FROM tbl_aldeas_caserios_hn WHERE id_municipio = $municipio");
	
	
	          while ($row = $query->fetch_assoc()) {
            echo '<option value="'.$row['id_aldea_caserio'].'"> '.$row['nombre_aldea_caserio'].'</option>'. "\n" ;
          }  

?>