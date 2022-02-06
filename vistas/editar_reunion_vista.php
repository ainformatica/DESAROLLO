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
$Id_objeto = 5002;

bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'Ingreso', 'A Editar Reunión');

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
    <style>
        input[type=checkbox]:checked+label.strikethrough {
            text-decoration: line-through;
            color: red;
            position: relative;
            top: 3px
        }
    </style>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Editar Reunión</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="pagina_principal_vista">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="menu_reunion_vista">Menú Reuniones</a></li>
                            <li class="breadcrumb-item active">Editar Reunión</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>





        <!-- Main content -->
        <section class="content">
            <?php
            $sql = "SELECT * FROM `tbl_reunion` WHERE `id_reunion` = $id ";
            $resultado = $mysqli->query($sql);
            $estado = $resultado->fetch_assoc();

            ?>
            <div class="container-fluid">
                <form role="form" name="editar-reunion" id="editar-reunion" method="post" action="../Modelos/modelo_reunion.php">
                    <div style="padding: 0px 0 25px 0; float: right;">
                        <input type="hidden" name="id_registro" value="<?php echo $id; ?>">
                        <input type="hidden" name="reunion" value="actualizar">
                        <button style="padding-right: 15px;" type="submit" class="btn btn-success float-left" id="editar_registro" <?php echo $_SESSION['btn_crear']; ?>>Guardar Cambios</button>
                        <a style="color: white !important; margin: 0px 0px 0px 10px;" class="cancelar-reunion btn btn-danger" data-toggle="modal" data-target="#modal-default" href="#">Cancelar</a>
                    </div><br><br><br>
                    <div class="card card-primary card-outline card-tabs">
                        <div class="card-header p-0 pt-1 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="datosgenerales-tab" data-toggle="pill" href="#datosgenerales" role="tab" aria-controls="datosgenerales" aria-selected="false">Datos Generales y Asistencia</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " id="datosreunion-tab" data-toggle="pill" href="#datosreunion" role="tab" aria-controls="datosreunion" aria-selected="true">Listado participantes</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-three-tabContent">
                                <div class="tab-pane fade active show" id="datosgenerales" role="tabpanel" aria-labelledby="datosgenerales-tab">
                                    <div class="row">
                                        <!-- left column -->
                                        <div class="col-md-6">
                                            <!-- general form elements -->
                                            <div class="card card-primary">
                                                <div class="card-header">
                                                    <h3 class="card-title">Datos Generales</h3>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label for="nombre">Nombre:</label>
                                                        <input onkeypress="return validacion(event)" onblur="limpia()" onkeyup="MismaLetra('nombre');" required maxlength="50" minlength="5" type="text" value="<?php echo $estado['nombre_reunion']; ?>" class="form-control" id="nombre" name="nombre" placeholder="Ingrese nombre de la Reunion. (Mínimo 5 caracteres)">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="tipo">Modalidad de Reunión</label>
                                                        <select class="form-control" onchange="showInp()" style="width: 50%;" id="tipo" name="tipo">
                                                            <option value="0">-- Seleccione una Modalidad --</option>
                                                            <?php
                                                            try {
                                                                $tipo_actual = $estado['id_tipo'];
                                                                $sql = "SELECT * FROM tbl_tipo_reunion_acta ";
                                                                $resultado = $mysqli->query($sql);
                                                                while ($tipo_reunion = $resultado->fetch_assoc()) {
                                                                    if ($tipo_reunion['id_tipo'] == $tipo_actual) { ?>
                                                                        <option value="<?php echo $tipo_reunion['id_tipo']; ?>" selected>
                                                                            <?php echo $tipo_reunion['tipo']; ?>
                                                                        </option>
                                                                    <?php } else { ?>
                                                                        <option value="<?php echo $tipo_reunion['id_tipo']; ?>">
                                                                            <?php echo $tipo_reunion['tipo']; ?>
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
                                                        <label for="lugar">Lugar:</label>
                                                        <input onkeypress="return validacion(event)" onblur="limpia()" required minlength="4" maxlength="30" value="<?php echo $estado['lugar']; ?>" style="width: 100%;" type="text" class="form-control" id="lugar" name="lugar" placeholder="Lugar donde se dearrollara la Reunion. (Mínimo 4 caracteres)" onkeyup="MismaLetra('lugar');">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="fecha">Fecha:</label>
                                                        <input required style="width: 40%;" value="<?php echo $estado['fecha']; ?>" type="date" class="form-control datetimepicker-input" id="fecha" title="Por favor seleccione una fecha mas reciente" name="fecha" min="<?php echo $hoy; ?>" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="horainicio">Hora Inicio: </label>
                                                        <input required style="width: 30%;" type="time" value="<?php echo $estado['hora_inicio']; ?>" class="form-control" id="horainicio" name="horainicio" min="6:00" max="23:00:00">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="horafinal">Hora Final: </label>
                                                        <input required style="width: 30%;" type="time" value="<?php echo $estado['hora_final']; ?>" class="form-control" id="horafinal" name="horafinal" min="6:30">
                                                    </div>
                                                    <div class="form-group">
                                                        <label id="enlaces" for="enlace">Enlace de la Reunión:</label>
                                                        <input value="<?php echo $estado['enlace']; ?>" minlength="10" maxlength="1000" type="text" class="form-control" id="enlace" name="enlace" placeholder="Ingrese el Link de la Reunion">
                                                    </div>
                                                </div>
                                                <!-- /.card-body -->
                                            </div>
                                            <!-- /.card -->
                                        </div>
                                        <!--/.col (left) -->
                                        <!-- right column -->
                                        <div class="col-md-6">
                                            <!-- Form Element sizes -->
                                            <div class="card card-success">
                                                <div class="card-header">
                                                    <h3 class="card-title">Datos de la Reunión</h3>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label for="asunto">Asunto:</label>
                                                        <textarea onkeyup="MismaLetra('asunto');" onkeypress="return validacion(event)" onblur="limpia()" required minlength="5" maxlength="50" class="form-control" id="asunto" name="asunto" rows="3" placeholder="Ingrese el asunto de la Reunión. (Mínimo 5 caracteres)"><?php echo $estado['asunto']; ?></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="agenda">Agenda Propuesta</label>
                                                        <textarea onkeyup="MismaLetra('agenda');" onkeypress="return validacion(event)" onblur="limpia()" required minlength="5" maxlength="65000" class="form-control" id="agenda" name="agenda" rows="13" placeholder="Ingrese Agenda Propuesta. (Mínimo 5 caracteres)"><?php echo $estado['agenda_propuesta']; ?></textarea>
                                                    </div>
                                                </div>
                                                <!-- /.card-body -->
                                            </div>
                                        </div>
                                        <!--/.col (right) -->
                                    </div>
                                </div>
                                <div class="tab-pane fade " id="datosreunion" role="tabpanel" aria-labelledby="datosreunion-tab">
                                    <!-- /.row -->
                                    <div class="card card-warning">
                                        <div class="card-header">
                                            <h3 class="card-title">Participantes</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="col-12">
                                                <!-- /.card -->
                                                <div class="card">
                                                    <div>
                                                        <a style="color: white !important; float: right; margin: 15px;" type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fas fa-user-check"></i> agregar participante</a>
                                                    </div>
                                                    <div style="padding: 15px 0px 0px 15px;">
                                                        <p>
                                                            Listado de personas que están invitadas actualmente <br> <b>SELECCIONA UNA PERSONA PARA ELIMINARLA DE LOS INVITADOS</b>
                                                        </p>
                                                    </div>
                                                    <!-- /.card-header -->
                                                    <div class="card-body">
                                                        <table class="table table-bordered table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>Nombre Participante</th>
                                                                    <th>Tipo Contrado</th>
                                                                </tr>
                                                            </thead>
                                                            <?php
                                                            try {
                                                                $sql = "SELECT
                                                    t1.id_persona,
                                                    CONCAT_WS(' ', t1.nombres, t1.apellidos) AS nombres,
                                                    t3.jornada
                                                FROM
                                                    tbl_personas t1
                                                INNER JOIN tbl_horario_docentes t2 ON
                                                    t2.id_persona = t1.id_persona
                                                INNER JOIN tbl_jornadas t3 ON
                                                    t2.id_jornada = t3.id_jornada
                                                INNER JOIN tbl_participantes t4 ON
                                                    t4.id_persona = t1.id_persona
                                                WHERE
                                                    t4.id_reunion = $id
                                                ORDER BY
                                                    nombres ASC";
                                                                $resultado = $mysqli->query($sql);
                                                            } catch (Exception $e) {
                                                                $error = $e->getMessage();
                                                                echo $error;
                                                            }
                                                            while ($estadoacta = $resultado->fetch_assoc()) { ?>
                                                                <tr>
                                                                    <td>
                                                                        <div class="icheck-danger d-inline">
                                                                            <input type="checkbox" id="<?php echo $estadoacta['id_persona']; ?>" name="invitados[]" value="<?php echo $estadoacta['id_persona']; ?>">
                                                                            <label class="strikethrough" for="<?php echo $estadoacta['id_persona']; ?>">
                                                                                <?php echo $estadoacta['nombres']; ?>
                                                                            </label>
                                                                        </div>
                                                                    </td>
                                                                    <td><?php echo $estadoacta['jornada']; ?></td>
                                                                </tr>
                                                            <?php  }  ?>
                                                        </table>
                                                    </div>
                                                    <!-- /.card-body -->
                                                </div>
                                                <!-- /.card -->
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                </div>


                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.modal -->
                    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nombre Participante</th>
                                                <th>Tipo Contrado</th>
                                            </tr>
                                        </thead>

                                        <body>
                                            <?php
                                            try {
                                                $sql = "SELECT t1.id_persona,concat_ws(' ', t1.nombres, t1.apellidos) as nombres, t3.jornada FROM tbl_personas t1 INNER JOIN tbl_horario_docentes t2 ON t2.id_persona = t1.id_persona INNER JOIN tbl_jornadas t3 ON t2.id_jornada = t3.id_jornada ORDER BY nombres ASC";
                                                $resultado = $mysqli->query($sql);
                                            } catch (Exception $e) {
                                                $error = $e->getMessage();
                                                echo $error;
                                            }
                                            while ($estadoacta = $resultado->fetch_assoc()) { ?>
                                                <tr>
                                                    <td>
                                                        <div class="icheck-danger d-inline">
                                                            <input type="checkbox" id="<?php echo $estadoacta['id_persona']; ?>" name="chk[]" value="<?php echo $estadoacta['id_persona']; ?>">
                                                            <label for="<?php echo $estadoacta['id_persona']; ?>">
                                                                <?php echo $estadoacta['nombres']; ?>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td><?php echo $estadoacta['jornada']; ?></td>
                                                </tr>
                                            <?php  }  ?>
                                        </body>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                                <div class="modal-footer justify-content-center">
                                    <a style="color: white ;" type="button" class="btn btn-success" data-dismiss="modal">Listo</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- /.modal -->


            </div>
            <!-- /.container-fluid -->
            </form>
        </section>
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
            <a style="color: white ;" type="button" class="btn btn-primary" href="reuniones_pendientes_vista">Sí, deseo cancelar</a>
            <a style="color: white ;" type="button" class="btn btn-danger" data-dismiss="modal">No</a>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    </div>
    
    <script type="text/javascript">
        function mayus(e) {
            e.value = e.value.toUpperCase();
        }
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
        const fec = "<?php echo $hoy; ?>";

        
        $("#guardar-reunion").submit(function () {  
    if($("#nombre").val().length < 5) { 
        e.preventDefault();
        swal('Error', '<h5>El <b>Nombre</b> debe tener como mínimo 5 caracteres</h5>', 'error');  
        return false;  
    }  
    return false;  
});  

$("#editar-reunion").submit(function () {  
    if($("#lugar").val().length < 4) { 
        e.preventDefault();
        swal('Error', '<h5>El <b>Lugar</b> debe tener como mínimo 4 caracteres</h5>', 'error');  
        return false;  
    }  
    return false;  
});  
$("#editar-reunion").submit(function () {  
    if($("#asunto").val().length < 5) { 
        e.preventDefault();
        swal('Error', '<h5>El <b>Asunto</b> debe tener como mínimo 5 caracteres</h5>', 'error');  
        return false;  
    }  
    return false;  
});  
$("#editar-reunion").submit(function () {  
    if($("#agenda").val().length < 5) { 
        e.preventDefault();
        swal('Error', '<h5>La <b>Agenda</b> debe tener como mínimo 5 caracteres</h5>', 'error');  
        return false;  
    }  
    return false;  
});  
$("#editar-reunion").submit(function () {  
    if($("#horainicio").val() < "06:00") { 
        e.preventDefault();
        swal('Error', '<h5><b>Hora de Inicio</b> debe de ser mayor que 6:00 A.M.</h5>', 'error');  
        return false;  
    }  
    return false;  
});  
$("#editar-reunion").submit(function () {  
    if($("#horainicio").val() > "23:30") {
        e.preventDefault(); 
        swal('Error', '<h5><b>Hora de Inicio</b> debe de ser menor que 23:30 P.M.</h5>', 'error');  
        return false;  
    }  
    return false;  
});  
$("#editar-reunion").submit(function () {  
    if($("#horafinal").val() < "06:30") { 
        e.preventDefault();
        swal('Error', '<h5><b>Hora de Final</b> No debe de ser menor que 07:30 A.M.</h5>', 'error');  
        return false;  
    }  
    return false;  
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

<!-- datatables JS -->
<script type="text/javascript" src="../plugins/datatables/datatables.min.js"></script>
<!-- para usar botones en datatables JS -->
<script src="../plugins/datatables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>
<script src="../plugins/datatables/JSZip-2.5.0/jszip.min.js"></script>
<script src="../plugins/datatables/pdfmake-0.1.36/pdfmake.min.js"></script>
<script src="../plugins/datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
<script src="../plugins/datatables/Buttons-1.5.6/js/buttons.html5.min.js"></script>
<script src="../js/tipoacta-ajax.js"></script>
<script type="text/javascript" src="../js/validaciones_mca.js"></script>
