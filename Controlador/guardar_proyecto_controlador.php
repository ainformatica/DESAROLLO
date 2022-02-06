<?php
session_start();

require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');

$codigo_proyecto = strtoupper($_POST['txt_cod_proyecto']);
$nombre_proyecto = strtoupper($_POST['txt_nombre_proyecto']);
$tipo_proyecto = strtoupper($_POST['txt_tipo_proyecto']);
$fecha_inicio_ejecucion = strtoupper($_POST['txt_fecha_inicio']);
$fecha_final_ejecucion = strtoupper($_POST['txt_fecha_final']);
$fecha_intermedia_evaluacion = strtoupper($_POST['txt_fecha_intermedia']);
$fecha_final_evaluacion = strtoupper($_POST['txt_fecha_final_evaluacion']);
$beneficiarios_directos = strtoupper($_POST['txt_beneficiario_directo']);
$beneficiarios_indirectos = strtoupper($_POST['txt_beneficiario_indirecto']);
$total_beneficiarios = strtoupper($_POST['txt_beneficiarios']);
$modalidad_proyecto = strtoupper($_POST['combo_modalidad']);
$tipo_vinculacion_proyecto = strtoupper($_POST['combo_tipo']);
$costo_proyecto = strtoupper($_POST['txt_costo_proyecto']);
$nombre_empresa = strtoupper($_POST['txt_nombre_empresa']);
$aporte_empresa = strtoupper($_POST['combo_aporte_empresa']);
$formalizacion_empresa = strtoupper($_POST['combo_formalizacion']);
$contacto_institucional = strtoupper($_POST['txt_contacto_institucional']);
$cargo_contacto = strtoupper($_POST['txt_cargo']);
$telefono_contacto = strtoupper($_POST['txt_telefono_contacto']);
$correo_contacto = strtoupper($_POST['txt_correo_contacto']);

/*
$nombre_estudiante=strtoupper ($_POST['txt_nombre_estudiante1']);
$numero_estudiante=strtoupper ($_POST['txt_num_estudiante1']);
$direccion_estudiante=strtoupper ($_POST['txt_direccion_estudiante1']);
$cargo_estudiante=strtoupper ($_POST['txt_cargo_estudiante1']);
$telefono_estudiante=strtoupper ($_POST['txt_telefono_estudiante1']);
$correo_estudiante=strtoupper ($_POST['txt_correo_estudiante1']);*/
$region_proyecto = strtoupper($_POST['txt_region']);
$departamento_pais = strtoupper($_POST['combo_depto']);
$municipio = strtoupper($_POST['id_municipio']);
$aldea_caserio = strtoupper($_POST['id_aldea']);
$barrio_colonia = strtoupper($_POST['txt_barrio_colonia']);
$entidad_beneficiaria = strtoupper($_POST['txt_entidad_beneficiaria']);
$objetivos_proyecto = strtoupper($_POST['txt_objetivos']);
$objetivos_inmediatos = strtoupper($_POST['txt_objetivos_inmediatos']);
$resultados_proyecto = strtoupper($_POST['txt_resultados_esperados']);
$actividades_proyecto = strtoupper($_POST['txt_actividades_principales']);
$departamento_facultad = strtoupper($_POST['txt_departamento']);

$nom_coordina = strtoupper($_POST['txt_nombre_coordinador']);
$num_empleado = strtoupper($_POST['txt_num_empleado']);
$direccion_cor = strtoupper($_POST['txt_direccion_cor']);
$cargo_coordinador = strtoupper($_POST['txt_cargo_coordinador']);
$telefono_coordinador = strtoupper($_POST['txt_telefono_coordinador']);
$correo_coordinador = strtoupper($_POST['txt_correo_coordinador']);


$nombre_estud = strtoupper($_POST['nom_coordina']);
$cargo_estud = strtoupper($_POST['txt_cargo_coordinador']);
$telefono_estud = strtoupper($_POST['txt_telefono_coordinador']);
$correo_estud = strtoupper($_POST['txt_correo_coordinador']);
$num_emple_estud = strtoupper($_POST['txt_num_empleado']);
$dirreccion_estud = strtoupper($_POST['txt_direccion_cor']);

$sqlexiste_proyecto = ("select count(nombre) as nombre  from tbl_proyectos where nombre='$nombre_proyecto' ");
//Obtener la fila del query
$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste_proyecto));


$Id_objeto = 24;

