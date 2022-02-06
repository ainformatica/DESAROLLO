<?php
ob_start();

session_start();

require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');

$Id_objeto = 209;
$nueva_descripcion = mb_strtoupper($_POST['descripcion']);
$id_motivo =$_SESSION['idmotivo'];



$patron_texto = "/^[a-zA-ZáéíóúÁÉÍÓÚñäëïöüÄËÏÖÜàèìòùÀÈÌÒÙÑ012345689_\s]+$/";
if( preg_match($patron_texto, $_POST['descripcion']) )
{


                    



                        if (empty($nueva_descripcion)) {
                                echo '<script type="text/javascript">
                                swal({
                                title:"",
                                text:"no puede enviar vacia la descripcion",
                                type: "warning",
                                showConfirmButton: false,
                                timer: 3000
                                });
                        </script>';
                    } else {

                        $sql = "call proc_actualizar_dato_salida('$nueva_descripcion','$id_motivo' )";






                        $valor = "select descripcion from tbl_motivo_salida WHERE id_motivo= '$id_motivo'";
                        $result_valor = $mysqli->query($valor);
                        $valor_viejo = $result_valor->fetch_array(MYSQLI_ASSOC);

                    if ($valor_viejo['descripcion'] <> $nueva_descripcion) {
                            $Id_objeto = 209;
                            bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'LA DESCRIPCION DE LA SALIDA: ' . $valor_viejo['descripcion'] . ' POR ' . $nueva_descripcion . ' ');
                            /* Hace el query para que actualize*/

                            $resultado = $mysqli->query($sql);

                            if ($resultado == true) {
                                echo '<script type="text/javascript">
                                swal({
                                    title:"",
                                    text: "Los datos  se almacenaron correctamente",
                                    type: "success",
                                    showConfirmButton: false,
                                    timer: 3000
                                  });
                                  $(".FormularioAjax")[0].reset();
                                  window.location = "../vistas/gestion_salida_vista.php";
                              </script>';
                            } else {
                                echo '<script type="text/javascript">
                                        swal({
                                                title: "",
                                                text: "Error al actualizar lo sentimos,intente de nuevo.",
                                                type: "error",
                                                showConfirmButton: false,
                                                timer: 3000
                                        });
                                        </script>';
                            }
                        } else {
                                echo '<script type="text/javascript">
                                swal({
                                    title: "",
                                    text: "Error al actualizar lo sentimos,intente de nuevo.",
                                    type: "error",
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                            </script>';

                            } 

                             }                       
                            
}
else{   
    echo '<script type="text/javascript">
    swal({
        title:"",
        text:"El nombre solo puede contener espacios y letras",
        type: "error",
        showConfirmButton: false,
        timer: 3000
    });
    </script>';
    }         

    
ob_end_flush();
?>  