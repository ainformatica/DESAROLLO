<?php
ob_start();


session_start();
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');

$producto = "";
$caracteristicas = "";
$Id_objeto = 209;
bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'Ingresó', 'A Nueva Salida');

$modal = "";
if (isset($_REQUEST['msj'])) {
    $msj = $_REQUEST['msj'];

    if ($msj == 5) {
        $modal = 1;
    }
}

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
                         window.location = "../vistas/pagina_principal_vista.php";

                          </script>';
} else {

    if (permisos::permiso_insertar($Id_objeto) == '1') {
        $_SESSION['btn_guardar_salida_producto'] = "";
    } else {
        $_SESSION['btn_guardar_salida_producto'] = "disabled";
    }


    if (isset($_REQUEST['msj'])) {
        $msj = $_REQUEST['msj'];
        if ($msj == 1) {
            echo '<script> alert("¡Lo sentimos! La SALIDA a ingresar ya existe, favor intenta con uno nuevo")</script>';
        }

        if ($msj == 2) {
            echo '<script> alert("SALIDA agregada correctamente")</script>';
        }
    }
}
ob_end_flush();
?>



<!DOCTYPE html>
<html>

<head>
    <script src="../js/autologout.js"></script>

</head>

<body>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">


                        <h1>Salida del Producto</h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="../vistas/gestion_salida_vista.php">Gestión de Salida</a></li>
                        </ol>
                    </div>

                    <!-- VERIFICAR -->
                    <div class="RespuestaAjax"></div>

                </div>
            </div><!-- /.container-fluid -->
        </section>


        <!-- Main content -->
        <section class="content">
            <div class="container-fluid ">
                <!-- pantalla 1 -->


                <div class="card card-default ">
                    <div class="card-header center">
                        <!-- BUSCADOR -->
                        <h5>Buscar por No. de Inventario</h5>

                        <div>
                            <form action="crear_salida_vista.php" method="post">
                                <input name="palabra" id="palabra" style="text-transform: uppercase; height:35px; width:200px;" placeholder="num inventario..."><input class="btn btn-primary" type="submit" class="search" id="buscador" value="Buscar">
                            </form>
                            <div class="card-tools">
                            </div>
                        </div>
                    </div>
        </section>

        <section class="content">
            <div class="container-fluid ">
                <!-- pantalla 1 -->

                <form action="../Controlador/guardar_salida_controlador.php" method="post" data-form="save" class="FormularioAjax" autocomplete="off">

                    <div class="card card-default ">
                        <div class="card-header center">
                            <h2 class="card-title">Datos del Producto Saliente</h2>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-6">
                                    <?php
                                    include "../Controlador/buscador.php";
                                    $producto = $_SESSION['producto'];
                                    $caracteristicas = $_SESSION['caracteristicas'];
                                    $inventario = $_SESSION['num_inventario'];
                                    $_SESSION['lo_que_busco'] = $inventario;
                                    ?>

                                    <!--    ENTRADA DEL PRODUCTO QUE BUSCO  -->
                                    <input class="form-control" value="<?php echo $producto . '   ' . $caracteristicas; ?>" type="text" id="txt_propiedades" name="txt_propiedades" required="" maxlength="30" readonly="true" disabled="true" style="text-transform: uppercase; height:38px; width:610px;" onkeyup="Espacio(this, event)" onkeypress="return validacion_para_nombre_con_numeros(event)">

                                    <?php
                                    $fecha = date('Y-m-d');
                                    $nuevaFecha = date("Y-m-d", strtotime('-2 day', strtotime($fecha)));
                                    // echo $nuevaFecha;
                                    ?>


                                    <!-- FECHA DE LA SALIDA  -->
                                    <div class="form-group">
                                        <label>Fecha Salida</label>
                                        <input class="form-control" type="date" id="fecha" min="<?php echo $nuevaFecha; ?>" max="<?php date_default_timezone_set('America/Tegucigalpa');
                                                                                                                                    echo date("Y-m-d"); ?>" onchange="handler(event);" value="<?php date_default_timezone_set('America/Tegucigalpa');
                                                                                                                                                                                                echo date("Y-m-d"); ?>" name="fecha" required>
                                    </div>

                                    <tr>

                                        <td style="padding: 40px"></td>
                                        <td>



                                        </td>
                                    </tr>





                                    <!-- LA DESCRIPCION DE BAJA -->
                                    <div class="form-group ">
                                        <textarea class="form-control " style="text-transform: uppercase" class="tf w-input" required type="text" placeholder="ingrese la descripcion del motivo de salida aquí" maxlength="100" name="descripcion" id="descripcion" rows="5" cols="40" onkeyup="DobleEspacio(this, event); MismaLetra('descripcion');" onkeypress="return validacion_para_producto(event)"></textarea>
                                    </div>


                                    <p class="text-center" style="margin-top: 20px;">
                                        <button type="submit" class="btn btn-primary" id="btn_guardar_salida" name="btn_guardar_salida" <?php echo $_SESSION['btn_guardar_salida_producto']; ?>><i class="zmdi zmdi-floppy"></i> Guardar</button>
                                        <a href="../vistas/gestion_salida_vista.php" class="btn btn-danger"><i class="zmdi zmdi-floppy"></i> Cancelar</a>
                                    </p>






                                </div>
                            </div>
                        </div>



                        <!-- /.card-body -->
                        <div class="card-footer"></div>
                    </div>



                    <div class="RespuestaAjax"></div>
                </form>

            </div>
        </section>

    </div>




</body>

</html>

<script type="text/javascript" src="../js/validaciones_gestion_laboratorio.js"></script>

<script type="text/javascript" src="../js/pdf_mantenimientos.js"></script>
<script src="../plugins/select2/js/select2.min.js"></script>
<script src="{{asset('libs/SB-Admin/js/moment.js')}}"></script>