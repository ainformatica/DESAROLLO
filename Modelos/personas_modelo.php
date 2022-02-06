<?php
require "../clases/conexion_mantenimientos.php";

$instancia_conexion = new conexion();

class personas
{
   
	//Implementamos un método para insertar registros de primera unica de supervision
	
	public function registrar_persona($nombres, $apellidos, $sexo, $identidad, $nacionalidad, $estado_civil, $fecha_nacimiento, $id_tipo_persona, $Estado, $correo, $cuenta, $telefono,$direccion)
	{
        global $instancia_conexion;
		$sql = "call proc_insertar_persona_estudiante('$nombres', '$apellidos', '$sexo', '$identidad', '$nacionalidad', '$estado_civil', '$fecha_nacimiento', '$id_tipo_persona', '$Estado', '$correo', '$cuenta', '$telefono','$direccion');";
		return $instancia_conexion->ejecutarConsulta($sql);
	}

	public function registrar_persona_admin($nombres, $apellidos, $sexo, $identidad, $nacionalidad, $estado_civil, $fecha_nacimiento, $id_tipo_persona, $Estado, $correo, $cuenta, $telefono, $direccion)
	{
		global $instancia_conexion;
		$sql = "call proc_insertar_persona_adm('$nombres', '$apellidos', '$sexo', '$identidad', '$nacionalidad', '$estado_civil', '$fecha_nacimiento', '$id_tipo_persona', '$Estado', '$correo', '$cuenta', '$telefono','$direccion');";
		return $instancia_conexion->ejecutarConsulta($sql);
	}



	function listar_tipo_persona()
	{
		global $instancia_conexion;
		$consulta = $instancia_conexion->ejecutarConsulta("SELECT id_tipo_persona, tipo_persona FROM tbl_tipos_persona where id_tipo_persona !=1 and id_tipo_persona!=3");

		return $consulta;
	}

	function listar_genero()
	{
		global $instancia_conexion;
		$consulta = $instancia_conexion->ejecutarConsulta("SELECT * FROM tbl_genero ");

		return $consulta;
	}
	function listar_estado_civil()
	{
		global $instancia_conexion;
		$consulta = $instancia_conexion->ejecutarConsulta("SELECT id_estado_civil,estado_civil FROM tbl_estadocivil ");

		return $consulta;
	}
	function listar_nacionalidad()
	{
		global $instancia_conexion;
		$consulta = $instancia_conexion->ejecutarConsulta("SELECT id_nacionalidad,nacionalidad FROM tbl_nacionalidad ");

		return $consulta;
	}

	function existe_persona($cuenta)
	{
		global $instancia_conexion;

		$sql4 = "call proc_verificar_persona_estudiante('$cuenta')";
		return $instancia_conexion->ejecutarConsultaSimpleFila($sql4);
	}

	function existe_personaAdmin($cuenta)
	{
		global $instancia_conexion;

		$sql4 = "call proc_verificar_persona_administrativa('$cuenta')";
		return $instancia_conexion->ejecutarConsultaSimpleFila($sql4);
	}

	public function Registrar_foto($nombrearchivo)
	{
		global $instancia_conexion;
		$sql = "CALL proc_insertar_foto('$nombrearchivo')";

		return $instancia_conexion->ejecutarConsulta($sql);
	}

}




   
























?>


