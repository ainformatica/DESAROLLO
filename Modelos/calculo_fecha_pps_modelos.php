<?php
ob_start();
require "../clases/conexion_mantenimientos.php";
$instancia_conexion = new conexion();

Class pruebas
{
   
	public function valida_campos($nombre,$edad)
	{
		$sql="SELECT * from tb_pruebas where nombre='$nombre' and edad='$edad'";
			if (validar_select($sql))
			    {
					return true;
					# code...
				}
			else
			{
				return false;
			}
	}

	public function busqueda_fechas($fecha_inicio,$fecha_p)
	{
        global $instancia_conexion;
		$sql="SELECT COUNT(fecha) as fecha from tbl_dias_feriados WHERE fecha BETWEEN '$fecha_inicio' and '$fecha_p'";
		return $instancia_conexion->ejecutarConsultaSimpleFila($sql);
        
    }

	public function update_pps($txt_estudiante_cuenta, $obs, $tipo, $empresa, $cb_horas_practica, $fechaN, $fechaF, $hora_inicio, $hora_final, $dias)
	{
        global $instancia_conexion;
		
		$sql = "call proc_aprobacion_practica('$txt_estudiante_cuenta', '$obs', '$tipo', '$empresa', '$cb_horas_practica', '$fechaN', '$fechaF', '$hora_inicio', '$hora_final', '$dias')";
		// return $instancia_conexion->ejecutarConsulta($sql);

		if ($consulta = $instancia_conexion->ejecutarConsulta($sql)) {
           return 1;
        } else {
            return 0;
        }

		
        
    }
	
}




















ob_end_flush();

?>