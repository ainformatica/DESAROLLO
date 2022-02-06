<?php
ob_start();


session_start();
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/conexion_mantenimientos.php');
require_once "../Modelos/detalle_existencias_modelo.php";
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');

//$producto="";
//$caracteristicas="";

if (empty($_SESSION['producto'])) {
    $_SESSION['producto'] = "";
}
if (empty($_SESSION['caracteristicas'])) {
    $_SESSION['caracteristicas'] = "";
}
if (empty($_SESSION['num_inventario'])) {
    $_SESSION['num_inventario'] = "";
}



$Id_objeto = 214;
bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'Ingreso', 'Nueva asignación.');

$inputTags = "";
$id_usuario_responsable = (isset($_GET['id_usuario_responsable']) ? $_GET['id_usuario_responsable'] : null);
$_SESSION['id_usuario_responsable'] = $id_usuario_responsable;
$consulta = "SELECT per.id_persona, 
CONCAT (per.nombres, ' ' ,per.apellidos) AS nombre 
FROM tbl_personas per
WHERE per.id_persona = '$id_usuario_responsable'";
$resultado = $mysqli->query($consulta);
$inputTags = $resultado->fetch_array(MYSQLI_ASSOC);

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
                         window.location = "../vistas/pagina_principal_vista.php";

                          </script>';
} else {


    if (permisos::permiso_insertar($Id_objeto) == '1') {
        $_SESSION['btn_guardar_asignacion'] = "";
    } else {
        $_SESSION['btn_guardar_asignacion'] = "disabled";
    }


    if (isset($_REQUEST['msj'])) {
        $msj = $_REQUEST['msj'];
        if ($msj == 1) {
            echo '<script> alert("Lo sentimos la SALIDA a ingresar ya existe favor intenta con uno nuevo")</script>';
        }

        if ($msj == 2) {
            echo '<script> alert("SALIDA agregada correctamente")</script>';
        }
    }
}
ob_end_flush();
?>

<!DOCTYPE html>
<html>

<head>
    <script src="../js/autologout.js"></script>
</head>

