<?php
ob_start();
session_start();
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
$id = $_GET['id'];
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');
$dtz = new DateTimeZone("America/Tegucigalpa");
$dt = new DateTime("now", $dtz);
$hoy = $dt->format("Y-m-d");
$Id_objeto = 5006;
$vista = $estado['num_acta'];
bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'Ingreso', 'Visualizar archivos ');
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
                            window.location = "../vistas/menu_reunion_vista.php";

                            </script>';
    // header('location:  ../vistas/menu_usuarios_vista.php');
} else {
    if (permisos::permiso_insertar($Id_objeto) == '1') {
        $_SESSION['btn_crear'] = "";
    } else {
        $_SESSION['btn_crear'] = "disabled='disabled'";
    }
}
ob_end_flush();
?>
<!DOCTYPE html>
<html>

<head>
    <script src="../js/autologout.js"></script>
    <link rel="stylesheet" type="text/css" href="../plugins/datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel=" stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js">
    <title></title>
</head>

<body>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="padding: 0 15px 40px 15px;">
        <?php
        $sql = "SELECT
            num_acta
        FROM
            tbl_acta t1 
        WHERE
            id_acta  = $id ";
        $resultado = $mysqli->query($sql);
        $estado = $resultado->fetch_assoc();
        ?>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h4>Visualizacion de archivos del acta <br><b><?php echo $estado['num_acta']; ?></b></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Visualizacion de archivos</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <table id="archivos" class="table table-bordered table-striped">
                <thead>
                    <tr style="color: #3444d1;">
                        <th>Nombre Archivo</th>
                        <th>Formato</th>
                        <th>DESCARGAR</th>
                    </tr>
                </thead>

                <body>
                    <?php
                    try {
                        $sql = "SELECT
                        t2.id_acta,
                        t2.num_acta,
                        t1.url,
                        t1.formato,
                        t1.nombre
                    FROM
                        tbl_acta_recursos t1
                        INNER JOIN tbl_acta t2 ON t2.id_acta = t1.id_acta
                    WHERE
                        t1.id_acta = $id";
                        $resultado = $mysqli->query($sql);
                    } catch (Exception $e) {
                        $error = $e->getMessage();
                        echo $error;
                    }
                    while ($estadoacta = $resultado->fetch_assoc()) { ?>
                        <tr>
                            <td>
                                <label for="<?php echo $estadoacta['nombre']; ?>">
                                    <a><?php echo $estadoacta['nombre']; ?></a>
                                </label>
                            </td>
                            <td>
                                <?php echo $estadoacta['formato']; ?>
                            </td>
                            <td>
                                <a href="<?php echo $estadoacta['url'] . $estadoacta['nombre']; ?>" download="<?php echo $estadoacta['nombre']; ?>"><i style="color: #359c32;" class="fas fa-download"></i></a>
                            </td>
                        </tr>
                    <?php  }  ?>
                </body>
            </table>
    </div>
    </section>
    <script type="text/javascript">
        $(function() {
            $('#archivos').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "responsive": true,
                language: {
                    decimal: "",
                    emptyTable: "No hay archivos adjuntados",
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
            });
        });
    </script>
</body>

</html>
<script type="text/javascript" src="../js/funciones_registro_docentes.js"></script>
<script type="text/javascript" src="../js/validar_registrar_docentes.js"></script>
<script type="text/javascript" src="../js/pdf_mantenimientos.js"></script>
<script src="../plugins/select2/js/select2.min.js"></script>
<!-- Select2 -->
<script src="../plugins/select2/js/select2.full.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="../js/tipoacta-ajax.js"></script>
<!-- datatables JS -->
<script type="text/javascript" src="../plugins/datatables/datatables.min.js"></script>
<!-- para usar botones en datatables JS -->
<script src="../plugins/datatables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>
<script src="../plugins/datatables/JSZip-2.5.0/jszip.min.js"></script>
<script src="../plugins/datatables/pdfmake-0.1.36/pdfmake.min.js"></script>
<script src="../plugins/datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
<script src="../plugins/datatables/Buttons-1.5.6/js/buttons.html5.min.js"></script>