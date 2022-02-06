<?php

ob_start();

session_start();

require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_visualizar.php');



if (permiso_ver('184') == '1') {

  $_SESSION['mantenimiento_crear_ubicacion_vista'] = "...";
} else {
  $_SESSION['mantenimiento_crear_ubicacion_vista'] = "No 
  tiene permisos para visualizar";
}

if (permiso_ver('185') == '1') {

  $_SESSION['mantenimiento_ubicacion_vista'] = "...";
} else {
  $_SESSION['mantenimiento_ubicacion_vista'] = "No 
  tiene permisos para visualizar";
}

if (permiso_ver('186') == '1') {

  $_SESSION['mantenimiento_crear_tipoadquisicion_vista'] = "...";
} else {
  $_SESSION['mantenimiento_crear_tipoadquisicion_vista'] = "No 
  tiene permisos para visualizar";
}

if (permiso_ver('187') == '1') {

  $_SESSION['mantenimiento_tipoadquisicion_vista'] = "...";
} else {
  $_SESSION['mantenimiento_tipoadquisicion_vista'] = "No 
  tiene permisos para visualizar";
}

if (permiso_ver('188') == '1') {

  $_SESSION['mantenimiento_crear_estado_vista'] = "...";
} else {
  $_SESSION['mantenimiento_crear_estado_vista'] = "No 
  tiene permisos para visualizar";
}

if (permiso_ver('189') == '1') {

  $_SESSION['mantenimiento_estado_vista'] = "...";
} else {
  $_SESSION['mantenimiento_estado_vista'] = "No 
  tiene permisos para visualizar";
}

if (permiso_ver('191') == '1') {

  $_SESSION['mantenimiento_crear_tipo_producto_vista'] = "...";
} else {
  $_SESSION['mantenimiento_crear_tipo_producto_vista'] = "No 
  tiene permisos para visualizar";
}

if (permiso_ver('192') == '1') {

  $_SESSION['mantenimiento_tipo_producto_vista'] = "...";
} else {
  $_SESSION['mantenimiento_tipo_producto_vista'] = "No 
  tiene permisos para visualizar";
}

if (permiso_ver('197') == '1') {

  $_SESSION['mantenimiento_crear_tipo_transaccion_vista'] = "...";
} else {
  $_SESSION['mantenimiento_crear_tipo_transaccion_vista'] = "No 
  tiene permisos para visualizar";
}

if (permiso_ver('198') == '1') {

  $_SESSION['mantenimiento_tipo_transaccion_vista'] = "...";
} else {
  $_SESSION['mantenimiento_tipo_transaccion_vista'] = "No 
  tiene permisos para visualizar";
}

if (permiso_ver('199') == '1') {

  $_SESSION['mantenimiento_crear_tipo_caracteristica_vista'] = "...";
} else {
  $_SESSION['mantenimiento_crear_tipo_caracteristica_vista'] = "No 
  tiene permisos para visualizar";
}

if (permiso_ver('200') == '1') {

  $_SESSION['mantenimiento_tipo_caracteristica_vista'] = "...";
} else {
  $_SESSION['mantenimiento_tipo_caracteristica_vista'] = "No 
  tiene permisos para visualizar";
}

ob_end_flush();

?>



<!DOCTYPE html>
<html>

<head>
  <script src="../js/autologout.js"></script>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">



