<?php
$usuario = $_SESSION['id_persona'];


// SELECT A LAS TABLAS PARA ENCUESTA
$sql = "SELECT * FROM tbl_asignaturas where carga='SI' AND estado=1";
$consulta = $mysqli->query($sql);
$row = $consulta->fetch_all(MYSQLI_ASSOC);

$sql1 = "SELECT * FROM tbl_areas";
$consulta1 = $mysqli->query($sql1);
$row1 = $consulta1->fetch_all(MYSQLI_ASSOC);

$sql4 = "SELECT * FROM tbl_areas";
$consulta4 = $mysqli->query($sql4);
$row4 = $consulta4->fetch_all(MYSQLI_ASSOC);

$sql9 = "SELECT * FROM tbl_asignaturas where carga='SI' AND estado=1";
$consulta9 = $mysqli->query($sql9);
$row9 = $consulta9->fetch_all(MYSQLI_ASSOC);

// --------------------------------

// TRAER LAS PREGUNTAS RESPONDIDAS X DOCENTE

//PREGUNTA 1
$sql2 = "SELECT id_pref_area_doce,
        (SELECT a.area FROM tbl_areas AS a WHERE a.id_area = tbl_pref_area_docen.id_area LIMIT 8) area_docente
        FROM tbl_pref_area_docen
        WHERE id_persona = '$usuario'";
$consulta2 = $mysqli->query($sql2);
$row2 = $consulta2->fetch_all(MYSQLI_ASSOC);

//PREGUNTA 2
$sql5 = "SELECT id_expe_academi_docente AS id_expe_a_doc,
        (SELECT a.area FROM tbl_areas AS a WHERE a.id_area = tbl_expe_academica_docente.id_area LIMIT 8) area_docente
        FROM tbl_expe_academica_docente
        WHERE id_persona = '$usuario'";
$consulta5 = $mysqli->query($sql5);
$row5 = $consulta5->fetch_all(MYSQLI_ASSOC);

//PREGUNTA 3
$sql7 = "SELECT id_pref_asig_docen,
        (SELECT a.asignatura FROM tbl_asignaturas AS a WHERE a.Id_asignatura = tbl_pref_asig_docen.Id_asignatura and a.carga='SI' AND a.estado=1 limit 8) asig_docente
        FROM tbl_pref_asig_docen
        WHERE id_persona = '$usuario';";
$consulta7 = $mysqli->query($sql7);
$row7 = $consulta7->fetch_all(MYSQLI_ASSOC);

//PREGUNTA 4
$sql10 = "SELECT id_desea_asig_doce,
        (SELECT a.asignatura FROM tbl_asignaturas AS a WHERE a.Id_asignatura = tbl_desea_asig_doce.Id_asignatura and a.carga='SI' AND a.estado=1 limit 8) desea_asig
        FROM tbl_desea_asig_doce
        WHERE id_persona = '$usuario' ";
$consulta10 = $mysqli->query($sql10);
$row10 = $consulta10->fetch_all(MYSQLI_ASSOC);

// --------------------------------

// TRAER LAS PREGUNTAS QUE NO HA CONTESTADO EL DOCENTE

//PREGUNTA 1
$sql3 = "SELECT area.area AS areas_vacias, area.id_area AS id_area
        FROM tbl_areas AS area
        WHERE NOT EXISTS (SELECT id_area, id_persona FROM tbl_pref_area_docen AS pad WHERE pad.id_area = area.id_area AND pad.id_persona = '$usuario');";
$consulta3 = $mysqli->query($sql3);
$row3 = $consulta3->fetch_all(MYSQLI_ASSOC);


//PREGUNTA 2
// --------------------------------
$sql6 = "SELECT area.area AS expe_areas_vacias, area.id_area AS id_area
        FROM tbl_areas AS area
        WHERE NOT EXISTS (SELECT id_area, id_persona FROM tbl_expe_academica_docente AS eac WHERE eac.id_area = area.id_area AND eac.id_persona = '$usuario');";
$consulta6 = $mysqli->query($sql6);
$row6 = $consulta6->fetch_all(MYSQLI_ASSOC);


