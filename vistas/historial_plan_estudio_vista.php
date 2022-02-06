<?php
ob_start();
session_start();


require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');
require_once('../clases/conexion_mantenimientos.php');
//$registro = controlador_registro_docente::ctrRegistro();
$Id_objeto = 97;


$visualizacion = permiso_ver($Id_objeto);


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


    // if (permisos::permiso_insertar($Id_objeto) == '1') {
    //   $_SESSION['btn_guardar_registro_docentes'] = "";
    // } else {
    //   $_SESSION['btn_guardar_registro_docentes'] = "disabled";
    // }
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/dff4a4ada1.js" crossorigin="anonymous"></script>
    <title></title>


</head>
<!-- shif alt f -->

<body>
    <div class="card card-default">

        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">

                <div class="container-fluid">

                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Historial de Plan de Estudio</h1>
                        </div>



                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
                                <li class="breadcrumb-item"><a href="../vistas/menu_plan_estudio_vista.php">Menu plan de estudio</a></li>
                                <li class="breadcrumb-item">Historial de Plan de Estudio</a></li>

                            </ol>
                        </div>



                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <section>



                <!-- Main content -->
                <section class="content-header">
                    <div class="container-fluid">
                        <!-- pantalla  -->

                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Datos Generales de Plan de Estudios</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>

                                </div>

                            </div>

                            <div class="card-body" style="display: block;">
                                <input type="text" class="form-control" id="nombre_busca" name="nombre_busca" readonly hidden>
                                <input type="text" class="form-control" id="codigo_busca" name="codigo_busca" readonly hidden>
                                <input type="text" class="form-control" id="txt_count1" name="txt_count1" readonly hidden>



                                <div class="table-responsive" style="width: auto;">
                                    <table id="tabla1_historial_plan" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>

                                                <th>Nombre</th>
                                                <th>Codigo</th>
                                                <th>Numero de Clases</th>
                                                <th>Fecha Creacion</th>
                                                <th>Vigente</th>
                                                <th>Acción</th>

                                            </tr>
                                        </thead>
                                    </table>

                                </div>



                            </div>

                        </div>


                    </div>


                </section>

                <!-- Main content -->
                <section class="content-header">
                    <div class="container-fluid">
                        <!-- pantalla  -->

                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Plan de Estudios Seleccionado</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>

                                </div>

                            </div>

                            <div class="card-body" style="display: block;">
                                <div class="row">

                                    <div class="col-md-2">
                                        <button class="btn btn-primary " id="limpiar" onclick="limpiar()"><i class="fas fa-sync-alt"></i> <a style="font-weight: bold;">limpiar tabla</a></button>

                                    </div>

                                    <div class=" px-12">
                                        <form method="post" action="../Controlador/reporte_carga_gestion_controlador.php">
                                            <!--                                             <button disabled class="btn btn-success " id="pdf"> <i class="fas fa-file-pdf"></i> <a style="font-weight: bold;">Exportar a PDF</a> </button>
 --> <input type="text" class="form-control" id="txt_count1" name="txt_count1" readonly hidden>

                                        </form>
                                    </div>
                                </div>
                                <br>


                                <div class="table-responsive" style="width: auto;">
                                    <table id="tabla3_historial_plan" class="table table-bordered table-striped">
                                        <thead class="thead-dark">
                                            <tr>

                                                <th>Periodo</th>
                                                <th>Asignatura</th>
                                                <th>Codigo</th>
                                                <th>UV</th>
                                                <th>Requisitos</th>
                                                <th>Equivalencia</th>
                                                <th>Sílabo</th>

                                            </tr>
                                        </thead>
                                    </table>

                                </div>




                            </div>

                        </div>


                    </div>


                </section>
            </section>
            <!--Modal para correo-->
            <div class="modal fade" tabindex="-1" role="dialog" id="Modalsilabo">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">


                        <div class="modal-body">

                            <button class="btn btn-info " id="descargar_curriculum" name=""> <a href="" target="_blank" id="curriculum" style="color:white;font-weight: bold;">Descargar Sílabo</a></button>

                        </div>


                    </div>
                </div>
            </div>

        </div>







    </div>







</body>



</html>
<script>
    $(document).ready(function() {
        Tabla1_historial_plan();


    });
</script>
<script>
    $(document).ready(function() {
        Tabla2cargar_plan();


    });
</script>



<script src="../js/historial_plan_estudio.js"></script>

<script>
    var idioma_espanol = {
        select: {
            rows: "%d fila seleccionada"
        },
        "sProcessing": "Procesando...",
        "sLengthMenu": "Mostrar _MENU_ registros",
        "sZeroRecords": "No se encontraron resultados",
        "sEmptyTable": "No se encuentra los datos",
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

<!-- -->
<!-- <script src="../plugins/datatables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>
<script src="../plugins/datatables/JSZip-2.5.0/jszip.min.js"></script>
<script src="../plugins/datatables/pdfmake-0.1.36/pdfmake.min.js"></script>
<script src="../plugins/datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
<script src="../plugins/datatables/Buttons-1.5.6/js/buttons.html5.min.js"></script> -->