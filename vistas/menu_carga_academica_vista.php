<?php
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_visualizar.php');


// if (permiso_ver('46')=='1')
//  {

//   $_SESSION['crear_carga_academica_vista']="...";
// }
// else
// {
// $_SESSION['crear_carga_academica_vista']="No 
//   tiene permisos para visualizar";

// }
if (permiso_ver('45') == '1') {

  $_SESSION['menu_carga_academica_vista'] = "...";
} else {
  $_SESSION['menu_carga_academica_vista'] = "No 
  tiene permisos para visualizar";
}

if (permiso_ver('47') == '1') {

  $_SESSION['gestion_carga_academica_vista'] = "...";
} else {
  $_SESSION['gestion_carga_academica_vista'] = "No 
  tiene permisos para visualizar";
}

if (permiso_ver('48') == '1') {

  $_SESSION['historial_carga_academica_vista'] = "...";
} else {
  $_SESSION['historial_carga_academica_vista'] = "No 
  tiene permisos para visualizar";
}
if (permiso_ver('104') == '1') {

  $_SESSION['importar_carga_final_vista'] = "...";
} else {
  $_SESSION['importar_carga_final_vista'] = "No 
  tiene permisos para visualizar";
}
if (permiso_ver('275') == '1') {

  $_SESSION['importar_carga_preliminar_vista'] = "...";
} else {
  $_SESSION['importar_carga_preliminar_vista'] = "No 
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
              <h1 class="m-0 text-dark">Menú Carga Académica </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
                <li class="breadcrumb-item active">Menú Carga Académica</li>
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



            <!-- <div class="col-6 col-sm-6 col-md-4">
   <div class="small-box bg-light">
   <div class="inner">
    <h4>Crear Carga Academica </h4>
    <p><?php echo $_SESSION['crear_carga_academica_vista']; ?></p>
  </div>
  <div class="icon">
    <i class="fas fa-user-plus"></i>
  </div>
  <a href="../vistas/crear_carga_academica_vista.php" class="small-box-footer">
   Ir <i class="fas fa-arrow-circle-right"></i>
  </a>
</div>
 /.info-box
</div> -->
            <!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix hidden-md-up"></div>



            <div class="col-12 col-sm-6 col-md-4">
              <div class="small-box bg-primary">
                <div class="inner">
                  <h4>Gestión Carga Académica </h4>
                  <p><?php echo $_SESSION['gestion_carga_academica_vista']; ?></p>
                </div>
                <div class="icon">
                  <i class="fas fa-user-edit"></i>
                </div>
                <a href="../vistas/gestion_carga_academica_vista.php" class="small-box-footer">
                  Ir <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>


            <div class="col-12 col-sm-6 col-md-4">
              <div class="small-box bg-primary">
                <div class="inner">
                  <h4>Historial Carga Académica </h4>
                  <p><?php echo $_SESSION['historial_carga_academica_vista']; ?></p>
                </div>
                <div class="icon">
                  <i class="fas fa-user-edit"></i>
                </div>
                <a href="../vistas/historial_carga_academica_vista.php" class="small-box-footer">
                  Ir <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
              <div class="small-box bg-primary">
                <div class="inner">
                  <h4>Importar Carga Final </h4>
                  <p><?php echo $_SESSION['importar_carga_final_vista']; ?></p>
                </div>
                <div class="icon">
                  <i class="fas fa-user-edit"></i>
                </div>
                <a href="../vistas/importar_carga_final_vista.php" class="small-box-footer">
                  Ir <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
              <div class="small-box bg-light">
                <div class="inner">
                  <h4>Importar Carga Preliminar </h4>
                  <p><?php echo $_SESSION['importar_carga_preliminar_vista']; ?></p>
                </div>
                <div class="icon">
                  <i class="fas fa-user-edit"></i>
                </div>
                <a href="../vistas/importar_carga_preliminar_vista.php" class="small-box-footer">
                  Ir <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>

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