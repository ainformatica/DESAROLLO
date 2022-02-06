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


$Id_objeto = 5019;
bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'Ingreso', 'A archivar acta');

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
                        <h1>Archivar Acta</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="pagina_principal_vista">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="menu_acta_vista">Menú Actas</a></li>
                            <li class="breadcrumb-item active">Archivar Acta</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <form role="form" name="editar-actas" id="actas-archivo" method="post" action="../Modelos/modelo_archivaracta.php" enctype="multipart/form-data">
                    <div style="padding: 0px 0 25px 0; float:right;">
                        <input type="hidden" name="id_registro" value="<?php echo $id; ?>">
                        <input type="hidden" name="acta" value="actualizar">
                        <button style="padding-right: 15px;" type="submit" class="btn btn-success float-left" id="editar_registro" <?php echo $_SESSION['btn_crear']; ?>>Archivar Acta</button>
                        <a style="color: white !important; margin: 0px 0px 0px 10px;" class="cancelar-acta btn btn-danger" data-toggle="modal" data-target="#modal-default" href="menu_acta_vista">Cancelar</a>
                    </div><br><br>

                    <div class="card-body">
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
                                            <input onkeypress="return validacion(event)" onblur="limpia()" onkeyup="MismaLetra('nombre');" required minlength="5" maxlength="50" type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese el nombre de la Reunion. (Mínimo 5 caracteres)">
                                        </div>
                                        <div class="form-group">
                                            <label for="tipo">Tipo de Reunión</label>
                                            <select class="form-control" onChange="showInp(); showdatos();" style="width: 50%;" id="tipo" name="tipo" required>
                                                <option value="0">-- Seleccioné un Tipo --</option>
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
                                            <input onkeypress="return validacion(event)" onblur="limpia()" onkeyup="MismaLetra('lugar');" required minlength="4" maxlength="30" style="width: 90%;" type="text" class="form-control" id="lugar" name="lugar" placeholder="Ingrese el lugar donde se desarrollo. (Mínimo 4 caracteres)">
                                        </div>
                                        <div class="form-group">
                                            <label for="fecha">Fecha:</label>
                                            <input required style="width: 40%;" type="date" class="form-control datetimepicker-input" id="fecha" name="fecha" max="<?php echo $hoy; ?>" />
                                        </div>
                                        <div class="form-group">
                                            <label for="nacta">No. Acta:</label>
                                            <input onkeypress="return validacion(event)" onblur="limpia()" onkeyup="mayus(this); MismaLetra('nacta');" required  style="width: 90%;" type="text" class="form-control" id="nacta" minlength="5" maxlength="25" name="nacta" placeholder="Ingrese numero o codigo del acta. (Mínimo 5 caracteres)">
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
                                        <h3 class="card-title">Adjuntar Acta</h3>
                                    </div>
                                    <?php
                                    $sql = "SELECT
                                                    Valor
                                                FROM
                                                    `tbl_parametros`
                                                WHERE
                                                    Parametro = 'archivaracta_permitido'";
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
                                                <strong><i class="fas fa-upload fa-2x"></i>⠀<b>⠀Añada el archivo aquí para subir.</b><br> <b style="padding: 2px; border-radius:5px; background-color:#D39F14">Formatos aceptados: <?php echo $aceptados['Valor']; ?> </b> </strong><b style="margin-left: 10px; padding: 2px; border-radius:5px; background-color:#D39F14">Tamaño máximo: <?php echo $sizee['Valor']; ?> MB </b></strong>
                                                <input required style="background-color: #FFC107; border: 0;" class="form-control" type="file" id="archivo_acta" name="archivo_acta[]" accept="<?php echo $aceptados['Valor']; ?>">
                                            </div>
                                            <div style="border: 0;" class="alert alert-dark alert-dismissable">
                                                <strong><i class="fas fa-cloud-upload-alt fa-2x"></i>⠀Vista previa archivos para subir:</strong>
                                                <ul name="listing" id="listing"></ul>
                                                <input class="btn btn-danger" type="button" onclick="limpiar()" value="Limpiar" />
                                            </div>

                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            </div>
                            <!--/.col (right) -->
                        </div>
                    </div>
                    <!-- /.card -->

                    <!-- /.row -->


                </form>
            </div>
            <!-- /.container-fluid -->
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



</body>
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
    var nom = document.getElementById('nombre');
    var lug = document.getElementById('lugar');
    var nacta = document.getElementById('nacta');
    
    nom.onpaste = function(e) {
      e.preventDefault();
      swal('Error', '<h5>La acción de <b>pegar</b> está prohibida</h5>', 'error');
    }
    
    nom.oncopy = function(e) {
      e.preventDefault();
      swal('Error', '<h5>La acción de <b>copiar</b> está prohibida</h5>', 'error');
    }
    
    lug.onpaste = function(e) {
      e.preventDefault();
      swal('Error', '<h5>La acción de <b>pegar</b> está prohibida</h5>', 'error');
    }
    
    lug.oncopy = function(e) {
      e.preventDefault();
      swal('Error', '<h5>La acción de <b>copiar</b> está prohibida</h5>', 'error');
    }
    
    nacta.onpaste = function(e) {
        e.preventDefault();
        swal('Error', '<h5>La acción de <b>pegar</b> está prohibida</h5>', 'error');
      }
      
      nacta.oncopy = function(e) {
        e.preventDefault();
        swal('Error', '<h5>La acción de <b>copiar</b> está prohibida</h5>', 'error');
      }
  }
  $("#actas-archivo").submit(function () {  
    if($("#tipo").value() < "1") { 
        swal('Error', '<h5>Debe seleccionar un <b>Tipo</b></h5>', 'error');  
        return false;  
    }  
    return false;  
}); 

document.getElementById("nombre").addEventListener("keydown", teclear);
    document.getElementById("lugar").addEventListener("keydown", teclear);

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
<script src="../js/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="../js/validaciones_mca.js"></script>



