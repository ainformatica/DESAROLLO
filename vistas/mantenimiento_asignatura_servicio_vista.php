<?php
ob_start();
session_start();
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');





$Id_objeto = 110;

bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'Ingreso', 'A MANTENIMIENTO/ASIGNATURA DE SERVICIO');



$visualizacion = permiso_ver($Id_objeto);



if ($visualizacion == 0) {
    //header('location:  ../vistas/menu_roles_vista.php');

    echo '<script type="text/javascript">
                              swal({
                                   title:"",
                                   text:"Lo sentimos no tiene permiso de visualizar la pantalla",
                                   type: "error",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                           window.location = "../vistas/menu_mantenimiento_plan.php";

                            </script>';
} else {






    if (permisos::permiso_insertar($Id_objeto) == '1') {
        $_SESSION['btn_modificar_asignatura_servicio'] = "";
    } else {
        $_SESSION['btn_modificar_asignatura_servicio'] = "disabled";
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


                        <h1>ASIGNATURAS DE SERVICIO</h1>
                    </div>



                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="../vistas/menu_mantenimiento_plan.php">Menu Mantenimiento</a></li>
                            <li class="breadcrumb-item"><a href="../vistas/mantenimiento_crear_asignatura_servcio_vista.php"> Mantenimiento crear Asignatura de servicio</a></li>
                        </ol>
                    </div>

                    <div class="RespuestaAjax"></div>

                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid ">
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">MANTENIMIENTO DE ASIGNATURAS DE SERVICIO</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>

                        </div>

                    </div>

                    <div class="card-body">
                        <div class="table-responsive" style="width: 100%;">
                            <table id="tabla_asignatura_servicio" class="table table-bordered table-striped" style="width:99%">
                                <thead>
                                    <tr>

                                        <th>Acción</th>
                                        <th>Asignatura</th>
                                        <th>Código</th>
                                        <th>UV</th>
                                        <!-- <th>Área</th> -->
                                        <th>Suficiencia</th>
                                        <th>Reposición</th>
                                        <th>Sílabo</th>

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
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modal_editar" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Asignatura</h5>
                    <button onclick="limpiarSilabo()" class="close" data-dismiss="modal">
                        &times;
                    </button>

                </div>

                <input class="form-control" type="text" id="id_asig" name="id_asig" readonly hidden>

                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-8">
                            <div class="form-group">

                                <input class="form-control" type="text" id="txt_nombre1" name="txt_nombre1" readonly hidden>
                                <label>Nombre Asignatura:</label>
                                <input class="form-control" type="text" id="txt_nombre" name="txt_nombre">

                            </div>

                        </div>
                        <div class="col-md-2">
                            <div class="form-group">

                                <input class="form-control" type="text" id="txt_codigo1" name="txt_codigo1" readonly hidden>
                                <label>Código:</label>
                                <input class="form-control" type="text" id="txt_codigo" name="txt_codigo" maxlength="10">


                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="hidden">
                                <label>UV:</label>

                                <input class="form-control" type="text" id="txt_uv1" name="txt_uv1" readonly hidden>
                                <input class="form-control" type="text" id="txt_uv" name="txt_uv" maxlength="10">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Reposición:</label>

                                <input class="form-control" type="text" id="cbm_reposicion1" name="cbm_reposicion1" readonly hidden>
                                <td> <select class="form-control" style="width: 100%;" name="cbm_reposicion" id="cbm_reposicion">
                                        <option value="0">SELECCIONAR</option>
                                        <option value="SI">SI</option>
                                        <option value="NO">NO</option>
                                    </select>
                                </td>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Suficiencia:</label>
                                <input class="form-control" type="text" id="cbm_suficiencia1" name="cbm_suficiencia1" readonly hidden>
                                <td> <select class="form-control" style="width: 100%;" name="cbm_suficiencia" id="cbm_suficiencia">
                                        <option value="0">SELECCIONAR</option>
                                        <option value="SI">SI</option>
                                        <option value="NO">NO</option>
                                    </select>
                                </td>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Actualizar Sílabo:</label>
                                <input class="form-control" type="file" id="txt_silabo" name="txt_silabo" value="" required accept="application/pdf" onchange="Validar();">
                                </td>
                            </div>
                        </div>


                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary" id="guardar_servicio" name="guardar_servicio" <?php echo $_SESSION['btn_modificar_asignatura_servicio']; ?>>Guardar</button>

                    <button class="btn btn-secondary" data-dismiss="modal" id="salir" onclick="limpiarSilabo()">Cancelar</button>
                </div>
            </div>
        </div>

    </div>
    <script type="text/javascript" src="../js/mantenimiento_asignatura.js"></script>
    <script type="text/javascript" src="../js/validaciones_plan.js"></script>

</body>
<!-- modal modificar carga -->





</html>
<script>
    $(document).ready(function() {
        TablaManteniAsignaturaServicio();


    });
</script>

<script>
    var idioma_espanol = {
        select: {
            rows: "%d fila seleccionada"
        },
        "sProcessing": "Procesando...",
        "sLengthMenu": "Mostrar _MENU_ registros",
        "sZeroRecords": "No se encontraron resultados",
        "sEmptyTable": "No se encontraron resultados",
        "sInfo": "Registros del (_START_ al _END_) total de _TOTAL_ registros",
        "sInfoEmpty": "Registros del (0 al 0) total de 0 registros",
        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix": "",
        "sSearch": "Buscar:",
        "sUrl": "",
        "sInfoThousands": ",",
        "sLoadingRecords": "<b>No se encontraron datos</b>",
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

<script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script>
<script src="../plugins/select2/js/select2.min.js"></script>
<!-- datatables JS -->
<script type="text/javascript" src="../plugins/datatables/datatables.min.js"></script>
<!-- para usar botones en datatables JS -->
<script src="../plugins/datatables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>
<script src="../plugins/datatables/JSZip-2.5.0/jszip.min.js"></script>
<script src="../plugins/datatables/pdfmake-0.1.36/pdfmake.min.js"></script>
<script src="../plugins/datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
<script src="../plugins/datatables/Buttons-1.5.6/js/buttons.html5.min.js"></script>