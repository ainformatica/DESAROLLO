<?php
require_once('../clases/conexion_mantenimientos.php');
$instancia_conexion = new conexion();


class objetos
{ // Clase para gestionar las consultas de los objetos
    function registrar_objeto($objeto, $descripcion, $id_modulo)
    {
        global $instancia_conexion;
        $sql = "call proc_insertar_actualizar_objetos('" . $objeto . "','" . $descripcion . "'," . $id_modulo . ",0,1)";
        return $instancia_conexion->ejecutarConsulta($sql);
        # code...
    }
    function registrar_modulo($modulo, $descripcion)
    {
        global $instancia_conexion;
        $sql = "insert into tbl_modulos(nombre, descripcion) values('" . $modulo . "','" . $descripcion . "')";
        return $instancia_conexion->ejecutarConsulta($sql);
        # code...
    }
    function listar()
    {

        global $instancia_conexion;
        $sql = "
        select ob.Id_objeto,ob.objeto,ob.descripcion,m.nombre from tbl_objetos ob, tbl_modulo_objetos mob,tbl_modulos m where ob.Id_objeto=mob.id_objeto and mob.id_modulo=m.id_modulo;";
        return $instancia_conexion->ejecutarConsulta($sql);
    }
    function listar_modulos()
    {

        global $instancia_conexion;
        $sql = " select * from tbl_modulos;";
        return $instancia_conexion->ejecutarConsulta($sql);
    }

    function actualizar_objeto($id_objeto, $objeto, $descripcion, $id_modulo)
    {
        global $instancia_conexion;
        $sql = "call proc_insertar_actualizar_objetos('" . $objeto . "','" . $descripcion . "'," . $id_modulo . "," . $id_objeto . ",2)";
        return $instancia_conexion->ejecutarConsulta($sql);
    }
    function actualizar_modulo($id_modulo, $modulo, $descripcion)
    {
        global $instancia_conexion;
        $sql = "update tbl_modulos set nombre='" . $modulo . "', descripcion='" . $descripcion . "' where id_modulo=" . $id_modulo . "";
        return $instancia_conexion->ejecutarConsulta($sql);
    }
    function listar_select_modulos()
    {
        global $instancia_conexion;
        $consulta = $instancia_conexion->ejecutarConsulta('select * from tbl_modulos');

        return $consulta;
    }
    function listar_objeto_modulos()
    {
        global $instancia_conexion;
        $consulta = $instancia_conexion->ejecutarConsulta('select * from tbl_objetos o, tbl_modulo_objetos mo where o.Id_objeto=mo.Id_objeto');

        return $consulta;
    }

    function mostrar($id_objeto)
    {
        global $instancia_conexion;
        $sql = 'select ob.Id_objeto,ob.objeto,ob.descripcion,m.id_modulo from tbl_objetos ob, tbl_modulo_objetos mob,tbl_modulos m where ob.Id_objeto=' . $id_objeto . ' and ob.Id_objeto=mob.id_objeto and mob.id_modulo=m.id_modulo;';
        return $instancia_conexion->ejecutarConsultaSimpleFila($sql);
    }
    function mostrar_modulo($id_modulo)
    {
        global $instancia_conexion;
        $sql = 'select * from tbl_modulos where id_modulo=' . $id_modulo;
        return $instancia_conexion->ejecutarConsultaSimpleFila($sql);
    }

    function listar_permiso_objeto($id_rol)
    {
        global $instancia_conexion;
        $sql = 'select mo.id_modulo,mo.id_objeto,o.objeto from tbl_modulo_objetos mo, tbl_objetos o, tbl_permisos_usuarios p where mo.id_objeto=o.Id_objeto and p.Id_objeto=o.Id_objeto and p.Id_rol=' . $id_rol;
        return $instancia_conexion->ejecutarConsulta($sql);
    }
    //Trae el maximo id del modulo
    function traer_maximo_id($id_modulo){
        global $instancia_conexion;
        $sql = 'select MAX(id_objeto) from tbl_modulo_objetos where id_modulo='.$id_modulo.';';
        return $instancia_conexion->ejecutarConsultaSimpleFila($sql);

    }
}


?>