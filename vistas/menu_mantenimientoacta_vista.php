<?php
ob_start();
session_start();
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_bitacora.php');

bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'Ingreso', 'A Menu Mantenimiento Actas');



if (permiso_ver('5013') == '1') {

    $_SESSION['mantenimiento_tipo_reunion_vista'] = "...";
} else {
    $_SESSION['mantenimiento_tipo_reunion_vista'] = "No tiene permisos para visualizar";
}

if (permiso_ver('5014') == '1') {

    $_SESSION['mantenimiento_estado_acta_vista'] = "...";
} else {
    $_SESSION['mantenimiento_estado_acta_vista'] = "No tiene permisos para visualizar";
}
if (permiso_ver('5015') == '1') {

    $_SESSION['mantenimiento_estado_reunion_vista'] = "...";
} else {
    $_SESSION['mantenimiento_estado_reunion_vista'] = "No tiene permisos para visualizar";
}

if (permiso_ver('5016') == '1') {

    $_SESSION['mantenimiento_estado_acuerdo_vista'] = "...";
} else {
    $_SESSION['mantenimiento_estado_acuerdo_vista'] = "No tiene permisos para visualizar";
}
if (permiso_ver('5017') == '1') {

    $_SESSION['mantenimiento_estado_notificacion_vista'] = "...";
} else {
    $_SESSION['mantenimiento_estado_notificacion_vista'] = "No tiene permisos para visualizar";
}

if (permiso_ver('5018') == '1') {

    $_SESSION['mantenimiento_estado_participante_vista'] = "...";
} else {
    $_SESSION['mantenimiento_estado_participante_vista'] = "No tiene permisos para visualizar";
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
                            <h1 class="m-0 text-dark">Menú Mantenimiento actas</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="pagina_principal_vista">Inicio</a></li>
                                <li class="breadcrumb-item active">Menú Mantenimiento actas</li>
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




                            <!-- /.info-box -->
                            <section class="content">
                                <div class="container-fluid">
                                    <!-- Info boxes -->
                                    <div class="row" style="  display: flex; align-items: center; justify-content: center;">
                                        <div class="col-6 col-sm-6 col-md-4">
                                            <div class="small-box bg-primary">
                                                <div class="inner">
                                                    <h4>Mantenimiento Tipo Reunion</h4>
                                                    <p><?php echo $_SESSION['mantenimiento_tipo_reunion_vista']; ?></p>
                                                </div>
                                                <div class="icon">
                                                    <i class="fas fa-edit"></i>
                                                </div>
                                                <a href="../vistas/mantenimiento_actareunion_vista.php" class="small-box-footer">
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
                                                    <h4>Mantenimiento Estado Acta </h4>
                                                    <p><?php echo $_SESSION['mantenimiento_estado_acta_vista']; ?></p>
                                                </div>
                                                <div class="icon">
                                                    <i class="fas fa-edit"></i>
                                                </div>

                                                <a href="../vistas/mantenimiento_estadoacta_vista.php" class="small-box-footer">
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
                            <section class="content">
                                <div class="container-fluid">
                                    <!-- Info boxes -->
                                    <div class="row" style="  display: flex; align-items: center; justify-content: center;">

                                        <div class="col-6 col-sm-6 col-md-4">
                                            <div class="small-box bg-primary">
                                                <div class="inner">
                                                    <h4>Mantenimiento Estado Reunión</h4>
                                                    <p><?php echo $_SESSION['mantenimiento_estado_reunion_vista']; ?></p>
                                                </div>
                                                <div class="icon">
                                                    <i class="fas fa-edit"></i>
                                                </div>

                                                <a href="../vistas/mantenimiento_estadoreunion_vista.php" class="small-box-footer">
                                                    Ir <i class="fas fa-arrow-circle-right"></i>
                                                </a>
                                            </div>
                                            <!-- /.info-box -->
                                        </div>
                                        <!-- fix for small devices only -->
                                        <div class="clearfix hidden-md-up"></div>

                                        <div class="col-6 col-sm-6 col-md-4">
                                            <div class="small-box bg-primary">
                                                <div class="inner">
                                                    <h4>Mantenimiento Estado Acuerdo</h4>
                                                    <p><?php echo  $_SESSION['mantenimiento_estado_acuerdo_vista']; ?></p>
                                                </div>
                                                <div class="icon">
                                                    <i class="fas fa-edit"></i>
                                                </div>

                                                <a href="../vistas/mantenimiento_estadoacuerdo_vista.php" class="small-box-footer">
                                                    Ir <i class="fas fa-arrow-circle-right"></i>
                                                </a>
                                            </div>
                                            <!-- /.info-box -->
                                        </div>
                                        <!-- /.row -->
                                    </div>
                                    <!--/. container-fluid -->
                                </div>
                            </section>

                            <section class="content">
                                <div class="container-fluid">
                                    <!-- Info boxes -->
                                    <div class="row" style="  display: flex; align-items: center; justify-content: center;">

                                        <div class="col-6 col-sm-6 col-md-4">
                                            <div class="small-box bg-primary">
                                                <div class="inner">
                                                    <h4>Mantenimiento Estado Notificación</h4>
                                                    <p><?php echo $_SESSION['mantenimiento_estado_notificacion_vista']; ?></p>
                                                </div>
                                                <div class="icon">
                                                    <i class="fas fa-edit"></i>
                                                </div>

                                                <a href="../vistas/mantenimiento_estadonoti_vista.php" class="small-box-footer">
                                                    Ir <i class="fas fa-arrow-circle-right"></i>
                                                </a>
                                            </div>
                                            <!-- /.info-box -->
                                        </div>
                                        <!-- fix for small devices only -->
                                        <div class="clearfix hidden-md-up"></div>

                                        <div class="col-6 col-sm-6 col-md-4">
                                            <div class="small-box bg-primary">
                                                <div class="inner">
                                                    <h4>Mantenimiento Estado Participante</h4>
                                                    <p><?php echo $_SESSION['mantenimiento_estado_participante_vista']; ?></p>
                                                </div>
                                                <div class="icon">
                                                    <i class="fas fa-edit"></i>
                                                </div>
                                                <a href="../vistas/mantenimiento_estadoparticipante_vista.php" class="small-box-footer">
                                                    Ir <i class="fas fa-arrow-circle-right"></i>
                                                </a>
                                            </div>
                                            <!-- /.info-box -->
                                        </div>
                                        <!-- /.row -->
                                    </div>
                                    <!--/. container-fluid -->
                                </div>
                            </section>
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