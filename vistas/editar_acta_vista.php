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
$Id_objeto = 5005;
bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'Ingreso', 'Editar Actas');
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
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Editar Acta</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="pagina_principal_vista">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="menu_acta_vista">Gestión Actas</a></li>
                            <li class="breadcrumb-item"><a href="actas_pendientes_vista">Actas Pendientes</a></li>
                            <li class="breadcrumb-item active">Editar Acta</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <?php
            $sql = "SELECT
            t1.id_reunion,
            t1.num_acta,
            t2.nombre_reunion,
            t3.id_tipo,
            t2.nombre_reunion,
            t2.lugar,
            t2.agenda_propuesta,
            t1.desarrollo,
            t1.fecha,
            t2.hora_inicio,
            t2.hora_final,
            t2.enlace
            FROM tbl_acta t1
            INNER JOIN tbl_reunion t2 ON t2.id_reunion = t1.id_reunion
            INNER JOIN tbl_tipo_reunion_acta t3 ON t3.id_tipo = t2.id_tipo
            WHERE `id_acta` = $id ";
            $resultado = $mysqli->query($sql);
            $estado = $resultado->fetch_assoc();
            ?>
            <div class="container-fluid">
                <form role="form" name="editar-actas" id="editar-actas-archivo" method="post" action="../Modelos/modelo_acta.php" enctype="multipart/form-data">
                    <div style="padding: 0px 0 25px 0; float:right;">
                        <input type="hidden" name="id_registro" value="<?php echo $id; ?>">
                        <input type="hidden" name="acta" value="actualizar">
                        <button style="padding-right: 15px;" type="submit" class="btn btn-success float-left" id="editar_registro" <?php echo $_SESSION['btn_crear']; ?>>Guardar Como Borrador</button>
                        <a style="color: white !important; margin: 0px 0px 0px 10px;" class="cancelar-acta btn btn-danger" data-toggle="modal" data-target="#modal-default" href="#">Cancelar</a>
                    </div><br><br><br>
                    <div class="card card-primary card-outline card-tabs">
                        <div class="card-header p-0 pt-1 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="datosgenerales-tab" data-toggle="pill" href="#datosgenerales" role="tab" aria-controls="datosgenerales" aria-selected="false">Datos Generales y Asistencia</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " id="datosreunion-tab" data-toggle="pill" href="#datosreunion" role="tab" aria-controls="datosreunion" aria-selected="true">Desarrollo Reunión</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="archivos-tab" data-toggle="pill" href="#archivos" role="tab" aria-controls="archivos" aria-selected="false">Adjuntar archivos</a>
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
                                                        <label for="nombre">Nombre Reunión:</label>
                                                        <input required minlength="5" type="text" value="<?php echo $estado['nombre_reunion']; ?>" class="form-control" id="nombre" name="nombre" style="background: #FFCFCF;" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="tipo">Tipo de Reunión</label>
                                                        <select  class="form-control" onchange="showInp()" style="width: 50%; background: #FFCFCF;" id="tipo" name="tipo" disabled>
                                                            <option value="0">-- Selecione un Tipo --</option>
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
                                                        <input required minlength="4" value="<?php echo $estado['lugar']; ?>" style="width: 90%; background: #FFCFCF;" type="text" class="form-control" id="lugar" name="lugar" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="fecha">Fecha:</label>
                                                        <input required style="width: 40%; background: #FFCFCF;" value="<?php echo $estado['fecha']; ?>" type="date" class="form-control datetimepicker-input" id="fecha" name="fecha" min="<?php echo $hoy; ?>" disabled />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="nacta">No. Acta:</label>
                                                        <input onkeypress="return validacion(event)" onblur="limpia()" onkeyup="mayus(this); Misma('nacta');" value="<?php echo $estado['num_acta']; ?>" style="width: 90%;" type="text" class="form-control" id="nacta" minlength="5" maxlength="25" name="nacta" placeholder="Ingrese numero o codigo del acta. (Mínimo 5 caracteres)">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="horainicio">Hora Inicio: </label>
                                                        <input required style="width: 30%;" type="time" value="<?php echo $estado['hora_inicio']; ?>" class="form-control" id="horainicio" name="horainicio">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="horafinal">Hora Final: </label>
                                                        <input required style="width: 30%;" type="time" value="<?php echo $estado['hora_final']; ?>" class="form-control" id="horafinal" name="horafinal">
                                                    </div>
                                                    <div class="form-group">
                                                        <label id="enlaces" for="enlace">Enlace de la Reunión:</label>
                                                        <input disabled value="<?php echo $estado['enlace']; ?>" style="background: #FFCFCF;" minlength="10" type="text" class="form-control" id="enlace" name="enlace" placeholder="Ingrese el Link de la Reunion">
                                                    </div>
                                                </div>
                                                <!-- /.card-body -->
                                            </div>
                                            <!-- /.card -->
                                        </div>
                                        <!--/.col (left) -->
                                        <!-- right column -->
                                        <div class="col-md-6" >
                                            <!-- Form Element sizes -->
                                            <div class="card card-success">
                                                <div class="card-header">
                                                    <h3 class="card-title">Asistencia</h3>
                                                </div>
                                                <div class="card-body" style="height: 40em; line-height: 1em; overflow-x: hidden; overflow-y: scroll; width: 100%;">
                                                    <table class="table table-bordered table-striped ">
                                                        <thead>
                                                            <tr >
                                                                <th>Nombre Participante</th>
                                                                <th>Editar Asistencia</th>
                                                                <th>Estado Asistencia Actual</th>
                                                            </tr>
                                                        </thead>

                                                        <body>
                                                            <?php
                                                            try {
                                                                $sql = "SELECT
                                                                        CONCAT_WS(' ', t4.nombres, t4.apellidos) AS nombres,
                                                                        t1.id_persona,
                                                                        t1.id_participante,
                                                                        t1.id_estado_participante,
                                                                        t3.estado,
                                                                        t1.descripcion,
                                                                        t2.nombre_reunion,
                                                                        t5.id_acta,
                                                                        t2.id_reunion
                                                                    FROM
                                                                        tbl_participantes t1
                                                                    LEFT JOIN tbl_reunion t2 ON
                                                                        t2.id_reunion = t1.id_reunion
                                                                    LEFT JOIN tbl_estado_participante t3 ON
                                                                        t3.id_estado = t1.id_estado_participante
                                                                    LEFT JOIN tbl_personas t4 ON
                                                                        t4.id_persona = t1.id_persona
                                                                    LEFT JOIN tbl_acta t5 ON
                                                                        t5.id_reunion = t1.id_reunion
                                                                    WHERE
                                                                        t5.id_acta = $id";
                                                                $resultado = $mysqli->query($sql);
                                                            } catch (Exception $e) {
                                                                $error = $e->getMessage();
                                                                echo $error;
                                                            }
                                                            while ($estadoacta = $resultado->fetch_assoc()) { ?>
                                                                <tr>
                                                                    <td>
                                                                        <label for="">
                                                                            <?php echo $estadoacta['nombres']; ?>
                                                                        </label>
                                                                    </td>
                                                                    <td>
                                                                        <div class="form-group">
                                                                            <select class="form-control" name="asistencia[<?php echo $estadoacta['id_persona'] ?>]" id="<?php echo $estadoacta['id_persona']; ?>">
                                                                                <option value="0">--------</option>
                                                                                <option value="1">ASISTIÓ</option>
                                                                                <option value="2">INASISTENCIA</option>
                                                                                <option value="3">EXCUSA</option>
                                                                            </select>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <label for="">
                                                                            <?php echo $estadoacta['estado']; ?>
                                                                        </label>
                                                                    </td>
                                                                </tr>
                                                            <?php  }  ?>
                                                        </body>
                                                    </table>
                                                </div>
                                                <!-- /.card-body -->
                                            </div>
                                        </div>
                                        <!--/.col (right) -->
                                    </div>
                                </div>
                                <div class="tab-pane fade " id="datosreunion" role="tabpanel" aria-labelledby="datosreunion-tab">
                                    <div class="card card-warning">
                                        <div class="card-header">
                                            <h3 class="card-title">Datos de la Reunión</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="col-12">
                                                <!-- /.card -->
                                                <!-- /.card-header -->
                                                <div class="card-body">
                                                    <div class="col-12">
                                                        <!-- /.card -->
                                                        <!-- /.card-header -->
                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label for="asunto">Agenda Propuesta:</label>
                                                                <input type="hidden" name="id_reunion" id="id_reunion" value="<?php echo $estado['id_reunion']; ?>">
                                                                <textarea style="background: #FFCFCF;" required minlength="4" class="form-control" id="agenda" name="agenda" rows="5" placeholder="Ingrese Agenda Propuesta" disabled><?php echo $estado['agenda_propuesta']; ?></textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="agenda">Desarrollo de la reunión</label>
                                                                <textarea onkeypress="return validacion(event)" onblur="limpia()" onkeyup="MismaLetra('desarrollo');" minlength="10" maxlength="65000" class="form-control" id="desarrollo" name="desarrollo" rows="10" placeholder="Ingrese lo que se hablo en la reunión. (Mínimo 10 caracteres)"><?php echo $estado['desarrollo']; ?></textarea>
                                                            </div>
                                                        </div>
                                                        <!-- /.card -->
                                                    </div>
                                                </div>
                                                <!-- /.card -->
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="archivos" role="tabpanel" aria-labelledby="archivos-tab">
                                    <div class="card card-success">
                                        <div class="card-header">
                                            <h3 class="card-title">Adjuntar Archivos</h3>
                                        </div>
                                        <?php
                                        $sql = "SELECT
                                                    Valor
                                                FROM
                                                    `tbl_parametros`
                                                WHERE
                                                    Parametro = 'acta_archivo_permitidos'";
                                        $resultado = $mysqli->query($sql);
                                        $aceptados = $resultado->fetch_assoc();
                                        ?>
                                            <?php
    $sql = "SELECT
                    Valor
                FROM
                    `tbl_parametros`
                WHERE
                    Parametro = 'acta_max_size'";
    $resultado = $mysqli->query($sql);
    $sizee = $resultado->fetch_assoc();
    ?>

                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="archivo_acta">Subir Archivo:</label>
                                                <div style="border: 0;" class="alert alert-warning alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                                    <strong><i class="fas fa-upload fa-2x"></i>⠀⠀Añada el archivo aquí para subir. <b style="padding: 5px; border-radius:5px; background-color:#D39F14">Formatos aceptados: <?php echo $aceptados['Valor']; ?> </b> </strong><b style="margin-left: 10px; padding: 5px; border-radius:5px; background-color:#D39F14">Tamaño máximo: <?php echo $sizee['Valor']; ?> MB </b>
                                                    <input style="background-color: #FFC107; border: 0;" class="form-control" type="file" id="archivo_acta" multiple name="archivo_acta[]" accept="<?php echo $aceptados['Valor']; ?>">
                                                </div>
                                                <div style="border: 0;" class="alert alert-dark alert-dismissable">
                                                    <strong><i class="fas fa-cloud-upload-alt fa-2x"></i>⠀Vista previa archivos para subir:</strong>
                                                    <ul name="listing" id="listing"></ul>
                                                    <input class="btn btn-danger" type="button" onclick="limpiar()" value="Limpiar" />
                                                </div>

                                            </div>

                                            <div class="col-md-12">
                                                <div style="border: 0;" class=" alert-dismissable">
                                                    <strong><i class="far fa-save fa-2x"></i>⠀Archivos Guardados:</strong>
                                                    <br>
                                                    <br>
                                                    <table id="tablaa" class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Nombre Archivo</th>
                                                                <th>Formato</th>
                                                                <th>Acción</th>
                                                            </tr>
                                                        </thead>

                                                        <body>
                                                            <?php
                                                            try {
                                                                $sql = "SELECT  id_recursos,id_acta,url, formato, nombre FROM tbl_acta_recursos WHERE id_acta = $id";
                                                                $resultado = $mysqli->query($sql);
                                                            } catch (Exception $e) {
                                                                $error = $e->getMessage();
                                                                echo $error;
                                                            }
                                                            while ($estadoacta = $resultado->fetch_assoc()) { ?>
                                                                <tr>
                                                                    <td>
                                                                        <label for="<?php echo $estadoacta['nombre']; ?>">
                                                                            <a target="_blank" href="<?php echo $estadoacta['url'] . $estadoacta['nombre']; ?>"><?php echo $estadoacta['nombre']; ?></a>
                                                                        </label>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $estadoacta['formato']; ?>
                                                                    </td>
                                                                    <td><a href="#" data-id="<?php echo $estadoacta['id_recursos']; ?>" data-tipo="acta" class="borrar_recursoacta btn btn-danger">Borrar</a></td>
                                                                </tr>
                                                            <?php  }  ?>
                                                        </body>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.row -->
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
            <a style="color: white ;" type="button" class="btn btn-primary" href="actas_pendientes_vista">Sí, deseo cancelar</a>
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
        document.getElementById("archivo_acta").addEventListener("change", function(event) {
            let output = document.getElementById("listing");
            let files = event.target.files;

            for (let i = 0; i < files.length; i++) {
                let item = document.createElement("li");
                item.innerHTML = "<b>NOMBRE:⠀</b>" + files[i].name + "<div class='progress'><div class='progress-bar' role='progressbar' aria-valuenow='100'  aria-valuemin='0' aria-valuemax='100' style='width:100%'>100%</div></div>";
                output.appendChild(item);

            };
        }, false);

        function limpiar() {
            archivo_acta.value = '';
            $(listing).empty();
        }

        function mayus(e) {
            e.value = e.value.toUpperCase();
        }
        $("#nacta").keyup(function() {
            var ta = $("#nacta");
            letras = ta.val().replace(/ /g, "");
            ta.val(letras)
        });
        $(function() {
            $('#table1').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "responsive": true,
            });
        });
        $(function() {
            $('#tablaa').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "responsive": true,
                language: {
                    decimal: "",
                    emptyTable: "No hay archivos guardados",
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
    <?php
    $sql = "SELECT
                    Valor
                FROM
                    `tbl_parametros`
                WHERE
                    Parametro = 'acta_max_size'";
    $resultado = $mysqli->query($sql);
    $aceptados = $resultado->fetch_assoc();
    ?>
    <script>
        var MAXIMO_TAMANIO_BYTES = <?php echo $aceptados['Valor']; ?>; // 1MB = 1 millón de bytes
        var MAXIMO_TAMANIO_BYTES = MAXIMO_TAMANIO_BYTES * 1000000;
        // Obtener referencia al elemento
        const $miInput = document.querySelector("#archivo_acta");
        $miInput.addEventListener("change", function() {
            // si no hay archivos, regresamos
            if (this.files.length <= 0) return;
            // Validamos el primer archivo únicamente
            const archivo = this.files[0];
            const tam = parseInt(archivo.size / 1000000 +1);
            if (archivo.size > MAXIMO_TAMANIO_BYTES) {
                const tamanioEnMb = MAXIMO_TAMANIO_BYTES / 1000000;
                swal('Error', `<h5>EL archivo es demasiado grande. El tamaño de subida máximo es:<b> ${tamanioEnMb} MB</b>, Y lo que está tratando de subir pesa: <b style="color:red;"> ${tam} MB</b>.</h5>`, 'error');
                // Limpiar
                $miInput.value = "";
                
            archivo_acta.value = '';
            $(listing).empty();
            
            } else if (archivo<0){
                // Validación pasada. Envía el formulario o haz lo que tengas que hacer
                archivo_acta.value = '';
            $(listing).empty();
            }
        });
        function validacion(e) {
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = "abcdefghijklmnñopqrstuvwxyz,.;@/:/-()%#0123456789éáíóú"
    especiales = [37, 39, 46, 13, 8, 32];

    tecla_especial = false
    for(var i in especiales) {
        if(key == especiales[i]) {
            tecla_especial = true;
            break;
        }
    }

    if(letras.indexOf(tecla) == -1 && !tecla_especial)
        return false;
}
window.onload = function() {

    var agenda = document.getElementById('desarrollo');
    var nacta = document.getElementById('nacta');

    nacta.onpaste = function(e) {
        e.preventDefault();
        swal('Error', '<h5>La acción de <b>pegar</b> está prohibida</h5>', 'error');
      }
      
      nacta.oncopy = function(e) {
        e.preventDefault();
        swal('Error', '<h5>La acción de <b>copiar</b> está prohibida</h5>', 'error');
      }
      agenda.onpaste = function(e) {
      e.preventDefault();
      swal('Error', '<h5>La acción de <b>pegar</b> está prohibida</h5>', 'error');
    }
    
    agenda.oncopy = function(e) {
      e.preventDefault();
      swal('Error', '<h5>La acción de <b>copiar</b> está prohibida</h5>', 'error');
    }
  }
  //FUNCION NO DEJA ESCRIBIR 3 LETRAS IGUEALES
function MismaLetra(id_input) {
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

document.getElementById("desarrollo").addEventListener("keydown", teclear);
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