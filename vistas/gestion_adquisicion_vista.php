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
        text: "¡Lo sentimos! La adquisición ya existe",
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





    $sqltabla = "select id_adquisicion,id_tipo_adquisicion,descripcion_adquisicion,id_usuario,fecha_adquisicion,id_estado from tbl_adquisiciones";
    $resultadotabla = $mysqli->query($sqltabla);
  }
  if ($msj == 3) {


    echo '<script type="text/javascript">
    swal({
        title: "",
        text: "¡Lo sentimos! Error al actualizar,intente de nuevo.",
        type: "error",
        showConfirmButton: false,
        timer: 3000
    });
</script>';
  }
}


$Id_objeto = 210;
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

  bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], ' INGRESO', ' A GESTION ADQUISICION');



  if (permisos::permiso_modificar($Id_objeto) == '1') {
    $_SESSION['btn_modificar_adquisicion'] = "";
  } else {
    $_SESSION['btn_modificar_adquisicion'] = "disabled";
  }


  /* Manda a llamar todos las datos de la tabla para llenar el gridview  */
  /*$sqltabla = "select id_adquisicion,id_tipo_adquisicion,descripcion_adquisicion,fecha_adquisicion,id_estado from tbl_adquisiciones"; */
  $sqltabla = "SELECT a.id_adquisicion,c.tipo_adquisicion as tipo_adquisicion,a.descripcion_adquisicion,a.fecha_adquisicion,e.estado FROM tbl_adquisiciones a INNER JOIN tbl_tipo_adquisicion c INNER JOIN tbl_estado e ON a.id_tipo_adquisicion=c.id_tipo_adquisicion and a.id_estado=e.id_estado";
  $resultadotabla = $mysqli->query($sqltabla);



  /* Esta condicion sirve para  verificar el valor que se esta enviando al momento de dar click en el icono modificar */
  if (isset($_GET['id_adquisicion'])) {
    $sqltabla = "select id_adquisicion,id_tipo_adquisicion,descripcion_adquisicion,id_usuario,fecha_adquisicion,id_estado from tbl_adquisiciones";

    $resultadotabla = $mysqli->query($sqltabla);

    /* Esta variable recibe el producto a modificar */
    $id_adquisicion = $_GET['id_adquisicion'];

    /* Iniciar la variable de sesion y la crea */
    /* Hace un select para mandar a traer todos los datos de la 
 tabla donde producto sea igual al que se ingreso en el input */
    $sql = "select * from tbl_adquisiciones where id_adquisicion = '$id_adquisicion'";
    $resultado = $mysqli->query($sql);
    /* Manda a llamar la fila */
    $row = $resultado->fetch_array(MYSQLI_ASSOC);

    /* Aqui obtengo el id<-productos de la tabla de la base el cual me sirve para enviarla a la pagina actualizar.php para usarla en el where del update   */

    //         variable               viene de la BD
    $_SESSION['id_adquisicion_'] = $row['id_adquisicion'];
    $_SESSION['id_tipo_adquisicion_'] = $row['id_tipo_adquisicion'];
    $_SESSION['descripcion_adquisicion_'] = $row['descripcion_adquisicion'];
    $_SESSION['id_usuario_'] = $row['id_usuario'];
    $_SESSION['fecha_adquisicion_'] = $row['fecha_adquisicion'];
    $_SESSION['id_estado_'] = $row['id_estado'];
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
  <!-- 1 FORMULARIO PRINCIPAL -->
  <div class="content-wrapper" id="tblListar">

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">


            <h1>Gestión Adquisiciones
            </h1>
          </div>

          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item active"><a href="crear_adquisicion_vista.php">Nueva Adquisición</a></li>
            </ol>
          </div>

          <div class="RespuestaAjax"></div>

        </div>
      </div><!-- /.container-fluid -->
    </section>


    <!--Parte central del formulario-->
    <div class="card card-default">
      <div class="card-header">
        <h3 class="card-title">Adquisiciones Existentes</h3>
        <div class="card-tools">

          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
        <br>
        <div class=" px-12">

        </div>
      </div>
      <div class="card-body">
        <div class="mb-3">
          <div style="padding: 2px;"><a href="crear_adquisicion_vista.php" class=" btn btn-success btn-inline float-right mt-0"><i class="fas fa-plus pr-2"></i>Nuevo</a></div>


          <table id="tbladquisicion" class="table table-bordered table-striped">



            <thead>
              <tr>
                <th>TIPO ADQUISICIÓN</th>
                <th>DESCRIPCION</th>
                <th>FECHA</th>
                <th>ESTADO</th>
                <th>MODIFICAR</th>
                <th>ANULAR</th>
                <th>REPORTE</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($row = $resultadotabla->fetch_array(MYSQLI_ASSOC)) { ?>
                <tr>
                  <?php $row['id_adquisicion']; ?>
                  <td><?php echo $row['tipo_adquisicion']; ?></td>
                  <td><?php echo $row['descripcion_adquisicion']; ?></td>
                  <td><?php echo $row['fecha_adquisicion']; ?></td>
                  <td><?php echo $row['estado']; ?></td>


                  <?php

                  if ($row['estado'] == 'ANULADO') {
                    $_SESSION['botones_adquisicion'] = 'disabled="true"';
                    $_SESSION['btn_editar_bloqueado'] = "#";
                  } else {
                    $_SESSION['botones_adquisicion'] = "";
                    $_SESSION['btn_editar_bloqueado'] = "../vistas/editar_adquisicion_vista.php?id_adquisicion=";
                  }


                  ?>
                  <!-- editar -->
                  <td style="text-align: center;">


                    <a href="<?php echo  $_SESSION['btn_editar_bloqueado'];
                              echo $row['id_adquisicion']; ?> "><button class="btn btn-primary btn-raised btn-xs" <?php echo $_SESSION['botones_adquisicion']; ?>>
                        <i class="far fa-edit"></i></button>
                    </a>


                  </td>
                  <!-- eliminar -->
                  <td style="text-align: center;">

                    <form action="../Controlador/anular_adquisicion_controlador.php?id_adquisicion=<?php echo $row['id_adquisicion']; ?>&estado=<?php echo $row['estado']; ?>" method="POST" class="FormularioAjax" autocomplete="off">
                      <button type="submit" <?php echo $_SESSION['botones_adquisicion']; ?> class="btn btn-danger btn-raised btn-xs">

                        <i class="fas fa-times-circle" style="display:<?php echo $_SESSION['anular_adquisicion'] ?> "></i>
                      </button>
                      <div class="RespuestaAjax"></div>
                    </form>
                  </td>
                  <!-- reporte -->
                  <td style="text-align: center;">

                    <a href="../pdf_laboratorio/reporte_adquisicion_lab.php?id_adquisicion=<?php echo $row['id_adquisicion']; ?>" target="_blank" class="btn btn-primary btn-raised btn-xs">

                      <i class="fas fa-clipboard-list"></i>
                    </a>
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










    <!-- <script type="text/javascript">
    $(function() {

      $('#tbladquisicion').DataTable({
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
<script type="text/javascript" src="../js/pdf_mantenimientos.js"></script>
<script src="../plugins/select2/js/select2.min.js"></script>
<!-- datatables JS -->
<script type="text/javascript" src="../plugins/datatables/datatables.min.js"></script>
<!-- para usar botones en datatables JS -->
<script src="../plugins/datatables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>
<script src="../plugins/datatables/JSZip-2.5.0/jszip.min.js"></script>
<script src="../plugins/datatables/pdfmake-0.1.36/pdfmake.min.js"></script>
<script src="../plugins/datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
<script src="../plugins/datatables/Buttons-1.5.6/js/buttons.html5.min.js"></script>