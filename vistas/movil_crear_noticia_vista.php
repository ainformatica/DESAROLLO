<?php

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
ob_start();

require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/conexion_mantenimientos.php');
require_once('../clases/funcion_bitacora_movil.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');
require_once('../Controlador/movil_helpers_controlador.php');
date_default_timezone_set("America/Tegucigalpa");
$Id_objeto = 10162;
$_SESSION['min_caracteres_noticia'] = parametrizacion('ContenidoMinNoticia');
$_SESSION['max_caracteres_noticia'] = parametrizacion('ContenidoMaxNoticia');
$_SESSION['min_date_public'] = parametrizacion('TiempoPublicacionMin');
$_SESSION['max_date_public'] = parametrizacion('TiempoPublicacionMax');
$_SESSION['archivos_aceptados_noticia'] = parametrizacion('ArchivoAceptadoNoticia');
bitacora_movil::evento_bitacora($_SESSION['id_usuario'], $Id_objeto, 'INGRESO', 'A CREAR NOTICIA');

?>
<!DOCTYPE html>
<html>

<head>
  <script src="../js/autologout.js"></script>
  <title></title>

  <!-- Bootstrap core CSS -->
  <link href="dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom styles for this template -->
  <link href="assets/sticky-footer-navbar.css" rel="stylesheet">
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
  <script type="text/javascript">
  </script>


</head>

<body>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Nueva Noticia</h1>
          </div>

          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item active"><a href="../vistas/movil_gestion_noticia_vista.php">Gestión de Noticias</a></li>
            </ol>
          </div>

          <div class="RespuestaAjax"></div>

        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- pantalla 1 -->

        <form action="../Controlador/movil_noticia_controlador.php?op=insert" method="POST" enctype="multipart/form-data">

          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">Formulario de creación de nuevas noticias</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="titulo"> Título </label>
                    <input autofocus class="form-control" type="text" minlength="30" maxlength="90" id="titulo" name="titulo" required onpaste="return false" onkeyup="DobleEspacio(this, event)" onkeypress="return check(event)">
                  </div>
                  <div class="form-group">
                    <label for="subtitulo"> Subtítulo </label>
                    <input class="form-control" type="text" minlength="30" maxlength="90" id="subtitulo" name="subtitulo" required onpaste="return false" onkeyup="DobleEspacio(this, event)" onkeypress="return check(event)">
                  </div>
                  <div class="form-group">
                    <label for="Contenido">Contenido:</label>
                    <br>
                    <textarea name="Contenido" id="Contenido" cols="150" rows="5" minlength="<?php echo $_SESSION['min_caracteres_noticia']?>" maxlength="<?php echo $_SESSION['max_caracteres_noticia']?>" required></textarea>
                  </div>

                  <div class="form-group">
                    <label>Segmentos: </label>
                    <select class="form-control" name="Segmentos" id="Segmentos">
                      <option value="">Seleccione una opción :</option>
                      <?php
                      $sql_segmentos = "SELECT id,nombre FROM tbl_movil_segmentos";
                      $resultado_segmentos = $mysqli->query($sql_segmentos);
                      while ($segmento = $resultado_segmentos->fetch_array(MYSQLI_ASSOC)) { ?>
                        <option value="<?php echo $segmento['id'] ?>"><?php echo $segmento['nombre'] ?></option>
                      <?php } ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <!-- FECHA DE PUBLICACION txt_fecha_Publicacion -->
                    <label for="txt_fecha_Publicacion">Fecha y Hora de Publicación:</label>
                    <input class="form-control" type="datetime-local" id="txt_fecha_Publicacion" name="txt_fecha_Publicacion" min="<?php echo date("Y-m-d\TH:i"); ?>" required>
                  </div>

                  <div class="form-group">
                    <!-- FECHA DE VENCIMIENTO txt_fecha_Publicacion -->
                    <label for="txt_fecha_Publicacion">Fecha y Hora de Vencimiento:</label>
                    <input class="form-control" type="datetime-local" id="txt_fecha_vencimiento" name="txt_fecha_vencimiento" min="<?php echo date("Y-m-d\TH:i", strtotime(date("Y-m-d\TH:i") . "+ ".$_SESSION['min_date_public'])); ?>" max="<?php echo date("Y-m-d\TH:i", strtotime(date("Y-m-d\TH:i") . "+ ".$_SESSION['max_date_public'])); ?>" required>
                  </div>
                </div>

                <div class="form-group">
                  <label> Adjuntar Archivos</label>
                  <input class="form-control" type="file" accept="<?php echo $_SESSION['archivos_aceptados_noticia']?>" class="form-control" id="txt_documentos" name="txt_documentos[]" multiple>
                </div>
              </div>
              <p class="text-center" style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary" id="btn_guardar" name="btn_guardar"><i class="zmdi zmdi-floppy"></i>Guardar</button>
              </p>
            </div>
          </div>
      </div>
      </form>
  </div>

  </section>
  </div>
  <script>
    function check(e) {
      tecla = (document.all) ? e.keyCode : e.which;

      //Tecla de retroceso para borrar, siempre la permite
      if (tecla == 8) {
        return true;
      }
      // Patron de entrada, en este caso solo acepta numeros y letras
      patron = /[A-Za-z0-9 ]/;
      tecla_final = String.fromCharCode(tecla);
      return patron.test(tecla_final);
    }
  </script>
</body>
<?php ob_end_flush() ?>