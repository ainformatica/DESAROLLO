<?php
ob_start();
session_start();

require_once('../clases/Conexion.php');
$id = $_GET['id'];
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');
require_once('../clases/conexion_mantenimientos.php');

$dtz = new DateTimeZone("America/Tegucigalpa");
$dt = new DateTime("now", $dtz);
$hoy = $dt->format("Y-m-d");

$Id_objeto = 5008;

bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'Ingreso', 'A Editar Acuerdo');

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
    <link rel=" stylesheet" type="text/javascript" href="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="../js/tipoacta-ajax.js"></script>

    <script type="text/javascript">
        $(window).on('load', function() {

            $('.selectpicker').selectpicker({
                'selectedText': 'cat'
            });

        });
    </script>
    <title></title>
</head>

<body>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6"><br>
                        <h1>Editar Acuerdo</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="pagina_principal_vista">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="menu_acuerdo_vista">Menú Acuerdos y Seg.</a></li>
                            <li class="breadcrumb-item"><a href="acuerdos_pendientes_vista">Acuerdos Pendientes</a></li>
                            <li class="breadcrumb-item active">Editar Acuerdo</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <?php
            $sql = "SELECT * FROM `tbl_acuerdos` WHERE `id_acuerdo` = $id ";
            $resultado = $mysqli->query($sql);
            $estado = $resultado->fetch_assoc();
            ?>
            <div class="container-fluid">
                <form role="form" name="editar-acuerdo" id="editar-acuerdo" method="post" action="../Modelos/modelo_acuerdos.php">
                    <div class="card card-danger">
                        <div class="card-header">
                            <h3 class="card-title">Acuerdos</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Seleccione el acta:</label>
                                <select class="form-control " style="width: 35%;" name="acta" id="acta">
                                    <?php
                                    try {
                                        $tipo_actual = $estado['id_acta'];
                                        $sql = "SELECT
                                        id_acta,
                                        id_reunion,
                                        IF(
                                            num_acta IS NULL or '',
                                            'SIN No. ACTUALMENTE',
                                            num_acta
                                        ) AS acta
                                    FROM
                                        tbl_acta";
                                        $resultado = $mysqli->query($sql);
                                        while ($tipo_reunion = $resultado->fetch_assoc()) {
                                            if ($tipo_reunion['id_acta'] == $tipo_actual) { ?>
                                                <option value="<?php echo $tipo_reunion['id_acta']; ?>" selected>
                                                    <?php echo $tipo_reunion['acta']; ?>
                                                </option>
                                            <?php } else { ?>

                                    <?php }
                                        }
                                    } catch (Exception $e) {
                                        echo "Error: " . $e->getMessage();
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Responsable:</label>
                                <select required class="form-control" class="selectpicker show-tick form-control" style="width: 50%;" name="responsable" id="responsable">
                                    <!--Participantes por acta-->
                                    <?php
                                    try {
                                        $responsable_actual = $estado['id_participante'];
                                        $sql = "SELECT 
                                        t1.id_persona,concat_ws(' ', t1.nombres, t1.apellidos) as nombres
                                        FROM tbl_personas t1 
                                        INNER JOIN tbl_horario_docentes t2 ON t2.id_persona = t1.id_persona 
                                        INNER JOIN tbl_jornadas t3 ON t2.id_jornada = t3.id_jornada 
                                        ORDER BY nombres ASC";
                                        $resultado = $mysqli->query($sql);
                                        while ($tipo_reunion = $resultado->fetch_assoc()) {
                                            if ($tipo_reunion['id_persona'] == $responsable_actual) { ?>
                                                <option value="<?php echo $tipo_reunion['id_persona']; ?>" selected>
                                                    <?php echo $tipo_reunion['nombres']; ?>
                                                </option>
                                            <?php } else { ?>
                                                <option value="<?php echo $tipo_reunion['id_persona']; ?>">
                                                    <?php echo $tipo_reunion['nombres']; ?>
                                                </option>
                                    <?php }
                                        }
                                    } catch (Exception $e) {
                                        echo "Error: " . $e->getMessage();
                                    }
                                    ?>

                                </select>
                            </div>
                            <div class="form-group">
                                <label>Nombre del Acuerdo:</label>
                                <input required onkeyup="MismaLetra('nombre_acuerdo');" onkeypress="return validacion(event)" onblur="limpia()" style="width: 35%;" type="text" class="form-control" id="nombre_acuerdo" value="<?php echo $estado['nombre_acuerdo']; ?>" name="nombre_acuerdo" minlength="5" maxlength="40" placeholder="Ingrese nombre del acuerdo. (Mínimo 5 caracteres)">
                            </div>
                            <div class="form-group">
                                <label>Descripción:</label>
                                <textarea onkeyup="MismaLetra('descripcion');" onkeypress="return validacion(event)" onblur="limpia()" class="form-control" placeholder="Ingrese la descripción del Acuerdo. (Mínimo 5 caracteres)" rows="5" id="descripcion" name="descripcion" minlength="5" maxlength="80" required><?php echo $estado['descripcion']; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Fecha Expiración:</label>
                                <div style="width: 20%;" class="input-group date">
                                    <input required style="width: 40%;" value="<?php echo $estado['fecha_expiracion']; ?>" type="date" class="form-control datetimepicker-input" id="fecha_exp" name="fecha_exp" min="<?php echo $hoy; ?>" />

                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <!-- /.row -->
            <div style="padding: 0px 0 25px 25px;">
                <input type="hidden" name="id_registro" value="<?php echo $id; ?>">
                <input type="hidden" name="acuerdo" value="actualizar">
                <button style="color: white !important;" type="submit" class="btn btn-primary" <?php echo $_SESSION['btn_crear']; ?>>Guardar</button>
                <a style="color: white !important;" class="btn btn-danger" data-toggle="modal" data-target="#modal-default" href="#">Cancelar</a>
            </div>
            </form>
        </section>
        <!-- /.card-body -->
    </div>
    <div class="modal fade justify-content-center" id="modal-default">

        <div class="modal-dialog modal-dialog-centered modal-sm justify-content-center">
            <div class="modal-content lg-secondary">
                <div class="modal-header">
                    <h4 style="padding-left: 19%;" class="modal-title"><b>¿Desea cancelar?</b></h4>
                </div>
                <div class="modal-body justify-content-center">
                    <p style="padding-left: 6%;">¡Lo que haya escrito no se guardará!</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <a style="color: white ;" type="button" class="btn btn-primary" href="acuerdos_pendientes_vista">Sí, deseo cancelar</a>
                    <a style="color: white ;" type="button" class="btn btn-danger" data-dismiss="modal">No</a>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

</body>
<script type="text/javascript">
    $(function() {
        $('#example1').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "responsive": true,
        });
    });

    /* jQuery(document).ready(function($) {
         $(document).ready(function() {
             $('#responsable').select2();
         });
     });*/
     document.getElementById("nombre_acuerdo").addEventListener("keydown", teclear);
    document.getElementById("descripcion").addEventListener("keydown", teclear);

