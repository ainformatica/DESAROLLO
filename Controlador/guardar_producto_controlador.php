<?php
ob_start();
	session_start();

require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');


  $Id_objeto=194; 
 



$Producto=mb_strtoupper ($_POST['txt_nombre_producto']);
$Descripcion=mb_strtoupper ($_POST['txt_descripcion']);
$tipo_producto=$_POST['cmb_tipoproducto'];

if ($tipo_producto==1){
  $stock=0;
}else{
  $stock=$_POST['stock'];
}	

$_SESSION['nombrePrueba']=$_POST['txt_nombre_producto'];
         		
$var=0;

 $estado= '';
///verificar si el producto existe





$patron_texto = "/^[a-zA-ZáéíóúÁÉÍÓÚ_äëïöüÄËÏÖÜàèìòùÀÈÌÒÙÑ0123456789_\s]+$/";
if( preg_match($patron_texto, $_POST['txt_nombre_producto']  ) )
{ 

  if( preg_match($patron_texto,$_POST['txt_descripcion'] ) )
  {

        $sqlexiste=("select count(nombre_producto) as nombre_producto  from tbl_productos where nombre_producto='$Producto'");
        //Obtener la fila del query
      $existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));

        /* Logica para que no acepte campos vacios */
              if ($_POST['txt_nombre_producto']  <>"" and  $_POST['txt_descripcion']<>"" and $_POST['cmb_tipoproducto']>0)
              {

              
                /* Condicion para que no se repita el producto*/
                  if ($existe['nombre_producto']==1)
                  {
                
                  echo '<script type="text/javascript">
                                  swal({
                                    title:"",
                                    text:"Lo sentimos el PRODUCTO ya existe",
                                    type: "error",
                                    showConfirmButton: false,
                                    timer: 3000
                                  });
                              </script>';
                  }
                else
                {
        

                    /* Query para que haga el insert*/
                    $sql = "call proc_insertar_productoss('$Producto','$Descripcion','$stock','$tipo_producto')";
                    $resultado = $mysqli->query($sql);
                  

    			

                  if($resultado === TRUE) 
                  {
                            bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INSERTO' , 'EL PRODUCTO '.$Producto.'');
                         
                          if ($tipo_producto==2)
                          {

                            $sql = "call proc_insertar_producto_inicializado2('$Producto');";
                            $resultado = $mysqli->query($sql);

                            echo '<script type="text/javascript">
                            swal({
                              title:"",
                              text:"Proceso Finalizado",
                              type: "success",
                              showConfirmButton: false,
                              timer: 6000
                           });
                      
                            window.location = "../vistas/gestion_producto_vista.php";

                        $(".FormularioAjax")[0].reset();

                          </script>';

                           }
                           else
                           {
                            echo '<script type="text/javascript">
                            swal({
                              title:"",
                              text:"Agregue caracteristicas a su producto" ,
                              type: "success",
                              showConfirmButton: false,
                              timer: 6000
                           });
                      
                            window.location = "../vistas/crear_caracteristicas_producto_vista.php";

                        $(".FormularioAjax")[0].reset();

                          </script>'; 
                                  
                            } 



                     

                  } else 
                  {
                    echo "Error: " . $sql ;
                  }
                }




              } elseif($stock<0 || $stock>100 and ($Producto<>'' and $Descripcion<>"" and $_POST['cmb_tipoproducto']>0))
              {
                echo '<script type="text/javascript">
                swal({
                  title:"",
                  text:"Campo de stock incorrecto",
                  type: "error",
                  showConfirmButton: false,
                  timer: 3000
                });
              </script>';

              }else{
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








  }  else{   
    echo '<script type="text/javascript">
    swal({
    title:"",
    text:"La descripcion solo puede contener espacios, letras y numeros",
    type: "error",
    showConfirmButton: false,
    timer: 3000
    });
  </script>';       
  }
        




    

}  else{   
  echo '<script type="text/javascript">
  swal({
  title:"",
  text:"El nombre solo puede contener espacios, letras y numeros",
  type: "error",
  showConfirmButton: false,
  timer: 3000
  });
</script>';       
}
ob_end_flush();
?>