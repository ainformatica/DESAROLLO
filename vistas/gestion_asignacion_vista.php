<?php
ob_start();

session_start();

require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');

//Lineas de msj al cargar pagina de acuerdo a actualizar o eliminar datos
if (isset($_REQUEST['msj'])) {
    $msj = $_REQUEST['msj'];

    if ($msj == 1) {
        echo '<script type="text/javascript">
    swal({
        title: "",
        text: "Lo sentimos, ya existe esa asignación.",
        type: "info",
        showConfirmButton: false,
        timer: 3000
    });
</script>';
    }

    if ($msj == 2) {

        echo '<script type="text/javascript">
    swal({
        title: "Buen trabajo",
        text: "Los datos se almacenaron correctamente",
        type: "success",
        showConfirmButton: false,
        timer: 3000
    });
</script>';



        $sqltabla = "SELECT 
        a.id_asignacion AS id_asignacion, CONCAT('INVE','-',da.numero_inventario) as inventario, p.nombre_producto as producto, u.ubicacion as ubicacion, CONCAT(per.nombres, ' ', per.apellidos) AS nombre, a.fecha_asignacion as fecha
        FROM tbl_asignaciones AS a
        LEFT JOIN tbl_detalle_adquisiciones AS da ON a.id_detalle = da.id_detalle
        LEFT JOIN tbl_productos AS p ON da.id_producto = p.id_producto
        LEFT JOIN tbl_ubicacion AS u ON a.id_ubicacion = u.id_ubicacion
        LEFT JOIN tbl_personas AS per ON a.id_usuario_responsable = per.id_persona";

        $resultadotabla = $mysqli->query($sqltabla);
    }
    if ($msj == 3) {

        echo '<script type="text/javascript">
    swal({
        title: "",
        text: "Error al actualizar lo sentimos,intente de nuevo.",
        type: "error",
        showConfirmButton: false,
        timer: 3000
    });
</script>';
    }
}

$Id_objeto = 212;
$visualizacion = permiso_ver($Id_objeto);

