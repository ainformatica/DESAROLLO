<?php

ob_start();


session_start();
require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_permisos.php');

if (isset($_REQUEST['msj']))
    {
    $msj=$_REQUEST['msj'];
    
    if ($msj==1)
    {
  

echo '<script type="text/javascript">
                              swal({
                                   title:"",
                                   text:"Lo sentimos tiene campos por rellenar",
                                   type: "info",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                                $(".FormularioAjax")[0].reset();
                            </script>';
    }
      if ($msj==2)
    {

    echo '<script type="text/javascript">
                    swal({
                       title:"",
                       text:"Lo sentimos hay algunos asignaturas ya existente y no seran guardados",
                       type: "error",
                       showConfirmButton: false,
                       timer: 3000
                    });
                </script>';
    }
      if ($msj==3)
    {
                             echo '<script type="text/javascript">
                              swal({
                                   title:"",
                                   text:"Los datos  se almacenaron correctamente",
                                   type: "success",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                                $(".FormularioAjax")[0].reset();
                            </script>';


  } 
  
      if ($msj==4)
    {

 echo '<script type="text/javascript">
                              swal({
                                   title:"",
                                   text:"Lo sentimos no se pudieron guardar los datos",
                                   type: "error",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                                $(".FormularioAjax")[0].reset();
                            </script>';
    }
        

  }


$Id_objeto= 2004 ; 




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
  bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'A GESTION ASIGNATURA APROBADAS');


  if (permisos::permiso_insertar($Id_objeto)=='1')
  {
    $_SESSION['btn_gestion_asignaturas_aprobadas']="";
  }
  else
  {
    $_SESSION['btn_gestion_asignaturas_aprobadas']="disabled";
  }


   $counter = 0;
   $sql_tabla_clases_aprobadas = json_decode( file_get_contents('http://localhost/automatizacion/api/asignaturas_aprobadas_api.php'), true );

  
$sql_tabla__modal_clases_aprobadas="select * from tbl_asignaturas";

if (isset($_GET['iduser']))
{

$_SESSION["nombreaprobadas"]=$_GET['nombres'];
$_SESSION["CuentaValor"]=$_GET['iduser'];

 //Obtener la fila del query
  
$sql_tabla__modal_clases_aprobadas="select * from tbl_asignaturas";
$resultadotabla_modal = $mysqli->query($sql_tabla__modal_clases_aprobadas);



?>
  <script>
    $(function(){
    $('#modal_modificar_asignaturas').modal('toggle')

    })



  </script>;
<?php 
 


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
            <div class="RespuestaAjax"></div>



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
      <!-- pantalla 1 -->
                
        <div class="card card-default">
      <div class="card-header">
            <h3 class="card-title">Gestión Aprobadas</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
      </div>
      <!-- /.card-header -->
      <?php
            $sql="SELECT  p.id_persona, CONCAT(p.nombres,' ', p.apellidos) nombres, cp.clases_aprobadas, cp.porcentaje_clases, pe.valor, verif.descripcion
            FROM tbl_personas p, tbl_charla_practica cp, tbl_personas_extendidas pe, tbl_practica_estudiantes pract, tbl_vinculacion_verificacion verif 
            WHERE cp.id_persona=p.id_persona 
            AND p.id_tipo_persona = 2 AND pract.id_estado = 1 AND pe.id_persona=p.id_persona 
            AND pract.id_persona=p.id_persona 
            AND cp.id_verificacion = verif.id_verificacion AND verif.id_verificacion != 3";
              
              $datos = $mysqli->query($sql);
              // $id_estudiante=['id_persona'];
            ?>
      <div class="card-body">
        <table id="tabla" class="table table-bordered table-striped">
          <thead>
            <tr>
                <th>NOMBRE COMPLETO</th>
                <th>CUENTA</th>                
                <th>CANTIDAD DE CLASES</th>
                <th>PROMEDIO</th>
                <th>VERIFICACIÓN</th>
                <th>CONSTANCIA</th>



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
                          <td>'.$row['descripcion'].'</td>
                          <td style="text-align: center;">

                            <a href="../pdf/reporte_constancia_clases.php?id_persona='.$row['id_persona'].'" target="_blank" class="btn btn-primary btn-raised btn-xs">
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

       <!-- /.card-body -->
    </div>


    <div class="RespuestaAjax"></div>

  </div>
</section>





</div>

  <script type="text/javascript">
 
 $(function () {

    $('#tabla').DataTable({
      "paging": true,
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
