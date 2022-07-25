<?php

ob_start();


session_start();
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');





$Id_objeto = 211;
bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INGRESO', 'A CREAR NUEVA ADQUISICION');


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
                           window.location = "../vistas/pagina_principal_vista.php";

                            </script>';
} else {






    if (permisos::permiso_insertar($Id_objeto) == '1') {
        $_SESSION['btn_guardar_adquisicion'] = "";
    } else {
        $_SESSION['btn_guardar_adquisicion'] = "disabled";
    }


    if (isset($_REQUEST['msj'])) {
        $msj = $_REQUEST['msj'];
        // if ($msj==1)
        //     {
        //     echo '<script> alert("Lo sentimos el PRODUCTO a ingresar ya existe favor intenta con uno nuevo")</script>';
        //     }

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


                        <h1>Adquisiciones</h1>
                    </div>



                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="../vistas/gestion_adquisicion_vista.php">Gestión Adquisiciones</a></li>

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

                <form action="../Controlador/guardar_adquisicion_controlador.php" method="post" data-form="save" class="FormularioAjax" autocomplete="off">

                    <div class="card card-default ">
                        <div class="card-header center">
                            <h3 class="card-title">Nueva Adquisición</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>


                        <!-- /.card-header -->
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-6">


                                    <!-- SELECT QUE TRAE LOS PRODUCTOS -->

                                    <div class="form-group">
                                        <label>Tipo de Adquisición</label>
                                        <select class="form-control select2" style="width: 100%;" name="cmb_tipoadquisicion" required="">
                                            <option value="0">Seleccione un Tipo de Adquisición:</option>
                                            <?php
                                            $query = $mysqli->query("SELECT * FROM tbl_tipo_adquisicion");
                                            while ($resultado = mysqli_fetch_array($query)) {
                                                echo '<option value="' . $resultado['id_tipo_adquisicion'] . '"> ' . $resultado['tipo_adquisicion'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>



                                    <div class="form-group ">
                                        <label>Ingrese la descripcion de la Adquisición </label>

                                        <textarea class="form-control " class="tf w-input" required type="text" id="txt_descripcion" onkeypress="return validacion_para_producto(event)" name="txt_descripcion" maxlength="100" style="text-transform: uppercase" onkeyup="DobleEspacio(this, event); MismaLetra('txt_descripcion');"></textarea>
                                    </div>


                                    <!-- FECHA ADQUISICION -->
                                    <div class="form-group">
                                        <label>Fecha de Adquisición</label>
                                        <input type="hidden" name="id_adquisicion" id="id_adquisicion">

                                        <input type="hidden" name="id_estado" id="id_estado">
                                        <!-- <input class="form-control" type="text" id="txt_" name="txt_nombreproducto"  value="" required  onkeyup="Espacio(this, event)" style="text-transform: uppercase" maxlength="60"  onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)"> -->

                                        <input class="form-control" type="date" min="<?php date_default_timezone_set('America/Tegucigalpa');
                                                                                        echo date("Y-m-d"); ?>" max="<?php date_default_timezone_set('America/Tegucigalpa');
                                                                                                                                                                            echo date("Y-m-d"); ?>" value="<?php date_default_timezone_set('America/Tegucigalpa');
                                                                                                                                                                                                                                                                    echo date("Y-m-d"); ?>" onchange="handler(event);" name="txt_fechaAdquisicion" maxlength="30" style="text-transform: uppercase" onblur="document.getElementById('txt_nombre_oculto').value=this.value" required>




                                    </div>



                                    <p class="text-center" style="margin-top: 20px;">
                                        <button type="submit" class="btn btn-primary" id="btn_guardar_adquisicion" name="btn_guardar_adquisicion" <?php echo $_SESSION['btn_guardar_adquisicion']; ?>><i class="zmdi zmdi-floppy"></i> Guardar</button>
                                        <a href="../vistas/gestion_adquisicion_vista.php" class="btn btn-danger"><i class="zmdi zmdi-floppy"></i> Cancelar</a>
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


<script type="text/javascript" src="../plugins/moment.js"></script>
<script type="text/javascript" src="../js/validaciones_gestion_laboratorio.js"></script>

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