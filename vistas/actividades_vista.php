<?php
ob_start();
//session_start();
require_once('../clases/Conexion.php');
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');


$Id_objeto = 9246;


$visualizacion = permiso_ver($Id_objeto);


if ($visualizacion == 0) {
    echo '<script type="text/javascript">
                              swal({
                                   title:"",
                                   text:"Lo sentimos no tiene permiso de visualizar la pantalla",
                                   type: "error",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                           window.location = "../vistas/actividades_vista.php";

                            </script>';
} else {

    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INGRESO', 'A ACTIVIDADES POA.');


  
}


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/smartwizard@5/dist/css/smart_wizard_all.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="../js/smart_wizard_dots.css" rel="stylesheet">
</head>

<body>
    <div id="vista_smart">
        <ul class="nav">
            <li>
                <a class="nav-link" href="#step-1">
                    Actividades
                </a>
            </li>
            <li>
                <a class="nav-link" href="#step-2">
                    Agregar Actividades
                </a>
            </li>
        </ul>

        <div class="tab-content">
            <div id="step-1" class="tab-pane" role="tabpanel">
                <table id="tabla_actividades" class="table table-sm table-dark table-striped needs-validation" cellpadding="0" width="100%">
                    <thead>
                        <tr>
                            <th scope="col">ID ACTIVIDAD</th>
                            <th scope="col">ACTIVIDAD</th>
                            <th scope="col">ID VERIFICACIÓN</th>
                            <th scope="col">MEDIO VERIFICACIÓN</th>
                            <th scope="col">ID POBLACIÓN</th>
                            <th scope="col">POBLACIÓN OBJETIVO</th>
                            <th scope="col">ACCIÓN</th>
                            <th scope="col">ACCIÓN</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div id="step-2" class="tab-pane" role="tabpanel">
                <div class="card card-default">
                    <!--inciio primer card -->
                    <div class="card-header" style="background-color: #ced2d7;">
                        <h3 class="card-title"><strong>AGREGAR ACTIVIDADES</strong> </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div id="container">
                            <form id="agregar_actividades">
                                <div class="form-group">
                                    <label for="formGroupExampleInput">Nombre Actividad</label>
                                    <input type="text" class="form-control" id="n_actividad" name="n_actividad" maxlength="50" value="" style="text-transform: uppercase" onkeyup="DobleEspacio(this, event); MismaLetra('n_actividad');" oncopy="return false" onpaste="return false" onkeypress="return sololetras(event)" placeholder="Actividad" required>
                                </div>
                                <div class="form-group">
                                    <label for="formGroupExampleInput2">Medios de Verificacion</label>
                                    <input type="text" class="form-control" id="m_verificacion" name="m_verificacion" maxlength="50" value="" style="text-transform: uppercase" onkeyup="DobleEspacio(this, event); MismaLetra('m_verificacion');" oncopy="return false" onpaste="return false" onkeypress="return sololetras(event)" placeholder="Verificación" required>
                                </div>
                                <div class="form-group">
                                    <label for="formGroupExampleInput3">Población Objetivo</label>
                                    <input type="text" class="form-control" id="p_objetivo" name="p_objetivo" maxlength="50" value="" style="text-transform: uppercase" onkeyup="DobleEspacio(this, event); MismaLetra('p_objetivo');" oncopy="return false" onpaste="return false" onkeypress="return sololetras(event)" placeholder="Población" required>
                                </div>
                                <div class="form-group d-flex">
                                    <div class="ml-auto p-2" id="edicion_actividades" hidden>
                                        <button class="btn sw-btn-prev btn btn-danger" id="finalizar_act">Finalizar</button>
                                        <button class="btn btn-warning" id="guardar_edicion_act">Guardar Edición</button>
                                    </div>
                                    <div class="ml-auto p-2" id="add_actividades">
                                        <button class="btn sw-btn-prev btn btn-danger">Finalizar</button>
                                        <button class="btn btn-primary" id="guardar_actividad">Guardar</button>
                                    </div>
                                </div>
                                <div id="mensaje_actividades"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
<!-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/smartwizard@5/dist/js/jquery.smartWizard.min.js" type="text/javascript"></script>


<script type="text/javascript">
    // SmartWizard initialize
    $('#vista_smart').smartWizard({
        theme: 'arrows',
        transitionEffect: 'fade',
        transitionSpeed: '400',
        lang: { // Language variables for button
            next: 'Siguiente',
            previous: 'Anterior'
        }
    });

    //!enviar datos al from
    $('#tabla_actividades tbody').on('click', '#editar_act', function() {
        var fila = $(this).closest('tr');
        var id_actividad = fila.find('td:eq(0)').text();
        var n_actividad = fila.find('td:eq(1)').text();
        var id_verificacion = fila.find('td:eq(2)').text();

        var m_verificacion = fila.find('td:eq(3)').text();
        var id_poblacion = fila.find('td:eq(4)').text();
        var p_objetivo = fila.find('td:eq(5)').text();
        // var tercer_trimestre = fila.find('td:eq(3)').text();
        // var cuarto_trimestre = fila.find('td:eq(4)').text();
        localStorage.removeItem('id_actividad');
        localStorage.removeItem('id_verificacion');
        localStorage.removeItem('id_poblacion');

        localStorage.setItem('id_actividad', id_actividad);
        localStorage.setItem('id_verificacion', id_verificacion);
        localStorage.setItem('id_poblacion', id_poblacion);


        document.getElementById('n_actividad').value = n_actividad;
        document.getElementById('m_verificacion').value = m_verificacion;
        document.getElementById('p_objetivo').value = p_objetivo;
        // document.getElementById('cuarto_trimestre').value = cuarto_trimestre;

        $(".sw-btn-next").trigger("click");

        $("#edicion_actividades").attr("hidden", false);
        $("#add_actividades").attr("hidden", true);
    });
    //!enviar datos al from

    $('#finalizar_act').click(function() {
        document.getElementById('agregar_actividades').reset();
        $("#edicion_actividades").attr("hidden", true);
        $("#add_actividades").attr("hidden", false);
    });

    const button_edicion_act = document.getElementById('guardar_edicion_act');
    const form_acti = document.getElementById('agregar_actividades');

    button_edicion_act.addEventListener('click', function(e) {
        e.preventDefault();
        if (agregar_actividades.checkValidity() === false) {
            e.preventDefault();
            e.stopPropagation();
            agregar_actividades.classList.add('was-validated')
        } else {

            const newform_edit = new FormData(form_acti);
            newform_edit.append('edit_act_send', 1);
            newform_edit.append('id_actividad', localStorage.getItem('id_actividad'));
            newform_edit.append('id_verificacion', localStorage.getItem('id_verificacion'));
            newform_edit.append('id_poblacion', localStorage.getItem('id_poblacion'));

            fetch('../Controlador/action.php', {
                    method: 'POST',
                    body: newform_edit
                })
                .then(res => res.json())
                .then(data => {
                    console.log(data);
                    if (data == 'exito') {
                        $('#tabla_actividades tbody').empty(); //limpiar la tabla despues de cada llamdo
                        update_actividades();
                        $("#mensaje_actividades").html(showMEssage('success', 'Dato actualizado el registro a la tabla'));
                        $("#mensaje_actividades").fadeTo(2000, 500).slideUp(500, function() {                            
                            $("#mensaje_actividades").slideUp(500);
                        });
                        document.getElementById('agregar_actividades').reset();
                    } else {
                        $("#mensaje_actividades").html(showMEssage('danger', 'Algo ocurrio mal'));
                        $("#mensaje_actividades").fadeTo(2000, 500).slideUp(500, function() {
                            $("#mensaje_actividades").slideUp(500);
                        });

                    }
                })
        }
    });
</script>

</html>
<script type="text/javascript" src="../js/validacion_jefatura.js"></script>