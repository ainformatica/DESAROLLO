<?php

ob_start();

session_start();

require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');
require_once('../clases/conexion_mantenimientos.php');



$Id_objeto = 289;
$visualizacion = permiso_ver($Id_objeto);
//$usuario = $_SESSION['id_persona'];



if ($visualizacion == 0) {
    // header('location:  ../vistas/menu_roles_vista.php');
    echo '<script type="text/javascript">
                              swal({
                                   title:"",
                                   text:"¡Lo sentimos! No tiene permiso de visualizar la pantalla",
                                   type: "error",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                           window.location = "../vistas/pagina_principal_vista.php";

                            </script>';
} else {

    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'Ingreso', 'A perfil admin-estudiante');


    // if (permisos::permiso_modificar($Id_objeto) == '1') {
    //     $_SESSION['btn_modificar_roles'] = "";
    // } else {
    //     $_SESSION['btn_modificar_roles'] = "disabled";
    // }
}


$nombre = $_SESSION['usuario'];
$id = $_SESSION['id_usuario'];
$id_persona = $_SESSION['id_persona'];


$sql = "SELECT tp.nombres, tp.apellidos FROM tbl_personas tp INNER JOIN tbl_usuarios us ON us.id_persona=tp.id_persona WHERE us.Id_usuario= $id";
$resultado3 = $mysqli->query($sql);


ob_end_flush();




?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!--  <style >
    #parrafo_comisiones{
        opacity: 0.5;
    }
  
    </style>
 -->

    <style>
        button .full-width {
            width: 100%;

        }
    </style>


</head>


<body>

    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h5>Área Personal-Perfil</h5>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Perfil </li>
                        </ol>
                    </div>

                    <div class="RespuestaAjax"></div>

                </div>
            </div><!-- /.container-fluid -->
        </section>


        <!--Pantalla 2-->



        <!--  <input type="datetime" name="fecha" value="<?php echo date("Y-m-d"); ?>"> -->

        <div class="card card-default">
            <div class="card-body" style="display: block;">
                <div class="row">



                    <div class="page-header-image"><img style="margin-left: 0px;" src="" alt="" class="brand-image img-circle elevation-3" id="foto" height="100" width="100"></a></div>
                    &nbsp;
                    &nbsp;
                    &nbsp;



                    <?php while ($row = $resultado3->fetch_array(MYSQLI_ASSOC)) { ?>
                        <h1 style="font-weight: normal;"><?php echo $row['nombres'], ' ', $row['apellidos'], ''; ?>




                        <?php }  ?>




                        <input type="text" value="<?php echo $id_persona ?>" readonly hidden id="id_persona" name="id_persona">





                </div>
                <hr>
                <div class="d-flex justify-content-around flex-row bd-highlight ">




                    <div class="card " style="width:500px;border-color:gray; background-color:lightblue;" id="">
                        <!--comisiones-->


                        <div class="card-body">
                            <h4 class="card-title" style="text-align: left; color:darkgray; font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;"> Detalles de usuario</h4>
                            &nbsp;&nbsp; &nbsp;&nbsp;
                            <div class=" col-sm-12" style="text-align: center">

                                <div class="form-group">

                                    <input hidden>
                                </div>



                                <button style="color:white;font-weight: bold;" type="button" id="" class="btn btn-large btn-block btn-info  full-width" style="width:100%" onclick="abrirModal()"></i>Editar Información</button>







                                &nbsp;&nbsp;




                            </div>
                            <h6 style="text-align: left; color:darkslategray; font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">Teléfono</h6>

                            <div id="cont1" style="text-align: left;  font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">

                            </div>
                            &nbsp;&nbsp;
                            <h6 style="text-align: left; color:darkslategray; font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">Dirección de correo</h6>

                            <div id="cont2" style="text-align: left;  font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">

                            </div>


                        </div>



                    </div>
                    <div class="card " style="width:500px;  border-color:gray; background-color:lightblue; " id="">
                        <!--comisiones-->
                        <div class="card-body">
                            <h4 class="card-title"></h4>
                            <div class="card-body">
                                <div class="col-sm-12" style="text-align: center">
                                    <p class="text-center" style="margin-top: 20px;" id="">


                                        <button style="color:white;font-weight: bold;" type="button" id="btn_mostrar" class="btn btn-large btn-block btn-info  full-width" onclick="MostrarBoton();"></i>Cambiar foto de Perfil</button>

                                        <button style="color:white;font-weight: bold;" hidden type="submit" id="btn_foto" class="btn btn-info btn_foto"><i class="fas fa-user-edit"></i>Guardar foto de Perfil</button>
                                        <button hidden id="btn_foto_cancelar" class="btn btn-dark btn_foto_cancelar"></i>Cancelar</button>


                                    <div class="form-group">
                                        <!-- FOTOGRAFIA  -->
                                        <input hidden type="file" accept=".png, .jpg, .JPG, .jpeg" maxlength="8388608" name="imagen" id="imagen" style="text-transform: uppercase">
                                    </div>

                                    <!-- </form> -->
                                    </p>

                                </div>



                            </div>
                        </div>


                    </div>

                </div>


            </div>


        </div>







    </div>


    <!-- modales -->

    <div class="modal fade" id="myModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Información personal</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <br>
                    <label for="">Teléfono:</label>

                    <div class="form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                            <input required type="text" name="telefono" id="telefono" class="form-control" data-inputmask="'mask': ' 9999-9999'" data-mask>
                            <input readonly hidden id="telefono_anterior" type="text">






                        </div>
                    </div>

                    <label for="">Dirección de correo:</label>
                    <div class="form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-envelope-open-text"></i></span>
                            <input id="correo" class="form-control" type="text">
                            <input readonly hidden id="correo_anterior" type="text">




                        </div>
                    </div>

                    <br>

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" id="guardarFormacion" class="btn btn-primary" onclick=" guardar_informacion();">Guardar</button>

                    <button id="cerrar" type="button" class="btn btn-secondary" data-dismiss="modal" onclick="cancelar()">Cancelar</button>
                </div>

            </div>
        </div>
    </div>



</body>
<html>

<script type="text/javascript" src="../js/ajustes_perfil_usuario.js"></script>