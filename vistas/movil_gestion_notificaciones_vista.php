<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
ob_start();
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora_movil.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');
require_once('../Controlador/movil_helpers_controlador.php');
date_default_timezone_set("America/Tegucigalpa");
$Id_objeto = 10169;
$visualizacion = permiso_ver($Id_objeto);
if ($visualizacion == 0) {
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
    $_SESSION['archivos_aceptado_notificacion'] = parametrizacion('ArchivoAceptadoNotificacion');
    bitacora_movil::evento_bitacora($_SESSION['id_usuario'], $Id_objeto, 'INGRESO', 'A GESTIÓN DE NOTIFICACIONES ');
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM tbl_movil_notificaciones WHERE id = '$id'";
    $resultado = $mysqli->query($sql);
    //     /* Manda a llamar la fila */
    $row = $resultado->fetch_array(MYSQLI_ASSOC);

    $id = $row['id'];
    $_SESSION['txtTitulo'] = $row['titulo'];
    $_SESSION['txtDescripcion'] = $row['descripcion'];
    $_SESSION['txtFecha'] = strtotime($row['fecha']);
    $_SESSION['txtSegmento_id'] = $row['segmento_id'];
    $_SESSION['txtTipoNotificacionId'] = $row['tipo_notificacion_id'];
    $_SESSION['txtUrl'] = $row['image_url'];

    if (isset($_SESSION['txtTitulo'])) {

?>

        <script>
            $(function() {
                $('#modal_modificar_notificacion').modal('toggle')
            })
        </script>;

<?php

    }
}

