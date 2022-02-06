<?php
ob_start();

session_start();

require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');

$Id_objeto = 212;
$visualizacion = permiso_ver($Id_objeto);

$inputTags = "";
$id_usuario_responsable = (isset($_GET['id_usuario_responsable']) ? $_GET['id_usuario_responsable'] : null);
$_SESSION['id_usuario_responsable'] = $id_usuario_responsable;
$consulta = "SELECT per.id_persona, 
CONCAT (per.nombres, ' ' ,per.apellidos) AS nombre 
FROM tbl_personas per
WHERE per.id_persona = '$id_usuario_responsable'";
$resultado = $mysqli->query($consulta);
$inputTags = $resultado->fetch_array(MYSQLI_ASSOC);


if (isset($_REQUEST['msj'])) {
    $msj = $_REQUEST['msj'];
    if ($msj == 1) {
        echo '<script type="text/javascript">
    swal({
        title: "",
        text: "Lo sentimos, tiene campos por rellenar",
        type: "info",
        showConfirmButton: false,
        timer: 3000
    });
</script>';
    }

    if ($msj == 2) {

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


    if ($msj == 3) {

        echo '<script type="text/javascript">
    swal({
        title: "",
        text: "Para reasignar, debe cambiar ubicación o persona responsable.",
        type: "error",
        showConfirmButton: false,
        timer: 3000
    });
</script>';
    }
}
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

    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INGRESO', 'A CREAR REASIGNACION');

    if (permisos::permiso_modificar($Id_objeto) == '1') {
        $_SESSION['btn_modificar_asignacion'] = "";
    } else {
        $_SESSION['btn_modificar_asignacion'] = "disabled";
    }
}



if (isset($_GET['id_asignacion'])) {
    // code...
    $id_asignacion_update = $_GET['id_asignacion'];
    $id_asignacion = $id_asignacion_update;
    $sql = "SELECT 
        a.id_asignacion AS id_asignacion, da.numero_inventario as inventario, a.id_detalle as id_detalle, p.nombre_producto as producto, u.id_ubicacion, u.ubicacion as ubicacion, per.id_persona, CONCAT(per.nombres, ' ', per.apellidos) AS nombre, a.fecha_asignacion as fecha, id_usuario_responsable, motivo, id_ubicacion_previa
        FROM tbl_asignaciones AS a
        LEFT JOIN tbl_detalle_adquisiciones AS da ON a.id_detalle = da.id_detalle
        LEFT JOIN tbl_productos AS p ON da.id_producto = p.id_producto
        LEFT JOIN tbl_ubicacion AS u ON a.id_ubicacion = u.id_ubicacion
        LEFT JOIN tbl_personas AS per ON a.id_usuario_responsable = per.id_persona
        WHERE a.id_asignacion = '$id_asignacion_update'";

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
}
ob_end_flush();
?>

<head>
    <script src="../js/autologout.js"></script>
