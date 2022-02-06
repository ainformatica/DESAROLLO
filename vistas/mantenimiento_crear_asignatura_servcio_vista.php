<?php

ob_start();


session_start();
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');





$Id_objeto = 109;

bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'Ingreso', 'A MANTENIMIENTO/CREAR ASIGNATURA DE SERVICIO');



$visualizacion = permiso_ver($Id_objeto);



if ($visualizacion == 0) {
    //header('location:  ../vistas/menu_roles_vista.php');

    echo '<script type="text/javascript">
                              swal({
                                   title:"",
                                   text:"Lo sentimos no tiene permiso de visualizar la pantalla",
                                   type: "error",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                           window.location = "../vistas/menu_mantenimiento_plan.php";

                            </script>';
} else {






    if (permisos::permiso_insertar($Id_objeto) == '1') {
        $_SESSION['btn_crear_asignatura_servicio'] = "";
    } else {
        $_SESSION['btn_crear_asignatura_servicio'] = "disabled";
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


                        <h1>ASIGNATURAS DE SERVICIO</h1>
                    </div>



                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="../vistas/menu_mantenimiento_plan.php">Menu Mantenimiento</a></li>
                            <li class="breadcrumb-item"><a href="../vistas/mantenimiento_asignatura_servicio_vista.php"> Mantenimiento Asignatura de servicio</a></li>
                        </ol>
                    </div>

                    <div class="RespuestaAjax"></div>

                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid ">
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">Nuevo Asignatura</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>

                        </div>

                    </div>

                    <div class="card-body" style="display: block;">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">

                                    <label>Nombre de Asignatura</label>

                                    <input class="form-control" type="text" id="txt_nombre_asignatura" name="txt_nombre_asignatura" maxlength="45" required onkeyup="DobleEspacio(this, event); " onkeypress="return sololetras(event)">


                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">

                                    <label>Código</label>

                                    <input class="form-control" type="text" id="txt_codigo_asignatura" name="txt_codigo_asignatura" maxlength="45" required style="text-transform: uppercase">


                                </div>
                            </div>


                            <div class="col-md-1">
                                <div class="form-group">

                                    <label>UV</label>

                                    <input class="form-control" type="text" id="txt_uv" name="txt_uv" maxlength="45" required onkeypress="return solonumeros(event)">


                                </div>
                            </div>


                            <div class="col-md-2">
                                <label>Reposición</label>
                                <td><select class="form-control" style="width: 100%;" name="cbm_reposicion" id="cbm_reposicion">
                                        <option value="0">SELECCIONAR</option>
                                        <option value="SI">SI</option>
                                        <option value="NO">NO</option>
                                    </select></td>
                            </div>
                            <div class="col-md-2">
                                <label>Suficiencia</label>
                                <td><select class="form-control" style="width: 100%;" name="cbm_suficiencia" id="cbm_suficiencia">
                                        <option value="0">SELECCIONAR</option>
                                        <option value="SI">SI</option>
                                        <option value="NO">NO</option>
                                    </select></td>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">

                                    <label>Sílabo</label>

                                    <input class="form-control" type="file" id="txt_silabo" name="txt_silabo" value="" required accept="application/pdf" onchange="Validar();">


                                </div>
                            </div>



                        </div>
                        <div class="container-fluid h-100">
                            <div class="row w-100 align-items-center">
                                <div class="col text-center">
                                    <button class="btn btn-primary" id="guardar_asig_servicio" <?php echo $_SESSION['btn_crear_asignatura_servicio']; ?>>Guardar </button>
                                </div>
                            </div>


                        </div>


                    </div>

                </div>

            </div>



        </section>

    </div>

    <script type="text/javascript" src="../js/mantenimiento_asignatura_crear.js"></script>
    <script type="text/javascript" src="../js/validaciones_plan.js"></script>

</body>

</html>