<?php

ob_start();
session_start();

require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');

$Id_objeto = 218;

$id_detalle_caracteristica = $_GET['id_detalle_caracteristica'];

$id_detalle = $_SESSION['id_detalle_'];

$valor = $_POST['txt_valor'];


        //obtener el nombre caracteristica
        $sql = "SELECT a.validacion as validacion from tbl_tipo_caracteristica a INNER JOIN tbl_caracteristicas_producto b INNER JOIN tbl_detalle_caracteristica c WHERE b.id_caracteristica_producto = c.id_caracteristica_producto AND b.id_tipo_caracteristica = a.id_tipo_caracteristica AND c.id_detalle_caracteristica = $id_detalle_caracteristica";
        $resultado = $mysqli->query($sql);
        $row = $resultado->fetch_array(MYSQLI_ASSOC);
        $validacion=$row['validacion'];


  if ($validacion==1){
        $patron_texto = "/^[a-zA-Z-_áéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙ\s]+$/";
    }
    elseif ($validacion==2){
            $patron_texto = "/^[0123456789\s]+$/";
       }
       elseif ($validacion==3){
            $patron_texto = "/^[a-zA-Z-_áéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙ0123456789\s]+$/";
         }

echo $patron_texto;



if (preg_match($patron_texto,$_POST['txt_valor'])){

    $sql = "call proc_actualizar_valor('$valor' ,'$id_detalle_caracteristica' )";

    $sqlvalor = "select valor_caracteristica from tbl_detalle_caracteristica WHERE id_detalle_caracteristica= '$id_detalle_caracteristica'";
    $result_valor = $mysqli->query($sqlvalor);
    $valor_viejo = $result_valor->fetch_array(MYSQLI_ASSOC);

    if ($valor_viejo['valor_caracteristica'] <> $valor ) {


        
        $resultado = $mysqli->query($sql);
        
        // bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' EL VALOR ' . $valor_viejo['valor'] . 'Y POR ' . $genero . ', LA DESCRIPCION DEL GÉNERO ' . $valor . ' ');


                    
                        /* Hace el query para que actualize*/
                        if ($resultado == true) {
                          
                            header("location:../vistas/editar_detalle_adquisicion_vista.php?id_detalle=$id_detalle&msj=8");



                        } else {
                            header("location:../vistas/editar_detalle_adquisicion_vista.php?id_detalle=$id_detalle&msj=9");
                        }
                    } else {
                        /*header("location: ../contenidos/editarRoles-view.php?msj=3&Rol=$Rol2 ");*/
                        header("location:../vistas/editar_detalle_adquisicion_vista.php?id_detalle=$id_detalle&msj=9");

                        }
} else {
            
    header("location:../vistas/editar_detalle_adquisicion_vista.php?id_detalle=$id_detalle&msj=10");
            
    }
               
                        
    ob_end_flush();

    ?>
         