</head>
<form action="../Controlador/actualizar_asignacion_controlador.php?id_asignacion=<?php echo $_SESSION['id_asignacion']; ?>" method="post" data-form="update" autocomplete="off">

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Reasignación
                        </h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
                            <li class="breadcrumb-item active"><a href="../vistas/gestion_asignacion_vista.php">Gestión de asignaciones</a></li>
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
            </div>

            <div class="card-body">
                <!-- CARD-BODY START -->
                <!-- CARD-BODY CODE -->

                <div class="modal-body">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Inventario</label>
                                    <input class="form-control" type="text" id="txt_inventario_modal" name="txt_inventario_modal" value="<?php echo $_SESSION['inventario']; ?>" required style="text-transform: uppercase" onkeyup="DobleEspacio(this, event); MismaLetra('txt_inventario_modal');" onkeypress="return sololetras(event)" maxlength="30" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nombre de producto</label>
                                    <input class="form-control" type="text" id="txt_producto_modal" name="txt_producto_modal" value="<?php echo $_SESSION['producto']; ?>" required style="text-transform: uppercase" onkeyup="DobleEspacio(this, event); MismaLetra('txt_producto_modal');" onkeypress="return sololetras(event)" maxlength="30" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="txt_persona_responsable_actual_modal">Persona responsable actual</label>
                                    <input type="hidden" id="txt_nueva_persona_responsable" name="txt_nueva_persona_responsable" value="<?php echo $id_usuario_responsable ?>">
                                    <input class="form-control" type="text" id="txt_persona_responsable_actual_modal" name="txt_persona_responsable_actual_modal" value="<?php echo $_SESSION['nombre']; ?>" required style="text-transform: uppercase" onkeyup="DobleEspacio(this, event); MismaLetra('txt_persona_responsable_actual_modal');" onkeypress="return sololetras(event)" maxlength="30" readonly>
                                </div>
                            </div>


                            <!-- PERSONA RESPONSABLE -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Persona responsable</label><br>
                                    <input class="form-control" type="text" id="txt_persona_responsable" name="txt_persona_responsable" value="<?php echo $inputTags['nombre']; ?>" required readonly>

                                    <div class="input-group-append">

                                        <button class="btn btn-primary" type="button" id="button-addon2" data-toggle="modal" data-target="#staticBackdrop">Buscar</button>

                                    </div>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Ubicación actual</label>
                                    <input class="form-control" type="text" id="txt_ubicacion_actual_modal" name="txt_ubicacion_actual_modal" value="<?php echo $_SESSION['ubicacion']; ?>" required style="text-transform: uppercase" onkeyup="DobleEspacio(this, event); MismaLetra('txt_ubicacion_actual_modal');" onkeypress="return sololetras(event)" maxlength="30" readonly>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="control-label">Nueva Ubicación</label>
                                    <select class="form-control" id="cmb_ubicacion_modal" name="cmb_ubicacion_modal" required="">
                                        <!-- <option value="0"  >Seleccione una ubicación para reasignar:</option> -->
                                        <?php
                                        // $_SESSION['tipo_producto_'] = $row['id_tipo_producto'];

                                        if (isset($_SESSION['id_ubicacion'])) {
                                            $query = $mysqli->query("select * FROM tbl_ubicacion where id_ubicacion<>$_SESSION[id_ubicacion] ");
                                            while ($resultado = mysqli_fetch_array($query)) {

                                                echo '<option value="' . $resultado['id_ubicacion'] . '"  > ' . $resultado['ubicacion'] . '</option>';
                                            }


                                            echo '<option value="' . $_SESSION['id_ubicacion'] . '" selected="" >  ' . $_SESSION['ubicacion'] . '</option>';
                                        } else {
                                            $query = $mysqli->query("select * FROM tbl_ubicacion");
                                            while ($resultado = mysqli_fetch_array($query)) {
                                                //$nombre_tipo_producto= $row['tipo_producto'];
                                                echo '<option value="' . $_SESSION['id_ubicacion'] . '" selected="" >  ' . $_SESSION['ubicacion'] . '</option>';
                                            }
                                        }
                                        //$_SESSION['nombre_tipo_producto_'] = $row['tipo_producto'];

                                        ?>
                                    </select>

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Fecha de asignacion</label>
                                    <input class="form-control" type="text" id="txt_fecha_modal" name="txt_fecha_modal" value="<?php echo $_SESSION['fecha']; ?>" required style="text-transform: uppercase" onkeyup="DobleEspacio(this, event); MismaLetra('txt_fecha_modal');" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                    $timezone = "America/Tegucigalpa";
                                    date_default_timezone_set($timezone);
                                    $today = date("Y-m-d");
                                    ?>
                                    <label>Nueva Fecha de Asignación</label>
                                    <input class="form-control" type="date" min="<?php echo date('Y'); ?>" id="nueva_fecha_asignacion" name="nueva_fecha_asignacion" maxlength="30" onkeyup="Espacio(this, event)" onblur="document.getElementById('nueva_fecha_asignacion').value=this.value" value="<?php echo $today; ?>" readonly>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Motivo original de asignación</label>
                                    <input type="text" style="text-transform: uppercase" class="form-control" id="motivo_asignacion_previo_modal" name="motivo_asignacion_previo_modal" value="<?php echo $_SESSION['motivo_previo']; ?>" readonly>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Motivo de reasignación</label>
                                    <textarea class="form-control tf w-input" style="text-transform: uppercase" required type="text" placeholder="Ingrese el motivo de reasignación aquí" onkeyup="DobleEspacio(this, event) maxlength=" 100" name="motivo_reasignacion_modal" id="motivo_reasignacion_modal" rows="5" cols="40" value="<?php echo $_SESSION['motivo_actual']; ?>"></textarea>
                                </div>
                            </div>

                            <p class="text-center" style="margin-top: 20px;">
                                <button type="submit" class="btn btn-primary" id="btn_modificar_asignacion" name="btn_modificar_asignacion" <?php echo $_SESSION['btn_modificar_asignacion']; ?>><i class="zmdi zmdi-floppy"></i> Guardar</button>

                                <a href="../vistas/gestion_asignacion_vista.php" class="btn btn-danger"><i class="zmdi zmdi-floppy"></i> Cancelar</a>
                            </p>

                        </div> <!-- CARD-BODY END -->

                        <!-- /.card-body -->
                        <div class="card-footer">

                        </div>
                    </div>
                    <div class="RespuestaAjax"></div>
</form>

<!-- Modal para seleccionar persona responsable -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Buscar usuarios</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Salida PHP para seleccionar productos no coincidentes (pasar a procedimiento) -->
            <?php
            $sqlRespUser = "SELECT per.id_persona as id_persona, CONCAT (per.nombres, ' ' ,per.apellidos) AS nombre FROM tbl_personas per WHERE per.Estado = 'ACTIVO'";
            $sqlRespUserResult = $mysqli->query($sqlRespUser);
            ?>

            <div class="modal-body">
                <div class="card-body">
                    <p>
                        Seleccione el nuevo usuario responsable
                    </p>
                    <div class="mb-3">
                        <table id="dtblInventario" class="table table-bordered table-striped" width="100%">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Seleccionar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($rowIR = $sqlRespUserResult->fetch_array(MYSQLI_ASSOC)) { ?>
                                    <tr>
                                        <td><?php echo $rowIR['nombre']; ?></td>

                                        <td style="text-align: center;">

                                            <form action="actualizar_asignacion_vista.php?id_usuario_responsable=<?php echo $rowIR['id_persona']; ?>" method="POST" autocomplete="off">
                                                <button type="submit" class="btn btn-primary btn-raised btn-xs"><i class="far fa-edit"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- FIN DE VENTANA MODAL -->

<script type="text/javascript">
    // formato de la tabla
    $(function() {

        $('#dtblInventario').DataTable({
            "language": {
                "url": "../plugins/lenguaje.json"
            },
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "responsive": true,
            "pageLength": 5,
            "lengthMenu": [
                [5, 10, 20, -1],
                [5, 10, 20, "Todos"]
            ]
        });
    });
</script>

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