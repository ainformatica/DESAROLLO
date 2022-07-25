<?php
ob_start();
session_start();


require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');
require_once('../clases/conexion_mantenimientos.php');
require_once('../clases/Conexion.php');
//$registro = controlador_registro_docente::ctrRegistro();
$Id_objeto = 96;








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
                           window.location = "../vistas/menu_plan_estudio_vista.php";

                            </script>';
} else {

    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INGRESO', 'A CREAR UN PLAN DE ESTUDIO.');


    if (permisos::permiso_insertar($Id_objeto) == '1') {
        $_SESSION['btn_crear_plan'] = "";
    } else {
        $_SESSION['btn_crear_plan'] = "disabled";
    }
}



//parametro min de creditos
$sql3 = $mysqli->prepare("SELECT Valor FROM tbl_parametros where Parametro = 'CREDITOS_PLAN_MIN' ");
$sql3->execute();
$resultado3 = $sql3->get_result();
$row3 = $resultado3->fetch_array(MYSQLI_ASSOC);

//parametros 

$sql2 = $mysqli->prepare("SELECT Valor FROM tbl_parametros where Parametro = 'CREDITOS_PLAN_MAX' ");
$sql2->execute();
$resultado2 = $sql2->get_result();
$row2 = $resultado2->fetch_array(MYSQLI_ASSOC);

$nombre = $_SESSION['usuario'];
ob_end_flush();



?>


<!DOCTYPE html>
<html>

<head>
    <script src="../js/autologout.js"></script>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <!--  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"> -->

    <title></title>


</head>

<body>

    <div class="card card-default">
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">

                <div class="container-fluid">

                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Crear Plan de Estudio</h1>
                        </div>



                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
                                <li class="breadcrumb-item"><a href="../vistas/menu_plan_estudio_vista.php">Menu plan de estudio</a></li>
                                <li class="breadcrumb-item">Crear plan de estudio</a></li>

                            </ol>
                        </div>



                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <section>

                <input type="text" id="id_sesion" name="id_sesion" value="<?php echo $nombre; ?>" hidden readonly>

                <input type="text" id="creditos_max" name="creditos_max" value="<?php echo $row2['Valor'] ?>" readonly hidden>
                <!-- <input type="text" id="creditos_min" name="creditos_min" value="<?php echo $row3['Valor'] ?>" readonly > -->

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <!-- pantalla  -->

                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Nuevo Plan de Estudio </h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>

                                </div>

                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">

                                            <label>Seleccione Tipo de plan:</label>
                                            <td><select class="form-control" style="width: 100%;" name="cbm_tipo_plan" id="cbm_tipo_plan">
                                                </select></td>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">

                                            <label>Número de Acta</label>

                                            <input class="form-control" type="text" id="txt_num_acta" name="txt_num_acta" maxlength="25" value="" required onkeypress="return solonumeros(event)">


                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">

                                            <label>Fecha de Acta</label>

                                            <input class="form-control" type="date" id="fecha_acta" name="fecha_acta" required>


                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">

                                            <label>Fecha de Emisión</label>

                                            <input class="form-control" type="date" id="fecha_emision" name="fecha_emision" required>


                                        </div>
                                    </div>




                                    <div class="col-md-3">
                                        <div class="form-group">

                                            <label>Nombre de Plan</label>

                                            <input class="form-control" type="text" id="txt_nombre" name="txt_nombre" maxlength="150" value="" required onkeyup="DobleEspacio(this, event); MismaLetra('txt_nombre');">


                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">

                                            <label>Código de Plan</label>

                                            <input class="form-control" type="text" id="txt_codigo_plan" name="txt_codigo_plan" maxlength="25" value="" required>


                                        </div>
                                    </div>


                                    <div class="col-md-2">
                                        <div class="form-group">

                                            <label># Clases de plan</label>
                                            <input class="form-control" type="text" id="txt_num_clases" name="txt_num_clases" maxlength="2" value="" onkeypress="return solonumeros(event)">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">

                                            <label># Créditos de plan</label>
                                            <input class="form-control" type="text" id="txt_creditos_plan" name="txt_creditos_plan" maxlength="3" value="" onkeypress="return solonumeros(event)">
                                        </div>
                                    </div>

                                    <!-- <div class="col-md-3">
                                    <label>Plan Vigente</label>
                                    <div style="padding: 3px 5px; border: #c3c3c3  1px solid;  border-radius:5px; width:auto; height:35px;">

                                        <div class="form-group">

                                            <input type="text" name="sino" id="sino" readonly hidden>
                                            <span class="checkbox-inline">
                                                <label class="checkbox-inline"><input id="SI" type="checkbox" name="check[]" class="ch" value="SI"> SI</label>
                                                <label class="checkbox-inline"><input id="NO" type="checkbox" name="check[]" class="ch" value="NO"> NO</label>


                                            </span>
                                        </div>
                                    </div>
                                </div>  -->
                                    <div class="col-md-2">
                                        <div class="form-group">

                                            <label>Fecha de Creación</label>

                                            <input class="form-control" type="date" id="fechacreacion" name="fechacreacion" value="" required>


                                        </div>
                                    </div>



                                </div>
                                <br>
                                <br>
                                <p class="text-center" style="margin-top: 10px;">
                                    <button class="btn btn-primary" id="guardar" name="guarda" <?php echo $_SESSION['btn_crear_plan']; ?>>Guardar</button>
                                </p>
                            </div>

                        </div>

                    </div>


                </section>
            </section>




            <script type="text/javascript" src="../js/plan.js"></script>
            <script type="text/javascript" src="../js/validaciones_plan.js"></script>




</body>




</html>