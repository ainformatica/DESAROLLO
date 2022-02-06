<?php
require_once('../clases/conexion_mantenimientos.php');
$instancia_conexion = new conexion();

class modelo_excel{

    

    function registrar_excel($profesor, $aula, $cod, $control, $seccion, $matri, $dias, $hr_inicio, $hr_final)
    {

        global $instancia_conexion;
        $modalidad = "1";
        $sql = "call proc_insert_import_carga('$profesor', '$aula', '$cod', '$modalidad', '$control', '$seccion','$matri', '$dias', '$hr_inicio', '$hr_final')";

        if ($consulta = $instancia_conexion->ejecutarConsulta($sql)){

          
            return 1;
            
        }else{
            return 0 ;
         
        }

     
    }

    function registrar_excel_preliminar($profesor, $aula, $cod, $seccion, $matri, $dias, $hr_inicio, $hr_final)
    {

        global $instancia_conexion;
        $modalidad = "1";
        $sql = "call proc_insert_import_carga_preliminar('$profesor', '$aula', '$cod', '$modalidad', '$seccion','$matri', '$dias', '$hr_inicio', '$hr_final')";

        if ($consulta = $instancia_conexion->ejecutarConsulta($sql)) {


           
            return 1;
            
        } else {
            return 0;
           
        }
    }
}
