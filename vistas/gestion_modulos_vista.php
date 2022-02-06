<?php

ob_start();

session_start();

require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');



//Lineas de msj al cargar pagina de acuerdo a actualizar o eliminar datos
if (isset($_REQUEST['msj'])) {
  $msj = $_REQUEST['msj'];

  if ($msj == 1) {
    echo '<script type="text/javascript">
                    swal({
                       title:"",
                       text:"Lo sentimos el objeto ya existe",
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
                       timer: 3000
                    });
                    
                </script>';
  }
  if ($msj == 3) {


    echo '<script type="text/javascript">
                    swal({
                       title:"",
                       text:"Error al actualizar lo sentimos,intente de nuevo.",
                       type: "error",
                       showConfirmButton: false,
                       timer: 3000
                    });
                    
                </script>';
  }
}







$Id_objeto = 286;
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
                           window.location = "../vistas/pagina_inicio_vista.php";

                            </script>';
} else {

  bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'Ingreso', 'A Gestion de Módulos');


  if (permisos::permiso_modificar($Id_objeto) == '1') {
    $_SESSION['btn_modificar_modulo'] = "";
  } else {
    $_SESSION['btn_modificar_modulo'] = "disabled";
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

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">


            <h1>MÓDULOS</h1>
          </div>

          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">INICIO</a></li>
              <li class="breadcrumb-item active"><a href="../vistas/crear_modulo_vista.php">NUEVO MÓDULO</a></li>
            </ol>
          </div>

          <div class="RespuestaAjax"></div>

        </div>
      </div><!-- /.container-fluid -->
    </section>


    <!--Pantalla 2-->





    <div class="card card-default">
      <div class="card-header">
        <h3 class="card-title">MÓDULOS EXISTENTES</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="tbl_modulos" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>MÓDULO</th>
              <th>DESCRIPCIÓN </th>
              <th>MODIFICAR</th>
            </tr>
          </thead>

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

  <form data-form="update" autocomplete="off" id="modal_actualizar_form">



    <div class="modal fade" id="modal_modificar_modulo">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">GESTIÓN MÓDULOS</h4>
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

                    <input hidden disabled id="id_modulo1" value="">
                    

                    <label>MÓDULO</label>


                    <input class="form-control" type="text" id="txtnombre_modulo" value="" required style="text-transform: uppercase"  onkeyup="DobleEspacio(this, event)" onkeypress="return Letras(event)" onkeypress="return comprobar(this.value, event, this.id)" maxlength="40">

                  </div>


                  <div class="form-group">
                    <label class="control-label">DESCRIPCIÓN</label>
                    <input class="form-control" type="text" id="descripcion_modulo1" value="" required style="text-transform: uppercase" onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" maxlength="50" onkeyup="DobleEspacio(this, event)" onkeypress="return Letras(event)" onkeypress="return comprobar(this.value, event, this.id)">

                  </div>
                 
                  

                 

                </div>
              </div>

            </div>

          </div>

          <!--Footer del modal-->
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">CERRAR</button>
            <button type="button" class="btn btn-primary" id="btn_modificar_modulo" name="btn_modificar_modulo" <?php echo $_SESSION['btn_modificar_modulo']; ?>>GUARDAR CAMBIOS</button>
          </div>
        </div>
        <!-- /.modal-content -->

      </div>
      <!-- /.modal-dialog -->
    </div>

    <!-- /.  finaldel modal -->



  </form>






  <script src="../js/modulos.js"></script>
</body>

</html>