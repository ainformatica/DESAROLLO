<?php
ob_start();

session_start();

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
        text: "¡Lo sentimos! El tipo producto ya existe",
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



    $sqltabla = "select tipo_producto FROM tbl_tipo_producto";
    $resultadotabla = $mysqli->query($sqltabla);
  }
  if ($msj == 3) {


    echo '<script type="text/javascript">
    swal({
        title: "",
        text: "¡Lo sentimos! Error al actualizar, intente de nuevo.",
        type: "error",
        showConfirmButton: false,
        timer: 3000
    });
</script>';
  }
}


$Id_objeto = 192;
$visualizacion = permiso_ver($Id_objeto);



if ($visualizacion == 0) {
  // header('location:  ../vistas/menu_roles_vista.php');
  echo '<script type="text/javascript">
                              swal({
                                   title:"",
                                   text:"¡Lo sentimos! No tiene permiso de visualizar la pantalla",
                                   type: "error",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                           window.location = "../vistas/menu_mantenimiento_laboratorio.php";

                            </script>';
} else {

  bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INGRESO', 'A MANTENIMIENTO TIPO PRODUCTO');


  if (permisos::permiso_modificar($Id_objeto) == '1') {
    $_SESSION['btn_modificar_tipo_producto'] = "";
  } else {
    $_SESSION['btn_modificar_tipo_producto'] = "disabled";
  }

  /* Manda a llamar todos las datos de la tabla para llenar el gridview  */
  $sqltabla = "select tipo_producto FROM tbl_tipo_producto";
  $resultadotabla = $mysqli->query($sqltabla);



  /* Esta condicion sirve para  verificar el valor que se esta enviando al momento de dar click en el icono modicar */
  if (isset($_GET['tipo_producto'])) {
    $sqltabla = "select tipo_producto         
FROM tbl_tipo_producto";
    $resultadotabla = $mysqli->query($sqltabla);

    /* Esta variable recibe el estado de modificar */
    $tipo_producto = $_GET['tipo_producto'];

    /* Iniciar la variable de sesion y la crea */
    /* Hace un select para mandar a traer todos los datos de la 
 tabla donde tipo_producto sea igual al que se ingreso en el input */
    $sql = "select * FROM tbl_tipo_producto WHERE tipo_producto = '$tipo_producto'";
    $resultado = $mysqli->query($sql);
    /* Manda a llamar la fila */
    $row = $resultado->fetch_array(MYSQLI_ASSOC);

    /* Aqui obtengo el id_estado_civil de la tabla de la base el cual me sirve para enviarla a la pagina actualizar.php para usarla en el where del update   */
    $_SESSION['id_tipo_producto'] = $row['id_tipo_producto'];
    $_SESSION['tipo_producto'] = $row['tipo_producto'];



    /*Aqui levanto el modal*/

    if (isset($_SESSION['tipo_producto'])) {


?>
      <script>
        $(function() {
          $('#modal_modificar_tipo_producto').modal('toggle')

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


            <h1>TIPO PRODUCTO
            </h1>
          </div>

          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item active"><a href="../vistas/menu_mantenimiento_laboratorio.php">Menú Mantenimiento</a></li>
              <!-- <li class="breadcrumb-item active"><a href="../vistas/mantenimiento_crear_tipo_producto_vista.php">Nuevo Tipo Producto</a></li> -->
            </ol>
          </div>

          <div class="RespuestaAjax"></div>

        </div>
      </div><!-- /.container-fluid -->
    </section>


    <!--Pantalla 2-->

    <div class="card card-default">
      <div class="card-header">
        <h3 class="card-title">Tipo Producto Existentes</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
        <br>
        <div class=" px-12">
          <!-- <button class="btn btn-success "> <i class="fas fa-file-pdf"></i> <a style="font-weight: bold;" onclick="ventana()">Exportar a PDF</a> </button> -->
        </div>
      </div>
      <div class="card-body">
        <div style="padding: 2px;"><a href="mantenimiento_crear_tipo_producto_vista.php" class=" btn btn-success btn-inline float-right mt-0"><i class="fas fa-plus pr-2"></i>Nuevo</a></div>

        <table id="tblTipoProducto" class="table table-bordered table-striped">



          <thead>
            <tr>
              <th>TIPO PRODUCTO</th>
              <th>MODIFICAR</th>
              <th>ELIMINAR</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $resultadotabla->fetch_array(MYSQLI_ASSOC)) { ?>
              <tr>
                <td><?php echo $row['tipo_producto']; ?></td>

                <td style="text-align: center;">

                  <a href="../vistas/mantenimiento_tipo_producto_vista.php?tipo_producto=<?php echo $row['tipo_producto']; ?>"> <button type="submit" class="btn btn-primary btn-raised btn-xs" <?php echo $_SESSION['btn_modificar_tipo_producto'] ?>>
                      <i class="far fa-edit"></i>
                    </button>
                  </a>
                </td>

                <td style="text-align: center;">

                  <form action="../Controlador/eliminar_tipo_producto_controlador.php?tipo_producto=<?php echo $row['tipo_producto']; ?>" method="POST" class="FormularioAjax" data-form="delete" autocomplete="off">
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





  <!-- Creacion del modal -->

  <form action="../Controlador/actualizar_tipo_producto_controlador.php?id_tipo_producto=<?php echo $_SESSION['id_tipo_producto']; ?>" method="post" class="FormularioAjax" data-form="update" autocomplete="off">



    <div class="modal fade" id="modal_modificar_tipo_producto">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"> Actualizar Tipo Producto</h4>
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

                    <label>Modificar Tipo Producto</label>


                    <input class="form-control" class="tf w-input" type="text" id="txt_tipo_producto" onkeypress="return validacion_para_nombre(event)" name="txt_tipo_producto" value="<?php echo $_SESSION['tipo_producto']; ?>" required style="text-transform: uppercase" onkeyup="DobleEspacio(this, event); MismaLetra('txt_tipo_producto');" maxlength="50">

                  </div>


                </div>
              </div>
            </div>

          </div>




          <!--Footer del modal-->
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary" id="btn_modificar_tipo_producto" name="btn_modificar_tipo_producto" <?php echo $_SESSION['btn_modificar_tipo_producto']; ?>>Guardar Cambios</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>

    <!-- /.  finaldel modal -->

    <!--mosdal crear -->
    <div class="RespuestaAjax"></div>
  </form>


  <!-- <script type="text/javascript" language="javascript">
      function ventana() {
        window.open("../Controlador/reporte_mantenimiento_generos_controlador.php", "REPORTE");
      }
    </script> -->


  <!-- <script type="text/javascript">
    $(function() {

      $('#tblTipoProducto').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
      });
    });
  </script> -->


</body>

</html>
<script type="text/javascript" src="../js/pdf_gestion_laboratorio.js"></script>
<script type="text/javascript" src="../js/validaciones_gestion_laboratorio.js"></script>
<script src="../plugins/select2/js/select2.min.js"></script>
<!-- datatables JS -->
<script type="text/javascript" src="../plugins/datatables/datatables.min.js"></script>
<!-- para usar botones en datatables JS -->
<script src="../plugins/datatables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>
<script src="../plugins/datatables/JSZip-2.5.0/jszip.min.js"></script>
<script src="../plugins/datatables/pdfmake-0.1.36/pdfmake.min.js"></script>
<script src="../plugins/datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
<script src="../plugins/datatables/Buttons-1.5.6/js/buttons.html5.min.js"></script>