<?php
require_once('../clases/conexion_mantenimientos.php');
$instancia_conexion = new conexion();


class objetos{
    function registrar_modulo($modulo,$descripcion)
    {
        global $instancia_conexion;
		$sql="";
		return $instancia_conexion->ejecutarConsulta($sql);
        # code...
    }
    function listar(){

        global $instancia_conexion;
		$sql="
        select ob.Id_objeto,ob.objeto,ob.descripcion,m.nombre from tbl_objetos ob, tbl_modulo_objetos mob,tbl_modulos m where ob.Id_objeto=mob.id_objeto and mob.id_modulo=m.id_modulo;";
		return $instancia_conexion->ejecutarConsulta($sql);
    }
    function seleccionar_modulo($id_modulo){

        global $instancia_conexion;
        $sql='';
		return $instancia_conexion->ejecutarConsultaSimpleFila($sql);
    }
    
    function actualizar_modulo($modulo,$descripcion,$id_modulo){
        global $instancia_conexion;
		$sql="";
		return $instancia_conexion->ejecutarConsulta($sql);
    }
    function listar_select_modulos(){
        global $instancia_conexion;
        $consulta=$instancia_conexion->ejecutarConsulta('select * from tbl_modulos');

        return $consulta;

    }
   
    
}

?>