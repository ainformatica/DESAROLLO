<?php
ob_start();
session_start();
require_once('../clases/Conexion.php');
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');

//Objeto de charla
$Id_objeto = 2007;
//txt_constancia_charla


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

  bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INGRESO', 'A GESTIÓN DE CHARLA.');


  if (permisos::permiso_insertar($Id_objeto) == '1') {
    $_SESSION['btn_guardar_charla'] = "";
  } else {
    $_SESSION['btn_guardar_charla'] = "disabled";
  }

  $usuario = $_SESSION['id_usuario'];
  $id = ("select id_persona from tbl_usuarios where id_usuario='$usuario'");
  $result = mysqli_fetch_assoc($mysqli->query($id));
  $id_persona = $result['id_persona'];


//   $sql = ("select concat(p.nombres,' ', p.apellidos) as nombre ,px.valor from tbl_personas_extendidas px, tbl_personas p where  p.id_persona='$id_persona' and px.id_atributo=12 and px.id_persona=p.id_persona ");
  //Obtener la fila del query
//   $resultado = mysqli_fetch_assoc($mysqli->query($sql));

//   $nombre = $resultado['nombre'];
//   $cuenta = $resultado['valor'];
}


$sql2 = $mysqli->prepare("SELECT fecha_valida FROM tbl_charla_practica WHERE id_persona = $id_persona");
$sql2->execute();
$resultado2 = $sql2->get_result();
$row2 = $resultado2->fetch_array(MYSQLI_ASSOC);
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
            <h1>Creación de charla para PPS</h1>
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
      <div class="container-fluid">
        <!-- pantalla 1 -->


        <form action="../Controlador/guardar_charla_controlador.php" method="post" data-form="save" autocomplete="off" class="FormularioAjax">
          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">Nueva charla</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              </div>
            </div>


            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">

                <div class="col-sm-6">
                  <div class="form-group">
                    <label> Expositor 1 </label>
                    <select class="form-control" name="cb_expositor_1" id="cb_expositor1" >
                      <option value="0">Seleccione un docente:</option>
                      <?php
                      $query = $mysqli->query("SELECT  p.id_persona, CONCAT(p.nombres,' ', p.apellidos) nombres FROM tbl_personas p, tbl_actividades_persona ap WHERE ap.id_persona=p.id_persona AND ap.id_actividad=1 ");
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
                    <select class="form-control" name="cb_expositor_2" id="cb_expositor2" onchange="Constancia();">
                      <option value="0">Seleccione un docente :</option>
                      <?php
                      $query = $mysqli->query("SELECT  p.id_persona, CONCAT(p.nombres,' ', p.apellidos) nombres FROM tbl_personas p, tbl_actividades_persona ap WHERE ap.id_persona=p.id_persona AND ap.id_actividad=1 ");
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
                    <input class="form-control" type="date" id="txt_fecha_asignada" name="txt_fecha_asignada">
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Hora de la charla</label>
                    <input class="form-control" type="time" maxlength="60" id="txt_hora_charla" name="txt_hora_charla">
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Cupos</label>
                    <input class="form-control" type="text" maxlength="2" id="txt_cupos" name="txt_cupos" required onkeyup="espacio(this, event)" onkeypress="return numeros(event)">
                  </div>
                </div>

                <div class="col-sm-4">
                  <div class="form-group">
                    <label> Jornada </label>
                    <select class="form-control" name="cb_jornada" id="cb_jornada">
                      <option value="0">Seleccione una jornada :</option>
                      <?php
                           $sql=$mysqli->query("SELECT * FROM tbl_jornada_charla");

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
                    <input class="form-control" type="text" maxlength="100" id="txt_nombre_charla" name="txt_nombre_charla" onkeyup="mayus(this);">
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Periodo académico</label>
                    <input class="form-control" type="text" maxlength="2" id="txt_periodo" name="txt_periodo" required onkeyup="espacio(this, event)" onkeypress="return numeros(event)">
                  </div>
                </div>

                <div class="col-sm-4">
                  <div class="form-group">
                    <label>Vigencia de la constancia</label>
                    <input class="form-control" type="date" id="txt_fecha_valida" name="txt_fecha_valida">
                  </div>
                </div>

              </div>

              <p class="text-center" style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary" id="btn_guardar_charla" <?php echo $_SESSION['btn_guardar_charla']; ?>><i class="zmdi zmdi-floppy"></i> Guardar</button>
              </p>
            </div>



            <!-- /.card-body -->
            <?php
            $sql="SELECT id_charla, tbl_personas.nombres AS expositor1, p2.nombres AS expositor2, fecha_charla, hora_charla, cupos, nombre_charla, periodo, fecha_valida, tbl_jornada_charla.jornada_charla, tbl_vinculacion_gestion_charla.estado
                  FROM tbl_vinculacion_gestion_charla INNER JOIN tbl_personas
                  ON tbl_vinculacion_gestion_charla.primer_expositor=tbl_personas.id_persona
                  INNER JOIN tbl_jornada_charla ON tbl_jornada_charla.id_jornada_charla = tbl_vinculacion_gestion_charla.id_jornada_charla
                  INNER JOIN tbl_personas p2
                  ON tbl_vinculacion_gestion_charla.segundo_expositor=p2.id_persona WHERE tbl_vinculacion_gestion_charla.estado = 1";
              
              $datos = $mysqli->query($sql);
            ?>
            <div class="card-footer">
              <table id="tabla" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    
                    <th>No.</th>
                    <th>NOMBRE CHARLA</th>
                    <th>EXPOSITOR 1</th>
                    <th>EXPOSITOR 2</th>
                    <th>FECHA</th>
                    <th>HORA</th>
                    <th>CUPOS</th>
                    <th>JORNADA</th>
                    <th>PERIODO</th>
                    <th>FECHA VÁLIDA</th>
                    <th>ACCIONES</th>

                  </tr>
                </thead>
                <tbody>
                    <?php 
                      if(mysqli_num_rows($datos) == 0){
                        echo '<tr><td colspan="8">No hay datos.</td></tr>';
                      }else{
                        $no = 1;
                        while($row = mysqli_fetch_assoc($datos)){
                          echo '
                          <tr>
                          <td>'.$row['id_charla'].'</td>
                          <td>'.$row['nombre_charla'].'</td>
                          <td>'.$row['expositor1'].'</td>
                          <td>'.$row['expositor2'].'</td>
                          <td>'.$row['fecha_charla'].'</td>
                          <td>'.$row['hora_charla'].'</td>
                          <td>'.$row['cupos'].'</td>
                          <td>'.$row['jornada_charla'].'</td>
                          <td>'.$row['periodo'].'</td>
                          <td>'.$row['fecha_valida'].'</td>
                          <td>
                          <a href="../vistas/editar_charla_vista.php?id='.$row['id_charla'].'" class="btn btn-success btn-raised">
                            <i class="far fa-edit"></i>
                          </a>
                          </td>
                          </tr>
                          ';
                          $no++;
                        }
                      }
                    ?>
                </tbody>
              </table>
            </div>
          </div>



          <div class="RespuestaAjax"></div>
        </form>

      </div>
    </section>


  </div>

</body>

</html>
<script>
  function fecha_valida() {
  var fech1 = new Date();
  var fech2 = document.getElementById("txt_fecha_valida").value;

  if ((Date.parse(fech1)) >= (Date.parse(fech2))) {

    document.getElementById("txt_fecha_valida").value = "";
  } else {

  }
}
</script>

<script>
  function mayus(e) {
    e.value = e.value.toUpperCase();
}
</script>

<script>
function numeros(e){
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = " 0123456789";
    especiales = [8];
 
    tecla_especial = false
    for(var i in especiales){
 if(key == especiales[i]){
     tecla_especial = true;
     break;
        } 
    }
 
    if(letras.indexOf(tecla)==-1 && !tecla_especial)
        return false;
}
</script>

<script language="javascript">

function espacio(campo, event) {

CadenaaReemplazar = " ";
CadenaReemplazo = "";
CadenaTexto = campo.value;
CadenaTextoNueva = CadenaTexto.split(CadenaaReemplazar).join(CadenaReemplazo);
campo.value = CadenaTextoNueva;

}

</script>

<script type="text/javascript">


   $(function () {

    $('#tabla').DataTable({
      "paging": false,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "responsive": true,
    });
  });


</script>