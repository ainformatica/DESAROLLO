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







$Id_objeto = 284;
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

  bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'Ingreso', 'A Gestion de Objetos');


  if (permisos::permiso_modificar($Id_objeto) == '1') {
    $_SESSION['btn_modificar_objeto'] = "";
  } else {
    $_SESSION['btn_modificar_objeto'] = "disabled";
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


            <h1>OBJETOS</h1>
          </div>

          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">INICIO</a></li>
              <li class="breadcrumb-item active"><a href="../vistas/crear_objeto_vista.php">NUEVO OBJETO</a></li>
            </ol>
          </div>

          <div class="RespuestaAjax"></div>

        </div>
      </div><!-- /.container-fluid -->
    </section>


    <!--Pantalla 2-->





    <div class="card card-default">
      <div class="card-header">
        <h3 class="card-title">OBJETOS EXISTENTES</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="tbl_objetos" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>OBJETO</th>
              <th>DESCRIPCIÓN </th>
              <th>MÓDULO</th>
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



    <div class="modal fade" id="modal_modificar_objeto">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">GESTION OBJETOS</h4>
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

                    <input hidden disabled id="txtidobjeto" name="txtidobjeto" value="">
                    

                    <label>OBJETO</label>


                    <input class="form-control" type="text" id="txtnombreobjeto" name="txtnombreobjeto" value="" required style="text-transform: uppercase"  onkeyup="DobleEspacio(this, event)" onkeypress="return Letras(event)" onkeypress="return comprobar(this.value, event, this.id)" maxlength="40">

                  </div>


                  <div class="form-group">
                    <label class="control-label">DESCRIPCION</label>

                    <input class="form-control" type="text" id="txtdescripcionobjeto" name="txtdescripcionobjeto" value="" required style="text-transform: uppercase" onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" maxlength="50" onkeyup="DobleEspacio(this, event)" onkeypress="return Letras(event)" onkeypress="return comprobar(this.value, event, this.id)">

                  </div>
                  <div class="form-group">
                  <label>INGRESE EL MÓDULO</label>
                    <select class="form-control" type="" id="select_modulo" name="select_modulo" required="" maxlength="30" style="text-transform: uppercase" onchange="Espacio(this, event)" onselect="return Letras(event)" onkeypress="return comprobar(this.value, event, this.id)">
                    </select>

                  </div>
                  

                  <!-- <div class="form-group clearfix">
                    <div class="icheck-success d-inline">
                      <input type="checkbox" id="checkboxactivomodificar" name="checkboxactivomodificar" value="true">
                      <label for="checkboxactivomodificar">ACTIVO
                      </label>
                    </div>
                  </div> -->

                </div>
              </div>

            </div>

          </div>

          <!--Footer del modal-->
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">CERRAR</button>
            <button type="button" class="btn btn-primary" id="btn_modificar_objeto" name="btn_modificar_objeto" <?php echo $_SESSION['btn_modificar_objeto']; ?>>GUARDAR CAMBIOS</button>
          </div>
        </div>
        <!-- /.modal-content -->

      </div>
      <!-- /.modal-dialog -->
    </div>

    <!-- /.  finaldel modal -->



  </form>






  <script src="../js/objetos.js"></script>
</body>

</html>