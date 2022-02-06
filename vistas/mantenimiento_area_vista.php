<?php
session_start();
ob_start();

require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');

//Lineas de msj al cargar pagina de acuerdo a actualizar o eliminar datos
if (isset($_REQUEST['msj'])) {
    $msj = $_REQUEST['msj'];

    if ($msj == 1) {
        echo '<script type="text/javascript">
    swal({
        title: "",
        text: "Lo sentimos el área ya existe",
        type: "info",
        showConfirmButton: false,
        timer: 3000
    });
</script>';
    }

    if ($msj == 2) {


        echo '<script type="text/javascript">
    swal({
        title: "",
        text: "Los datos se almacenaron correctamente",
        type: "success",
        showConfirmButton: false,
        timer: 3000
    });
</script>';



        $sqltabla = "select * FROM tbl_areas";
        $resultadotabla = $mysqli->query($sqltabla);
    }
    if ($msj == 3) {


        echo '<script type="text/javascript">
    swal({
        title: "",
        text: "Error al actualizar lo sentimos, intente de nuevo.",
        type: "error",
        showConfirmButton: false,
        timer: 3000
    });
</script>';
    }
}


$Id_objeto = 93;
$visualizacion = permiso_ver($Id_objeto);



if ($visualizacion == 0) {
    // header('location:  ../vistas/menu_roles_vista.php');
    echo '<script type="text/javascript">
                              swal({
                                   title:"",
                                   text:"Lo sentimos no tiene permiso de visualizar la pantalla",
                                   type: "error",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                           window.location = "../vistas/menu_roles_vista.php";

                            </script>';
} else {

    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'Ingreso', 'A mantenimiento area');


    if (permisos::permiso_modificar($Id_objeto) == '1') {
        $_SESSION['btn_modificar_area'] = "";
    } else {
        $_SESSION['btn_modificar_area'] = "disabled";
    }


    /* Manda a llamar todos las datos de la tabla para llenar el gridview  */
    $sqltabla = "SELECT *, (SELECT c.Descripcion FROM tbl_carrera as c WHERE c.id_carrera= tbl_areas.id_carrera LIMIT 1) AS carrera
      FROM tbl_areas";
    $resultadotabla = $mysqli->query($sqltabla);



    /* Esta condicion sirve para  verificar el valor que se esta enviando al momento de dar click en el icono modicar */
    if (isset($_GET['area'])) {
        $sqltabla = "SELECT *, (SELECT c.Descripcion FROM tbl_carrera as c WHERE c.id_carrera= tbl_areas.id_carrera LIMIT 1) AS carrera
        FROM tbl_areas";
        $resultadotabla = $mysqli->query($sqltabla);

        /* Esta variable recibe el estado de modificar */
        $area = $_GET['area'];

        /* Iniciar la variable de sesion y la crea */
        /* Hace un select para mandar a traer todos los datos de la 
 tabla donde rol sea igual al que se ingreso en el input */
        $sql = "SELECT *, (SELECT c.Descripcion FROM tbl_carrera as c WHERE c.id_carrera= tbl_areas.id_carrera LIMIT 1) AS carrera
        FROM tbl_areas WHERE area = '$area'";
        $resultado = $mysqli->query($sql);
        /* Manda a llamar la fila */
        $row = $resultado->fetch_array(MYSQLI_ASSOC);

        /* Aqui obtengo el id_actividad de la tabla de la base el cual me sirve para enviarla a la pagina actualizar.php para usarla en el where del update   */
        $_SESSION['id_area'] = $row['id_area'];
        $_SESSION['area'] = $row['area'];
        $_SESSION['id_carrera'] = $row['id_carrera'];
        $_SESSION['carrera'] = $row['carrera'];
        /*Aqui levanto el modal*/

        if (isset($_SESSION['area'])) {


?>
            <script>
                $(function() {
                    $('#modal_modificar_area').modal('toggle')

                })
            </script>;

            <?php
            ?>

<?php


        }
    }
}

ob_end_flush();


?>
<!DOCTYPE html>
<html>

<head>
    <script src="../js/autologout.js"></script>
    <link rel="stylesheet" type="text/css" href="../plugins/datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel=" stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js">
    <title></title>
</head>


<body>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">


                        <h1>Mantenimiento Área
                        </h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
                            <li class="breadcrumb-item active"><a href="../vistas/menu_mantenimiento_plan.php">Menú Mantenimiento de Plan</a></li>
                            <li class="breadcrumb-item active"><a href="../vistas/mantenimiento_crear_areas.php">Nueva Área</a></li>
                        </ol>
                    </div>

                    <div class="RespuestaAjax"></div>

                </div>
            </div><!-- /.container-fluid -->
        </section>


        <!--Pantalla 2-->

        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">Áreas Existentes</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
                <br>
                <div class=" px-12">
                    <!-- <button class="btn btn-success "> <i class="fas fa-file-pdf"></i> <a style="font-weight: bold;" onclick="ventana()">Exportar a PDF</a> </button> -->
                </div>
            </div>
            <div class="card-body">

                <table id="tabla16" class="table table-bordered table-striped">



                    <thead>
                        <tr>
                            <th># </th>
                            <th>Área</th>
                            <th>Carrera</th>
                            <th>Modificar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $resultadotabla->fetch_array(MYSQLI_ASSOC)) { ?>
                            <tr>
                                <td><?php echo $row['id_area']; ?></td>
                                <td><?php echo $row['area']; ?></td>
                                <td><?php echo $row['carrera']; ?></td>


                                <td style="text-align: center;">

                                    <a href="../vistas/mantenimiento_area_vista.php?area=<?php echo $row['area']; ?>" class="btn btn-primary btn-raised btn-xs">
                                        <i class="far fa-edit" style="display:<?php echo $_SESSION['modificar_area'] ?> "></i>
                                    </a>
                                </td>

                                <td style="text-align: center;">

                                    <form action="../Controlador/eliminar_area_controlador.php?id_area=<?php echo $row['id_area']; ?>" method="POST" class="FormularioAjax" data-form="delete" autocomplete="off">
                                        <button type="submit" class="btn btn-danger btn-raised btn-xs">

                                            <i class="far fa-trash-alt" style="display:<?php echo $_SESSION['eliminar_area'] ?> "></i>
                                        </button>
                                        <div class="RespuestaAjax"></div>
                                    </form>
                                </td>

                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>


        <!-- /.card-body -->
        <div class="card-footer">

        </div>
    </div>





    <!-- *********************Creacion del modal 

-->

    <form action="../Controlador/actualizar_area_controlador.php?id_area=<?php echo $_SESSION['id_area']; ?>" method="post" data-form="update" autocomplete="off">



        <div class="modal fade" id="modal_modificar_area">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"> Actualizar área</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>


                    <!--Cuerpo del modal-->
                    <div class="modal-body">


                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Área</label>
                                        <input class="form-control" type="text" id="area" name="area" value="<?php echo $_SESSION['area']; ?>" onkeyup="DobleEspacio(this, event); MismaLetra('area');">
                                    </div>
                                    <div class="form-group ">
                                        <label>Descripción</label>
                                        <input class="form-control" type="text" id="descripcion_area" name="descripcion_area" onkeyup="DobleEspacio(this, event); MismaLetra('descripcion_area');">
                                    </div>

                                    <div class="form-group">
                                        <label>Ingrese la Carrera</label>
                                        <select class="form-control select2" type="text" id="cbm_carrera" name="cmb_carrera" style="width: 100%;">
                                            <option value="">Seleccione una opción</option>
                                        </select>
                                    </div>
                                    <input class="form-control" id="carrera1" name="carrera1" value="0" readonly hidden>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!--Footer del modal-->
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="" class="btn btn-primary" id="btn_modificar_area" name="btn_modificar_area" <?php echo $_SESSION['btn_modificar_area']; ?>>Guardar cambios</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <!-- /.  finaldel modal -->

        <!--mosdal crear -->



    </form>





    <!-- <script type="text/javascript">
        $(function() {

            $('#tabla16').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "responsive": true,
            });
        });
    </script>
 -->

