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
        text: "¡Lo sentimos! El producto ya existe",
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



    $sqltabla = "select nombre_producto,descripcion_producto,stock_minimo FROM tbl_productos";
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


$Id_objeto = 196;
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

  bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INGRESO', 'A GESTION PRODUCTOS');



  if (permisos::permiso_modificar($Id_objeto) == '1') {
    $_SESSION['btn_modificar_producto'] = "";
  } else {
    $_SESSION['btn_modificar_producto'] = "disabled";
  }


  /* Manda a llamar todos las datos de la tabla para llenar el gridview  */
  $sqltabla = "select nombre_producto,descripcion_producto FROM tbl_productos";
  $resultadotabla = $mysqli->query($sqltabla);



  /* Esta condicion sirve para  verificar el valor que se esta enviando al momento de dar click en el icono modificar */
  if (isset($_GET['nombre_producto'])) {
    $sqltabla = "select nombre_producto,descripcion_producto FROM tbl_productos";

    $resultadotabla = $mysqli->query($sqltabla);

    /* Esta variable recibe el producto a modificar */
    $nombre_producto = $_GET['nombre_producto'];

    /* Iniciar la variable de sesion y la crea */
    /* Hace un select para mandar a traer todos los datos de la 
 tabla donde producto sea igual al que se ingreso en el input */
    $sql = "select * FROM tbl_productos WHERE nombre_producto = '$nombre_producto'";
    $resultado = $mysqli->query($sql);
    /* Manda a llamar la fila */
    $row = $resultado->fetch_array(MYSQLI_ASSOC);

    /* Aqui obtengo el id<-productos de la tabla de la base el cual me sirve para enviarla a la pagina actualizar.php para usarla en el where del update   */

    //         variable               viene de la BD
    $_SESSION['id_producto_'] = $row['id_producto'];
    $_SESSION['nombre_producto_'] = $row['nombre_producto'];
    $_SESSION['descripcion_producto_'] = $row['descripcion_producto'];
    //     $_SESSION['stock_minimo_'] = $row['stock_minimo'];


    /*Aqui levanto el modal*/

    if (isset($_SESSION['nombre_producto_'])) {


?>
      <script>
        $(function() {
          $('#modal_modificar_producto').modal('toggle')

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
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js">
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


            <h1>Gestión de Productos
            </h1>
          </div>

          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item active"><a href="crear_productos_vista.php">Nuevo Producto</a></li>
            </ol>
          </div>

          <div class="RespuestaAjax"></div>

        </div>
      </div><!-- /.container-fluid -->
    </section>


    <!--Parte central del formulario-->
    <div class="card card-default">
      <div class="card-header">
        <h3 class="card-title">Productos Existentes</h3>
        <div class="card-tools">

          <!-- <button type="button" class=" my-3 btn btn-secondary btn-inline p-2 mr-2">Generar pdf</button> -->
          <!-- <a href="crear_productos_vista.php" class=" my-3 btn btn-primary btn-inline p-2 "  >Nuevo</a> -->

          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
        <br>
        <div class=" px-12">

        </div>
      </div>
      <div class="card-body">
        <div class="mb-3">
          <a href="crear_productos_vista.php" class=" btn btn-success btn-inline float-right mt-2"><i class="fas fa-plus pr-2"></i>Nuevo</a>
          <!-- <input type="text" class="float-right mt-2"> -->
        </div>


        <!-- NOMBRE DE LA TABLA QUE ALOJA LOS PRODUCTOS -->
        <table id="tblproducto" class="table table-bordered table-striped">



          <thead>
            <tr>
              <th>NOMBRE</th>
              <th>DESCRIPCION</th>
              <th>MODIFICAR</th>
              <th>ELIMINAR</th>
              <th>REPORTE</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $resultadotabla->fetch_array(MYSQLI_ASSOC)) { ?>
              <tr>
                <td><?php echo $row['nombre_producto']; ?></td>
                <td><?php echo $row['descripcion_producto']; ?></td>
                <!-- editar -->
                <td style="text-align: center;">

                  <a href="../vistas/editar_producto_vista.php?nombre_producto=<?php echo $row['nombre_producto']; ?>" class="btn btn-primary btn-raised btn-xs">
                    <i class="far fa-edit" style="display:<?php echo $_SESSION['modificar_producto'] ?> "></i>
                  </a>

                </td>
                <!-- eliminar -->
                <td style="text-align: center;">

                  <form action="../Controlador/eliminar_producto_controlador.php?nombre_producto=<?php echo $row['nombre_producto']; ?>" method="POST" class="FormularioAjax" data-form="delete" autocomplete="off">
                    <button type="submit" class="btn btn-danger btn-raised btn-xs">

                      <i class="far fa-trash-alt" style="display:<?php echo $_SESSION['eliminar_producto'] ?> "></i>
                    </button>
                    <div class="RespuestaAjax"></div>
                  </form>
                </td>
                <!-- reporte -->
                <td style="text-align: center;">

                  <a href="../pdf_laboratorio/reporte_producto_lab.php?nombre_producto=<?php echo $row['nombre_producto']; ?>" target="_black" class="btn btn-primary btn-raised btn-xs">

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


  <!-- <script type="text/javascript" language="javascript">
    function ventana() {
      window.open("../Controlador/reporte__controlador.php", "REPORTE");
    }
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