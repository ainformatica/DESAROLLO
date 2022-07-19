<?php

ob_start();


session_start();
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');





$Id_objeto = 211;
bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INGRESO', 'A MODIFICAR ADQUISICION');


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






    if (permisos::permiso_modificar($Id_objeto) == '1') {
        $_SESSION['btn_editar_adquisicion'] = "";
    } else {
        $_SESSION['btn_editar_adquisicion'] = "disabled";
    }
    $id_adquisicion = $_GET['id_adquisicion'];
    //  echo $id_adquisicion;
    $sql = "select TTP.id_tipo_adquisicion,TTP.tipo_adquisicion,TP.id_adquisicion as id_adquisicion,TP.descripcion_adquisicion,TP.fecha_adquisicion FROM tbl_tipo_adquisicion TTP, tbl_adquisiciones TP WHERE TP.id_tipo_adquisicion=TTP.id_tipo_adquisicion and id_adquisicion=$id_adquisicion";
    $resultado = $mysqli->query($sql);
    /* Manda a llamar la fila */
    $row = $resultado->fetch_array(MYSQLI_ASSOC);



    //    variable               viene de la BD
    $_SESSION['id_adquisicion_'] = $row['id_adquisicion'];
    $_SESSION['tipo_adquisicion_'] = $row['id_tipo_adquisicion'];
    $_SESSION['descripcion_adquisicion_'] = $row['descripcion_adquisicion'];
    // $_SESSION['id_usuario_'] = $row['id_usuario'];
    $_SESSION['fecha_adquisicion_'] = $row['fecha_adquisicion'];
    $_SESSION['nombre_tipo_adquisicion_'] = $row['tipo_adquisicion'];
    // $_SESSION['id_estado_'] = $row['id_estado'];


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


                        <h1>Actualizar Adquisiciones</h1>
                    </div>



                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="../vistas/gestion_adquisicion_vista.php">Gestion de Adquisiciones</a></li>

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

                <form action="../Controlador/actualizar_adquisicion_controlador.php" method="post" data-form="save" class="FormularioAjax" autocomplete="off">

                    <div class="card card-default ">
                        <div class="card-header center">
                            <h3 class="card-title">Editar Adquisición</h3>

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
                                        <input class="form-control" type="text" id="txt_tipo" name="txt_tipo" value="<?php echo $_SESSION['nombre_tipo_adquisicion_']; ?>" maxlength="30" readonly="true" style="text-transform: uppercase" onblur="document.getElementById('txt_nombre_oculto').value=this.value" required>
                                    </div>



                                    <div class="form-group ">
                                        <label>Editar Descripción de la Adquisición </label>
                                        <!--<input class="form-control " type="text" id="txt_descripcion" name="txt_descripcion" value="<?php echo $_SESSION['descripcion_adquisicion_']; ?>"required="" maxlength="100" style="text-transform: uppercase" onkeyup="DobleEspacio(this, event); MismaLetra('txt_descripcion);" onkeypress="return sololetras(event)"  onkeypress="return comprobar(this.value, event, this.id)"> -->
                                        <textarea class="form-control " style="text-transform: uppercase" class="tf w-input" required type="text" maxlength="100" name="txt_descripcion" id="txt_descripcion" rows="5" cols="40" onkeyup="DobleEspacio(this, event); MismaLetra('txt_descripcion');" onkeypress="return validacion_para_producto(event)"><?php echo $_SESSION['descripcion_adquisicion_']; ?></textarea>
                                    </div>


                                    <!-- FECHA ADQUISICION -->
                                    <div class="form-group">
                                        <label>Fecha de Adquisición</label>
                                        <input type="hidden" name="id_adquisicion" id="id_adquisicion">

                                        <input type="hidden" name="id_estado" id="id_estado">
                                        <!-- <input class="form-control" type="text" id="txt_" name="txt_nombreproducto"  value="" required  onkeyup="Espacio(this, event)" style="text-transform: uppercase" maxlength="60"  onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)"> -->

                                        <input class="form-control" type="date" id="txt_fechadquisicion" name="txt_fechaAdquisicion" value="<?php echo $_SESSION['fecha_adquisicion_'] ?>" maxlength="30" readonly="true" style="text-transform: uppercase" onblur="document.getElementById('txt_nombre_oculto').value=this.value" required>
                                    </div>



                                    <p class="text-center" style="margin-top: 20px;">
                                        <button type="submit" class="btn btn-primary" id="btn_editar_adquisicion" name="btn_editar_adquisicion" <?php echo $_SESSION['btn_editar_adquisicion']; ?>><i class="zmdi zmdi-floppy"></i> Guardar</button>
                                        <a href="../vistas/gestion_adquisicion_vista.php" class="btn btn-danger"><i class="zmdi zmdi-floppy"></i> Cancelar</a>
                                        <!--  <a href="../vistas/editar_detalle_adquisicion_vista.php" class="btn btn-primary"><i class="zmdi zmdi-floppy"></i>Siguiente</a> -->
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