</body>

</html>
<script type="text/javascript" language="javascript">
    function ventana() {
        window.open("../Controlador/reporte_mantenimiento_periodo_controlador.php", "REPORTE");
    }
</script>

<script>
    function llenar_carrera() {
        var cadena = "&activar=activar";
        $.ajax({
            url: "../Controlador/plan_estudio_controlador.php?op=carreras",
            type: "POST",
            data: cadena,
            success: function(r) {
                $("#cbm_carrera").html(r).fadeIn();
                var o = new Option("SELECCIONAR", 0);


                $("#cbm_carrera").append(o);
                $("#cbm_carrera").val(0);

            },
        });
    }
    llenar_carrera();
    $('#cbm_carrera').change(function() {
        var carrera = $(this).val();
        console.log(carrera);
        $('#carrera1').val(carrera);
        if (carrera == 0) {
            alert("Seleccione una opción válida");
            document.getElementById("cbm_carrera").value = "";
        }
    });
</script>

<!-- <script type="text/javascript" language="javascript">
    $(document).ready(function() {

        $('.select2').select2({
            placeholder: 'Seleccione una opcion',
            theme: 'bootstrap4',
            tags: true,
        });

    });
</script> -->

<script type="text/javascript" language="javascript">
    function MismaLetra(id_input) {
        var valor = $('#' + id_input).val();
        var longitud = valor.length;
        //console.log(valor+longitud);
        if (longitud > 2) {
            var str1 = valor.substring(longitud - 3, longitud - 2);
            var str2 = valor.substring(longitud - 2, longitud - 1);
            var str3 = valor.substring(longitud - 1, longitud);
            nuevo_valor = valor.substring(0, longitud - 1);
            if (str1 == str2 && str1 == str3 && str2 == str3) {
                swal('Error', 'No se permiten 3 letras consecutivamente', 'error');

                $('#' + id_input).val(nuevo_valor);
            }
        }
    }

    function sololetras(e) {

        key = e.keyCode || e.wich;

        teclado = String.fromCharCode(key).toUpperCase();

        letras = " ABCDEFGHIJKLMNOPQRSTUVWXYZÑ";

        especiales = "8-37-38-46-164";

        teclado_especial = false;

        for (var i in especiales) {

            if (key == especiales[i]) {
                teclado_especial = true;
                break;
            }
        }

        if (letras.indexOf(teclado) == -1 && !teclado_especial) {
            return false;
        }

    }
</script>

<script type="text/javascript" src="../js/ca2.js"></script>

<script type="text/javascript" src="../js/pdf_mantenimientos_plan.js"></script>
<script src="../plugins/select2/js/select2.min.js"></script>
<!-- datatables JS -->
<script type="text/javascript" src="../plugins/datatables/datatables.min.js"></script>
<!-- para usar botones en datatables JS -->
<script src="../plugins/datatables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>
<script src="../plugins/datatables/JSZip-2.5.0/jszip.min.js"></script>
<script src="../plugins/datatables/pdfmake-0.1.36/pdfmake.min.js"></script>
<script src="../plugins/datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
<script src="../plugins/datatables/Buttons-1.5.6/js/buttons.html5.min.js"></script>