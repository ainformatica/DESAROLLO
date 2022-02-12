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
    $("#cbm_genero").val(data.sexo).trigger("change");
    $("#identidad").val(data.identidad);
    $("#cbm_nacionalidad").val(data.nacionalidad).trigger("change");
    $("#cbm_estado_civil").val(data.estado_civil).trigger("change");
    $("#nacimiento").val(data.fecha_nacimiento);
    $("#cbm_estado").val(data.estado).trigger("change");
    $("#cbm_tipo_persona").val(data.tipo_persona).trigger("change");

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