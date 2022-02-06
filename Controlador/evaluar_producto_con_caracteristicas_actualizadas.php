<?php
       ob_start();
       session_start();
      

        require_once ('../clases/Conexion.php');
        require_once ('../clases/funcion_bitacora.php');
        
        
          $Id_objeto=195; 

          $id="";
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        }
          
          
         
        //   $Producto=$_POST['nombre_prueba']; //el producto que trae


    $sqlexiste="SELECT count(id_tipo_caracteristica) as contador from tbl_caracteristicas_producto where id_producto='$id'; ";

    $existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));
    
    if ($existe['contador']==0)
    {
          echo '<script type="text/javascript">
          swal({
              title:"",
              text:"Debe agregar por lo menos 1 caracteristica a su producto",
              type: "error",
              showConfirmButton: false,
              timer: 20000
            });
            $(".FormularioAjax")[0].reset();
          window.location = "../vistas/editar_caracteristicas_producto_vista.php";

        </script>'
        ;          

    }
    else
    {
          echo '<script type="text/javascript">
          swal({
              title:"",
              text:"Actualización Finalizada!",
              type: "success",
              showConfirmButton: false,
              timer: 30000
            });
            $(".FormularioAjax")[0].reset();
          window.location = "../vistas/gestion_producto_vista.php";

        </script>'
        ;          


    }

                
  
ob_end_flush();
?>
          
         
        
          
     