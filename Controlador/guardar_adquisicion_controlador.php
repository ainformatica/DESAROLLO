<?php

  ob_start();
	session_start();

require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');
require_once ('../clases/funcion_bitacora.php');

  $Id_objeto=211; 
 


  /* Aqui obtengo el id_estado_civil de la tabla de la base el cual me sirve para enviarla a la pagina actualizar.php para usarla en el where del update   */
  $hoy= date("DD/MM/AAAA");
$sql = "SELECT * FROM tbl_estado WHERE estado = 'procesado'";
$resultado = $mysqli->query($sql);
$row = $resultado->fetch_array(MYSQLI_ASSOC);
  


$tipo_adquisicion=$_POST['cmb_tipoadquisicion'];
$Descripcion=strtoupper ($_POST['txt_descripcion']);
$fecha=strtoupper ($_POST['txt_fechaAdquisicion']);	
$estado=$row['id_estado'];	
$usuario=$_SESSION['id_usuario'];

         		

/* Logica para que no acepte campos vacios */
if  ($_POST['txt_descripcion']<> '' and $_POST['txt_fechaAdquisicion']> '' and $_POST['cmb_tipoadquisicion']>0)
{

        
        /* Query para que haga el insert, procedimiento almacenado para ingresar adquisiciomes*/ 
	$sql = "call proc_insertar_adquisicion('$tipo_adquisicion','$Descripcion','$usuario','$fecha','$estado')";
	$resultado = $mysqli->query($sql);
 

    			

	        if($resultado === TRUE) 
          {
                    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INSERTO' , 'LA ADQUISICION CON DESCRIPCION: '.$Descripcion.'');
                    
         echo '<script type="text/javascript">
        
              window.location = "../vistas/crear_detalle_adquisicion_vista.php";

           $(".FormularioAjax")[0].reset();

             </script>'; 
                           

			} 
			else 
			{
    		echo "Error: " . $sql ;
			}
 }

 elseif ( $_POST['txt_fechaAdquisicion']>$hoy )
 {
 
   echo '<script type="text/javascript">
   swal({
   title:"",
   text:"Fecha Invalida",
   type: "warning",
   showConfirmButton: false,
   timer: 3000
   });
   
 
   
 
 
   </script>';
 }
 else


{

  echo '<script type="text/javascript">
                                    swal({
                                       title:"",
                                       text:"Lo sentimos tiene campos por rellenar",
                                       type: "warning",
                                       showConfirmButton: false,
                                       timer: 3000
                                    });
                                   

                                   


                                </script>';
                                
}

ob_end_flush();

?>