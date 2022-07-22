<?php

ob_start();


session_start();
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');


$Id_objeto = 186;
bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INGRESO', 'A MANTENIMIENTO/CREAR TIPO ADQUISICION');


$visualizacion = permiso_ver($Id_objeto);



if ($visualizacion == 0) {
    //header('location:  ../vistas/menu_roles_vista.php');

    echo '<script type="text/javascript">
                              swal({
                                   title:"",
                                   text:"¡Lo sentimos! No tiene permiso de visualizar la pantalla",
                                   type: "error",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                           window.location = "../vistas/menu_mantenimiento_laboratorio.php";

                            </script>';
} else {


    if (permisos::permiso_insertar($Id_objeto) == '1') {
        $_SESSION['btn_guardar_tipoadquisicion'] = "";
    } else {
        $_SESSION['btn_guardar_tipoadquisicion'] = "disabled";
    }


    if (isset($_REQUEST['msj'])) {
        $msj = $_REQUEST['msj'];
        if ($msj == 1) {
            echo '<script> alert("¡Lo sentimos! El rol a ingresar ya existe, por favor intenta con uno nuevo")</script>';
        }

        if ($msj == 2) {
            echo '<script> alert("Rol agregado correctamente")</script>';
        }
    }
}


ob_end_flush();


?>


<!DOCTYPE html>
<html>

<head>
    <script src="../js/autologout.js"></script>
    <title></title>



</head>

<body>


    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">


                        <h1>Tipo de Adquisición</h1>
                    </div>



                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="../vistas/menu_mantenimiento_laboratorio.php">Menú Mantenimiento</a></li>
                            <li class="breadcrumb-item"><a href="../vistas/mantenimiento_tipoadquisicion_vista.php"> Mantenimiento Tipo Adquisición</a></li>
                        </ol>
                    </div>

                    <div class="RespuestaAjax"></div>

                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid ">
                <!-- pantalla 1 -->
                <form action="../Controlador/guardar_tipoadquisicion_controlador.php" method="post" data-form="save" class="FormularioAjax" autocomplete="off">

                    <div class="card card-default ">
                        <div class="card-header center">
                            <h3 class="card-title">Nuevo Tipo Adquisición</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>


                        <!-- /.card-header -->
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label>Ingrese el Tipo Adquisición</label>
                                        <input class="form-control" class="tf w-input" type="text" id="txt_tipoadquisicion1" onkeypress="return validacion_para_nombre(event)" name="txt_tipoadquisicion1" required="" maxlength="50" style="text-transform: uppercase" onkeyup="DobleEspacio(this, event); MismaLetra('txt_tipoadquisicion1');">

                                    </div>


                                    <p class="text-center" style="margin-top: 20px;">
                                        <button type="submit" class="btn btn-primary" id="btn_guardar_tipoadquisicion" name="btn_guardar_tipoadquisicion" <?php echo $_SESSION['btn_guardar_tipoadquisicion']; ?>><i class="zmdi zmdi-floppy"></i> Guardar</button>

                                        <a href="../vistas/mantenimiento_tipoadquisicion_vista.php" class="btn btn-danger"><i class="zmdi zmdi-floppy"></i> Cancelar</a>

                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- /.card-body -->
                        <div class="card-footer">

                        </div>
                    </div>
                    <div class="RespuestaAjax"></div>

                </form>

            </div>
        </section>

    </div>

</body>

</html>



<script type="text/javascript" src="../js/validaciones_gestion_laboratorio.js"></script>