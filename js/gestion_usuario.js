function abrirmodalusuario() {
    $("#modalReset").modal({ backdrop: "static", keyboard: false });
    $("#modalReset").modal("show");
}


$("#telefono").click(function() {
    $("#modal_telefono").modal({ backdrop: "static", keyboard: false });
    $("#modal_telefono").modal("show");
});

$("#correo").click(function() {
    $("#modal_correo").modal({ backdrop: "static", keyboard: false });
    $("#modal_correo").modal("show");
});





function usuario() {
    var cadena = "&activar=activar";
    $.ajax({
        url: "../Controlador/reset_usuario_controlador.php?op=usuario",
        type: "POST",
        data: cadena,
        success: function(r) {
            $("#usuario").html(r).fadeIn();
            var o = new Option("Seleccionar un usuario", 0);

            $("#usuario").append(o);
            $("#usuario").val(0);
        },
    });
}
usuario();

function reiniciar() {
    var usuario = $("#usuario").val();
    console.log(usuario);

    if (usuario == 0) {
        swal("Alerta!", "seleccione una opcion valida", "warning");

    } else {
        var opcion = confirm("Estas seguro de continuar?");
        if (opcion == true) {

            $.ajax({
                url: "../Controlador/reset_usuario_controlador.php?op=confirmar",
                type: "POST",
                data: {
                    id_usuario: usuario,
                },
            }).done(function(resp) {


                if (resp > 0) {
                    if (resp == 1) {
                        //alert("si");
                        swal({
                            title: "Bien",
                            text: "Se guardó correctamente",
                            type: "success",
                            showConfirmButton: false,
                            timer: 11000,
                        });
                        location.reload();
                    } else {
                        swal("Alerta!", "No se pudo completar la acción", "warning");
                    }
                }
            });

        }
    }


}


var table;

function TablaPersonas() {
    table = $("#tabla_persona").DataTable({
        paging: true,
        lengthChange: true,
        ordering: true,
        info: true,
        autoWidth: true,
        responsive: true,
        // LengthChange: false,
        searching: { regex: true },
        lengthMenu: [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "All"],
        ],
        sortable: false,
        pageLength: 15,
        destroy: true,
        async: false,
        processing: true,
        ajax: {
            url: "../Controlador/tabla_personas_controlador.php",
            type: "POST",
        },
        columns: [{
                defaultContent: "<button style='font-size:13px;' type='button' class='editar btn btn-primary '><i class='fas fa-edit'></i></button>",
            },
            {
                defaultContent: "<button style='font-size:13px;' type='button' class='borrar btn btn-warning '><i class='fas fa-trash-alt'></i></button>",
            },
            { data: "nombres" },
            { data: "apellidos" },
            { data: "sexo" },
            { data: "identidad" },
            { data: "nacionalidad" },
            { data: "estado_civil" },
            { data: "fecha_nacimiento" },
            { data: "tipo_persona" },
            { data: "estado" },
        ],
    });
}

$("#tabla_persona").on("click", ".editar", function() {
    $("#modal_editar").modal({ backdrop: "static", keyboard: false });
    $("#modal_editar").modal("show");

    var data = table.row($(this).parents("tr")).data();
    if (table.row(this).child.isShown()) {
        var data = table.row(this).data();
    }



    $("#cbm_tipo_persona").val(data.id_tipo_persona).trigger("change");
    $("#id_persona").val(data.id_persona);
    $("#nombres").val(data.nombres);
    $("#apellidos").val(data.apellidos);
    $("#genero").val(data.sexo);
    $("#identidad").val(data.identidad);
    $("#nacionalidad").val(data.nacionalidad);
    $("#civil").val(data.estado_civil);
    $("#fecha").val(data.fecha_nacimiento);
    $("#estado1").val(data.estado);

    traerTel();

    traerCorreo();
});




function tipo_persona() {
    var cadena = "&activar=activar";
    $.ajax({
        url: "../Controlador/gestion_personas_controlador.php?op=tipo_persona",
        type: "POST",
        data: cadena,
        success: function(r) {
            $("#cbm_tipo_persona").html(r).fadeIn();
            var o = new Option("SELECCIONE", 0);

            $("#cbm_tipo_persona").append(o);
            $("#cbm_tipo_persona").val(0);
        },
    });
}
tipo_persona();


