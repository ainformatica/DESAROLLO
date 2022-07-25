<?php
$usuario = $_SESSION['id_persona'];
?>
<!DOCTYPE html>
<html>

<head>
    <script src="../js/autologout.js"></script>
    <!-- Latest compiled and minified CSS -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <title></title>
</head>


<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">

                    <div class="d-flex justify-content-around flex-row bd-highlight row">
                        <div class="card " style="width:400px;border-color:gray;" id="card_telefono">
                            <div class="card-body">
                                <h4 class="card-title">Contactos</h4>
                                <div class="form-group card-text">
                                    <!-- TABLA CONTACTOS -->
                                    <button type="button" name="add1" id="add1" class="btn btn-info card-title" data-toggle="modal" data-target="#ModalTel">Agregar Teléfono</button>

                                    <table class="table table-bordered table-striped m-0">
                                        <thead>
                                            <tr>

                                                <th>Teléfono</th>
                                                <th id="eliminar_telefono_tabla">Eliminar</th>

                                            </tr>
                                        </thead>
                                        <tbody id="tbData2"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="card " style="width:400px;border-color:gray;">
                            <div class="card-body">
                                <h4 class="card-title">Correo</h4>
                                <div class="form-group card-text">
                                    <!-- TABLA CORREO -->
                                    <button type="button" name="add_correo1" id="add_correo1" class="btn btn-info card-title" data-toggle="modal" data-target="#ModalCorreo">Agregar Correo</button>

                                    <table class="table table-bordered table-striped m-0">
                                        <thead>
                                            <tr>

                                                <th>Correo</th>
                                                <th id="eliminar_correo_tabla">Eliminar</th>

                                            </tr>
                                        </thead>
                                        <tbody id="tbDataCorreo1"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!---card-->




                    </div>

                </div>
            </div>
        </div>
    </div>
</div>








<!--Modal para telefono-->
<div class="modal fade" tabindex="-1" role="dialog" id="ModalTel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Datos</h5>
                <button class="close" data-dismiss="modal">
                    &times;
                </button>
            </div>

            <div class="modal-body">
                <div class="container">
                    <div class="form-group">
                        <label for="">Teléfono</label>
                        <input required type="text" name="tel1" id="tel1" class="form-control name_list" data-inputmask="'mask': ' 9999-9999'" data-mask required>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="addTel()">Agregar</button>
                <button class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!--CERRANDO MODAL TELEFONO-->

<!--Modal para correo-->
<div class="modal fade" tabindex="-1" role="dialog" id="ModalCorreo">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Datos</h5>
                <button class="close" data-dismiss="modal">
                    &times;
                </button>
            </div>

            <div class="modal-body">
                <div class="container">
                    <div class="form-group">
                        <label for="">Correo</label>
                        <input required type="email" name="correo" id="correo" class="form-control name_list">
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="addCorreo()">Agregar</button>
                <button class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


</html>