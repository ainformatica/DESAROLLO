<?php
ob_start();

session_start();

require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');

//TRAER LAS CARACTERISTICAS ANTIGUAS
// $valorsqlcaracteristicas=("SELECT id_tipo_caracteristica from tbl_caracteristicas_producto where id_producto=11;");
// $resultadocaracteristicas = $mysqli->query($valorsqlcaracteristicas);
// print_r ($resultadocaracteristicas);




// while ($row = $resultadocaracteristicas ->fetch_array(MYSQLI_ASSOC)) {

// echo ($row['id_tipo_caracteristica']); 

// }


// $result_valorcaracteristicas = $mysqli->query($valorsqlcaracteristicas);
// $valor_viejo_caracteristicas = $result_valorcaracteristicas->fetch_array(MYSQLI_ASSOC);






//$Producto=$_GET["nombre_producto"];
//RECIBO LA VARIABLE SESSION DEL NOMBRE DEL PRODUCTO
$producto = $_SESSION['producto_enviado'];
//RECIBO LOS DATOS ANTIGUOS DEL PRODUCTO
$Array_viejo = array();
$Array_viejo = $_SESSION['ARRAY_VIEJO'];

//pasar esos valores del array a variables normal
$id = $_SESSION['ARRAY_VIEJO']['id_producto'];
$_nombreviejo = $_SESSION['ARRAY_VIEJO']['nombre_producto'];
$_descripcionviejo = $_SESSION['ARRAY_VIEJO']['descripcion_producto'];
$_stockviejo = $_SESSION['ARRAY_VIEJO']['stock_minimo'];
$_tipoviejo = $_SESSION['ARRAY_VIEJO']['id_tipo_producto'];






