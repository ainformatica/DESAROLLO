<?php
ob_start();
session_start();
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
$id = $_GET['id'];
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');

$Id_objeto = 5023;

bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'Ingreso', 'A Editar Estado Reunión');

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
                           window.location = "../vistas/menu_mantenimientoacta_vista.php";

                            </script>';
    // header('location:  ../vistas/menu_usuarios_vista.php');
} else {


    if (permisos::permiso_modificar($Id_objeto) == '1') {
        $_SESSION['btn_editar'] = "";
    } else {
        $_SESSION['btn_editar'] = "disabled";
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
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Editar estado</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="pagina_principal_vista">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="menu_mantenimientoacta_vista">Menú Mantenimiento actas</a></li>
                            <li class="breadcrumb-item active">Editar estado</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <?php
            $sql = "SELECT * FROM `tbl_estado_reunion` WHERE `id_estado_reunion` = $id ";
            $resultado = $mysqli->query($sql);
            $estado = $resultado->fetch_assoc();

            ?>
            <form role="form" name="guardar-estadoreunion" id="guardar-estadoreunion" method="post" action="../Modelos/modelo_manreunion.php">
                <div class="card-body" style="padding-top: 100px;">
                    <div class="form-group">
                        <label for="tipo">Nombre Estado: </label>
                        <input type="text" value="<?php echo $estado['estado_reunion']; ?>" class="form-control" class="form-control col-md-6" id="estado" name="estado" placeholder="Ingrese un estado nuevo. (Mínimo 3 caracteres)" onkeyup="MismaLetra('estado');" required title="Solo se permiten MAYÚSCULAS y no se Aceptan caracteres especiales" minlength="3" maxlength="15" pattern="[A-Z\s]{1,15}">
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer" style="background: white;">
                    <input type="hidden" name="estado-reunion" value="actualizar">
                    <input type="hidden" name="id_estado" value="<?php echo $id; ?>">
                    <button type="submit" class="btn btn-success" id="editar_registro">Guardar cambios</button>
                    <a type="button" data-toggle="modal" data-target="#modal-default" href="#" class="btn btn-danger" style="color: white;">Cancelar</a>
                </div>
            </form>
    </div>
    <!-- /.content-wrapper -->
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
            <a style="color: white ;" type="button" class="btn btn-primary" href="mantenimiento_estadoreunion_vista">Sí, deseo cancelar</a>
            <a style="color: white ;" type="button" class="btn btn-danger" data-dismiss="modal">No</a>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->





    <script type="text/javascript" language="javascript">
        function ventana() {
            window.open("../Controlador/reporte_mantenimiento_estadoactareunion_controlador.php", "REPORTE");
        }
    </script>



    <script type="text/javascript">
        $(function() {

            $('#tabla11').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "responsive": true,
            });
        });

        window.onload = function() {
    var nom = document.getElementById('estado');

    
   
    nom.onpaste = function(e) {
      e.preventDefault();
      swal('Error', '<h5>La acción de <b>pegar</b> está prohibida</h5>', 'error');
    }
    
    nom.oncopy = function(e) {
      e.preventDefault();
      swal('Error', '<h5>La acción de <b>copiar</b> está prohibida</h5>', 'error');
    }
}
document.getElementById("estado").addEventListener("keydown", teclear);

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


</body>

</html>
<script type="text/javascript" src="../js/funciones_registro_docentes.js"></script>
<script type="text/javascript" src="../js/validar_registrar_docentes.js"></script>

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
<script type="text/javascript" src="../js/validaciones_mca.js"></script>
<script src="../js/tipoacta-ajax.js"></script>