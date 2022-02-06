<?php
ob_start();

session_start();

require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/conexion_mantenimientos.php');
require_once "../Modelos/detalle_existencias_modelo.php";
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');

$Id_objeto = 217;
$visualizacion = permiso_ver($Id_objeto);

if (isset($_REQUEST['msj'])) {
  // $Producto=$_GET['nombre'];

  $msj = $_REQUEST['msj'];

  if ($msj == 1) {
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
                                                text:"Lo sentimos tiene campos por rellenar",
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
      text:"La cantidad solamente puede contener numeros",
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
                                                text:"Lo sentimos tiene campos por rellenar",
                                                type: "error",
                                                showConfirmButton: false,
                                                timer: 3000
                                              });
                                          </script>';
  }



  if ($msj == 6) {

    echo '<script type="text/javascript">
                                              swal({
                                                title:"",
                                                text:"La cantidad debe ser menor o igual a la existencia",
                                                type: "error",
                                                showConfirmButton: false,
                                                timer: 3000
                                              });
                                          </script>';
  }
}








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
                           window.location = "../vistas/pagina_principal_vista.php";

                            </script>';
} else {



  /* Manda a llamar todos las datos de la tabla para llenar el gridview  */
  bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'Ingreso', 'A transaccion');
  $sqltabla = "call sel_transacciones_kardex()";
  $resultadotabla = $mysqli->query($sqltabla);
}

ob_end_flush();


?>
<!DOCTYPE html>
<html>

<head>
  <script src="../js/autologout.js"></script>
  <link rel="stylesheet" type="text/css" href="../plugins/datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
  <link rel=" stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js">
</head>


<body>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">


            <h1>Transacciones
            </h1>
          </div>

          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <!-- <li class="breadcrumb-item active"><a href="../vistas/menu_mantenimiento_laboratorio.php">Menu Mantenimiento</a></li> -->
              <!-- <li class="breadcrumb-item active"><a href="../vistas/mantenimiento_crear_tipo_caracteristica_vista.php">Nuevo Tipo Característica</a></li> -->
            </ol>
          </div>

          <div class="RespuestaAjax"></div>

        </div>
      </div><!-- /.container-fluid -->
    </section>


    <!--Pantalla 2-->

    <div class="card card-default">
      <div class="card-header">
        <!-- <h3 class="card-title">Transacciones</h3> -->
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
        <br>
        <div class=" px-12">
          <!-- <button class="btn btn-success "> <i class="fas fa-file-pdf"></i> <a style="font-weight: bold;" onclick="ventana()">Exportar a PDF</a> </button> -->
        </div>
      </div>
      <div class="card-body">



        <div style="padding: 6px;"><button data-toggle="modal" data-target="#nueva_transaccion" class=" btn btn-success btn-inline float-right mt-0"><i class="fas fa-plus pr-2"></i>Nueva Transacción</button></div>
        <table id="tblTransaccion_kardex" class="table table-bordered table-striped">


          <!-- m  -->
          <thead>
            <tr>
              <!-- <th>NO</th> -->
              <th>NOMBRE PRODUCTO</th>
              <th>TIPO TRANSACCIÓN</th>



              <th>CANTIDAD</th>
              <th>FECHA</th>
            </tr>
          </thead>
          <tbody>
            <?php $acum = 0; ?>
            <?php while ($row = $resultadotabla->fetch_array(MYSQLI_ASSOC)) { ?>
              <tr>
                <!-- <?php $acum = $acum + 1; ?> -->
                <!-- <td><?php echo $acum; ?></td> -->
                <td><?php echo $row['nombre_producto']; ?></td>

                <td><?php echo $row['tipo_transaccion']; ?></td>

                <td><?php echo $row['cantidad']; ?></td>
                <td><?php echo $row['fecha_transaccion']; ?></td>



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

  <form action="../Controlador/guardar_transaccion_controlador.php" method="post" autocomplete="off">
    <div class="modal fade" id="nueva_transaccion">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Nueva Transacción</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">

            </button>
          </div>


          <!--Cuerpo del modal-->
          <div class="modal-body">

            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">

                    <label>Tipo Transacción</label>

                    <select class="form-control" name="cb_tipo_transaccion" id="cb_tipo_transaccion" onchange="">
                      <option value="0">Seleccione una opción:</option>
                      <option value="3">ENTRADA</option>
                      <option value="2">SALIDA</option>

                    </select>





                    <label>Productos</label>
                    <select class="form-control" name="cb_producto" onchange="" required="">
                      <option value="">Seleccione el producto:</option>
                      <?php


                      $modelo = new respuesta();
                      $query = $modelo->transaccion();

                      // $servidor= "localhost";
                      // $usuario= "root";
                      // $password = "";
                      // $base= "informat_desarrollo_automatizacion";

                      // $mysqli2 = new mysqli($servidor,$usuario,$password,$base);

                      // $query = $mysqli2->query("SELECT * FROM tbl_productos where id_tipo_producto='2'");
                      while ($resultado = mysqli_fetch_array($query)) {
                        echo '<option value="' . $resultado['id_producto'] . '"> ' . $resultado['nombre_producto'] . '</option>';
                      }
                      ?>
                    </select>




                    <label>Cantidad</label>
                    <input class="form-control" type="text" id="txt_cantidad" name="txt_cantidad" required style="text-transform: uppercase" onkeyup="DobleEspacio(this, event); MismaLetra('txt_genero');" onkeypress="return solonumeros(event)" maxlength="30">



                  </div>


                </div>
              </div>
            </div>

          </div>




          <!--Footer del modal-->
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary" id="btn_modificar_genero" name="btn_modificar_genero">Guardar</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>

    <div class="RespuestaAjax"></div>

  </form>







  <!-- <script type="text/javascript" language="javascript">
    function ventana() {
      window.open("../Controlador/reporte_mantenimiento_tipocaracteristicaes_controlador.php", "REPORTE");
    }
  </scrip> -->


  <!-- <script type="text/javascript">
    $(function() {

      $('#tblCaracteristica').DataTable({
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