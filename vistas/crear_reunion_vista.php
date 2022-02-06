<?php
ob_start();
session_start();
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');
$dtz = new DateTimeZone("America/Tegucigalpa");
$dt = new DateTime("now", $dtz);
$hoy = $dt->format("Y-m-d");

$Id_objeto = 5000;

bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'Ingreso', 'A crear Reunión');

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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
                        <h1>Agendar una Reunión</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="pagina_principal_vista">Inicio</a></li>
                           <li class="breadcrumb-item"><a href="menu_reunion_vista">Menú Reuniones</a></li>
                            <li class="breadcrumb-item active">Crear Reunión</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary card-outline card-tabs">
                    <div class="card-header p-0 pt-1 border-bottom-0">
                        <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="datosgenerales-tab" data-toggle="pill" href="#datosgenerales" role="tab" aria-controls="datosgenerales" aria-selected="false">Datos Generales y Datos Reunión</a>
                            </li>
                            <li class="nav-item">
                                <a style="display: none;" class="nav-link " id="datosreunion-tab" data-toggle="pill" href="#datosreunion" role="tab" aria-controls="datosreunion" aria-selected="true">Participantes</a>
                            </li>
                            <li class="nav-item">
                            <form role="form" name="guardar-reunion" id="guardar-reunion" method="post" action="../Modelos/modelo_reunion.php" >
                            <div class="form-control" style="padding: 0px 0 0px 0; margin: 0px 0px 5px 10px;">
                               <input type="hidden" name="estado" value="1">
                               <input type="hidden" name="reunion" value="nuevo">
                               <button type="submit" class="btn btn-success float-right bloquear" <?php echo $_SESSION['btn_crear']; ?> disabled>Agendar</button> 
                               <a style="color: white !important; padding-left: 10px;" class="cancelar-reunion btn btn-danger" data-toggle="modal" data-target="#modal-default" href="#" id="confirm">Cancelar</a>
                            </div>
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
                                                        <input onkeyup="MismaLetra('nombre');" onkeypress="return validacion(event)" onblur="limpia()" required="" minlength="5" maxlength="50"  onchange="showdatos()"  type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese nombre de la Reunión. (Mínimo 5 caracteres)">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="tipo">Tipo de Modalidad</label>
                                                        <select class="form-control" onChange="showInp(); showdatos();" style="width: 50%;" id="tipo" name="tipo">
                                                            <option value="0">Seleccione una modalidad</option>
                                                            <?php
                                                            try {
                                                                $sql = "SELECT * FROM tbl_tipo_reunion_acta ";
                                                                $resultado = $mysqli->query($sql);
                                                                while ($tipo_reunion = $resultado->fetch_assoc()) { ?>
                                                                    <option value="<?php echo $tipo_reunion['id_tipo']; ?>">
                                                                        <?php echo $tipo_reunion['tipo']; ?>
                                                                    </option>
                                                            <?php }
                                                            } catch (Exception $e) {
                                                                echo "Error: " . $e->getMessage();
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="lugar">Lugar:</label>
                                                        <input onkeyup="MismaLetra('lugar');" onkeypress="return validacion(event)" onblur="limpia()" required="" minlength="4" maxlength="30" onchange="showdatos()" style="width: 100%;" type="text" class="form-control" id="lugar" name="lugar" placeholder="Lugar donde se desarrollará la Reunión. (Mínimo 4 caracteres)">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="fecha">Fecha:</label>
                                                        <input required style="width: 40%;" onchange="showdatos()" type="date" class="form-control datetimepicker-input" id="fecha" name="fecha" min="<?php echo $hoy; ?>" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="horainicio">Hora Inicio: </label>
                                                        <input required style="width: 30%;" onchange="showdatos()" type="time" class="form-control" id="horainicio" name="horainicio" value="05:00" min="5:00" max="23:30">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="horafinal">Hora Final: </label>
                                                        <input required style="width: 30%;" onchange="showdatos()" type="time" class="form-control" id="horafinal" name="horafinal" min="5:30" >
                                                    </div>
                                                    <div class="form-group">
                                                        <label style="display: none;" id="enlaces" for="enlace">Enlace de la Reunión:</label>
                                                        <input style="display: none;"  maxlength="1000" type="text" class="form-control" id="enlace" name="enlace" placeholder="Ingrese el Link de la Reunión">
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
                                                    <textarea onkeyup="MismaLetra('asunto');" type="text" onkeypress="return validacion(event)" minlength="5"  maxlength="50" onchange="showdatos()"  class="form-control" id="asunto" name="asunto" rows="3" placeholder="Ingrese el asunto de la Reunión. (Mínimo 5 caracteres)"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="agenda">Agenda Propuesta</label>
                                                    <textarea onkeyup="MismaLetra('agenda');" onkeypress="return validacion(event)" onblur="limpia()" required minlength="5" maxlength="65000" onchange="showdatos()"  class="form-control" id="agenda" name="agenda" rows="13" placeholder="Ingrese la Agenda Propuesta. (Mínimo 5 caracteres)"></textarea>
                                                </div>
                                            </div>
                                            <!-- /.card-body -->
                                        </div>
                                    </div>
                                    <!--/.col (right) -->
                                </div>
                                <!-- /.row -->
                            </div>
                            <div class="tab-pane fade " id="datosreunion" role="tabpanel" aria-labelledby="datosreunion-tab">
                                <div class="form-group">
                                    <label for="tipo">Tipo de Reunión</label>
                                    <select class="form-control" onChange="reuOnChange(this)" ; style="width: 50%;" id="clasif" name="clasif">
                                        <option value="1">-- Selecione un Tipo --</option>
                                        <option value="2">ASAMBLEA</option>
                                        <option value="3">REUNIONES DE DEPARTAMENTO</option>
                                    </select>
                                </div>
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Participantes</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="col-12">
                                            <!-- /.card -->
                                            <div class="card">
                                                
                                                <div id="reu-normal" style="display:none;">


                                                    <div class="icheck-danger d-inline" style="padding: 15px 0px 0px 15px;">
                                                        <input  type="checkbox" id="checkboxPrimary10" name="selectall" onclick="marcar(this);">
                                                        <label for="checkboxPrimary10">
                                                            Seleccionar/Deseleccionar Todo
                                                        </label>
                                                    </div>


                                                    <!-- /.card-header -->
                                                    <div class="card-body">
                                                        <table id="" class="table table-bordered table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>Nombre Participante</th>
                                                                    <th>Tipo Contrado</th>
                                                                </tr>
                                                            </thead>

                                                            <body>
                                                                <?php
                                                                try {
                                                                    $sql = "SELECT t1.id_persona, CONCAT_WS(' ', t1.nombres, t1.apellidos) AS nombres, t3.jornada
                                                                    FROM tbl_personas t1
                                                                    INNER JOIN tbl_horario_docentes t2 ON t2.id_persona = t1.id_persona
                                                                    INNER JOIN tbl_jornadas t3 ON t2.id_jornada = t3.id_jornada
                                                                    ORDER BY nombres ASC";
                                                                    $resultado = $mysqli->query($sql);
                                                                } catch (Exception $e) {
                                                                    $error = $e->getMessage();
                                                                    echo $error;
                                                                }
                                                                while ($estadoacta = $resultado->fetch_assoc()) { ?>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="icheck-danger d-inline">
                                                                                <input class="normal"  type="checkbox" id="<?php echo $estadoacta['id_persona']; ?>" name="chknormal[]" value="<?php echo $estadoacta['id_persona']; ?>">
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
                                                </div>
                                                <div id="reu-asamblea" style="display: none;">


                                                    <div class="icheck-danger d-inline" style="padding: 15px 0px 0px 15px;">
                                                        <input type="checkbox" id="checkboxPrimary10" name="selectall" onclick="marcar(this);">
                                                        <label for="checkboxPrimary10">
                                                            Seleccionar/Deseleccionar Todo
                                                        </label>
                                                    </div>


                                                    <!-- /.card-header -->
                                                    <div class="card-body">
                                                        <table id="" class="table table-bordered table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>Nombre Participante</th>
                                                                    <th>Tipo Contrado</th>
                                                                </tr>
                                                            </thead>

                                                            <body>
                                                                <?php
                                                                try {
                                                                    $sql = "SELECT t1.id_persona+10000 AS id_persona, CONCAT_WS(' ', t1.nombres, t1.apellidos) AS nombres, t3.jornada
                                                                    FROM tbl_personas t1
                                                                    INNER JOIN tbl_horario_docentes t2 ON t2.id_persona = t1.id_persona
                                                                    INNER JOIN tbl_jornadas t3 ON t2.id_jornada = t3.id_jornada
                                                                    WHERE t3.jornada = 'TIEMPO COMPLETO' OR t3.jornada = 'MEDIO TIEMPO'
                                                                    ORDER BY nombres ASC";
                                                                    $resultado = $mysqli->query($sql);
                                                                } catch (Exception $e) {
                                                                    $error = $e->getMessage();
                                                                    echo $error;
                                                                }
                                                                while ($estadoacta = $resultado->fetch_assoc()) { ?>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="icheck-danger d-inline">
                                                                                <input class="asamblea" type="checkbox" id="<?php echo $estadoacta['id_persona']; ?>" name="chk[]" value="<?php echo $estadoacta['id_persona']; ?>">
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
                                                </div>
                                                <!-- /.card-body -->
                                            </div>
                                            <!-- /.card -->
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.container-fluid -->
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
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

    <?php
    $sql = "SELECT
    t1.id_reunion +1 AS valor
FROM
    tbl_reunion t1
ORDER BY
    t1.id_reunion
DESC
LIMIT 1";
    $resultado = $mysqli->query($sql);
    $ultimo = $resultado->fetch_assoc();
    ?>

    
    <script>
        
/********** guardar reunion ***********/
$('#guardar-reunion').on('submit', function(e) {
    e.preventDefault();
    var datos = $(this).serializeArray();
    $.ajax({
        type: $(this).attr('method'),
        data: datos,
        url: $(this).attr('action'),
        dataType: 'json',
        success: function(data) {
            console.log(data);
            var resultado = data;
            if (resultado.respuesta == 'exito') {
                swal({
                    title: "Correcto",
                    text: "Se Agendo correctamente!",
                    type: "success",
                    allowOutsideClick: false, //bloquear click fuera
                    confirmButtonText: "Ir a Reuniones Pendientes",
                    html: `<h3>La reunión se Agendo con Exito!</h3>
                        <br>
                        ¿Ahora que desea hacer?
                        <br>
                        <b><a target="_blank" href="../pdf/reporte_memorandum.php?id=<?php echo $ultimo['valor']; ?>">Ver Reporte</a></b>
                        <br><br><br>
                        <a style="padding: 4px 25px; background: rgb(225, 33, 33); border: 1px solid #B91C1C; color: #fff; border-radius: 4px; text-decoration:none;" href="pagina_principal_vista"><b>Salir</b></a>`,
                        
                }).then(function() {
                    location.href = "../vistas/reuniones_pendientes_vista.php";
                });
            } else {
                swal(
                    'Error',
                    'Hubo un error!',
                    'error'
                )
            }
        }
    })
});

function Misma(id_input) {
	var valor = $('#' + id_input).val();
	var longitud = valor.length;
	//console.log(valor+longitud);
	if (longitud > 2) {
		var str1 = valor.substring(longitud - 3, longitud - 2);
		var str2 = valor.substring(longitud - 2, longitud - 1);
		var str3 = valor.substring(longitud - 1, longitud);
		nuevo_valor = valor.substring(0, longitud - 1);
		if (str1 == str2 && str1 == str3 && str2 == str3) {
			swal('Error', 'No se permiten tres letras consecutivas', 'error');

			$('#' + id_input).val(nuevo_valor);
		}
	}
}
    </script>
</body>

</html>

<script src="../plugins/select2/js/select2.min.js"></script>
<!-- Select2 -->
<script src="../plugins/select2/js/select2.full.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<!-- datatables JS -->
<script type="text/javascript" src="../plugins/datatables/datatables.min.js"></script>
<!-- para usar botones en datatables JS -->
<script src="../plugins/datatables/Buttons-1.5.6/js/buttons.html5.min.js"></script>
<script src="../js/tipoacta-ajax.js"></script>
<script type="text/javascript" src="../js/validaciones_mca.js"></script>