var flag = false;
var teclaAnterior = "";

function teclear(event) {
  teclaAnterior = teclaAnterior + " " + event.keyCode;
  var arregloTA = teclaAnterior.split(" ");
  if (event.keyCode == 32 && arregloTA[arregloTA.length - 2] == 32) {
    event.preventDefault();
  }
}
</script>

</html>
<script type="text/javascript" src="../js/funciones_registro_docentes.js"></script>
<script type="text/javascript" src="../js/validar_registrar_docentes.js"></script>

<script type="text/javascript" src="../js/pdf_mantenimientos.js"></script>
<script src="../plugins/select2/js/select2.min.js"></script>
<!-- Select2 -->
<script src="../plugins/select2/js/select2.full.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<!-- datatables JS -->
<script type="text/javascript" src="../plugins/datatables/datatables.min.js"></script>
<!-- para usar botones en datatables JS -->
<script src="../plugins/datatables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>
<script src="../plugins/datatables/JSZip-2.5.0/jszip.min.js"></script>
<script src="../plugins/datatables/pdfmake-0.1.36/pdfmake.min.js"></script>
<script src="../plugins/datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
<script src="../plugins/datatables/Buttons-1.5.6/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="../js/validaciones_mca.js"></script>
<script>
    /********** Listar Responsable ***********/

    $(document).ready(function() {

        var responsable = $('#responsable');
        $("#acta").on("change", function() {

            var acta = $(this).val();
            console.log(acta);
            $.ajax({
                    type: 'POST',
                    url: "../Controlador/cargar_responsable_acta.php",
                    data: {
                        acta: acta
                    }
                })
                .done(function(data) {
                    responsable.html(data);
                    console.log(responsable)
                })
                .fail(() => {
                    alert("Error al cargar lista de responsables")
                });
        });
    });
    window.onload = function() {
    var nacuerdo = document.getElementById('nombre_acuerdo');
    var desc = document.getElementById('descripcion');
    
    desc.onpaste = function(e) {
        e.preventDefault();
        swal('Error', '<h5>La acción de <b>pegar</b> está prohibida</h5>', 'error');
      }
      
      desc.oncopy = function(e) {
        e.preventDefault();
        swal('Error', '<h5>La acción de <b>copiar</b> está prohibida</h5>', 'error');
      }
    nacuerdo.onpaste = function(e) {
        e.preventDefault();
        swal('Error', '<h5>La acción de <b>pegar</b> está prohibida</h5>', 'error');
      }
      
      nacuerdo.oncopy = function(e) {
        e.preventDefault();
        swal('Error', '<h5>La acción de <b>copiar</b> está prohibida</h5>', 'error');
      }
    }
</script>