<?php
	
require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');
$Id_objeto=209;      
       $vacio="";
       
        // Si está vacío, lo informamos, sino realizamos la búsqueda
        if (empty($_POST['palabra'])) {
            $_SESSION['producto']=$vacio;
            $_SESSION['caracteristicas']=$vacio;
            $_SESSION['num_inventario']=$vacio;
            
        } else {        
            $buscar = $_POST['palabra'];
            $sql = "select id_detalle as id from tbl_detalle_adquisiciones where numero_inventario='$buscar';";
            $resultado = $mysqli->query($sql);
            /* Manda a llamar la fila */
            $row = $resultado->fetch_array(MYSQLI_ASSOC);
            $id=$row['id'];



            $sqlexiste = "SELECT count(id_detalle) as contador from tbl_motivo_salida where id_detalle='$id';";
            $existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));
           
            $sqlexiste1=("select count(id_detalle) as detalle  from tbl_detalle_adquisiciones where id_detalle='$id';");

            $existe1= mysqli_fetch_assoc($mysqli->query($sqlexiste1));

            if ($existe['contador'] == 1) {
                $_SESSION['producto']=$vacio;
                $_SESSION['caracteristicas']=$vacio;
                $_SESSION['num_inventario']=$vacio;
                echo '<script type="text/javascript">
                    swal({
                        title: "",
                        text: "Lo sentimos el producto ya fué dado de baja",
                        type: "info",
                        showConfirmButton: false,
                        timer: 3000
                    });
                </script>';
                }elseif($existe1['detalle']==0){
                    echo '<script type="text/javascript">
                    swal({
                        title: "",
                        text: "Lo sentimos ese producto no existe",
                        type: "info",
                        showConfirmButton: false,
                        timer: 3000
                    });
                </script>';

            
            }else {
                $sql = "call select_buscar_producto_salida3('$buscar');";
                $resultado = $mysqli->query($sql);
                if ($resultado == true) {
                    $valor = $resultado->fetch_array(MYSQLI_ASSOC);
                    $_SESSION['producto']=$valor['producto'];
                    $_SESSION['caracteristicas']=$valor['caracteristicas'];
                    $_SESSION['num_inventario']=$buscar;    
                }



            }
            
            }


?>

































