<?php 
//Incluímos inicialmente la conexión a la base de datos

require "../clases/conexion_mantenimientos.php";

$instancia_conexion = new conexion();



Class listado_asistencia
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($id_actividad_voae,$cuenta,$nombre_alumno,$cant_horas, $carrera )
	{
		global $instancia_conexion;
		$sql = "INSERT INTO `tbl_voae_asistencias` ( `id_actividad_voae`, `cuenta`, `nombre_alumno`, `cant_horas`, `carrera`) 
				VALUES ('$id_actividad_voae','$cuenta', trim(upper('$nombre_alumno')),'$cant_horas', trim(upper( '$carrera'))); 
		";
		return $instancia_conexion->ejecutarConsulta($sql);

		
	}

	//Implementamos un método para editar registros
	public function editar(	$id_asistencia,$cuenta,$nombre_alumno,$cant_horas, $carrera)
	{
		global $instancia_conexion;
		$sql="UPDATE tbl_voae_asistencias SET cuenta = '$cuenta', nombre_alumno =  trim(upper('$nombre_alumno')), cant_horas = '$cant_horas', carrera =  trim(upper( '$carrera'))
		 WHERE  id_asistencia='$id_asistencia';";
		return $instancia_conexion->ejecutarConsulta($sql);
	}


	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_asistencia)
	{
		global $instancia_conexion;
		$sql="SELECT * FROM tbl_voae_asistencias WHERE id_asistencia='$id_asistencia'";
		return $instancia_conexion->ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar($id_actividad_voae)
	{
		global $instancia_conexion;
		$sql="SELECT * FROM tbl_voae_asistencias where id_actividad_voae = '$id_actividad_voae' ORDER BY carrera DESC,  nombre_alumno ASC";
		return $instancia_conexion->ejecutarConsulta($sql);		
	}

	//Implementamos un método para eliminar categorías
	public function eliminar($id_asistencia)
	{
		global $instancia_conexion;
		$sql="DELETE FROM tbl_voae_asistencias WHERE id_asistencia='$id_asistencia' ";
		return $instancia_conexion->ejecutarConsulta($sql);
	}
}

?>