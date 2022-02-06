<?php
require_once('../clases/conexion_mantenimientos.php');
$instancia_conexion = new conexion();


class permisos_objetos
{ // Clase para gestionar las consultas de los objetos
    
   //Listar los objetos y su permiso de visualizar por medio del rol
    function listar($id)
    {

        global $instancia_conexion;
        $sql = "select pu.Id_objeto, tmo.id_modulo, pu.visualizar from tbl_permisos_usuarios pu, tbl_modulo_objetos tmo, tbl_objetos o, tbl_usuarios u where u.Id_usuario=".$id." and pu.Id_rol=u.Id_rol and pu.Id_objeto=tmo.id_objeto and pu.Id_objeto=o.id_objeto;";
        return $instancia_conexion->ejecutarConsulta($sql);
    }
    

    //Listar los modulos existentes en la base de datos
    function listar_select_modulos()
    {
        global $instancia_conexion;
        $consulta = $instancia_conexion->ejecutarConsulta('select * from tbl_modulos');

        return $consulta;
    }
}


?>