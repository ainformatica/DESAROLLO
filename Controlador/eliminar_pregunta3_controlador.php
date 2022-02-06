 <?php

    ob_start();
    session_start();
    require '../Modelos/perfil_docente_modelo.php';
    // require_once('../clases/funcion_bitacora.php');
    // $Id_objeto = 108;
    $MU = new modelo_perfil_docentes;


    $id_persona = isset($_POST["id_persona"]) ? limpiarCadena1($_POST["id_persona"]) : "";


    $consulta = $MU->EliminarPregunta3($id_persona);
    // $rspta = $instancia_modelo->EliminarPregunta4($id_persona);

    echo $consulta;
