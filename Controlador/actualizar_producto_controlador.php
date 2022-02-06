<?php
ob_start();
session_start();

require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');

$Id_objeto=194; 

//$Id_producto=intval( $_GET['id_producto']);
$id_producto_=intval($_POST['txt_']);
$nombre_producto_=strtoupper($_POST['txt_nombre_producto']);
$descripcion_producto_= strtoupper($_POST['txt_descripcion']);
if (isset($_POST['stock2'])) {
    $stock=intval($_POST['stock2']);
}else if (empty($_GET['stock_minimo_'])) {
    $stock=intval($_SESSION['stock_minimo_']);
}

// $stock=intval($_POST['stock2']);
$tipo_producto=intval( $_SESSION['tipo_producto_']);
//TRAIGO EL NOMBRE DEL PRODUCTO QUE INTRODUJO EL USUARIO
$_SESSION['producto_enviado']=$_POST['txt_nombre_producto'];





$patron_texto = "/^[a-zA-ZáéíóúÁÉÍÓÚ_ÑñäëïöüÄËÏÖÜàèìòùÀÈÌÒÙÑñ0123456789_\s]+$/";
if( preg_match($patron_texto, $_POST['txt_nombre_producto']) )
{ 
    if( preg_match($patron_texto,$_POST['txt_descripcion'] ) )
    {

///verificar si se repite 
$sqlexiste = ("select count(nombre_producto) as nombre_producto from tbl_productos where nombre_producto='$nombre_producto_' and id_producto<>'$id_producto_' ;");

// //Obtener la fila del query
$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));


