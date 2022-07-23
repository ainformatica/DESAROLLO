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
/*require_once('../Modelos/movil_segmentos_modelo.php');*/
date_default_timezone_set("America/Tegucigalpa");
$Id_objeto = 10177;
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
  bitacora_movil::evento_bitacora($_SESSION['id_usuario'], $Id_objeto, 'INGRESO', 'A MANTENIMIENTO UBICACION RECURSO');
}

// /* Esta condicion sirve para  verificar el valor que se esta enviando al momento de dar click en el icono modicar */
if (isset($_GET['id'])) {
  $sql_segmento = "SELECT * FROM tbl_movil_segmentos";
  $resultado_segmento = $mysqli->query($sql_segmento);

  $id = $_GET['id'];

  // /* Iniciar la variable de sesion y la crea */


  //  /* Hace un select para mandar a traer todos los datos de la 
  //  tabla donde rol sea igual al que se ingreso e el input */
  $sql = "SELECT * FROM tbl_movil_segmentos WHERE id = '$id'";
  $resultado = $mysqli->query($sql);
  //     /* Manda a llamar la fila */
  $row = $resultado->fetch_array(MYSQLI_ASSOC);

  $id = $row['id'];
  $_SESSION['txtNombre'] = $row['nombre'];
  $_SESSION['txtDescripcion'] = $row['descripcion'];
  $_SESSION['txtCreado_por'] = $row['creado_por'];

  if (isset($_SESSION['txtNombre'])) {


?>
    <script>
      $(function() {
        $('#modal_modificar_segmento').modal('toggle')
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
</head>

<body>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Mantenimiento Ubicación Tipo Recurso</h1>
          </div>

          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
            </ol>
          </div>

          <div class="RespuestaAjax"></div>

        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!--Pantalla 2-->

    <div class="card card-default">
      <div class="card-header">
        <a class="btn btn-primary btn-xs" href="#">Nuevo</a>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="tabla" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>UBICACIÓN DEL RECURSO</th>
              <th>EDITAR</th>
              <th>BORRAR</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $sql_segmentos = "select *  ";
            $resultado_segmentos = $mysqli->query($sql_segmentos);
            while ($segmento = $resultado_segmentos->fetch_array(MYSQLI_ASSOC)) { ?>
              <tr>
                <td><?php echo $segmento['']; ?></td>
                <td><?php echo $segmento['']; ?></td>

                <td style="text-align: center;">

                  <a href="../vistas/movil_gestion_segmentos_vista.php?&id=<?php echo $segmento['id']; ?>" class="btn btn-primary btn-raised btn-xs">
                    <i class="far fa-edit"></i>
                  </a>
                </td>

                <td style="text-align: center;">
                  <form action="../Controlador/guardar_segmento_controlador.php?op=eliminar&id=<?php echo $segmento['id']; ?>" method="POST" class="FormularioAjax" data-form="delete" autocomplete="off">
                    <button type="submit" class="btn btn-danger btn-raised btn-xs">
                      <i class="far fa-trash-alt"></i>
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

  </div>

  </section>

  </div>

  <form action="../Controlador/guardar_segmento_controlador.php?op=editar&id=<?php echo $id ?>" method="post" data-form="update" autocomplete="off">

    <div class="modal fade" id="modal_modificar_segmento">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Modificar Segmento</h4>
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
                    <label>Segmento</label>

                    <input class="form-control" type="text" id="nombre" name="nombre" style="text-transform: uppercase" onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" required="" maxlength="30" value="<?php echo $_SESSION['txtNombre']; ?>">

                  </div>

                  <div class="form-group">
                    <label>Descripción</label>

                    <input class="form-control" type="text" id="descripcion" name="descripcion" style="text-transform: uppercase" onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" required="" maxlength="30" value="<?php echo $_SESSION['txtDescripcion']; ?>">

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


  <script type="text/javascript">
    $(function() {

      $('#tabla').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
        "language": {
          "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
        }
      });
    });
  </script>
</body>

</html>
<?php ob_end_flush() ?>