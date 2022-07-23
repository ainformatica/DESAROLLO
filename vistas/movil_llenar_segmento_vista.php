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
/*require_once('../Modelos/movil_segmentos_modelo.php');*/
////////////////declaracion de variables para la busqueda//////////

$Id_objeto = 10173;

bitacora_movil::evento_bitacora($_SESSION['id_usuario'], $Id_objeto, 'INGRESO', 'A LLENAR SEGMENTO');

$visualizacion = permiso_ver($Id_objeto);
if (isset($_REQUEST['msj'])) {
  $msj = $_REQUEST['msj'];

  if ($msj == 1) {
    echo '<script type="text/javascript">
                    swal({
                       title:"",
                       text:"¡Lo sentimos! El segmento ya existe",
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
                       text:"Lo sentimos tiene campos por rellenar",
                       type: "error",
                       showConfirmButton: false,
                       timer: 3000
                    });
                </script>';
  }
}
// if ($visualizacion == 0) {
//   echo '<script type="text/javascript">
//                               swal({
//                                    title:"",
//                                    text:"¡Lo sentimos! No tiene permiso de visualizar la pantalla",
//                                    type: "error",
//                                    showConfirmButton: false,
//                                    timer: 3000
//                                 });
//                            window.location = "../vistas/menu_usuarios_vista.php";

//                             </script>';
//   // header('location:  ../vistas/menu_usuarios_vista.php');
// } else {

//   if (permisos::permiso_insertar($Id_objeto) == '1') {
//     $_SESSION['btn_guardar_segmentos'] = "";
//   } else {
//     $_SESSION['btn_guardar_segmentos'] = "disabled";
//   }
// }

?>

<!DOCTYPE html>
<html>

<head>
  <script src="../js/autologout.js"></script>
  <title></title>
  <!-- Bootstrap core CSS -->
  <link href="dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom styles for this template -->
  <link href="assets/sticky-footer-navbar.css" rel="stylesheet">

  <script type="text/javascript">
  </script>
</head>

<body>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Llenando Segmento</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item active"><a href="../vistas/movil_gestion_segmentos_vista.php">Gestión Segmentos</a></li>
            </ol>
          </div>
          <div class="RespuestaAjax"></div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- pantalla 1 -->

        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Pantalla de seleccion de usuarios para un segmento.</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <label>Segmento: </label>
                <select class="form-control" name="Segmento" id="Segmento" onchange="readProducts(this.value),realizaProceso() " required>
                  <option value="">Seleccione un segmento:</option>
                  <?php
                  $sql_segmentos = "SELECT id,nombre FROM tbl_movil_segmentos";
                  $resultado_segmentos = $mysqli->query($sql_segmentos);
                  while ($segmento = $resultado_segmentos->fetch_array(MYSQLI_ASSOC)) { ?>
                    <option value="<?php echo $segmento['id'] ?>"><?php echo $segmento['nombre'] ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label>Tipo de Persona: </label>
              <select class="form-control" name="buscar_tipo_persona" id="buscar_tipo_persona" onchange="realizaProceso()">
                <option value="">Seleccione una opción :</option>
                <?php
                $sql_tipo_persona = "SELECT id_tipo_persona,tipo_persona FROM tbl_tipos_persona";
                $resultado_tipo_persona = $mysqli->query($sql_tipo_persona);
                while ($tipo_persona = $resultado_tipo_persona->fetch_array(MYSQLI_ASSOC)) { ?>
                  <option value="<?php echo $tipo_persona['id_tipo_persona'] ?>"><?php echo $tipo_persona['tipo_persona'] ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <!-- /.card-header -->

          <p class="text-center font-weight-bold">Listado de personas que se pueden seleccionar</p>
          <div class="card-body" id="resultado">



          </div>

          <hr>
          <div class="dt-buttons btn-group col-1"><button class="btn btn-secondary buttons-pdf buttons-html5 btn-danger" type="button" id="GenerarReporte_segmento_usuario" title="Exportar a PDF"><span><i class="fas fa-file-pdf"></i> </span> </button> </div>
          <p class="text-center font-weight-bold">Listado de personas que pertenecen al segmento</p>
          <div class="card-body" id="resultadoSegmentoUsuarios">


          </div>
          <a class="btn btn-primary m-4" href="../vistas/movil_gestion_segmentos_vista.php">Volver</a>
        </div>

    </section>



  </div>
  <script>
    function realizaProceso() {
      var tipo_persona = document.getElementById('buscar_tipo_persona').value;
      var segmento = document.getElementById('Segmento').value;
      var parametros = {
        "tipoPersona": tipo_persona,
        "segmento": segmento
      }
      $.ajax({
        data: parametros, //datos que se envian a traves de ajax
        url: '../Controlador/movil_buscar_personas_controlador.php', //archivo que recibe la peticion
        type: 'post', //método de envio
        beforeSend: function() {
          $("#resultado").html("Procesando, espere por favor...");
        },
        success: function(response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
          $("#resultado").html(response);
        }
      });
    }
    //funcion para marcar todos los checkbox
    function toggle(source) {
      console.log(source.checked);
      checkboxes = document.getElementsByName('persona[]');
      for (var i = 0, n = checkboxes.length; i < n; i++) {
        checkboxes[i].checked = source.checked;
        validar(checkboxes[i]);
        checkboxes[i].disabled = true;
      }

    }
    //-------------------------------------------

    //funcion que envia los datos de usuario y segmento al controldaor para realizar el sql correspondiente
    function validar(checkbox) {
      if (checkbox.checked) {
        var segmento = document.getElementById('Segmento').value;
        var parametros = {
          'funcion': 'insertar',
          'Segmento': segmento,
          'persona': checkbox.value
        }
        $.ajax({
          data: parametros, //datos que se envian a traves de ajax
          url: '../Controlador/movil_segmento_persona_controlador.php', //archivo que recibe la peticion
          type: 'POST', //método de envio
          beforeSend: function() {
            $('#resultadoSegmentoUsuarios').html("Procesando, espere por favor...");
          },
          success: function(data) { //una vez que el archivo recibe el request lo procesa y lo devuelve
            if (data != '') {
              readProducts(segmento);
            } else {
              alert('¡No se pudo guardar!');
            }
          }
        });
      }
    }


    function readProducts(segmento) {
      var parametro = {
        'segmento': segmento
      }
      $.ajax({
        data: parametro, //datos que se envian a traves de ajax
        url: '../Controlador/movil_listar_segmento_usuarios_controlador.php', //archivo que recibe la peticion
        type: 'POST', //método de envio
        beforeSend: function() {
          $('#resultadoSegmentoUsuarios').html("Procesando, espere por favor...");
        },
        success: function(response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
          $('#resultadoSegmentoUsuarios').html(response);
        }
      });
    }

    function eliminar(id_usuario, segmento) {
      var parametro = {
        'funcion': 'eliminar',
        'id_usuario': id_usuario
      }
      $.ajax({
        data: parametro, //datos que se envian a traves de ajax
        url: '../Controlador/movil_segmento_persona_controlador.php', //archivo que recibe la peticion
        type: 'POST', //método de envio
        beforeSend: function() {
          $('#resultadoSegmentoUsuarios').html("Procesando, espere por favor...");
        },
        success: function(data) { //una vez que el archivo recibe el request lo procesa y lo devuelve
          console.log(data);
          if (data != '') {
            readProducts(segmento);
            realizaProceso();
          } else {
            alert('¡No se pudo eliminar!');
          }
        }
      });
    }
  </script>

</body>

</html>
<?php ob_end_flush() ?>