<?php
session_start();
require_once('clases/Conexion.php');
include_once('vistas/pagina_inicio_login.php');
/*
   $sql_auto_registro=("select valor FROM tbl_parametros where parametro='AUTO_REGISTRO' ");
   $parametro_registro = mysqli_fetch_assoc($mysqli->query($sql_auto_registro));


if ($parametro_registro['valor']=="1") 
{
  $_SESSION['auto_registro']="block";
}
else
{
  $_SESSION['auto_registro']="none";
}
*/

if (isset($_REQUEST['msj'])) {
  $msj = $_REQUEST['msj'];

  if ($msj == 1) {
    echo '<script >
                            swal(
                      "Alerta!",
                      "Favor revisar su correo la contraseña ha sido enviada",
                      "warning"
                    );
                            </script>';
  }

  if ($msj == 2) {
    echo '<script >
                
           swal(
                      "Alerta!",
                      "Usuario/Contraseña incorrecta",
                      "warning"
                    );
                            </script>';
  }
  if ($msj == 3 and isset($_REQUEST['intentos'])) {




    $sql_intentos = " select valor from tbl_parametros where parametro='intentos' ";
    $resultado_intento = $mysqli->query($sql_intentos);
    $row_parametro_intento = mysqli_fetch_array($resultado_intento);

    $Intento1 = $_REQUEST['intentos'];

    if ($Intento1 == $row_parametro_intento['valor'] and $_SESSION["id_usuario"] <> 1) {


      echo '<script >
                
                 swal(
                      "Alerta!",
                      "Lo sentimos este es tu ultimo intento.",
                      "warning"
                    );          
          
                            </script>';
    } else {
      echo '<script >
                          
          
                 swal(
                      "Alerta!",
                      "Usuario/Contraseña incorrecta",
                      "warning"
                    );
                      </script>';
    }
  }
  if ($msj == 4) {
    echo '<script >
    
          
                    

                        swal("Lo sentimos tu usuario ha sido bloqueado"," Contactese con el administrador");
                            </script>';


  }
  if ($msj == 5) {
    echo '<script >
       
         
                        swal("Lo sentimos su usuario esta bloqueado"," Contactese con el administrador");
                            </script>';
  }
  if ($msj == 6) {
    echo '<script >
       swal(
                      "Alerta!",
                      "Su contraseña ha actualizada correctamente",
                      "warning"
                    );  

                            </script>';
  }
  if ($msj == 7) {
    echo '<script>
    swal(
                      "Alerta!",
                      "Número de cuenta o de empleado no cumple los requisitos de longitud",
                      "warning"
                    );  

                            </script>';
  }
}


?>






<!DOCTYPE html>
<html>

<head>
  <!--  <meta charset="utf-8"> -->

  <!-- Tell the browser to be responsive to screen width -->

  <title>Informatica</title>
  <!-- Theme style -->

</head>

<body class="hold-transition login-page">
  <div class="login-box">

    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">

        <div class="login-logo">
          <img src="dist/img/lOGO_OFICIAL.jpg" width="40%" height="40%" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        </div>

        <p class="login-box-msg"> Iniciar Sesión</p>

        <form action="Controlador/existe_usuario_controlador.php" method="post">
          <div class="input-group mb-3">
            <input id="usuario" name="usuario" value="" type="text" maxlength="30" style="text-transform: uppercase" onkeyup="Espacio(this, event)" class="form-control" placeholder="Usuario" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" name="clave" id="clave" class="form-control" placeholder="CONTRASEÑA" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span id="show-hide-passwd6" action="hide" class="fas fa-eye"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">

            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Entrar</button>
            </div>
            <!-- /.col -->
          </div>
        </form>


        <p class="mb-1">
          <a href="vistas/recuperar_clave_vista.php">Olvidaste tu contraseña?</a>
        </p>
        <p class="mb-0">
          <a href="vistas/auto_registro_estudiante_vista.php" class="text-center">Registrate</a>
        </p>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <!-- 
  <script src="plugins/jquery/jquery.min.js"></script> -->
  <!-- Bootstrap 4 -->
  <!-- 
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script> -->
  <!-- AdminLTE App -->
  <!--   <script src="dist/js/adminlte.min.js"></script> -->

  <script>
    $(document).ready(function() {

      $('#show-hide-passwd6').click(function() {
        if ($(this).hasClass('fa-eye')) {
          $('#clave').removeAttr('type');
          $('#show-hide-passwd6').addClass('fa-eye-slash').removeClass('fa-eye');
        } else {
          //Establecemos el atributo y valor
          $('#clave').attr('type', 'password');
          $('#show-hide-passwd6').addClass('fa-eye').removeClass('fa-eye-slash');
        }
      });

    });
  </script>




</body>

</html>