//PREGUNTA 3
// --------------------------------
$sql8 = "SELECT area.asignatura AS asig_vacias, area.Id_asignatura AS id_asignatura
        FROM tbl_asignaturas AS area
        WHERE NOT EXISTS (SELECT Id_asignatura, id_persona FROM tbl_pref_asig_docen AS pad WHERE pad.Id_asignatura = area.Id_asignatura
        AND pad.id_persona = '$usuario')  and area.carga='SI' AND area.estado=1;";
$consulta8 = $mysqli->query($sql8);
$row8 = $consulta8->fetch_all(MYSQLI_ASSOC);

//PREGUNTA 4
// --------------------------------
$sql11 = "SELECT area.asignatura AS asig_vacias, area.Id_asignatura AS id_asignatura
        FROM tbl_asignaturas AS area
        WHERE NOT EXISTS (SELECT Id_asignatura, id_persona FROM tbl_desea_asig_doce AS pad WHERE pad.Id_asignatura = area.Id_asignatura
        AND pad.id_persona = '$usuario') and area.carga='SI' AND area.estado=1;";
$consulta11 = $mysqli->query($sql11);
$row11 = $consulta11->fetch_all(MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html>

<head>
    <script src="../js/autologout.js"></script>

    <!--     <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <title></title>
</head>



<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-around flex-row bd-highlight row">
                        <div class="card " style="width:420px;border-color:gray;" id="parrafo_encuesta">
                            <div class="card-body">
                                <h4 class="card-title">Preferencia Docente en Base a Experiencias Profesionales</h4>
                                <div class="card-text">
                                    <button type="button" id="btn_modal1" class="btn btn-info " onclick="pregunta1();">1. Identifique las Áreas que imparte clases</button>
                                    <br><br>
                                    <button type="button" id="btn_modal2" class="btn btn-info " onclick="pregunta2();">
                                        <h6 style="text-align: left;font-size:10;">2. Identifique las Áreas de Preferencia y Experencia Profesional</h6>
                                    </button>
                                    <br><br>
                                    <button type="button" id="btn_modal3" class="btn btn-info " onclick="pregunta3();">
                                        <h6 style="text-align: left; font-size:10;">3. Identifique las Asignaturas de Preferencia Profesional</h6>
                                    </button>
                                    <br><br>
                                    <button type="button" id="btn_modal3" class="btn btn-info " onclick="pregunta4();">
                                        <h6 style="text-align: left; font-size:10;">4. Identifique las Asignaturas de Experiencia Profesional</h6>
                                    </button>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <!-- modal encuesta -->
                <div class="modal fade" id="modalencuesta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalencuesta">Pregunta 1</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">

                                <!--  <div class="card " style="width:420px;border-color:gray;"> -->

                                <div style="text-align:left">


                                    <h5 style="font-weight: bold; font-size: 15px"> 1. ¿En que áreas de la carrera imparte clases?</h5>
                                    <div class="form-check">
                                        <?php

                                        if ($row1 != $row2) {
                                            // echo '<input type="checkbox"  name="" value="' . $id["id_pref_area_doce"] . '">' . $id["area_docente"];

                                            foreach ($row2 as $id) {
                                                echo '<br>';
                                                echo '<input class="pregunta1" type="checkbox" checked = "checked" name="areas[]" value="' . $id["id_pref_area_doce"] . '">' . $id["area_docente"];
                                            }

                                            foreach ($row3 as $id) {

                                                echo '<br>';
                                                echo '<input class="pregunta1" type="checkbox" name="areas[]" value="' . $id["id_area"] . '">' . $id["areas_vacias"];
                                            }
                                        } else {
                                            foreach ($row1 as $id) {
                                                echo '<br>';
                                                echo '<input  class="pregunta1" type="checkbox" name="areas[]" value="' . $id["id_area"] . '">' . $id["area"];
                                            }
                                        };

                                        ?>
                                    </div>


                                </div>



                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button type="button" value="pregunta1" class="btn btn-primary" onclick="enviarpregunta1()">Guardar</button>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modalencuesta2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalencuesta">Pregunta 2</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <div style="text-align:left">
                                    <h5 style="font-weight: bold; font-size: 15px">2. ¿Seleccione una o dos áreas de la informática en la que tiene mayor experiencia y se siente más cómodo en la docencia?</h5>
                                    <div class="form-check">
                                        <?php


                                        if ($row4 != $row5) {
                                            // echo '<input type="checkbox"  name="" value="' . $id["id_pref_area_doce"] . '">' . $id["area_docente"];

                                            foreach ($row5 as $id) {
                                                echo '<br>';
                                                echo '<input class="pregunta2" type="checkbox" checked = "checked" name="areas2[]" value="' . $id["area_docente"] . '">' . $id["area_docente"];
                                            }

                                            foreach ($row6 as $id) {

                                                echo '<br>';
                                                echo '<input class="pregunta2" type="checkbox" name="areas2[]" value="' . $id["id_area"] . '">' . $id["expe_areas_vacias"];
                                            }
                                        } else {

                                            foreach ($row4 as $area) {
                                                echo '<br>';
                                                echo '<input  class="pregunta2" type="checkbox" name="areas2[]" value="' . $area["id_area"] . '">' . $area["area"];
                                            }
                                        };

                                        ?>

                                    </div>
                                </div>


                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary" onclick="enviarpregunta2();">Guardar</button>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modalencuesta3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalencuesta">Pregunta 3</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <!--  <div class="card " style="width:420px;border-color:gray;"> -->

                                <div style="text-align:left">

                                    <h5 style="font-weight: bold; font-size: 15px">3. Basado en la respuesta de la pregunta anterior ¿Selecciones la(s) Asignatura(s)
                                        en la que tiene mayor experiencia?</h5>
                                    <div class="form-check">
                                        <?php


                                        if ($row != $row7) {

                                            foreach ($row7 as $id) {
                                                echo '<br>';
                                                echo '<input class="pregunta3" type="checkbox" checked = "checked" name="asignatura3[]" value="' . $id["id_pref_asig_docen"] . '">' . $id["asig_docente"];
                                            }

                                            foreach ($row8 as $id) {

                                                echo '<br>';
                                                echo '<input class="pregunta3" type="checkbox" name="asignatura3[]" value="' . $id["id_asignatura"] . '">' . $id["asig_vacias"];
                                            }
                                        } else {

                                            foreach ($row as $id) {
                                                echo '<br>';
                                                echo '<input  required class="pregunta3" type="checkbox" name="asignatura3[]" value="' . $id["Id_asignatura"] . '">' . $id["asignatura"];
                                            }
                                        };

                                        ?>
                                    </div>



                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="cancelar4" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                    <button type="button" class="btn btn-primary" onclick="enviarpregunta3();">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
                <div class="modal fade" id="modalencuesta4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalencuesta">Pregunta 4</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <!--  <div class="card " style="width:420px;border-color:gray;"> -->

                                <div style="text-align:left">

                                    <h5 style="font-weight: bold; font-size: 15px"> 4. ¿Selecciones la(s) Asignatura(s) en la que desea de impartir? </h5>
                                    <div class="form-check">

                                        <?php

                                        if ($row9 != $row10) {

                                            foreach ($row10 as $id) {
                                                echo '<br>';
                                                echo '<input class="pregunta4" type="checkbox"  checked = "checked" name="asignatura4[]" value="' . $id["id_desea_asig_doce"] . '">' . $id["desea_asig"];
                                            }

                                            foreach ($row11 as $id) {

                                                echo '<br>';
                                                echo '<input class="pregunta4" type="checkbox"  name="asignatura4[]" value="' . $id["id_asignatura"] . '">' . $id["asig_vacias"];
                                            }
                                        } else {
                                            foreach ($row9 as $id) {
                                                echo '<br>';
                                                echo '<input required class="pregunta4" type="checkbox"  name="asignatura4[]" value="' . $id["Id_asignatura"] . '">' . $id["asignatura"];
                                            }
                                        };

                                        ?>
                                    </div>


                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="cancelar4" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                    <button type="button" class="btn btn-primary" onclick="enviarpregunta4();">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>
</div>

</html>
<!-- para seleccionar limite de checkbox -->
<!-- <script>
    var limite = 3;
    $(".pregunta2").change(function() {
        if ($("input:checked").length > limite) {
            alert("solo puedes seleccionar un maximo de dos");
            this.checked = false;
        }
    });
</script> -->