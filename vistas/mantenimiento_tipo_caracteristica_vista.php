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
        text: "Lo sentimos el tipo característica ya existe",
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



    $sqltabla = "select tipo_caracteristica FROM tbl_tipo_caracteristica";
    $resultadotabla = $mysqli->query($sqltabla);
  }
  if ($msj == 3) {


    echo '<script type="text/javascript">
    swal({
        title: "",
        text: "Nombre no vàlido",
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
                        text: "Datos no editados.",
                        type: "error",
                        showConfirmButton: false,
                        timer: 3000
                    });
                   
                    </script>';
  }
  if ($msj == 5) {


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
  if ($msj == 8) {
    echo '<script type="text/javascript">
    swal({
      title:"",
      text:"Error",
      type: "error",
      showConfirmButton: false,
      timer: 3000
    });
</script>';
  }
}


$Id_objeto = 200;
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

  bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'Ingreso', 'A Mantenimiento Tipo Caracteristica');


  if (permisos::permiso_modificar($Id_objeto) == '1') {
    $_SESSION['btn_modificar_tipocaracteristica'] = "";
  } else {
    $_SESSION['btn_modificar_tipocaracteristica'] = "disabled";
  }


  /* Manda a llamar todos las datos de la tabla para llenar el gridview  */
  $sqltabla = "select id_tipo_caracteristica,tipo_caracteristica,validacion from tbl_tipo_caracteristica";
  $resultadotabla = $mysqli->query($sqltabla);



  /* Esta condicion sirve para  verificar el valor que se esta enviando al momento de dar click en el icono modicar */
  if (isset($_GET['tipo_caracteristica'])) {
    $sqltabla = "select id_tipo_caracteristica,tipo_caracteristica,validacion from tbl_tipo_caracteristica";
    $resultadotabla = $mysqli->query($sqltabla);

    /* Esta variable recibe el estado de modificar */
    $tipo_caracteristica = $_GET['tipo_caracteristica'];
    $validacion = $_GET['validacion'];

    /* Iniciar la variable de sesion y la crea */
    /* Hace un select para mandar a traer todos los datos de la 
 tabla donde rol sea igual al que se ingreso en el input */
    $sql = "select * FROM tbl_tipo_caracteristica WHERE tipo_caracteristica = '$tipo_caracteristica'";
    $resultado = $mysqli->query($sql);
    /* Manda a llamar la fila */
    $row = $resultado->fetch_array(MYSQLI_ASSOC);

    /* Aqui obtengo el id_tipo<-caracteristica de la tabla de la base el cual me sirve para enviarla a la pagina actualizar.php para usarla en el where del update   */
    $_SESSION['id_tipo_caracteristica'] = $row['id_tipo_caracteristica'];
    $_SESSION['tipo_caracteristica'] = $row['tipo_caracteristica'];
    $_SESSION['validacion'] = $row['validacion'];


    /*Aqui levanto el modal*/

    if (isset($_SESSION['tipo_caracteristica'])) {


?>
      <script>
        $(function() {
          $('#modal_modificar_tipocaracteristica').modal('toggle')

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


            <h1>Tipos de Características
            </h1>
          </div>

          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item active"><a href="../vistas/menu_mantenimiento_laboratorio.php">Menu Mantenimiento</a></li>
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
        <h3 class="card-title">Tipos de Características Existentes</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
        <br>
        <div class=" px-12">
          <!-- <button class="btn btn-success "> <i class="fas fa-file-pdf"></i> <a style="font-weight: bold;" onclick="ventana()">Exportar a PDF</a> </button> -->
        </div>
      </div>
      <div class="card-body">
        <div style="padding: 2px;"><a href="mantenimiento_crear_tipo_caracteristica_vista.php" class=" btn btn-success btn-inline float-right mt-0"><i class="fas fa-plus pr-2"></i>Nuevo</a></div>

        <table id="tblCaracteristica" class="table table-bordered table-striped">



          <thead>
            <tr>
              <th>TIPO CARACTERÍSTICA</th>
              <th>TIPO DE DATO</th>
              <th>MODIFICAR</th>
              <th>ELIMINAR</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $resultadotabla->fetch_array(MYSQLI_ASSOC)) { ?>
              <tr>
                <td><?php echo $row['tipo_caracteristica']; ?></td>
                <?php if ($row['validacion'] == 1) { ?>
                  <td><?php echo 'LETRAS';
                      $_SESSION['validacion'] = $row['validacion']; ?></td>
                <?php } elseif ($row['validacion'] == 2) { ?>
                  <td><?php echo 'NÚMEROS';
                      $_SESSION['validacion'] = $row['validacion'];;  ?></td>
                <?php } else { ?>
                  <td><?php echo 'LETRAS Y NÚMEROS';
                      $_SESSION['validacion'] = $row['validacion'];; ?></td>
                <?php } ?>
                <!-- /. PARA MODIFICAR -->
                <td style="text-align: center;">
                  <a href="../vistas/mantenimiento_tipo_caracteristica_vista.php?tipo_caracteristica=<?php echo $row['tipo_caracteristica']; ?>&validacion=<?php echo $_SESSION['validacion']; ?>" class="btn btn-primary btn-raised btn-xs">
                    <i class="far fa-edit" style="display:<?php echo $_SESSION['modificar_tipo_caracteristica'] ?> "></i>
                  </a>
                </td>




                <!-- /. PARA ELIMINAR -->
                <td style="text-align: center;">

                  <form action="../Controlador/eliminar_tipo_caracteristica_controlador.php?tipo_caracteristica=<?php echo $row['tipo_caracteristica']; ?>" method="POST" class="FormularioAjax" data-form="delete" autocomplete="off">
                    <button type="submit" class="btn btn-danger btn-raised btn-xs">

                      <i class="far fa-trash-alt" style="display:<?php echo $_SESSION['eliminar_tipo_caracteristica'] ?> "></i>
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





  <!-- *********************Creacion del modal 

-->

  <form action="../Controlador/actualizar_tipo_caracteristica_controlador.php?id_tipo_caracteristica=<?php echo $_SESSION['id_tipo_caracteristica']; ?>" method="post" data-form="update" class="FormularioAjax" autocomplete="off">



    <div class="modal fade" id="modal_modificar_tipocaracteristica">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"> Actualizar Tipo de Característica </h4>
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
                    <label>Modificar Tipo de Característica </label>

                    <input class="form-control" class="tf w-input" type="text" id="txt_tipocaracteristica" onkeypress="return validacion_para_nombre(event)" name="txt_tipocaracteristica" value="<?php echo $_SESSION['tipo_caracteristica'];   ?>" required style="text-transform: uppercase" onkeyup="DobleEspacio(this, event); MismaLetra('txt_tipocaracteristica');" maxlength="50">
                  </div>
                </div>
              </div>
            </div>

            <?php
            $vali = $_SESSION['tipo_caracteristica'];

            $sql = "select validacion from tbl_tipo_caracteristica where tipo_caracteristica='$vali'";

            $resultado = $mysqli->query($sql);
            /* Manda a llamar la fila */
            $row = $resultado->fetch_array(MYSQLI_ASSOC);

            //         variable               viene de la BD
            $_SESSION['validacion'] = $row['validacion'];
            //print_r($_SESSION['validacion']);


            if ($_SESSION['validacion'] == 1) {

              $_SESSION['tipo'] = 'LETRAS';

              $_SESSION['validacion2'] = 2;
              $_SESSION['tipo2'] = 'NUMEROS';

              $_SESSION['validacion3'] = 3;
              $_SESSION['tipo3'] = 'LETRAS Y NUMEROS';
            } elseif ($_SESSION['validacion'] == 2) {
              $_SESSION['tipo'] = 'NUMEROS';

              $_SESSION['validacion2'] = 1;
              $_SESSION['tipo2'] = 'LETRAS';

              $_SESSION['validacion3'] = 3;
              $_SESSION['tipo3'] = 'LETRAS Y NUMEROS';
            } else {
              $_SESSION['tipo'] = 'LETRAS Y NUMEROS';

              $_SESSION['validacion2'] = 1;
              $_SESSION['tipo2'] = 'LETRAS';

              $_SESSION['validacion3'] = 2;
              $_SESSION['tipo3'] = 'NUMEROS';
            }
            ?>
          


          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">

                  <label>Tipo de dato de la Característica</label>
                  <select class="form-control" name="cb_tipo_dato" id="cb_tipo_dato" onchange="">
                    <option value="0">Seleccione una opción:</option>
                    <?php


                    if (isset($_SESSION['validacion'])) {


                      echo '<option value="' . $_SESSION['validacion'] . '" selected="" > ' . $_SESSION['tipo'] . '</option>';
                      echo '<option value="' . $_SESSION['validacion2'] . '"  >  ' . $_SESSION['tipo2'] . '</option>';
                      echo '<option value="' . $_SESSION['validacion3'] . '"  >  ' . $_SESSION['tipo3'] . '</option>';
                    } else {
                    }

                    ?>

                  </select>
                </div>


              </div>
            </div>
          </div>
          </div>



          <!--Footer del modal-->
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary" id="btn_modificar_tipocaracteristica" name="btn_modificar_tipocaracteristica" <?php echo $_SESSION['btn_modificar_tipocaracteristica']; ?>>Guardar Cambios</button>
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