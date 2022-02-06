<?php
ob_start();



require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');

if(isset($_POST)){

    $id_charla=strtoupper ($_POST['id_charla']);
    $primer_expositor=strtoupper ($_POST['cb_expositor_1']);
    $segundo_expositor=strtoupper ($_POST['cb_expositor_2']);
    $fecha_charla=strtoupper ($_POST['txt_fecha_asignada']);
    $hora_charla=strtoupper ($_POST['txt_hora_charla']);
    $cupos=strtoupper ($_POST['txt_cupos']);
    $jornada=strtoupper ($_POST['cb_jornada']);
    $nombre_charla=strtoupper ($_POST['txt_nombre_charla']);
    $periodo=strtoupper ($_POST['txt_periodo']);
    $fecha_valida=strtoupper ($_POST['txt_fecha_valida']);

    $update = ("UPDATE tbl_vinculacion_gestion_charla SET primer_expositor='$primer_expositor', segundo_expositor='$segundo_expositor', fecha_charla='$fecha_charla', hora_charla='$hora_charla', cupos='$cupos', id_jornada_charla='$jornada', estado='1', nombre_charla='$nombre_charla', periodo='$periodo', fecha_valida='$fecha_valida' WHERE `id_charla` = $id_charla") or die(mysqli_error($connection));
    $resultado2 = $mysqli->query($update);
    if($resultado2){
        echo '<script type="text/javascript">
            swal({
                title:"",
                text:"Modificación guardada con exito",
                type: "success",
                showConfirmButton: false,
                timer: 4000
                });
                $(".FormularioAjax")[0];
                window.location.href = "../vistas/gestion_charla_vista.php";
            </script>'; 
        }else{
            echo '<script type="text/javascript">
            swal({
                title:"",
                text:"Error al modificar los datos",
                type: "error",
                showConfirmButton: false,
                timer: 4000
                });
                $(".FormularioAjax")[0];
            </script>'; 
        }
    }else{
        echo '<script type="text/javascript">
                                    swal({
                                        title:"",
                                        text:"Faltan campos por llenar....",
                                        type: "error",
                                        showConfirmButton: false,
                                        timer: 1500
                                        });
                                        $(".FormularioAjax")[0];
                                    </script>'; 
    }
ob_end_flush();
?>