<body>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">


                        <h1>Asignación del producto</h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="../vistas/gestion_asignacion_vista.php">Gestión de asignaciones</a></li>
                        </ol>
                    </div>

                    <!-- VERIFICAR -->
                    <div class="RespuestaAjax"></div>

                </div>
            </div><!-- /.container-fluid -->
        </section>


        <!-- Main content -->
        <section class="content">
            <div class="container-fluid ">
                <!-- pantalla 1 -->


                <div class="card card-default ">
                    <div class="card-header center">
                        <!-- BUSCADOR -->
                        <h5>Buscar por No. Inventario</h5>

                        <div>
                            <form action="crear_asignacion_vista.php" method="post">
                                <input name="palabra" id="palabra" style="text-transform: uppercase; height:35px; width:200px;" placeholder="num inventario..."><input class="btn btn-primary" type="submit" class="search" id="buscador" value="Buscar">
                            </form>
                            <div class="card-tools">
                            </div>
                        </div>
                    </div>
        </section>

        <section class="content">
            <div class="container-fluid ">
                <!-- pantalla 1 -->

                <form action="../Controlador/guardar_asignacion_controlador.php" method="post" data-form="" class="FormularioAjax" autocomplete="off">

                    <div class="card card-default ">
                        <div class="card-header center">
                            <h2 class="card-title">Datos del producto por asignar</h2>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-6">

                                    <input type="hidden" id="prueba" name="prueba" value="<?php echo $inputTags['nombre']; ?>">

                                    <!-- BUSCADOR -->
                                    <?php
                                    include "../Controlador/buscador_asignacion.php";
                                    $producto = $_SESSION['producto'];
                                    $caracteristicas = $_SESSION['caracteristicas'];
                                    $inventario = $_SESSION['num_inventario'];
                                    $_SESSION['lo_que_busco'] = $inventario;
                                    ?>

                                    <input class="form-control" type="hidden" id="numero_inventario" name="numero_inventario" value="<?php echo $_SESSION['lo_que_busco']; ?>">

                                    <!--    ENTRADA DEL PRODUCTO QUE BUSCO  -->
                                    <input class="form-control" value="<?php echo $producto . '   ' . $caracteristicas; ?>" type="text" id="txt_propiedades" name="txt_propiedades" required="" maxlength="30" readonly="true" disabled="true" style="text-transform: uppercase; height:38px; width:590px;" onkeyup="Espacio(this, event)" onkeypress="return validacion_para_nombre_con_numeros(event)">


                                    <!-- FECHA DE LA ASIGNACIÓN  -->
                                    <div class="form-group">
                                        <label>Fecha de Asignación</label>
                                        <input class="form-control" type="date" min="<?php date_default_timezone_set('America/Tegucigalpa');
                                                                                        echo date("Y-m-d"); ?>" max="<?php date_default_timezone_set('America/Tegucigalpa');
                                                                                                                        echo date("Y-m-d"); ?>" value="<?php date_default_timezone_set('America/Tegucigalpa');
                                                                                                                                                        echo date("Y-m-d"); ?>" id="fecha_asignacion" name="fecha_asignacion" maxlength="30" style="text-transform:uppercase" onkeyup="Espacio(this, event)" onblur="document.getElementById('txt_nombre_oculto').value=this.value" required>
                                    </div>

                                    <!-- PERSONA RESPONSABLE -->
                                    <label>Persona responsable</label><br>
                                    <div class="input-group mb-6">
                                        <input class="form-control" type="text" id="txt_persona_responsable" name="txt_persona_responsable" value="<?php echo $inputTags['nombre']; ?>" required readonly>

                                        <div class="input-group-append">

                                            <button class="btn btn-primary" type="button" id="button-addon2" data-toggle="modal" data-target="#staticBackdrop">Buscar</button>

                                        </div>

                                    </div>

                                    <!-- Selector de Ubicación de Inventario -->
                                    <div class="form-group">
                                        <label>Ubicación de Inventario</label>
                                        <select class="form-control select2" style="width: 100%;" name="cmb_id_ubicacion" id="cmb_id_ubicacion" required>
                                            <option>Seleccione una ubicación:</option>
                                            <?php
                                            $query = $mysqli->query("SELECT * FROM tbl_ubicacion;");
                                            while ($resultado = mysqli_fetch_array($query)) {
                                                echo '<option value="' . $resultado['id_ubicacion'] . '"> ' . $resultado['ubicacion'] . '</option>';
                                            };
                                            ?>
                                        </select>
                                    </div>

                                    <!-- DESCRIPCION DE LA MOTIVACIÓN DE LA ASIGNACIÓN -->
                                    <div class="form-group ">
                                        <label>Motivo de asignación</label>
                                        <textarea class="form-control " class="tf w-input" required type="text" placeholder="ingrese la descripcion del motivo de asignación aquí" maxlength="100" name="motivo" id="motivo" onkeypress="return validacion_para_producto(event)" name="motivo" maxlength="100" style="text-transform: uppercase" onkeyup="DobleEspacio(this, event); MismaLetra('motivo');" rows="5" cols="40"></textarea>
                                    </div>

                                    <p class="text-center" style="margin-top: 20px;">
                                        <button type="submit" class="btn btn-primary" id="btn_guardar_asignacion" name="btn_guardar_asignacion" <?php echo $_SESSION['btn_guardar_asignacion']; ?>><i class="zmdi zmdi-floppy"></i> Asignar</button>
                                        <a href="../vistas/gestion_asignacion_vista.php" class="btn btn-danger"><i class="zmdi zmdi-floppy"></i> Cancelar</a>
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

        <!-- Modal para seleccionar persona responsable -->
        <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Buscar inventarios no asignados</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- Salida PHP para seleccionar productos no coincidentes (pasar a procedimiento) -->
                    <?php
                    $modelo = new respuesta();
                    $sqlRespUserResult = $modelo->asignacion();
                    //   $sqlRespUser = "SELECT per.id_persona as id_persona, CONCAT (per.nombres, ' ' ,per.apellidos) AS nombre FROM tbl_personas per WHERE per.Estado = 'ACTIVO'";
                    //  $sqlRespUserResult = $->query($sqlRespUser);        
                    ?>

                    <div class="modal-body">
                        <div class="card-body">
                            <p>
                                Seleccione un elemento de inventario pendiente de asignación
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

                                                    <form action="crear_asignacion_vista.php?id_usuario_responsable=<?php echo $rowIR['id_persona']; ?>" method="POST" autocomplete="off">
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

</body>

</html>

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


<script src="../js/pdf_gestion_laboratorio.js"></script>
<script type="text/javascript" src="../js/validaciones_gestion_laboratorio.js"></script>
<script type="text/javascript" src="../plugins/datatables/datatables.min.js"></script>
<!-- para usar botones en datatables JS -->
<script src="../plugins/datatables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>
<script src="../plugins/datatables/JSZip-2.5.0/jszip.min.js"></script>
<script src="../plugins/datatables/pdfmake-0.1.36/pdfmake.min.js"></script>
<script src="../plugins/datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
<script src="../plugins/datatables/Buttons-1.5.6/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="../js/pdf_mantenimientos.js"></script>
<script src="../plugins/select2/js/select2.min.js"></script>