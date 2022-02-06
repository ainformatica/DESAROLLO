<?php
ob_start();
session_start();


require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');
require_once('../clases/conexion_mantenimientos.php');
//$registro = controlador_registro_docente::ctrRegistro();
$Id_objeto = 113;


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
                           window.location = "../vistas/menu_docentes_vista.php";

                            </script>';
} else {

    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INGRESO', 'A CONSULTAR PLAN DE ESTUDIO DOCENTE.');


    // if (permisos::permiso_insertar($Id_objeto) == '1') {
    //   $_SESSION['btn_guardar_registro_docentes'] = "";
    // } else {
    //   $_SESSION['btn_guardar_registro_docentes'] = "disabled";
    // }
}
$sql2 = $mysqli->prepare("SELECT plan.id_plan_estudio AS id_plan_estudio, plan.nombre AS nombre, plan.num_clases AS num_clases,
plan.fecha_creacion AS fecha_vigencia
FROM tbl_plan_estudio plan
 WHERE plan.plan_vigente='SI'");
$sql2->execute();
$resultado2 = $sql2->get_result();
$row2 = $resultado2->fetch_array(MYSQLI_ASSOC);
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

<body onload="">


    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <div class="container-fluid">

                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Asignaturas Vigentes</h1>
                    </div>



                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="../vistas/menu_plan_estudio_vista.php">Menu plan de estudio</a></li>
                            <li class="breadcrumb-item">Consultar Asignaturas</a></li>

                        </ol>
                    </div>
                    <div class="RespuestaAjax"></div>



                </div>
            </div><!-- /.container-fluid -->
        </section>




        <div class="card card-default">
            <div class="card-body" style="display: block;">
                <h2>Plan de Estudios Vigente</h2>
                <div class="card-header">

                    <div class="row">
                        <div class="col-md-4" style="width:75px">
                            <div class="input-group mb-3 input-group">
                                <span class=" input-group-text" style="font-weight: bold;">Nombre</span>
                                <input type="text" class="form-control" id="nombre_" name="nombre_" value="<?php echo $row2['nombre'] ?>" readonly>

                            </div>
                        </div>
                        <div class="col-md-4" style="width:75px">
                            <div class="input-group mb-3 input-group">
                                <span class=" input-group-text" style="font-weight: bold;">Fecha de Vigencia</span>
                                <input type="text" class="form-control" id="fecha_vigencia" name="fecha_vigencia" value="<?php echo $row2['fecha_vigencia'] ?>" readonly>


                            </div>
                        </div>
                        <div class="col-md-3" style="width:75px">
                            <div class="input-group mb-3 input-group">

                                <span class=" input-group-text" style="font-weight: bold;">Numero de Clases</span>
                                <input type="text" class="form-control" id="num_clases" name="num_clases" value="<?php echo $row2['num_clases'] ?>" readonly>



                            </div>
                        </div>




                        <!-- <div class=" px-12">
                                        <form method="post" action="../Controlador/reporte_carga_gestion_controlador.php">
                                            <button disabled class="btn btn-success " id="pdf"> <i class="fas fa-file-pdf"></i> <a style="font-weight: bold;">Exportar a PDF</a> </button>
                                           <input type="text" class="form-control" id="txt_count1" name="txt_count1" readonly hidden>

                                        </form>
                                    </div> -->
                    </div>
                </div>


            </div>

            <div class="container-fluid" style="width: 100%;">
                <div class="box-body">

                    <div class="card-body">


                        <div class="table-responsive" style="width: auto;">
                            <table id="tabla_consultar_plan_docente" class="table table-bordered table-striped">
                                <thead>
                                    <tr>

                                        <th>Periodo</th>
                                        <th>Asignatura</th>
                                        <th>Codigo</th>
                                        <th>UV</th>
                                        <th>Requisitos</th>
                                        <th>Equivalencias</th>
                                        <th>Sílabo</th>

                                    </tr>
                                </thead>
                            </table>

                        </div>




                    </div>
                </div>
            </div>

        </div>









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













</body>



</html>
<script>
    $(document).ready(function() {
        Tabla_consulta_plan();


    });
</script>




<script src="../js/consultar_plan_docentes.js"></script>

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