<?php

ob_start();


session_start();
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');



if (isset($_REQUEST['msj'])) {
  $msj = $_REQUEST['msj'];

  if ($msj == 1) {


    echo '<script type="text/javascript">
                    swal({
                       title:"",
                       text:"Lo sentimos la cantidad de archivos sobrepasa el permitido,.",
                       type: "info",
                       showConfirmButton: false,
                       timer: 3000
                    });
                    
                </script>';
  }
  if ($msj == 4) {


    echo '<script type="text/javascript">
                    swal({
                       title:"",
                       text:"Los archivos fueron reemplazado correctamente.",
                       type: "info",
                       showConfirmButton: false,
                       timer: 3000

                    });
  window.location = "../vistas/subida_informacion_estudiante_vista.php";

                </script>';
  }
}



$Id_objeto = 6004;

$visualizacion = permiso_ver($Id_objeto);


if ($visualizacion == 0) {
  echo '<script type="text/javascript">
                              swal({
                                   title:"",
                                   text:"Lo sentimos no tiene permiso de visualizar la pantalla",
                                   type: "error",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                           window.location = "../vistas/menu_practica_vista.php";

                            </script>';
} else {

  bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INGRESO', 'A DOCUMENTACION DE PRACTICA.');

  if (permisos::permiso_insertar($Id_objeto) == '1') {
    $_SESSION['btn_guardar_subida'] = "";
  } else {
    $_SESSION['btn_guardar_subida'] = "disabled";
  }
  $usuario = $_SESSION['id_usuario'];
  $id = ("select id_persona from tbl_usuarios where id_usuario='$usuario'");
  $result = mysqli_fetch_assoc($mysqli->query($id));
  $id_persona = $result['id_persona'];

  $sqlsubida = ("select concat(p.nombres,' ',p.apellidos) as nombre, px.valor from tbl_personas p, tbl_personas_extendidas px where px.id_persona='$id_persona' and p.id_persona='$id_persona'");
  //Obtener la fila del query
  $datos = mysqli_fetch_assoc($mysqli->query($sqlsubida));



  $_SESSION['nombre_estudiante'] = $datos['nombre'];
  $_SESSION['cuenta_estudiante'] = $datos['valor'];
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


            <h1>Documentación de Práctica </h1>
          </div>

          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item active">Subida de Información</li>
            </ol>
          </div>

          <div class="RespuestaAjax"></div>

        </div>
      </div><!-- /.container-fluid -->
    </section>


    <!--Pantalla 2-->



    <div class="card card-default">
      <div class="card-header">
        <h3 class="card-title">Subida de Información </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
      </div>
      <form action="../Controlador/subida_informacion_controlador.php" method="post" data-form="save" autocomplete="off" class="FormularioAjax">


        <!-- /.card-header -->
        <div class="card-body">
          <div class="row">



            <div class="col-sm-6">
              <div class="form-group">
                <label>Nombre Estudiante</label>
                <input class="form-control" type="text" id="txt_nombre_estudiante" name="txt_nombre_estudiante" value="<?php
                                                                                                                        if (!empty($_SESSION['nombre_estudiante'])) {
                                                                                                                          echo $_SESSION['nombre_estudiante'];
                                                                                                                        } else {
                                                                                                                          echo "";
                                                                                                                        } ?>" required onkeyup="Espacio(this, event)" maxlength="50" readonly="readonly">
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group">
                <label>N° Cuenta</label>
                <input class="form-control" type="text" id="txt_cuenta_estudiante" name="txt_cuenta_estudiante" value="<?php
                                                                                                                        if (!empty($_SESSION['cuenta_estudiante'])) {
                                                                                                                          echo $_SESSION['cuenta_estudiante'];
                                                                                                                        } else {
                                                                                                                          echo "";
                                                                                                                        } ?>" required onkeyup="Espacio(this, event)" maxlength="50" readonly="readonly">
              </div>
            </div>


            <div class="col-sm-4">
              <div class="form-group">
                <label> Copia de la Cédula</label>
                <input class="form-control" type="file" class="form-control" id="txt_documentos[]" name="txt_cedula" multiple="">
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label> Certificado de Bioseguridad</label>
                <input class="form-control" type="file" class="form-control" id="txt_documentos" name="txt_bioseguridad" multiple="">
              </div>
            </div>
            <div class="col-sm-2">
              <div class="form-group">
                  <label for="">Mis Documentos </label>
                  <button id="btn-documentos" type="button" class="form-control btn btn-success" data-toggle="modal" data-target="#documentacion">
                        Ver
                  </button>    
                </div>
            </div>




          </div>
          <p class="text-center" style="margin-top: 20px;"> <button type="submit" class="btn btn-primary" id="btn_guardar_subida" name="btn_guardar_subida" <?php echo $_SESSION['btn_guardar_subida']; ?>>Guardar Cambios</button>

          </p>
          <!-- /.card-body -->
        </div>

        <div class="RespuestaAjax"></div>

      </form>
      <!-- /.card-body -->
      <div class="card-footer">

      </div>
    </div>

    <!-- Modal de documentacion -->
    <div class="modal fade" id="documentacion">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Documentos</h4>
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
                  <label class="control-label">Nombre Completo</label>
                  <input class="form-control" type="text" maxlength="60" id="txt_nombre_alumno" name="txt_nombre_alumno" value="<?php echo $_SESSION['nombre_estudiante'] ?>" readonly>
                  <?php
                  $cuenta =  $datos['valor'];
                  $listar = null;
                  $directorio=opendir("../Documentacion_practica/$cuenta/");
                  $n=0;
                  while ($elemento = readdir($directorio)) {
                    if ($elemento != '.' and $elemento != '..') {


                      if (is_dir("../Documentacion_practica/$cuenta/".$elemento)) {
                        $listar .= "<div class='list-group'>
                                        <a href='../Documentacion_practica/$cuenta/$elemento' 
                                        target='_blank'' 
                                        class='list-group-item list-group-item-action list-group-item-success' >
                                        $elemento
                                        </a>
                                    </div>";
                        
                        
                      } else {
                        $listar .= "<div class='list-group'>
                                      <a href='../Documentacion_practica/$cuenta/$elemento' 
                                      target='_blank'' 
                                      class='list-group-item list-group-item-action list-group-item-success' >
                                      $elemento
                                      </a>
                                    </div>";
                        //$listar .= "<li> <a href='../Documentacion_practica/$cuenta/$elemento' target='_blank' >$elemento</a></li>";
                      }
                    }
                    $n++;
                  }
                  if ($n=1) {
                    $faltan="<div class='list-group'>
                                <a href='#' class='list-group-item list-group-item-action list-group-item-danger' >04_Certificado_de_Bioseguridad</a>
                            </div>";
                    $faltan.="<div class='list-group'>
                                <a href='#' class='list-group-item list-group-item-action list-group-item-danger' >05_Foto_de_La_Cedula</a>
                              </div>";
                    
                 
                  }else{
                     $faltan="<div class='list-group'>
                                    <a href='#' class='list-group-item list-group-item-action list-group-item-primary' >Documentacion Completa</a>
                                 </div>";
                  }


                  ?>
                  <label class="control-label mt-3">Documentos que ya tengo (<strong>No subir </strong>)</label>
                  <ul>
                    <?php echo $listar;
                   ?>
                   
                  </ul>
                  <label class="control-label my-3">Documentos que me faltan (Subir) </label>
                  <ul>
                    <?php echo $faltan;
                   ?>
                   
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--Footer del modal-->
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>

</body>
<script>
  document.getElementById('btn-documentos').click();
</script>

</html>