//Lineas de msj al cargar pagina de acuerdo a actualizar o eliminar datos
if (isset($_REQUEST['msj'])) {
  // $Producto=$_GET['nombre'];

  $msj = $_REQUEST['msj'];

  if ($msj == 1) {
    echo '<script type="text/javascript">
    swal({
        title: "",
        text: "Lo sentimos la caracteristica ya existe",
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
        text:"Los datos  se almacenaron correctamente",
        type: "success",
        showConfirmButton: false,
        timer: 6000
      });
     
  </script>';




    $sqltabla = ("SELECT TTC.tipo_caracteristica,TTC.id_tipo_caracteristica from tbl_tipo_caracteristica TTC,tbl_caracteristicas_producto TCP,tbl_productos TP where TTC.id_tipo_caracteristica=TCP.id_tipo_caracteristica and TCP.id_producto=TP.id_producto and nombre_producto='$producto'
;");
    $resultadotabla = $mysqli->query($sqltabla);
  }
  if ($msj == 3) {


    echo '<script type="text/javascript">
    swal({
        title: "",
        text: "Error al crear lo sentimos,intente de nuevo.",
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
    title:"",
    text:"El nombre solo puede contener espacios y letras",
    type: "error",
    showConfirmButton: false,
    timer: 3000
    });
</script>';
  }
  if ($msj == 7) {
    echo '<script type="text/javascript">
    swal({
      title:"",
      text:"Seleccione un tipo de dato",
      type: "error",
      showConfirmButton: false,
      timer: 3000
    });
</script>';
  }
}


$Id_objeto = 195;
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
                           window.location = "../vistas/gestion_producto_vista.php";

                            </script>';
} else {

  bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'Ingreso', 'A Editar Caracteristicas');



  if (permisos::permiso_insertar($Id_objeto) == '1') {
    $_SESSION['btn_guardar_caracteristicas'] = "";
  } else {
    $_SESSION['btn_guardar_caracteristicas'] = "disabled";
  }



  /*

  

  /* Manda a llamar todos las datos de la tabla para llenar el gridview  */
  $sqltabla = ("SELECT TTC.tipo_caracteristica,TTC.id_tipo_caracteristica from tbl_tipo_caracteristica TTC,tbl_caracteristicas_producto TCP,tbl_productos TP where TTC.id_tipo_caracteristica=TCP.id_tipo_caracteristica and TCP.id_producto=TP.id_producto and nombre_producto='$producto'
  ;");
  $resultadotabla = $mysqli->query($sqltabla);



  /* Esta condicion sirve para  verificar el valor que se esta enviando al momento de dar click en el icono modificar */
  if (isset($_GET['tipo_caracteristica'])) {
    $sqltabla = "select tipo_caracteristica FROM tbl_tipo_caracteristica";

    $resultadotabla = $mysqli->query($sqltabla);

    /* Esta variable recibe el producto a modificar */
    $tipo_caracteristicas = $_GET['tipo_caracteristica'];

    /* Iniciar la variable de sesion y la crea */
    /* Hace un select para mandar a traer todos los datos de la 
 tabla donde producto sea igual al que se ingreso en el input */
    $sql = "select * FROM tbl_tipo_caracteristica WHERE tipo_caracteristica = '$tipo_caracteristicas'";
    $resultado = $mysqli->query($sql);
    /* Manda a llamar la fila */
    $row = $resultado->fetch_array(MYSQLI_ASSOC);

    /* Aqui obtengo el id<-productos de la tabla de la base el cual me sirve para enviarla a la pagina actualizar.php para usarla en el where del update   */

    //         variable               viene de la BD
    $_SESSION['id_caracteristica_'] = $row['id_caracteristica'];
    $_SESSION['tipo_caracteristica_'] = $row['tipo_caracteristica'];

    //     $_SESSION['stock_minimo_'] = $row['stock_minimo'];


    /*Aqui levanto el modal*/

    if (isset($_SESSION['tipo_caracteristica_'])) {


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
  <title></title>



</head>

<body>


  <div class="content-wrapper" id="formulariocaracteristicas">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Actualización de Productos</h1>
          </div>



          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <!-- <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li> -->
              <!-- <li class="breadcrumb-item"><a href="../vistas/gestion_producto_vista.php">Gestión Productos</a></li> -->


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
            <h3 class="card-title">Editar Características del producto</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
          </div>



          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">

                <div id="formulariocaracteristicas1">
                  <form name="formularioCaracteristicas" action="../Controlador/guardar_caracteristica_producto_controlador2.php" id="formularioCaracteristicas" class="FormularioAjax" data-form="save" method="POST">




                    <!-- <div class="col-sm-12"> -->
                    <div class="form-group my-1">
                      <label class="">Producto Ingresado: </label>

                      <!-- < PROBANDOO  $_SESSION['ARRAY_VIEJO']['descripcion_producto']   *************************************""> -->
                      <input class="form-control" value="<?php echo $_SESSION['producto_enviado']; ?>" type="text" id="txt_nombre_oculto" name="txt_nombre_oculto" required="" maxlength="50" readonly="true" style="text-transform: uppercase; height:38px; width:858px;" onkeyup="Espacio(this, event)" onkeypress="return Letras(event)" onkeypress="return comprobar(this.value, event, this.id)">



                    </div>





                    <div class="form-group pt-3">
                      <label>Tipo de características</label>
                    </div>




                    <div class="form-inline">

                      <select class="form-control select2 mr-3" style="height:38px; width:708px;" name="cmb_tipocaracteristicas" required="">
                        <option value="0">Seleccione un tipo de característica:</option>
                        <?php
                        $query = $mysqli->query("SELECT * FROM tbl_tipo_caracteristica");
                        while ($resultado = mysqli_fetch_array($query)) {
                          echo '<option value="' . $resultado['id_tipo_caracteristica'] . '"> ' . $resultado['tipo_caracteristica'] . '</option>';
                        }
                        ?>
                      </select>

                      <div class="" style="height:38px; width:358px;">
                        <button type="submit" class="btn btn-primary" id="btn_guardar_caracteristicas" name="btn_guardar_caracteristicas" <?php echo $_SESSION['btn_guardar_caracteristicas']; ?>><i class="zmdi zmdi-floppy"></i> Agregar</button>

                        <button type="button" class=" ml-3  btn btn-inline btn-primary form-control" name="add" id="gcorreotel" data-toggle="modal" data-target="#modal_guardar_tipocaracteristica"><i class="fas fa-plus"></i></button>
                      </div>

                    </div>
                    <!-- </div> -->

                    <div class="RespuestaAjax"></div>

                  </form>


                  <div class="form-group pt-5" id="tblCaracteristicas1">
                    <!-- /.arrastra este id para mostrar en el data -->
                    <table width="100%" id="tblCaracteristicas" class="table table-bordered table-striped">
                      <thead>
                        <tr>

                          <th> CARACTERÍSTICA </th>
                          <th> ELIMINAR </th>

                        </tr>
                      </thead>
                      <tbody>
                        <?php while ($row = $resultadotabla->fetch_array(MYSQLI_ASSOC)) { ?>
                          <tr>
                            <td><?php echo $row['tipo_caracteristica']; ?></td>

                            <!-- ELIMINAR LA CARACTERISTICA -->
                            <td style="text-align: center;">

                              <form action="../Controlador/eliminar_caracteristica_controlador2.php?tipo_caracteristica=<?php echo $row['tipo_caracteristica']; ?>" method="POST" class="FormularioAjax" data-form="delete" autocomplete="off">
                                <button type="submit" class="btn btn-danger btn-raised btn-xs">
                                  <i class="far fa-trash-alt" style="display:<?php echo $_SESSION['eliminar_caracteristica'] ?> "></i>
                                </button>
                                <div class="RespuestaAjax"></div>
                              </form>
                            </td>
                          </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>






                  <!-- Botones para guardar y cancelar -->
                  <div class="btn-group">
                    <!-- <p class="text-center"  >
                  <div class="form-group">  
                                                                                                                                                                                    
                  <form action="../Controlador/cancelar_actualizacion_caracteristicas_producto.php?id=<?php echo $id ?>&nombre=<?php echo $_nombreviejo ?>&descripcion=<?php echo $_descripcionviejo ?>&stock=<?php echo $_stockviejo ?>&tipo=<?php echo $_tipoviejo ?>" method="POST" class="FormularioAjax" data-form="delete" autocomplete="off">                                                                            
                  
                  <button class="btn btn-danger" type="submit">Cancelar</button>
                  <div class="RespuestaAjax"></div>
                  </form>
                  </div>
                  </p>  -->

                    <p class="text-center">
                    <div class="form-group">
                      <form action="../Controlador/evaluar_producto_con_caracteristicas_actualizadas.php?id=<?php echo $id ?>" method="POST" class="FormularioAjax" autocomplete="off">
                        <button class=" ml-3  btn btn-inline btn-primary form-control" type="submit">Guardar Cambios</button>
                        <div class="RespuestaAjax"></div>
                      </form>
                    </div>
                    </p>
                  </div>

                  <!-- $Array_viejo=$_SESSION['ARRAY_VIEJO']; -->










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

  <!-- ****** MODAL PARA CREAR UNA NUEVA CARACTERISTICA*********** -->
  <form action="../Controlador/GUARDAR_TIPO_CARACTERISTICA_CONTROLADOR3.PHP" method="post" class="FormularioAjx" autocomplete="off">



    <div class="modal fade" id="modal_guardar_tipocaracteristica">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"> Tipo característica </h4>
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
                    <label>Nombre de tipo característica </label>
                    <input class="form-control" class="tf w-input" type="text" id="txt_tipo_caracteristica1" onkeypress="return validacion_para_nombre(event)" name="txt_tipo_caracteristica1" value="" required style="text-transform: uppercase" onkeyup="DobleEspacio(this, event); MismaLetra('txt_tipo_caracteristica1');" maxlength="50">
                  </div>
                </div>
              </div>
            </div>



            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">

                    <label>Tipo de dato de la Característica</label>
                    <select class="form-control" name="cb_tipo_dato" id="cb_tipo_dato" onchange="">
                      <option value="0">Seleccione una opción:</option>
                      <option value="1">Letras</option>
                      <option value="2">Números</option>
                      <option value="3">Letras y Números</option>
                    </select>
                  </div>


                </div>
              </div>
            </div>




            <!--Footer del modal-->
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary" id="btn_guardar_tipo_caracteristica" name="modal_guardar_tipocaracteristica" <?php echo $_SESSION['btn_guardar_caracteristicas'] ?>>Guardar Cambios</button>
              <!-- <button type="submit" class="btn btn-primary" id="btn_guardar_tipo_caracteristica1" name="btn_guardar_tipo_caracteristica1" <?php echo $_SESSION['btn_guardar_tipo_caracteristica1']; ?>><i class="zmdi zmdi-floppy"></i> Guardar</button> -->

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
<script src="../plugins/datatables/Buttons-1.5.6/js/buttons.html5.min.js"></script>