/* Logica para que no acepte campos vacios */
if (isset($nombre_proyecto) and isset($nombre_empresa) and isset($codigo_proyecto) and isset($tipo_proyecto) and isset($departamento_facultad) and isset($fecha_inicio_ejecucion) and isset($fecha_final_ejecucion) and isset($fecha_intermedia_evaluacion) and isset($fecha_final_ejecucion) and isset($beneficiarios_directos) and isset($beneficiarios_indirectos) and isset($modalidad_proyecto) and isset($costo_proyecto) and isset($aporte_empresa) and isset($formalizacion_empresa) and isset($contacto_institucional) and isset($cargo_contacto) and isset($telefono_contacto) and isset($correo_contacto) and isset($region_proyecto) and isset($departamento_pais) and isset($municipio) and isset($entidad_beneficiaria) and isset($objetivos_inmediatos) and isset($resultados_proyecto) and isset($actividades_proyecto)) {

  if ($existe['nombre'] == 1) {
    /*header('location: ../contenidos/crearPregunta-view.php?msj=2');*/
    echo '<script type="text/javascript">
  swal({
   title:"",
   text:"Lo sentimos el proyecto <?php $nombre_proyecto ?> ya existe",
   type: "error",
   showConfirmButton: false,
   timer: 3000
   });
   </script>';
  } else {


$num_emple_estud = strtoupper($_POST['num_emple_estud']);
    $sql = "call   proc_insertar_proyecto( '$tipo_vinculacion_proyecto', '$modalidad_proyecto' , '$nombre_proyecto' , '$codigo_proyecto',  '1', '$beneficiarios_directos', '$beneficiarios_indirectos', '$nombre_empresa', '$contacto_institucional' , '$cargo_contacto' , '$telefono_contacto', '$correo_contacto' , '$total_beneficiarios', '$fecha_inicio_ejecucion', '$fecha_final_ejecucion', '$fecha_intermedia_evaluacion', '$fecha_final_evaluacion', '$costo_proyecto' '4', '$formalizacion_empresa', '$aporte_empresa', '$region_proyecto', '$departamento_pais', '$municipio ', '$aldea_caserio', '$barrio_colonia', '$entidad_beneficiaria', '$objetivos_proyecto', '$objetivos_inmediatos', '$resultados_proyecto', '$actividades_proyecto', '$departamento_facultad','$tipo_proyecto', '$nombre_estud', '$cargo_estud', '$telefono_estud', '$correo_estud', '$num_emple_estud', '$dirreccion_estud')";
    $resultado = $mysqli->query($sql);

    // ,'$_SESSION[id_usuario]' ,
    if ($resultado === TRUE) {
      bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INSERTO', 'EL PROYECTO ' . $nombre_proyecto . '');

      echo '<script type="text/javascript">
 document.getElementById("btn_guardar_proyecto").enable=true;
</script>';
      /*   require"../contenidos/crearRol-view.php"; 
header('location: ../contenidos/crearRol-view.php?msj=2');*/
      echo '<script type="text/javascript">
           swal({
                title:"",
                text:"Los datos  se almacenaron correctamente",
                type: "success",
                showConfirmButton: false,
                timer: 3000
             });
             $(".FormularioAjax")[0].reset();
             window.location = "../vistas/registrar_proyecto_vinculacion_vista.php";
         </script>';
    } else {
      echo "Error: " . $sql;
    }


    // if ($resultado === TRUE /*and $resultado_estudiante===TRUE*/) {
    //   bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INSERTO', 'EL PROYECTO ' . $nombre_proyecto . '');

    //   /*header('location: ../contenidos/crearPregunta-view.php?msj=1');*/
    //   echo '<script type="text/javascript">
    //                       swal({
    //                        title:"",
    //                        text:"Los datos  se almacenaron correctamente",
    //                        type: "success",
    //                        showConfirmButton: false,
    //                        timer: 3000
    //                        });
    //                        $(".FormularioAjax")[0].reset();
    //                        </script>';
    // } else {
    //   echo '<script type="text/javascript">
    //                       swal({
    //                        title:"",
    //                        text:"Lo sentimos los datos no fueron guardados correctamente",
    //                        type: "error",
    //                        showConfirmButton: false,
    //                        timer: 3000
    //                        });

    //                        </script>';
    // }
  }
} else {
  /*echo '<script> alert("Lo sentimos tiene campos por rellenar ")</script>';*/
  echo '<script type="text/javascript">
  swal({
   title:"",
   text:"Lo sentimos tiene campos por rellenar",
   type: "error",
   showConfirmButton: false,
   timer: 3000
   });
   </script>';
}