if ($visualizacion == 0) {
    // header('location:  ../vistas/menu_roles_vista.php');
    echo '<script type="text/javascript">
                              swal({
                                   title:"",
                                   text:"Lo sentimos no tiene permiso de visualizar la pantalla",
                                   type: "error",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                           window.location = "../vistas/pagina_principal_vista.php";

                            </script>';
} else {

    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INGRESO', 'A GESTION DE ASIGNACION');

    if (permisos::permiso_modificar($Id_objeto) == '1') {
        $_SESSION['btn_modificar_asignacion'] = "";
    } else {
        $_SESSION['btn_modificar_asignacion'] = "disabled";
    }

    /* Manda a llamar todos las datos de la tabla para llenar el gridview  */
    $sqltabla = "SELECT 
    a.id_asignacion AS id_asignacion, da.numero_inventario as inventario, p.nombre_producto as producto, u.ubicacion as ubicacion, CONCAT(per.nombres, ' ', per.apellidos) AS nombre, a.fecha_asignacion as fecha,a.motivo as motivo
    FROM tbl_asignaciones AS a
    LEFT JOIN tbl_detalle_adquisiciones AS da ON a.id_detalle = da.id_detalle
    LEFT JOIN tbl_productos AS p ON da.id_producto = p.id_producto
    LEFT JOIN tbl_ubicacion AS u ON a.id_ubicacion = u.id_ubicacion
    LEFT JOIN tbl_personas AS per ON a.id_usuario_responsable = per.id_persona";
    $resultadotabla = $mysqli->query($sqltabla);

    /* Esta condicion sirve para  verificar el valor que se esta enviando al momento de dar click en el icono modicar */
    if (isset($_GET['id_asignacion'])) {
        $sqltabla = "SELECT 
        a.id_asignacion AS id_asignacion, CONCAT('INVE','-',da.numero_inventario) as inventario, p.nombre_producto as producto, u.ubicacion as ubicacion, CONCAT(per.nombres, ' ', per.apellidos) AS nombre, a.fecha_asignacion as fecha
        FROM tbl_asignaciones AS a
        LEFT JOIN tbl_detalle_adquisiciones AS da ON a.id_detalle = da.id_detalle
        LEFT JOIN tbl_productos AS p ON da.id_producto = p.id_producto
        LEFT JOIN tbl_ubicacion AS u ON a.id_ubicacion = u.id_ubicacion
        LEFT JOIN tbl_personas AS per ON a.id_usuario_responsable = per.id_persona";

        $resultadotabla = $mysqli->query($sqltabla);

        /* Esta variable recibe el estado de modificar */
        $id_asignacion = $_GET['id_asignacion'];

        /* Iniciar la variable de sesion y la crea */
        /* Hace un select para mandar a traer todos los datos de la tabla donde rol sea igual al que se ingreso en el input */
        $sql = "SELECT 
        a.id_asignacion AS id_asignacion, CONCAT('INVE','-',da.numero_inventario) as inventario, a.id_detalle as id_detalle, p.nombre_producto as producto, u.id_ubicacion, u.ubicacion as ubicacion, per.id_persona, CONCAT(per.nombres, ' ', per.apellidos) AS nombre, a.fecha_asignacion as fecha, id_usuario_responsable, motivo, id_ubicacion_previa
        FROM tbl_asignaciones AS a
        LEFT JOIN tbl_detalle_adquisiciones AS da ON a.id_detalle = da.id_detalle
        LEFT JOIN tbl_productos AS p ON da.id_producto = p.id_producto
        LEFT JOIN tbl_ubicacion AS u ON a.id_ubicacion = u.id_ubicacion
        LEFT JOIN tbl_personas AS per ON a.id_usuario_responsable = per.id_persona
        WHERE a.id_asignacion = '$id_asignacion'";

        $resultado = $mysqli->query($sql);
        /* Manda a llamar la fila */
        $row = $resultado->fetch_array(MYSQLI_ASSOC);

        /* Aqui obtengo los campos de la tabla asignación para reasignar   */
        $_SESSION['id_asignacion'] = $row['id_asignacion'];
        $_SESSION['inventario'] = $row['inventario'];
        $_SESSION['producto'] = $row['producto'];
        $_SESSION['id_detalle'] = $row['id_detalle'];
        $_SESSION['id_usuario_responsable_previo'] = $row['id_usuario_responsable'];
        $_SESSION['motivo_previo'] = $row['motivo'];
        $_SESSION['id_ubicacion'] = $row['id_ubicacion'];
        $_SESSION['id_ubicacion_previa'] = $row['id_ubicacion'];
        $_SESSION['ubicacion'] = $row['ubicacion'];
        $_SESSION['id_persona'] = $row['id_persona'];
        $_SESSION['nombre'] = $row['nombre'];
        $_SESSION['fecha'] = $row['fecha'];
        $_SESSION['fecha_asignacion_previa'] = $row['fecha'];

        /*Aqui levanto el modal*/

        if (isset($_SESSION['id_asignacion'])) {
?>
            <script>
                $(function() {
                    $('#modal_actualizar_inventario').modal('toggle')
                })
            </script>;

            <?php
            ?>

<?php


        }
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


    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Asignaciones
                        </h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
                            <li class="breadcrumb-item active"><a href="../vistas/crear_asignacion_vista.php">Nueva asignación</a></li>
                        </ol>
                    </div>

                    <div class="RespuestaAjax"></div>

                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!--Pantalla 2-->

        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title"></h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
                <br>
                <!-- <div class=" px-12">
                    <button class="btn btn-success "> <i class="fas fa-file-pdf"></i> <a style="font-weight: bold;" onclick="ventana()">Exportar a PDF</a> </button>
                </div> -->

            </div>

            <div class="card-body">
                <div class="mb-3">
                    <div style="padding: 2px;"><a href="crear_asignacion_vista.php" class=" btn btn-success btn-inline float-right mt-0"><i class="fas fa-plus pr-2"></i>Nuevo</a></div>

                    <table id="tblAsignacion" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>INVENTARIO</th>
                                <th>NOMBRE PRODUCTO</th>
                                <th>UBICACIÓN</th>
                                <th>RESPONSABLE</th>
                                <th>MOTIVO</th>
                                <th>FECHA</th>
                                <th>REASIGNAR</th>
                                <th>ELIMINAR</th>
                                <th>REPORTE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $resultadotabla->fetch_array(MYSQLI_ASSOC)) { ?>
                                <tr>
                                    <td><?php echo $row['inventario']; ?></td>
                                    <td><?php echo $row['producto']; ?></td>
                                    <td><?php echo $row['ubicacion']; ?></td>
                                    <td><?php echo $row['nombre']; ?></td>
                                    <td><?php echo $row['motivo']; ?></td>
                                    <td><?php echo $row['fecha']; ?></td>


                                    <td style="text-align: center;">

                                        <!-- <a href="../vistas/actualizar_asignacion_vista.php">Inicio</a> -->

                                        <a href="../vistas/actualizar_asignacion_vista.php?id_asignacion=<?php echo $row['id_asignacion']; ?>" class="btn btn-primary btn-raised btn-xs">
                                            <i class="far fa-edit" style="display:<?php echo $_SESSION['modificar_asignacion'] ?> "></i>
                                        </a>
                                    </td>

                                    <td style="text-align: center;">

                                        <form action="../Controlador/eliminar_asignacion_controlador.php?id_asignacion=<?php echo $row['id_asignacion']; ?>" method="POST" class="FormularioAjax" data-form="delete" autocomplete="off">
                                            <button type="submit" class="btn btn-danger btn-raised btn-xs">

                                                <i class="far fa-trash-alt" style="display:<?php echo $_SESSION['eliminar_asignacion'] ?> "></i>
                                            </button>
                                            <div class="RespuestaAjax"></div>
                                        </form>
                                    </td>

                                    <!-- reporte -->
                                    <td style="text-align: center;">

                                        <a href="../pdf_laboratorio/reporte_asignacion_lab.php?id_asignacion=<?php echo $row['id_asignacion']; ?>" target="_blank" class="btn btn-primary btn-raised btn-xs">

                                            <i class="fas fa-clipboard-list"></i>
                                        </a>
                                    </td>

                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>

        </div>

        <!-- /.card-body -->
        <div class="card-footer">

        </div>
    </div>

    <script type="text/javascript" language="javascript">
        //impresión de reporte
        function ventana() {
            window.open("../Controlador/reporte_asignaciones_controlador.php", "REPORTE");
        }
    </script>


    <!-- <script type="text/javascript"> // formato de la tabla
        $(function() {

            $('#tblAsignacion').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "responsive": true,
            });
        });
    </script> -->

</body>

</html>

<script type="text/javascript" src="../js/funciones_mantenimientos.js"></script>
<script type="text/javascript" language="javascript">
    $(document).ready(function() {

        $('.select2').select2({
            placeholder: 'Seleccione una opcion',
            theme: 'bootstrap4',
            tags: true,
        });

    });
</script>
<script src="../js/pdf_gestion_laboratorio.js"></script>
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