if (isset($_REQUEST['msj'])) {
    $msj = $_REQUEST['msj'];

    if ($msj == 1) {
        echo '<script type="text/javascript">
                    swal({
                       title:"",
                       text:"¡Lo sentimos! El segmento ya existe",
                       type: "info",
                       showConfirmButton: false,
                       timer: 3000
                        });
                </script>';
    }
    if ($msj == 2) {
        echo '<script type="text/javascript">
                    swal({
                       title:"",
                       text:"Los datos se almacenaron correctamente",
                       type: "success",
                       showConfirmButton: false,
                       timer: 3000
                        });
                </script>';
    }
    if ($msj == 3) {
        echo '<script type="text/javascript">
                    swal({
                       title:"",
                       text:"¡Lo sentimos! Tiene campos por rellenar",
                       type: "error",
                       showConfirmButton: false,
                       timer: 3000
                    });
                </script>';
    }
    if ($msj == 4) {
        echo '<script type="text/javascript">
                    swal({
                       title:"",
                       text:"Los datos se eliminaron correctamente",
                       type: "error",
                       showConfirmButton: false,
                       timer: 3000
                    });
                </script>';
    }
    if ($msj == 5) {
        echo '<script type="text/javascript">
                    swal({
                       title:"",
                       text:"¡No se puede agregar más de una imagen!",
                       type: "error",
                       showConfirmButton: false,
                       timer: 3000
                    });
                </script>';
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <script src="../js/autologout.js"></script>
    <title></title>
    <script src="../js/movil_notificacion.js" defer></script>
</head>

<body>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Gestión de Notificaciones</h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
                            <li class="breadcrumb-item active"><a href="../vistas/movil_menu_notificaciones_vista.php">Menú de Notificaciones</a></li>
                        </ol>
                    </div>

                    <div class="RespuestaAjax"></div>

                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!--Pantalla 2-->
        <div class="card card-default">
            <div class="card-header">
            <h3 class="card-title">Listado de notificaciones existentes en el sistema.</h3><br>
            <hr>
            <div class="dt-buttons btn-group">
                    <button class="btn btn-secondary buttons-pdf buttons-html5 btn-danger" tabindex="0" aria-controls="tabla2" type="button" id="GenerarReporte" title="Exportar a PDF"><span><i class="fas fa-file-pdf"></i> </span> </button>
                </div>
                <a class="btn btn-primary btn-xs float-right" href="../vistas/movil_crear_notificacion_vista.php">Nuevo</a>
                <!--buscador-->
                <div class="float-right mt-5 ml-5">
                    <input class="form-control" placeholder="Buscar..." type="text" id="buscartext" name="buscar" onpaste="return false" onkeyup="leer(this.value)">
                </div>
                <!-- /.card-header -->
                <div class="card-body" id="Notificaciones">

                </div><!-- /.card-body -->
            </div>
        </div>
        <?php
        if (isset($_GET['id'])):
        ?>
        <form action="../Controlador/movil_notificacion_controlador.php?op=editar&id=<?php echo $id ?>" method="post" data-form="update" autocomplete="off" enctype="multipart/form-data">

            <div class="modal fade" tabindex="-1" id="modal_modificar_notificacion">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Modificar Notificación</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>


                        <!--Cuerpo del modal-->
                        <div class="modal-body">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="titulo"> Título:</label>
                                            <input autofocus class="form-control" type="text" value="<?php echo $_SESSION['txtTitulo'] ?>" minlength="30" maxlength="90" id="titulo" name="titulo" required onpaste="return false" onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" onkeypress="return comprobar(this.value, event, this.id)">
                                        </div>

                                        <div class="form-group">
                                            <label for="Contenido">Contenido:</label>
                                            <input class="form-control" type="text" value="<?php echo $_SESSION['txtDescripcion'] ?>" minlength="100" maxlength="255" id="Contenido" name="Contenido" required onpaste="return false" onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" onkeypress="return comprobar(this.value, event, this.id)">
                                        </div>

                                        <div class="form-group">
                                            <label>Segmentos: </label>
                                            <select class="form-control" name="Segmentos" id="Segmentos">
                                                <option value="">Seleccione una opción :</option>
                                                <?php
                                                $sql_segmentos = "SELECT id,nombre FROM tbl_movil_segmentos";
                                                $resultado_segmentos = $mysqli->query($sql_segmentos);
                                                while ($segmento = $resultado_segmentos->fetch_array(MYSQLI_ASSOC)) { ?>
                                                    <?php if ($segmento['id'] == $_SESSION['txtSegmento_id']) { ?>
                                                        <option selected value="<?php echo $segmento['id'] ?>">
                                                            <?php echo $segmento['nombre'] ?></option>
                                                    <?php } else { ?>
                                                        <option value="<?php echo $segmento['id'] ?>">
                                                            <?php echo $segmento['nombre'] ?></option>
                                                <?php }
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Tipo Notificación: </label>
                                            <select class="form-control" name="tipo_notificacion" id="tipo_notificacion">
                                                <option value="">Seleccione una opción :</option>
                                                <?php
                                                $sql_tn = "SELECT id,descripcion FROM tbl_movil_tipo_notificaciones";
                                                $resultado_tn = $mysqli->query($sql_tn);
                                                while ($fila = $resultado_tn->fetch_array(MYSQLI_ASSOC)) { ?>
                                                    <?php if ($fila['id'] == $_SESSION['txtTipoNotificacionId']) { ?>
                                                        <option selected value="<?php echo $fila['id'] ?>">
                                                            <?php echo $fila['descripcion'] ?></option>
                                                    <?php } else { ?>
                                                        <option value="<?php echo $fila['id'] ?>">
                                                            <?php echo $fila['descripcion'] ?></option>
                                                <?php }
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <!-- FECHA DE PUBLICACION txt_fecha_Publicacion -->
                                            <label for="txt_fecha_Publicacion">Fecha y Hora de Publicación:</label>
                                            <input class="form-control" type="datetime-local" id="txt_fecha_Publicacion" value="<?php echo date("Y-m-d\TH:i", $_SESSION['txtFecha']); ?>" min="<?php echo date("Y-m-d\TH:i"); ?>" max="<?php echo date("Y-m-d\TH:i", strtotime(date("Y-m-d\TH:i") . "+ 1 week")); ?>" name="txt_fecha_Publicacion" required onkeydown="return false">
                                        </div>
                                        <div class="form-group" style="width: 300px;">
                                            <!-- archivos adjuntos -->
                                            <label>Archivos Adjuntos:</label>
                                            <div id="tabla_archivos">
                                                <table id="tabla_imagen" class="table table-bordered table-striped" style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>URL</th>
                                                            <th>ELIMINAR</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><?php echo str_replace(base_url, '..', $_SESSION['txtUrl']); ?></td>
                                                            <?php if ($_SESSION['txtUrl'] != 'null') :?>
                                                                <td><a onclick="eliminar_img(<?php echo $id; ?>);" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a></td>
                                                            <?php else:?>
                                                                <td><a class="btn btn-danger btn-xs" disabled><i class="fa fa-trash"></i></a></td>
                                                            <?php endif;?>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php if ($_SESSION['txtUrl'] != 'null') : ?>
                                                <label>¡No necesita más imágenes!</label>
                                            <?php else : ?>
                                                <label> Nueva Imagen:</label>
                                                <input class="form-control" type="file" class="form-control" id="subir_archivo" name="subir_archivo" accept="<?php echo $_SESSION['archivos_aceptados_notificacion']?>">
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--Footer del modal-->
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary" id="btn_modificar_segmento" name="btn_modificar_segmento">Guardar Cambios</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>

            <!-- /.  finaldel modal -->

        </form>
        <?php endif;?>
        <script>
            //validar el tipo de archivo
            $(document).on('change', 'input[type="file"]', function() {
                var fileName = this.files[0].name;
                var fileSize = this.files[0].size;

                if (fileSize > 3000000) {
                    alert('El archivo no debe superar los 3MB');
                    this.value = '';
                    this.files[0].name = '';
                } else {
                    // recuperamos la extensión del archivo
                    var ext = fileName.split('.').pop();

                    // Convertimos en minúscula porque 
                    // la extensión del archivo puede estar en mayúscula
                    ext = ext.toLowerCase();

                    // console.log(ext);
                    switch (ext) {
                        case 'jpg':
                        case 'jpeg':
                        case 'png':
                            break;
                        default:
                            alert('El archivo no tiene la extensión adecuada');
                            this.value = ''; // reset del valor
                            this.files[0].name = '';
                    }
                }
            });
            $(function() {
                $('#tabla_imagen').DataTable({
                    "paging": false,
                    "lengthChange": false,
                    "searching": false,
                    "ordering": false,
                    "info": false,
                    "autoWidth": false,
                    "responsive": false,
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
                    }
                });
            });

            function eliminar_img(id) {
                var parametro = {
                    'funcion': "eliminar_imagen",
                    'id': id,
                };
                var confirmacion = confirm("¿Está seguro de eliminar?");
                if (confirmacion) {
                    $.ajax({
                        data: parametro, //datos que se envian a traves de ajax
                        url: "../Controlador/movil_notificacion_controlador.php", //archivo que recibe la peticion
                        type: "POST", //método de envio
                        success: function(data) {
                            //una vez que el archivo recibe el request lo procesa y lo devuelve
                            if (data != "") {
                                location.reload(true);
                            }
                        },
                    });
                } else {
                    console.log("Decidio no eliminar");
                }
            }
        </script>
</body>

</html>
<?php ob_end_flush() ?>