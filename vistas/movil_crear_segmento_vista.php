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
////////////////declaracion de variables para la busqueda//////////

$Id_objeto = 10165;

bitacora_movil::evento_bitacora($_SESSION['id_usuario'], $Id_objeto, 'INGRESO', 'A CREAR SEGMENTOS');

$visualizacion = permiso_ver($Id_objeto);
if (isset($_GET['msj'])) {
  $msj = $_GET['msj'];

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
                       text:"¡Lo sentimos! Tiene campos por rellenar.",
                       type: "error",
                       showConfirmButton: false,
                       timer: 3000
                    });
                </script>';
  }
}
if ($visualizacion == 0) {
  echo '<script type="text/javascript">
                              swal({
                                   title:"",
                                   text:"¡Lo sentimos! No tiene permiso de visualizar la pantalla",
                                   type: "error",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                            </script>';
   header('location:  ../vistas/pagina_inicio_vista');
} 
//else {

//   if (permisos::permiso_insertar($Id_objeto) == '1') {
//     $_SESSION['btn_guardar_segmentos'] = "";
//   } else {
//     $_SESSION['btn_guardar_segmentos'] = "disabled";
//   }
// }

ob_end_flush();

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
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
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
            <h1>Nuevo Segmento</h1>
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
        <form action="../Controlador/movil_segmentos_controlador.php" method="POST">
          <div class="card card-default">
            <div class="card-header">
            <h3 class="card-title">Formulario de creación de nuevos segmentos</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="nombre"> Nombre del segmento</label>
                    <input autofocus class="form-control" type="text" maxlength="45" id="nombre" name="nombre" required style="text-transform: uppercase" onpaste="return false" onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" onkeypress="return comprobar(this.value, event, this.id)">
                  </div>
                  <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <input class="form-control" type="text" maxlength="200" id="descripcion" name="descripcion" required style="text-transform: uppercase" onpaste="return false" onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" onkeypress="return comprobar(this.value, event, this.id)">
                  </div>
                </div>
              </div>
            </div>
            <!-- /.card-header -->
            <p class="text-center" style="margin-top: 20px;">
              <button type="submit" class="btn btn-primary" id="btn_guardar_segmentos" name="btn_guardar_segmentos"><i class="zmdi zmdi-floppy"></i>Guardar</button>
            </p>
        </form>
      </div>
    </section>


  </div>

</body>

</html>
<?php ob_end_flush() ?>