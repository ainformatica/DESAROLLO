<?php
ob_start();
session_start();

require_once('../clases/Conexion.php');
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');

$Id_objeto = 6002;




$visualizacion = permiso_ver($Id_objeto);

$usuario = $_SESSION['id_usuario'];
$id = ("select id_persona from tbl_usuarios where id_usuario='$usuario'");
$result = mysqli_fetch_assoc($mysqli->query($id));
$id_persona = $result['id_persona'];
$sql_estudiante = ("SELECT  px.valor, concat(a.nombres,' ',a.apellidos) as nombre, c.valor Correo,g.valor as direccion
,H.valor as celular, j.valor as telefono,a.fecha_nacimiento,a.identidad
FROM tbl_personas AS a
JOIN tbl_contactos c ON a.id_persona = c.id_persona
JOIN tbl_tipo_contactos d ON c.id_tipo_contacto = d.id_tipo_contacto AND d.descripcion = 'CORREO'
JOIN tbl_contactos g ON a.id_persona = g.id_persona
JOIN tbl_tipo_contactos F ON g.id_tipo_contacto = F.id_tipo_contacto AND F.descripcion = 'DIRECCION'
JOIN tbl_contactos H ON a.id_persona = H.id_persona
JOIN tbl_tipo_contactos I ON H.id_tipo_contacto = I.id_tipo_contacto AND I.descripcion = 'TELEFONO CELULAR'
JOIN tbl_contactos j ON a.id_persona = j.id_persona
JOIN tbl_tipo_contactos k ON j.id_tipo_contacto = k.id_tipo_contacto AND k.descripcion = 'TELEFONO FIJO'
            join tbl_personas_extendidas as px on px.id_atributo=12 and px.id_persona=a.id_persona
            WHERE a.id_persona = '$id_persona'
           LIMIT 1");
//Obtener la fila del query
$datos_estudiante = mysqli_fetch_assoc($mysqli->query($sql_estudiante));








if ($visualizacion == 0) {
  echo '<script type="text/javascript">
                              swal({
                                   title:"",
                                   text:"Lo sentimos no tiene permiso de visualizar la pantalla",
                                   type: "error",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                           window.location = "../vistas/menu_estudiantes_practica_vista.php";

                            </script>';
} else {

  bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INGRESO', 'A REGISTRAR SOLICITUD PRACTICA.');


  if (permisos::permiso_insertar($Id_objeto) == '1') {
    $_SESSION['btn_guardar_solicitud_pps'] = "";
  } else {
    $_SESSION['btn_guardar_solicitud_pps'] = "disabled";
  }
}

ob_end_flush();




?>


<!DOCTYPE html>
<html>

<head>
  <title></title>
  <link rel="stylesheet" href="../css/tabs_formulario_pps.css">
</head>

<body>









<div class="container ">
<ul class="navbar-nav">
        <li class="nav-item">
          <a id="ocultar" class="nav-link" data-widget="pushmenu"  href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

<div class="tabset">
  
  <!-- Tab 1 -->
  <input type="radio" name="tabset" id="tab1" aria-controls="marzen" checked>
  <label for="tab1">Información del Estudiante</label>
  <!-- Tab 2 -->
  <input type="radio" name="tabset" id="tab2" aria-controls="rauchbier">
  <label for="tab2">Información de la Institución</label>
  <!-- Tab 3 -->
  <input type="radio" name="tabset" id="tab3" aria-controls="dunkles">
  <label for="tab3">Información de Práctica Profesional </label>



  
  <!-- <input type="radio" name="tabset" id="tab4" aria-controls="wilder">
  <label for="tab4">Documentos</label> -->
  







  <div class="tab-panels ">

  
        <!-- INFORMACION PERSONAL -->
    <section id="marzen" class="tab-panel ">
      <form action="#">
        
      <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                  <label>Nombre Completo</label>
                  <input class="form-control" type="text" id="txt_cuenta_solicitud" name="txt_cuenta_solicitud" maxlength="12" value="<?php echo $datos_estudiante['nombre'];; ?>" readonly>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                  <label>Nº de Cuenta</label> 

                  <input class="form-control" type="text" id="txt_cuenta_solicitud" name="txt_cuenta_solicitud" maxlength="12" value="<?php echo $datos_estudiante['valor']; ?>" readonly>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                  <label>DNI</label>
                  <input class="form-control" type="text" id="txt_cuenta_solicitud" name="txt_cuenta_solicitud" maxlength="12" value="<?php echo $datos_estudiante['identidad']; ?>" readonly>
                </div>
            </div>
        
            <div class="col-sm-4">
                <div class="form-group">
                  <label>Fecha de nacimiento</label>
                  <input class="form-control" type="text" id="txt_cuenta_solicitud" name="txt_cuenta_solicitud" maxlength="12" value="<?php echo $datos_estudiante['fecha_nacimiento']; ?>" readonly>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                  <label>Dirección</label>
                  <input class="form-control" type="text" id="txt_cuenta_solicitud" name="txt_cuenta_solicitud" maxlength="12" value="<?php echo $datos_estudiante['direccion']; ?>" readonly>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                  <label>Teléfono fijo</label>
                  <input class="form-control" type="text" id="txt_cuenta_solicitud" name="txt_cuenta_solicitud" maxlength="12" value="<?php echo $datos_estudiante['telefono']; ?>" readonly>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                  <label>Celular</label>
                  <input class="form-control" type="text" id="txt_cuenta_solicitud" name="txt_cuenta_solicitud" maxlength="12" value="<?php echo $datos_estudiante['celular']; ?>" readonly>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                  <label>Correo Institucional</label>
                  <input class="form-control" type="text" id="txt_cuenta_solicitud" name="txt_cuenta_solicitud" maxlength="25" value="<?php echo $datos_estudiante['Correo']; ?>" readonly>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                  <label>Correo Personal</label>
                  <input class="form-control" type="text" id="txt_cuenta_solicitud" name="txt_cuenta_solicitud" maxlength="25" value="<?php echo $datos_estudiante['Correo']; ?>" readonly>
                </div>
            </div>

            <div class="col-sm-12 ">
                <div class="form-group">
                  <button class="btn btn-outline-primary">Guardar</button>
                  <button class="btn btn-outline-danger">Cancelar</button>
                </div>
            </div>
        </div>
        
      </form>
    </section>
        <!--FIN DE  INFORMACION PERSONAL -->

        <!-- INFORMACION EMPRESA -->
    <section id="dunkles" class="tab-panel">
      <form  id="frmempresa"  enctype="multipart/form-data">
          
          <div class="row">
              
                <div class="col-sm-8">
                    <div class="form-group">
                      <label>Nombre Empresa</label> 

                      <input class="form-control" type="text" id="nombre" name="nombre_empresa">
                      <input type="hidden" name="id_persona" value="<?php echo $result['id_persona'] ?>">  
                      <input class="form-control" type="hidden" id="cuenta" name="txt_cuenta" value="<?php echo $datos_estudiante['valor']; ?>">

                    </div>
                </div>

                <div class="col-sm-4">
                  <div class="form-group">
                    <label>Tipo de institución</label>
                    <select class="form-control" name="cb_empresa" id="empresa">
                      <option selected disabled value="0">Seleccione una opcion:</option>
                      <?php
                      $query = $mysqli->query("SELECT * FROM tbl_tipo_empresa");
                      while ($resultado = mysqli_fetch_array($query)) {
                        echo '<option value="' . $resultado['id_tipo_empresa'] . '"> ' . $resultado['descripcion'] . '</option>';
                      }
                      ?>
                    </select>
                  </div>
              </div>

                <div class="col-sm-12">
                    <div class="form-group">
                      <label>Dirección Empresa</label> 

                      <input class="form-control" type="text" id="direccion" name="direccion_empresa">
                    </div>
                </div>

               

                <div class="col-sm-8">
                        <div class="form-group">
                          <label>Nombre del Jefe</label> 
                          <input class="form-control" type="text" id="jefe" name="nombre_jefe">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                          <label>Cargo del Jefe</label> 
                          <input class="form-control" type="text" id="cargo" name="cargo_jefe">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                          <label>Correo electrónico</label> 
                          <input class="form-control" type="text" id="correo" name="correo_jefe">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                          <label>Telefono (Ext.)</label> 
                          <input class="form-control" type="text" id="telefono" name="telefono_jefe">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                          <label>Celular</label> 
                          <input class="form-control" type="text" id="txt_cuenta_solicitud" name="celular_jefe">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                          <label>Nivel académico</label>
                          <select class="form-control" name="cb_nivel" id="nivel_academico">
                            <option selected disabled value="0">Seleccione una opcion:</option>
                            <option value="1">Bachillerato</option>
                            <option value="2">Licenciado</option>
                            <option value="3">Ingeniero</option>
                            <option value="4">Máster</option>
                            <option value="4">Doctor</option>
                          
                          </select>
                        </div>
                    </div>

                    <div class="col-sm-4">
                   
                   <div class="form-group">
                     <label>¿ Trabaja para la institución ?</label>
                     <select class="form-control" name="cb_trabaja" id="trabaja_institucion">
                       <option selected disabled value="10">Seleccione una opcion:</option>
                       <option value="1">Sí</option>
                       <option value="2">No</option>
                     
                     </select>
                   </div>
               </div>
                 <div class="col-sm-4">
                     <div class="form-group">
                       <label id="lb_cargo" class="d-none">Cargo</label>
                       <input class="form-control d-none" type="text" id="cargo_trabaja" name="cargo_trabajo" >
                     </div>
                 </div>
                 <div class="col-sm-4">
                     <div class="form-group">
                       <label id="lb_fechaingreso" class="d-none">Fecha de ingreso a la institución</label>
                       <input class="form-control d-none" type="date" id="fechaIngreso" name="fecha_ingreso" >
                     </div>
                 </div>



                    <div class="col-sm-12">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text">Perfil de empresa</span>
                            </div>
                            <textarea class="form-control" aria-label="With textarea" name="perfil_empresa"></textarea>

                        </div>
                    </div>
                </div>


            
                <div class="col-sm-12 mb-4">
                      <div class="input-group">
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" id="cargarCroquis" name="croquis">
                              <label class="custom-file-label" for="cargarCroquis">Cargar Croquis</label>
                            </div>
                            <div class="input-group-append">
                              <button id="1" onclick="informacion(this)" class="btn btn-outline-info" type="button">Información</button>
                            </div>
                      </div>
                </div>
               



                <div class="col-sm-6 mb-4">
                    <div class="form-group">

                     
                      <button type="submit" class="btn btn-primary" id="btn_empresa" name="registrar" ><i class="zmdi zmdi-floppy"></i> Guardar</button>
                      <button type="button" class="btn btn-danger" id="btn_salir" ><i class="zmdi zmdi-floppy"></i> Cancelar</button>
                    </div>
              
              </div>

            </div>
            
      </form>

    </section>
        <!--FIN DE INFORMACION EMPRESA -->

           <!-- INFORMACION PPS -->
    <section id="rauchbier" class="tab-panel">
     
     <form id="frmPractica" >
         
         <div class="row">
             <div class="col-sm-4">
                 <div class="form-group">
                   <label>Modalidad de Práctica</label>
                   <select class="form-control" name="cb_modalidad" id="cb_modalidad">
                     <option selected disabled value="0">Seleccione una opcion:</option>
                     <?php
                     $query = $mysqli->query("SELECT * FROM tbl_modalidad");
                     while ($resultado = mysqli_fetch_array($query)) {
                       echo '<option value="' . $resultado['id_modalidad'] . '"> ' . $resultado['modalidad'] . '</option>';
                     }
                     ?>
                   </select>
                 </div>
             </div>
               <div class="col-sm-4">
                   <div class="form-group">
                     <label>Fecha de inicio</label> 
   
                     <input class="form-control" type="date" id="fecha_inicio" name="txt_fecha_inicio">
                     <input  type="hidden" id="empresa_id" name="id_empresa">
                     <input type="hidden" name="id_persona" value="<?php echo $result['id_persona'] ?>">
                   </div>
               </div>
               <div class="col-sm-4">
                   <div class="form-group">
                     <label>Fecha de finalización</label>
                     <input class="form-control" type="date" id="fecha_final" name="txt_fecha_final">
                   </div>
               </div>
           
               <div class="col-sm-4">
                 <div class="form-group">
                   <label>Jornada laboral</label>
                   <select class="form-control" name="cb_jornada" id="jornada">
                     <option selected disabled value="0">Seleccione una opcion:</option>
                     <?php
                     $query = $mysqli->query("SELECT * FROM tbl_jornada_laboral");
                     while ($resultado = mysqli_fetch_array($query)) {
                       echo '<option value="' . $resultado['id_jornada_laboral'] . '"> ' . $resultado['descripcion'] . '</option>';
                     }
                     ?>
                   </select>
                 </div>
             </div>
               <div class="col-sm-4">
                   <div class="form-group">
                     <label>Hora inicio</label>
                     <input class="form-control" type="time" id="hora_inicio" 
                     name="txt_hora_inicio" placeholder="08:00 am">
                     
                   </div>
               </div>
               <div class="col-sm-4">
                   <div class="form-group">
                     <label>Hora final</label>
                     <input class="form-control" type="time" id="hora_final" 
                     name="txt_hora_final" placeholder="16:00 pm">
                   </div>
               </div>
              
             
           </div>
           
           <div class="col-sm-6 mb-4">
                    <div class="form-group">

                     
                      <button type="submit" class="btn btn-primary" id="btn_practica" name="registrar" ><i class="zmdi zmdi-floppy"></i> Guardar</button>
                      <button type="button" class="btn btn-danger" id="btn_salirr" ><i class="zmdi zmdi-floppy"></i> Cancelar</button>
                    </div>
              
              </div>

           
     </form>
     
     
    </section>
      <!--FIN DE INFORMACION PPS -->

   


    <section id="wilder" class="tab-panel">

          <form action="#">
              
              <div class="row">
                 
                    <div class="col-sm-8">
                        <div class="form-group">
                          <label>Nombre</label> 
                          <input class="form-control" type="text" id="txt_cuenta_solicitud" name="txt_cuenta_solicitud">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                          <label>Cargo</label> 
                          <input class="form-control" type="text" id="txt_cuenta_solicitud" name="txt_cuenta_solicitud">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                          <label>Correo electrónico</label> 
                          <input class="form-control" type="text" id="txt_cuenta_solicitud" name="txt_cuenta_solicitud">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                          <label>Telefono (Ext.)</label> 
                          <input class="form-control" type="text" id="txt_cuenta_solicitud" name="txt_cuenta_solicitud">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                          <label>Celular</label> 
                          <input class="form-control" type="text" id="txt_cuenta_solicitud" name="txt_cuenta_solicitud">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                          <label>Nivel académico</label>
                          <select class="form-control" name="cb_empresa" id="empresa">
                            <option selected disabled value="0">Seleccione una opcion:</option>
                            <option value="1">Bachillerato</option>
                            <option value="2">Licenciado</option>
                            <option value="3">Ingeniero</option>
                            <option value="4">Máster</option>
                            <option value="4">Doctor</option>
                          
                          </select>
                        </div>
                    </div>

                    
                   
                   
                   
                   
                  
                  
                </div>
                
          </form>                      

    </section>

    


  </div>
  

  <script src="../js/charla/tabs_formulario_pps.js"></script>
  <script type="text/javascript">

  $("#cb_trabaja").change(function () {
    var id_tipo_periodo = $("#cb_trabaja option:selected").text();

    $("#trabaja").val(id_tipo_periodo);
  });
document.getElementById('ocultar').click();
    </script>


</body>

</html>