<?php
ob_start();
        session_start();

        require_once ('../clases/Conexion.php');
        require_once ('../clases/funcion_bitacora.php');
        
        
          $Id_objeto=195; 
         
          $Combo=$_POST['cmb_tipocaracteristicas'];	
         
          $Producto=mb_strtoupper($_POST['txt_nombre_oculto']); //el producto que trae


          
          //  //Obtener la fila del query
          $sql = "select tipo_caracteristica FROM tbl_tipo_caracteristica WHERE id_tipo_caracteristica = '$Combo'";
          $resultado = $mysqli->query($sql);
          /* Manda a llamar la fila */
          $row = $resultado->fetch_array(MYSQLI_ASSOC);
      
        
         //         variable               viene de la BD
         $caracteristica= $row['tipo_caracteristica'];     
          



        if ($Combo>0)
        {               
               
                $id_tipo_caracteristica_=intval($Combo);
                $sqlexiste="SELECT count(id_tipo_caracteristica) as tipo from tbl_caracteristicas_producto where id_tipo_caracteristica='$id_tipo_caracteristica_' and id_producto=(SELECT MAX(id_producto) from tbl_productos);";

                $existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));
                 
                if ($existe['tipo']==1)
                {
                        echo '<script type="text/javascript">
                        swal({
                            title: "",
                            text: "Lo sentimos esta caracteristica ya existe",
                            type: "info",
                            showConfirmButton: false,
                            timer: 3000
                        });
                    
                    </script>';
                }else
                {




                        $sql = "call proc_insertar_nueva_caracteristica ('$Producto', $Combo  )" ;
                        $resultado = $mysqli->query($sql);
                        
                        if ($resultado == true) {
                            bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INSERTO' , 'LA CARACTERISTICA: '.$caracteristica.' AL PRODUCTO: '.$Producto.'');

                
                            echo '<script type="text/javascript">
                            swal({
                                title:"",
                                text:"Los datos  se almacenaron correctamente",
                                type: "success",
                                showConfirmButton: false,
                                timer: 6000
                              });
                              $(".FormularioAjax")[0].reset();
                              window.location = "../vistas/crear_caracteristicas_producto_vista.php";
                          </script>';

                            } else {
                                header("location:../vistas/crear_caracteristicas_producto_vista.php?msj=3");
                            }

                }

                



        }else
{       
        echo '<script type="text/javascript">
        swal({
            title: "",
            text: "Debe seleccionar una caracteristica.",
            type: "error",
            showConfirmButton: false,
            timer: 3000
        });
    
    </script>';

        
        }



       
        
    
        ob_end_flush();
        
?>







       
    
   