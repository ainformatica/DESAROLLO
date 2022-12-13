<?php
//
ob_start();

session_start();


require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');
require_once('../clases/conexion_mantenimientos.php');


$Id_objeto = 292;
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
                           window.location = "../vistas/menu_registro_estudiantes_vista.php";
                            </script>';
} else {
    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INGRESO', 'A GESTION REGISTRO DE ESTUDIANTES');
}

?>


<!DOCTYPE html>

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
                        <h1>Gestión de Estudiantes</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="../vistas/menu_registro_estudiantes_vista.php">Menú Mantenimiento de Estudiantes</a></li>

                        </ol>

                    </div>
                    <div class="RespuestaAjax"></div>
                </div>

            </div><!-- /.container-fluid -->
        </section>


        <!--Pantalla 2-->

        <div class="card card-default">
            <div class="card-header">
                <!--COMBOBOX-->

                <div class="px-1">
                    <a href="../vistas/registro_estudiantes_vista.php" class="btn btn-warning"><i class="fas fa-arrow"></i>
                    Registro de Nuevo Estudiante</a>
                </div>
                <!--IMPORTACIÓN DE DATOS-->
                <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <input type="file" id="txt_archivo_excel" class="form-control">
                    </div>
                    <div class="col-2">
                        <button class="btn btn-success" style="width: 100%" onclick="cargar_excel()">Importar de Excel</button>
                    </div>
                </div>
                </div>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>

            <!-- /.card-header -->
            <div class="card-footer">
                <input hidden class="form-control" type="text" id="txt_uno" name="txt_uno" value="<?php echo $row2['num_uno'] ?>" readonly>
                <input hidden class="form-control" type="text" id="txt_dos" name="txt_dos" value="<?php echo $row2['num_dos'] ?>" readonly>

                <div class="card-body">

                    <div class="table-responsive" style="width: 100%;">
                        <div class="input-group">
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
                        </div>

                        <table id="tablaestudiantes" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Id Persona</th>
                                    <th>Nombre</th>                                    
                                    <th>Identidad</th>
                                    <th>Cuenta Nº</th>
                                    <th>Teléfonos</th>
                                    <th>Correos</th>
                                    <th>Trabaja</th>                                     
                                    <th>Egresado</th> 
                                    <th>Carrera</th>
                                    <th>Centro Regional</th>
                                    <th>Estado</th> 
                                    <th>Modificar Estado</th>
                                    <th>Modificar Información</th>
                                </tr>
                            </thead>
                        </table>
                        <br>

                    </div>
                </div>
                <!-- modal modificar carga -->
                <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modal_editar" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Editar Datos</h5>
                                <button onclick="limpiar();actualizar_tabla();" class="close" data-dismiss="modal">
                                    &times;
                                </button>
                            </div>


                            <div class="modal-body">
                                <div class="row">
                                    <input type="hidden">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input hidden type="text" id="txt_id_persona" readonly>
                                            <label> Estudiante: </label>
                                            <input class="form-control" type="text" id="txt_nombre_estudiante" name="txt_nombre_estudiante" 
                                            readonly>
                                        </div>
                                    </div>

                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Identificación</label>
                                            <input class="form-control" name="identidad_edita" data-inputmask="'mask': '9999-9999-99999'" 
                                            data-mask id="identidad_edita" onkeyup="ValidarIdentidad($('#identidad_edita').val());" 
                                            readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Cuenta Nº</label>
                                            <input class="form-control" name="ncuenta_edita" id="ncuenta_edita" onkeypress="return solonumeros(event)" onkeyUp="pierdeFoco(this)" maxlength="11" required>

                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                        <label>Carrera</label>
                                         <select class="form-control" name="cb_carrera_edita" id="cb_carrera_edita">
                                         </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                        <label>Centro Regional</label>
                                         <select class="form-control" name="cb_credita" id="cb_credita">
                                         </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Egresado</label>
                                            <select class="form-control" name="egresado_edita" id="egresado_edita">
                                                <option value="SI">SI</option>
                                                <option value="NO">NO</option>
                                            </select>
                                        </div>
                                    </div>


                            </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-info" onclick="modificar_gestion_estudiante();" id="editar_info" name="editar_info">Guardar Cambios</button>
                                    <button class="btn btn-secondary" data-dismiss="modal" onclick="limpiar(); actualizar_tabla();" 
                                    id="salir">Cancelar</button>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

</body>
<html>

<script language="javascript">
    function ventana1() {
        window.open("../Controlador/gestion_estudiantes_controlador2.php", "GESTION");
    }
</script>
.
<script>
    $(document).ready(function() {
        TablaEstudiante();
    });
</script>

<script type="text/javascript" src="../js/funciones_gestion_estudiantes.js"></script>
<script>
    var idioma_espanol = {
        select: {
            rows: "%d fila seleccionada"
        },
        "sProcessing": "Procesando...",
        "sLengthMenu": "Mostrar _MENU_ registros",
        "sZeroRecords": "No se encontraron resultados",
        "sEmptyTable": "No hay registros disponibles",
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
<script>
    //Validacion para que solo acepte archivos EXCEL
document.getElementById("txt_archivo_excel").addEventListener("change", ()=>{
    var fileName = document.getElementById("txt_archivo_excel").value;
    var idxDot = fileName.lastIndexOf(".")+1;
    var extFile = fileName.substr(idxDot, fileName.length).
    toLowerCase();
    if (extFile =="xlsx" || extFile =="xlsb") {
        //TO DO
    } else {
        swal("Mensaje de Advertencia", "Solo se aceptan archivos Excel - Usted subió un archivo con extensión "+extFile,"warning");
        document.getElementById("txt_archivo_excel").value="";
    }
});

//Funcion para subir informacion del archivo a la base de datos
function cargar_excel() {
    let archivo = document.getElementById ('txt_archivo_excel').value;
    if (archivo.length==0) {
        //return Swal.fire("Mensaje de advertencia", "Seleccione un archivo", "warning");
        swal({
                title: "¡Mensaje de Advertencia!",
                text: "Seleccione un archivo ",
                type: "warning",
                showConfirmButton: true,
                timer: 10000,
            });
    }
    let formData = new FormData();
    let excel = $("#txt_archivo_excel")[0].files[0];
    formData.append('excel', excel);
    $.ajax({
        url: 'import_registro_estudiantes_controlador.php',
        type:'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (resp){
            alert(resp);
        }
    });
    return false;
}
</script>