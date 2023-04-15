<?php

session_start();
require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_permisos.php');
require_once('../clases/funcion_visualizar.php');

$Id_objeto = 14029;
bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'Ingreso', 'A completar sus datos personales');
  
?>



<!DOCTYPE html>
<html>

<head>
    <script src="../js/autologout.js"></script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="../plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="../plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="../plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
  <!-- Ionicons -->
  <!-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->
  <!-- DataTables -->
  <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <!-- <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"> -->

  <link rel="stylesheet" type="text/css" href="../plugins/sweetalert2/sweetalert2.min.css">
  <link rel="stylesheet" href="../dist/css/sweetalert2.css">
  <script src="../dist//js/jspdf.min.js"></script>
  <script src="../dist//js/jspdf.plugin.autotable.min.js"></script>
  <title>Informática Administrativa</title>
  <!-- Tell the browser to be responsive to screen width -->

</head>

<body>
<form action="" method="POST" id="Formulario" class="FormularioAjax" name="miFormulario" autocomplete="off" role="form" enctype="multipart/form-data">
    
<div class="content-center">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
        <h1 class="login-box-msg">COMPLETA TU REGISTRO</h1>
        </section>

<section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- pantalla  -->
       
        <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">DATOS PERSONALES </h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>

                </div>

              </div>
              <!-- /.card-header -->
              <!--empieza -->

              <!-- /.card-body -->
              <div class="card-body" style="display: block;">
                <div class="row">                
                  <div class="col-sm-12" style="text-align: center">
                    <img src="../Imagenes_Perfil_Estudiantes/default-avatar.png" class="brand-image img-circle elevation-3" id="mostrarimagen2" height="175" width="175">
                    <br><br>
                    <label>Imagen de Perfil</label>
                    <input class="form-control-file" type="file" style="text-align: center" accept="image/jpg/png/jpeg/PNG" id="seleccionararchivo2" name="seleccionararchivo2" placeholder="Imagen de perfil" required><br><br>

                  </div>

                  <div class="col-sm-2">
                    <div class="form-group">
                      <!-- NACIONALIDAD -->
                      <input  hidden type="text" id="txt_id_persona" readonly>
                      <label>Nacionalidad</label>
                      <select class="form-control" name="cb_nacionalidad" id="cb_nacionalidad" style="text-transform: uppercase" required>
                      <?php
                      $query = $mysqli->query('select * from `tbl_nacionalidad`;');
                      while ($resultado = mysqli_fetch_array($query)) {
                        if ($resultado['id_nacionalidad']==82) {
                          # code...
                          echo '<option value="' . $resultado['nacionalidad'] . '" selected=true > ' . $resultado['nacionalidad'] . '</option>';
                        }
                      echo '<option value="' . $resultado['nacionalidad'] . '"> ' . $resultado['nacionalidad'] . '</option>';
                      }
                      ?>
                    </select>
                    </div>
                  </div>

                  <div class="col-sm-2">
                    <label id="label1" for="">Nº Identidad:</label>
                    <div class="form-group">
                      <div class="input-group-prepend">
                        <input name="identidad" type="text" placeholder="Ej: 9999000099999" maxlength="13" minlength="13" data-mask class="form-control" id="identidad" onkeypress="return solonumeros(event);" onblur="ExisteIdentidad();">
                      </div>
                    </div>
                    <p hidden id="TextoIdentidad" style="color:red;">¡Ya existe un registro con esta identidad! </p>
                    <p hidden id="Textomayor" style="color:red;">¡Año incorrecto! </p>
                  </div>


                  <div class="col-sm-2">
                    <div class="form-group">
                      <!-- FECHA DE NACIMIENTO  -->
                      <label>Fecha Nacimiento</label>
                      <input class="form-control" type="date" id="txt_fecha_nacimiento" name="txt_fecha_nacimiento" required onkeydown="return false">

                    </div>
                    </div>

                    <div class="col-sm-2">
                    <div class="form-group">
                      <!-- LUGAR DE NACIMIENTO  -->
                      <label>Lugar de Nacimiento</label>
                      <input class="form-control" type="text" id="txt_lugar_nacimiento" name="txt_lugar_nacimiento" mask="Upper" style="text-transform: uppercase" onkeyup="DobleEspacio(this, event);" placeholder="Ej: Lugar, Municipio" required>
                    </div>
                    </div>

                  <div class="col-sm-2">
                    <div class="form-group">
                      <!-- ESTADO CIVIL -->
                      <label>Estado civil</label>
                      <select class="form-control" name="cb_ecivil" id="cb_ecivil" style="text-transform: uppercase" required>
                      <?php
                      $query = $mysqli->query('select * from `tbl_estadocivil`;');
                      while ($resultado = mysqli_fetch_array($query)) {
                      echo '<option value="' . $resultado['estado_civil'] . '"> ' . $resultado['estado_civil'] . '</option>';
                      }
                      ?>
                    </select>
                    </div>
                  </div>

                  <div class="col-sm-2">
                    <div class="form-group">
                      <!-- CURRICULUM -->
                      <label>Currículum</label>
                      <input class="form-control" type="file" accept=application/pdf id="curriculum" name="curriculum" required>

                    </div>
                  </div>


                  <!-- /.form-group -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.card-body -->

            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">INFORMACIÓN DE CONTACTO</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>

                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                <div class="col-sm-2">
                    <div class="form-group">
                      <label for="">Teléfono</label>
                      <input type="text" name="tel" id="tel" class="form-control name_list" data-inputmask="'mask': '9999-9999'" onkeypress="return solonumeros2(event);" onblur="valtel(document.miFormulario.tel);" data-mask maxlength="9" required>
                    </div>
                  </div>

                  <div class="col-sm-1">
                    <label>¿Trabajas?</label>
                    <div class="form-group">
                      <input hidden class="form-control" id="rb_trabajo" name="rb_trabajo" type="text">
                      <span class="form-control">
                        <label class="checkbox-inline"><input class="CheckedAK" id="si" type="radio" name="check[]" value="SI">Si</label>
                        <label class="checkbox-inline"><input class="CheckedAK" id="no" type="radio" name="check[]" value="NO">No</label>
                      </span>
                    </div>
                  </div>

                  <!-- /.form-group -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.card-body -->



            <!--CONTACTOS-->


            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">INFORMACIÓN ACADÉMICA</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>

                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">

                  <div class="col-sm-3">
                    <div class="form-group">
                      <!-- CARRERA --> 
                      <label>Carrera</label>
                      <select class="form-control" id="cb_carrera" name="cb_carrera" style="text-transform: uppercase" required>
                      <?php
                      $query = $mysqli->query('SELECT * FROM `tbl_carrera`;');
                      while ($resultado = mysqli_fetch_array($query)) {
                        if ($resultado['id_carrera']==1) {
                      echo '<option value="' . $resultado['Descripcion'] . '"> ' . $resultado['Descripcion'] . '</option>';
                      }                      
                      echo '<option value="' . $resultado['Descripcion'] . '"> ' . $resultado['Descripcion'] . '</option>';
                      }
                      ?>
                      </select>
                    </div>
                  </div>

                  <div class="col-sm-3">
                    <div class="form-group">
                      <!-- CENTRO REGIONAL --> 
                      <label>Centro Regional</label>
                      <select class="form-control" name="cb_cr" id="cb_cr" style="text-transform: uppercase" required>
                      <?php
                      $query = $mysqli->query('SELECT * FROM `tbl_centros_regionales`;');
                      while ($resultado = mysqli_fetch_array($query)) {
                        if ($resultado['Id_centro_regional']==1) {
                      echo '<option value="' . $resultado['centro_regional'] . '"> ' . $resultado['centro_regional'] . '</option>';
                      }                      
                      echo '<option value="' . $resultado['centro_regional'] . '"> ' . $resultado['centro_regional'] . '</option>';
                      }
                      ?>
                      </select>
                    </div>
                  </div>

                  
                
                  <div class="col-sm-2">
                    <label>¿Eres egresado?</label>
                    <div class="form-group">
                      <input hidden class="form-control" id="rb_egresado" name="rb_egresado" type="text">
                      <span class="form-control">
                        <label class="checkbox-inline"><input class="Check" id="siegresado" type="radio" name="egresado" value="SI">Si</label>
                        <label class="checkbox-inline"><input class="Check" id="noegresado" type="radio" name="egresado" value="NO">No</label>
                      </span>
                    </div>
                  </div>

                     </div>
                    </div>
                  </div>

             <!-- /.col -->
            <div class="col-12">
            <p class="text-center" style="margin-top: 10px;">
            <button type="button" class="btn btn-primary btn-lg" id="btn_guardar_datos_estudiantes" name="btn_guardar_datos_estudiantes"><i class="zmdi zmdi-floppy"></i>Guardar Cambios</button>
            <p class="mb-0">
                
              </p>
            </p>
              </div>

              
        </section>
      </section>
    </div>
            <!-- /.col -->

