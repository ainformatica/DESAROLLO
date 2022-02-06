<?php
ob_start();
session_start();


require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');
require_once('../clases/conexion_mantenimientos.php');
//$registro = controlador_registro_docente::ctrRegistro();
$Id_objeto = 98;


$visualizacion = permiso_ver($Id_objeto);

$nombre = $_SESSION['usuario'];
$id_usuario = $_SESSION['id_usuario'];
if ($visualizacion == 0) {
    echo '<script type="text/javascript">
                              swal({
                                   title:"",
                                   text:"Lo sentimos no tiene permiso de visualizar la pantalla",
                                   type: "error",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                           window.location = "../vistas/menu_plan_estudio_vista.php";

                            </script>';
} else {

    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INGRESO', 'A GESTIÓN DE PLAN DE ESTUDIO.');


    if (permisos::permiso_insertar($Id_objeto) == '1') {
        $_SESSION['btn_guardar_cambio_plan'] = "";
    } else {
        $_SESSION['btn_guardar_cambio_plan'] = "disabled";
    }
}
ob_end_flush();


?>


<!DOCTYPE html>
<html>

<head>
    <script src="../js/autologout.js"></script>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

    <title></title>


</head>


<body>
    <div class="card card-default">
        <div class="content-wrapper">


            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">


                            <h1>Gestión Plan de Estudio</h1>
                        </div>

                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
                                <li class="breadcrumb-item"><a href="../vistas/menu_plan_estudio_vista.php">Menu Plan de Estudio</a></li>
                                <li class="breadcrumb-item">Gestión de Plan</li>

                            </ol>
                        </div>

                        <div class="RespuestaAjax"></div>

                    </div>
                </div><!-- /.container-fluid -->
            </section>


            <input type="text" id="id_sesion" name="id_sesion" value="<?php echo $nombre; ?>" hidden readonly>
            <input type="date" id="fecha_hoy" name="fecha_hoy" hidden readonly>

            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            <section class="content-header">
                <div class="container-fluid">
                    <!-- pantalla  -->

                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Datos Generales</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>

                            </div>

                        </div>

                        <div class="card-body" style="display: block;">
                            <div class="table-responsive" style="width: 100%;">
                                <table id="tabla_plan_estudio" class="table table-bordered table-striped" style="width:99%">
                                    <thead>
                                        <tr>
                                            <th>editar</th>
                                            <th>Cambiar vigencia</th>
                                            <th>Nombre</th>
                                            <th># Clases</th>
                                            <th>Código de plan</th>
                                            <th>Tipo de plan</th>
                                            <th>UV del plan</th>
                                            <th>Plan Vigente</th>

                                        </tr>
                                    </thead>


                                </table>
                                <br>


                            </div>
                        </div>

                    </div>
                </div>
            </section>

        </div>



        <!-- modal crear carga -->
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal_editar">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Editar Plan</h5>
                        <button class="close" data-dismiss="modal">
                            &times;
                        </button>
                    </div>


                    <div class="modal-body">
                        <input type="text" id="id_sesion" name="id_sesion" value="<?php echo $nombre; ?>" hidden readonly>
                        <input type="text" id="id_sesion_usuario" name="id_sesion_usuario" value="<?php echo $id_usuario; ?>" hidden readonly>
                        <input class="form-control" type="text" id="id_plan_estudio" name="id_plan_estudio" hidden readonly>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">

                                    <label>Seleccione Tipo de plan:</label>
                                    <td><select class="form-control" style="width: 100%;" name="cbm_tipo_plan_edita" id="cbm_tipo_plan_edita">
                                        </select></td>
                                    <!-- <input class="form-control" type="text" id="txt_id_tipo_plan" name="txt_id_tipo_plan" required readonly hidden> -->

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">

                                    <label>Nombre de Plan</label>

                                    <input class="form-control" type="text" id="txt_nombre_edita" name="txt_nombre_edita" maxlength="150" value="" onkeyup="DobleEspacio(this, event); MismaLetra('txt_nombre_edita');" onkeypress="return sololetras(event)" required>

                                    <!-- <input class=" form-control" type="text" id="txt_nombre_edita2" name="txt_nombre_edita2" maxlength="25" value="" readonly hidden> -->


                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">

                                    <label>Código de Plan</label>

                                    <input class="form-control" type="text" id="txt_codigo_plan_edita" name="txt_codigo_plan_edita" maxlength="25" required onkeyup="DobleEspacio(this, event); MismaLetra('txt_codigo_plan_edita');">
                                    <!-- <input class="form-control" type="text" id="txt_codigo_plan_edita2" name="txt_codigo_plan_edita2" maxlength="25" value="" readonly hidden> -->


                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">

                                    <label>Número de clases del plan</label>
                                    <input class="form-control" type="text" id="txt_num_clases_edita" name="txt_num_clases_edita" maxlength="2" onkeypress="return solonumeros(event)">
                                    <!-- <input class="form-control" type="text" id="txt_num_clases_edita2" name="txt_num_clases_edita2" maxlength="2" value="" readonly hidden> -->

                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">

                                    <label>Créditos del Plan</label>

                                    <input class="form-control" type="text" id="txt_creditos_plan" name="txt_creditos_plan" maxlength="3" onkeypress="return solonumeros(event)">
                                    <input class="form-control" type="text" id="txt_creditos_plan2" name="txt_creditos_plan2" maxlength="25" value="" readonly hidden>


                                </div>
                            </div>




                            <!-- <div class="col-md-4">
                                <div class="form-group">

                                    <label>Plan Vigente</label>

                                    <input class="form-control" type="text" id="txt_vigente_edita" name="txt_vigente_edita" maxlength="2" value="" required readonly>
                                    <input class="form-control" type="text" id="fecha_hoy" name="fecha_hoy" required readonly hidden>
                                    <input class="form-control" type="text" id="txt_vigente_edita2" name="txt_vigente_edita2" maxlength="2" value="" readonly hidden>


                                </div>

                            </div> -->
                            <!-- <div class="col-md-4">
                                <div class="form-group">

                                    <label>Plan Vigente</label>
                                    <div class="input-group md-4">
                                        <input type="text" class="form-control" id="txt_vigente_edita" name="txt_vigente_edita" maxlength="2" value="" required readonly>
                                        <div class="input-group-append">
                                            <button class="btn btn-success" type="" id="cambiar">Cambiar</button>
                                        </div>
                                    </div>
                                </div>
                            </div> -->

                        </div>

                    </div>



                    <div class="modal-footer">
                        <!-- <button class="btn btn-danger" name="cambiar_vigencia1" id="cambiar_vigencia1">Guardar Vigencia</button> -->
                        <button class="btn btn-primary" id="guardar" name="guardar" <?php echo $_SESSION['btn_guardar_cambio_plan']; ?>>Guardar</button>
                        <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>


</html>




<script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../js/plan_estudio_gestion.js"></script>
<script src="../js/validaciones_plan.js"></script>



<script>
    var idioma_espanol = {
        select: {
            rows: "%d fila seleccionada"
        },
        "sProcessing": "Procesando...",
        "sLengthMenu": "Mostrar _MENU_ registros",
        "sZeroRecords": "No se encontraron resultados",
        "sEmptyTable": "Ning&uacute;n dato disponible en esta tabla",
        "sInfo": "Registros del (_START_ al _END_) total de _TOTAL_ registros",
        "sInfoEmpty": "Registros del (0 al 0) total de 0 registros",
        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix": "",
        "sSearch": "Buscar:",
        "sUrl": "",
        "sInfoThousands": ",",
        "sLoadingRecords": "<b>No se encontrarón datos</b>",
        "oPaginate": {
            "sFirst": "Primero",
            "sLast": "Último",
            "sNext": "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }

    }
</script>
<script>
    $(document).ready(function() {
        TablaPlanEstudio();

    });
</script>