$("#guardar_persona").click(function() {
    var nombres = $("#nombres").val();
    var apellidos = $("#apellidos").val();
    var cbm_genero = $("#cbm_genero").val();
    var cbm_estado_civil = $("#cbm_estado_civil").val();
    var cbm_tipo_persona = $("#cbm_tipo_persona").val();

    if (
        nombres.length == 0 ||
        apellidos.length == 0
    ) {
        swal({
            title: "alerta",
            text: "Llene o seleccione los campos vacios correctamente",
            type: "warning",
            showConfirmButton: true,
            timer: 15000,
        });
    } else if (cbm_genero == 0 || cbm_estado_civil == 0 || cbm_tipo_persona == 0) {
        swal(
            "Alerta!",
            "Seleccione una opción válida",
            "warning"
        );
    } else {

        $.ajax({
            url: "../Controlador/modificar_plan_estudio_controlador.php",
            type: "POST",
            data: {
                nombres: nombres,
                apelidos: txt_codigo_plan,
                genero: cbm_genero,
                estado_civil: cbm_estado_civil,
                tipo_persona: cbm_tipo_persona
            },
        }).done(function(resp) {
            if (resp > 0) {
                swal(
                    "Buen trabajo!",
                    "datos actualizados correctamente!",
                    "success"
                );
                $("#modal_editar").modal("hide");
                table.ajax.reload();
            } else {
                swal("Alerta!", "No se pudo completar la actualización", "warning");
            }
        });

    }

    /* } */
});



$("#cambiar").click(function() {
    var estado = $("#estado1").val();

    var activo = "ACTIVO";
    var inactivo = "INACTIVO";


    var id = $("#id_persona").val();

    swal({
        title: "Estas seguro?",
        text: "Se cambiará el estado de la persona!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {

            if (estado == "ACTIVO") {
                cambiar(id, inactivo);
            } else {
                cambiar(id, activo);
            }



        }

    });



});


function cambiar(id, estado) {

    var nom = $("#nombres").val();
    $.ajax({
        url: "../Controlador/actualizar_estado_persona.php",
        type: "POST",
        data: {
            id_persona: id,
            Estado: estado,
            nombres: nom
        },
    }).done(function(resp) {

        if (resp > 0) {
            $("#modal_editar").modal("hide");
            //  document.getElementById("txt_registro").value = "";
            table.ajax.reload();
        } else {
            swal("Alerta!", "No se pudo completar la actualización", "warning");
            //document.getElementById("txt_registro").value = "";
        }
    });

}

function traerTel() {
    var id_persona = $("#id_persona").val();
    $.post(
        "../Controlador/gestion_personas_controlador.php?op=CargarDatos", { id_persona: id_persona },
        function(data, status) {
            //////console.log(data);
            data = JSON.parse(data);
            ////console.log(data);
            for (var i = 0; i < data.all.length; ++i) {
                // j = ContarTel();

                let n = 1 + i;

                $("#tbData2").append(
                    '<tr id="row' +
                    n +
                    '">' +
                    '<td id="celda' +
                    n +
                    '"><input maxlength="9"    onkeyup="javascript:mascara()" id="tel1' +
                    n +
                    '"  type="tel1" name="tel1" class="form-control name_list" value="' +
                    data["all"][i].valor +
                    '" placeholder="___-___"/></td>' +
                    '<td><button type="button" name="remove" id="' +
                    n +
                    '" class="btn btn-danger btn_remove">X</button></td>' +
                    "</tr>"
                );
            }
        }
    )
}

function traerCorreo() {
    var id_persona = $("#id_persona").val();
    $.post(
        "../Controlador/gestion_personas_controlador.php?op=CargarDatosC", { id_persona: id_persona },
        function(data, status) {
            //////console.log(data);
            data = JSON.parse(data);
            ////console.log(data);
            for (var i = 0; i < data.all.length; ++i) {
                // j = ContarTel();

                let m = 1 + i;

                $("#tbDataCorreo1").append(
                    '<tr id="row2' +
                    m +
                    '">' +
                    '<td id="celda2' +
                    m +
                    '"><input maxlength="9"  id="correo' +
                    m +
                    '"  type="correo" name="correo" class="form-control name_list" value="' +
                    data["all"][i].valor +
                    '"/></td>' +
                    '<td><button type="button" name="eliminar_correo" id="' +
                    m +
                    '" class="btn btn-danger btn_eliminar_correo">X</button></td>' +
                    "</tr>"
                );
            }
        }
    );
}

function limpiar() {
    $("#tbDataCorreo1").empty();
    $("#tbData2").empty();
}