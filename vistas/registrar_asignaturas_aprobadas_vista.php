<?php

ob_start();


session_start();
require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_permisos.php');


$Id_objeto= 2002 ; 

$visualizacion= permiso_ver($Id_objeto);



if ($visualizacion==0)
{
 // header('location:  ../vistas/menu_permisos_usuario_vista.php');
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
 }

 else

 {
  bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'A VERIFICACIÓN ASIGNATURA APROBADAS');


  if (permisos::permiso_insertar($Id_objeto)=='1')
  {
    $_SESSION['btn_guardar_asignaturas_aprobadas']="";
  }
  else
  {
    $_SESSION['btn_guardar_asignaturas_aprobadas']="disabled";
  }



  $sqltabla_asignaturas="select Id_asignatura as Id, asignatura , codigo from tbl_asignaturas";
  $resultadotabla_asignaturtas = $mysqli->query($sqltabla_asignaturas);


  if (isset($_POST['txt_cuenta']) )
  {
  
   $_SESSION['Cuenta']=  $_POST['txt_cuenta'];

     $sql="select concat(p.nombres,' ',p.apellidos) as nombre from tbl_personas p, tbl_personas_extendidas px where px.valor=$_SESSION[Cuenta] AND px.id_atributo=12 and px.id_persona=p.id_persona";
 //Obtener la fila del query
   $nombre = mysqli_fetch_assoc($mysqli->query($sql));
   if (!empty($nombre['nombre']) )
   {
     $_SESSION['Nombre_completo']=$nombre['nombre'];


   }
   else
   {
     echo '<script type="text/javascript">
     swal({
       title:"",
       text:"El estudiante no esta registrado, lo sentimos intente de nuevo.",
       type: "info",
       showConfirmButton: false,
       timer: 1500
       });
       $(".FormularioAjax")[0].reset();
       </script>'; 
     }

   }
   else
   {
     $_SESSION['Cuenta']="";
     $_SESSION['Nombre_completo']="";


   }


 }




 ob_end_flush();

 ?>


 <!DOCTYPE html>
 <html>
 <head>
  <title></title>
</head>
<body >



<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Asignaturas Aprobadas</h1>
        </div>



        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
             <li class="breadcrumb-item active">Vinculación </li>

          </ol>
        </div>

        <div class="RespuestaAjax"></div>

      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="card-footer">

      </div>
    </div>


            
      <form action="../Controlador/guardar_asignaturas_aprobadas_controlador.php" method="post"  data-form="save" autocomplete="off" class="FormularioAjax">

       

    <div class="card card-default">
      <div class="card-header">
        <h3 class="card-title">Verificación de Asignaturas Aprobadas</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
      </div>
      <!-- /.card-header -->
      <?php
      $sql= "SELECT  p.id_persona, CONCAT(p.nombres,' ', p.apellidos) nombres, cp.clases_aprobadas, cp.porcentaje_clases, pe.valor, verif.descripcion 
      FROM tbl_personas p, tbl_charla_practica cp, tbl_personas_extendidas pe, tbl_practica_estudiantes pract, tbl_vinculacion_verificacion verif WHERE cp.id_persona=p.id_persona 
      AND p.id_tipo_persona = 2 AND pract.id_estado = 1 AND pe.id_persona=p.id_persona AND pract.id_persona=p.id_persona AND cp.id_verificacion = verif.id_verificacion AND verif.id_verificacion = 3";
      $datos = $mysqli->query($sql);
      ?>
      <div class="card-body">
           <table id="tabla" class="table table-bordered table-striped">
              <thead>
                <tr>

                  <th>ESTUDIANTES</th>
                  <th>Nº CUENTA</th>
                  <th>CLASES APROBADAS</th>
                  <th>PORCENTAJE</th>
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
                      <td>'.$row['nombres'].'</td>
                      <td>'.$row['valor'].'</td>
                      <td>'.$row['clases_aprobadas'].'</td>
                      <td>'.$row['porcentaje_clases'].'</td>
                      <td>
                      <a href="../vistas/editar_comprobacion_asignaturas.php?id='.$row['id_persona'].'" class="btn btn-success btn-raised">
                            <i class="far fa-edit"></i>
                          </a>
                      </tr>
                      ';
                          $no++;
                        }
                      }
                 ?>    
              </tbody>
            </table>
      </div>

        <p class="text-center" style="margin-top: 20px;">
            <button type="submit" class="btn btn-primary" id="btn_guardar_asignaturas_aprobadas" name="btn_guardar_asignaturas_aprobadas">  <?php echo $_SESSION['btn_guardar_asignaturas_aprobadas']; ?><i class="zmdi zmdi-floppy"></i> Guardar</button>
          </p>
      <!-- /.card-body -->
    </div>


    <div class="RespuestaAjax"></div>
  </form>

  </div>
</section>





</div>



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
</body>

</html>