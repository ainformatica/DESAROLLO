<?php
ob_start();
session_start();


require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');
require_once('../clases/conexion_mantenimientos.php');
//$registro = controlador_registro_docente::ctrRegistro();
$Id_objeto = 275;


$visualizacion = permiso_ver($Id_objeto);

$nombre = $_SESSION['usuario'];
$id_usuario = $_SESSION['id_usuario'];
if ($visualizacion == 0) {
    echo '<script type="text/javascript">
                              swal({
                                   title:"",
                                   text:"Lo sentimos no tiene permiso de visualizar la pantalla",
                                   type: "error",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                           window.location = "../vistas/menu_carga_academica_vista.php";

                            </script>';
} else {

    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INGRESO', 'A IMPORTAR UNA CARGA PRELIMINAR.');


    if (permisos::permiso_insertar($Id_objeto) == '1') {
        $_SESSION['btn_guardar_datos_preliminar'] = "";
    } else {
        $_SESSION['btn_guardar_datos_preliminar'] = "disabled";
    }
}

$sql2 = $mysqli->prepare("SELECT tbl_periodo.id_periodo AS id_periodo, tbl_periodo.num_periodo AS num_periodo, tbl_periodo.num_anno AS num_anno
FROM tbl_periodo
ORDER BY id_periodo DESC LIMIT 1;");
$sql2->execute();
$resultado2 = $sql2->get_result();
$row2 = $resultado2->fetch_array(MYSQLI_ASSOC);
ob_end_flush();


?>


<!DOCTYPE html>
<html>

<head>
    <script src="../js/autologout.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"> -->

    <title></title>


</head>


<body>
    <div class="content-wrapper">


        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">


                        <h1>Importar Carga Preliminar</h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="../vistas/menu_carga_academica_vista.php">Menu Carga Académica</a></li>
                            <li class="breadcrumb-item">Importar Carga Preliminar</li>

                        </ol>
                    </div>

                    <div class="RespuestaAjax"></div>

                </div>
            </div><!-- /.container-fluid -->

        </section>
        <section class="content">
            <div class="container-fluid">
                <!-- pantalla  --><input class="" type="text" id="txt_id_periodo" name="txt_id_periodo" value="<?php echo $row2['id_periodo'] ?>" readonly hidden>

                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">Seleccione el archivo</h3>
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
                            <div class="col-lg-8">
                                <input type="file" class="form-control" id="archivo_excel_preliminar" accept=".xls, .xlsx"><br>

                            </div>
                            <div class="col-lg-2">
                                <button class="btn btn-danger" style="width: 100%;" id="importar_preliminar" onclick="cargar_excel_preliminar1();">Cargar Excel</button><br>


                            </div>
                            <div class="col-lg-2">
                                <button class="btn btn-primary" style="width: 100%;" disabled id="btn_guardar_preliminar" onclick="registrar_excel_preliminar();" <?php echo $_SESSION['btn_guardar_datos_preliminar']; ?>>Guardar Datos</button><br>

                            </div>

                            <div class="col-lg-12" id="div_tabla_preliminar">
                                <tr>

                                </tr>
                            </div>

                        </div>



                    </div>
                </div>
            </div>
        </section>

    </div>
</body>


</html>
<script>
    $('input[type="file"]').on('change', function() {
        var ext = $(this).val().split('.').pop();
        if ($(this).val() != '') {
            if (ext == "xls" || ext == "xlsx" || ext == "csv") {} else {
                $(this).val('');
                alert("Extensión no permitida");
            }
        }
    });
</script>

<script src="../js/importar_carga.js"></script>