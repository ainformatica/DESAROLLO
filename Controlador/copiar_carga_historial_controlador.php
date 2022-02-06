<?php
    require '../Modelos/tabla_carga_modelo.php';

    require_once('../clases/funcion_bitacora.php');
    $Id_objeto = 48;
    $MU = new modeloCarga();

    $id_periodo_antiguo = $_POST['id_periodo'];
    $id_periodo_nuevo = $_POST['id_periodo_nuevo_'];


    $consulta = $MU->insertar_copia_carga($id_periodo_nuevo, $id_periodo_antiguo);

    echo $consulta;

    if ($consulta == 1) {
    # code...
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INSERTO', 'UNA CARGA ANTIGUA A UN PERIODO NUEVO');

        
    }
