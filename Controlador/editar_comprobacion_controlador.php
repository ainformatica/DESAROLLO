<?php
ob_start();



require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');

if(isset($_POST)){
    
    $estudiante=strtoupper ($_POST['id_estudiante']);
    $clases=strtoupper ($_POST['txt_clases']);
    $porcentaje=strtoupper ($_POST['txt_promedio']);
    $verificacion=strtoupper ($_POST['cb_verificacion']);

    $update = ("UPDATE tbl_charla_practica SET clases_aprobadas='$clases', porcentaje_clases='$porcentaje', id_verificacion='$verificacion' WHERE `id_persona` = $estudiante") or die(mysqli_error($connection));
    $resultado2 = $mysqli->query($update);
    if($resultado2){
        echo '<script type="text/javascript">
            swal({
                title:"",
                text:"Comprobación guardada con exito",
                type: "success",
                showConfirmButton: false,
                timer: 4000
                });
                $(".FormularioAjax")[0];
                window.location.href = "../vistas/registrar_asignaturas_aprobadas_vista.php";
            </script>'; 
        }else{
            echo '<script type="text/javascript">
            swal({
                title:"",
                text:"Error al registrar la comprobación",
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
