<?php
ob_start();
session_start();
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
$id_estudiante = $_GET['id'];
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');
//Objeto de charla
$Id_objeto = 2003;
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

  bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INGRESO', 'A COMPROBACIÓN DE ASIGNATURAS.');


  if (permisos::permiso_insertar($Id_objeto) == '1') {
    $_SESSION['btn_guardar_charla'] = "";
  } else {
    $_SESSION['btn_guardar_charla'] = "disabled";
  }

  $usuario = $_SESSION['id_usuario'];
  $id = ("select id_persona from tbl_usuarios where id_usuario='$usuario'");
  $result = mysqli_fetch_assoc($mysqli->query($id));
  $id_persona = $result['id_persona'];



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
            <h1>Verificación de las asignaturas</h1>
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
                $sql = "SELECT  p.id_persona, CONCAT(p.nombres,' ', p.apellidos) nombres, cp.clases_aprobadas, cp.porcentaje_clases, pe.valor, verif.descripcion
                FROM tbl_personas p, tbl_charla_practica cp, tbl_personas_extendidas pe, tbl_practica_estudiantes pract, tbl_vinculacion_verificacion verif 
                WHERE cp.id_persona=p.id_persona 
            AND p.id_tipo_persona = 2 AND pract.id_estado = 1 AND pe.id_persona=p.id_persona AND pract.id_persona=p.id_persona AND 
                pe.id_persona = $id_estudiante";
                $resultado = $mysqli->query($sql);
                $verificacion = $resultado->fetch_assoc();
            ?>

      <div class="container-fluid">
        <!-- pantalla 1 -->


        <form action="../Controlador/editar_comprobacion_controlador.php" method="post" data-form="save" autocomplete="off" class="FormularioAjax">
          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">Verificación del 80%</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              </div>
            </div>


            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">
                
               <input type="text" class="d-none" name="id_estudiante" value="<?php echo $id_estudiante; ?>">

                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Nombre del estudiante</label>
                    <input class="form-control" type="text" id="txt_estudiante" name="txt_estudiante" value="<?php echo $verificacion ['nombres']; ?>" disabled>
                  </div>
                </div>

                <div class="col-sm-4">
                  <div class="form-group">
                    <label>Número de cuenta</label>
                    <input class="form-control" type="text" id="txt_cuenta" name="txt_cuenta" value="<?php echo $verificacion ['valor']; ?>" disabled>
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Clases aprobadas</label>
                    <input class="form-control" type="text" maxlength="2" id="clases" name="txt_clases" value="<?php echo $verificacion ['clases_aprobadas']; ?>" required onkeyup="Espacio(this, event)" onkeypress="return Numeros(event)">
                  </div>
                </div>

                <div class="col-sm-4">
                  <div class="form-group">
                    <label> Porcentaje </label>
                    <input class="form-control" type="text" maxlength="3" id="txt_promedio" name="txt_promedio" value="<?php echo $verificacion ['porcentaje_clases']; ?>" required onkeyup="Espacio(this, event)" onkeypress="return Numeros(event)">  
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Verificación del 80%</label>
                    <select class="form-control" name="cb_verificacion" id="cb_verificacion">
                      <option value="0">Seleccione una opción :</option>
                      <?php
                           $sql=$mysqli->query("SELECT * FROM tbl_vinculacion_verificacion WHERE id_verificacion != 3");

                           while($fila=$sql->fetch_array()){
                              echo "<option value='".$fila['id_verificacion']."'>".$fila['descripcion']."</option>";
                           }
                       ?>
                    </select>
                  </div>
                </div>

              </div>

              <p class="text-center" style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary" id="btn_guardar_charla" <?php echo $_SESSION['btn_guardar_charla']; ?>><i class="zmdi zmdi-floppy"></i> Guardar</button>
              </p>
            </div>
          </div>



          <div class="RespuestaAjax"></div>
        </form>

      </div>
    </section>


  </div>

</body>
<script type="text/javascript">
    
    let $txt_clase=document.getElementById("clases");

    $txt_clase.addEventListener('keyup',(e)=>{
      //console.log($txt_clase);
      porcentaje($txt_clase.value)

    })
     function porcentaje(clases) {
    
         if (clases>52) {
          swal({
            title:"Control de Cupos",
            text:"Charla con cupos agotados.",
            type: "info",
            showConfirmButton: true,
            
         });
         $txt_clase.value='';
         document.getElementById('txt_promedio').value='';
         }else{
          let  total_clases = 52,
          promedio=(clases*100)/total_clases;
         document.getElementById('txt_promedio').value = Math.round(promedio);
         }
       
    
     }
</script>
</html>
