<?php

ob_start();
session_start();

require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');

$Id_objeto = 189;
$estado= mb_strtoupper($_POST['txt_estado']);
$id_estado = $_GET['id_estado'];


$patron_texto = "/^[a-zA-ZáéíóúÁÉÍÓÚ_äëïöüÄËÏÖÜàèìòùÀÈÌÒÙ\s]+$/";
if( preg_match($patron_texto, $_POST['txt_estado']) )
{



            ///Logica para el tipo de adquisicion que se repite
            $sqlexiste = ("select count(estado) as estado from tbl_estado where estado='$estado' and id_estado<>'$id_estado' ;");
            //Obtener la fila del query
            $existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));



            if ($existe['estado'] == 1) {/*
            header("location: ../contenidos/editarRoles-view.php?msj=1&Rol=$Rol2 ");*/

                header("location:../vistas/mantenimiento_tipo_estado_vista.php?msj=1");
            } else {

                $sql = "call proc_actualizar_estado('$estado','$id_estado' )";






                $valor = "select estado from tbl_estado WHERE id_estado= '$id_estado'";
                $result_valor = $mysqli->query($valor);
                $valor_viejo = $result_valor->fetch_array(MYSQLI_ASSOC);

                if ($valor_viejo['estado'] <> $estado) {
                  
                    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'EL ESTADO ' . $valor_viejo['estado'] . '  POR ' . $estado . ' ');
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
                          window.location = "../vistas/mantenimiento_tipo_estado_vista.php";
                      </script>';

                    } else {
                        header("location:../vistas/mantenimiento_tipo_estado_vista.php?msj=3");
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
                    window.location = "../vistas/mantenimiento_tipo_estado_vista.php";
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