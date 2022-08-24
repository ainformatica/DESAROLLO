<?php
require_once "../clases/conexion_mantenimientos.php";
//require_once "../clases/Conexion.php";

$instancia_conexion = new conexion();



class modelo_registro_estudiantes
{

    //Insertar registros
    public function registrar($nombre,$apellidos,$sexo,$identidad,$nacionalidad,$estado,$fecha_nacimiento,$ncuenta,$tipo_estudiante,
    $trabajo, $idcarrera,$idcr){
        global $instancia_conexion;
        $sql="call proc_insertar_estudiantes_persona ('$nombre', '$apellidos', '$sexo', '$identidad', '$nacionalidad', '$estado', 
        '$fecha_nacimiento', '2', 'ACTIVO', '$ncuenta', '$tipo_estudiante', '$trabajo', '$idcarrera', '$idcr')";
        

        return $instancia_conexion->ejecutarConsulta($sql);

    }

    public function Registrar_foto($nombrearchivo){
        global $instancia_conexion;
        $sql="CALL proc_insertar_foto('$nombrearchivo')";
        
        return $instancia_conexion->ejecutarConsulta($sql);

    }

    public function Registrar_curriculum($nombrearchivo2){
        global $instancia_conexion;
        $sql="CALL proc_insertar_curriculum('$nombrearchivo2')";
        
        return $instancia_conexion->ejecutarConsulta($sql);
    }


    function listar_selectEST(){
        global $instancia_conexion;
        $consulta=$instancia_conexion->ejecutarConsulta('select * from tbl_estadocivil');

        return $consulta;
    }

    function ExisteIdentidad($identidad){
        global $instancia_conexion;
        $consulta=$instancia_conexion->ejecutarConsultaSimpleFila("SELECT EXISTS( 
        SELECT  identidad FROM tbl_personas WHERE identidad='$identidad') as existe");
      
        return $consulta;
    }

    function ExisteNCuenta($ncuenta){
        global $instancia_conexion;
        $consulta=$instancia_conexion->ejecutarConsultaSimpleFila("SELECT EXISTS(SELECT valor FROM tbl_personas_extendidas WHERE valor='$ncuenta') as existe");
      
        return $consulta;
    }
    
    function listar_selectGEN(){
        global $instancia_conexion;
        $consulta=$instancia_conexion->ejecutarConsulta('select * from tbl_genero');

        return $consulta;

    }
    
    function listar_selectNAC(){
        global $instancia_conexion;
        $consulta=$instancia_conexion->ejecutarConsulta('select * from tbl_nacionalidad');

        return $consulta;

    }

    function listar_selectCR (){
        global $instancia_conexion;
        $consulta=$instancia_conexion->ejecutarConsulta('SELECT * FROM `tbl_centros_regionales`;');
        return $consulta;
    }

    function listar_selectCAR (){
        global $instancia_conexion;
        $consulta=$instancia_conexion->ejecutarConsulta('SELECT * FROM `tbl_carrera`;');
        return $consulta;
    }

    function validardepto($codigo)
    {
        global $instancia_conexion;
        $sql4 = "call proc_existe_municipio_depto($codigo)";
        return $instancia_conexion->ejecutarConsultaSimpleFila($sql4);
    }



  
    


}