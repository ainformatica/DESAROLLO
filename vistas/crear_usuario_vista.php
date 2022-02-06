<?php

ob_start();


session_start();

require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');


$Id_objeto = 3;

bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'Ingreso', 'A Crear Usuarios');

$visualizacion = permiso_ver($Id_objeto);
$nombre = $_SESSION['usuario'];

if ($visualizacion == 0) {
  echo '<script type="text/javascript">
                              swal({
                                   title:"",
                                   text:"Lo sentimos no tiene permiso de visualizar la pantalla",
                                   type: "error",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                           window.location = "../vistas/menu_usuarios_vista.php";

                            </script>';
  // header('location:  ../vistas/menu_usuarios_vista.php');
} else {



  if (permisos::permiso_insertar($Id_objeto) == '1') {
    $_SESSION['btn_guardar_usuario'] = "";
  } else {
    $_SESSION['btn_guardar_usuario'] = "disabled";
  }
}

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
  <!-- <script type="text/javascript">
    $(function() {
      $("#curso").autocomplete({
        source: "../Controlador/seleccionar_datos_controlador.php",
        minLength: 2,
        select: function(event, ui) {
          event.preventDefault();
          $('#curso').val(ui.item.nombres);
          $('#txt_id').val(ui.item.txt_id);
          $('#txt_nombre').val(ui.item.txt_nombre);



          $("#curso").focus();
        }
      });
    });

    document.addEventListener('DOMContentLoaded', () => {
      document.querySelectorAll('input[type=text]').forEach(node => node.addEventListener('keypress', e => {
        if (e.keyCode == 13) {
          e.preventDefault();
        }
      }))
    });
  </script> -->


</head>

<body>


  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Registro de Usuarios</h1>
          </div>



          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item active">Seguridad</li>
            </ol>
          </div>


        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- pantalla 1 -->

        <!-- <form action="../Controlador/guardar_usuario_controlador.php" method="post" data-form="save" autocomplete="off" class="FormularioAjax"> -->

        <div class="card card-default">
          <input type="text" id="fecha_hoy" readonly hidden>
          <input type="text" id="fecha_a" readonly hidden>
          <input type="text" id="usuario" value="<?php echo $nombre; ?>" readonly hidden>

          <div class="card-header">
            <h3 class="card-title">Nuevo Usuario</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
          </div>


          <!-- /.card-header -->
          <div class="card-body">
            <div class="row" style="justify-content: center;">

              <div class="col-md-7">
                <div class="form-group">

                  <label>Seleccione Persona</label>
                  <select class="form-control select2" style="width: 100%;" name="cbm_persona" id="cbm_persona">

                  </select>
                </div>
              </div>
              <div class="col-md-7">
                <div class="form-group">

                  <label>Seleccione un Rol</label>
                  <select class="form-control select2" style="width: 100%;" name="cbm_rol" id="cbm_rol">

                  </select>
                </div>
              </div>

              <div class="col-md-7">
                <div class="form-group">


                  <label>Usuario</label>
                  <input class="form-control" type="text" id="txt_usuario" name="txt_usuario" style="text-transform: uppercase" maxlength="30" placeholder="Ingrese el nombre de Usuario" onkeypress="return sololetras(event)" onkeyup="NoEspacio(this, event)">



                </div>
              </div>
              <div class="col-md-7">

                <div class="form-group">

                  <label>Ingrese Contraseña</label>
                  <div class="input-group mb-3">
                    <input class="form-control" type="password" id="txt_contrasena" name="txt_contrasena" maxlength="10" readonly value="Hola*4321">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span id="show-hide-passwd" action="hide" class="fas fa-eye"></span>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
              <div class="col-md-7">
                <div class="form-group">


                  <label>Confimar Contraseña</label>
                  <div class="input-group mb-3">
                    <input class="form-control" type="password" id="txt_confirmar_contrasena" name="txt_confirmar_contrasena" maxlength="10" value="Hola*4321" readonly>

                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span id="show-hide-passwd1" action="hide" class="fas fa-eye"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>


            </div>

            <div class="container-fluid h-100">
              <div class="row w-100 align-items-center">
                <div class="col text-center">
                  <button class="btn btn-primary" id="guardar_usuario" <?php echo $_SESSION['btn_guardar_usuario']; ?>>Guardar </button>
                </div>
              </div>


            </div>




          </div>
    </section>


  </div>
  <script src="../js/registro_usuario.js"></script>
  <script type="text/javascript" src="../js/validaciones_plan.js"></script>

  <script>
    $(document).ready(function() {

      $('#show-hide-passwd').click(function() {
        if ($(this).hasClass('fa-eye')) {
          $('#txt_contrasena').removeAttr('type');
          $('#show-hide-passwd').addClass('fa-eye-slash').removeClass('fa-eye');
        } else {
          //Establecemos el atributo y valor
          $('#txt_contrasena').attr('type', 'password');
          $('#show-hide-passwd').addClass('fa-eye').removeClass('fa-eye-slash');
        }
      });

    });

    $(document).ready(function() {

      $('#show-hide-passwd1').click(function() {
        if ($(this).hasClass('fa-eye')) {
          $('#txt_confirmar_contrasena').removeAttr('type');
          $('#show-hide-passwd1').addClass('fa-eye-slash').removeClass('fa-eye');
        } else {
          //Establecemos el atributo y valor
          $('#txt_confirmar_contrasena').attr('type', 'password');
          $('#show-hide-passwd1').addClass('fa-eye').removeClass('fa-eye-slash');
        }
      });

    });
  </script>




</body>

</html>