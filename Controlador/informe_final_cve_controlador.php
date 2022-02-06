<?php 
ob_start();
session_start();

require_once ('../clases/funcion_permisos.php');
require_once ('../clases/Conexion.php');

require_once ('../clases/funcion_visualizar.php');
require_once "../Modelos/informe_final_cve_modelo.php";
require_once ('../clases/funcion_bitacora.php');

$informe_final=new informe();
$Id_objeto=8236; 
if (permisos::permiso_eliminar($Id_objeto)==0)
  {
    $_SESSION["btneliminar"]="hidden";
  }
else
  {
    $_SESSION["btneliminar"]="";
  }
  if (permisos::permiso_modificar($Id_objeto)==0)
  {
    $_SESSION["btnmodificar"]="hidden";
  }
else
  {
    $_SESSION["btnmodificar"]="";
  }


$id_informe_anual=isset($_POST["id_informe_anual"])? $instancia_conexion->limpiarCadena($_POST["id_informe_anual"]):"";
$intro=isset($_POST["introduccion"])? $instancia_conexion->limpiarCadena($_POST["introduccion"]):"";
$objetivos=isset($_POST["objetivos"])? $instancia_conexion->limpiarCadena($_POST["objetivos"]):"";
$conclu=isset($_POST["conclu"])? $instancia_conexion->limpiarCadena($_POST["conclu"]):"";
$recomendaciones=isset($_POST["reco"])? $instancia_conexion->limpiarCadena($_POST["reco"]):"";

$año=isset($_POST["año"])? $instancia_conexion->limpiarCadena($_POST["año"]):"";

