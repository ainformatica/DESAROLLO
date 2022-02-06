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
$Id_objeto = 10174;
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
  window.location = "../vistas/pagina_principal_vista.php";

   </script>';
} else {
  bitacora_movil::evento_bitacora($_SESSION['id_usuario'], $Id_objeto, 'INGRESO', 'MANTENIMIENTO TIPO MENSAJE');
}

// /* Esta condicion sirve para  verificar el valor que se esta enviando al momento de dar click en el icono modicar */
if (isset($_GET['id'])) {
  $sql_tipomensaje = "SELECT * FROM tbl_movil_tipo_mensajes";
  $resultado_tipomensaje = $mysqli->query($sql_tipomensaje);

  $id = $_GET['id'];


  //  /* Hace un select para mandar a traer todos los datos de la 
  //  tabla donde rol sea igual al que se ingreso e el input */
  $sql = "SELECT * FROM tbl_movil_tipo_mensajes WHERE id = '$id'";
  $resultado = $mysqli->query($sql);
  //     /* Manda a llamar la fila */
  $row = $resultado->fetch_array(MYSQLI_ASSOC);

  $id = $row['id'];
  $_SESSION['txttipo_mensaje'] = $row['tipo_mensaje'];


  if (isset($_SESSION['txttipo_mensaje'])) {


?>
    <script>
      $(function() {
        $('#modal_modificar_tipomensaje').modal('toggle')
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
                       text:"Lo sentimos el Tipo Mensaje ya existe",
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
                       text:"Lo sentimos tiene campos por rellenar.",
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
                       text:"los datos se eliminaron correctamente.",
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


<body onload="readProducts()">
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Mantenimiento Tipo Mensaje</h1>
          </div>

          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item"><a href="../vistas/movil_menu_mantenimiento_vista.php">Mantenimiento APP</a></li>
            </ol>
          </div>

          <div class="RespuestaAjax"></div>

        </div>
      </div><!-- /.container-fluid -->
    </section>


    <!--Pantalla 2-->
    <div class="card card-default">
      <div class="card-header">
        <div class="dt-buttons btn-group"><button class="btn btn-secondary buttons-pdf buttons-html5 btn-danger" tabindex="0" aria-controls="tabla2" type="button" id="GenerarReporte" title="Exportar a PDF"><span><i class="fas fa-file-pdf"></i> </span> </button> </div>
        <a class="btn btn-primary btn-xs float-right" href="../vistas/movil_crear_tipo_mensaje_vista.php">Nuevo</a>
        <!--buscador-->
        <div class="float-right mt-5 ml-5">
          <input class="form-control" placeholder="Buscar..." type="text" id="buscartext" name="buscar" onpaste="return false" onkeyup="leer(this.value)">
        </div>
        <!-- /.card-header -->
        <div class="card-body" id="tipo_mensaje">
        </div>

        <!-- inicio modal-->
        <form action="../Controlador/movil_guardar_tipomensaje_controlador.php?op=editar&id=<?php echo $id ?>" method="post" data-form="update" autocomplete="off">
          <div class="modal fade" id="modal_modificar_tipomensaje">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Modificar Tipo Mensaje </h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <!--Cuerpo del modal-->
                <div class="modal-body">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Tipo de Mensaje</label>
                          <input class="form-control" type="text" id="tipo_mensaje" name="tipo_mensaje" style="text-transform: uppercase" onpaste="return false" onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" required="" maxlength="30" value="<?php echo $_SESSION['txttipo_mensaje']; ?>">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!--Footer del modal-->
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <button type="submit" class="btn btn-primary" id="btn_modificar_tipomensaje" name="btn_modificar_tipomensaje">Guardar Cambios</button>
                </div>
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>
          <!-- /.  finaldel modal -->
        </form>
        <script type="text/javascript">
          function leer(buscar) {
            var buscar;
            var parametro = {
              "buscar": buscar
            }
            $.ajax({
              data: parametro, //datos que se envian a traves de ajax
              url: '../Controlador/movil_listar_tipo_mensaje_controlador.php', //archivo que recibe la peticion
              type: 'POST', //método de envio
              beforeSend: function() {
                $('#tipo_mensaje').html("Procesando, espere por favor...");
              },
              success: function(response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                $('#tipo_mensaje').html(response);
              }
            });
          }

          function readProducts() {
            var parametro;
            $.ajax({
              data: parametro, //datos que se envian a traves de ajax
              url: '../Controlador/movil_listar_tipo_mensaje_controlador.php', //archivo que recibe la peticion
              type: 'POST', //método de envio
              beforeSend: function() {
                $('#tipo_mensaje').html("Procesando, espere por favor...");
              },
              success: function(response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                $('#tipo_mensaje').html(response);
              }
            });
          }

          function eliminar(id) {
            var parametro = {
              'funcion': 'eliminar',
              'id': id
            }
            var confirmacion = confirm('esta seguro de eliminar');
            if (confirmacion) {
              $.ajax({
                data: parametro, //datos que se envian a traves de ajax
                url: '../Controlador/movil_guardar_tipomensaje_controlador.php', //archivo que recibe la peticion
                type: 'POST', //método de envio
                success: function(data) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                  console.log(data);
                  if (data != '') {
                    readProducts();
                    datoseliminados();
                  } else {
                    alert('no se pudo eliminar!!');
                  }

                }
              });
            } else {
              console.log('decidio no eliminar');
            }
          }

          function datoseliminados() {
            swal({
              title: "",
              text: "los datos se eliminaron correctamente.",
              type: "success",
              showConfirmButton: true,
              timer: 3000
            });
          }
        </script>
</body>

</html>
<?php ob_end_flush() ?>