<?php
require_once('../Modelos/plan_estudio_modelo.php');

$MU = new modelo_plan();

$consulta = $MU->tabla_requisitos();
if ($consulta) {
    echo json_encode($consulta);
} else {
    echo '{
		    "sEcho": 1,
		    "iTotalRecords": "0",
		    "iTotalDisplayRecords": "0",
		    "aaData": []
		}';
}