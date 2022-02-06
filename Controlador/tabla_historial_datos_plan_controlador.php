<?php
    require_once ('../Modelos/plan_estudio_modelo.php');

    $MU = new modelo_plan();
    
    $consulta = $MU->historial_plan_estudio_datos();
    if($consulta){
        echo json_encode($consulta);

    }else{
    echo '{
		    "sEcho": 1,
		    "iTotalRecords": "0",
		    "iTotalDisplayRecords": "0",
		    "aaData": []
		}';
    }