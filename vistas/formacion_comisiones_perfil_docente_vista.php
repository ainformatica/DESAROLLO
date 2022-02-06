<?php
$usuario = $_SESSION['id_persona'];
?>
<!DOCTYPE html>
<html>

<head>
    <script src="../js/autologout.js"></script>
    <!-- Latest compiled and minified CSS -->
    <!--     <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- <style type="text/css" media="print">
        @page {
            size: auto;
            margin: 0mm;
        }

        ;
    </style>

    <style>
        #fecha_actual {
            font-family: Tahoma, Verdana, Arial;
            font-size: 24px;
            color: #707070;
            background-color: #FFFFFF;
            border-width: 0;
        }

        ;
    </style> -->
    <title></title>
</head>
<div class="container-fluid">


    <div class="row justify-content-center">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form action="" method="post" role="form" enctype="multipart/form-data" data-form="perfil" autocomplete="off" class="FormularioAjax">



                        <div class="d-flex justify-content-around flex-row bd-highlight row">
                            <div class="card " style="width:400px;border-color:gray;" id="parrafo_formacion">
                                <!--comisiones-->

                                <div class="card-body">
                                    <h4 class="card-title ">Formación Académica</h4><br>


                                    <!-- <ul class="card-text" id="ulFormacion">

                                    </ul> -->
                                    <div class="card-body">
                                        <button type="button" class="btn btn-info card-title" data-toggle="modal" data-target="#myModal">Agregar Formación Académica <i class="fa fa-user-plus"></i></button>
                                        <h4 class="card-title"></h4>
                                        <div class="card-text">
                                            <table class="table table-bordered table-striped m-0">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Grado</th>
                                                        <th>Especialidad</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbl_especialidad"></tbody>
                                            </table>
                                        </div>
                                    </div>



                                    <!-- The Modal -->

                                </div>
                            </div><!-- Comisiones-->



                            <div class="card " style="width:400px;border-color:gray;" id="parrafo_comisiones">
                                <!--comisiones-->
                                <div class="card-body">
                                    <h4 class="card-title">Comisiones y Actividades</h4>
                                    <div class="card-body">

                                        <table class="table table-bordered table-striped m-0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Comisión</th>
                                                    <th>Actividad</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbl_comisiones"></tbody>
                                        </table>
                                    </div>
                                </div>


                            </div><!-- Comisiones-->


                        </div>



                    </form>
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
                <h4 class="modal-title">Nueva Formación Académica</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <br>
                <label for="">GRADO ACADÉMICO:</label>

                <div class="form-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
                        &nbsp; <select class="form-control" onchange="mostrar($('#id_select').val());" id="id_select" name="">

                        </select>


                    </div>
                </div>

                <label for="">ESPECIALIDAD:</label>
                <div class="form-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-file-code"></i></span>
                        &nbsp;<select hidden id="select_especialidad" class="form-control" name="">
                            <input id="especialidad" class="form-control" type="text" onkeyup="Mayuscula('especialidad');">
                        </select>


                    </div>
                </div>

                <br>

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" id="guardarFormacion" class="btn btn-primary">Guardar Formación Académica <i class="fa fa-user-plus"></i></button>

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>

        </div>
    </div>
</div>


</html>
<!-- para seleccionar limite de checkbox -->
<!-- <script>
    var limite = 2;
    $(".pregunta2").change(function() {
        if ($("input:checked").length > limite) {
            alert("solo puedes seleccionar un maximo de dos");
            this.checked = false;
        }
    });
</script> -->