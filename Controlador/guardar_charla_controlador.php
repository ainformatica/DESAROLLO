<?php
ob_start();

session_start();
$Id_objeto = 276;
require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');

if(isset($_POST['cb_expositor_1'])){

// var_dump($_POST);

// return false;    
$primer_expositor=strtoupper ($_POST['cb_expositor_1']);
$segundo_expositor=strtoupper ($_POST['cb_expositor_2']);
$fecha_charla=strtoupper ($_POST['txt_fecha_asignada']);
$hora_charla=strtoupper ($_POST['txt_hora_charla']);
$cupos=strtoupper ($_POST['txt_cupos']);
$jornada=strtoupper ($_POST['cb_jornada']);
$nombre_charla=strtoupper ($_POST['txt_nombre_charla']);
$periodo=strtoupper ($_POST['txt_periodo']);
$fecha_valida=strtoupper ($_POST['txt_fecha_valida']);


    if($primer_expositor!=="" && $segundo_expositor!=="" && $fecha_charla!=="" && $hora_charla!=="" && $cupos!=="" && $jornada!=="" && $nombre_charla!=="" && $periodo!=="" && $fecha_valida!==""){ 
    
        $sql= "INSERT INTO tbl_vinculacion_gestion_charla (primer_expositor, segundo_expositor, fecha_charla, hora_charla, cupos, id_jornada_charla, estado, nombre_charla, periodo, fecha_valida)
                                VALUES ('$primer_expositor', '$segundo_expositor', '$fecha_charla', '$hora_charla', '$cupos', '$jornada', '1', '$nombre_charla', '$periodo', '$fecha_valida')";
        $resultadop = $mysqli->query($sql);
    
        if($resultadop){
            echo '<script type="text/javascript">
            swal({
                title:"",
                text:"Charla registrada con exito",
                type: "success",
                showConfirmButton: false,
                timer: 4000
                });
                $(".FormularioAjax")[0];
            </script>'; 
        }else{
            echo '<script type="text/javascript">
            swal({
                title:"",
                text:"Error al registrar la charla",
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
}  
ob_end_flush();
?>
