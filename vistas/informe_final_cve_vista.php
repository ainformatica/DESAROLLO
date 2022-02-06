<?php

ob_start();
session_start();
require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/Conexion.php');

require_once ('../clases/funcion_bitacora.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_permisos.php');

$Id_objeto=8236; 


$visualizacion= permiso_ver($Id_objeto);

if($visualizacion==0){
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
}else{
  bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'A Memorandums');
}

if (permisos::permiso_insertar($Id_objeto)==0)
  {
  $_SESSION["btnagregar"]="hidden";
  }
else
  {
    $_SESSION["btnagregar"]="";
  }
ob_end_flush();
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">

         <h1>Informe Anual</h1>
          </div>

                <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item active"><a href="../vistas/menu_actividades_cve_vista.php">Actividades Menú</a></li>
            </ol>
          </div>

            <div class="RespuestaAjax"></div>
   
        </div>
      </div><!-- /.container-fluid -->
    </section>

<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="card card-default">        
        <!-- Main content -->
        <section class="content">
            <div class="card-header">
              <div class="col-md-12">
                  <div class="box">

                    <div class="box-header with-border">                         
                          <h1 style="text-align:right;"><button class="btn btn-success" id="btnagregar" <?php echo $_SESSION['btnagregar']; ?> onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Nuevo Informe</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>

                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">

                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Año Informe</th>
                            <th>Fecha Creación</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                        </table>
                    </div>

               <div id="formularioregistros">
                    <!-- AQUI INICIA EL FORMULARIO PARA UN MEMORANDUM -->
              <form name="formulario" id="formulario" method="POST">
               <input type="hidden" name="id_informe_anual" id="id_informe_anual"> <!-- ID_MEMO OCULTO-->

                    <!-- Card  1 Introduccion y o-->
               <div class ="card card-default ">
                <div class="card-header bg-gradient-dark">
                  <h3 class="card-title">Introducción y Objetivos</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="row">                    
                      <!-- INTRODUCCION Y OBJETIVOS-->   
                      <div class="col-sm-6">
                        <div class="form-group">                     
                          <label>Introducción </label>
                          <p><textarea  class="form-control" name="introduccion" id="introduccion" rows="8" maxlength="1000" value=""                                       
                                      onkeyup="Card(event, this)"required> </textarea></p>
                        </div>
                      </div>
                      <!-- OBJETIVOS -->  
                      <div class="col-sm-6">
                        <div class="form-group">                      
                          <label>Objetivos </label>
                          <p><textarea  class="form-control" name="objetivos" id="objetivos" rows="8" maxlength="1000" value=""                                       
                                        onkeyup="Card(event, this)"required> </textarea></p>
                                    </div>
                                </div>          
                             </div>
                          </div>
                      </div>


               <!-- Card  2 Conclu y Reco-->
               <div class ="card card-default ">
                <div class="card-header bg-gradient-dark">
                  <h3 class="card-title">Conclusiones y Recomendaciones</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="row">                    
                      <!-- Conclusiones -->   
                      <div class="col-sm-6">
                        <div class="form-group">                     
                          <label>Conclusiones </label>
                          <p><textarea class="form-control" name="conclu" id="conclu" rows="8" maxlength="1000" value=""                                       
                                      onkeyup="Card(event, this)"required> </textarea></p>
                        </div>
                      </div>
                      <!-- Recomendaciones -->  
                      <div class="col-sm-6">
                        <div class="form-group">                      
                          <label>Recomendaciones </label>
                          <p><textarea  class="form-control" name="reco" id="reco" rows="8" required maxlength="1000" value=""                                       
                                        onkeyup="Card(event, this)"> </textarea></p>
                        </div>
                      </div>          
                  </div>
                </div>
              </div>

                       <!-- Año -->
                <div class="card card-default">
                <div class="card-header bg-gradient-dark">
                  <h3 class="card-title">Selección del año</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <div class="row">
                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <label>Año:</label>
                  <select class="form-control-lg select2" name="año" id="año" style="width: 100%;" required>
                        <option value="0"></option>
                        <?php $year = date("Y");
                              for ($i=2017; $i<=$year; $i++){
                                  echo '<option value="'.$i.'">'.$i.'</option>';
                              }
                        ?>
                       </select>
                </div>
                </div>
                </div>
                </div>

                          
                
                
                  <!-- BOTON DE GUARDAR -->
                 <h3 style="text-align: center;"><button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                  <!-- BOTON DE CANCELAR -->
                   <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button></h3>

              </form>
               </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
</div>
<script src="../public/datatables/jszip.min.js"></script>
    

 <link rel="stylesheet" type="text/css" href="../public/DataTables-1.10.25/css/dataTables.bootstrap4.min.css"/>
<link rel="stylesheet" type="text/css" href="../public/Buttons-1.7.1/css/buttons.bootstrap4.min.css"/>
 
<script type="text/javascript" src="../public/pdfmake-0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="../public/pdfmake-0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="../public/DataTables-1.10.25/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../public/DataTables-1.10.25/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="../public/Buttons-1.7.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="../public/Buttons-1.7.1/js/buttons.bootstrap4.min.js"></script>
<script type="text/javascript" src="../public/Buttons-1.7.1/js/buttons.html5.min.js"></script>

<script type="text/javascript" src="../js/informe_final_cve.js"></script>
<script src="//cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script>
<script src="../plugins/select2/js/select2.min.js"></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
  function soloLetras(e) {
    var key = e.keyCode || e.which,
      tecla = String.fromCharCode(key).toUpperCase(),
      letras = " ÀÈÌÒÙABCDEFGHIJKLMNÑOPQRSTUVWXYZ0123456789",
      especiales = [8, 37, 39, 44, 45, 46, 58, 59],
      tecla_especial = false;

    for (var i in especiales) {
      if (key == especiales[i]) {
        tecla_especial = true;
        break;
      }
    }

    if (letras.indexOf(tecla) == -1 && !tecla_especial) {
      return false;
    }
  }
</script>

<!--script>
document.getElementById("formularioregistros").addEventListener("submit", function(e) {
  var estado = document.getElementById("no_memo").value;
  if (estado.match("^[a-zA-Z]{2}-[0-9]{4}$")) {
    alert("Cumple el patron");
  } else {
    alert("No cumple el patron");
    e.preventDefault(); // no se envia el formulario
  }
})
</script-->

</body>
</html>
