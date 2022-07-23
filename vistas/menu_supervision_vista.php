<?php
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/permisos_usuario.php');
require_once('../clases/funcion_visualizar.php');

if (permiso_ver('2010')=='1')
 {
  
  $_SESSION['primera_supervision_menu']="...";
}
else
{
$_SESSION['primera_supervision_menu']="No tiene permisos para visualizar";

}

if (permiso_ver('2011')=='1')
 {
  
  $_SESSION['segunda_supervision_menu']="...";
}
else
{
$_SESSION['segunda_supervision_menu']="No 
  tiene permisos para visualizar";

}

if (permiso_ver('2012')=='1')
 {
  
  $_SESSION['unica_supervision_menu']="...";
}
else
{
$_SESSION['unica_supervision_menu']="No 
  tiene permisos para visualizar";

}

if (permiso_ver('2013')=='1')
 {
  
  $_SESSION['asignar_docente_menu']="...";
}
else
{
$_SESSION['asignar_docente_menu']="No 
  tiene permisos para visualizar";

}

if (permiso_ver('2014')=='1')
 {
  
  $_SESSION['estudiante_pps_menu']="...";
}
else
{
$_SESSION['estudiante_pps_menu']="No 
  tiene permisos para visualizar";

}

if (permiso_ver('2015')=='1')
 {
  
  $_SESSION['reportes_pps_menu']="...";
}
else
{
$_SESSION['reportes_pps_menu']="No 
  tiene permisos para visualizar";

}


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
              <h1 class="m-0 text-dark">Práctica Profesional Supervisada</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
                <li class="breadcrumb-item active">Vinculación</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->



      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- Info boxes -->
          <div class="row" style="  display: flex;
    align-items: center;
    justify-content: center;">



            <div class="col-6 col-sm-6 col-md-4">
              <div class="small-box bg-light">
                <div class="inner">
                  <h5>Primera Supervisión </h5>
                  <p><?php echo $_SESSION['primera_supervision_menu']; ?></p>
                </div>
                <div class="icon">
                  <i class="fas fa-user-plus"></i>
                </div>
                <a href="../vistas/guardar_primera_visita_vista.php" class="small-box-footer">
                  Ir <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
              <!-- /.info-box -->
            </div>


            <div class="col-6 col-sm-6 col-md-4">
              <div class="small-box bg-light">
                <div class="inner">
                  <h5>Segunda Supervisión </h5>
                  <p><?php echo $_SESSION['segunda_supervision_menu']; ?></p>
                </div>
                <div class="icon">

                  <i class="fas fa-user-plus"></i>
                </div>
                <a href="../vistas/guardar_segunda_visita_vista.php" class="small-box-footer">
                  Ir <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
              <!-- /.info-box -->
            </div>


            <div class="col-6 col-sm-6 col-md-4">
              <div class="small-box bg-light">
                <div class="inner">
                  <h5>Única Supervisión </h5>
                  <p><?php echo $_SESSION['unica_supervision_menu']; ?></p>
                </div>
                <div class="icon">

                  <i class="fas fa-user-plus"></i>
                </div>
                <a href="../vistas/guardar_unica_visita_vista.php" class="small-box-footer">
                  Ir <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
              <!-- /.info-box -->
            </div>

            <div class="col-6 col-sm-6 col-md-4">
              <div class="small-box bg-light">
                <div class="inner">
                  <h5>Asignar Docente Supervisor </h5>
                  <p><?php echo $_SESSION['asignar_docente_menu']; ?></p>
                </div>
                <div class="icon">

                  <i class="fas fa-user-plus"></i>
                </div>
                <a href="../vistas/gestion_docente_supervisor_vista.php" class="small-box-footer">
                  Ir <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
              <!-- /.info-box -->
            </div>



            <div class="col-6 col-sm-6 col-md-4">
              <div class="small-box bg-primary">
                <div class="inner">
                  <h4>Estudiantes en Práctica Profesional Supervisada </h4>
                  <p><?php echo $_SESSION['estudiante_pps_menu']; ?></p>
                </div>
                <div class="icon">
                  <i class="fas fa-user-edit"></i>
                </div>
                <a href="../vistas/gestion_practicantes_vista.php" class="small-box-footer">
                  Ir <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>
            <div class="col-6 col-sm-6 col-md-4">
              <div class="small-box bg-primary">
                <div class="inner">
                  <h4>Reportes Práctica Profesional Supervisada </h4>
                  <p><?php echo $_SESSION['reportes_pps_menu']; ?></p>
                </div>
                <div class="icon">
                  <i class="fas fa-user-edit"></i>
                </div>
                <a href="../vistas/estadisticas_practica_profesional_vista.php" class="small-box-footer">
                  Ir <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>
            <!-- /.col -->

            <!-- /.row -->
          </div>
          <!--/. container-fluid -->
        </div>
      </section>
      <!-- /.content -->
    </div>

  </div>

</body>

</html>