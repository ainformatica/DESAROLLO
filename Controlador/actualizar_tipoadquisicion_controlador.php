<?php

ob_start();
session_start();

require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');

$Id_objeto = 187;
$tipo_adquisicion = mb_strtoupper($_POST['txt_tipoadquisicion']);
$id_tipo_adquisicion = $_GET['id_tipo_adquisicion'];



$patron_texto = "/^[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜ_àèìòùÀÈÌÒÙ\s]+$/";
if( preg_match($patron_texto, $_POST['txt_tipoadquisicion']) )
{


                    ///Logica para el tipo de adquisicion que se repite
                    $sqlexiste = ("select count(tipo_adquisicion) as tipo_adquisicion from tbl_tipo_adquisicion where tipo_adquisicion='$tipo_adquisicion' and id_tipo_adquisicion<>'$id_tipo_adquisicion' ;");
                    //Obtener la fila del query
                    $existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));



                    if ($existe['tipo_adquisicion'] == 1) {/*
                    header("location: ../contenidos/editarRoles-view.php?msj=1&Rol=$Rol2 ");*/

                        header("location:../vistas/mantenimiento_tipoadquisicion_vista.php?msj=1");
                    } else {

                        $sql = "call proc_actualizar_tipo_adquisicion('$tipo_adquisicion','$id_tipo_adquisicion' )";






                        $valor = "select tipo_adquisicion from tbl_tipo_adquisicion WHERE id_tipo_adquisicion= '$id_tipo_adquisicion'";
                        $result_valor = $mysqli->query($valor);
                        $valor_viejo = $result_valor->fetch_array(MYSQLI_ASSOC);

                    if ($valor_viejo['tipo_adquisicion'] <> $tipo_adquisicion) {
                            $Id_objeto = 210;
                            bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'EL TIPO ADQUISICION ' . $valor_viejo['tipo_adquisicion'] . ' POR ' . $tipo_adquisicion . ' ');
                            /* Hace el query para que actualize*/

                            $resultado = $mysqli->query($sql);

                            if ($resultado == true) {
                                echo '<script type="text/javascript">
                                swal({
                                    title:"",
                                    text: "Los datos se almacenaron correctamente",
                                    type: "success",
                                    showConfirmButton: false,
                                    timer: 3000
                                  });
                                  $(".FormularioAjax")[0].reset();
                                  window.location = "../vistas/mantenimiento_tipoadquisicion_vista.php";
                              </script>';
                            } else {
                                header("location:../vistas/mantenimiento_tipoadquisicion_vista.php?msj=3");
                            }
                        } else {
                            /* SI NO SE CAMBIO NADA;*/
                            echo '<script type="text/javascript">
                            swal({
                                title: "",
                                text: "Dato no editado.",
                                type: "error",
                                showConfirmButton: false,
                                timer: 3000
                            });
                            $(".FormularioAjax")[0].reset();
                                  window.location = "../vistas/mantenimiento_tipoadquisicion_vista.php";
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