<?php
ob_start();
session_start();
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');
require_once('../clases/conexion_mantenimientos.php');




$Id_objeto = 47;

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
                           window.location = "../vistas/menu_carga_academica_vista.php";

                            </script>';
} else {

    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INGRESO', ' A GESTIONAR CARGA ACADEMICA');

    if (permisos::permiso_modificar($Id_objeto) == '1') {
        $_SESSION['btn_crear_nueva_guardar_carga'] = "";
    } else {
        $_SESSION['btn_crear_nueva_guardar_carga'] = "disabled";
    }
}

$sql2 = $mysqli->prepare("SELECT tbl_periodo.id_periodo AS id_periodo, tbl_periodo.num_periodo AS num_periodo, tbl_periodo.num_anno AS num_anno, tbl_periodo.fecha_adic_canc AS fecha_adic_canc, tbl_periodo.fecha_desbloqueo AS fecha_desbloqueo,
(SELECT tp.descripcion FROM tbl_tipo_periodo AS tp INNER JOIN tbl_periodo AS pdo ON tp.id_tipo_periodo=pdo.id_tipo_periodo
			WHERE tp.id_tipo_periodo= tbl_periodo.id_tipo_periodo LIMIT 1) AS tipo_periodo,
			(SELECT tp.horas_validas FROM tbl_tipo_periodo AS tp INNER JOIN tbl_periodo AS pdo ON tp.id_tipo_periodo=pdo.id_tipo_periodo
			WHERE tp.id_tipo_periodo= tbl_periodo.id_tipo_periodo LIMIT 1) AS horas_validas
FROM tbl_periodo
ORDER BY id_periodo DESC LIMIT 1;");
$sql2->execute();
$resultado2 = $sql2->get_result();
$row2 = $resultado2->fetch_array(MYSQLI_ASSOC);
//var_dump($row2);

ob_end_flush();

?>


<!DOCTYPE html>
<html>

<head>
    <script src="../js/autologout.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
   <!--  <link rel="stylesheet" type="text/css" href="../plugins/datatables/datatables.min.css" /> -->
    <!--datables estilo bootstrap 4 CSS-->
    <!-- <link rel="stylesheet" type="text/css" href="../plugins/datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">

    <link rel=" stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"> -->

    <!-- <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->

    <!-- css -->
   <!--  <link rel="stylesheet" href="//cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css"> -->



</head>

<body>
    <div class="content-wrapper">


        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">


                        <h1>Gestión Carga Académica</h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="../vistas/menu_carga_academica_vista.php">Menu Carga Académica</a></li>
                            <li class="breadcrumb-item">Gestion de Carga Académica</li>
                        </ol>
                    </div>

                    <div class="RespuestaAjax"></div>

                </div>
            </div><!-- /.container-fluid -->
        </section>


        <!--Pantalla 2-->





        <div class="card card-default">
            <div class="card-header">
                <h2>Datos del Periodo</h2>
            </div>
            <div class="card-header">
                <!--COMBOBOX-->

                <div class="row">
                    <div class="col-md-3" style="width:75px">
                        <div class="input-group mb-3 input-group">

                            <span class=" input-group-text" style="font-weight: bold;">Periodo Actual</span>
                            <input class="form-control" type="text" id="txt_periodo" name="txt_periodo" value="<?php echo $row2['num_periodo'] ?>" readonly>


                        </div>
                    </div>
                    <input class="" type="text" id="txt_id_periodo" name="txt_periodo" value="<?php echo $row2['id_periodo'] ?>" readonly hidden>

                    <!-- <div class="col-md-3" style="width:75px"> -->
                    <!-- <div class="input-group mb-3 input-group"> -->

                    <!-- <span class=" input-group-text" style="font-weight: bold;">id</span> -->


                    <!-- </div> -->
                    <!-- </div> -->

                    <div class="col-md-3" style="width:75px">
                        <div class="input-group mb-3 input-group">

                            <span class=" input-group-text" style="font-weight: bold;">Año Académico</span>
                            <input class="form-control" type="text" id="txt_anno" name="txt_anno" value="<?php echo $row2['num_anno'] ?>" readonly>

                        </div>
                    </div>

                    <div class="col-md-3" style="width:75px">
                        <div class="input-group mb-3 input-group">

                            <span class="input-group-text" style="font-weight: bold;">Tipo Periodo</span>
                            <input class="form-control" type="text" id="txt_tipo_periodo" name="txt_tipo_periodo" value="<?php echo $row2['tipo_periodo'] ?>" readonly>

                        </div>
                    </div>
                    <div class="col-md-2" hidden>
                        <div class="form-group">
                            <label>horas_validas:</label>
                            <input class="form-control" type="text" id="txt_hras_validas" name="txt_hras_validas" value="<?php echo $row2['horas_validas'] ?>" readonly>

                        </div>
                    </div>

                    <div class="col-md-2" hidden>
                        <div class="form-group">
                            <label>fecha_adic_canc:</label>
                            <input class="form-control" type="text" id="fecha_adic_canc" name="fecha_adic_canc" value="<?php echo $row2['fecha_adic_canc'] ?>">

                        </div>
                    </div>

                    <div class="col-md-2" hidden>
                        <div class="form-group">
                            <label>desbloqueo:</label>
                            <input class="form-control" type="text" id="fecha_desbloqueo" name="fecha_desbloqueo" value="<?php echo $row2['fecha_desbloqueo'] ?>">

                        </div>
                    </div>

                </div>


                <!-- <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>

                </div> -->
            </div>
            <div class="card-header">


                <div class="btn-group">
                    <div class=" px-12">
                        <button class="btn btn-danger " data-toggle="modal" onclick="abrirmodalcarga();" id="nueva_carga"><i class="fas fa-plus"></i> <a style="font-weight: bold;" <?php echo $_SESSION['btn_crear_nueva_guardar_carga']; ?>>Nueva Carga</a></button>
                    </div>
                    <br><br>
                    <div class=" px-6">
                        <button class="btn btn-warning btn-lg" hidden> <a></a></button>
                    </div>
                    <div class=" px-4">
                        <button class="btn btn-warning btn-lg" hidden> <a></a></button>
                    </div>

                    <div class=" px-12">
                        <button class="btn btn-info " id="btn1" name="btn1" data-toggle="modal" onclick="abrirmodalinformaciondocente();"><i class="fas fa-chalkboard-teacher"></i> <a style="font-weight: bold;">Información Docente</a></button>
                    </div>
                    <div class=" px-6">
                        <button class="btn btn-warning btn-lg" hidden> <a></a></button>
                    </div>
                    <div class=" px-4">
                        <button class="btn btn-warning btn-lg" hidden> <a></a></button>
                    </div>

                    <div class=" px-12">
                        <button class="btn btn-info " id="" name=""><i class="fas fa-arrow-circle-right"></i> <a href="historial_carga_academica_vista.php" style="color:white;font-weight: bold;">Ir a historial de carga</a></button>
                    </div>
                    <div class=" px-6">
                        <button class="btn btn-warning btn-lg" hidden> <a></a></button>
                    </div>
                    <div class=" px-4">
                        <button class="btn btn-warning btn-lg" hidden> <a></a></button>
                    </div>

                    <div class=" px-12">
                        <button class="btn btn-warning" id="" name="" style="color:white;font-weight: bold;" onclick="borraTodosDatos();"><i class="fas fa-trash-alt"></i> Eliminar todos los datos</button>
                    </div>


                    <!-- 
                    <div class=" px-12">
                        <form method="post" action="../Controlador/reporte_carga_excel_controlador.php">
                            <button type="submit" name="export" class="btn btn-success " value="EXCEL"> <i class="fas fa-file-excel"></i> <a style="font-weight: bold;">Excel Preliminar</a></button>
                        </form>
                    </div>
                    <div class=" px-12">
                        <form method="post" action="../Controlador/reporte_carga_excel_final_controlador.php">
                            <button type="submit" name="export" class="btn btn-success " value="EXCEL"> <i class="fas fa-file-excel"></i> <a style="font-weight: bold;">Excel Final</a></button>
                        </form>
                    </div> -->


                </div>
            </div>

            <!-- /.card-header -->
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            <!-- <div class="row">
                        <div class="col-lg-10">
                            <div class="input-group">
                                <input type="text" class="global_filter form-control" id="global_filter" placeholder="Ingresar dato a buscar" style="width: 90%;">
                                <span class="input-group-text">Buscar</span>
                            </div>
                        </div>

                    </div> -->

            <div class="card-body">


                <div class="table-responsive" style="width: 100%;">
                    <!-- <div class="input-group">
                            <div class="col-md-3">
                                <div class="input-group mb-3 input-group" hidden>

                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group mb-3 input-group" hidden>

                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="input-group mb-3 input-group" hidden>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    </div>
                                    <input type="text" class="global_filter form-control" id="global_filter" placeholder="Ingresar dato a buscar" maxlength="30" onkeypress="return letrasynumeros(event)">
                                </div>

                            </div>
                        </div> -->
                    <table id="tabla_carga" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Acción</th>
                                <!-- <th>#</th> -->
                                <th>N# Empleado</th>
                                <th>Nombre</th>
                                <th>Código</th>
                                <th>Asignatura</th>
                                <th>UV</th>
                                <th>Sección</th>
                                <th>Hi</th>
                                <th>Hf</th>
                                <th>Dia</th>
                                <th>Aula</th>
                                <th>Edificio</th>
                                <th>N. Alumnos</th>
                                <th>Control</th>
                                <th>Modalidad</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Acción</th>
                                <!-- <th>#</th> -->
                                <th>N# Empleado</th>
                                <th>Nombre</th>
                                <th>Código</th>
                                <th>Asignatura</th>
                                <th>UV</th>
                                <th>Sección</th>
                                <th>Hi</th>
                                <th>Hf</th>
                                <th>Día</th>
                                <th>Aula</th>
                                <th>Edificio</th>
                                <th>N. Alumnos</th>
                                <th>Control</th>
                                <th>Modalidad</th>
                            </tr>
                        </tfoot>

                    </table>
                    <br>


                    <!-- modal crear carga -->

                    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="ModalTask" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Nueva Carga Académica</h5>
                                    <button class="close" data-dismiss="modal">
                                        &times;
                                    </button>

                                </div>

                                <div class="modal-body">

                                    <div class="row">
                                        <input class="form-control" type="text" id="txt_registro_crear" name="txt_registro_crear" value="" readonly hidden>
                                        <input class="form-control" type="text" id="txt_contar_carga" name="txt_contar_carga" readonly hidden>

                                        <input type="text" id="txt_hra_entrada" readonly hidden>
                                        <div class="col-md-6">
                                            <div class="form-group">

                                                <label>Docente:</label>
                                                <select class="form-control select2" onchange="mostrardocente($('#id_select').val());" id="id_select" name=""></select>
                                            </div>

                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">

                                                <label>N# Docente:</label>
                                                <input class="form-control" type="text" id="txt_num_doc" name="txt_num_doc" value="" readonly>


                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">

                                                <label>Hi:</label>
                                                <input class="form-control" type="text" id="txt_hra_entrada2" name="txt_hra_entrada2" value="" readonly>


                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Hf:</label>
                                                <input class="form-control" type="text" id="txt_hra_salida" name="txt_hra_salida" value="" readonly>

                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Tipo asignatura:</label>

                                                <!-- <input class="form-control" type="text" id="cbm_reposicion1" name="cbm_reposicion1" readonly hidden> -->
                                                <td> <select class="form-control select2" style="width: 100%;" name="cbm_tipo_asignatura" id="cbm_tipo_asignatura">
                                                        <option value="0">SELECCIONAR</option>
                                                    </select>
                                                </td>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Asignatura:</label>
                                                <select class="form-control select2" id="select2" name="select2" onchange="mostrar2($('#select2').val());"></select>

                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">

                                                <label>Código:</label>
                                                <input class="form-control" type="text" id="txt_cod_asignatura" name="txt_cod_asignatura" readonly>


                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">

                                                <label>UV:</label>
                                                <input class="form-control" type="text" id="txt_unid_valora" name="txt_unid_valora" readonly>


                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Modalidad:</label>
                                                <select class="form-control-lg select2" onchange="mostrar_modalidad($('#modalidad').val());" id="modalidad" name="modalidad"> </select>

                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Edificio:</label>
                                                <select class="form-control select2" name="edificio" id="edificio"></select>



                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Aulas:</label>
                                                <select class="form-control select2" name="aula" id="aula"></select>



                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Capacidad:</label>
                                                <input class="form-control" type="text" id="capacidad" name="capacidad" readonly>

                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Cupos:</label>

                                                <input maxlength="2" class="form-control" type="text" onblur="valida_matriculados()" id="txt_matriculados" name="txt_matriculados" value="" onkeypress="return Numeros(event)" onkeyup="Espacio(this, event)">

                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Sección:</label>
                                                <input maxlength="4" class="form-control" type="text" id="txt_seccion" name="txt_seccion" value="" onkeypress="return Numeros(event)" onkeyup="Espacio(this, event)">

                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Hi:</label>

                                                <select class="form-control" onblur="valida_entrada_crear();" onchange="mostrar_hora($('#hora_inicial').val());" id="hora_inicial" name="hora_inicial"></select>

                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Hf:</label>
                                                <select class="form-control" onchange="mostrar_hora($('#hora_final').val());" id="hora_final" name="hora_final" onblur="valida_horario_crear()"></select>

                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Control:</label>
                                                <input maxlength="6" class="form-control" onkeypress="return Numeros(event)" type="text" id="txt_control" name="txt_control" value="" onkeyup="Espacio(this, event)" required>

                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Seleccione dias:</label>
                                                <div style="padding: 3px 5px; border: #c3c3c3  1px solid;  border-radius:5px; width:260px; height:39px;">

                                                    <input class="form-control" id="dias" name="dias" type="text" value="" hidden readonly>
                                                    <span class="checkbox-inline">
                                                        <label class="checkbox-inline"><input class="CheckedAK" name="checks[]" id="Lu" type="checkbox" value="Lu">Lu</label>
                                                        <label class="checkbox-inline"><input class="CheckedAK" name="checks[]" id="Ma" type="checkbox" value="Ma">Ma</label>
                                                        <label class="checkbox-inline"><input class="CheckedAK" name="checks[]" id="Mi" type="checkbox" value="Mi">Mi</label>
                                                        <label class="checkbox-inline"><input class="CheckedAK" name="checks[]" id="Ju" type="checkbox" value="Ju">Ju</label>
                                                        <label class="checkbox-inline"><input class="CheckedAK" name="checks[]" id="Vi" type="checkbox" value="Vi">Vi</label>
                                                        <label class="checkbox-inline"><input class="CheckedAK" name="checks[]" id="Sa" type="checkbox" value="Sa">Sa</label>
                                                        <label class="checkbox-inline"><input class="CheckedAK" name="checks[]" id="Do" type="checkbox" value="Do">Do</label>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>



                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-primary" onclick="crear_carga_academica();" id="guardar" name="guardar">Guardar</button>
                                    <!-- <button class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                                    <button class="btn btn-secondary" onclick="cerrar_modal();" id="cerrar_modal">Cerrar</button>

                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- modal informacion docente -->
                    <div id="modal2" class="modal fade bd-example-modal-lg" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" tabindex="-1">
                        <!--      Para centrado-->
                        <div class="modal-dialog modal-lg">

                            <!--  <div class="modal-dialog" role="document">-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Información Docente</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="card-body">
                                        <div class="row">

                                            <!-- CAPTURAMOS EL ID EN UN INPUT -->

                                            <input id="id" class="form control" type="text" name="id" value="" readonly hidden>

                                            <!-- -------------------------- -->

                                            <div class="col-sm-8">
                                                <div class="form-group">
                                                    <label>Docente:</label>
                                                    <td><select class="form-control-lg select2" onchange="mostrar_docente($('#id_select2').val());" id="id_select2" name="">
                                                            <option value="">Seleccionar Docente</option>
                                                        </select></td>

                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <input class="form-control" hidden type="text" id="" name="" value="" readonly>

                                                    </div>
                                                </div>
                                            </div>

                                            <!-- <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="control-label">Nombre Completo</label>
                                        <input class="form-control" type="text" id="input8" name="input8" value="" style="text-transform: uppercase" readonly>

                                    </div>
                                </div> -->

                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label class="control-label">Horario de Entrada</label>
                                                    <input class="form-control" type="text" id="input6" name="input6" value="" style="text-transform: uppercase" readonly>

                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label class="control-label">Horario de Salida</label>
                                                    <input class="form-control" type="text" id="input5" name="input5" value="" style="text-transform: uppercase" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label class="control-label">Categoria</label>
                                                    <input class="form-control" type="text" id="input2" name="input2" value="" style="text-transform: uppercase" readonly>

                                                </div>
                                            </div>

                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label class="control-label">Jornada</label>
                                                    <input class="form-control" type="text" id="input7" name="input7" value="" style="text-transform: uppercase" readonly>

                                                </div>
                                            </div>

                                            <div class="card-body">
                                                <table id="dynamic_field" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <!-- <th>#</th> -->
                                                            <th>Información Profesional</th>
                                                            <th>Preferencia Área</th>
                                                            <th>Experiencia Académica</th>
                                                            <th>Preferencia Asignatura</th>
                                                            <th>Desea impartir</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="id_profe">

                                                    </tbody>

                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- modal eliminar 2 -->

                    <div class="modal fade" id="modal_borrar">
                        <div class="modal-dialog modal-sm ">
                            <div class="modal-content">

                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Estas seguro de eliminar la carga?</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <!-- Modal body -->
                                <div class="modal-body">
                                    <input class="" type="text" id="txt_carga_id_eliminar" name="" value="" readonly hidden>
                                    <div class="input-group mb-3 input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" style="font-weight: bold;">Docente</span>
                                        </div>
                                        <input class="form-control" type="text" id="txt_docente_eliminar" name="txt_docente_eliminar" readonly>
                                    </div>


                                    <div class="input-group mb-3 input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" style="font-weight: bold;">Asignatura</span>
                                        </div>
                                        <input class="form-control" type="text" id="txt_asignatura_eliminar" name="txt_asignatura_eliminar" readonly>
                                    </div>


                                    <div class="input-group mb-3 input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" style="font-weight: bold;">Sección</span>
                                        </div>
                                        <input class="form-control" type="text" id="txt_seccion_eliminar" name="txt_seccion_eliminar" readonly>
                                    </div>

                                </div>

                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="limpiar_registro_eliminar();">Cancelar</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="aceptar_eliminar" onclick="eliminarRegistro();">Aceptar</button>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- modal modificar carga -->

                    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modal_editar" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Editar Carga Académica</h5>
                                    <button class="close" data-dismiss="modal">
                                        &times;
                                    </button>

                                </div>

                                <div class="modal-body">

                                    <div class="row">

                                        <input type="text" id="txt_carga_id" readonly hidden>
                                        <input type="text" id="txt_id_docente" readonly hidden>
                                        <input type="text" id="txt_registro" readonly hidden>
                                        <input type="text" id="txt_descripcion_aula" hidden readonly>
                                        <input type="text" id="txthrentradatabla" readonly hidden>
                                        <input type="text" id="txthrsalidatabla" readonly hidden>
                                        <input type="text" id="txtaulatabla" readonly hidden>
                                        <input id="txt_dias_edita" name="txt_dias_edita" type="text" readonly onblur="limpiardias_edita();" hidden>

                                        <div class="col-md-6">
                                            <div class="form-group">

                                                <label>Docente:</label>
                                                <input class="form-control" type="text" id="txt_nombre_doc_edita" name="txt_nombre_doc_edita" value="" readonly>

                                            </div>

                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>N# Docente:</label>
                                                <input class="form-control" type="text" id="txt_num_doc_edita" name="txt_num_doc_edita" value="" readonly>


                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">

                                                <label>Hi:</label>
                                                <input class="form-control" type="text" id="txtentrada" readonly>


                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Hf:</label>
                                                <input class="form-control" type="text" id="txtsalida" readonly>

                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Tipo asignatura:</label>
                                                <!-- 
                                                <input class="form-control" type="text" id="cbm_reposicion1" name="cbm_reposicion1" readonly hidden> -->
                                                <td> <select class="form-control" style="width: 100%;" name="cbm_tipo_asignatura_edita" id="cbm_tipo_asignatura_edita">
                                                    </select>
                                                </td>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Asignatura:</label>
                                                <select class="form-control select2" style="width: 100%;" id="cbm_asignatura_edita" name="cbm_asignatura_edita">

                                            </div>
                                        </div>
                                        <div class="col-md-2" hidden>
                                            <div class="form-group">
                                                <input type="text" readonly hidden>


                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">

                                                <label>Código:</label>
                                                <input class="form-control" type="text" id="txt_cod_asignatura_edita" name="txt_cod_asignatura_edita" readonly>


                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">

                                                <label>UV:</label>
                                                <input class="form-control" type="text" id="txt_unidades_edita" name="txt_unidades_edita" readonly>



                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Modalidad:</label>

                                                <select class="form-control-lg select2" style="width: 100%;" onchange="mostrar2($('#cbm_modalidad_edita').val());" id="cbm_modalidad_edita" name="cbm_modalidad_edita">

                                            </div>
                                        </div>
                                        <div class="col-md-2" hidden>
                                            <div class="form-group">
                                                <input type="text" readonly hidden>


                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Edificio:</label>
                                                <select class="form-control" style="width: 100%;" name="cbm_edificio_edita" id="cbm_edificio_edita">



                                            </div>
                                        </div>
                                        <div class="col-md-2" hidden>
                                            <div class="form-group">
                                                <input type="text" readonly hidden>


                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Aulas:</label>
                                                <select class="form-control" style="width: 100%;" name="cbm_aula_edita" id="cbm_aula_edita">



                                            </div>
                                        </div>
                                        <div class="col-md-2" hidden>
                                            <div class="form-group">
                                                <input type="text" readonly hidden>


                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Capacidad:</label>
                                                <input class="form-control" type="text" id="txt_capacidad_edita" name="capacidad_edita" readonly>

                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Cupos:</label>

                                                <input maxlength="2" class="form-control" type="text" onblur="valida_matriculados_edita()" id="txt_matriculados_edita" name="txt_matriculados_edita" value="" onkeypress="return Numeros(event)" onkeyup="Espacio(this, event)">

                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Sección:</label>
                                                <input maxlength="4" class="form-control" type="text" id="txt_seccion_edita" name="txt_seccion" value="" onkeypress="return Numeros(event)" onkeyup="Espacio(this, event)">

                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Hi:</label>
                                                <select class="form-control" style="width: 100%;" name="cbm_hi_edita" id="cbm_hi_edita" onblur="validaentrada_edita()"></select>

                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Hf:</label>
                                                <select class="form-control" style="width: 100%;" name="cbm_hf_edita" id="cbm_hf_edita" onblur="validahoraperiodo_edita();">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Control:</label>
                                                <input maxlength="6" class="form-control" onkeypress="return Numeros(event)" type="text" id="txt_control_edita" name="txt_control" value="" onkeyup="Espacio(this, event)" required>


                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Seleccione dias:</label>
                                                <div style="padding: 3px 5px; border: #c3c3c3  1px solid;  border-radius:5px; width:260px; height:39px;">

                                                    <input class="form-control" id="dias" name="dias" type="text" value="" hidden readonly>
                                                    <span class="checkbox-inline">
                                                        <label class="checkbox-inline"><input id="Lu1" type="checkbox" name="check[]" class="ch" value="Lu">Lu</label>
                                                        <label class="checkbox-inline"><input id="Ma1" type="checkbox" name="check[]" class="ch" value="Ma">Ma</label>
                                                        <label class="checkbox-inline"><input id="Mi1" type="checkbox" name="check[]" class="ch" value="Mi">Mi</label>
                                                        <label class="checkbox-inline"><input id="Ju1" type="checkbox" name="check[]" class="ch" value="Ju">Ju</label>
                                                        <label class="checkbox-inline"><input id="Vi1" type="checkbox" name="check[]" class="ch" value="Vi">Vi</label>
                                                        <label class="checkbox-inline"><input id="Sa1" type="checkbox" name="check[]" class="ch" value="Sa">Sa</label>
                                                        <label class="checkbox-inline"><input id="Do1" type="checkbox" name="check[]" class="ch" value="Do">Do</label>

                                                    </span>
                                                </div>
                                            </div>
                                        </div>



                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-primary" id="guardar" name="guardar" onclick="modificar_carga_academica();">Guardar</button>

                                    <button class="btn btn-secondary" data-dismiss="modal" onclick="cerrar();" id="salir">Cancelar</button>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>
            </div>
            <div class="card-footer">
                <h1></h1>
            </div>
        </div>






    </div>







    <script src="../js/ca2.js"></script>
    <script src="../js/ca3.js"></script>
    <script src="../js/validaciones_plan.js"></script>

</body>

</html>

<script type="text/javascript" language="javascript">
    function ventana() {
        window.open("../Controlador/reporte_carga_gestion_controlador.php", "REPORTE");
    }


    function limpiardias_edita() {
        document.getElementById("#txt_dias_edita").value = "";
    }
</script>





<!-- para datatable -->
<script>
    $(document).ready(function() {
        TablaCarga();

    });
</script>

<script>
    var idioma_espanol = {
        select: {
            rows: "%d fila seleccionada"
        },
        "sProcessing": "Procesando...",
        "sLengthMenu": "Mostrar _MENU_ registros",
        "sZeroRecords": "No se encontraron resultados",
        "sEmptyTable": "Ning&uacute;n dato disponible en esta tabla",
        "sInfo": "Registros del (_START_ al _END_) total de _TOTAL_ registros",
        "sInfoEmpty": "Registros del (0 al 0) total de 0 registros",
        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix": "",
        "sSearch": "Buscar:",
        "sUrl": "",
        "sInfoThousands": ",",
        "sLoadingRecords": "<b>No se encontraron datos</b>",
        "oPaginate": {
            "sFirst": "Primero",
            "sLast": "Último",
            "sNext": "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }

    }
</script>
<script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script>
<script src="../plugins/select2/js/select2.min.js"></script>
<!-- datatables JS -->
<script type="text/javascript" src="../plugins/datatables/datatables.min.js"></script>
<!-- para usar botones en datatables JS -->
<script src="../plugins/datatables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>
<script src="../plugins/datatables/JSZip-2.5.0/jszip.min.js"></script>
<script src="../plugins/datatables/pdfmake-0.1.36/pdfmake.min.js"></script>
<script src="../plugins/datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
<script src="../plugins/datatables/Buttons-1.5.6/js/buttons.html5.min.js"></script>