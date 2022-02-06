<?php
ob_start();
session_start();
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
$id = $_GET['id'];
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');
$dtz = new DateTimeZone("America/Tegucigalpa");
$dt = new DateTime("now", $dtz);
$hoy = $dt->format("Y-m-d");
$Id_objeto = 2008;
bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'Ingreso', 'A crear Reunion');
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
                                window.location = "./vistas/gestion_charla_vista.php";
                            </script>';
    // header('location:  ../vistas/menu_usuarios_vista.php');
} else {
    if (permisos::permiso_insertar($Id_objeto) == '1') {
        $_SESSION['btn_crear'] = "";
    } else {
        $_SESSION['btn_crear'] = "disabled='disabled'";
    }
}
ob_end_flush();

?>



<!DOCTYPE html>
<html>

<head>
  <title></title>
</head>

<body>
  


  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Modificación de charla para PPS</h1>
          </div>



          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item active">Vinculación</li>
            </ol>
          </div>

          <div class="RespuestaAjax"></div>

        </div>
      </div><!-- /.container-fluid -->
    </section>


    <!-- Main content -->
    <section class="content">
         <?php
            $sql = "SELECT primer_expositor, CONCAT (p1.nombres,' ',p1.apellidos) AS nombre1, segundo_expositor, CONCAT (tbl_personas.nombres,' ',tbl_personas.apellidos) AS nombre2, fecha_charla, hora_charla, cupos, nombre_charla, tbl_vinculacion_gestion_charla.id_jornada_charla, jornada_charla, periodo, fecha_valida
                    FROM tbl_vinculacion_gestion_charla
                      INNER JOIN tbl_jornada_charla 
                      ON tbl_jornada_charla.id_jornada_charla=tbl_vinculacion_gestion_charla.id_jornada_charla
                      INNER JOIN tbl_personas p1 
                      ON tbl_vinculacion_gestion_charla.primer_expositor = p1.id_persona
                      INNER JOIN tbl_personas 
                      ON tbl_vinculacion_gestion_charla.segundo_expositor = tbl_personas.id_persona
                    WHERE `id_charla` = $id";
            $resultado = $mysqli->query($sql);
            $charla = $resultado->fetch_assoc();
          ?>
      <div class="container-fluid">
        <!-- pantalla 1 -->


        <form action="../Controlador/actualizar_charla_controlador.php" method="post" data-form="save" autocomplete="off" class="FormularioAjax">
          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">Editar charla</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              </div>
            </div>

        
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">

                <input type="text" class="d-none" name="id_charla" value="<?php echo $id; ?>">

                <div class="col-sm-6">
                  <div class="form-group">
                    <label> Expositor 1 </label>
                    <select class="form-control" name="cb_expositor_1" id="cb_expositor_1" >
                      <option selected value="<?php echo $charla ['primer_expositor']; ?>"><?php echo $charla ['nombre1']; ?></option>
                      <?php
                      $dato= $charla ['primer_expositor'];
                      $query = $mysqli->query("SELECT p.id_persona, CONCAT(p.nombres,' ', p.apellidos) nombres FROM tbl_personas p, tbl_actividades_persona ap WHERE ap.id_persona=p.id_persona AND ap.id_actividad=1 AND p.id_persona<>'$dato' ");
                      while ($valores = mysqli_fetch_array($query)) {
                        echo '<option value="' . $valores['id_persona'] . '">' . $valores['nombres'] . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label> Expositor 2 </label>
                    <select class="form-control" name="cb_expositor_2" id="cb_expositor_2">
                      <option selected value="<?php echo $charla ['segundo_expositor']; ?>"><?php echo $charla ['nombre2']; ?></option>
                      <?php
                      $dato= $charla ['segundo_expositor'];
                      $query = $mysqli->query("SELECT p.id_persona, CONCAT(p.nombres,' ', p.apellidos) nombres FROM tbl_personas p, tbl_actividades_persona ap WHERE ap.id_persona=p.id_persona AND ap.id_actividad=1 AND p.id_persona<>'$dato'");
                      while ($valores = mysqli_fetch_array($query)) {
                        echo '<option value="' . $valores['id_persona'] . '">' . $valores['nombres'] . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                </div>


                <div class="col-sm-4">
                  <div class="form-group">
                    <label>Fecha de la charla</label>
                    <input class="form-control" type="date" value="<?php echo $charla ['fecha_charla']; ?>" id="txt_fecha_asignada" name="txt_fecha_asignada">
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Hora de la charla</label>
                    <input class="form-control" type="time" value="<?php echo $charla ['hora_charla']; ?>" maxlength="60" id="txt_hora_charla" name="txt_hora_charla">
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Cupos</label>
                    <input class="form-control" type="text" value="<?php echo $charla ['cupos']; ?>"maxlength="2" id="txt_cupos" name="txt_cupos">
                  </div>
                </div>

                <div class="col-sm-4">
                  <div class="form-group">
                    <label> Jornada </label>
                    <select class="form-control" name="cb_jornada" id="cb_jornada">
                      <option selected value="<?php echo $charla ['id_jornada_charla']; ?>"><?php echo $charla ['jornada_charla']; ?></option>
                        <?php
                            $dato= $charla ['id_jornada_charla'];
                            $sql=$mysqli->query("SELECT * FROM tbl_jornada_charla WHERE id_jornada_charla<>'$dato'");

                            while($fila=$sql->fetch_array()){
                                echo "<option value='".$fila['id_jornada_charla']."'>".$fila['jornada_charla']."</option>";
                            }
                        ?>
                     </select>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Nombre de la charla</label>
                    <input class="form-control" type="text" value="<?php echo $charla ['nombre_charla']; ?>" maxlength="100" id="txt_nombre_charla" name="txt_nombre_charla">
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Periodo académico</label>
                    <input class="form-control" type="text" value="<?php echo $charla ['periodo']; ?>" maxlength="2" id="txt_periodo" name="txt_periodo" required onkeyup="Espacio(this, event)" onkeypress="return Numeros(event)">
                  </div>
                </div>

                <div class="col-sm-4">
                  <div class="form-group">
                    <label>Vigencia de la constancia</label>
                    <input class="form-control" type="date" value="<?php echo $charla ['fecha_valida']; ?>" id="txt_fecha_valida" name="txt_fecha_valida">
                  </div>
                </div>

              </div>

              <p class="text-center" style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary" id="btn_guardar_charla" name="btn_actualizar_charla" <?php echo $_SESSION['btn_guardar_charla']; ?>><i class="zmdi zmdi-floppy"></i> Guardar</button>
                <a style="color: white !important; margin: 0px 0px 0px 10px;" class="btn btn-danger" href="gestion_charla_vista.php">Cancelar</a>
              </p>
            </div>
           </div>

            <div class="RespuestaAjax"></div>
         </form>

      </div>
    </section>


  </div>

</body>

</html>
