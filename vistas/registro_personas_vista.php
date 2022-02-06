<?php
ob_start();
session_start();

require_once('../clases/Conexion.php');
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');
require_once('../clases/conexion_mantenimientos.php');

$Id_objeto = 281;


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
                           window.location = "../vistas/menu_usuarios_vista.php";

                            </script>';
} else {

  bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INGRESO', 'A REGISTRAR UNA PERSONA.');


  if (permisos::permiso_insertar($Id_objeto) == '1') {
    $_SESSION['btn_guardar_persona'] = "";
  } else {
    $_SESSION['btn_guardar_persona'] = "disabled";
  }
}


ob_end_flush();

?>


<!DOCTYPE html>
<html>

<head>
  <script src="../js/autologout.js"></script>
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />



  <title></title>


</head>

<body>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

      <div class="container-fluid">


        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Registro personas</h1>
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

    <section>


      <!-- Main content -->
      <section class="content">
        <!--    <form action="" method="POST" id="Formulario" class="FormularioAjax" name="miFormulario" autocomplete="off" role="form" enctype="multipart/form-data"> -->
        <div class="container-fluid">
          <!-- pantalla  -->

          <div class="card card-default">

            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">

                <div class="col-sm-12 ">
                  <label>DATOS PERSONALES</label>
                  <hr>

                </div>

                <div class="col-md-2">
                  <label>Tipo Persona</label>
                  <select class="form-control" name="tipo_persona" id="tipo_persona">

                  </select>
                </div>
                <div class="col-md-2">
                  <label>N° Cuenta/empleado </label>

                  <input class="form-control" type="text" id="num_cuenta" name="num_cuenta" onkeypress="return solonumeros(event)">

                </div>
                <div class="col-md-4">
                  <label>Nombres </label>

                  <input class="form-control" type="text" id="nombre_persona" name="nombre_persona" maxlength="40" value="" style="text-transform: uppercase" onkeyup="DobleEspacio(this, event); " onkeypress="return sololetras(event)" required>

                </div>
                <div class="col-md-4">
                  <label>Apellidos </label>

                  <input class="form-control" type="text" id="apellido_persona" name="apellido_persona" maxlength="30" value="" style="text-transform: uppercase" onkeyup="DobleEspacio(this, event); " onkeypress="return sololetras(event)" required>

                </div>
                <div class="col-sm-12 ">
                  <label></label>
                  <hr>

                </div>
                <div class="col-md-4">
                  <label>Género</label>
                  <select class="form-control" name="genero_persona" id="genero_persona">

                  </select>
                </div>
                <div class="col-md-4">
                  <label>Estado civil</label>
                  <select class="form-control" name="estado_civil_persona" id="estado_civil_persona">

                  </select>
                </div>
                <div class="col-md-4">
                  <label> Correo Electrónico </label>

                  <input class="form-control" type="text" id="correo_persona" name="correo_persona" maxlength="20" value="" ;>


                </div>
                <div class="col-sm-12 ">
                  <label></label>
                  <hr>

                </div>
                <div class="col-md-4">
                  <label>Fecha de nacimiento</label>
                  <input class="form-control" type="date" id="fecha_persona" name="fecha_persona">

                </div>
                <div class="col-md-4">
                  <label>Nacionalidad</label>
                  <select class="form-control" name="nacionalidad_persona" id="nacionalidad_persona" style="text-transform: uppercase">

                  </select>
                </div>
                <div class="col-md-2">
                  <label>Identidad </label>

                  <input class="form-control" type="text" id="identidad_persona" name="identidad_persona" maxlength="20" onkeypress="return solonumeros(event)">

                </div>
                <div class="col-md-2">
                  <label>Télefono Movil</label>

                  <input class="form-control" type="text" id="telefono_persona" name="telefono_persona" maxlength="20" onkeypress="return solonumeros(event)">

                </div>

                <div class="col-sm-12 ">
                  <label></label>
                  <hr>

                </div>
                <div class="col-md-8">
                  <label>Dirección </label>

                  <input class="form-control" type="text" id="direccion_persona" name="direccion_persona" maxlength="48" style="text-transform: uppercase">

                </div>
                <div class="col-md-4">
                  <label>Seleccione imagen </label>

                  <input class="form-control" type="file" id="imagen_persona" name="imagen_persona" maxlength="48" style="text-transform: uppercase" accept="image/jpg/png/jpeg/PNG" required>

                </div>
                <div class="col-sm-12 ">
                  <label></label>
                  <hr>

                </div>

              </div>
              <div class="container-fluid h-100">
                <div class="row w-100 align-items-center">
                  <div class="col text-center">
                    <button class="btn btn-primary" id="guardar_persona" <?php echo $_SESSION['btn_guardar_persona']; ?>>Guardar </button>
                  </div>
                </div>


              </div>
            </div>



          </div>



        </div>

        <!--    </form> -->
      </section>
    </section>

  </div>


  <script type="text/javascript" src="../js/registro_personas.js"></script>
  <script type="text/javascript" src="../js/validaciones_plan.js"></script>



</body>

</html>