/* validacion para que no acepte campos vacios */
if ($_POST['txt_nombre_producto']  <>"" and  $_POST['txt_descripcion']<>"" and  $_SESSION['tipo_producto_']>0 )
{

//     //NO CONTINUARA PORQUE ESTA REPETIDO
    if ($existe['nombre_producto'] == 1) {
        
        echo '<script type="text/javascript">
          swal({
              title: "",
              text: "Lo sentimos el producto ya existe",
              type: "info",
              showConfirmButton: false,
              timer: 3000
          });
      </script>';
    } 
       else if ($existe['nombre_producto'] < 1)
       { 
                //no hay repetidos 
                $sql = "call proc_actualizar_productos('$id_producto_','$nombre_producto_','$descripcion_producto_','$stock','$tipo_producto' )";
            
                //CONTIENE LOS DATOS ANTES DE LA ACTUALIZACION DEL PRODUCTO
                $valor="select * from tbl_productos WHERE id_producto= '$id_producto_'";
                $result_valor = $mysqli->query($valor);
                $valor_viejo = $result_valor->fetch_array(MYSQLI_ASSOC);

                //DEPOSITAR ESOS  VALORES 
                $_SESSION['ARRAY_VIEJO'] = array();
                $_SESSION['ARRAY_VIEJO']=$valor_viejo;
               
                if ($valor_viejo['nombre_producto']<>$nombre_producto_ and $valor_viejo['descripcion_producto']<>$descripcion_producto_ and $valor_viejo['stock_minimo']<>$stock and $valor_viejo['id_tipo_producto']<>$tipo_producto)
                {
                    //4 CAMPOS 
                    $Id_objeto=194 ;
                bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'MODIFICO' , ' EL NOMBRE '.$valor_viejo['nombre_producto'].' POR '.$nombre_producto_.' ,LA DESCRIPCION DEL PRODUCTO ' .$valor_viejo['descripcion_producto']. ' POR '  .$descripcion_producto_.  ' ,EL STOCK MINIMO ' .$valor_viejo['stock_minimo'].  ' POR ' .$stock. ' Y EL TIPO DE PRODUCTO DE ' .$valor_viejo['id_tipo_producto']. ' A ' .$tipo_producto.  ' ' );  

                    $resultado = $mysqli->query($sql);

                    if ($resultado == true) {
                        echo '<script type="text/javascript">
                        window.location="../vistas/editar_caracteristicas_producto_vista.php";
                        </script>';
                    } else {

                        echo '<script type="text/javascript">
                            swal({
                                title: "",
                                text: "Error al actualizar lo sentimos,intente de nuevo.",
                                type: "error",
                                showConfirmButton: false,
                                timer: 3000
                            });
                        </script>'; 
                        
                    }  
    
                }else if ($valor_viejo['nombre_producto']<>$nombre_producto_ and $valor_viejo['descripcion_producto']<>$descripcion_producto_ and $valor_viejo['stock_minimo']<>$stock)
                {
                    //3 CAMPOS
                    $Id_objeto=194 ;
                    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'MODIFICO' , ' EL NOMBRE '.$valor_viejo['nombre_producto'].' POR '.$nombre_producto_.' ,LA DESCRIPCION DEL PRODUCTO ' .$valor_viejo['descripcion_producto']. ' POR '  .$descripcion_producto_.  ' Y EL STOCK MINIMO ' .$valor_viejo['stock_minimo'].  ' A ' .$stock.   ' ' );  
                    
                    $resultado = $mysqli->query($sql);

                    if ($resultado == true) {
                        

                        if ($tipo_producto==2)
                        {
                          echo '<script type="text/javascript">
                          swal({
                            title:"",
                            text:"Proceso Finalizado",
                            type: "success",
                            showConfirmButton: false,
                            timer: 8000
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
                    
                          window.location = "../vistas/editar_caracteristicas_producto_vista.php";

                      $(".FormularioAjax")[0].reset();

                        </script>'; 
                                
                          } 

                    } else {

                        echo '<script type="text/javascript">
                            swal({
                                title: "",
                                text: "Error al actualizar lo sentimos,intente de nuevo.",
                                type: "error",
                                showConfirmButton: false,
                                timer: 3000
                            });
                        </script>'; 
                        
                    }  
    
                }else if ($valor_viejo['nombre_producto']<>$nombre_producto_ and $valor_viejo['descripcion_producto']<>$descripcion_producto_ and $valor_viejo['id_tipo_producto']<>$tipo_producto)
                {
                    //3 CAMPOS
                    $Id_objeto=194 ;
                    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'MODIFICO' , ' EL NOMBRE '.$valor_viejo['nombre_producto'].' POR '.$nombre_producto_.' ,LA DESCRIPCION DEL PRODUCTO ' .$valor_viejo['descripcion_producto']. ' POR '  .$descripcion_producto_.  ' Y EL TIPO DE PRODUCTO DE ' .$valor_viejo['id_tipo_producto']. ' A ' .$tipo_producto.  ' ' );  
                    
                    $resultado = $mysqli->query($sql);

                    if ($resultado == true) {
                        echo '<script type="text/javascript">
                        window.location="../vistas/editar_caracteristicas_producto_vista.php";
                        </script>';
                    } else {

                        echo '<script type="text/javascript">
                            swal({
                                title: "",
                                text: "Error al actualizar lo sentimos,intente de nuevo.",
                                type: "error",
                                showConfirmButton: false,
                                timer: 3000
                            });
                        </script>'; 
                        
                    }  
    
                }else if ($valor_viejo['nombre_producto']<>$nombre_producto_ and $valor_viejo['stock_minimo']<>$stock and $valor_viejo['id_tipo_producto']<>$tipo_producto )
                {
                    //3 CAMPOS
                    $Id_objeto=194 ;
                    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'MODIFICO' , ' EL NOMBRE '.$valor_viejo['nombre_producto'].' POR '.$nombre_producto_. ' ,EL STOCK MINIMO ' .$valor_viejo['stock_minimo'].  ' A ' .$stock.  ' Y EL TIPO DE PRODUCTO DE ' .$valor_viejo['id_tipo_producto']. ' A ' .$tipo_producto.  ' ' );  
                    
                    $resultado = $mysqli->query($sql);

                    if ($resultado == true) {
                        echo '<script type="text/javascript">
                        window.location="../vistas/editar_caracteristicas_producto_vista.php";
                        </script>';
                    } else {

                        echo '<script type="text/javascript">
                            swal({
                                title: "",
                                text: "Error al actualizar lo sentimos,intente de nuevo.",
                                type: "error",
                                showConfirmButton: false,
                                timer: 3000
                            });
                        </script>'; 
                        
                    }  
    
                }else if ($valor_viejo['descripcion_producto']<>$descripcion_producto_ and $valor_viejo['stock_minimo']<>$stock and $valor_viejo['id_tipo_producto']<>$tipo_producto)
                {
                    //3 CAMPOPS
                    $Id_objeto=194 ;
                    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'MODIFICO' , ' LA DESCRIPCION DEL PRODUCTO ' .$valor_viejo['descripcion_producto']. ' POR '  .$descripcion_producto_.  ' ,EL STOCK MINIMO ' .$valor_viejo['stock_minimo'].  ' POR ' .$stock. ' Y EL TIPO DE PRODUCTO DE ' .$valor_viejo['id_tipo_producto']. ' A ' .$tipo_producto.  ' ' );  
                    
                    $resultado = $mysqli->query($sql);

                    if ($resultado == true) {
                        echo '<script type="text/javascript">
                        window.location="../vistas/editar_caracteristicas_producto_vista.php";
                        </script>';
                    } else {

                        echo '<script type="text/javascript">
                            swal({
                                title: "",
                                text: "Error al actualizar lo sentimos,intente de nuevo.",
                                type: "error",
                                showConfirmButton: false,
                                timer: 3000
                            });
                        </script>'; 
                        
                    }  
    
                }else if ($valor_viejo['nombre_producto']<>$nombre_producto_ and $valor_viejo['descripcion_producto']<>$descripcion_producto_)
                {
                    //2 CAMPOS
                    $Id_objeto=194 ;
                    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'MODIFICO' , ' EL NOMBRE '.$valor_viejo['nombre_producto'].' POR '.$nombre_producto_.' , LA DESCRIPCION DEL PRODUCTO ' .$valor_viejo['descripcion_producto']. ' POR '  .$descripcion_producto_.   ' ' );  

                    $resultado = $mysqli->query($sql);

                    if ($resultado == true) {
                        if ($tipo_producto==2)
                          {
                            echo '<script type="text/javascript">
                            swal({
                              title:"",
                              text:"Proceso Finalizado",
                              type: "success",
                              showConfirmButton: false,
                              timer: 8000
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
                      
                            window.location = "../vistas/editar_caracteristicas_producto_vista.php";

                        $(".FormularioAjax")[0].reset();

                          </script>'; 
                                  
                            } 




                    } else {

                        echo '<script type="text/javascript">
                            swal({
                                title: "",
                                text: "Error al actualizar lo sentimos,intente de nuevo.",
                                type: "error",
                                showConfirmButton: false,
                                timer: 3000
                            });
                        </script>'; 
                        
                    }  
    
                }else if ($valor_viejo['nombre_producto']<>$nombre_producto_ and $valor_viejo['stock_minimo']<>$stock)
                {
                    //2 CAMPOS
                    $Id_objeto=194 ;
                    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'MODIFICO' , ' EL NOMBRE '.$valor_viejo['nombre_producto'].' POR '.$nombre_producto_. ' ,EL STOCK MINIMO ' .$valor_viejo['stock_minimo'].  ' A ' .$stock.  ' ' );  
                    
                    $resultado = $mysqli->query($sql);

                    if ($resultado == true) {
                       

                        if ($tipo_producto==2)
                        {
                          echo '<script type="text/javascript">
                          swal({
                            title:"",
                            text:"Proceso Finalizado",
                            type: "success",
                            showConfirmButton: false,
                            timer: 8000
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
                    
                          window.location = "../vistas/editar_caracteristicas_producto_vista.php";

                      $(".FormularioAjax")[0].reset();

                        </script>'; 
                                
                          } 


                    } else {

                        echo '<script type="text/javascript">
                            swal({
                                title: "",
                                text: "Error al actualizar lo sentimos,intente de nuevo.",
                                type: "error",
                                showConfirmButton: false,
                                timer: 3000
                            });
                        </script>'; 
                        
                    }  
    
                }else if ($valor_viejo['nombre_producto']<>$nombre_producto_ and $valor_viejo['id_tipo_producto']<>$tipo_producto)
                {
                    //2 CAMPOS
                    $Id_objeto=194 ;
                    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'MODIFICO' , ' EL NOMBRE '.$valor_viejo['nombre_producto'].' POR '.$nombre_producto_. ' Y EL TIPO DE PRODUCTO DE ' .$valor_viejo['id_tipo_producto']. ' A ' .$tipo_producto.  ' ' );  

                    $resultado = $mysqli->query($sql);

                    if ($resultado == true) {
                        echo '<script type="text/javascript">
                        window.location="../vistas/editar_caracteristicas_producto_vista.php";
                        </script>';
                    } else {

                        echo '<script type="text/javascript">
                            swal({
                                title: "",
                                text: "Error al actualizar lo sentimos,intente de nuevo.",
                                type: "error",
                                showConfirmButton: false,
                                timer: 3000
                            });
                        </script>'; 
                        
                    }  
    
                }else if ($valor_viejo['descripcion_producto']<>$descripcion_producto_ and $valor_viejo['stock_minimo']<>$stock)
                {
                    //2 CAMPOS
                    $Id_objeto=194 ;
                    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'MODIFICO' , 'LA DESCRIPCION DEL PRODUCTO ' .$valor_viejo['descripcion_producto']. ' POR '  .$descripcion_producto_.  ' ,EL STOCK MINIMO ' .$valor_viejo['stock_minimo'].  ' A ' .$stock.  ' ' );  

                    $resultado = $mysqli->query($sql);

                    if ($resultado == true) {
                      

                        if ($tipo_producto==2)
                        {
                          echo '<script type="text/javascript">
                          swal({
                            title:"",
                            text:"Proceso Finalizado",
                            type: "success",
                            showConfirmButton: false,
                            timer: 8000
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
                    
                          window.location = "../vistas/editar_caracteristicas_producto_vista.php";

                      $(".FormularioAjax")[0].reset();

                        </script>'; 
                                
                          } 

                    } else {

                        echo '<script type="text/javascript">
                            swal({
                                title: "",
                                text: "Error al actualizar lo sentimos,intente de nuevo.",
                                type: "error",
                                showConfirmButton: false,
                                timer: 3000
                            });
                        </script>'; 
                        
                    }  
    
                }else if ($valor_viejo['descripcion_producto']<>$descripcion_producto_ and $valor_viejo['id_tipo_producto']<>$tipo_producto)
                {
                    //2 CAMPOS
                    $Id_objeto=194 ;
                    //bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'MODIFICO' , ' EL NOMBRE '.$valor_viejo['nombre_producto'].' POR '.$nombre_producto_. ', LA DESCRIPCION DEL PRODUCTO ' .$nombre_producto_ .', EL STOCK Y EL TIPO DE PRODUCTO DE ' .$nombre_producto_. ' ');  
                    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'MODIFICO' , 'LA DESCRIPCION DEL PRODUCTO ' .$valor_viejo['descripcion_producto']. ' POR '  .$descripcion_producto_.   ' Y EL TIPO DE PRODUCTO DE ' .$valor_viejo['id_tipo_producto']. ' A ' .$tipo_producto.  ' ' );  

                    $resultado = $mysqli->query($sql);

                    if ($resultado == true) {
                        echo '<script type="text/javascript">
                        window.location="../vistas/editar_caracteristicas_producto_vista.php";
                        </script>';
                    } else {

                        echo '<script type="text/javascript">
                            swal({
                                title: "",
                                text: "Error al actualizar lo sentimos,intente de nuevo.",
                                type: "error",
                                showConfirmButton: false,
                                timer: 3000
                            });
                        </script>'; 
                        
                    }  
    
                }else if ($valor_viejo['stock_minimo']<>$stock and $valor_viejo['id_tipo_producto']<>$tipo_producto)
                {
                    //2 CAMPOS
                    $Id_objeto=194 ;
                    //bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'MODIFICO' , ' EL NOMBRE '.$valor_viejo['nombre_producto'].' POR '.$nombre_producto_. ', LA DESCRIPCION DEL PRODUCTO ' .$nombre_producto_ .', EL STOCK Y EL TIPO DE PRODUCTO DE ' .$nombre_producto_. ' ');  
                    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'MODIFICO' ,  'EL STOCK MINIMO ' .$valor_viejo['stock_minimo'].  ' A ' .$stock. ' Y EL TIPO DE PRODUCTO DE ' .$valor_viejo['id_tipo_producto']. ' A ' .$tipo_producto.  ' ' );  

                    $resultado = $mysqli->query($sql);

                    if ($resultado == true) {
                        echo '<script type="text/javascript">
                        window.location="../vistas/editar_caracteristicas_producto_vista.php";
                        </script>';
                    } else {

                        echo '<script type="text/javascript">
                            swal({
                                title: "",
                                text: "Error al actualizar lo sentimos,intente de nuevo.",
                                type: "error",
                                showConfirmButton: false,
                                timer: 3000
                            });
                        </script>'; 
                        
                    }  
    
                }else if ($valor_viejo['nombre_producto']<>$nombre_producto_)
                {
                    //1 CAMPO
                    $Id_objeto=194 ;
                    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'MODIFICO' , ' EL NOMBRE '.$valor_viejo['nombre_producto'].' POR '.$nombre_producto_.  ' ' );  

                    $resultado = $mysqli->query($sql);

                    if ($resultado == true) {
                        if ($tipo_producto==2)
                          {
                            echo '<script type="text/javascript">
                            swal({
                              title:"",
                              text:"Proceso Finalizado",
                              type: "success",
                              showConfirmButton: false,
                              timer: 8000
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
                              timer: 8000
                           });
                      
                            window.location = "../vistas/editar_caracteristicas_producto_vista.php";

                        $(".FormularioAjax")[0].reset();

                          </script>'; 
                                  
                            } 

                    } else {

                        echo '<script type="text/javascript">
                            swal({
                                title: "",
                                text: "Error al actualizar lo sentimos,intente de nuevo.",
                                type: "error",
                                showConfirmButton: false,
                                timer: 3000
                            });
                        </script>'; 
                        
                    }  
    
                }else if ($valor_viejo['descripcion_producto']<>$descripcion_producto_)
                {
                    //1 CAMPO
                    $Id_objeto=194 ;
                    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'MODIFICO' , 'LA DESCRIPCION DEL PRODUCTO ' .$valor_viejo['descripcion_producto']. ' POR '  .$descripcion_producto_.  ' ' );  
                    
                    $resultado = $mysqli->query($sql);

                    if ($resultado == true) {
                        if ($tipo_producto==2)
                        {
                          echo '<script type="text/javascript">
                          swal({
                            title:"",
                            text:"Proceso Finalizado",
                            type: "success",
                            showConfirmButton: false,
                            timer: 8000
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
                            timer: 8000
                         });
                    
                          window.location = "../vistas/editar_caracteristicas_producto_vista.php";

                      $(".FormularioAjax")[0].reset();

                        </script>'; 
                                
                          } 

                    } else {

                        echo '<script type="text/javascript">
                            swal({
                                title: "",
                                text: "Error al actualizar lo sentimos,intente de nuevo.",
                                type: "error",
                                showConfirmButton: false,
                                timer: 3000
                            });
                        </script>'; 
                        
                    }  
    
                }else if ($valor_viejo['stock_minimo']<>$stock)
                {
                    //1 CAMPO
                    $Id_objeto=194 ;
                    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'MODIFICO' ,  'EL STOCK MINIMO ' .$valor_viejo['stock_minimo'].  ' A ' .$stock.  ' ' );  
                    
                    $resultado = $mysqli->query($sql);

                    if ($resultado == true) {
                        

                        if ($tipo_producto==2)
                        {
                          echo '<script type="text/javascript">
                          swal({
                            title:"",
                            text:"Proceso Finalizado",
                            type: "success",
                            showConfirmButton: false,
                            timer: 8000
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
                    
                          window.location = "../vistas/editar_caracteristicas_producto_vista.php";

                      $(".FormularioAjax")[0].reset();

                        </script>'; 
                                
                          } 

                    } else {

                        echo '<script type="text/javascript">
                            swal({
                                title: "",
                                text: "Error al actualizar lo sentimos,intente de nuevo.",
                                type: "error",
                                showConfirmButton: false,
                                timer: 3000
                            });
                        </script>'; 
                        
                    }  
    
                }else if ($valor_viejo['id_tipo_producto']<>$tipo_producto)
                {
                    //1 CAMPO
                    $Id_objeto=194 ;
                    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'MODIFICO' , 'EL TIPO DE PRODUCTO DE ' .$valor_viejo['id_tipo_producto']. ' A ' .$tipo_producto.  ' ' );  
                    
                    $resultado = $mysqli->query($sql);

                    if ($resultado == true) {
                        echo '<script type="text/javascript">
                        window.location="../vistas/editar_caracteristicas_producto_vista.php";
                        </script>';
                    } else {

                        echo '<script type="text/javascript">
                            swal({
                                title: "",
                                text: "Error al actualizar lo sentimos,intente de nuevo.",
                                type: "error",
                                showConfirmButton: false,
                                timer: 3000
                            });
                        </script>'; 
                        
                    }  
                    // SI NO EDITO NADA DEPENDE DEL TIPO DE PRODUCTO IRA A OTRO LUGAR
                    }else {

                        if ($tipo_producto==2)
                        {
                          echo '<script type="text/javascript">
                          swal({
                            title:"",
                            text:"Datos del producto NO editados",
                            type: "error",
                            showConfirmButton: false,
                            timer: 10000
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
                            text:"Datos NO editados,puede actualizar Caracteristicas" ,
                            type: "success",
                            showConfirmButton: false,
                            timer: 20000
                         });
                    
                          window.location = "../vistas/editar_caracteristicas_producto_vista.php";

                      $(".FormularioAjax")[0].reset();

                        </script>'; 
                                
                          } 

                    }

        }else {
            echo '<script type="text/javascript">
            swal({
                title: "",
                text: "Error al actualizar lo sentimos,intente de nuevo.",
                type: "error",
                showConfirmButton: false,
                timer: 3000
            });
        </script>';
        } 

}  //VALIDACION PARA VACIOS 

else if(($_POST['stock2']<0 or $_POST['stock2']>100) and  $_SESSION['tipo_producto_']<1 ){
    echo '<script type="text/javascript">
    swal({
        title:"",
        text:"Campo stock y tipo producto incorrecto",
        type: "error",
        showConfirmButton: false,
        timer: 3000
    });
    </script>';

    }

else if($_POST['stock2']<1 or $_POST['stock2']>100  ){
        echo '<script type="text/javascript">
        swal({
            title:"",
            text:"Campo de stock incorrecto",
            type: "error",
            showConfirmButton: false,
            timer: 3000
        });
        </script>';
    
        } else if ( $_SESSION['tipo_producto_']<1){
            echo '<script type="text/javascript">
        swal({
            title:"",
            text:"Tipo de producto incorrecto",
            type: "error",
            showConfirmButton: false,
            timer: 3000
        });
        </script>';
    } 
     else   {
    
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