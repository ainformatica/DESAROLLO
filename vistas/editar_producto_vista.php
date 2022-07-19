<?php

ob_start();


session_start();
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');



$Id_objeto = 194;


$visualizacion = permiso_ver($Id_objeto);



if ($visualizacion == 0) {
    //header('location:  ../vistas/menu_roles_vista.php');

    echo '<script type="text/javascript">
                              swal({
                                   title:"",
                                   text:"¡Lo sentimos! No tiene permiso de visualizar la pantalla",
                                   type: "error",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                           window.location = "../vistas/menu_roles_vista.php";

                            </script>';
} else {


    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'Ingresó', 'A EDITAR PRODUCTO');


    if (permisos::permiso_modificar($Id_objeto) == '1') {
        $_SESSION['btn_actualizar_producto'] = "";
    } else {
        $_SESSION['btn_actualizar_producto'] = "disabled";
    }

    $nombre_producto = $_GET['nombre_producto'];

    $sql = "select TTP.id_tipo_producto,TTP.tipo_producto,TP.id_producto as id_producto,TP.nombre_producto,TP.descripcion_producto,TP.stock_minimo FROM tbl_tipo_producto TTP, tbl_productos TP WHERE TP.id_tipo_producto=TTP.id_tipo_producto and nombre_producto='$nombre_producto'";

    $resultado = $mysqli->query($sql);
    /* Manda a llamar la fila */
    $row = $resultado->fetch_array(MYSQLI_ASSOC);

    //         variable               viene de la BD
    $_SESSION['id_producto_'] = $row['id_producto'];
    $_SESSION['nombre_producto_'] = $row['nombre_producto'];
    $_SESSION['descripcion_producto_'] = $row['descripcion_producto'];

    $_SESSION['stock_minimo_'] = $row['stock_minimo'];
    $_SESSION['tipo_producto_'] = $row['id_tipo_producto'];
    $_SESSION['nombre_tipo_producto_'] = $row['tipo_producto'];
}


ob_end_flush();


?>


<!DOCTYPE html>
<html>

<head>
    <script src="../js/autologout.js"></script>
    <title></title>



</head>

<body>


    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">


                        <h1>Actualización de Productos</h1>
                    </div>



                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="../vistas/gestion_producto_vista.php">Gestión de Productos</a></li>

                        </ol>
                    </div>

                    <div class="RespuestaAjax"></div>

                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid ">
                <!-- pantalla 1 -->

                <form action="../Controlador/actualizar_producto_controlador.php" method="post" data-form="notificar" class="FormularioAjaxProducto" autocomplete="off">

                    <div class="card card-default ">
                        <div class="card-header center">
                            <h3 class="card-title">Editar Producto</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>


                        <!-- /.card-header -->
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label>Modificar Nombre </label>

                                        <input class="form-control" class="tf w-input" type="text" id="txt_nombre_producto" name="txt_nombre_producto" onkeypress="return validacion_para_producto(event)" value="<?php echo $_SESSION['nombre_producto_']; ?>" required style="text-transform: uppercase" onkeyup="DobleEspacio(this, event); MismaLetra('txt_nombre_producto');" maxlength="50">


                                        <input class="form-control" type="hidden" id="txt_" name="txt_" value="<?php echo $_SESSION['id_producto_']; ?>">


                                    </div>

                                    <div class="form-group">

                                        <label>Descripción del Producto </label>


                                        <input class="form-control" class="tf w-input" type="text" id="txt_descripcion" name="txt_descripcion" onkeypress="return validacion_para_producto(event)" value="<?php echo $_SESSION['descripcion_producto_']; ?>" maxlength="100" required style="text-transform: uppercase" onkeyup="DobleEspacio(this, event); MismaLetra('txt_descripcion');">

                                    </div>

                                    <!-- SELECT QUE TRAE EL TIPO DE PRODUCTO -->

                                    <div class="form-group ">
                                        <label class="control-label">Tipos de Productos</label>
                                        <select class="form-control" id="cmb_tipoproducto2" name="cmb_tipoproducto2" disabled required="">
                                            <option value="0">Seleccione un Tipo:</option>
                                            <?php
                                            // $_SESSION['tipo_producto_'] = $row['id_tipo_producto'];

                                            if (isset($_SESSION['tipo_producto_'])) {
                                                $query = $mysqli->query("select * FROM tbl_tipo_producto where id_tipo_producto<>$_SESSION[tipo_producto_] ");
                                                while ($resultado = mysqli_fetch_array($query)) {

                                                    echo '<option value="' . $resultado['id_tipo_producto'] . '"  > ' . $resultado['tipo_producto'] . '</option>';
                                                }


                                                echo '<option value="' . $_SESSION['tipo_producto_'] . '" selected="" >  ' . $_SESSION['nombre_tipo_producto_'] . '</option>';
                                            } else {
                                                $query = $mysqli->query("select * FROM tbl_tipo_producto");
                                                while ($resultado = mysqli_fetch_array($query)) {
                                                    //$nombre_tipo_producto= $row['tipo_producto'];
                                                    echo '<option value="' . $_SESSION['tipo_producto_'] . '" selected="" >  ' . $_SESSION['nombre_tipo_producto_'] . '</option>';
                                                }
                                            }
                                            //$_SESSION['nombre_tipo_producto_'] = $row['tipo_producto'];

                                            if ($_SESSION['tipo_producto_'] == 1) {
                                                $_SESSION['disabled'] = "disabled";
                                            } else {
                                                $_SESSION['disabled'] = "";
                                            }

                                            ?>
                                        </select>
                                    </div>


                                    <!-- STOCK DEL PRODUCTO -->
                                    <div class="form-group ">
                                        <label>Stock Mínimo</label>
                                        <input class="form-control" value="<?php echo $_SESSION['stock_minimo_']; ?>" <?php echo $_SESSION['disabled']; ?> style="height:28px; width:70px;" min="0" max="100" type="number" id="stock2" name="stock2" placeholder="" size="20">
                                    </div>




                                    <p class="text-center" style="margin-top: 20px;">
                                        <button type="submit" class="btn btn-primary" id="btn_actualizar_producto" name="btn_actualizar_producto" <?php echo $_SESSION['btn_actualizar_producto']; ?>><i class="zmdi zmdi-floppy"></i> Guardar</button>

                                        <a href="../vistas/gestion_producto_vista.php" class="btn btn-danger"><i class="zmdi zmdi-floppy"></i> Cancelar</a>
                                    </p>
                                </div>
                            </div>
                        </div>



                        <!-- /.card-body -->
                        <div class="card-footer">

                        </div>
                    </div>



                    <div class="RespuestaAjax"></div>
                </form>

            </div>
        </section>

    </div>





</body>

</html>

<script type="text/javascript" src="../js/validaciones_gestion_laboratorio.js"></script>
<script type="text/javascript" src="../js/main_gestion_lab.js"></script>

<script type="text/javascript" src="../js/pdf_mantenimientos.js"></script>
<script src="../plugins/select2/js/select2.min.js"></script>
<!-- datatables JS -->
<script type="text/javascript" src="../plugins/datatables/datatables.min.js"></script>
<!-- para usar botones en datatables JS -->
<script src="../plugins/datatables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>
<script src="../plugins/datatables/JSZip-2.5.0/jszip.min.js"></script>
<script src="../plugins/datatables/pdfmake-0.1.36/pdfmake.min.js"></script>
<script src="../plugins/datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
<script src="../plugins/datatables/Buttons-1.5.6/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="../js/funciones_registro_docentes.js"></script>
<script type="text/javascript" src="../js/validar_registrar_docentes.js"></script>