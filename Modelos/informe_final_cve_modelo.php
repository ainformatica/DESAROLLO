<?php 

require "../clases/conexion_mantenimientos.php";

$instancia_conexion = new conexion();

Class informe
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}


	//Implementamos un método para insertar registros  
	public function insertar($hoy,$intro,$objetivos,$conclu,$recomendaciones,$año)
	{
		global $instancia_conexion;
		$sql="INSERT INTO tbl_voae_informe_anual(fecha_creacion,introduccion,objetivos,conclusiones,recomendaciones,año)
		VALUES ('$hoy','$intro','$objetivos',
		'$conclu','$recomendaciones','$año')";
		return $instancia_conexion->ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($id_informe_anual,$hoy,$intro,$objetivos,$conclu,$recomendaciones,$año)
	{
		global $instancia_conexion;
		$sql="UPDATE tbl_voae_informe_anual SET introduccion= '$intro',
		objetivos='$objetivos', conclusiones= '$conclu', 
		recomendaciones= '$recomendaciones',  año= '$año' WHERE id_informe_anual='$id_informe_anual'";
		return $instancia_conexion->ejecutarConsulta($sql);
	}

	//Implementamos un método para eliminar un memorandum
	public function eliminar($id_informe_anual)
	{
		global $instancia_conexion;
		$sql="DELETE FROM tbl_voae_informe_anual WHERE id_informe_anual='$id_informe_anual'";
		return $instancia_conexion->ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_informe_anual)
	{
		global $instancia_conexion;
		$sql="SELECT * FROM tbl_voae_informe_anual WHERE id_informe_anual='$id_informe_anual'";
		return $instancia_conexion->ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{	

		global $instancia_conexion;
		$sql="SELECT * FROM tbl_voae_informe_anual";
			return $instancia_conexion->ejecutarConsulta($sql);
	}
}

?>