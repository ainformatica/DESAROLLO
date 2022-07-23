<?php
ob_start();

session_start();

require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');

//Lineas de msj al cargar pagina de acuerdo a actualizar o eliminar datos
// if (isset($_REQUEST['msj'])) {
//   $msj = $_REQUEST['msj'];

//   if ($msj == 1) {
//     echo '<script type="text/javascript">
//     swal({
//         title: "",
//         text: "¡Lo sentimos! El tipo adquisición ya existe",
//         type: "info",
//         showConfirmButton: false,
//         timer: 3000
//     });
// </script>';
//   }

//   if ($msj == 2) {


//     echo '<script type="text/javascript">
//     swal({
//         title: "",
//         text: "Los datos se almacenaron correctamente",
//         type: "success",
//         showConfirmButton: false,
//         timer: 3000
//     });
// </script>';



//     $sqltabla = "select tipo_adquisicion FROM tbl_tipo_adquisicion";
//     $resultadotabla = $mysqli->query($sqltabla);
//   }
//   if ($msj == 3) {


//     echo '<script type="text/javascript">
//     swal({
//         title: "",
//         text: "¡Lo sentimos! Error al actualizar, intente de nuevo.",
//         type: "error",
//         showConfirmButton: false,
//         timer: 3000
//     });
// </script>';
//   }
// }


$Id_objeto = 206;
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
                           window.location = "../vistas/pagina_principal_vista.php";

                            </script>';
} else {

  bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INGRESO', 'A REPORTES DE EXISTENCIAS');



  if (permisos::permiso_modificar($Id_objeto) == '1') {
    $_SESSION['ver_detalle_existencias'] = "";
  } else {
    $_SESSION['ver_detalle_existencias'] = "disabled";
  }


  /* Manda a llamar todos las datos de la tabla para llenar el gridview  */
  $sqltabla = "SELECT  p.id_tipo_producto as tipo_producto, p.stock_minimo as stock, inv.id_inventario as id_inventario, p.id_producto as id_producto, p.nombre_producto as nombre_producto, inv.existencia as existencia FROM tbl_inventario inv INNER JOIN 
    tbl_productos p ON inv.id_producto=p.id_producto";

  $resultadotabla = $mysqli->query($sqltabla);



  /* Esta condicion sirve para  verificar el valor que se esta enviando al momento de dar click en el icono modicar */
  if (isset($_GET['tipo_adquisicion'])) {
    $sqltabla = "SELECT  p.id_tipo_producto as tipo_producto, p.stock_minimo as stock, inv.id_inventario as id_inventario, p.id_producto as id_producto, p.nombre_producto as nombre_producto, inv.existencia as existencia FROM tbl_inventario inv INNER JOIN 
    tbl_productos p ON inv.id_producto=p.id_producto";

    $resultadotabla = $mysqli->query($sqltabla);

    /* Esta variable recibe el estado de modificar */
    $tipo_adquisicion = $_GET['tipo_adquisicion'];

    /* Iniciar la variable de sesion y la crea */
    /* Hace un select para mandar a traer todos los datos de la 
 tabla donde rol sea igual al que se ingreso en el input */
    $sql = "SELECT  p.id_tipo_producto as tipo_producto, p.stock_minimo as stock, inv.id_inventario as id_inventario, p.id_producto as id_producto, p.nombre_producto as nombre_producto, inv.existencia as existencia FROM tbl_inventario inv INNER JOIN 
    tbl_productos p ON inv.id_producto=p.id_producto";

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


            <h1>Consulta - Existencias</h1>
          </div>

          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item active"><a href="../vistas/reportes_existencias_vista.php">Consulta Existencias</a></li>
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
        <h3 class="card-title"></h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
        <br>
        <!-- <div class=" px-12"> -->
        <!-- <a target="_blank" href="../pdf/reporte_existencias_lab.php" class="btn btn-warning" id="btnreporte"><i class="fa fa-file-pdf-o" ></i> Generar Reporte</a> -->

        <!-- <button class="btn btn-success "> <i class="fas fa-file-pdf"></i> <a style="font-weight: bold;" onclick="ventana()">Exportar a PDF</a> </button> -->
        <!-- </div> -->
      </div>

      <div class="card-body">
        <!-- <div style="padding: 2px;"><a href="mantenimiento_crear_tipoadquisicion_vista.php" class=" btn btn-success btn-inline float-right mt-0" ><i class="fas fa-plus pr-2"></i>Nuevo</a></div> -->
        <table id="tblReporte_existencias" class="table table-bordered table-striped">



          <thead>
            <tr>
              <!-- <th>NO.</th> -->
              <th>PRODUCTO</th>
              <th>EXISTENCIAS</th>
              <th>DETALLE DEL PRODUCTO</th>
              <th>ADVERTENCIA</th>
            </tr>
          </thead>
          <tbody>
            <?php $acum = 0; ?>
            <?php while ($row = $resultadotabla->fetch_array(MYSQLI_ASSOC)) { ?>
              <?php $acum += 1; ?>
              <tr>
                <!-- <td><?php echo $acum; ?></td> -->
                <td><?php echo $row['nombre_producto']; ?></td>

                <td><?php echo $row['existencia']; ?></td>

                <td style="text-align: center;">
                  <a style="font-size:14px;" href="../vistas/reportes_detalle_existencias_vista.php?id_producto=<?php echo $row['id_producto']; ?>" class="btn btn-primary px-3 py-0 ">
                    <!-- <i class="far fa-edit" style="display:<?php echo $_SESSION['ver_detalle_existencias'] ?> "></i> -->
                    Ver más
                  </a>
                </td>
                <td style="text-align: center; ">
                  <?php if ($row['existencia'] <= $row['stock']) { ?>
                    <div class=" btn btn-danger px-5 py-0">
                      <div style="font-size:14px;">Escaso</div>
                    </div>

                  <?php } elseif ($row['stock'] == '0' and $row['tipo_producto'] == 1) { ?>
                    <div class=" btn btn-secondary px-4 py-0" style="font-size:14px;">
                      Almacenable
                    </div>


                  <?php } else { ?>
                    <div class=" btn btn-success px-5 py-0">
                      <div style="font-size:14px;">Óptimo</div>
                    </div>
                  <?php } ?>
                </td>








              </tr>
            <?php } ?>
          </tbody>
        </table>

        <!-- <div class="modal-footer justify-content-between"> -->
        <!-- <button type="submit" class="btn btn-danger float-right mt-3" id="btn_cancelar_ubicacion" name="btn_cancelar_ubicacion" <?php echo $_SESSION['btn_cancelar_ubicacion']; ?>>Cancelar</button> -->
        <!-- </div> -->

      </div>
      <!-- /.card-body -->
    </div>


    <!-- /.card-body -->
    <div class="card-footer">

    </div>
  </div>









  <!-- <script type="text/javascript">
    $(function() {

      $('#tblReporte_existencias').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
        "language": {
            "url": "../plugins/lenguaje.json"
        },
      });
    });
  </script> -->


</body>

</html>


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