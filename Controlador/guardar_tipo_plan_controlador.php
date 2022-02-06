<?php
session_start();

require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');

$Id_objeto = 101;

//obtener el valor del input mediante metodo post
$nombre_plan = ($_POST['tipo_plan']);




///Logica para el que se repite
$sqlexiste = ("select count(nombre) as nombre from tbl_tipo_plan where nombre='$nombre_plan'");
//Obtener la fila del query
$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));

/* Logica para que no acepte campos vacios */
if ($_POST['tipo_plan']  <> '') {

    // /* Condicion para que no se repita el periodo*/
    if ($existe['nombre'] == 1) {
        echo '<script type="text/javascript">
        swal({
           title:"Informacion",
           text:"Ya existe el nombre ",
           type: "error",
           showConfirmButton: false,
           timer: 3000
        });
    </script>';
    } else {
        $sql = "call proc_insertar_nombre_tipo_plan('$nombre_plan','$_SESSION[usuario]')";
        $resultado = $mysqli->query($sql);

            if ($resultado === TRUE) {
                bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INSERTO', 'EL NOMBRE DEL TIPO PLAN:  ' . $nombre_plan . '');

                echo '<script type="text/javascript">
             document.getElementById("btn_guardar_tipo_plan").enable=true;
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
                         window.location = "../vistas/mantenimiento_crear_tipo_plan_vista.php";
                     </script>';
            } else {
                echo "Error: " . $sql;
            }

              
        
    }
} else {
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