</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">MANTENIMIENTOS DE GESTIÓN DE LABORATORIOS </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Inicio</a></li>

              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->


      <div class="card card-default">
        <div class="card-header">

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>

          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">



              <!-- comienzo de Tipo de adquisición -->

              <!-- /.info-box -->
              <section class="content">
                <div class="container-fluid">
                  <!-- Info boxes -->
                  <div class="row" style="  display: flex;
    align-items: center;
    justify-content: center;">
                    <div class="col-6 col-sm-6 col-md-4">
                      <div class="small-box bg-light">
                        <div class="inner">
                          <h4>Crear Tipo Adquisición </h4>
                          <p><?php echo $_SESSION['mantenimiento_crear_tipoadquisicion_vista']; ?></p>
                        </div>
                        <div class="icon">
                          <i class="fas fa-plus-square"></i>
                        </div>

                        <a href="../vistas/mantenimiento_crear_tipoadquisicion_vista.php" class="small-box-footer">
                          Ir <i class="fas fa-arrow-circle-right"></i>
                        </a>
                      </div>

                    </div>
                    <!-- fix for small devices only -->
                    <div class="clearfix hidden-md-up"></div>
                    <!-- /.info-box -->
                    <div class="col-6 col-sm-6 col-md-4">
                      <div class="small-box bg-primary">
                        <div class="inner">
                          <h4>Mantenimiento Tipo Adquisición </h4>
                          <p><?php echo $_SESSION['mantenimiento_tipoadquisicion_vista']; ?></p>
                        </div>
                        <div class="icon">
                          <i class="fas fa-edit"></i>
                        </div>

                        <a href="../vistas/mantenimiento_tipoadquisicion_vista.php" class="small-box-footer">
                          Ir <i class="fas fa-arrow-circle-right"></i>
                        </a>
                      </div>

                    </div>
                    <!-- /.row -->
                  </div>
                  <!--/. container-fluid -->
                </div>
              </section>

              <!-- Final de Tipo de adquisición -->

              <!-- comienzo de Tipo de Transacción -->

              <!-- /.info-box -->
              <section class="content">
                <div class="container-fluid">
                  <!-- Info boxes -->
                  <div class="row" style="  display: flex;
    align-items: center;
    justify-content: center;">
                    <div class="col-6 col-sm-6 col-md-4">
                      <div class="small-box bg-light">
                        <div class="inner">
                          <h4>Crear Tipo Transacción </h4>
                          <p><?php echo $_SESSION['mantenimiento_tipo_transaccion_vista']; ?></p>
                        </div>
                        <div class="icon">
                          <i class="fas fa-plus-square"></i>
                        </div>

                        <a href="../vistas/mantenimiento_crear_tipo_transaccion_vista.php" class="small-box-footer">
                          Ir <i class="fas fa-arrow-circle-right"></i>
                        </a>
                      </div>

                    </div>
                    <!-- fix for small devices only -->
                    <div class="clearfix hidden-md-up"></div>
                    <!-- /.info-box -->
                    <div class="col-6 col-sm-6 col-md-4">
                      <div class="small-box bg-primary">
                        <div class="inner">
                          <h4>Mantenimiento Tipo Transacción </h4>
                          <p><?php echo $_SESSION['mantenimiento_tipo_transaccion_vista']; ?></p>
                        </div>
                        <div class="icon">
                          <i class="fas fa-edit"></i>
                        </div>

                        <a href="../vistas/mantenimiento_tipo_transaccion_vista.php" class="small-box-footer">
                          Ir <i class="fas fa-arrow-circle-right"></i>
                        </a>
                      </div>

                    </div>
                    <!-- /.row -->
                  </div>
                  <!--/. container-fluid -->
                </div>
              </section>

              <!-- Final de Tipo de Transacción -->

              <!-- comienzo de Tipo de Estado -->

              <!-- /.info-box -->
              <section class="content">
                <div class="container-fluid">
                  <!-- Info boxes -->
                  <div class="row" style="  display: flex;
    align-items: center;
    justify-content: center;">
                    <div class="col-6 col-sm-6 col-md-4">
                      <div class="small-box bg-light">
                        <div class="inner">
                          <h4>Crear Tipo Estado </h4>
                          <p><?php echo $_SESSION['mantenimiento_crear_estado_vista']; ?></p>
                        </div>
                        <div class="icon">
                          <i class="fas fa-plus-square"></i>
                        </div>

                        <a href="../vistas/mantenimiento_crear_estado_vista.php" class="small-box-footer">
                          Ir <i class="fas fa-arrow-circle-right"></i>
                        </a>
                      </div>

                    </div>
                    <!-- fix for small devices only -->
                    <div class="clearfix hidden-md-up"></div>
                    <!-- /.info-box -->
                    <div class="col-6 col-sm-6 col-md-4">
                      <div class="small-box bg-primary">
                        <div class="inner">
                          <h4>Mantenimiento Tipo Estado </h4>
                          <p><?php echo $_SESSION['mantenimiento_estado_vista']; ?></p>
                        </div>
                        <div class="icon">
                          <i class="fas fa-edit"></i>
                        </div>

                        <a href="../vistas/mantenimiento_tipo_estado_vista.php" class="small-box-footer">
                          Ir <i class="fas fa-arrow-circle-right"></i>
                        </a>
                      </div>

                    </div>
                    <!-- /.row -->
                  </div>
                  <!--/. container-fluid -->
                </div>
              </section>

              <!-- Final de Tipo de Estado -->

              <!-- comienzo de Tipo de Característica -->

              <!-- /.info-box -->
              <section class="content">
                <div class="container-fluid">
                  <!-- Info boxes -->
                  <div class="row" style="  display: flex;
    align-items: center;
    justify-content: center;">
                    <div class="col-6 col-sm-6 col-md-4">
                      <div class="small-box bg-light">
                        <div class="inner">
                          <h4>Crear Tipo Característica </h4>
                          <p><?php echo $_SESSION['mantenimiento_crear_tipo_caracteristica_vista']; ?></p>
                        </div>
                        <div class="icon">
                          <i class="fas fa-plus-square"></i>
                        </div>

                        <a href="../vistas/mantenimiento_crear_tipo_caracteristica_vista.php" class="small-box-footer">
                          Ir <i class="fas fa-arrow-circle-right"></i>
                        </a>
                      </div>

                    </div>
                    <!-- fix for small devices only -->
                    <div class="clearfix hidden-md-up"></div>
                    <!-- /.info-box -->
                    <div class="col-6 col-sm-6 col-md-4">
                      <div class="small-box bg-primary">
                        <div class="inner">
                          <h4>Mantenimiento Tipo Característica </h4>
                          <p><?php echo $_SESSION['mantenimiento_tipo_caracteristica_vista']; ?></p>
                        </div>
                        <div class="icon">
                          <i class="fas fa-edit"></i>
                        </div>

                        <a href="../vistas/mantenimiento_tipo_caracteristica_vista.php" class="small-box-footer">
                          Ir <i class="fas fa-arrow-circle-right"></i>
                        </a>
                      </div>

                    </div>
                    <!-- /.row -->
                  </div>
                  <!--/. container-fluid -->
                </div>
              </section>

              <!-- Final de Tipo de Característica -->

              <!-- comienzo de Tipo de Producto -->

              <!-- /.info-box -->
              <section class="content">
                <div class="container-fluid">
                  <!-- Info boxes -->
                  <div class="row" style="  display: flex;
    align-items: center;
    justify-content: center;">
                    <div class="col-6 col-sm-6 col-md-4">
                      <div class="small-box bg-light">
                        <div class="inner">
                          <h4>Crear Tipo Producto </h4>
                          <p><?php echo $_SESSION['mantenimiento_crear_tipo_producto_vista']; ?></p>
                        </div>
                        <div class="icon">
                          <i class="fas fa-plus-square"></i>
                        </div>

                        <a href="../vistas/mantenimiento_crear_tipo_producto_vista.php" class="small-box-footer">
                          Ir <i class="fas fa-arrow-circle-right"></i>
                        </a>
                      </div>

                    </div>
                    <!-- fix for small devices only -->
                    <div class="clearfix hidden-md-up"></div>
                    <!-- /.info-box -->
                    <div class="col-6 col-sm-6 col-md-4">
                      <div class="small-box bg-primary">
                        <div class="inner">
                          <h4>Mantenimiento Tipo Producto </h4>
                          <p><?php echo $_SESSION['mantenimiento_tipo_producto_vista']; ?></p>
                        </div>
                        <div class="icon">
                          <i class="fas fa-edit"></i>
                        </div>

                        <a href="../vistas/mantenimiento_tipo_producto_vista.php" class="small-box-footer">
                          Ir <i class="fas fa-arrow-circle-right"></i>
                        </a>
                      </div>

                    </div>
                    <!-- /.row -->
                  </div>
                  <!--/. container-fluid -->
                </div>
              </section>

              <!-- Final de Tipo de Producto -->

              <!-- comienzo de Ubicación -->

              <!-- /.info-box -->
              <section class="content">
                <div class="container-fluid">
                  <!-- Info boxes -->
                  <div class="row" style="  display: flex;
    align-items: center;
    justify-content: center;">
                    <div class="col-6 col-sm-6 col-md-4">
                      <div class="small-box bg-light">
                        <div class="inner">
                          <h4>Crear Ubicación </h4>
                          <p><?php echo $_SESSION['mantenimiento_crear_ubicacion_vista']; ?></p>
                        </div>
                        <div class="icon">
                          <i class="fas fa-plus-square"></i>
                        </div>

                        <a href="../vistas/mantenimiento_crear_ubicacion_vista.php" class="small-box-footer">
                          Ir <i class="fas fa-arrow-circle-right"></i>
                        </a>
                      </div>

                    </div>
                    <!-- fix for small devices only -->
                    <div class="clearfix hidden-md-up"></div>
                    <!-- /.info-box -->
                    <div class="col-6 col-sm-6 col-md-4">
                      <div class="small-box bg-primary">
                        <div class="inner">
                          <h4>Mantenimiento Ubicación </h4>
                          <p><?php echo $_SESSION['mantenimiento_ubicacion_vista']; ?></p>
                        </div>
                        <div class="icon">
                          <i class="fas fa-edit"></i>
                        </div>

                        <a href="../vistas/mantenimiento_ubicacion_vista.php" class="small-box-footer">
                          Ir <i class="fas fa-arrow-circle-right"></i>
                        </a>
                      </div>

                    </div>
                    <!-- /.row -->
                  </div>
                  <!--/. container-fluid -->
                </div>
              </section>

              <!-- Final de Ubicación -->



              <!-- /.form-group -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.card-body -->
      </div>






    </div>

  </div>

</body>

</html>