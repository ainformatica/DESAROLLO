<?php
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');
require_once('../clases/conexion_mantenimientos.php');
$Id_objeto = 16017;


$visualizacion = permiso_ver($Id_objeto);

$nombre = $_SESSION['usuario'];
$id_usuario = $_SESSION['id_usuario'];
if ($visualizacion == 0) {
    echo '<script type="text/javascript">
    swal({
        title: "",
        text: "Lo sentimos no tiene permiso de visualizar la pantalla",
        type: "error",
        showConfirmButton: false,
        timer: 3000
    });
    window.location = "../vistas/pagina_principal_vista.php";
</script>';
} else {

    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INGRESO', 'A GESTIÓN DE PERSONAS.');


    if (permisos::permiso_insertar($Id_objeto) == '1') {
        $_SESSION['btn_guardar_persona'] = "";
    } else {
        $_SESSION['btn_guardar_persona'] = "disabled";
    }
}


ob_end_flush();

?>

<!DOCTYPE html>
<html>

<head>
    <script src="../js/autologout.js"></script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <title></title>
</head>


<body>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">


                        <h1>Gestion de Personas</h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
                            <li class="breadcrumb-item active"><a href="../vistas/registro_personas_vista.php">Nueva Persona</a></li>
                        </ol>
                    </div>

                    <div class="RespuestaAjax"></div>

                </div>
            </div><!-- /.container-fluid -->
        </section>


        <!--Pantalla 2-->





        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">Personas Existente</h3>
                <div class="card-tools">



                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>

            </div>

            <div class="card-body" style="display: block;">
                <div class="table-responsive" style="width: 100%;">
                    <table id="tabla_persona" class="table table-bordered table-striped" style="width:99%">
                        <thead>
                            <tr>
                                <th>MODIFICAR</th>
                                <th>ELIMINAR</th>
                                <th>NOMBRE</th>
                                <th>APELLIDO</th>
                                <th>SEXO</th>
                                <th>IDENTIDAD</th>
                                <th>NACIONALIDAD</th>
                                <th>ESTADO CIVIL</th>
                                <th>FECHA NACIMIENTO</th>
                                <th>TIPO PERSONAL</th>
                                <th>ESTADO</th>

                            </tr>
                        </thead>


                    </table>
                    <br>


                </div>
            </div>


            <!-- /.card-body -->
            <div class="card-footer">

            </div>
        </div>

        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal_editar">

            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Editar Persona</h5>
                        <button class="close" data-dismiss="modal" onclick="limpiar()">
                            &times; 
                        </button>
                    </div>


                    <div class="modal-body">
                        <input type="text" id="id_sesion" name="id_sesion" value="<?php echo $nombre; ?>" readonly hidden>
                        <input type="text" id="id_sesion_usuario" name="id_sesion_usuario" value="<?php echo $id_usuario; ?>" readonly hidden>
                        <input class="form-control" type="text" id="id_persona" name="id_persona" readonly hidden>

                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">

                                    <label>NOMBRES</label>

                                    <input class="form-control" type="text" id="nombres" name="nombres" maxlength="150" value="" onkeyup="DobleEspacio(this, event); MismaLetra('nombres');" onkeypress="return sololetras(event)" required>

                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">

                                    <label>APELLIDOS</label>
                                    <input class="form-control" type="text" id="apellidos" name="apellidos" maxlength="150" value="" onkeyup="DobleEspacio(this, event); MismaLetra('apellidos');" onkeypress="return sololetras(event)" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">

                                    <label>GENERO</label>
                                    <input class="form-control" type="text" id="genero" name="genero" maxlength="150">


                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">


                                    <label>NACIONALIDAD</label>
                                    <input class="form-control" type="text" id="nacionalidad" name="nacionalidad" maxlength="150" value="" onkeyup="DobleEspacio(this, event); " onkeypress="return sololetras(event)" required readonly>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">

                                    <label>IDENTIDAD</label>
                                    <input class="form-control" type="text" id="identidad" name="identidad" maxlength="150" value="" onkeyup="DobleEspacio(this, event); " onkeypress="return sololetras(event)" required readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">



                                    <label>ESTADO CIVIL:</label>
                                    <input class="form-control" type="text" id="civil" name="civil" maxlength="150" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">

                                    <label>TIPO_PERSONA:</label>
                                    <td><select class="form-control select2" style="width: 100%;" name="cbm_tipo_persona" id="cbm_tipo_persona">
                                        </select></td>


                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">


                                    <label>FECHA_NACIMIENTO</label>
                                    <input class="form-control" type="text" id="fecha" name="fecha" maxlength="150" value="" onkeyup="DobleEspacio(this, event); " onkeypress="return sololetras(event)" required readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">


                                    <label>ESTADO</label>
                                    <input class="form-control" type="text" id="estado1" name="estado" maxlength="20" readonly>

                                </div>

                            </div>



                        </div>

                        <div class="d-flex justify-content-around flex-row bd-highlight row">
                            <div class="card " style="width:300px;border-color:gray;" id="card_telefono">
                                <div class="card-body">
                                    <h4 class="card-title">Contactos</h4>
                                    <div class="form-group card-text">
                                        <!-- TABLA CONTACTOS -->
                                        <button type="button" name="add1" id="add1" class="btn btn-info card-title" data-toggle="modal" data-target="#ModalTel">Agregar Teléfono</button>

                                        <table class="table table-bordered table-striped m-0">
                                            <thead>
                                                <tr>

                                                    <th>Teléfono</th>
                                                    <th id="eliminar_telefono_tabla">Eliminar</th>

                                                </tr>
                                            </thead>
                                            <tbody id="tbData2"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="card " style="width:400px;border-color:gray;">
                                <div class="card-body">
                                    <h4 class="card-title">Correo</h4>
                                    <div class="form-group card-text">
                                        <!-- TABLA CORREO -->
                                        <button type="button" name="add_correo1" id="add_correo1" class="btn btn-info card-title" data-toggle="modal" data-target="#ModalCorreo">Agregar Correo</button>

                                        <table class="table table-bordered table-striped m-0">
                                            <thead>
                                                <tr>

                                                    <th>Correo</th>
                                                    <th id="eliminar_correo_tabla">Eliminar</th>

                                                </tr>
                                            </thead>
                                            <tbody id="tbDataCorreo1"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>




                        <div class="modal-footer">

                            <button class="btn btn-danger" id="cambiar" name="cambiar">CAMBIAR ESTADO</button>
                            <!-- <button class="btn btn-danger" name="cambiar_vigencia1" id="cambiar_vigencia1">Guardar Vigencia</button> -->
                            <button class="btn btn-primary" id="guardar_persona" name="guardar_persona" <?php echo $_SESSION['btn_guardar_persona']; ?> onclick="limpiar();">Guardar</button>
                            <button class="btn btn-secondary" data-dismiss="modal" onclick="limpiar();">Close</button>
                        </div>
                    </div>
                </div>
            </div>






            <script src="../js/gestion_usuario.js"></script>


            <script>
                $(document).ready(function() {
                    TablaPersonas();

                });
            </script>

</body>

</html>