$hoy = date("Y-m-d");

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($id_informe_anual)){

			//LOGICA PARA EL NOMBRE QUE SE REPITE
			$sqlexiste=("select count(año) as año  from tbl_voae_informe_anual where año='$año' and id_informe_anual<>'$id_informe_anual' ");
			//OBTENER LA ULTIMA FILA DEL QUERY
			$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));

			//CONDICION PARA QUE NO SE REPITA EL NOMBRE
			if ($existe['año']== 1) {
				echo 'EL INFORME YA EXISTE, INGRESE UNO DIFERENTE';

			} else {
				//SE MANDA A LA BITACORA LA ACCION DE INSERTAR
				$rspta=$informe_final->insertar($hoy,$intro,$objetivos,$conclu,$recomendaciones,$año);
				echo $rspta ? "INFORME REGISTRADO" : "El Informe  no se pudo registrar";
				bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INSERTO', 'EL INFORME DE ACTIVIDADES DEL AÑO "' . $año . '"');
			}

		} else {
			//LOGICA PARA EL NOMBRE QUE SE REPITE
			$sqlexiste = ("select count(año) as año from tbl_voae_informe_anual where año ='$año' and id_informe_anual <>'$id_informe_anual' ;");
			//Obtener la fila del query
			$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));

			if ($existe['año'] == 1) {
				echo 'EL INFORME YA EXISTE, INGRESE UNO DIFERENTE';

			} else {
				
				//EXTRAEMOS LOS VALORES VIEJOS DE LA BASE DE DATOS QUE SE VAN A MODIFICAR		
				$valor = "select id_informe_anual, introduccion, objetivos, conclusiones,recomendaciones, año from tbl_voae_informe_anual WHERE id_informe_anual= '$id_informe_anual'";
				$result_valor = $mysqli->query($valor);
				$valor_viejo = $result_valor->fetch_array(MYSQLI_ASSOC);

				//CONDICION PARA LA MODIFICACION DE TODO
				if ($valor_viejo['introduccion'] <> $intro and $valor_viejo['objetivos'] <> $objetivos and $valor_viejo['conclusiones'] <> $conclu and $valor_viejo['recomendaciones'] <> $recomendaciones and $valor_viejo['año'] <> $año) {
					bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' LA INTRODUCCION, LOS OBJETIVOS, RECOMENACIONES Y LAS CONCLUSIONES DEL INFORME ANUAL CVE DEL AÑO "' . $año. '');

					$rspta=$informe_final->editar($id_informe_anual,$hoy,$intro,$objetivos,$conclu,$recomendaciones,$año);
					echo $rspta ? "INFORME ACTUALIZADO" : "NO SE PUDO ACTUALIZAR";

				//CONDICION PARA LA MODIFICACION DE LA INTRO
				} elseif ($valor_viejo['introduccion'] <> $intro) {
					bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' LA INTRODUCCION DEL INFORME ANUAL CVE DEL AÑO: "' . $año . '');

					$rspta=$informe_final->editar($id_informe_anual,$hoy,$intro,$objetivos,$conclu,$recomendaciones,$año);
					echo $rspta ? "INFORME ACTUALIZADO" : "NO SE PUDO ACTUALIZAR";

				//CONDICION PARA LA MODIFICACION OBJETIVOS
				} elseif ($valor_viejo['objetivos'] <> $objetivos) {
				bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' LOS OBJETIVOS DEL INFORME ANUAL CVE DEL AÑO: "' . $año . '');

				$rspta=$informe_final->editar($id_informe_anual,$hoy,$intro,$objetivos,$conclu,$recomendaciones,$año);
					echo $rspta ? "INFORME ACTUALIZADO" : "NO SE PUDO ACTUALIZAR";

				//CONDICION PARA LA MODIFICACION CONCLU
				}elseif ($valor_viejo['conclusiones'] <> $conclu) {
				bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' LAS CONCLUSIONES DEL INFORME ANUAL CVE DEL AÑO: "' . $año . '');
				
				$rspta=$informe_final->editar($id_informe_anual,$hoy,$intro,$objetivos,$conclu,$recomendaciones,$año);
					echo $rspta ? "INFORME ACTUALIZADO" : "NO SE PUDO ACTUALIZAR";

				//CONDICION PARA LA MODIFICACION RECOMENDACIONES
				}elseif ($valor_viejo['recomendaciones'] <> $recomendaciones) {
				bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' LAS RECOMENDACIONES DEL INFORME ANUAL CVE DEL AÑO: "' . $año . '');
				
				$rspta=$informe_final->editar($id_informe_anual,$hoy,$intro,$objetivos,$conclu,$recomendaciones,$año);
					echo $rspta ? "INFORME ACTUALIZADO" : "NO SE PUDO ACTUALIZAR";

				} elseif ($valor_viejo['año'] <> $año) {
				bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' EL AÑO DEL INFORME ANUAL CVE DEL AÑO: "' . $año . '');
				
				$rspta=$informe_final->editar($id_informe_anual,$hoy,$intro,$objetivos,$conclu,$recomendaciones,$año);
					echo $rspta ? "INFORME ACTUALIZADO" : "NO SE PUDO ACTUALIZAR";
				}

			}
		} //FIN
	break;


	case 'mostrar':

		$rspta=$informe_final->mostrar($id_informe_anual);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'eliminar':
		
		$valor = "select año from tbl_voae_informe_anual where id_informe_anual= '$id_informe_anual'";
	    $result_valor = $mysqli->query($valor);
	    $bt_nombre_ambito = $result_valor->fetch_array(MYSQLI_ASSOC);

    	//SE MANDA A LA BITACORA LA ACCION DE ACTIVAR EL AMBITO
 		bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'ELIMINO', 'EL INFORME ANUAL CVE DEL AÑO: ' . $bt_nombre_ambito['año'] . '');
		$rspta=$informe_final->eliminar($id_informe_anual);
 		echo $rspta ? "REGISTRO ELIMINADO" : "Error";

	break;


	case 'listar':
	
	
 		$rspta=$informe_final->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(

 				"0"=>'<button  class="btn btn-warning" '.$_SESSION['btnmodificar'].' style="display:inline;"  onclick="mostrar('.$reg->id_informe_anual.')"><i class="far fa-edit"></i></button>'.
 					 ' <form action="../Controlador/../Controlador/generar_reporte_pdf_controlador.php" method="POST" style="display:inline;">
					   <input type="hidden" name="id_informe_anual" value="'.$reg->id_informe_anual.'">
					   <input type="hidden" name="año" value="'.$reg->año.'">
					   <input type="hidden" name="introduccion" value="'.$reg->introduccion.'">
					   <input type="hidden" name="objetivos" value="'.$reg->objetivos.'">
					   <input type="hidden" name="conclu" value="'.$reg->conclusiones.'">
					   <input type="hidden" name="reco" value="'.$reg->recomendaciones.'">
					   <button title="Generar PDF"  class="btn btn-danger"  type="submit" ><i class="fas fa-file-pdf"></i></button></form>'.
 					 ' <button class="btn btn-danger" '.$_SESSION['btneliminar'].' style="display:inline;"   onclick="eliminar('.$reg->id_informe_anual.')"><i class="fas fa-trash-alt"></i></button>',
 				"1"=>$reg->año,
 				"2"=>$reg->fecha_creacion			
 			);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
	

break;
ob_end_flush();
}