</form>

    <!-- REQUIRED SCRIPTS -->
  <!-- jQuery -->
  <script src="../plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- Bootstrap 4 -->
  <!-- Select2 -->
  <script src="../plugins/select2/js/select2.full.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../dist/js/adminlte.js"></script>

  <!-- OPTIONAL SCRIPTS -->
  <script src="../dist/js/demo.js"></script>

  <!-- PAGE PLUGINS -->
  <!-- jQuery Mapael -->
  <!-- bootstrap color picker -->
  <script src="../plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
  <script src="../plugins/jquery-mousewheel/jquery.mousewheel.js"></script>

  <script src="../plugins/raphael/raphael.min.js"></script>
  <script src="../plugins/jquery-mapael/jquery.mapael.min.js"></script>
  <script src="../plugins/jquery-mapael/maps/usa_states.min.js"></script>
  <!-- DataTables -->
  <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

  <!-- InputMask -->
  <script src="../plugins/moment/moment.min.js"></script>
  <script src="../plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
  <!-- ChartJS -->
  <script src="../plugins/chart.js/Chart.min.js"></script>

  <!-- PAGE SCRIPTS -->
  <script src="../dist/js/pages/dashboard2.js"></script>

  <!-- Bootstrap 4 -->
  <!-- SweetAlert2 -->
  <script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
  <script src="../plugins/sweetalert/sweetalert.min.js"></script>
  <!-- Toastr -->
  <script src="../plugins/toastr/toastr.min.js"></script>
  <!-- AdminLTE App -->
  <script type="text/javascript" src="../plugins/sweetalert2/sweetalert2.min.js"></script>

  <script src="../dist/js/sweetalert2.min.js"></script>

  <script src="../dist/js/main.js"></script>



  <script type="text/javascript" src="../plugins/bootstrap/js/bootstrap.min.js"></script>


  <script src="../js/sweetalert2.min.js"></script>

  <script src="../js/main.js"></script>
  <script type="text/javascript" src="../js/funciones_reg_estudiantes_login.js"></script>
</body>

</html>