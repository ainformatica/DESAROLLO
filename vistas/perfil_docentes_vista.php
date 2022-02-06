<?php
session_start();
ob_start();
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');



$Id_objeto = 54;
$visualizacion = permiso_ver($Id_objeto);
$usuario = $_SESSION['id_persona'];



if ($visualizacion == 0) {
    // header('location:  ../vistas/menu_roles_vista.php');
    echo '<script type="text/javascript">
                              swal({
                                   title:"",
                                   text:"Lo sentimos no tiene permiso de visualizar la pantalla",
                                   type: "error",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                           window.location = "../vistas/menu_docentes_vista.php";

                            </script>';
} else {

    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'Ingreso', 'A perfil docente');


    // if (permisos::permiso_modificar($Id_objeto) == '1') {
    //     $_SESSION['btn_modificar_roles'] = "";
    // } else {
    //     $_SESSION['btn_modificar_roles'] = "disabled";
    // }
}

ob_end_flush();


$fechaActual = date('d-m-Y h:i:s');
?>

<!DOCTYPE html>
<html>

<head>
    <script src="../js/autologout.js"></script>
    <!-- Latest compiled and minified CSS -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!--     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->

    <title></title>
</head>

<body>



    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Perfil Docente</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Perfil Docente</li>
                        </ol>
                    </div>

                    <div class="RespuestaAjax"></div>

                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <form action="" method="post" role="form" enctype="multipart/form-data" data-form="perfil" autocomplete="off" class="FormularioAjax">


                    <div class=" card-body">

                        <div class="container-fluid">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Datos Personales</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="contactos-tab" data-toggle="tab" href="#contactos" role="tab" aria-controls="contactos" aria-selected="false">Contactos</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="formacion-tab" data-toggle="tab" href="#formacion" role="tab" aria-controls="formacion" aria-selected="false">Formación y Comisiones</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="formacion-tab" data-toggle="tab" href="#encuesta" role="tab" aria-controls="encuesta" aria-selected="false">Preferencias Docente</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                    <div class="row justify-content-center">
                                        <div class="container-fluid">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="container-fluid">
                                                        <div class="card-body">

                                                            <div class="row">

                                                                <div class=" col-sm-12" style="text-align: right">
                                                                    <div class="btn-group btn-group-lg">

                                                                        &nbsp;&nbsp; &nbsp;&nbsp;
                                                                        <div class="" id="curriculum_parrafo">
                                                                            <button class="btn btn-info " id="descargar_curriculum" name=""><a href="" target="_blank" id="curriculum" style="color:white;font-weight: bold;">Descargar Curriculum </a></button>
                                                                        </div>


                                                                    </div>

                                                                </div>
                                                                <div class=" col-sm-12" style="text-align: center">

                                                                    <img style="margin-left: 0px;" src="" alt="" class="brand-image img-circle elevation-3" id="foto" height="155" width="140">

                                                                </div>
                                                                <div class="col-sm-12" style="text-align: center">
                                                                    <p class="text-center" style="margin-top: 20px;" id="parrafo_boton_editar">

                                                                        <!-- <form action="" method="POST" role="form" enctype="multipart/form-data" id="frmimagen"> -->
                                                                    <div class="form-group">
                                                                        <!-- FOTOGRAFIA  -->
                                                                        <input hidden type="file" accept=".png, .jpg, .JPG, .jpeg" maxlength="8388608" name="imagen" id="imagen" style="text-transform: uppercase">
                                                                    </div>
                                                                    <button style="color:white;font-weight: bold;" type="button" id="btn_mostrar" class="btn btn-warning" onclick="MostrarBoton();"></i>Cambiar foto de Perfil</button>

                                                                    <button style="color:white;font-weight: bold;" hidden type="submit" id="btn_foto" class="btn btn-info btn_foto"><i class="fas fa-user-edit"></i>Guardar foto de Perfil</button>
                                                                    <button hidden id="btn_foto_cancelar" class="btn btn-dark btn_foto_cancelar"></i>Cancelar</button>
                                                                    <input class="form-control" hidden value="<?php echo $usuario ?>" type="text" name="id_persona" id="id_persona">

                                                                    <!-- </form> -->
                                                                    </p>

                                                                </div>
                                                                <div class=" col-sm-12" style="text-align: center">
                                                                    <div class="btn-group btn-group-lg">


                                                                        &nbsp;&nbsp;

                                                                        <div id="parrafo_curriculum">

                                                                            <!-- <form action="" method="POST" role="form" enctype="multipart/form-data" id="frmimagen"> -->
                                                                            <button style="color:white;font-weight: bold;" type="button" id="btn_mostrar_curriculum" class="btn btn-info" onclick="MostrarBotonCurriculum();"></i>Actualizar Curriculum</button>

                                                                            <input hidden class="btn btn-info" type="file" accept=".pdf" maxlength="60" id="c_vitae" name="c_vitae" value="" style="text-transform: uppercase">
                                                                            &nbsp;&nbsp;
                                                                            <button hidden type="submit" id="btn_curriculum" class="btn btn-info btn_curriculum"></i>Guardar Curriculum</i> <input class="form-control" hidden value="<?php echo $usuario ?>" type="text" name="id_persona" id="id_persona">
                                                                                <!-- </form> -->
                                                                            </button>
                                                                            <button hidden id="btn_curriculu_cancelar" class="btn btn-dark btn_curriculum_cancelar"></i>Cancelar</button>
                                                                        </div>


                                                                    </div>

                                                                </div>

                                                                <div class="container">

                                                                    <div class="row">



                                                                        <div class="col-sm-4" id="parrafo_numEmpleado">
                                                                            <label for="">Nº Empleado:</label>

                                                                            <div class="form-group">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text"><i class="fas fa-user icon"></i></span>
                                                                                    <input disabled name="" type="text" class="form-control" id="empleado">

                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-sm-4">
                                                                            <label for="">Nombre:</label>

                                                                            <div class="form-group">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="icono_nombre"><i class="fas fa-file-signature"></i></span>
                                                                                    <input disabled name="" type="text" onkeyup="Mayuscula('Nombre'); MismaLetra('Nombre'); DobleEspacio(this, event);" onkeypress="return sololetras(event)" class="form-control" id="Nombre" required>

                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-sm-4">
                                                                            <label for="">Apellido(s):</label>

                                                                            <div class="form-group">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="icono_apellido"><i class="fas fa-file-signature"></i></span>
                                                                                    <input disabled name="" type="text" onkeyup="Mayuscula('txt_apellido');MismaLetra('txt_apellido'); DobleEspacio(this, event);" onkeypress="return sololetras(event);" class="form-control" id="txt_apellido" required>

                                                                                </div>
                                                                            </div>

                                                                        </div>





                                                                        <div class="col-sm-4" id="parrafo_genero">
                                                                            <label for="email">Género:</label>

                                                                            <div class="form-group">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="icono_genero"><i class="fas fa-toggle-on"></i></span>

                                                                                    <input value="" type="text" disabled name="ver_genero" id="ver_genero" class="form-control">

                                                                                    <select hidden class="form-control" onchange="mostrar_genero($('#genero').val());" id="genero" name="">
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <input class="form-control" readonly hidden id="age" name="age" maxlength="25" value="" required style="text-transform: uppercase">

                                                                        
                                                                        <input type="text" name="mayoria_edad" id="mayoria_edad" hidden readonly onload="mayoria_edad()">

                                                                        <div class="col-sm-4" id="parrafo_nacimiento">
                                                                        <label for="">Fecha Nacimiento:</label>

                                                                            <div class="form-group">
                                                                                <div class="input-group-prepend">
                                                                                <span class="input-group-text" id="icono_nacimiento"><i class="far fa-calendar-alt"></i></span>
                                                                                    <input disabled="true" value="" type="date" name="fecha" id="fecha" class="form-control" onblur="valida_mayoria()">
                                                                                
                                                                                </div>
                                                                                <p hidden id="Textofecha" style="color:red;">¡El docente debe ser mayor de edad! </p>
                                                                            </div>
                                                                            

                                                                        </div>





                                                                        <div class="col-sm-4" id="parrafo_identidad">
                                                                            <label for="">Nº Identidad:</label>

                                                                            <div class="form-group">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="icono_identidad"><i class="fas fa-id-card"></i></span>
                                                                                    <input disabled name="" type="text" data-inputmask="'mask': '9999-9999-99999'" data-mask class="form-control" id="identidad" required onkeyup="ValidarIdentidad($('#identidad').val());" onblur="ExisteIdentidad();">

                                                                                </div>
                                                                            </div>
                                                                            <p hidden id="TextoIdentidad" style="color:red;">La Identidad Ya existe</p>
                                                                            <p hidden id="Textomayor" style="color:red;">¡Es menor de edad! </p>

                                                                        </div>

                                                                        <div class="col-sm-3" id="parrafo_estadoC">
                                                                            <label for="">Estado Civil:</label>

                                                                            <div class="form-group">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="icono_estado"><i class="fas fa-user icon"></i></span>

                                                                                    <input value="" type="text" disabled name="ver_estado" id="ver_estado" class="form-control">

                                                                                    <select hidden class="form-control" onchange="mostrar_estado_civil($('#estado_civil').val());" id="estado_civil" name="">
                                                                                    </select>

                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-sm-3" id="parrafo_nacionalidad">
                                                                            <label for="">Nacionalidad:</label>

                                                                            <div class="form-group">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="icono_nacionalidad"><i class="fas fa-flag"></i></span>
                                                                                    <input disabled name="" type="text" onkeyup="Mayuscula('nacionalidad');" class="form-control" id="nacionalidad">

                                                                                </div>
                                                                            </div>
                                                                        </div>




                                                                        <div class="col-sm-3" id="parrafo_sued">
                                                                            <label for="">Sued:</label>

                                                                            <div class="form-group">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="icono_estado"><i class="fas fa-user icon"></i></span>

                                                                                    <input class="form-control" readonly value="" type="text" name="sued" id="sued">

                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-sm-3" id="parrafo_categoria">
                                                                            <label for="">Categoría:</label>

                                                                            <div class="form-group">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="icono_categoria"><i class="fas fa-user icon"></i></span>
                                                                                    <input disabled name="" type="text" class="form-control" id="categoria">

                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-sm-3" id="parrafor_jornada">
                                                                            <label for="">Jornada:</label>

                                                                            <div class="form-group">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="icono_jornada"><i class="fas fa-user icon"></i></span>
                                                                                    <input disabled name="" type="text" class="form-control" id="jornada">

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-3" id="parrafor_hi">
                                                                            <label for="">H. entrada:</label>

                                                                            <div class="form-group">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="icono_jornada"><i class="fas fa-user-clock"></i></span>
                                                                                    <input disabled name="" type="text" class="form-control" id="hi">

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-3" id="parrafor_hf">
                                                                            <label for="">H. salida:</label>

                                                                            <div class="form-group">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="icono_jornada"><i class="fas fa-user-clock"></i></span>
                                                                                    <input disabled name="" type="text" class="form-control" id="hf">

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-3" id="parrafo_fechaentradatrabajo">
                                                                            <label for="">Fecha Ingreso :</label>

                                                                            <div class="form-group">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="icono_nacimiento"><i class="far fa-calendar-alt"></i></span>
                                                                                    <input disabled="true" value="" type="date" name="fechaentrada" id="fechaentrada" class="form-control">
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class=" col-sm-12" style="text-align: right">
                                                                    <div class="btn-group ">
                                                                        <button style="color:white;font-weight: bold;" class="btn btn-info" onclick="habilitar_editar();" id="editar_info" name="editar_info">Editar Información</button>

                                                                        <button hidden type="button" style="color:white;font-weight: bold;" class="btn btn-dark" onclick="desabilitar();" id="btn_editar" name="btn_editar"><i class="fas fa-user-edit"></i>Cancelar</button>




                                                                        &nbsp;&nbsp;
                                                                        <!-- <p class="text-center" style="margin-top: 20px;"> -->
                                                                        <button hidden type="button" class="btn btn-info" id="btn_guardar_edicion" name="btn_guardar_edicion" onclick="EditarPerfil($('#Nombre').val(),$('#txt_apellido').val(),$('#identidad').val(),$('#estado_civil_text').val()); ver_estado_civil();"><i class="fas fa-user-edit"></i>Guardar Información</button>
                                                                        <!-- </p> -->

                                                                    </div>

                                                                </div>









                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="tab-pane fade" id="contactos" role="tabpanel" aria-labelledby="profile-tab">
                                    <?php
                                    require 'contactos_perfil_docente_vista.php';
                                    ?>
                                </div>
                                <div class="tab-pane fade" id="formacion" role="tabpanel" aria-labelledby="profile-tab">
                                    <?php
                                    require 'formacion_comisiones_perfil_docente_vista.php';
                                    ?>
                                </div>
                                <div class="tab-pane fade" id="encuesta" role="tabpanel" aria-labelledby="profile-tab">
                                    <?php
                                    require 'encuesta_perfil_docente_vista.php';
                                    ?>
                                </div>
                            </div>
                        </div>





                    </div>




                </form>
            </div>

        </section>




    </div>











    <!-- /.card-body -->
    <div class="card-footer">

    </div>



    <div class="RespuestaAjax"></div>
    </section>

    </div>
    </section>


    </div>

    <script type="text/javascript" src="../js/perfil_docentes.js"></script>
    <script type="text/javascript" src="../js/validar_registrar_docentes.js"></script>
    <script>

    </script>




</body>

</html>