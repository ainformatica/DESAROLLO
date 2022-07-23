<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
ob_start();
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/conexion_mantenimientos.php');
require_once('../clases/funcion_bitacora_movil.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');
date_default_timezone_set("America/Tegucigalpa");
$instancia_conexion = new conexion();

$Id_objeto = 10172;
$visualizacion = permiso_ver($Id_objeto);
if ($visualizacion == 0) {
  echo '<script type="text/javascript">
  swal({
        title:"",
        text:"¡Lo sentimos! No tiene permiso de visualizar la pantalla",
        type: "error",
        showConfirmButton: false,
        timer: 3000
      });
  window.location = "../vistas/pagina_principal_vista.php";

   </script>';
} else {
  bitacora_movil::evento_bitacora($_SESSION['id_usuario'], $Id_objeto, 'INGRESO', 'GESTION DE TRANSACCIONES');
}

// /* Esta condicion sirve para  verificar el valor que se esta enviando al momento de dar click en el icono modicar */
if (isset($_GET['id'])) {
  $sql_transacciones = "SELECT * FROM tbl_movil_transacciones";
  $resultado_transacciones = $mysqli->query($sql_transacciones);

  $id = $_GET['id'];
  //  /* Hace un select para mandar a traer todos los datos de la 
  //  tabla donde rol sea igual al que se ingreso e el input */
  $sql = "SELECT * FROM tbl_movil_transacciones WHERE id = '$id'";
  $resultado = $mysqli->query($sql);
  //     /* Manda a llamar la fila */
  $row = $resultado->fetch_array(MYSQLI_ASSOC);

  $id = $row['id'];
  $_SESSION['txtfecha_envio'] = $row['fecha_envio'];
  $_SESSION['txtrequest_envio'] = $row['request_envio'];
  $_SESSION['txtresponse'] = $row['response'];
  $_SESSION['txtestado'] = $row['estado'];
  $_SESSION['txtTipotransaccion'] = $row['tipo_transaccion_id'];


  if (isset($_SESSION['txtfecha_envio'])) {


?>
    <script>
      $(function() {
        $('#modal_modificar_transacciones').modal('toggle')
      })
    </script>;

<?php


  }
}

if (isset($_REQUEST['msj'])) {
  $msj = $_REQUEST['msj'];

  if ($msj == 1) {
    echo '<script type="text/javascript">
                    swal({
                       title:"",
                       text:"¡Lo sentimos! El Tipo Transacción ya existe",
                       type: "info",
                       showConfirmButton: false,
                       timer: 3000
                        });
                </script>';
  }
  if ($msj == 2) {
    echo '<script type="text/javascript">
                    swal({
                       title:"",
                       text:"Los datos se almacenaron correctamente",
                       type: "success",
                       showConfirmButton: false,
                       timer: 3000
                        });
                </script>';
  }
  if ($msj == 3) {
    echo '<script type="text/javascript">
                    swal({
                       title:"",
                       text:"¡Lo sentimos! Tiene campos por rellenar",
                       type: "error",
                       showConfirmButton: false,
                       timer: 3000
                    });
                </script>';
  }
  if ($msj == 4) {
    echo '<script type="text/javascript">
                    swal({
                       title:"",
                       text:"Los datos se eliminaron correctamente",
                       type: "error",
                       showConfirmButton: false,
                       timer: 3000
                    });
                </script>';
  }
}

?>

<!DOCTYPE html>
<html>

<head>
  <script src="../js/autologout.js"></script>
  <title></title>
</head>

<body onload="readProducts();">
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Gestión de Transacciones</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item"><a href="../vistas/movil_menu_gestion_vista.php">Gestión APP</a></li>
            </ol>
          </div>
          <div class="RespuestaAjax"></div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!--Pantalla 2-->
    <div class="card card-default">
      <div class="card-header">
      <h3 class="card-title">Listado de transacciones efectuadas entre el módulo y el api</h3><br>
      <hr>
        <div class="card-tools">
        
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
        <div class="dt-buttons btn-group">
          <button class="btn btn-secondary buttons-pdf buttons-html5 btn-danger" tabindex="0" aria-controls="tabla2" type="button" id="GenerarReporte" title="Exportar a PDF"><span><i class="fas fa-file-pdf"></i> </span>
          </button>
        </div>
        <div class="row">
          <div class="col-md-3">
            <label> Fecha Desde: </label>
            <input type="datetime-local" class="form-control" placeholder="Start" name="date1" id="inicio" />
          </div>
          <div class="col-md-3">
            <label> Hasta: </label>
            <input type="datetime-local" class="form-control" placeholder="End" name="date2" id="final" />
          </div>
          <div class="col-md-3">
            <button class="btn btn-primary mt-4" name="search" onclick="readProducts();">buscar</button> <a href="../vistas/movil_gestion_transacciones_vista.php" type="button" class="btn btn-success mt-4">actualizar</a>
          </div>
          <div class="col-md-3">
            <!--buscador-->
            <input class="form-control mt-4" placeholder="Buscar..." type="text" id="buscartext" name="buscar" onpaste="return false" onkeyup="leer(this.value)">
          </div>
        </div>
      </div>
      <div class="card-body" id="Transacciones">

      </div><!-- /.card-body -->
    </div>
  </div>
  <script type="text/javascript">
    function readProducts() {
      var fecha1 = document.getElementById('inicio').value;
      var fecha2 = document.getElementById('final').value;
      var parametro = {
        'inicio': fecha1,
        'final': fecha2
      }
      $.ajax({
        data: parametro, //datos que se envian a traves de ajax
        url: '../Controlador/movil_listar_transacciones_controlador.php', //archivo que recibe la peticion
        type: 'POST', //método de envio
        beforeSend: function() {
          $('#Transacciones').html("Procesando, espere por favor...");
        },
        success: function(response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
          $('#Transacciones').html(response);
        }
      });
    }

    function leer(buscar) {
      var parametro = {
        "buscar": buscar
      }
      $.ajax({
        data: parametro, //datos que se envian a traves de ajax
        url: '../Controlador/movil_listar_transacciones_controlador.php', //archivo que recibe la peticion
        type: 'POST', //método de envio
        beforeSend: function() {
          $('#Transacciones').html("Procesando, espere por favor...");
        },
        success: function(response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
          $('#Transacciones').html(response);
        }
      });
    }
  </script>
</body>

</html>
<?php ob_end_flush() ?>