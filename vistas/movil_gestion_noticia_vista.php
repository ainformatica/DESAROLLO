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
$Id_objeto = 10168;
$visualizacion = permiso_ver($Id_objeto);


if ($visualizacion == 0) {
 
} else {
$_SESSION['min_caracteres_noticia'] = parametrizacion('ContenidoMinNoticia');
$_SESSION['max_caracteres_noticia'] = parametrizacion('ContenidoMaxNoticia');
$_SESSION['min_date_public'] = parametrizacion('TiempoPublicacionMin');
$_SESSION['max_date_public'] = parametrizacion('TiempoPublicacionMax');
$_SESSION['archivos_aceptados_noticia'] = parametrizacion('ArchivoAceptadoNoticia');
  bitacora_movil::evento_bitacora($_SESSION['id_usuario'], $Id_objeto, 'INGRESO', 'A GESTIÓN DE NOTICIAS ');
}

if (isset($_GET['id'])) {
  $id = $_GET['id'];

  $sql = "SELECT * FROM tbl_movil_noticias WHERE id = '$id'";
  $resultado = $mysqli->query($sql);
  //     /* Manda a llamar la fila */
  $row = $resultado->fetch_array(MYSQLI_ASSOC);

  $id = $row['id'];
  $_SESSION['txtTitulo'] = $row['titulo'];
  $_SESSION['txtSubtitulo'] = $row['subtitulo'];
  $_SESSION['txtDescripcion'] = $row['descripcion'];
  $_SESSION['txtFecha'] = strtotime($row['fecha']);
  $_SESSION['txtFecha_vencimiento'] = strtotime($row['fecha_vencimiento']);
  $_SESSION['txtSegmento_id'] = $row['segmento_id'];




  if (isset($_SESSION['txtTitulo'])) {

?>

    <script>
      $(function() {
        $('#modal_modificar_noticia').modal('toggle')
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
}

?>
<!DOCTYPE html>
<html>

<head>
  <script src="../js/autologout.js"></script>
  <title></title>
  <script src="../js/movil_gestion_noticias.js" defer></script>
</head>

<body>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Gestión Noticias</h1>
          </div>

          <div class="col-sm-6">
            
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item"><a href="../vistas/movil_menu_noticias_vista.php">Menú de Noticias</a></li>
            </ol>
          </div>

          <div class="RespuestaAjax"></div>

        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!--Pantalla 2-->
    <div class="card card-default">
   
      <div class="card-header">
      <h3 class="card-title">Listado de noticias existentes en el sistema.</h3><br>
      <hr>
        <div class="card-tools">
          <a class="btn btn-primary btn-xs" href="../vistas/movil_crear_noticia_vista.php">Nuevo</a>
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
        <div class="dt-buttons btn-group">
          <button class="btn btn-secondary buttons-pdf buttons-html5 btn-danger" tabindex="0" aria-controls="tabla2" type="button" title="Exportar a PDF"><span><i class="fas fa-file-pdf"></i> </span> 
        </button>
       </div>
        <!--buscador-->
        <div class="float-right mt-5 ml-5">
          <input class="form-control" placeholder="Buscar..." type="text" id="buscartext" name="buscar" onpaste="return false" onkeyup="leer(this.value)">
        </div>
        <div class="card-body" id="Noticias">

</div><!-- /.card-body -->
      </div>
     
    </div>
        <?php
        if (isset($_GET['id'])):
        ?>
    <!--modal editar noticias-->
    <form action="../Controlador/movil_noticia_controlador.php?op=editar&id=<?php echo $id ?>" method="post" data-form="update" autocomplete="off" enctype="multipart/form-data">

      <div class="modal fade" id="modal_modificar_noticia">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Modificar Noticia</h4>
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
                      <label for="titulo">Título:</label>
                      <input autofocus class="form-control" type="text" minlength="30" maxlength="90" value="<?php echo $_SESSION['txtTitulo'] ?>" maxlength="90" id="titulo" name="titulo" required onpaste="return false" onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" onkeypress="return comprobar(this.value, event, this.id)">
                    </div>

                    <div class="form-group">
                      <label for="subtitulo">Subtítulo:</label>
                      <input class="form-control" type="text" minlength="30" maxlength="90" value="<?php echo $_SESSION['txtSubtitulo'] ?>" maxlength="90" id="subtitulo" name="subtitulo" required onpaste="return false" onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" onkeypress="return comprobar(this.value, event, this.id)">
                    </div>

                    <div class="form-group">

                      <label for="Contenido">Contenido:</label>
                      <textarea class="form-control" cols="150" rows="5" minlength="<?php echo $_SESSION['min_caracteres_noticia']?>" maxlength="<?php echo $_SESSION['max_caracteres_noticia']?>" id="Contenido" name="Contenido" required onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" onkeypress="return comprobar(this.value, event, this.id)"><?php echo $_SESSION['txtDescripcion']; ?></textarea>
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
                            <option selected value="<?php echo $segmento['id'] ?>"><?php echo $segmento['nombre'] ?></option>
                          <?php } else { ?>
                            <option value="<?php echo $segmento['id'] ?>"><?php echo $segmento['nombre'] ?></option>
                        <?php }
                        }
                        ?>
                      </select>
                    </div>

                    <div class="form-group">
                      <!-- FECHA DE PUBLICACION txt_fecha_Publicacion -->
                      <label for="txt_fecha_Publicacion">Fecha y Hora de Publicación:</label>
                      <input class="form-control" type="datetime-local" id="txt_fecha_Publicacion" name="txt_fecha_Publicacion" value="<?php echo date("Y-m-d\TH:i", $_SESSION['txtFecha']); ?>" min="<?php echo date("Y-m-d\TH:i", $_SESSION['txtFecha']); ?>" onkeydown="return false">
                    </div>
                    <div class="form-group">
                      <!-- FECHA DE PUBLICACION txt_fecha_Publicacion -->
                      <label for="txt_fecha_vencimiento">Fecha y Hora de Vencimiento:</label>
                      <input class="form-control" type="datetime-local" id="txt_fecha_vencimiento" name="txt_fecha_vencimiento" value="<?php echo date("Y-m-d\TH:i", $_SESSION['txtFecha_vencimiento']); ?>" min="<?php echo date("Y-m-d\TH:i", strtotime($_SESSION['txtFecha_vencimiento'] . "+ 1 month")); ?>" max="<?php echo date("Y-m-d\TH:i", strtotime(date("Y-m-d\TH:i") . "+ 3 month")); ?>" onkeydown="return false">
                    </div>
                    <div class="form-group">
                      <!-- archivos adjuntos -->
                      <label>Archivos Adjuntos:</label>
                      <div id="tabla_archivos">
                        <table id="tabla" class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th>URL</th>
                              <th>ELIMINAR</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $sql_archivos = "SELECT n.id as noticia,r.id as recurso,r.url FROM `tbl_movil_tipo_recursos` r INNER JOIN tbl_movil_noticia_recurso nr
                                INNER JOIN tbl_movil_noticias n on r.id=nr.recurso_id and n.id=nr.noticia_id and n.id = $id";
                            $rspta = $mysqli->query($sql_archivos);
                            while ($row2 = $rspta->fetch_array(MYSQLI_ASSOC)) { ?>
                              <tr>
                                <td><?php echo str_replace(base_url, '..', $row2['url']); ?></td>
                                <td><a onclick="eliminar_archivos(<?php echo $row2['noticia'] ?>,<?php echo $row2['recurso'] ?>)" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a></td>
                              </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="form-group">
                      <label> Nuevos Archivos:</label>
                      <input class="form-control" type="file" class="form-control" id="txt_documentos" name="txt_documentos[]" multiple accept="<?php echo $_SESSION['archivos_aceptados_noticia']?>">
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
    </script>
</body>

</html>
<?php ob_end_flush() ?>