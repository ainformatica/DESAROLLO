<?php

ob_start();


session_start();
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');





$Id_objeto = 194;
bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'Ingresó', 'A Nuevo producto');


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






    if (permisos::permiso_insertar($Id_objeto) == '1') {
        $_SESSION['btn_guardar_producto'] = "";
    } else {
        $_SESSION['btn_guardar_producto'] = "disabled";
    }


    if (isset($_REQUEST['msj'])) {
        $msj = $_REQUEST['msj'];
        if ($msj == 1) {
            echo '<script> alert("¡Lo sentimos! El PRODUCTO a ingresar ya existe, favor intenta con uno nuevo")</script>';
        }

        if ($msj == 2) {
            echo '<script> alert("Producto agregado correctamente")</script>';
        }
    }
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


                        <h1>Productos</h1>
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

                <form action="../Controlador/guardar_producto_controlador.php" method="post" data-form="notificar" class="FormularioAjaxProducto" autocomplete="off">

                    <div class="card card-default ">
                        <div class="card-header center">
                            <h3 class="card-title">Nuevo Producto</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>


                        <!-- /.card-header -->
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-6">

                                    <div class="form-group ">
                                        <label>Ingrese el Nombre del Producto</label>
                                        <input class="form-control " class="tf w-input" required type="text" id="txt_nombre_producto" onkeypress="return validacion_para_producto(event)" name="txt_nombre_producto" maxlength="50" style="text-transform: uppercase" onkeyup="DobleEspacio(this, event); MismaLetra('txt_nombre_producto');">

                                    </div>



                                    <div class="form-group ">
                                        <label>Ingrese la Descripción del Producto</label>
                                        <input class="form-control " class="tf w-input" required type="text" id="txt_descripcion" onkeypress="return validacion_para_producto(event)" name="txt_descripcion" maxlength="100" style="text-transform: uppercase" onkeyup="DobleEspacio(this, event); MismaLetra('txt_descripcion');">

                                    </div>

                                    <!-- SELECT QUE TRAE LOS PRODUCTOS -->

                                    <div class="form-group">
                                        <label>Tipo de Producto</label>
                                        <select class="form-control select2" style="width: 100%;" name="cmb_tipoproducto" id="cmb_tipoproducto" required>
                                            <option>Seleccione un Tipo de Producto:</option>
                                            <?php
                                            $query = $mysqli->query("SELECT * FROM tbl_tipo_producto");
                                            while ($resultado = mysqli_fetch_array($query)) {
                                                echo '<option value="' . $resultado['id_tipo_producto'] . '"> ' . $resultado['tipo_producto'] . '</option>';
                                            }


                                            ?>
                                        </select>
                                    </div>


                                    <!-- STOCK DEL PRODUCTO -->
                                    <div class="form-group ">
                                        <label>Stock Mínimo</label>
                                        <input class="form-control" value="0" readonly=false style="height:28px; width:70px;" min="0" max="100" required type="number" id="stock" name="stock" placeholder="0" size="20">
                                        <!-- <input id="d" disabled="disabled" type="text" value="test"> -->

                                    </div>



                                    <p class="text-center" style="margin-top: 20px;">
                                        <button type="submit" class="btn btn-primary" id="btn_guardar_producto" name="btn_guardar_producto" <?php echo $_SESSION['btn_guardar_producto']; ?>><i class="zmdi zmdi-floppy"></i> Guardar</button>

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