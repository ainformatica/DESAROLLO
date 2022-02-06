<?php
session_start();
ob_start();
header("Content-Type:application/json");

require_once('../clases/funcion_bitacora.php');
require_once('../clases/Conexion.php');

$result = [];
//Verificacion de control de asistencia


if (isset($_GET['id'])) {

	$id=$_GET['id'];
	$consulta="SELECT id_charla, p1.nombres AS expositor1, p2.nombres AS expositor2, fecha_charla, hora_charla, cupos, nombre_charla, fecha_valida, tbl_jornada_charla.jornada_charla, tbl_vinculacion_gestion_charla.estado
		 FROM tbl_vinculacion_gestion_charla INNER JOIN tbl_personas p1
		 ON tbl_vinculacion_gestion_charla.primer_expositor=p1.id_persona
		 INNER JOIN tbl_jornada_charla ON tbl_jornada_charla.id_jornada_charla = tbl_vinculacion_gestion_charla.id_jornada_charla
		 INNER JOIN tbl_personas p2
		 ON tbl_vinculacion_gestion_charla.segundo_expositor=p2.id_persona 
		 WHERE tbl_vinculacion_gestion_charla.estado = 1 and id_charla='$id'";
			
		$data=$mysqli->query($consulta);

		$query1="select CONCAT(date_format(sysdate(), '%Y'), date_format(sysdate(), '%m'),CASE
							WHEN contador < 10 THEN concat('00',contador+1)
							WHEN contador >= 10 AND contador < 100 THEN concat('0',contador+1)
							ELSE
							contador +1
						
							END) as contador from tbl_contador_constancia where id_contador =1";
		
	
		$query2="select CONCAT(date_format(sysdate(), '%Y'), date_format(sysdate(), '%m'),CASE
		WHEN contador < 10 THEN concat('00',contador+1)
		WHEN contador >= 10 AND contador < 100 THEN concat('0',contador+1)
		ELSE
		contador +1
	
	END) as contador from tbl_contador_constancia where id_contador =2";			
		$cons_matutina=$mysqli->query($query1);
		$matutina=mysqli_fetch_assoc ($cons_matutina);
		$cons_vespertina=$mysqli->query($query2);
		$vespertina=mysqli_fetch_assoc ($cons_vespertina);
		$charla=mysqli_fetch_assoc($data);

		array_push($charla,$matutina,$vespertina);
		echo json_encode($charla);

		// 


		return false;

}

if (isset($_GET['charla'])) {

	$charla=$_GET['charla'];
	$consulta="SELECT CONCAT(p.nombres,' ',p.apellidos) AS nombre, px.valor AS valor, p.id_persona, cp.Id_charla 
					FROM tbl_personas p, tbl_charla_practica cp , tbl_personas_extendidas px, tbl_vinculacion_gestion_charla wr
			   WHERE  px.id_persona=p.id_persona 
			   AND cp.id_persona=p.id_persona and cp.charla_id=wr.id_charla  AND cp.estado_asistencia_charla = 0";
			

		$consulta2=	"SELECT id_charla, tbl_personas.nombres AS expositor1, p2.nombres AS expositor2, fecha_charla, hora_charla, cupos, nombre_charla, tbl_jornada_charla.jornada_charla, tbl_vinculacion_gestion_charla.estado
			FROM tbl_vinculacion_gestion_charla INNER JOIN tbl_personas
			ON tbl_vinculacion_gestion_charla.primer_expositor=tbl_personas.id_persona
			INNER JOIN tbl_jornada_charla ON tbl_jornada_charla.id_jornada_charla = tbl_vinculacion_gestion_charla.id_jornada_charla
			INNER JOIN tbl_personas p2
			ON tbl_vinculacion_gestion_charla.segundo_expositor=p2.id_persona 
			WHERE tbl_vinculacion_gestion_charla.estado = 1 and id_charla='$charla'";

		$data=$mysqli->query($consulta);
		$data2=$mysqli->query($consulta2);
				
		$charla=mysqli_fetch_assoc($data2);
		$alumnos=mysqli_fetch_all($data);

		$array=['charla'=>$charla,'alumnos'=>$alumnos];
		
		// array_push($charla, $alumnos);
		echo json_encode($array);

		// 


		return false;

}

if (isset($_GET['ruby'])){
	$res=array("asiste"=>"si","estado"=>200);
	$idAlumno=$_GET['ruby'];
	$asintencia=$_GET['asiste'];

	if ($asintencia==1) {
		$sql="UPDATE tbl_charla_practica 
			SET estado_asistencia_charla=1,charla_impartida=1 WHERE id_persona = $idAlumno";
		$resultado = $mysqli->query($sql);
		echo json_encode($res);
	}else{
		$sql="UPDATE tbl_charla_practica 
			SET estado_asistencia_charla=0,charla_impartida=0 WHERE id_persona = $idAlumno";
		$resultado = $mysqli->query($sql);
		$res=array("asiste"=>"no","estado"=>500);
		echo json_encode($res);
	}
	

}

if (isset($_GET['python'])){
	$res=array("asiste"=>"si","estado"=>200);
	$idAlumno=$_GET['python'];
	
	$sql="SELECT tb1.estado_asistencia_charla,tb1.charla_impartida FROM tbl_charla_practica tb1 
				INNER JOIN tbl_personas tb2
				ON tb1.id_persona=tb2.id_persona
				INNER JOIN tbl_usuarios tb3
				ON tb1.id_persona=tb3.id_persona
		  WHERE tb3.Id_usuario in($idAlumno)";
	$data = $mysqli->query($sql);
	$res=mysqli_fetch_assoc($data);

	echo json_encode($res);
}


if (isset($_GET['perl'])){
	$res=array("asiste"=>"si","estado"=>200);
	$idAlumno=$_GET['perl'];
	
	$sql="SELECT tb1.estado_asistencia_charla,tb1.charla_impartida FROM tbl_charla_practica tb1 
				INNER JOIN tbl_personas tb2
				ON tb1.id_persona=tb2.id_persona
				INNER JOIN tbl_usuarios tb3
				ON tb1.id_persona=tb3.id_persona
		  WHERE tb3.Id_usuario in($idAlumno)";
	$data = $mysqli->query($sql);
	$res=mysqli_fetch_assoc($data);

	echo json_encode($res);
}






