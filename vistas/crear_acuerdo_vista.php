<?php
ob_start();
session_start();

require_once('../clases/Conexion.php');
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');
require_once('../clases/conexion_mantenimientos.php');

$dtz = new DateTimeZone("America/Tegucigalpa");
$dt = new DateTime("now", $dtz);
$hoy = $dt->format("Y-m-d");


$Id_objeto = 5007;

bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'Ingreso', 'A crear Acuerdo');

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

    <script src="../js/tipoacta-ajax.js"></script>

    <title></title>
</head>

<body>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <br>
                        <h1>Crear Acuerdo</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="pagina_principal_vista">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="menu_acuerdo_vista">Menú Acuerdos y Seguimientos</a></li>
                            <li class="breadcrumb-item active">Crear Acuerdo</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <form role="form" name="guardar-acuerdo" id="guardar-acuerdo" method="post" action="../Modelos/modelo_acuerdos.php">
                    <div class="card card-danger">
                        <div class="card-header">
                            <h3 class="card-title">Acuerdos</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Seleccione el acta:</label>
                                <select class="form-control select2" style="width: 35%;" name="acta" id="acta" required>
                                    <option value="-1">-- Seleccione --</option>
                                    <?php
                                    try {
                                        $sql = "SELECT
                                                id_acta,
                                                id_reunion,
                                                IF(
                                                    num_acta IS NULL or '',
                                                    'SIN No. ACTUALMENTE',
                                                    num_acta
                                                ) AS num_acta
                                            FROM
                                                tbl_acta
                                                WHERE id_estado = 2";
                                        $resultado = $mysqli->query($sql);
                                        while ($acta = $resultado->fetch_assoc()) { ?>
                                            <option value="<?php echo $acta['id_acta']; ?>">
                                                <?php echo $acta['num_acta']; ?>
                                            </option>
                                    <?php }
                                    } catch (Exception $e) {
                                        echo "Error: " . $e->getMessage();
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Responsable:</label>
                                <select class="form-control select2" style="width: 50%;" name="responsable" id="responsable" disabled="disabled" required>
                                    <!--Cargar lista de responsables-->
                                    <option value="selected">--Seleccione--</option>

                                </select>
                            </div>
                            <div class="form-group">
                                <label>Nombre del Acuerdo:</label>
                                <input onkeyup="MismaLetra('nombre_acuerdo');" onkeypress="return validacion(event)" onblur="limpia()" style="width: 35%;" type="text" class="form-control" id="nombre_acuerdo" name="nombre_acuerdo" placeholder="Ingrese nombre del acuerdo. (Mínimo 5 caracteres)" minlength="5" maxlength="40" required />
                            </div>
                            <div class="form-group">
                                <label>Descripción:</label>
                                <textarea onkeyup="MismaLetra('descripcion');" onkeypress="return validacion(event)" onblur="limpia()" class="form-control" placeholder="Ingrese la descripción del Acuerdo. (Mínimo 5 caracteres)" rows="5" id="descripcion" name="descripcion" minlength="5" maxlength="80" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Fecha Expiración:</label>
                                <div style="width: 20%;" class="input-group date">
                                    <input type="date" class="form-control " id="fecha_exp" name="fecha_exp" min="<?php echo $hoy; ?>" required />
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <!-- /.row -->
            <div style="padding: 0px 0 25px 30px;">
                <input type="hidden" name="estado" value="1">
                <input type="hidden" name="acuerdo" value="nuevo">
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
</script>

</html>
<script src="../js/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="../js/validaciones_mca.js"></script>


<script type="text/javascript">
    /********** Listar Responsable ***********/

    $(document).ready(function() {

        var responsable = $('#responsable');
        $("#acta").on("change", function() {

            var acta = $(this).val();
            console.log(acta);

            if (acta > -1 && acta != "") {
                responsable.removeAttr('disabled');
            } else {
                responsable.prop('disabled', 'disabled');
            }

            if (acta <= 0) {
                responsable
            }

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