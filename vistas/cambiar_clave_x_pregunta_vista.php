<?php
require_once('../clases/Conexion.php');
require_once('pagina_inicio_cambiar_clave_pregunta.php');

if (isset($_REQUEST['id_usuario2'])) {

  $id_usuarios = $_GET['id_usuario2'];
}



if (isset($_REQUEST['msj'])) {
  $msj = $_REQUEST['msj'];
  if ($msj == 1) {
    echo '<script>
                
                 swal(
                      "Alerta!",
                      "Lo sentimos NUEVA Y CONFIRMAR deben ser iguales intenta de nuevo",
                      "warning"
                    );          
          
                            </script>';
  }
  if ($msj == 2) {
    echo '<script>
                
                 swal(
                      "Alerta!",
                      "PASSWORD NO VÁLIDO: ' . $_REQUEST['error'] . '",
                      "warning"
                    );          
          
                            </script>';
  }
  if ($msj == 3) {
    echo '<script>
                
                 swal(
                      "Alerta!",
                      "Los datos  se actulizaron correctamente",
                      "warning"
                    );          
          
                            </script>';
  }
  if ($msj == 4) {
    echo '<script>
                
                 swal(
                      "Alerta!",
                      "No se realizo el proceso, favor llame al administrador o intente de nuevo",
                      "warning"
                    );          
          
                            </script>';
  }
}



?>





<!DOCTYPE html>
<html>

<head>
  <script src="../js/autologout.js"></script>
  <title>Informatica Admistrativa</title>

</head>

<body class="hold-transition login-page">
  <div class="login-box">

    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">

        <div class="login-logo">
          <img src="../dist/img/logo_informatica.jpg" width="40%" height="40%" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        </div>

        <p class="login-box-msg">Cambiar contraseña por Pregunta de Seguridad</p>

        <form action="../Controlador/actualizar_clave_x_pregunta_controlador.php?id_usuario=<?php echo $id_usuarios ?>" method="post">

          <label>Nueva Contraseña:</label>
          <div class="input-group mb-3">

            <input class="form-control" type="password" id="txt_nuevaclave" name="txt_nuevaclave" onkeyup="Espacio(this, event)" required oncopy="return false" onpaste="return false" maxlength="10">
            <div class="input-group-append">
              <div class="input-group-text">
                <span id="show-hide-passwd1" action="hide" class="fas fa-eye"></span>
              </div>
            </div>
          </div>
          <label>Confirmar Contraseña:</label>
          <div class="input-group mb-3">
            <input class="form-control" type="password" id="txt_confirmarclave" name="txt_confirmarclave" onkeyup="Espacio(this, event)" required oncopy="return false" onpaste="return false" maxlength="10">
            <div class="input-group-append">
              <div class="input-group-text">
                <span id="show-hide-passwd2" action="hidev" class="fas fa-eye"></span>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block">Enviar</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <p class="mt-3 mb-1">
          <a href="../login.php">Inicia Sesión</a>
        </p>

      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->



  <script>
    $(document).ready(function() {

      $('#show-hide-passwd1').click(function() {
        if ($(this).hasClass('fa-eye')) {
          $('#txt_nuevaclave').removeAttr('type');
          $('#show-hide-passwd1').addClass('fa-eye-slash').removeClass('fa-eye');
        } else {
          //Establecemos el atributo y valor
          $('#txt_nuevaclave').attr('type', 'password');
          $('#show-hide-passwd1').addClass('fa-eye').removeClass('fa-eye-slash');
        }
      });

    });

    $(document).ready(function() {

      $('#show-hide-passwd2').click(function() {
        if ($(this).hasClass('fa-eye')) {
          $('#txt_confirmarclave').removeAttr('type');
          $('#show-hide-passwd2').addClass('fa-eye-slash').removeClass('fa-eye');
        } else {
          //Establecemos el atributo y valor
          $('#txt_confirmarclave').attr('type', 'password');
          $('#show-hide-passwd2').addClass('fa-eye').removeClass('fa-eye-slash');
        }
      });

    });
  </script>

  <script>
    function Espacio(campo, event) {

      CadenaaReemplazar = " ";
      CadenaReemplazo = "";
      CadenaTexto = campo.value;
      CadenaTextoNueva = CadenaTexto.split(CadenaaReemplazar).join(CadenaReemplazo);
      campo.value = CadenaTextoNueva;

    }
  </script>

</body>

</html>