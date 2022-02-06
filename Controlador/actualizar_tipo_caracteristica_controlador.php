<?php
ob_start();
session_start();

require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');

$Id_objeto = 200;
$tipo_caracteristica = mb_strtoupper($_POST['txt_tipocaracteristica']);
$id_tipo_caracteristica = $_GET['id_tipo_caracteristica'];
$tipo_dato = $_POST['cb_tipo_dato'];

if ($tipo_dato==1)
{
    $nuevo='LETRAS';
    
    }elseif ( $tipo_dato==2)
    {
    $nuevo='NUMEROS';
    }else
    {
    $nuevo='LETRAS Y NUMEROS';
    }
// echo $tipo_caracteristica;
// echo $id_tipo_caracteristica;
// echo $tipo_dato;

// $tipo_dato=$_POST['cb_tipo_dato'];

$patron_texto = "/^[a-zA-ZáéíóúÁÉÍÓÚ_äëïöüÄËÏÖÜàèìòùÀÈÌÒÙ\s]+$/";
if( preg_match($patron_texto, $_POST['txt_tipocaracteristica']) )
{

            /* Iniciar la variable de sesion y la crea */


            ///Logica para el tipo de caracteristica que se repite
            $sqlexiste = ("select count(tipo_caracteristica) as tipo_caracteristica from tbl_tipo_caracteristica where tipo_caracteristica='$tipo_caracteristica' and id_tipo_caracteristica<>'$id_tipo_caracteristica' ;");
            //Obtener la fila del query
            $existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));

    if ($_POST['txt_tipocaracteristica']  <>"" and $_POST['cb_tipo_dato']>0 )
    {

            if ($existe['tipo_caracteristica'] == 1) {
                echo '<script type="text/javascript">
                swal({
                    title:"",
                    text: "El nombre de la caracteristica ya existe!",
                    type: "success",
                    showConfirmButton: false,
                    timer: 6000
                  });
                  $(".FormularioAjax")[0].reset();
                  window.location = "../vistas/mantenimiento_tipo_caracteristica_vista.php";
              </script>';
            


            } else {

                            $sql = "call proc_actualizar_tipo_caracteristica('$tipo_caracteristica','$id_tipo_caracteristica','$tipo_dato' )";
                            $valor = "select tipo_caracteristica,validacion from tbl_tipo_caracteristica WHERE id_tipo_caracteristica= '$id_tipo_caracteristica'";
                            $result_valor = $mysqli->query($valor);
                            $valor_viejo = $result_valor->fetch_array(MYSQLI_ASSOC);

                            if ($valor_viejo['tipo_caracteristica'] <> $tipo_caracteristica and $valor_viejo['validacion'] <> $tipo_dato  )
                            {
                                
                                bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'EL TIPO caracteristica ' . $valor_viejo['tipo_caracteristica'] . ' POR ' . $tipo_caracteristica . ' Y EL TIPO DE DATO A: '.$nuevo. '  ');
                                /* Hace el query para que actualize*/

                                $resultado = $mysqli->query($sql);

                                if ($resultado == true) {
                                    echo '<script type="text/javascript">
                                    swal({
                                        title:"",
                                        text: "Los datos se almacenaron correctamente",
                                        type: "success",
                                        showConfirmButton: false,
                                        timer: 6000
                                      });
                                      $(".FormularioAjax")[0].reset();
                                      window.location = "../vistas/mantenimiento_tipo_caracteristica_vista.php";
                                  </script>';
                                } else {
                                    header("location:../vistas/mantenimiento_tipo_caracteristica_vista.php?msj=8");
                                }
                            }elseif($valor_viejo['tipo_caracteristica'] <> $tipo_caracteristica )
                            {

                                bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'EL TIPO caracteristica ' . $valor_viejo['tipo_caracteristica'] . ' POR ' . $tipo_caracteristica .'  ');
                                /* Hace el query para que actualize*/

                                $resultado = $mysqli->query($sql);

                                if ($resultado == true) {
                                    echo '<script type="text/javascript">
                                    swal({
                                        title:"",
                                        text: "Los datos se almacenaron correctamente",
                                        type: "success",
                                        showConfirmButton: false,
                                        timer: 6000
                                      });
                                      $(".FormularioAjax")[0].reset();
                                      window.location = "../vistas/mantenimiento_tipo_caracteristica_vista.php";
                                  </script>';
                                } else {
                                    header("location:../vistas/mantenimiento_tipo_caracteristica_vista.php?msj=8");
                                }
                            }
                            
                            elseif ($valor_viejo['validacion'] <> $tipo_dato  )

                            {
                             
                                bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO',  '  EL TIPO DE DATO A: '.$nuevo. ' ,DE LA CARACTERISTICA '.$tipo_caracteristica. ' '   );
                                /* Hace el query para que actualize*/

                                $resultado = $mysqli->query($sql);

                                if ($resultado == true) {
                                    echo '<script type="text/javascript">
                                    swal({
                                        title:"",
                                        text: "Los datos se almacenaron correctamente",
                                        type: "success",
                                        showConfirmButton: false,
                                        timer: 6000
                                      });
                                      $(".FormularioAjax")[0].reset();
                                      window.location = "../vistas/mantenimiento_tipo_caracteristica_vista.php";
                                  </script>';
                                } else {
                                    header("location:../vistas/mantenimiento_tipo_caracteristica_vista.php?msj=8");
                                }

                            } else
                            {
                                header("location:../vistas/mantenimiento_tipo_caracteristica_vista.php?msj=4");
 
                            }



                    }

      
    }else if ($_POST['cb_tipo_dato']<0)
        {
            echo '<script type="text/javascript">
            swal({
                title:"",
                text: "Seleccione un tipo de dato!",
                type: "error",
                showConfirmButton: false,
                timer: 6000
              });
              $(".FormularioAjax")[0].reset();
              window.location = "../vistas/mantenimiento_tipo_caracteristica_vista.php";
          </script>';
        }
        else
            {
                header("location:../vistas/mantenimiento_tipo_caracteristica_vista.php?msj=5");

            }




}
else{   
   
    echo '<script type="text/javascript">
    swal({
        title:"",
        text: "Nombre no Válido!",
        type: "error",
        showConfirmButton: false,
        timer: 6000
      });
      $(".FormularioAjax")[0].reset();
      window.location = "../vistas/mantenimiento_tipo_caracteristica_vista.php";
  </script>';

    }  


    ob_end_flush();       
    ?>