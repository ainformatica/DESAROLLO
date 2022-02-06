<?php

ob_start();
session_start();

require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');

$Id_objeto = 192;
$tipo_producto = mb_strtoupper($_POST['txt_tipo_producto']);
$id_tipo_producto = $_GET['id_tipo_producto'];


$patron_texto = "/^[a-zA-ZáéíóúÁÉÍÓÚ_äëïöüÄËÏÖÜàèìòùÀÈÌÒÙ\s]+$/";
if( preg_match($patron_texto, $_POST['txt_tipo_producto']) )
{



                    ///Logica para el rol que se repite
                    $sqlexiste = ("select count(tipo_producto) as tipo_producto  from tbl_tipo_producto where tipo_producto='$tipo_producto' and id_tipo_producto<>'$id_tipo_producto' ;");
                    //Obtener la fila del query
                    $existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));



                    if ($existe['tipo_producto'] == 1) {/*
                    header("location: ../contenidos/editarRoles-view.php?msj=1&Rol=$Rol2 ");*/

                        header("location:../vistas/mantenimiento_tipo_producto_vista.php?msj=1");
                    } else {

                        $sql = "call proc_actualizar_tipo_producto('$tipo_producto','$id_tipo_producto' )";








                        $valor = "select tipo_producto from tbl_tipo_producto WHERE id_tipo_producto= '$id_tipo_producto'";
                        $result_valor = $mysqli->query($valor);
                        $valor_viejo = $result_valor->fetch_array(MYSQLI_ASSOC);

                    if ($valor_viejo['tipo_producto'] <> $tipo_producto) {
                           
                            bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'EL TIPO PRODUCTO ' . $valor_viejo['tipo_producto'] . ' POR ' . $tipo_producto . ' ');
                            /* Hace el query para que actualize*/

                            $resultado = $mysqli->query($sql);

                            if ($resultado == true) {
                                echo '<script type="text/javascript">
                                swal({
                                    title:"",
                                    text: "Los datos se almacenaron correctamente",
                                    type: "success",
                                    showConfirmButton: false,
                                    timer: 6000
                                  });
                                  $(".FormularioAjax")[0].reset();
                                  window.location = "../vistas/mantenimiento_tipo_producto_vista.php";
                              </script>';
                            } else {
                                header("location:../vistas/mantenimiento_tipo_producto_vista.php?msj=3");
                            }
                        } else {
                            /*header("location: ../contenidos/editarRoles-view.php?msj=3&Rol=$Rol2 ");*/
                            echo '<script type="text/javascript">
                            swal({
                                title: "",
                                text: "Dato no editado.",
                                type: "error",
                                showConfirmButton: false,
                                timer: 3000
                            });
                            $(".FormularioAjax")[0].reset();
                            window.location = "../vistas/mantenimiento_tipo_producto_vista.php";
                            </script>';
                            } 
                    }
}else{   
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