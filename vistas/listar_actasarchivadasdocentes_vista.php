<?php
//
ob_start();
session_start();
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');
$Id_objeto = 5020;
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
                           window.location = "../vistas/menu_acta_vista.php";
                            </script>';
} else {
    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'Ingreso', 'A Consultar Actas (Docente)');
}

ob_end_flush();
?>
<!DOCTYPE html>
<html>

<head>
    <script src="../js/autologout.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../plugins/datatables/datatables.min.css" />
    <link rel="stylesheet" type="text/css" href="../plugins/datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel=" stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6"><br>
                        <h1>Actas Archivadas</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista">Inicio</a></li>
                            <li class="breadcrumb-item active">Actas Archivadas</li>
                        </ol>
                    </div>
                    <div class="RespuestaAjax"></div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">Listado de Actas</h3>

                <!--BOTON AGENDAR REUNIÓN-->
                <!-- <div class="px-1">
                    <a href="../vistas/agendar_reunion_vista.php" class="btn btn-warning"><i class="fas fa-arrow"></i>Agendar Nueva Reunión</a>
                </div>-->
                
            </div>
            <!-- /.card-header -->
            <!-- /.card-header -->
            <div class="card-body">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header p-0 border-bottom-0">
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-four-tabContent">
                            <div class="tab-pane fade active show" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                                <form role="form" name="guardar-tiporeu" id="guardar-tiporeu" method="post" action="../Modelos/modelo_manactareunion.php">
                                    <table id="tab" class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr class="table-secondary">
                                                <th>No. Acta</th>
                                                <th>Nombre Reunión</th>
                                                <th>Tipo Reunión</th>
                                                <th>Fecha Reunión</th>
                                                <th>Redactor</th>
                                                <th>Fecha de Subida</th>
                                                <th>Acta</th>
                                                <!-- <th>Acta</th>-->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            try {
                                                $sql = "SELECT 
                                                t1.id_tipo, 
                                                t1.nombrereu,
                                                t1.num_acta,
                                                t1.fecha,
                                                t1.fecha_archivo,
                                                t1.url,
                                                t1.nombre,
                                                t2.tipo,
                                                t3.Usuario
                                                FROM tbl_acta_archivo t1
                                                INNER JOIN tbl_tipo_reunion_acta t2 
                                                ON t2.id_tipo = t1.id_tipo
                                                INNER JOIN	tbl_usuarios t3
                                                ON t3.Id_usuario = t1.redactor";
                                                $resultado = $mysqli->query($sql);
                                            } catch (Exception $e) {
                                                $error = $e->getMessage();
                                                echo $error;
                                            }
                                            while ($acta = $resultado->fetch_assoc()) { ?>
                                                <tr>
                                                    <td><?php echo $acta['num_acta']; ?></td>
                                                    <td><?php echo $acta['nombrereu']; ?></td>
                                                    <td><?php echo $acta['tipo']; ?></td>
                                                    <td><?php echo $acta['fecha']; ?></td>
                                                    <td><?php echo $acta['Usuario']; ?></td>
                                                    <td><?php echo $acta['fecha_archivo']; ?></td>
                                                    <td> <a style="color: #359c32;" target="_blank" href="<?php echo $acta['url'] . $acta['nombre']; ?>"><i class="fas fa-eye "></i> VER ACTA</a></td>
                                                </tr>
                                            <?php
                                            }  ?>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel" aria-labelledby="custom-tabs-four-messages-tab">
                                <div class="card card-primary">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </section>
    </div>
    <!-- /.content-wrapper -->
    </div>
    <script type="text/javascript">
        $(function() {
            $('#tab').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                language: {
                    decimal: "",
                    emptyTable: "No hay información",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    infoEmpty: "Mostrando 0 to 0 of 0 Entradas",
                    infoFiltered: "(Filtrado de _MAX_ total entradas)",
                    lengthMenu: "Mostrar _MENU_ Entradas",
                    loadingRecords: "Cargando...",
                    processing: "Procesando...",
                    search: "Buscar:",
                    zeroRecords: "Sin resultados encontrados",
                    paginate: {
                        first: "Primero",
                        last: "Ultimo",
                        next: "Siguiente",
                        previous: "Anterior"
                    }
                },
                "info": true,
                "autoWidth": true,
                "responsive": true
            });
        });
    </script>

</body>

</html>
<script type="text/javascript" src="../js/pdf_lista_reuniones.js"></script>
<script src="../plugins/select2/js/select2.min.js"></script>
<!-- datatables JS -->
<script type="text/javascript" src="../plugins/datatables/datatables.min.js"></script>
<!-- para usar botones en datatables JS -->
<script src="../plugins/datatables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>
<script src="../plugins/datatables/JSZip-2.5.0/jszip.min.js"></script>
<script src="../plugins/datatables/pdfmake-0.1.36/pdfmake.min.js"></script>
<script src="../plugins/datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
<script src="../plugins/datatables/Buttons-1.5.6/js/buttons.html5.min.js"></script>