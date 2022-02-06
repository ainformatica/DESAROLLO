<?php

require_once('../clases/conexion_mantenimientos.php');

$instancia_conexion = new conexion();

	$el_departamento = $_POST['id_departamento'];
	
	$query = $instancia_conexion->ejecutarConsulta("SELECT id_departamento, municipio, id_municipio FROM tbl_municipios_hn WHERE id_departamento = $el_departamento");
	
	
	          while ($row = $query->fetch_assoc()) {
            echo '<option value="'.$row['id_municipio'].'"> '.$row['municipio'].'</option>'. "\n" ;
          }  

?>