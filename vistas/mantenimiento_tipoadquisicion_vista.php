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
        text: "Lo sentimos el tipo adquisición ya existe",
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



    $sqltabla = "select tipo_adquisicion FROM tbl_tipo_adquisicion";
    $resultadotabla = $mysqli->query($sqltabla);
  }
  if ($msj == 3) {


    echo '<script type="text/javascript">
    swal({
        title: "",
        text: "Error al actualizar lo sentimos,intente de nuevo.",
        type: "error",
        showConfirmButton: false,
        timer: 3000
    });
</script>';
  }
}


$Id_objeto = 187;
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
                           window.location = "../vistas/menu_mantenimiento_laboratorio.php";

                            </script>';
} else {

  bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'Ingreso', 'A Mantenimiento Tipo Adquisicion');



  if (permisos::permiso_modificar($Id_objeto) == '1') {
    $_SESSION['btn_modificar_tipoadquisicion'] = "";
  } else {
    $_SESSION['btn_modificar_tipoadquisicion'] = "disabled";
  }


  /* Manda a llamar todos las datos de la tabla para llenar el gridview  */
  $sqltabla = "select tipo_adquisicion FROM tbl_tipo_adquisicion";
  $resultadotabla = $mysqli->query($sqltabla);



  /* Esta condicion sirve para  verificar el valor que se esta enviando al momento de dar click en el icono modicar */
  if (isset($_GET['tipo_adquisicion'])) {
    $sqltabla = "select tipo_adquisicion        
FROM tbl_tipo_adquisicion";
    $resultadotabla = $mysqli->query($sqltabla);

    /* Esta variable recibe el estado de modificar */
    $tipo_adquisicion = $_GET['tipo_adquisicion'];

    /* Iniciar la variable de sesion y la crea */
    /* Hace un select para mandar a traer todos los datos de la 
 tabla donde rol sea igual al que se ingreso en el input */
    $sql = "select * FROM tbl_tipo_adquisicion WHERE tipo_adquisicion = '$tipo_adquisicion'";
    $resultado = $mysqli->query($sql);
    /* Manda a llamar la fila */
    $row = $resultado->fetch_array(MYSQLI_ASSOC);

    /* Aqui obtengo el id_tipo<-adquisicion de la tabla de la base el cual me sirve para enviarla a la pagina actualizar.php para usarla en el where del update   */
    $_SESSION['id_tipo_adquisicion'] = $row['id_tipo_adquisicion'];
    $_SESSION['tipo_adquisicion'] = $row['tipo_adquisicion'];



    /*Aqui levanto el modal*/

    if (isset($_SESSION['tipo_adquisicion'])) {


?>
      <script>
        $(function() {
          $('#modal_modificar_tipoadquisicion').modal('toggle')

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


            <h1>Tipo Adquisición
            </h1>
          </div>

          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item active"><a href="../vistas/menu_mantenimiento_laboratorio.php">Menu Mantenimiento</a></li>
              <!-- <li class="breadcrumb-item active"><a href="../vistas/mantenimiento_crear_tipoadquisicion_vista.php">Nuevo Tipo Adquisición</a></li> -->
            </ol>
          </div>

          <div class="RespuestaAjax"></div>

        </div>
      </div><!-- /.container-fluid -->
    </section>


    <!--Pantalla 2-->
    <div class="card card-default">
      <div class="card-header">
        <h3 class="card-title">Tipo Adquisición Existentes</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
        <br>
        <div class=" px-12">
          <!-- <button class="btn btn-success "> <i class="fas fa-file-pdf"></i> <a style="font-weight: bold;" onclick="ventana()">Exportar a PDF</a> </button> -->
        </div>
      </div>

      <div class="card-body">
        <div style="padding: 2px;"><a href="mantenimiento_crear_tipoadquisicion_vista.php" class=" btn btn-success btn-inline float-right mt-0"><i class="fas fa-plus pr-2"></i>Nuevo</a></div>
        <table id="tblTipoAdquisicion" class="table table-bordered table-striped">



          <thead>
            <tr>
              <th>TIPO ADQUISICIÓN</th>
              <th>MODIFICAR</th>
              <th>ELIMINAR</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $resultadotabla->fetch_array(MYSQLI_ASSOC)) { ?>
              <tr>
                <td><?php echo $row['tipo_adquisicion']; ?></td>

                <td style="text-align: center;">

                  <a href="../vistas/mantenimiento_tipoadquisicion_vista.php?tipo_adquisicion=<?php echo $row['tipo_adquisicion']; ?>" class="btn btn-primary btn-raised btn-xs">
                    <i class="far fa-edit" style="display:<?php echo $_SESSION['modificar_tipo_adquisicion'] ?> "></i>
                  </a>
                </td>

                <td style="text-align: center;">

                  <form action="../Controlador/eliminar_tipoadquisicion_controlador.php?tipo_adquisicion=<?php echo $row['tipo_adquisicion']; ?>" method="POST" class="FormularioAjax" data-form="delete" autocomplete="off">
                    <button type="submit" class="btn btn-danger btn-raised btn-xs">

                      <i class="far fa-trash-alt" style="display:<?php echo $_SESSION['eliminar_tipo_adquisicion'] ?> "></i>
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





  <!-- ********************* MODAL PARA MODIFICAR-->

  <form action="../Controlador/actualizar_tipoadquisicion_controlador.php?id_tipo_adquisicion=<?php echo $_SESSION['id_tipo_adquisicion']; ?>" method="post" data-form="update" class="FormularioAjax" autocomplete="off">



    <div class="modal fade" id="modal_modificar_tipoadquisicion">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"> Actualizar Tipo Adquisición </h4>
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

                    <label>Modificar Tipo Adquisición </label>


                    <input class="form-control" class="tf w-input" type="text" id="txt_tipoadquisicion" onkeypress="return validacion_para_nombre(event)" name="txt_tipoadquisicion" value="<?php echo $_SESSION['tipo_adquisicion']; ?>" required style="text-transform: uppercase" onkeyup="DobleEspacio(this, event); MismaLetra('txt_tipoadquisicion');" maxlength="50">

                  </div>


                </div>
              </div>
            </div>

          </div>




          <!--Footer del modal-->
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary" id="btn_modificar_tipoadquisicion" name="btn_modificar_tipoadquisicion" <?php echo $_SESSION['btn_modificar_tipoadquisicion']; ?>>Guardar Cambios</button>

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
  <script type="text/javascript" language="javascript">
    function ventana() {
      window.open("../Controlador/reporte_mantenimiento_tipoadquisiciones_controlador.php", "REPORTE");
    }
  </script>




  <!-- <script type="text/javascript">
    $(function() {

      $('#tblTipoAdquisicion').DataTable({
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

<script type="text/javascript" src="../js/validaciones_gestion_laboratorio.js"></script>
<script type="text/javascript" src="../js/pdf_gestion_laboratorio.js"></script>
<script src="../plugins/select2/js/select2.min.js"></script>
<!-- datatables JS -->
<script type="text/javascript" src="../plugins/datatables/datatables.min.js"></script>


<!-- para usar botones en datatables JS -->
<script src="../plugins/datatables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>
<script src="../plugins/datatables/JSZip-2.5.0/jszip.min.js"></script>
<script src="../plugins/datatables/pdfmake-0.1.36/pdfmake.min.js"></script>
<script src="../plugins/datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
<script src="../plugins/datatables/Buttons-1.5.6/js/buttons.html5.min.js"></script>