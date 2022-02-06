<?php
ob_start();

session_start();

require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');


//$Producto=$_GET["nombre_producto"];
$adquisicion = $_SESSION['id'];
echo $adquisicion;


//Lineas de msj al cargar pagina de acuerdo a actualizar o eliminar datos
if (isset($_REQUEST['msj'])) {
  // $Producto=$_GET['nombre'];

  $msj = $_REQUEST['msj'];

  if ($msj == 1) {
    echo '<script type="text/javascript">
    swal({
        title: "",
        text: "Lo sentimos el número de inventario ya existe",
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
        text: "Agregado con exito",
        type: "success",
        showConfirmButton: false,
        timer: 3000
    });
   

</script>';




    // $sql = "SELECT MAX(id_adquisicion) as id_adquisicion FROM tbl_adquisiciones";
    // $resultado = $mysqli->query($sql);
    // $row = $resultado->fetch_array(MYSQLI_ASSOC);
    // $id_adquisicion=$row['id_adquisicion'];




    /* Manda a llamar todos las datos de la tabla para llenar el gridview  */
    $sqltabla = "SELECT a.id_detalle,c.nombre_producto as nombre_producto,a.numero_inventario FROM tbl_detalle_adquisiciones a INNER JOIN tbl_productos c ON a.id_producto=c.id_producto and a.id_adquisicion = $adquisicion";

    $resultadotabla = $mysqli->query($sqltabla);
  }
  if ($msj == 3) {


    echo '<script type="text/javascript">
    swal({
        title: "",
        text: "Error al crear lo sentimos, intente de nuevo.",
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
        text: "Lo sentimos tiene campos por rellenar.",
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
        text: "Error al actualizar lo sentimos,intente de nuevo.",
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
        text: "Los datos se almacenaron correctamente",
        type: "success",
        showConfirmButton: false,
        timer: 3000
    });
</script>';
  }

  if ($msj == 8) {


    echo '<script type="text/javascript">
  swal({
      title:"",
      text: "Valor actualizado exitosamente",
      type: "success",
      showConfirmButton: false,
      timer: 800
  });


</script>';
  }


  if ($msj == 9) {


    echo '<script type="text/javascript">
  swal({
          title: "",
          text: "Valor no actualizado.",
          type: "error",
          showConfirmButton: false,
          timer: 1000
      });
   
  
  </script>';
  }

  if ($msj == 10) {

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


  if ($msj == 11) {


    echo '<script type="text/javascript">
  swal({
      title:"",
      text: "Valor guardado exitosamente",
      type: "success",
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
                                   text:"Lo sentimos no tiene permiso de visualizar la pantalla",
                                   type: "error",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                           window.location = "../vistas/pagina_principal_vista.php";

                            </script>';
} else {

  bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INGRESO', 'A MODIFICAR DETALLE ADQUISICION');



  if (permisos::permiso_modificar($Id_objeto) == '1') {
    $_SESSION['btn_guardar'] = "";
  } else {
    $_SESSION['btn_guardar'] = "disabled";
  }



  ///obtener el id_adquisicion
  // $sql = "SELECT MAX(id_adquisicion) as id_adquisicion FROM tbl_adquisiciones";
  // $resultado = $mysqli->query($sql);
  // $row = $resultado->fetch_array(MYSQLI_ASSOC);
  // $id_adquisicion=$row['id_adquisicion'];


  /* Manda a llamar todos las datos de la tabla para llenar el gridview  */
  $sqltabla = "SELECT a.id_detalle,c.nombre_producto as nombre_producto,a.numero_inventario FROM tbl_detalle_adquisiciones a INNER JOIN tbl_productos c ON a.id_producto=c.id_producto and a.id_adquisicion = $adquisicion";

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
          $('#modal_agregar_caracteristica1').modal('toggle')

        })
      </script>;

      <?php
      ?>

    <?php


    }
  }

  if (isset($_GET['numero_inventario'])) {

    /* Guardar el id_detalle */
    $numero_inventario = $_GET['numero_inventario'];

    /* buscar el id de detalle */
    $sql = "select * FROM tbl_detalle_adquisiciones WHERE numero_inventario  = '$numero_inventario'";
    $resultado = $mysqli->query($sql);
    /* Manda a llamar la fila */
    $row = $resultado->fetch_array(MYSQLI_ASSOC);

    /* Guardar el id_detalle en variable de sesion */
    $_SESSION['numero_inventario_'] = $row['numero_inventario'];
    $_SESSION['id_detalle_'] = $row['id_detalle'];


    /*Aqui levanto el modal*/
    if (isset($_SESSION['numero_inventario_'])) {


    ?>
      <script>
        $(function() {
          $('#modal_agregar_caracteristica2').modal('toggle')

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
    <!-- Content Header  -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1> Detalle Adquisiciones </h1>
          </div>



          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item"><a href="../vistas/gestion_adquisicion_vista.php">Gestión Adquisición</a></li>


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
            <h3 class="card-title">Actualizar Caracteristicas Detalle Adquisición</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
          </div>



          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">


                </form>


                <div class="form-group pt-5" id="tblCaracteristicas1">
                  <!-- /.arrastra este id para mostrar en el data -->
                  <table width="100%" id="tblCaracteristicas" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th> NO. DE INVENTARIO </th>
                        <th> PRODUCTO </th>
                        <th> EDITAR CARACTERÍSTICAS </th>
                        <th> NUEVAS CARACTERÍSTICAS </th>

                      </tr>
                    </thead>
                    <tbody>
                      <?php while ($row = $resultadotabla->fetch_array(MYSQLI_ASSOC)) { ?>
                        <tr>

                          <td><?php echo $row['numero_inventario']; ?></td>
                          <td><?php echo $row['nombre_producto']; ?></td>


                          <!-- caracteristicas -->

                          <td style="text-align: center;">
                            <a href="../vistas/editar_detalle_adquisicion_vista.php?id_detalle=<?php echo $row['id_detalle']; ?>" class="btn btn-primary btn-raised btn-xs">
                              <i class="fas fa-plus" style="display:<?php echo $_SESSION['editar_caracteristica'] ?> "></i>
                            </a>
                          </td>

                          <td style="text-align: center;">
                            <a href="../vistas/editar_detalle_adquisicion_vista.php?numero_inventario=<?php echo $row['numero_inventario']; ?>" class="btn btn-primary btn-raised btn-xs">
                              <i class="fas fa-plus" style="display:<?php echo $_SESSION['agregar_caracteristica'] ?> "></i>
                            </a>
                          </td>



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
                    <form action="../Controlador/finalizar_adquisicion_detalle_actualizado_controlador.php?id_adquisicion=<?php echo $adquisicion ?>" method="POST" class="FormularioAjax" data-form="update" autocomplete="off">
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
  <!-- <form action="../Controlador/actualizar_detalle_controlador.php?id_detalle=<?php  ?>" method="post" data-form="update" autocomplete="off"> -->

  <?php $id_detalle_adquisicion = $_SESSION['id_detalle_'] ?>
  <?php

  //    $sql = "SELECT * from tbl_detalle_caracteristica  where id_detalle_caracteristica= $id_detalle_adquisicion";
  // //  $sql = "call sel_valor($id_detalle_adquisicion)";
  // $resultado = $mysqli->query($sql);
  // /* Manda a llamar la fila */
  // $row = $resultado->fetch_array(MYSQLI_ASSOC);
  // // // $_SESSION['id_detalle_caracteristica_'] = $row['id_detalle_caracteristica'];
  // // // $id_detalle_ca= $_SESSION['id_detalle_caracteristica_'];
  // // //  $prueba = "SELECT valor_caracteristica FROM tbl_detalle_caracteristica WHERE id_detalle_caracteristica= $id_detalle_ca";
  // // //  $resultadoprueba = $mysqli->query($sql);
  // // //           /* Manda a llamar la fila */
  // // // $row= $resultadoprueba->fetch_array(MYSQLI_ASSOC);
  // $_SESSION['valor_'] = $row['valor_caracteristica'];

  // 
  ?>
  <?php $sqltablamodal = "SELECT a.validacion,d.id_detalle_caracteristica,d.valor_caracteristica,a.tipo_caracteristica as caracteristica FROM tbl_tipo_caracteristica a INNER JOIN tbl_detalle_adquisiciones b INNER JOIN tbl_caracteristicas_producto c INNER JOIN tbl_detalle_caracteristica d WHERE  b.id_detalle = '$id_detalle_adquisicion' and b.id_producto = c.id_producto and c.id_tipo_caracteristica = a.id_tipo_caracteristica and b.id_detalle=d.id_detalle and c.id_caracteristica_producto=d.id_caracteristica_producto";

  $resultadotablamodal = $mysqli->query($sqltablamodal);



  ?>



  <div class="modal fade" id="modal_agregar_caracteristica1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"> Editar Características </h4>
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
                <th> VALOR </th>



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

                    <form action="../Controlador/actualizar_valor_controlador.php?id_detalle_caracteristica=<?php echo $row['id_detalle_caracteristica']; ?>" method="POST" data-form="save" autocomplete="off">




                      <input class="form-control " <?php echo $_SESSION['validacion']; ?> required type="text" id="txt_valor" name="txt_valor" maxlength="100" value="<?php echo $row['valor_caracteristica']; ?>" style="text-transform: uppercase" onkeyup="DobleEspacio(this, event)" ;>

                      <div class="btn-group" style="padding: 8px;">
                        <button type="submit" class="btn btn-success">
                          <i class="far fa-check-circle" style="display:<?php echo $_SESSION['editar_valor_caracteristica'] ?> ">ACTUALIZAR VALOR DE <?php echo $row['caracteristica'] ?></i>
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
          <a href="../vistas/editar_detalle_adquisicion_vista.php"><button a type="submit" class="btn btn-primary" id="btn_guardar_tipo_caracteristica" name="modal_guardar_tipocaracteristica" <?php echo $_SESSION['btn_guardar'] ?>>Finalizar</button></a>


        </div>
      </div>

      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>

  <!-- /.  finaldel modal -->
  <!-- </form> -->

  <?php $sqltablamodalnueva = "SELECT a.validacion,a.tipo_caracteristica as caracteristica FROM tbl_tipo_caracteristica a INNER JOIN tbl_detalle_adquisiciones b INNER JOIN tbl_caracteristicas_producto c WHERE
                                    b.id_detalle = $id_detalle_adquisicion and b.id_producto = c.id_producto and c.id_tipo_caracteristica = a.id_tipo_caracteristica";

  $resultadotablamodalnueva = $mysqli->query($sqltablamodalnueva);

  ?>

  <div class="modal fade" id="modal_agregar_caracteristica2">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Valor Características </h4>
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
                <th> VALOR </th>



              </tr>
            </thead>
            <tbody>
              <?php while ($row = $resultadotablamodalnueva->fetch_array(MYSQLI_ASSOC)) { ?>
                <tr>





                  <?php
                  if ($row['validacion'] == '1') {
                    $_SESSION['validacion'] = 'onkeypress="return validacion_para_nombre(event)"';
                  } elseif ($row['validacion'] == '2') {
                    $_SESSION['validacion'] = 'onkeypress="return solonumeros(event)"';
                  } elseif ($row['validacion'] == '3') {
                    $_SESSION['validacion'] = 'onkeypress="return validacion_para_numero_inventario(event)"';
                  }

                  ?>
                  <?php

                  $caracteristica = $row['caracteristica'];
                  $_SESSION['validacion'] = '';


                  $sqlnuevo = "select COUNT(a.id_detalle_caracteristica) as id_detalle_caracteristica  from tbl_detalle_caracteristica a INNER JOIN tbl_tipo_caracteristica b INNER JOIN tbl_caracteristicas_producto c where b.tipo_caracteristica='$caracteristica' and a.id_detalle='$id_detalle_adquisicion' and c.id_caracteristica_producto=a.id_caracteristica_producto and b.id_tipo_caracteristica=c.id_tipo_caracteristica";
                  $resultadonuevo = $mysqli->query($sqlnuevo);
                  $row = $resultadonuevo->fetch_array(MYSQLI_ASSOC);
                  $contadornuevo = $row['id_detalle_caracteristica'];

                  if ($contadornuevo == 0) {




                  ?>

                    <td><?php echo $caracteristica ?></td>



                    <!-- GUARDAR LA CARACTERISTICA -->
                    <td style="text-align: center;" class="inline-block">

                      <form action="../Controlador/nuevo_valor_caracteristica_controlador.php?caracteristica=<?php echo $caracteristica ?>" method="POST" data-form="save" autocomplete="off">




                        <input class="form-control " <?php echo $_SESSION['validacion']; ?> required type="text" id="txt_valor" name="txt_valor" maxlength="100" style="text-transform: uppercase" onkeyup="DobleEspacio(this, event)" ;>

                        <div class="btn-group" style="padding: 8px;">
                          <button type="submit" class="btn btn-primary">
                            <i class="far fa-check-circle" style="display:<?php echo $_SESSION['guardar_valor_caracteristica'] ?> "> GUARDAR VALOR DE <?php echo $caracteristica ?></i>
                          </button>

                        </div>



                        <div class="RespuestaAjax"></div>
                      </form>

                    </td>
                  <?php } ?>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>




        <!--Footer del modal-->
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <a href="../vistas/editar_detalle_adquisicion_vista.php"><button a type="submit" class="btn btn-primary" id="btn_guardar_tipo_caracteristica" name="modal_guardar_tipocaracteristica" <?php echo $_SESSION['btn_guardar'] ?>>Finalizar</button></a>


        </div>
      </div>

      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>




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