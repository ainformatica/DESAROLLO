function abrirmodalusuario() {
    $("#modalReset").modal({ backdrop: "static", keyboard: false });
    $("#modalReset").modal("show");
}

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
    var data = table.row($(this).parents("tr")).data();
    if (table.row(this).child.isShown()) {
        var data = table.row(this).data();
    }

    $("#modal_editar").modal({ backdrop: "static", keyboard: false });
    $("#modal_editar").modal("show");

    $("#id_persona").val(data.id_persona);
    $("#nombres").val(data.nombres);
    $("#apellidos").val(data.apellidos);
    $("#cbm_genero").val(data.id_genero).trigger("change");
    $("#identidad").val(data.identidad);
    $("#nacionalidad").val(data.nacionalidad);
    $("#cbm_estado_civil").val(data.id_estado_civil).trigger("change");
    $("#fecha").val(data.fecha_nacimiento);
    $("#estado").val(data.estado);
    $("#cbm_tipo_persona").val(data.id_tipo_persona).trigger("change");

});


function genero() {
    var cadena = "&activar=activar";
    $.ajax({
        url: "../Controlador/gestion_personas_controlador.php?op=genero",
        type: "POST",
        data: cadena,
        success: function(r) {
            $("#cbm_genero").html(r).fadeIn();
            var o = new Option("SELECCIONE", 0);

            $("#cbm_genero").append(o);
            $("#cbm_genero").val(0);
        },
    });
}
genero();

function estado_civil() {
    var cadena = "&activar=activar";
    $.ajax({
        url: "../Controlador/perfil_docente_controlador.php?op=estado_civil",
        type: "POST",
        data: cadena,
        success: function(r) {
            $("#cbm_estado_civil").html(r).fadeIn();
            var o = new Option("SELECCIONE", 0);

            $("#cbm_estado_civil").append(o);
            $("#cbm_estado_civil").val(0);
        },
    });
}
estado_civil();

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


function cambiar() {

    var estado = $("#estado").val();

    if (estado = "ACTIVO") {


        alert('activo');
        // $("#estado").val('INACTIVO');

    } else {
        alert("no");

        // $("#estado").val('ACTIVO');
    }

}