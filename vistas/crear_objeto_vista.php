<?php

ob_start();


session_start();
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');





$Id_objeto = 283;

bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'Ingreso', 'A Crear Objeto');



$visualizacion = permiso_ver($Id_objeto);



if ($visualizacion == 0) {
  //header('location:  ../vistas/menu_roles_vista.php');

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






  if (permisos::permiso_insertar($Id_objeto) == '1') {
    $_SESSION['btn_guardar_objeto'] = "";
  } else {
    $_SESSION['btn_guardar_objeto'] = "disabled";
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
              <li class="breadcrumb-item active">SEGURIDAD</li>
            </ol>
          </div>

          <div class="RespuestaAjax"></div>

        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- pantalla 1 -->

        <form data-form="save" id="formulario_objeto" name="formulario_objeto" class="FormularioAjax" autocomplete="off">

          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">NUEVO OBJETO</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              </div>
            </div>


            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>INGRESE EL OBJETO</label>
                    <input class="form-control" type="text" id="txt_objeto" name="txt_objeto" required="" maxlength="40" style="text-transform: uppercase" onkeyup="DobleEspacio(this, event)" onkeypress="return Letras(event)" onkeypress="return comprobar(this.value, event, this.id)" >
                  </div>

                  <div class="form-group">
                    <label>DESCRIPCIÓN</label>
                    <input class="form-control" type="text" id="txt_descripcionobjeto" name="txt_descripcionobjeto" required="" maxlength="50" style="text-transform: uppercase" onkeyup="DobleEspacio(this, event)" onkeypress="return Letras(event)" onkeypress="return comprobar(this.value, event, this.id)">
                  </div>
                  <div class="form-group">
                    <label>INGRESE EL MÓDULO</label>
                    <select class="form-control" type="" id="select_modulo" name="select_modulo" required="" maxlength="30" style="text-transform: uppercase" onchange="Espacio(this, event)" onselect="return Letras(event)" onkeypress="return comprobar(this.value, event, this.id)">
                    </select>
                </div>

            <!--      <div class="form-group clearfix">
                    <div class="icheck-success d-inline">
                      <input type="checkbox" id="txt_checkboxactivo" name="txt_checkboxactivo" value="true">
                      <label for="txt_checkboxactivo">ACTIVO
                      </label>
                    </div>
                  </div>-->

                  <p class="text-center" style="margin-top: 20px;">
                    <button type="submit" class="btn btn-primary" id="btn_guardar_objeto" name="btn_guardar_objeto" <?php echo $_SESSION['btn_guardar_objetos']; ?>><i class="zmdi zmdi-floppy"></i> GUARDAR</button>
                  </p>

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




<script src="../js/objetos.js"></script>
</body>

</html>