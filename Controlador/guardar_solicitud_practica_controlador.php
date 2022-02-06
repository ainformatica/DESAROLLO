<?php
ob_start();

session_start();

require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');

$modalidad_practica=strtoupper ($_POST['cb_modalidad']);
$identidad_estudiante=strtoupper ($_POST['txt_identidad']);
$nacimiento_estudiante=strtoupper ($_POST['txt_fecha_nacimiento']);
$telefono_estudiante=strtoupper ($_POST['txt_telefono_solicitud']);
$celular_estudiante=strtoupper ($_POST['txt_celular_solicitud']);
$direccion_estudiante=strtoupper ($_POST['txt_direccion_solicitud']);
$labora_empresa=strtoupper ($_POST['trabaja']);
$tipo_empresa=strtoupper ($_POST['cb_tipo_empresa']);
$fecha_final_estimada=strtoupper ($_POST['txt_fecha_final_estimada']);
$fecha_inicio_estimada=strtoupper ($_POST['txt_fecha_inicio_estimada']);

//DATOS DE EMPRESA
$nombre_empresa_practica=strtoupper ($_POST['txt_institucion_solicitud']);
$direccion_empresa_practica=strtoupper ($_POST['txt_institucion_direccion_solicitud']);
$nombre_jefe_inmediato=strtoupper ($_POST['txt_jefe_solicitud']);
$departamento_practica=strtoupper ($_POST['txt_depto_empresa']);
$titulo_jefe_inmediato=strtoupper ($_POST['txt_titulo_profesional']);
$telefono_jefe_inmediato=strtoupper ($_POST['txt_telefono_jefe_solicitud']);
$correo_jefe_inmediato=strtoupper ($_POST['txt_correo_prof']);
$cargo_jefe_inmediato=strtoupper ($_POST['txt_cargo_prof']);


  $usuario=$_SESSION['id_usuario'];
        $id=("select id_persona from tbl_usuarios where id_usuario='$usuario'");
       $result= mysqli_fetch_assoc($mysqli->query($id));
       $id_persona=$result['id_persona'];

       $sql2 = "SELECT fecha_recibida FROM tbl_charla_practica WHERE id_persona = $id_persona";
       $solicitud_charla_existe = mysqli_fetch_assoc($mysqli->query($sql2));


       //PROCEDIMIENTO PARA ALMACENAR LA EMPRESA DEL PRACTICANTE
$sql = "call proc_insertar_empresa_practica('$nombre_empresa_practica', '$direccion_empresa_practica', '$tipo_empresa', '$labora_empresa', '$departamento_practica', '$nombre_jefe_inmediato', '$titulo_jefe_inmediato', '$cargo_jefe_inmediato', '$correo_jefe_inmediato', '$telefono_jefe_inmediato','$id_persona');";
$resultado2 = $mysqli->query($sql);

$sql_guardar_solicitud_practica = "Call proc_guardar_solicitud_practica (".$id_persona.",'".$telefono_estudiante."','".$celular_estudiante."','".$direccion_estudiante."','".$nacimiento_estudiante."','".$fecha_inicio_estimada."','".$fecha_final_estimada."' ,'".$identidad_estudiante."','".$modalidad_practica."'); ";
$resultado = $mysqli->query($sql_guardar_solicitud_practica);


if (isset($identidad_estudiante) and isset($nacimiento_estudiante) and isset($direccion_estudiante) and isset($labora_empresa) and isset($tipo_empresa) and isset($fecha_final_estimada) and isset($fecha_inicio_estimada) and isset($nombre_empresa_practica) and isset($direccion_empresa_practica) and isset($departamento_practica) and isset($nombre_jefe_inmediato) and isset($titulo_jefe_inmediato) and isset($cargo_jefe_inmediato) and isset($correo_jefe_inmediato) and isset($telefono_jefe_inmediato))
{


 
    if ($resultado2 === TRUE)
                         {


                          if ($resultado === TRUE) {
                            $Id_objeto=6002; 
                          bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INSERTO' , 'UNA SOLICITUD PPS EL ESTUDIANTE '.$identidad_estudiante.'');

                          echo '<script type="text/javascript">
                            swal({
                             title:"Guardado!",
                             text:"Los datos  se almacenaron correctamente",
                             type: "success",
                             showConfirmButton: false,
                             timer: 3000
                             });
                             $(".FormularioAjax")[0].reset();
                             </script>'; 
                           } 
                           else{
                            echo '<script type="text/javascript">
                            swal({
                             title:"Error",
                             text:"Lo sentimos los datos no fueron guardados correctamente",
                             type: "error",
                             showConfirmButton: false,
                             timer: 3000
                             });
                             $(".FormularioAjax")[0].reset();
                             </script>'; 

                           }
         
                          }else {
                            echo '<script type="text/javascript">
                            swal({
                             title:"Error",
                             text:"Empresa no registrada",
                             type: "error",
                             showConfirmButton: false,
                             timer: 3000
                             });
                             $(".FormularioAjax")[0].reset();
                             </script>'; 
                          }
 

       
}

else
{
  
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



//  if ($solicitud_charla_existe === TRUE) {
// }else {
//     echo '<script type="text/javascript">
//                             swal({
//                              title:"Charla PPS",
//                              text:"No cuenta con la constancia de charla PPS",
//                              type: "error",
//                              showConfirmButton: false,
//                              timer: 3000
//                              });
//                              $(".FormularioAjax")[0].reset();
//                              </script>'; 
//   } 

 ob_end_flush();
?>



