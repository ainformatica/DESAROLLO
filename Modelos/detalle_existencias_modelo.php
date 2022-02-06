<?php


require_once('../clases/conexion_mantenimientos.php');



$prueba=new conexion();

class respuesta{

    public function producto($id_producto)
	{
        global $prueba;
		$sql="CALL sel_reportes_existencia_asignados3('$id_producto')";
		
		return $prueba->ejecutarConsulta($sql);
	}


    public function transaccion()
	{
        global $prueba;
		$sql="SELECT * FROM tbl_productos where id_tipo_producto='2'";
		
		return $prueba->ejecutarConsulta($sql);
	}

    public function asignacion()
	{
        global $prueba;
		$sql="SELECT per.id_persona as id_persona, CONCAT (per.nombres, ' ' ,per.apellidos) AS nombre FROM tbl_personas per WHERE per.Estado = 'ACTIVO'";
		return $prueba->ejecutarConsulta($sql);
	}

    

}





?>