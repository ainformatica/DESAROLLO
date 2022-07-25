<?php
ob_start();

session_start();

require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');

//$Producto=$_GET["nombre_producto"];
//$Producto=$_SESSION['nombrePrueba'];


if (empty($_SESSION['id_detalle_'])) {
  $_SESSION['id_detalle_'] = "";
}

//Lineas de msj al cargar pagina de acuerdo a actualizar o eliminar datos
if (isset($_REQUEST['msj'])) {
  // $Producto=$_GET['nombre'];

  $msj = $_REQUEST['msj'];

  if ($msj == 1) {
    echo '<script type="text/javascript">
    swal({
        title: "",
        text: "¡Lo sentimos! El número de inventario ya existe",
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
        text: "Agregado con éxito",
        type: "success",
        showConfirmButton: false,
        timer: 3000
    });
   

</script>';




    $sql = "SELECT MAX(id_adquisicion) as id_adquisicion FROM tbl_adquisiciones";
    $resultado = $mysqli->query($sql);
    $row = $resultado->fetch_array(MYSQLI_ASSOC);
    $id_adquisicion = $row['id_adquisicion'];


    /* Manda a llamar todos las datos de la tabla para llenar el gridview  */
    $sqltabla = "SELECT a.id_detalle,c.nombre_producto as nombre_producto,a.numero_inventario FROM tbl_detalle_adquisiciones a INNER JOIN tbl_productos c ON a.id_producto=c.id_producto and a.id_adquisicion = $id_adquisicion";

    $resultadotabla = $mysqli->query($sqltabla);
  }
  if ($msj == 3) {


    echo '<script type="text/javascript">
    swal({
        title: "",
        text: "¡Lo sentimos! Error al crear, intente de nuevo.",
        type: "error",
        showConfirmButton: false,
        timer: 3000
    });

</script>';
  }
  if ($msj == 4) {


    echo '<script type="text/javascript">
    swal({
        title: "",
        text: "¡Lo sentimos! Tiene campos por rellenar.",
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
                                   text:"Los datos se eliminaron correctamente",
                                   type: "success",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                                
                                
                            </script>';
  }


  if ($msj == 6) {


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

  if ($msj == 7) {


    echo '<script type="text/javascript">
    swal({
        title: "",
        text: "Valor guardado exitosamente",
        type: "success",
        showConfirmButton: false,
        timer: 800
    });
</script>';
  }
  if ($msj == 8) {
    echo '<script type="text/javascript">
  swal({
    title:"",
    text:"Caracteres no válidos",
    type: "error",
    showConfirmButton: false,
    timer: 1000
  });
</script>';
  }


  if ($msj == 9) {
    echo '<script type="text/javascript">
  swal({
  title:"",
  text:"¡Lo sentimos! Esta característica ya tiene su valor",
  type: "error",   
  showConfirmButton: false,
  timer: 1000
  });
</script>';
  }


  if ($msj == 10) {
    echo '<script type="text/javascript">
    swal({
        title: "",
        text: "Características guardadas exitosamente",
        type: "success",
        showConfirmButton: false,
        timer: 800
    });
</script>';
  }

  if ($msj == 11) {

    echo '<script type="text/javascript">
    swal({
    title:"",
    text:"Aún hay características sin guardar",
    type: "error",   
    showConfirmButton: false,
    timer: 1000
    });
  </script>';
  }
}

$Id_objeto = 218;
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

  bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INGRESO', 'A CREAR DETALLE ADQUISICION');



  if (permisos::permiso_insertar($Id_objeto) == '1') {
    $_SESSION['btn_guardar'] = "";
  } else {
    $_SESSION['btn_guardar'] = "disabled";
  }



  ///obtener el id_adquisicion
  $sql = "SELECT MAX(id_adquisicion) as id_adquisicion FROM tbl_adquisiciones";
  $resultado = $mysqli->query($sql);
  $row = $resultado->fetch_array(MYSQLI_ASSOC);
  $id_adquisicion = $row['id_adquisicion'];


  /* Manda a llamar todos las datos de la tabla para llenar el gridview  */
  $sqltabla = "SELECT a.id_detalle,c.nombre_producto as nombre_producto,a.numero_inventario FROM tbl_detalle_adquisiciones a INNER JOIN tbl_productos c ON a.id_producto=c.id_producto and a.id_adquisicion = $id_adquisicion";

  $resultadotabla = $mysqli->query($sqltabla);



  /* Esta condicion sirve para  verificar el valor que se esta enviando al momento de dar click en el icono caracteristicas */
  if (isset($_GET['id_detalle'])) {

    /* Guardar el id_detalle */
    $id_detalle = $_GET['id_detalle'];

    /* buscar el id de detalle */
    $sql = "select * FROM tbl_detalle_adquisiciones WHERE id_detalle = '$id_detalle'";
    $resultado = $mysqli->query($sql);
    /* Manda a llamar la fila */
    $row = $resultado->fetch_array(MYSQLI_ASSOC);

    /* Guardar el id_detalle en variable de sesion */
    $_SESSION['id_detalle_'] = $row['id_detalle'];

    /*Aqui levanto el modal*/
    if (isset($_SESSION['id_detalle_'])) {


?>
      <script>
        $(function() {
          $('#modal_agregar_caracteristica').modal('toggle')

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
  <title></title>



</head>

<body>


  <div class="content-wrapper" id="formulariocaracteristicas">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Adquisiciones </h1>
          </div>



          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item"><a href="../vistas/gestion_adquisicion_vista.php">Gestión de Adquisición</a></li>


            </ol>
          </div>

          <div class="RespuestaAjax"></div>

        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">



        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Detalle de la Adquisición</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
          </div>



          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">

                <div id="formulariocaracteristicas1">
                  <form name="formularioCaracteristicas" action="../Controlador/guardar_detalle_adquisicion_controlador.php" id="formularioCaracteristicas" data-form="save" method="POST">




                    <!-- <div class="col-sm-12"> -->
                    <div class="form-group my-1">
                      <label class="">Producto Ingresado: </label>

                      <!-- <input type="hidden" name="txt_nombre_producto" id="txt_nombre_producto" class=""> -->
                      <select class="form-control select2 mr-3" style="height:38px; width:708px;" name="cmb_producto" required="">
                        <option value="0">Seleccione el Producto:</option>
                        <?php
                        $query = $mysqli->query("SELECT * FROM tbl_productos where id_tipo_producto = 1");
                        while ($resultado = mysqli_fetch_array($query)) {
                          echo '<option value="' . $resultado['id_producto'] . '"> ' . $resultado['nombre_producto'] . '</option>';
                        }
                        ?>
                      </select>

                    </div>




                    <div class="form-inline">
                      <div class="form-group my-1" style="padding: 5px;">
                        <div class="form-group my-1" style="padding: 1px;"> <label>Ingrese el Número de Inventario</label></div>
                        <!-- <input class="form-control " required type="text" id="txt_numero" name="txt_numero" maxlength="100" style="text-transform: uppercase" onkeyup="DobleEspacio(this, event)";> -->
                        <input class="form-control " class="tf w-input" required type="text" id="txt_numero" onkeypress="return validacion_para_numero_inventario(event)" name="txt_numero" maxlength="100" style="text-transform: uppercase" onkeyup="DobleEspacio(this, event);">

                      </div>

                      <div class="" style="height:38px; width:358px;">
                        <button type="submit" class="btn btn-primary" id="btn_guardar" name="btn_guardar <?php echo $_SESSION['btn_guardar']; ?>><i class=" zmdi zmdi-floppy"></i> Agregar</button>

                        <!-- <button type="button" class=" ml-3  btn btn-inline btn-primary form-control" name="add" id="gcorreotel" data-toggle="modal" data-target="#modal_guardar_tipocaracteristica"><i class="fas fa-plus"></i></button> -->
                      </div>

                    </div>
                    <!-- </div> -->



                  </form>


                  <div class="form-group pt-5" id="tblCaracteristicas1">
                    <!-- /.arrastra este id para mostrar en el data -->
                    <table width="100%" id="tblCaracteristicas" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th> NO. DE INVENTARIO </th>
                          <th> PRODUCTO </th>
                          <th> CARACTERÍSTICAS </th>
                          <th> ELIMINAR </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php while ($row = $resultadotabla->fetch_array(MYSQLI_ASSOC)) { ?>
                          <tr>

                            <td><?php echo $row['numero_inventario']; ?></td>
                            <td><?php echo $row['nombre_producto']; ?></td>


                            <!-- caracteristicas -->

                            <td style="text-align: center;">
                              <a href="../vistas/crear_detalle_adquisicion_vista.php?id_detalle=<?php echo $row['id_detalle']; ?>" class="btn btn-primary btn-raised btn-xs">
                                <i class="fas fa-plus" style="display:<?php echo $_SESSION['agregar_caracteristica'] ?> "></i>
                              </a>
                            </td>


                            <!-- eliminar -->
                            <td style="text-align: center;">

                              <form action="../Controlador/eliminar_detalle_controlador.php?numero_inventario=<?php echo $row['numero_inventario']; ?>" method="POST" class="FormularioAjax" data-form="delete" autocomplete="off">
                                <button type="submit" class="btn btn-danger btn-raised btn-xs">

                                  <i class="far fa-trash-alt" style="display:<?php echo $_SESSION['eliminar_detalle'] ?> "></i>
                                </button>
                                <div class="RespuestaAjax"></div>
                              </form>
                            </td>


                          </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>



                  <!-- Botones para guardar y CANCELAR -->
                  <div class="btn-group">
                    <p class="text-center">
                    <div class="form-group">
                      <form action="../Controlador/cancelar_detalle_controlador.php?id_adquisicion=<?php echo $row['id_adquisicion']; ?>" method="POST" class="FormularioAjax" data-form="delete" autocomplete="off">
                        <button class="btn btn-danger" type="submit">Cancelar</button>
                        <div class="RespuestaAjax"></div>
                      </form>
                    </div>
                    </p>

                    <p class="text-center">
                    <div class="form-group">
                      <form action="../Controlador/finalizar_adquisicion_detalle_controlador.php?id_adquisicion=<?php echo $row['id_adquisicion']; ?> " method="POST" class="FormularioAjax" autocomplete="off">
                        <button class=" ml-3  btn btn-inline btn-primary form-control" type="submit">Finalizar</button>
                        <div class="RespuestaAjax"></div>
                      </form>
                    </div>
                    </p>
                  </div>
                  <!-- </form> -->
                </div>


              </div>
            </div>
          </div>

        </div>



        <!-- /.card-body -->
        <div class="card-footer">

        </div>
      </div>



      <div class="RespuestaAjax"></div>
      </form>

  </div>
  </section>

  </div>




  <!--comienzo modal-->


  <?php


  $id_detalle_adquisicion = $_SESSION['id_detalle_']; ?>


  <?php

  if ($id_detalle_adquisicion <> "") {

    $sql = "SELECT * from tbl_detalle_caracteristica  where id_detalle= $id_detalle_adquisicion";
    //  $sql = "call sel_valor($id_detalle_adquisicion)";
    $resultado = $mysqli->query($sql);
    /* Manda a llamar la fila */
    $row = $resultado->fetch_array(MYSQLI_ASSOC);
    // // $_SESSION['id_detalle_caracteristica_'] = $row['id_detalle_caracteristica'];
    // // $id_detalle_ca= $_SESSION['id_detalle_caracteristica_'];
    // //  $prueba = "SELECT valor_caracteristica FROM tbl_detalle_caracteristica WHERE id_detalle_caracteristica= $id_detalle_ca";
    // //  $resultadoprueba = $mysqli->query($sql);
    // //           /* Manda a llamar la fila */
    // // $row= $resultadoprueba->fetch_array(MYSQLI_ASSOC);
    $_SESSION['valor_'] = $row['valor_caracteristica'];
  }

  // 
  ?>

  <?php $sqltablamodal = "SELECT a.validacion,a.tipo_caracteristica as caracteristica  FROM tbl_tipo_caracteristica a INNER JOIN tbl_detalle_adquisiciones b INNER JOIN tbl_caracteristicas_producto c WHERE
                                    b.id_detalle = $id_detalle_adquisicion and b.id_producto = c.id_producto and c.id_tipo_caracteristica = a.id_tipo_caracteristica";

  $resultadotablamodal = $mysqli->query($sqltablamodal);





  ?>



  <div class="modal fade" data-backdrop="static" id="modal_agregar_caracteristica">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"> Características </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>


        <!--Cuerpo del modal-->
        <div class="form-group pt-5" id="tblCaracteristicas1">
          <!-- /.arrastra este id para mostrar en el data -->
          <table width="100%" id="tblCaracteristicas" class="table table-bordered table-striped">
            <thead>
              <tr>

                <th> NOMBRE </th>
                <th> VALOR DE LA CARACTERÍSTICA </th>



              </tr>
            </thead>
            <tbody>
              <?php while ($row = $resultadotablamodal->fetch_array(MYSQLI_ASSOC)) { ?>
                <tr>
                  <td><?php echo $row['caracteristica']; ?></td>


                  <?php
                  if ($row['validacion'] == '1') {
                    $_SESSION['validacion'] = 'onkeypress="return validacion_para_nombre(event)"';
                  } elseif ($row['validacion'] == '2') {
                    $_SESSION['validacion'] = 'onkeypress="return solonumeros(event)"';
                  } elseif ($row['validacion'] == '3') {
                    $_SESSION['validacion'] = 'onkeypress="return validacion_para_numero_inventario(event)"';
                  }

                  ?>
                  <!-- GUARDAR LA CARACTERISTICA -->
                  <td style="text-align: center;" class="inline-block">

                    <form action="../Controlador/guardar_valor_caracteristica_controlador.php?caracteristica=<?php echo $row['caracteristica']; ?>" method="POST" data-form="save" autocomplete="off">




                      <input class="form-control " <?php echo $_SESSION['validacion']; ?> required type="text" id="txt_valor" name="txt_valor" maxlength="100" style="text-transform: uppercase" onkeyup="DobleEspacio(this, event)" ;>


                      <?php
                      $caracteristica = $row['caracteristica'];

                      $sqlboton = "select COUNT(a.id_detalle_caracteristica) as id_detalle_caracteristica  from tbl_detalle_caracteristica a INNER JOIN tbl_tipo_caracteristica b INNER JOIN tbl_caracteristicas_producto c where b.tipo_caracteristica='$caracteristica' and a.id_detalle='$id_detalle_adquisicion' and c.id_caracteristica_producto=a.id_caracteristica_producto and b.id_tipo_caracteristica=c.id_tipo_caracteristica";
                      $resultadoboton = $mysqli->query($sqlboton);
                      $row = $resultadoboton->fetch_array(MYSQLI_ASSOC);
                      $contadorboton = $row['id_detalle_caracteristica'];


                      if ($contadorboton == 1) {
                        $_SESSION['colorboton'] = 'class="btn btn-success"';
                        $_SESSION['textoboton'] = "VALOR GUARDADO";
                      } else {

                        $_SESSION['colorboton'] = 'class="btn btn-primary"';
                        $_SESSION['textoboton'] = "GUARDAR VALOR DE $caracteristica";
                      }


                      ?>
                      <div class="btn-group" style="padding: 8px;">
                        <button type="submit" <?php echo $_SESSION['colorboton']; ?>>
                          <i class="far fa-check-circle" style="display:<?php echo $_SESSION['guardar_valor_caracteristica'] ?> "><?php echo $_SESSION['textoboton'] ?></i>
                        </button>
                      </div>

                      <div class="RespuestaAjax"></div>
                    </form>

                  </td>

                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>




        <!--Footer del modal-->
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

          <form action="../Controlador/finalizar_valores_caracteristicas_controlador.php?id_detalle=<?php echo $id_detalle_adquisicion ?>" method="post" required type="submit" autocomplete="off">
            <button type="submit" class="btn btn-primary" id="btn_guardar_tipo_caracteristica" name="modal_guardar_tipocaracteristica" <?php echo $_SESSION['btn_guardar'] ?>>Finalizar</button>
            <div class="RespuestaAjax"></div>
          </form>

        </div>
      </div>

      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>


  <!-- /.  finaldel modal -->
  <!-- </form> -->




  <script type="text/javascript">
    $(function() {

      $('#tblCaracteristicas').DataTable({
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
  </script>


</body>

</html>


<script type="text/javascript" src="../js/pdf_mantenimientos.js"></script>
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