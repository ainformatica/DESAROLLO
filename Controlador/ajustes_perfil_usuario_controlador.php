<?php
require_once "../Modelos/ajustes_perfil_usuario_modelo.php";

$id_persona = isset($_POST["id_persona"]) ? limpiarCadena1($_POST["id_persona"]) : "";
$telefono = isset($_POST["telefono"]) ? limpiarCadena1($_POST["telefono"]) : "";
$correo = isset($_POST["correo"]) ? limpiarCadena1($_POST["correo"]) : "";


$instancia_modelo = new ajustes_perfil_modelo();

if (isset($_GET['op'])) {

    switch ($_GET['op']) {
        case 'CargarDatos':
            $rspta = $instancia_modelo->mostrar($id_persona);
            //echo '<pre>';print_r($rspta);echo'</pre>';
            //Codificar el resultado utilizando json
            echo json_encode($rspta);
            break;

        case 'Cargartelefono':
            $rspta = $instancia_modelo->mostrarTelefono($id_persona);
            //echo '<pre>';print_r($rspta);echo'</pre>';
            //Codificar el resultado utilizando json
            echo json_encode($rspta);
            break;

        case 'CargarCorreo':
            $rspta = $instancia_modelo->mostrarCorreo($id_persona);
            //echo '<pre>';print_r($rspta);echo'</pre>';
            //Codificar el resultado utilizando json
            echo json_encode($rspta);
            break;
        case 'modificar_informacion':
            $rspta = $instancia_modelo->modificar_informacion_perfil($telefono, $id_persona, $correo);
            //Codificar el resultado utilizando json
            echo json_encode($rspta);
            break;
        case 'CambiarFoto':


            $ruta_carpeta = "../Imagenes_Perfil_Usuario/";
            $nombre_archivo = "imagen" . date("dHis") . "." . pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION);


            $ruta_guardar_archivo = $ruta_carpeta . $nombre_archivo;
            //echo $ruta_guardar_archivo;
            move_uploaded_file($_FILES["imagen"]["tmp_name"], $ruta_guardar_archivo);
            $rspta = $instancia_modelo->CambiarFoto($ruta_guardar_archivo, $id_persona);
            echo json_encode($ruta_guardar_archivo);



            break;
    }
}
