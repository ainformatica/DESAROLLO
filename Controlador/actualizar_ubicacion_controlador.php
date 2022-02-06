<?php

ob_start();
session_start();

require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');

$Id_objeto = 185;
$ubicacion = strtoupper($_POST['txt_ubicacion']);
$id_ubicacion = $_GET['id_ubicacion'];


$patron_texto = "/^[a-zA-ZáéíóúÁÉÍÓÚ_äëïöüÄËÏÖÜàèìòùÀÈÌÒÙ0123456789\s]+$/";
if( preg_match($patron_texto, $_POST['txt_ubicacion']) )
{


                ///Logica para el rol que se repite
                $sqlexiste = ("select count(ubicacion) as ubicacion  from tbl_ubicacion where ubicacion='$ubicacion' and id_ubicacion<>'$id_ubicacion' ;");
                //Obtener la fila del query
                $existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));



                if ($existe['ubicacion'] == 1) {/*
                header("location: ../contenidos/editarRoles-view.php?msj=1&Rol=$Rol2 ");*/

                    header("location:../vistas/mantenimiento_ubicacion_vista.php?msj=1");
                } else {

                    $sql = "call proc_actualizar_ubicacion('$ubicacion','$id_ubicacion' )";








                    $valor = "select ubicacion from tbl_ubicacion WHERE id_ubicacion= '$id_ubicacion'";
                    $result_valor = $mysqli->query($valor);
                    $valor_viejo = $result_valor->fetch_array(MYSQLI_ASSOC);

                if ($valor_viejo['ubicacion'] <> $ubicacion) {
                      
                        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'LA UBICACION ' . $valor_viejo['ubicacion'] . ' POR ' . $ubicacion . ' ');
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
                              window.location = "../vistas/mantenimiento_ubicacion_vista.php";
                          </script>';
                        } else {
                            header("location:../vistas/mantenimiento_ubicacion_vista.php?msj=3");
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
                        window.location = "../vistas/mantenimiento_ubicacion_vista.php";
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