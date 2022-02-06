<?php
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_visualizar.php');


if (permiso_ver('103') == '1') {

    $_SESSION['menu_plan_estudio_vista'] = "...";
} else {
    $_SESSION['menu_plan_estudio_vista'] = "No 
  tiene permisos para visualizar";
}

if (permiso_ver('96') == '1') {

    $_SESSION['crear_plan_estudio_vista'] = "...";
} else {
    $_SESSION['crear_plan_estudio_vista'] = "No 
  tiene permisos para visualizar";
}

if (permiso_ver('97') == '1') {

    $_SESSION['historial_plan_estudio_vista'] = "...";
} else {
    $_SESSION['historial_plan_estudio_vista'] = "No 
  tiene permisos para visualizar";
}
if (permiso_ver('98') == '1') {

    $_SESSION['gestion_plan_estudio_vista'] = "...";
} else {
    $_SESSION['gestion_plan_estudio_vista'] = "No 
  tiene permisos para visualizar";
}
if (permiso_ver('106') == '1') {

    $_SESSION['equivalencias_vista'] = "...";
} else {
    $_SESSION['equivalencias_vista'] = "No 
  tiene permisos para visualizar";
}
if (permiso_ver('105') == '1') {

    $_SESSION['comparar_plan_vista'] = "...";
} else {
    $_SESSION['comparar_plan_vista'] = "No 
  tiene permisos para visualizar";
}
if (permiso_ver('112') == '1') {

    $_SESSION['requisitos_vista'] = "...";
} else {
    $_SESSION['requisitos_vista'] = "No 
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

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">Menú Plan de Estudio </h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Menú Plan de estudio</li>
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




                        <!-- <p><?php echo $_SESSION['crear_plan_de_estudio_vista']; ?></p>
 -->

                        <!-- fix for small devices only -->
                        <div class="clearfix hidden-md-up"></div>



                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <h4>Crear Plan de Estudio </h4>
                                    <p><?php echo $_SESSION['crear_plan_estudio_vista']; ?></p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-user-edit"></i>
                                </div>
                                <a href="../vistas/crear_plan_estudio_vista.php" class="small-box-footer">
                                    Ir <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <h4>Gestión de Plan de Estudio </h4>
                                    <p><?php echo $_SESSION['gestion_plan_estudio_vista']; ?></p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-user-edit"></i>
                                </div>
                                <a href="../vistas/gestion_plan_estudio_vista.php" class="small-box-footer">
                                    Ir <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>


                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <h4>Historial de Plan de Estudio </h4>
                                    <p><?php echo $_SESSION['historial_plan_estudio_vista']; ?></p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-user-edit"></i>
                                </div>
                                <a href="../vistas/historial_plan_estudio_vista.php" class="small-box-footer">
                                    Ir <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <h4>Agregar Equivalencias </h4>
                                    <p><?php echo $_SESSION['equivalencias_vista']; ?></p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-user-edit"></i>
                                </div>
                                <a href="../vistas/equivalencias_plan_estudio_vista.php" class="small-box-footer">
                                    Ir <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <h4>Agregar Requisitos</h4>
                                    <p><?php echo $_SESSION['requisitos_vista']; ?></p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-user-edit"></i>
                                </div>
                                <a href="../vistas/requisitos_plan_estudio_vista.php" class="small-box-footer">
                                    Ir <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <h4>Tabla de Equivalencias </h4>
                                    <p><?php echo $_SESSION['comparar_plan_vista']; ?></p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-user-edit"></i>
                                </div>
                                <a href="../vistas/comparar_plan_estudio_vista.php" class="small-box-footer">
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



</body>

</html>