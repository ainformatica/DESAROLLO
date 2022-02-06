<?php
 session_start();
ob_start();

 require_once ('../clases/Conexion.php');
 require_once ('../clases/funcion_bitacora.php'); 

        $Id_objeto = 102 ;


    $nombre =($_POST['nombre']);
    $id_tipo_plan = $_GET['id_tipo_plan'];

 
///Logica para el que se repite
$sqlexiste = ("select nombre from tbl_tipo_plan where nombre = '$nombre'");


 //Obtener la fila del query
$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));


/* Logica para que no acepte campos vacios */
if ($_POST['nombre'] <> '')
{
   
  /* Condicion para que no se repita el rol*/
            if ($existe <> '') {
                header("location:../vistas/mantenimiento_tipo_plan_vista.php?msj=1");

             }else{
                $sql = "call proc_actualizar_nombre_tipo_plan('$nombre','$_SESSION[usuario]','$id_tipo_plan' )";
                $resultado = $mysqli->query($sql);
       
        
	        if($resultado === TRUE) 
          {
                    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'MODIFICO' , 'EL PERIODO DE PLAN '. $periodo.'');

                header("location:../vistas/mantenimiento_tipo_plan_vista.php?msj=2");
           
			} 
			else 
			{
                header("location:../vistas/mantenimiento_tipo_plan_vista.php?msj=3");
			}



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


